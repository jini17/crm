<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

vimport('~~/modules/WSAPP/synclib/connectors/TargetConnector.php');
vimport('~~/libraries/office-api-php-client/src/Google/Client.php');
vimport('~~/libraries/office-api-php-client/src/Google/Service/Calendar.php');



Class Office365_Calendar_Connector extends WSAPP_TargetConnector {
    
    const maxBatchRequestCount = 50;

    protected $apiConnection;
    protected $totalRecords;
    protected $maxResults = 100;
    protected $createdRecords;

    protected $client;
    protected $service;



    protected $eventCalendarFieldMappingTableName = 'vtiger_office365_event_calendar_mapping';
  
    protected $calendars;

    public function __construct($oauth2Connection) {

        $this->apiConnection = $oauth2Connection;
        $this->client = new Google_Client();
        $this->client->setToken($this->apiConnection->token);
        $this->client->setClientId($oauth2Connection->getClientId());
        $this->client->setClientSecret($oauth2Connection->getClientSecret());
        $this->client->setRedirectUri($oauth2Connection->getRedirectUri());
        $this->client->setScopes($oauth2Connection->getScope());

        try {

        } catch(Exception $e) {
            echo "Error : " . $e;
        }
        $this->service = new Google_Service_Calendar($this->client);
    }
    
    public function getName() {
        return 'Office365Calendar';
    }

    public function emailLookUp($emailIds) {
        $db = PearDatabase::getInstance();
        $sql = 'SELECT crmid FROM vtiger_emailslookup WHERE setype = "Contacts" AND value IN (' .  generateQuestionMarks($emailIds) . ')';
        $result = $db->pquery($sql,$emailIds);
        $crmIds = array();
        for($i=0;$i<$db->num_rows($result);$i++) {
            $crmIds[] = $db->query_result($result,$i,'crmid');
        }
        return $crmIds;
     
    }

    /**
     * Tarsform Google Records to Vtiger Records
     * @param <array> $targetRecords 
     * @return <array> tranformed Google Records
     */
    public function transformToSourceRecord($targetRecords, $user = false) {
        $entity = array();
        $calendarArray = array();

        foreach ($targetRecords as $office365Record) {
            if ($office365Record->getMode() != WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
                if(!$user)
                    $user = Users_Record_Model::getCurrentUserModel();
                $entity = Vtiger_Functions::getMandatoryReferenceFields('Events');
                $entity['assigned_user_id'] = vtws_getWebserviceEntityId('Users', $user->id);
                $entity['subject'] = $office365Record->getSubject();
                $entity['date_start'] = $office365Record->getStartDate($user);
                $entity['location'] = $office365Record->getWhere();
                $entity['time_start'] = $office365Record->getStartTimeUTC($user);
                $entity['due_date'] = $office365Record->getEndDate($user);
                $entity['time_end'] = $office365Record->getEndTimeUTC($user);
                $entity['eventstatus'] = "Planned";
                $entity['activitytype'] = "Meeting";
                $entity['description'] = $office365Record->getDescription();
                $entity['duration_hours'] = '00:00';
                $entity['visibility'] = $office365Record->getVisibility($user);
                if (empty($entity['subject'])) {
                    $entity['subject'] = 'Google Event';
                }
                $attendees = $office365Record->getAttendees();
                $entity['contactidlist'] = '';
                if(count($attendees)) {
                    $contactIds = $this->emailLookUp($attendees);
                    if(count($contactIds)) {
                        $entity['contactidlist'] = implode(';', $contactIds);
                    }
                }
            }

            $calendar = $this->getSynchronizeController()->getSourceRecordModel($entity);

            $calendar = $this->performBasicTransformations($office365Record, $calendar);
            $calendar = $this->performBasicTransformationsToSourceRecords("Office365Calendar",$calendar, $office365Record,null);
            $calendarArray[] = $calendar;

        }

        return $calendarArray;
    }

    /**
     * Pull the events from google
     * @param <object> $SyncState
     * @return <array> google Records
     */
    public function pull($SyncState, $user = false) {
        try {
            return $this->getCalendar($SyncState, $user);
        } catch (Exception $e) {
            return array();
        }
    }
    
    /**
     * Function to convert datetime to RFC 3339 timestamp
     * @param <String> $date
     * @return <DateTime>
     */
    function googleFormat($date) {
        $datTime = new DateTime($date);
        $timeZone = new DateTimeZone('UTC');
        $datTime->setTimezone($timeZone);
        $googleFormat = $datTime->format('Y-m-d\TH:i:s');
        return $googleFormat;
    }

    /**
     * Pull the events from google
     * @param <object> $SyncState
     * @return <array> google Records
     */
    public function getCalendar($SyncState, $user = false) {
        if($this->apiConnection->isTokenExpired()) {
            $this->apiConnection->refreshToken();
            $this->client->setAccessToken($this->apiConnection->getAccessToken());
            $this->service = new Google_Service_Calendar($this->client);

        }

        $query = array(
            'maxResults' => $this->maxResults,
            'orderBy' => 'updated',
            'singleEvents' => true,
        );

        if (Office365_Utils_Helper::getSyncTime('Calendar', $user)) {
            $query['updatedMin'] = $this->googleFormat(Office365_Utils_Helper::getSyncTime('Calendar', $user));
            //shows deleted by default
        }

        $calendarId = Office365_Utils_Helper::getSelectedCalendarForUser($user);
        if(!isset($this->calendars)) {
            $this->calendars = $this->pullCalendars(true);
        }

        if(!in_array($calendarId, $this->calendars)) {
            $calendarId = 'primary';
        }

        try {
            $feed =$this->service->events->listEvents($calendarId,$query);
        } catch (Exception $e) {
            if($e->getCode() == 410) {
                $query['showDeleted'] = false;
                $feed =$this->service->events->listEvents($calendarId,$query);
            }
        }

        $calendarRecords = array();



        if($feed) {
            $count=0;
            foreach ($feed as $value){
                foreach ($value['value'] as $item){
                        $calendarRecords[$count++]=$item;
                }


            }
             $this->totalRecords = count($calendarRecords);
        }

            $lastentry=$calendarRecords[($this->totalRecords) -1];

        if (count($calendarRecords) > 0) {
            $maxModifiedTime = date('Y-m-d H:i:s', strtotime(Office365_Contacts_Model::vtigerFormat($lastentry['LastModifiedDateTime'])) + 1);
        }

        $googleRecords = array();
        $googleEventIds = array();
        foreach ($calendarRecords as $i => $calendar) {
            $recordModel = Office365_Calendar_Model::getInstanceFromValues(array('entity' => $calendar));

            $deleted = false;
            if ($calendar['IsCancelled']== '1') {
                $deleted = true;
            }
            if (!$deleted) {
                $recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode(WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE);
            } else {
                $recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode(WSAPP_SyncRecordModel::WSAPP_DELETE_MODE);
            }

            $googleRecords[$calendar['Id']] = $recordModel;
            $googleEventIds[] = $calendar['Id'];
        }

        $this->createdRecords = count($googleRecords);

        if (isset($maxModifiedTime)) {
            Office365_Utils_Helper::updateSyncTime('Calendar', $maxModifiedTime, $user);
        } else {
            Office365_Utils_Helper::updateSyncTime('Calendar', false, $user);
        }
        if(count($googleEventIds)) {
            $this->putGoogleEventCalendarMap($googleEventIds, $calendarId, $user);
        }
        return $googleRecords;
    }

    protected function putGoogleEventCalendarMap($event_ids, $calendar_id, $user) {
        if(is_array($event_ids) && count($event_ids)) {
            $db = PearDatabase::getInstance();
            $user_id = $user->getId();
            $sql = 'INSERT INTO vtiger_office365_event_calendar_mapping (event_id, calendar_id, user_id) VALUES ';
            $sqlParams = array();
            foreach($event_ids as $event_id) {
                $sql .= '(?, ?, ?),';
                $sqlParams[] = $event_id;
                $sqlParams[] = $calendar_id;
                $sqlParams[] = $user_id;
            }
            $sql = substr_replace($sql, "", -1);
            $db->pquery('DELETE FROM vtiger_office365_event_calendar_mapping WHERE event_id IN ('.generateQuestionMarks($event_ids).')',$event_ids);
            $db->pquery($sql,$sqlParams);
        }
    }

    protected function getGoogleEventCalendarMap($user) {
        $db = PearDatabase::getInstance();
        $map = array();
        $sql = 'SELECT event_id, calendar_id FROM vtiger_office365_event_calendar_mapping WHERE user_id = ?';
        $res = $db->pquery($sql, array($user->getId()));
        $num_of_rows = $db->num_rows($res);
        for($i=0;$i<$num_of_rows;$i++) {
            $event_id = $db->query_result($res, $i, 'event_id');
            $calendar_id = $db->query_result($res, $i, 'calendar_id');
            $map[$event_id] = $calendar_id;
        }
        return $map;
    }

    /**
     * Push the vtiger records to google
     * @param <array> $records vtiger records to be pushed to google
     * @return <array> pushed records
     */
    public function push($records,$user) {
        //TODO : use batch requests
        $calendarId = Office365_Utils_Helper::getSelectedCalendarForUser($user);

        if(!isset($this->calendars)) {
            try {
                $this->calendars = $this->pullCalendars(true);
            } catch (Exception $e) {
                return $records;
            }
        }

        if(!in_array($calendarId, $this->calendars)) {
            $calendarId = 'primary';
        }

        $eventCalendarMap = $this->getGoogleEventCalendarMap($user);


        $newEventIds = array();
        $count=0;
        foreach ($records as $record) {
            $entity = $record->get('entity');
            $eventCalendarId = 'primary';
            if($this->apiConnection->isTokenExpired()) {
                $this->apiConnection->refreshToken();
                $this->client->setAccessToken($this->apiConnection->getAccessToken());
                $this->service = new Google_Service_Calendar($this->client);

            }
            try {
                if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {

                    if(array_key_exists($entity[0]['Id'], $eventCalendarMap)) {
                        $eventCalendarId = $eventCalendarMap[$entity[0]['Id']];
                    }

                    $newEntity = $this->service->events->update($eventCalendarId,$entity[0]['Id'],$entity);
                    $record->set('entity', $newEntity);
                } else if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
                    $record->set('entity', $entity);
                    if(array_key_exists($entity->getId(), $eventCalendarMap)) {
                        $eventCalendarId = $eventCalendarMap[$entity->getId()];
                    }
                    $newEntity = $this->service->events->delete($eventCalendarId,$entity->getId());
                } else {
                    $newEntity = $this->service->events->insert($calendarId,$entity);
                    $newEventIds[] = $newEntity[0]['Id'];
                     $record->setId($newEntity[0]['Id']);
                    $record->set('entity', $newEntity);

                }
                
            } catch (Exception $e) {
                continue;
            }
        }

        if(count($newEventIds) > 0) {
            $this->putGoogleEventCalendarMap($newEventIds, $calendarId, $user);
        }
        return $records;
    }

    /**
     * Tarsform  Vtiger Records to Google Records
     * @param <array> $vtEvents 
     * @return <array> tranformed vtiger Records
     */
    public function transformToTargetRecord($vtEvents, $user) {;
        $records = array();
        foreach ($vtEvents as $vtEvent) {
            $newEvent = new Google_Service_Calendar_Event();

            if ($vtEvent->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
                $newEvent->setId($vtEvent->get('_id'));
            } elseif($vtEvent->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE && $vtEvent->get('_id')) {
                if ($this->apiConnection->isTokenExpired()) {
                    $this->apiConnection->refreshToken();
                    try {
                        $this->client->setAccessToken($this->apiConnection->getAccessToken());
                    } catch (Exception $e) {
                    }//suppressing invalid access-token exception if access revoked
                    $this->service = new Google_Service_Calendar($this->client);
                }
                try {
                    $calendarId = 'primary';
                    $eventCalendarMap = $this->getGoogleEventCalendarMap($user);
                    if (array_key_exists($vtEvent->get('_id'), $eventCalendarMap)) {
                        $calendarId = $eventCalendarMap[$vtEvent->get('_id')];
                    }
                    $newEvent = $this->service->events->get($calendarId, $vtEvent->get('_id'));
                } catch (Exception $e) {
                    continue;
                }


                $newEvent[0]['Subject'] = $vtEvent->get('subject');
                $newEvent[0]['Location']['DisplayName'] = $vtEvent->get('location');
                $newEvent[0]['Body']['Content'] = $vtEvent->get('description');
                strtolower($vtEvent->get('visibility')) == 'public' ? $sensitivity = 'Normal' : $sensitivity = 'Private';
                $newEvent[0]['Sensitivity'] = $sensitivity;


                $startDate = $vtEvent->get('date_start');
                $startTime = $vtEvent->get('time_start');
                $endDate = $vtEvent->get('due_date');
                $endTime = $vtEvent->get('time_end');
                if (empty($endTime)) {
                    $endTime = "00:00";
                }
                $userModel = Users_Record_Model::getCurrentUserModel();
                $start = new Google_Service_Calendar_EventDateTime();

                $start->setDateTime($this->googleFormat($startDate . ' ' . $startTime));
                $start->setTimeZone($userModel->get('time_zone'));
                $start = (object)array('DateTime' => $start->getDateTime(), 'TimeZone' => $start->getTimeZone());
                $newEvent[0]["Start"] = $start;


                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime($this->googleFormat($endDate . ' ' . $endTime));
                $end->setTimeZone($userModel->get('time_zone'));
                $end = (object)array('DateTime' => $end->getDateTime(), 'TimeZone' => $end->getTimeZone());
                $newEvent[0]["End"] = $end;
            }else{

                $newEvent->setSummary($vtEvent->get('subject'));
                $newEvent->setLocation($vtEvent->get('location'));
                $newEvent->setDescription($vtEvent->get('description'));
                $newEvent->setVisibility(strtolower($vtEvent->get('visibility')));

                $startDate = $vtEvent->get('date_start');
                $startTime = $vtEvent->get('time_start');
                $endDate = $vtEvent->get('due_date');
                $endTime = $vtEvent->get('time_end');
                if (empty($endTime)) {
                    $endTime = "00:00";
                }
                $start = new Google_Service_Calendar_EventDateTime();
                $start->setDateTime($this->googleFormat($startDate . ' ' . $startTime));
                $newEvent->setStart($start);

                $end = new Google_Service_Calendar_EventDateTime();
                $end->setDateTime($this->googleFormat($endDate. ' ' .$endTime));
                $newEvent->setEnd($end);
            }


			/**
			 * Commenting out adding attendees in google
            //attendees
            $googleAttendees = array();
            $newEvent->setAttendees($googleAttendees);
            $attendees = $vtEvent->get('attendees');
            if(isset($attendees)) {
                foreach($attendees as $attendee) {
                    if(!empty($attendee['email'])) {
                        $eventAttendee = new Google_Service_Calendar_EventAttendee();
                        $eventAttendee->setEmail($attendee['email']);
                        $googleAttendees[] = $eventAttendee;
                    }
                }
                if(count($googleAttendees)) $newEvent->setAttendees($googleAttendees);
            }
			*/

            $recordModel = Office365_Calendar_Model::getInstanceFromValues(array('entity' => $newEvent));
            $recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode($vtEvent->getMode())->setSyncIdentificationKey($vtEvent->get('_syncidentificationkey'));
            $recordModel = $this->performBasicTransformations($vtEvent, $recordModel);
            $recordModel = $this->performBasicTransformationsToTargetRecords($recordModel, $vtEvent);
            $records[] = $recordModel;
        }
        return $records;
    }

    /**
     * returns if more records exits or not
     * @return <boolean> true or false
     */
    public function moreRecordsExits() {
        return ($this->totalRecords - $this->createdRecords > 0) ? true : false;
    }


    public function pullCalendars($list=false) {
        //getting calendar here not events
        $calendarList = $this->service->calendarList->listCalendarList();
        $calendars = array();
        $allCalendarsItems=array();
            $calendarItems = $calendarList;
            if(is_array($calendarItems))
                $allCalendarsItems = array_merge($allCalendarsItems, $calendarItems);
        if($list) {

             foreach($allCalendarsItems as $calendarItem) {
                     if (!empty($calendarItem['Id'])){
                          $calendars[] = $calendarItem['Id'];
                     }
                     else {
                         $calendars[] = 'primary';
                     }
             }
            return $calendars;
        }

         foreach($allCalendarsItems as $calendarItem) {
             $calendars[] = array(
                 'id' => $calendarItem['Id'],
                 'Owner' =>$calendarItem["Owner"]["Name"],

             );
        }


        return $calendars;
    }

}
?>


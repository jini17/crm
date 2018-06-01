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
require_once 'vtlib/Vtiger/Net/Client.php';

Class Office365_Contacts_Connector extends WSAPP_TargetConnector {
	

	protected $apiConnection;
	protected $totalRecords;
	protected $createdRecords;
	protected $maxResults = 100;

	const CONTACTS_URI = 'https://outlook.office.com/api/v2.0/me/contacts';
	const CONTACTS_URI_COUNT = 'https://outlook.office.com/api/v2.0/me/contacts/$count';
	const CONTACTS_URI_DELETE='https://outlook.office.com/api/v2.0/me/contacts/';


	const USER_PROFILE_INFO = 'https://outlook.office.com/api/v2.0/me';

	/*protected $NS = array(
		'gd' => 'http://schemas.google.com/g/2005',
		'gContact' => 'http://schemas.google.com/contact/2008',
		'batch' => 'http://schemas.google.com/gdata/batch'
	);*/

	protected $apiVersion = '2.0';

	private $groups = null;

	private $selectedGroup = null;

	private $fieldMapping = null;

	private $maxBatchSize = 100;

	protected $fields = array(
		'salutationtype' => array(
				'name' => 'DisplayName'
			),
		'firstname' => array(
				'name' => 'GivenName'
			),
		'lastname' => array(
				'name' => 'Surname'
			),
		'title' => array(
				'name' => 'Title'
			),
		'organizationname' => array(
				'name' => 'CompanyName'
			),
		'birthday' => array(
				'name' => 'Birthday'
			),  
		'email' => array(
			'name' => 'ImAddresses'
			),
		'phone' => array(
			'name' => 'MobilePhone1'
			),
		'address' => array(
			'name' => 'OfficeLocation'
		),			
		'url' => array(
			'name' => 'BusinessHomePage'
		)
	);

	public function __construct($oauth2Connection) {
		$this->apiConnection = $oauth2Connection;
	}

	/**
	 * Get the name of the Office365 Connector
	 * @return string
	 */
	public function getName() {
		return 'Office365Contacts';
	}

	/**
	 * Function to get Fields
	 * @return <Array>
	 */
	public function getFields() {
		return $this->fields;
	}

	/**
	 * Function to get the mapped value
	 * @param <Array> $valueSet
	 * @param <Array> $mapping
	 * @return <Mixed>
	 */
	public function getMappedValue($valueSet,$mapping) {
		$key = $mapping['office365_field_type'];
		if($key == 'custom')
			$key = $mapping['office365_custom_label'];
		return $valueSet[decode_html($key)];
	}

	/**
	 * Function to get field value of google field
	 * @param <Array> $googleFieldDetails
	 * @param <Office365_Contacts_Model> $user
	 * @return <Mixed>
	 */
	public function getOffice365FieldValue($googleFieldDetails, $googleRecord, $user) {

		$googleFieldValue = '';

            switch ($googleFieldDetails['office365_field_name']) {
                case 'DisplayName' :
                    $googleFieldValue = $googleRecord->getNamePrefix();
                    break;
                case 'GivenName' :
                    $googleFieldValue = $googleRecord->getFirstName();
                    break;
                case 'Surname' :
                    $googleFieldValue = $googleRecord->getLastName();
                    break;
                case 'JobTitle' :
                    $googleFieldValue = $googleRecord->getTitle();
                    break;
                case 'CompanyName' :
                    $googleFieldValue = $googleRecord->getAccountName($user->id);
                    break;
                case 'Birthday' :
                    $googleFieldValue = $googleRecord->getBirthday();
                    break;
                case 'ImAddresses' :
                    $googleFieldValue = $googleRecord->getEmails();
                    break;
                case 'MobilePhone1' :
                    $googleFieldValue = $googleRecord->getPhones();
                    break;
                case 'OfficeLocation' :
                    $addresses = $googleRecord->getAddresses();
                    $googleFieldValue = $this->getMappedValue($addresses, $googleFieldDetails);
                    break;
                case 'BusinessHomePage' :
                    $googleFieldValue = $googleRecord->getUrlFields();
                    break;
            }

		return $googleFieldValue;
	}

	/**
	 * Tarsform Office365 Records to Vtiger Records
	 * @param <array> $targetRecords 
	 * @return <array> tranformed Office365 Records
	 */
	public function transformToSourceRecord($targetRecords, $user = false) {
	
		$entity = array();
		$contacts = array();


		if(!isset($this->fieldMapping)) {			
			$this->fieldMapping = Office365_Utils_Helper::getFieldMappingForUser($user);
		}
	
		
	
		foreach ($targetRecords as $googleRecord) {
				
			if ($googleRecord->getMode() != WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) { 
				if(!$user) $user = Users_Record_Model::getCurrentUserModel();
			
				$entity = Vtiger_Functions::getMandatoryReferenceFields('Contacts');				
				$entity['assigned_user_id'] = vtws_getWebserviceEntityId('Users', $user->id);

				foreach($this->fieldMapping as $vtFieldName => $googleFieldDetails) {
					
					$googleFieldValue = $this->getOffice365FieldValue($googleFieldDetails, $googleRecord, $user);
					$entity[$vtFieldName] = $googleFieldValue;
					
					
				
				}
				
				if (empty($entity['lastname'])) {
					if (!empty($entity['salutationtype'])) {
						$entity['lastname'] = $entity['firstname'];
					} else if(empty($entity['firstname']) && !empty($entity['email'])) {
						$entity['lastname'] = $entity['email'];
					} else if( !empty($entity['phone']) ) {
						$entity['lastname'] = 'Office365 Contact';
					} else {
						continue;
					}
			   }
			 
			}
			
			$contact = $this->getSynchronizeController()->getSourceRecordModel($entity);
			
			$contact = $this->performBasicTransformations($googleRecord, $contact);
			$contact = $this->performBasicTransformationsToSourceRecords("Office365Contacts",$contact, $googleRecord,$count);
			$contacts[] = $contact;
			$count++;
			
		
		}
		
		return $contacts;
	}

	/**
	 * Pull the contacts from google
	 * @param <object> $SyncState
	 * @return <array> google Records
	 */
	public function pull($SyncState, $user = false) { 
		$record=$this->getContacts($SyncState, $user);		
		return $record;
		
	}

	/**
	 * Helper to send http request using NetClient
	 * @param <String> $url
	 * @param <Array> $headers
	 * @param <Array> $params
	 * @param <String> $method
	 * @return <Mixed>
	 */
	protected function fireRequest($url,$headers,$params=array(),$method='GET') {

		switch ($method) {
			case 'POST':
                $httpClient = new Vtiger_Net_Client($url);
                if(count($headers)) $httpClient->setHeaders($headers);
				$response = $httpClient->doPost($params);
				break;
			case 'GET':
                $httpClient = new Vtiger_Net_Client($url);
                if(count($headers)) $httpClient->setHeaders($headers);
				$response = $httpClient->doGet($params);
				break;
            case "PATCH":
                $ch = curl_init($url);
                $headers = array(
                    "Authorization: Bearer ".$this->apiConnection->token['access_token']['access_token'],
                    'Content-Type: '.'application/json'
                );
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $response=curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if($http_code >= 400) {
                    echo "Error executing request to Office365 api with error code=$http_code<br/><br/>\n\n";
                    echo "<pre>"; print_r($response);echo "methods :" .print_r($method); echo "</pre>";die;

                }
                break;
		}
		return $response;
	}

	function fetchContactsFeed($query) {
		$query['alt'] = 'json';
		if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
		$headers = array(
			'Authorization' => $this->apiConnection->token['access_token']['token_type'] . ' ' . 
							   $this->apiConnection->token['access_token']['access_token'],
			"Content-Type :" => "application/json"
		);
		$response = $this->fireRequest(self::CONTACTS_URI, $headers, $query, 'GET');
		return $response;
	}

	function getContactListFeed($query) {
		$feed = $this->fetchContactsFeed($query);
		$decoded_feed = json_decode($feed,true);	
		return $decoded_feed['value'];
	}


	function googleFormat($date) {
		return str_replace(' ', 'T', $date);
	}

	/**
	 * Pull the contacts from google
	 * @param <object> $SyncState
	 * @return <array> google Records
	 */
	public function getContacts($SyncState, $user = false) { 
		if(!$user) $user = Users_Record_Model::getCurrentUserModel();
		$query = array(
			'max-results' => $this->maxResults,
			'start-index' => 1,
			'orderby' => 'lastmodified',
			'sortorder' => 'ascending',
		);
		if(!isset($this->selectedGroup))
			$this->selectedGroup = Office365_Utils_Helper::getSelectedContactGroupForUser($user);
		
		if($this->selectedGroup != '' && $this->selectedGroup != 'all') {
			if($this->selectedGroup == 'none') return array();
			if(!isset($this->groups)) {
				$this->groups = $this->pullGroups(TRUE);
			}
			if(in_array($this->selectedGroup, $this->groups['title']))
				$query['group'] = $this->selectedGroup;
			else
				return array();
		}
		
		if (Office365_Utils_Helper::getSyncTime('Contacts', $user)) {
			$query['updated-min'] = $this->googleFormat(Office365_Utils_Helper::getSyncTime('Contacts', $user));
			$query['showdeleted'] = 'true';
		}
		
		$feed = $this->getContactListFeed($query);
		$count=count($feed);
	
		$this->totalRecords = $count;	
		$contactRecords = array();
		if ($count > 0) {
			$lastEntry = $feed[$count-1]; 


			$maxModifiedTime = date('Y-m-d H:i:s', strtotime(Office365_Contacts_Model::vtigerFormat($lastEntry['LastModifiedDateTime'])) + 1);
			if ($this->totalRecords > $this->maxResults) {
				if (!Office365_Utils_Helper::getSyncTime('Contacts', $user)) {
					$query['updated-min'] = $this->googleFormat(date('Y-m-d H:i:s', strtotime(Office365_Contacts_Model::vtigerFormat($lastEntry['LastModifiedDateTime']))));
					$query['start-index'] = $this->maxResults;
				}
				if($this->selectedGroup != '' && $this->selectedGroup != 'all') {
					$query['group'] = $this->selectedGroup;
				}
				$query['max-results'] = (5000);
				$query['updated-max'] = $this->googleFormat($maxModifiedTime);
				$extendedFeed = $this->getContactListFeed($query);
				if(is_array($extendedFeed)) {;
					$contactRecords = array_merge($feed, $extendedFeed);
				} else {
					$contactRecords = $feed;
				}
			} else {
				$contactRecords = $feed;
			}
		};
	
		$googleRecords = array();

		foreach ($contactRecords as $i => $contact) {
				
			$recordModel = Office365_Contacts_Model::getInstanceFromValues(array('entity' => $contact));
            $deleted = false;
			if(array_key_exists('gd$deleted', $contact)) {
				$deleted = true;
			}
			if (!$deleted) {
				$recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode(WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE);
			} else {
				$recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode(WSAPP_SyncRecordModel::WSAPP_DELETE_MODE);
			}
			$googleRecords[$contact['Id']] = $recordModel;
		}
		$this->createdRecords = count($googleRecords);
		if (isset($maxModifiedTime)) {
			Office365_Utils_Helper::updateSyncTime('Contacts', $maxModifiedTime, $user);
		} else {
			Office365_Utils_Helper::updateSyncTime('Contacts', false, $user);
		}
		return $googleRecords;
	}

	/**
	 * Function to send a batch request
	 * @param <String> <Xml> $batchFeed
	 * @return <Mixed>
	 */
	protected function sendBatchRequest($batchFeed) {
		if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
		$headers = array(	
			'Authorization' => $this->apiConnection->token['access_token']['token_type'] . ' ' . 
							   $this->apiConnection->token['access_token']['access_token'],
			'Content-Type' => 'application/json',
		);
		$response = $this->fireRequest(self::CONTACTS_URI, $headers, $batchFeed);
		return $response['value'];
	}

	public function mbEncode($str) {
		global $default_charset;
		$convmap = array(0x080, 0xFFFF, 0, 0xFFFF);
		return mb_encode_numericentity(htmlspecialchars($str), $convmap, $default_charset);
	}

	/**
	 * Function to add detail to entry element
	 * @param <SimpleXMLElement> $entry
	 * @param <Office365_Contacts_Model> $entity
	 * @param <Users_Record_Model> $user
	 */
	protected function  addEntityDetailsToAtomEntry($entity,$user,$method,$url) {
	    $query=array();
        if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
        $headers = array(

            'Authorization ' => $this->apiConnection->token['access_token']['token_type'] . ' ' .
                $this->apiConnection->token['access_token']['access_token'],
            "Content-Type" => "application/json"
        );
		if($entity->get('salutationtype')) $query["Title"]=$entity->get('salutationtype');
		if($entity->get('firstname')) $query["GivenName"]=$entity->get('firstname');
		if($entity->get('lastname')) $query["Surname"]=$entity->get('lastname');
        if($entity->get('lastname') && $entity->get('firstname')) $query["DisplayName"]=$entity->get('firstname')." ". $entity->get('lastname');

		if(!isset($this->fieldMapping)) {
			$this->fieldMapping = Office365_Utils_Helper::getFieldMappingForUser($user);
		}

		foreach($this->fieldMapping as $vtFieldName => $googleFieldDetails) {

			switch ($googleFieldDetails['office365_field_name']) {
				case 'ImAddresses' :
                    if($entity->get('email'))
				    $query['EmailAddresses']=array(array("Name"=> $entity->get('firstname'), 'Address' =>$entity->get('email')));
					break;
				case 'Birthday' :
                    if($entity->get('birthday'))
				    $query['Birthday']=$entity->get('birthday');
					break;
				case 'MobilePhone1' :
                    if($entity->get('phone'))
					$query['MobilePhone1']=$entity->get('phone');
					break;
				case 'BusinessHomePage' :
				    if($entity->get('portal'))
                    $query['BusinessHomePage']=$entity->get('portal');
					break;
                case "JobTitle":
                    if($entity->get('title'))
                    $query['JobTitle']=$entity->get('title');

			}
		}


        $response = $this->fireRequest($url, $headers, json_encode($query), $method);
        return $response;
	}

	/**
	 * Function to add update entry to the atomfeed
	 * @param <SimpleXMLElement> $feed
	 * @param <Office365_Contacts_Model> $entity
	 * @param <Users_Record_Model> $user
	 */
	protected function addUpdateContactEntry($entity,$user) {
	    $url=self::CONTACTS_URI_DELETE.$entity->get('_id');

        $response=$this->addEntityDetailsToAtomEntry($entity, $user,"PATCH",$url);
        return json_decode($response,true);

	}

	/**
	 * Function to add delete contact entry to atom feed
	 * @param <SimpleXMLElement> $feed
	 * @param <Office365_Contacts_Model> $entity
	 */
	protected function addDeleteContactEntry($entity)
    {
        $url = self::CONTACTS_URI_DELETE . $entity->get('_id');


        $ch = curl_init($url);
        $headers = array(
            "Authorization: Bearer ".$this->apiConnection->token['access_token']['access_token'],

        );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response=curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($http_code >= 400) {
            echo "Error executing request to Office365 api with error code=$http_code<br/><br/>\n\n";
            echo "<pre>"; print_r($response); echo "</pre>";

        }

        return $response;
    }

	/**
	 * Function to add create entry to the atomfeed
	 * @param <SimpleXMLElement> $feed
	 * @param <Office365_Contacts_Model> $entity
	 * @param <Users_Record_Model> $user
	 */
	protected function addCreateContactEntry($entity,$user) {


		if(!$user) $user = Users_Record_Model::getCurrentUserModel ();

		if(!isset($this->selectedGroup))
			$this->selectedGroup = Office365_Utils_Helper::getSelectedContactGroupForUser($user);


		$response=$this->addEntityDetailsToAtomEntry($entity, $user,"POST",self::CONTACTS_URI);

		return json_decode($response,true);
	}

	/**
	 * Function to add Retreive entry to atomfeed
	 * @param <SimpleXMLElement> $feed
	 * @param <Office365_Contacts_Model> $entity
	 * @param <Users_Record_Model> $user
	 */
	protected function addRetrieveContactEntry(&$feed, $entity, $user) {
		$entryId = $entity->get('_id');
		$entryId = str_replace('/base/','/full/',$entryId);
		$entry = $feed->addChild("entry");
		$batchNS = $this->NS['batch'];
		$entry->addChild("id","retrieve",$batchNS);
		$batchOperation = $entry->addChild("operation",'',$batchNS);
		$batchOperation->addAttribute("type","query");
		$entry->addChild('id',$entryId);
	}

	/**
	 * Function to get Office365Contacts-ContactsGroup map for the supplied records
	 * @global  $default_charset
	 * @param <Array> $records
	 * @param <Users_Record_Model> $user
	 * @return <Array>
	 */
	/*protected function googleContactsGroupMap($records,$user) {
		global $default_charset;
		$contactsGroupMap = array();

		$atom = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?>
		<feed xmlns='http://www.w3.org/2005/Atom' xmlns:gContact='http://schemas.google.com/contact/2008'
			  xmlns:gd='http://schemas.google.com/g/2005' xmlns:batch='http://schemas.google.com/gdata/batch' />");

		foreach($records as $record) {
			$entity = $record->get('entity');
			$this->addRetrieveContactEntry($atom, $entity, $user);
		}

		$payLoad = html_entity_decode($atom->asXML(), ENT_QUOTES, $default_charset);
		$response = $this->sendBatchRequest($payLoad);
		if($response) {
			$responseXml = simplexml_load_string($response);
			$responseXml->registerXPathNamespace('gd', $this->NS['gd']);
			$responseXml->registerXPathNamespace('gContact', $this->NS['gContact']);
			$responseXml->registerXPathNamespace('batch', $this->NS['batch']);

			foreach($responseXml->entry as $entry) {
				$entryXML = $entry->asXML();
				$p = xml_parser_create();
				xml_parse_into_struct($p, $entryXML, $xmlList, $index);
				xml_parser_free($p);

				if(count($xmlList)) {
					foreach($xmlList as $tagDetails) {

						if($tagDetails['tag'] == 'ID') {
							$googleContactId = $tagDetails['value'];
						}

						if($tagDetails['tag'] == 'GCONTACT:GROUPMEMBERSHIPINFO') {
							$attribs = $tagDetails['attributes'];
							$googleContactGroupId = $attribs['HREF'];
						}

						if(isset($googleContactId) && isset($googleContactGroupId)) {
							$contactsGroupMap[$googleContactId] = $googleContactGroupId;
							unset($googleContactId);unset($googleContactGroupId);
						}

					}
				}
			}
		}
		return $contactsGroupMap;
	}
*/
	/**
	 * Function to push records in a batch
	 * https://developers.google.com/google-apps/contacts/v3/index#batch_operations
	 * @global <String> $default_charset
	 * @param <Array> $records
	 * @param <Users_Record_Model> $user
	 * @return <Array> - pushedRecords
	 */
	protected function pushChunk($records,$user) {
		
		global $default_charset;
	
		foreach ($records as $record) {
			$entity = $record->get('entity');
			try {
				if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {
					$responses[]=$this->addUpdateContactEntry($entity,$user);
				} else if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
					$responses[]=$this->addDeleteContactEntry($entity);
				} else {
					$responses[]=$this->addCreateContactEntry($entity,$user);
				}
			} catch (Exception $e) {
				continue;
			}
		}

		  foreach ($records as $record) {
                  foreach ($responses as $index => $response) {
                      $newEntity = array();
                      $newEntity=$response;
                      $newEntityId = $response['Id'];
                      $record->set('entity', $newEntity);
                      $record->set('id',$newEntityId);
                  }

          }
	
		return $records;
	}

	/**
	 * Function to push records in batch of maxBatchSize
	 * @param <Array Office365_Contacts_Model> $records
	 * @param <Users_Record_Model> $user
	 * @return <Array> - pushed records
	 */
	protected function batchPush($records,$user) {
		$chunks = array_chunk($records, $this->maxBatchSize);
		$mergedRecords = array();
		foreach($chunks as $chunk) {
			$pushedRecords = $this->pushChunk($chunk, $user);
			$mergedRecords = array_merge($mergedRecords,$pushedRecords);
		}
		return $mergedRecords;
	}

	/**
	 * Push the vtiger records to google
	 * @param <array> $records vtiger records to be pushed to google
	 * @return <array> pushed records
	 */
	public function push($records, $user = false) {
		if(!$user) $user = Users_Record_Model::getCurrentUserModel();

		if(!isset($this->selectedGroup))
			$this->selectedGroup = Office365_Utils_Helper::getSelectedContactGroupForUser($user);

		if($this->selectedGroup != '' && $this->selectedGroup != 'all') {
			if($this->selectedGroup == 'none') return array();
			if(!isset($this->groups)) {
				$this->groups = $this->pullGroups(TRUE);
			}
			if(!in_array($this->selectedGroup, $this->groups['title']))
				return array();
		}

		$updateRecords = $deleteRecords = $addRecords = array();
		foreach($records as $record) {
			if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {
				$updateRecords[] = $record;
			} else if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
				$deleteRecords[] = $record;
			} else {
				$addRecords[] = $record;
			}
		}

		if(count($deleteRecords)) {
			$deletedRecords = $this->batchPush($deleteRecords, $user);
		}

		if(count($updateRecords)) {
			$updatedRecords = $this->batchPush($updateRecords, $user);
		}

		if(count($addRecords)) {
			$addedRecords = $this->batchPush($addRecords, $user);

        }

		$i = $j = $k = 0;
		foreach($records as $record) {
			if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {
				$uprecord = $updatedRecords[$i++];
				$newEntity = $uprecord->get('entity');
				$record->set('entity',$newEntity);
			} else if ($record->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
				$delrecord = $deletedRecords[$j++];
				$newEntity = $delrecord->get('entity');
				$record->set('entity',$newEntity);
			} else {
				$adrecord = $addedRecords[$k++];

				$newEntity = $adrecord->get('entity');
				$record->set('entity',$newEntity);
			}
		}
		return $records;
	}

	/**
	 * Tarsform  Vtiger Records to Office365 Records
	 * @param <array> $vtContacts 
	 * @return <array> tranformed vtiger Records
	 */
	public function transformToTargetRecord($vtContacts) {
		$records = array();
		
		foreach ($vtContacts as $vtContact) {
			$recordModel = Office365_Contacts_Model::getInstanceFromValues(array('entity' => $vtContact));
			$recordModel->setType($this->getSynchronizeController()->getSourceType())->setMode($vtContact->getMode())->setSyncIdentificationKey($vtContact->get('_syncidentificationkey'));
			$recordModel = $this->performBasicTransformations($vtContact, $recordModel);
			$recordModel = $this->performBasicTransformationsToTargetRecords($recordModel, $vtContact);
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

	/**
	 * Function to pull contact groups for user
	 * @param <Boolean> $onlyIds
	 * @return <Array>
	 */
	public function pullGroups($onlyIds = FALSE) {
		//max-results: If you want to receive all of the groups, rather than only the default maximum.
		$query = array(
			'alt' => 'json',
			'max-results' => 1000,
		);
		if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
		
		$headers = array(
			'Authorization ' => $this->apiConnection->token['access_token']['token_type'] . ' ' . 
							   $this->apiConnection->token['access_token']['access_token'],
			'Content_Type :' => 'application/json'
		);
		$response = $this->fireRequest(self::CONTACTS_URI, $headers,$query,'GET');			if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
		$decoded_resp = json_decode($response,true);
		$feed=$decoded_resp['value'];
		
		$groups = array(
			'title' => $decoded_resp['@odata.context']
		);
		return $groups;
	}    

	/**
	 * Function to get user profile info
	 * @return <Mixed>
	 */
	public function getUserProfileInfo() {
		if($this->apiConnection->isTokenExpired()) $this->apiConnection->refreshToken();
		$headers = array(
			'GData-Version' => $this->apiVersion,
			'Authorization' => $this->apiConnection->token['access_token']['token_type'] . ' ' . 
							   $this->apiConnection->token['access_token']['access_token'],
			'If-Match' => '*',
			'Content-Type' => 'application/json',
		);
		$response = $this->fireRequest(self::USER_PROFILE_INFO, $headers, array(), 'GET');
		return $response;
	}
}

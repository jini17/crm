<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
require_once 'modules/WSAPP/synclib/models/SyncStateModel.php';
require_once 'modules/WSAPP/synclib/models/VtigerModel.php';
require_once 'modules/WSAPP/synclib/models/TargetModel.php';

require_once 'modules/WSAPP/synclib/connectors/VtigerConnector.php';

require_once 'include/database/PearDatabase.php';

require_once 'modules/WSAPP/api/ws/Register.php';
require_once 'modules/WSAPP/WSAPPLogs.php';

abstract class WSAPP_SynchronizeController {

    const WSAPP_SYNCHRONIZECONTROLLER_USER_SYNCTYPE = 'user';
    const WSAPP_SYNCHRONIZECONTROLLER_APP_SYNCTYPE = 'app';
    const WSAPP_SYNCHRONIZECONTROLLER_USERANDGROUP_SYNCTYPE = 'userandgroup';

    const WSAPP_SYNCHRONIZECONTROLLER_PULL_EVENT = 'pull';
    const WSAPP_SYNCHRONIZECONTROLLER_PUSH_EVENT = 'push';

    public $user;


    abstract function getTargetConnector();
    abstract function getSourceType();

    abstract function getSyncType();

    function __construct($user) {
        $this->user = $user;
        $this->targetConnector = $this->getTargetConnector();

        $this->sourceConnector = $this->getSourceConnector();
        $this->db = PearDatabase::getInstance();
    }

    function getSourceConnector() {
        $connector =  new WSAPP_VtigerConnector();
        $connector->setSynchronizeController($this);
        $targetName = $this->targetConnector->getName();
        if(empty ($targetName)){
            throw new Exception('Target Name cannot be empty');
        }
        return $connector->setName('Vtiger_'.$targetName);
    }

    function getTargetRecordModel($data) {
        return new WSAPP_TargetModel($data);
    }

    function getSourceRecordModel($data) {
        return new WSAPP_VtigerModel($data);
    }

    function getSyncStateModel($connector) {
        return $connector->getSyncState($this->getSourceType())->setType($this->getSourceType());
    }

    function updateSyncStateModel($connector,WSAPP_SyncStateModel $syncStateModel){
        return $connector->updateSyncState($syncStateModel);
    }

    public function synchronizePull($moduleName) {
        global $adb;
        $synchronizedRecords = array();
        $sourceType = $this->getSourceType();

        $this->sourceConnector->preEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PULL_EVENT);
        $this->targetConnector->preEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PUSH_EVENT);

        $syncStateModel = $this->getSyncStateModel($this->sourceConnector);
        $sourceRecords = $this->sourceConnector->pull($syncStateModel, $this->user);
        foreach($sourceRecords as $record){
            $record->setSyncIdentificationKey(uniqid());
        }

       foreach ($sourceRecords as $sourceRecord){
            if($moduleName =='Office365Calendar' || $moduleName=='Office365Contacts') {
                if (($sourceRecord->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE || $sourceRecord->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE)
                    && $sourceRecord->get('_id') == "") {
                    if($sourceRecord->get('_serverid') !="") $sourceid = explode("x", $sourceRecord->get('_serverid'));
                    else $sourceid = explode("x", $sourceRecord->get('id'));
                    $sourceId = $sourceid[1];
                    $res = $adb->pquery("SELECT `officeid` FROM `office365_sync_map` WHERE `vtigerid`=? AND`module`=?", array($sourceId,$moduleName));
                    $synced = $adb->query_result($res, 'officeid');
                    $sourceRecord->set('_id', $synced);

                }
            }
       }

        $transformedRecords = $this->targetConnector->transformToTargetRecord($sourceRecords, $this->user);
        $targetRecords = $this->targetConnector->push($transformedRecords, $this->user);
        $targetSyncStateModel = $this->getSyncStateModel($this->targetConnector);

        foreach($sourceRecords as $sourceRecord){
            $sourceId = $sourceRecord->getId();
            foreach($targetRecords as $targetRecord){
                if($targetRecord->getMode()!=WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
                    if ($moduleName == "Office365Calendar" || $moduleName == "Office365Contacts") {
                        $entity = $targetRecord->get('entity');
                        if ($moduleName == 'Office365Contacts') $officeid = $entity['Id'];
                        else $officeid = $entity[0]['Id'];

                        $vtigerid = explode("x", $sourceRecord->get('id'));
                        $vtigerid = $vtigerid[1];
                        $adb->pquery("INSERT INTO `office365_sync_map` (`vtigerid`, `officeid`, `synced`,`module` ) VALUES (?, ?, ?,?)", array($vtigerid, $officeid, 1, $moduleName));

                    }

                }
                if($targetRecord->getSyncIdentificationKey() == $sourceRecord->getSyncIdentificationKey()){
                    $sychronizeRecord = array();
                    $sychronizeRecord['source'] = $sourceRecord;
                    $sychronizeRecord['target'] = $targetRecord;
                    $synchronizedRecords[] = $sychronizeRecord;
                    break;
                }

            }
        }


        $this->sourceConnector->postEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PULL_EVENT, $synchronizedRecords, $syncStateModel);

        $this->targetConnector->postEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PUSH_EVENT, $synchronizedRecords, $targetSyncStateModel);

        return $synchronizedRecords;
    }

    function synchronizePush($moduleName){

        $synchronizedRecords = array();
        $sourceType = $this->getSourceType();

        $this->sourceConnector->preEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PUSH_EVENT);
        $this->targetConnector->preEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PULL_EVENT);


        $syncStateModel = $this->getSyncStateModel($this->targetConnector);
        $targetRecords = $this->targetConnector->pull($syncStateModel, $this->user);        

        foreach($targetRecords as $record){
            $record->setSyncIdentificationKey(uniqid());
        }
        $sourceSyncStateModel = $this->getSyncStateModel($this->sourceConnector);

        if($moduleName=="Office365Calendar" || $moduleName=='Office365Contacts'){
            global $adb;
            foreach ($targetRecords as $targetRecord){
                if($targetRecord->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE){
                    $event=$targetRecord->get('entity');
                    $eventid=$event['Id'];
                    $res=$adb->pquery("SELECT `vtigerid` FROM `office365_sync_map` WHERE `officeid`=? AND `module`=? ",array($eventid,$moduleName));
                    $synced=$adb->query_result($res,'vtigerid');

                    if($synced != ''){
                      $eventidcopy[]=$eventid;
                    }

                }
            }
            // Mabruk
            if ($moduleName != 'Office365Contacts')
                foreach ($eventidcopy as $id){
                    unset($targetRecords[$id]);
                }
            
        }

        $transformedRecords = $this->targetConnector->transformToSourceRecord($targetRecords, $this->user); 
        $sourceRecords = $this->sourceConnector->push($transformedRecords, $sourceSyncStateModel);

        foreach ($targetRecords as $targetRecord) {
                $targetId = $targetRecord->getId();
            foreach ($sourceRecords as $sourceRecord) {
                if ($sourceRecord->getSyncIdentificationKey() == $targetRecord->getSyncIdentificationKey()) {
                    $sychronizeRecord = array();
                    $sychronizeRecord['source'] = $sourceRecord;
                    $sychronizeRecord['target'] = $targetRecord;
                    $synchronizedRecords[] = $sychronizeRecord;
                    break;
                }

            }

        }

        $this->targetConnector->postEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PULL_EVENT, $synchronizedRecords, $syncStateModel);
        $this->sourceConnector->postEvent(self::WSAPP_SYNCHRONIZECONTROLLER_PUSH_EVENT, $synchronizedRecords, $sourceSyncStateModel);

        $this->updateSyncStateModel($this->sourceConnector, $sourceSyncStateModel);

        return $synchronizedRecords;

    }

    public function synchronize($pullTargetFirst = true, $push = true, $pull = true,$moduleName) {
        $records = array();
        $currentTime = date('y-m-d H:i:s');
        $user = Users_Record_model::getCurrentUserModel();
        $records['synctime'] = $currentTime;
        $records['Extension'] = explode('_',get_class($this));
        $records['ExtensionModule'] = $this->getSourceType();
        $records['user'] = $user->id;

        if ($pullTargetFirst) {
            if($push) $records['push'] = $this->synchronizePush($moduleName);
            if($pull) $records['pull'] = $this->synchronizePull($moduleName);
        } else {
            if($pull) $records['pull'] = $this->synchronizePull($moduleName);
            if($push) $records['push'] = $this->synchronizePush($moduleName);
        }

        //To Log sync information
        WSAPP_Logs::add($records);

        return $records;
    }

}

?>

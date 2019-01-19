<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Roles Record Model Class
 */
abstract class Settings_Vtiger_Record_Model extends Vtiger_Base_Model {

	abstract function getId();
	abstract function getName();

	const tableName  = 'vtiger_leaverolemapping';

    /**
	 * Function to get the instance of Settings module model
	 * @return Settings_Vtiger_Module_Model instance
	 */
	 public static function getInstance($name='Settings:Vtiger') {
		$modelClassName  = Vtiger_Loader::getComponentClassName('Model', 'Record', $name);
		 return new $modelClassName();
	 }
    
    
	public function getRecordLinks() {

		$links = array();
		$recordLinks = array();
		foreach ($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}

		return $links;
	}

	//Function Added By Mabruk For Googe Drive Settings on 16/05/2018
	public function getGoogleCredentials() {
		
		global $adb;
		$result = $adb->pquery("SELECT * FROM google_drive_credentials",array());
		//$client_secret_file = $adb->query_result($result,0,"json_file");
		$access_key = $adb->query_result($result,0,"access_key");
		$result = array('Client Secret File' => $client_secret_file = "", 'Access Key' =>$access_key);
		return $result;
	}
	
	public function getDisplayValue($key) {
		return $this->get($key);
	}

	public function save(){

		$db = PearDatabase::getInstance();
        $currentUser = Users_Record_Model::getCurrentUserModel();
        $currentDate = date('Y-m-d H:i:s');
        $checkQuery = 'SELECT 1 FROM '.self::tableName;
        $result = $db->pquery($checkQuery,array($currentUser->getId()));
        if($db->num_rows($result) > 0) {
            $query = 'UPDATE '.self::tableName.' SET announcement=?,time=? WHERE creatorid=?';
            $params = array($this->get('announcement'),$db->formatDate($currentDate, true),$currentUser->getId());
        }else{
            $query = 'INSERT INTO '.self::tableName.' VALUES(?,?,?,?)';
            $params = array($currentUser->getId(),$this->get('announcement'),'announcement',$db->formatDate($currentDate, true));
        }
        $db->pquery($query,$params);
	}
}

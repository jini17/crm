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
class Settings_MultipleActions_Record_Model extends Settings_Vtiger_Record_Model {

	
	public function getId() {
		//return $this->get('roleid');
	}

	/**
	 * Function to get the Role Name
	 * @return <String>
	 */
	public function getName() {
		//return $this->get('rolename');
	}

	/**
	 * Function to save the Multiple actions
	*/
	public function saveRecord($data) {
		$db = PearDatabase::getInstance();
	//echo "<pre>";	print_r($data);
		$time = date('Y-m-d H:i:s');
		foreach($data as $item) {
			//check if exist or not
			$resultcheck = $db->pquery("SELECT 1 FROM secondcrm_multipleactions WHERE actioncode=?",array($item['actioncode']));	if ($db->num_rows($resultcheck)>0) {
				$params = array($item['isrestrict'],$item['statusvalue'],$item['userid'],$time, $item['actioncode']);		$result = $db->pquery("UPDATE secondcrm_multipleactions SET isrestrict=?, statusvalue=?, modifiedby=?, modifiedtime=? WHERE actioncode=?",array($params));
			
			} else {
				$params = array($item['isrestrict'],$item['statusvalue'],$item['module'],$item['actioncode'],$item['userid'],$time);
				$result = $db->pquery("INSERT INTO secondcrm_multipleactions SET isrestrict=?, statusvalue=?, module=?,actioncode=?,createdby=?, createdtime=?",array($params));
			}	
		}

	}

	
	/**
	 * Function get all multiple actions
	 * @return Array Null otherwise
	 */
	public static function getRestrictActions() {
		$db = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_multipleactions";
		
		$params = array();
		$result = $db->pquery($sql, $params);
		if ($db->num_rows($result) > 0) {
			while ($temprow = $db->fetch_array($result)) {				
				return 	$rows[] = $temprow;		
			}
		}
		return null;
	}

	/**
	 * Function get all picklist values
	 * @return Array 
	*/
		
	public function getPickistValues($picklist){
		$db = PearDatabase::getInstance();
		$sql = "SELECT ".$picklist." FROM vtiger_".$picklist;
		
		$params = array();
		$result = $db->pquery($sql, $params);
		$num_rows = $db->num_rows($result);
		if ($db->num_rows($result) > 0) {
			for ($i = 0; $i < $num_rows; $i++) {
				$rows[] = $db->query_result($result, $i,$picklist);
			}
			return $rows;
		}		
		return null;
	}		
}

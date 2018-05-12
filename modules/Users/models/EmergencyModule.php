<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EmergencyModule_Model extends Vtiger_Base_Model{
    
    const tableName = 'secondcrm_emergencycontact';
	
   public function getEditEmergencyUrl() {
	return '?module=Users&view=EditEmergency';
    }
	
     
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
		$emeregencyRecordModel=array();
   
		$query = 'SELECT * FROM '.self::tableName.' WHERE user_id=?';
        	$result = $db->pquery($query,array($id));
        	$emeregencyRecordModel = new self();
        	if($db->num_rows($result) > 0) {
        	    $row = $db->query_result_rowdata($result,0);
        	    $emeregencyRecordModel->setData($row)->setType($type);
        	}
        return $emeregencyRecordModel;
    }
}

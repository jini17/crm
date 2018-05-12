<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_WorkExpModule_Model extends Vtiger_Base_Model{
    
    const ISView = 0;
    const tableName = 'secondcrm_userworkexp';
  
    public function getCreateUserWorkExpUrl() {
	return '?module=Users&view=EditWorkExp';
    }
 
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
	$WERecordModel=array();
		$query = 'SELECT * FROM '.self::tableName.' WHERE uw_id=?';
        	$result = $db->pquery($query,array($id));
        	$WERecordModel = new self();
        	if($db->num_rows($result) > 0) {
        	    $row = $db->query_result_rowdata($result,0);
        	    $WERecordModel->setData($row)->setType($type);
        	}
        return $WERecordModel;
    }
}

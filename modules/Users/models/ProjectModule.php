<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_ProjectModule_Model extends Vtiger_Base_Model{
    
    const ISView = 0;
    const tableName = 'secondcrm_project';
	
   
    public function getId() {
        return $this->get('project_id');
    }

    public function getTitle() {
        return $this->get('title');
    }
 
    public function getCreateProjectUrl() {
	return '?module=Users&view=EditProject';
    }
	
     
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
	$projectRecordModel=array();
   
	
		$query = 'SELECT * FROM '.self::tableName.' WHERE project_id=?';
        	$result = $db->pquery($query,array($id));
        	$projectRecordModel = new self();
        	if($db->num_rows($result) > 0) {
        	    $row = $db->query_result_rowdata($result,0);
        	    $projectRecordModel->setData($row)->setType($type);
        	}
        return $projectRecordModel;
    }
}

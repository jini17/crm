<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EduModule_Model extends Vtiger_Base_Model{
    
    const ISView = 0;
    const tableName = 'secondcrm_education';
	
   
    public function getId() {
        return $this->get('edu_id');
    }

    public function getInstitutionId() {
        return $this->get('institution_id');
    }
	
    public function getStartYear() {
        return $this->get('startyear');
    }	 

    public function getEndYear() {
        return $this->get('endyear');
    }
    
    public function getEducationLevel() {
        return $this->get('education_level');
    }

    public function getMajorId() {
        return $this->get('major_id');
    }

    public function getDescription() {
        return $this->get('description');
    }

    public function isView() {
        return $this->get('isview') == 0 ? 'No' : 'Yes';
    }

    public function markDeleted() {
        return $this->set('deleted','1');
    }
    
    public function unMarkDeleted() {
        return $this->set('deleted','0');
    }
    
    public function getCreateEducationUrl() {
	return '?module=Users&view=EditEducation';
    }
	
     
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
	$eduRecordModel=array();
   
	
		$query = 'SELECT * FROM '.self::tableName.' WHERE edu_id=?';
        	$result = $db->pquery($query,array($id));
        	$eduRecordModel = new self();
        	if($db->num_rows($result) > 0) {
        	    $row = $db->query_result_rowdata($result,0);
        	    $eduRecordModel->setData($row)->setType($type);
        	}
        return $eduRecordModel;
    }
}

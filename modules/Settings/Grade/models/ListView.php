<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Grade_ListView_Model extends Settings_Vtiger_ListView_Model {
    
    public function getBasicListQuery() {
        $currentUser = Users_Record_Model::getCurrentUserModel();

        if(!$currentUser->isAdminUser()){
        	$where = "AND vtiger_crmentity.smownerid = ".$currentUser->getId();	
        }	
       
       $userNameSql = getSqlForNameInDisplayFormat(array('first_name'=>
							'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');

       $query = "SELECT if(vtiger_grade.grade_status=1, 'Yes','No') as grade_status, grade_desc,grade, gradeid, $userNameSql as smownerid FROM vtiger_grade INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_grade.gradeid 
        	INNER JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
        	WHERE vtiger_crmentity.deleted=0 $where";
        return $query;
    }
}
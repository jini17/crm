<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_EmployeeContract_ListView_Model extends Settings_Vtiger_ListView_Model {
    
    public function getBasicListQuery() {
        $currentUser = Users_Record_Model::getCurrentUserModel();

       if(!$currentUser->isAdminUser() && $currentUser->hradmin !='1'){
        	$where = "AND vtiger_crmentity.smownerid = ".$currentUser->getId();	
        }	
        $userNameSql = getSqlForNameInDisplayFormat(array('first_name'=>
							'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');


       $query = "SELECT *,$userNameSql as smownerid, vtiger_employeecontract.department, vtiger_grade.grade as job_grade FROM vtiger_employeecontract INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_employeecontract.employeecontractid 
        INNER JOIN vtiger_users ON vtiger_users.id=vtiger_crmentity.smownerid
        INNER JOIN vtiger_grade ON vtiger_grade.gradeid=vtiger_employeecontract.job_grade
        WHERE vtiger_crmentity.deleted=0 $where ORDER BY vtiger_crmentity.createdtime DESC";
        return $query;
    }
}

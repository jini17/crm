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
        
        $query = "SELECT if(vtiger_grade.grade_status=1, 'Yes','No') as grade_status, grade_desc,grade, gradeid  FROM vtiger_grade INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_grade.gradeid WHERE vtiger_crmentity.deleted=0";
        $query .=' AND vtiger_crmentity.smownerid = '.$currentUser->getId();
        return $query;
    }
}
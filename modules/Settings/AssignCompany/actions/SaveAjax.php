<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_AssignCompany_SaveAjax_Action extends Settings_Vtiger_Basic_Action {
    
    function __construct() {
        $this->exposeMethod('enableOrDisable');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
	$this->invokeExposedMethod($mode, $request);
    }
    
    /**
     * Function which will assign existing values to the roles
     * @param Vtiger_Request $request
     */
    public function assignValueToRole(Vtiger_Request $request) {
        $pickListFieldName = $request->get('picklistName');
        $valueToAssign = $request->getRaw('assign_values');
        $userSelectedRoles = $request->get('rolesSelected');
        
        $roleIdList = array();
        //selected all roles option
        if(in_array('all',$userSelectedRoles)) {
            $roleRecordList = Settings_Roles_Record_Model::getAll();
            foreach($roleRecordList as $roleRecord) {
                $roleIdList[] = $roleRecord->getId();
            }
        }else{
            $roleIdList = $userSelectedRoles;
        }
        
        $moduleModel = new Settings_Picklist_Module_Model();
        
        $response = new Vtiger_Response();
        try{
            $moduleModel->enableOrDisableValuesForRole($pickListFieldName, $valueToAssign, array(),$roleIdList);
            $response->setResult(array('success',true));
        } catch (Exception $e) {
            $response->setError($e->getCode(), $e->getMessage());
        }
        $response->emit();
    }
    
       
    public function enableOrDisable(Vtiger_Request $request) {
	$db = PearDatabase::getInstance();	
        $enabledValues = $request->getRaw('enabled_values',array());
        $userSelected = $request->get('userSelected');
       
	//Remove Previous Assign Company for a user
	$sql = $db->pquery("DELETE FROM secondcrm_users_assigncompany WHERE userid = ?",array($userSelected));	
	
	//Insert into company assign to User
      	$query = "INSERT INTO secondcrm_users_assigncompany(userid, organization_id) VALUES";
        foreach($enabledValues  as $companyValue) {
		if(!empty($companyValue)){
			 $query .= "(".$userSelected.",".$companyValue."),";
		}
        }
	$query = rtrim($query,',');	
	$result = $db->pquery($query,array());
	
	$response = new Vtiger_Response();
	if($result) {
	           $response->setResult(array('success',true));
        } else {
	           $response->setError("Query Failed:203 ", $query);
        } 
	
        $response->emit();
	
    }
         
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    } 
}

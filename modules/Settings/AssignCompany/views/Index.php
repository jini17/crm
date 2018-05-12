<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_AssignCompany_Index_View extends Settings_Vtiger_Index_View {
    
    public function process(Vtiger_Request $request) {
	$userstaus = true;
        $defaultUser = $request->get('default_user');
        $activeUserList = Users_Record_Model::getCRMUser($userstaus);

        if(empty($defaultUser)) {
            //take the first module as the source module
	    $defaultUser = $activeUserList[0]['id'];
        }
        $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(FALSE);
        $viewer->assign('USERS_LIST',$activeUserList);	 //All Active User assign to smarty variable
	
	//Get All Company List
	$allCompanyList = Settings_MultipleCompany_List_Model::getListCompany();		
	$viewer->assign('COMPANY_LIST',$allCompanyList); //All Company assign to smarty variable	
	
	//Get All Assign Company To User
	$assignCompanyList = Settings_MultipleTnC_CompanyTnC_Model::getAllCompanyByUser($defaultUser);
	
	$viewer->assign('ASSIGN_COMPANY_LIST',$assignCompanyList);
	$viewer->assign('DEFAULT_USER',$defaultUser);
       	$viewer->view('Index.tpl',$qualifiedName);
    }
	
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.$moduleName.resources.$moduleName",
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

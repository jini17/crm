<?php
/* ===================================================================
Modified By: Jitendra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 15 / 09 / 2014
Change Reason: Multiple Terms An Conditions , New file created
=================================================================== */

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleCompany_List_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
                
		$qualifiedModuleName = $request->getModule(false);
		$moduleModel = Settings_MultipleCompany_List_Model::getInstance();
                $return_data = $moduleModel->getListCompany();
                
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('ERROR_MESSAGE', $request->get('error'));
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('DETAILS', $return_data);
		$viewer->view('List.tpl', $qualifiedModuleName);
	}
	
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_COMPANY_DETAILS',$qualifiedModuleName);
	}
	
		/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.CompanyDetails",
			"modules.Settings.$moduleName.resources.List"		//added by jitu@Tar for display msg on delete
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
    
}

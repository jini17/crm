<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_CompanyNumbering_CustomRecordNumbering_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		$supportedModules = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getSupportedModules();
		//Important : Is intance allow for multiple company or not
		$isAllowMultipleCompany = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getSupportMultipleCompany();		
		 $companylist    = Settings_MultipleTnC_CompanyTnC_Model::getAllCompanyByTnC();
		
		if($isAllowMultipleCompany == 0) {
			$tmplist = $companylist[0];
			$companylist = array();
			$companylist[0] = $tmplist;
		}
		
		$defaultcompany =  $companylist[0]['organizationId'];
		
		$sourceModule = $request->get('sourceModule');
		if ($sourceModule) {
			$defaultModuleModel = $supportedModules[getTabid($sourceModule)];
		} else {
			$defaultModuleModel = reset($supportedModules);
		}
		
		$viewer = $this->getViewer($request);
		$viewer->assign('ALL_COMPANY', $companylist);
		$viewer->assign('DEFAULT_COMPANY', $defaultcompany);
		$viewer->assign('SUPPORTED_MODULES', $supportedModules);
		$viewer->assign('DEFAULT_MODULE_MODEL', $defaultModuleModel);
		$viewer->assign('QUALIFIED_MODULE',$qualifiedModuleName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->view('CustomRecordNumbering.tpl', $qualifiedModuleName);
	}
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_CUSTOMIZE_RECORD_NUMBERING',$qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.CustomRecordNumbering"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

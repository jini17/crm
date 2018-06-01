<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk
 ************************************************************************************/

class Settings_Vtiger_AdvanceGoogleConfigEdit_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$qualifiedName = $request->getModule(false);
		$moduleModel = Settings_Vtiger_GoogleConfigModule_Model::getInstance();

		$viewer = $this->getViewer($request);
		$viewer->assign('MODEL', $moduleModel);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('ADVANCED_FIELD_VALUES', Settings_Vtiger_Record_Model::getGoogleCredentials()); // Added By Mabruk for Googe Drive Settings
		$viewer->view('AdvanceGoogleConfigEdit.tpl', $qualifiedName);
	}
	
		
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_GOOGLE_CONFIG',$qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.GoogleConfig"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

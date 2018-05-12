<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleTnC_Edit_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$record = $request->get('id');
		$SELECTED_COMPANY = array();
		if(!empty($record)) {
			$TNC_RECORD = Settings_MultipleTnC_Detail_Model::getInstanceId($record);
			$viewer->assign('MODE', 'edit');
			$RES_COMPANY = Settings_MultipleTnC_CompanyTnC_Model::getAllCompanyByTnC($record);
			foreach($RES_COMPANY as $Company) {
				$SELECTED_COMPANY[] = $Company['organizationId']; 	
			}	
		} else {
			$TNC_RECORD = array();
			$viewer->assign('MODE', '');
		}
			
		$ALL_COMPANY = Settings_MultipleTnC_CompanyTnC_Model::getAllCompanyByTnC();
		$viewer->assign('ALL_COMPANY', $ALL_COMPANY);
		$viewer->assign('SELECTED_COMPANY', $SELECTED_COMPANY);
		$viewer->assign('TNC_RECORD', $TNC_RECORD);
		$viewer->assign('RECORD_ID', $record);
		$viewer->assign('MODULE', $moduleName);
		$viewer->view('Edit.tpl', $qualifiedModuleName);
	}	
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_TNC_DETAILS',$qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.Edit"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
    
}

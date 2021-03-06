<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_PDFSetting_List_View extends Settings_Vtiger_Index_View {
	
	public function checkPermission(Vtiger_Request $request) {
            $moduleName = $request->getModule();
            $CURRENT_USER_MODEL = Users_Record_Model::getCurrentUserModel();
            if(!$CURRENT_USER_MODEL->isAdminuser() && !in_array($CURRENT_USER_MODEL->roleid,array('H2','H12','H13'))) {
                    throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $moduleName));
            }
	}
	

	public function process(Vtiger_Request $request) {
                
		$qualifiedModuleName = $request->getModule(false);

		//set default module	
		$default_module = 'Quotes';
		if($request->get('displaymodul'))
			$default_module = $request->get('displaymodul');
		
		$return_data = Settings_PDFSetting_Record_Model::getPDFSettings($default_module);
		//echo '<pre>';print_r($return_data);
      		$viewer = $this->getViewer($request);
		$viewer->assign('ERROR_MESSAGE', $request->get('error'));
		$viewer->assign('DISPLAYMODULE', $default_module );
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('DETAILS', $return_data);
		echo $viewer->view('List.tpl', $qualifiedModuleName, true);
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
			"modules.Vtiger.resources.List",
			"modules.Settings.Vtiger.resources.List",
			"modules.Settings.$moduleName.resource.List"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

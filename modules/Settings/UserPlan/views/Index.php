<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk
 *************************************************************************************/

Class Settings_UserPlan_Index_View extends Settings_Vtiger_Index_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('showUserPlan');
		$this->exposeMethod('LoadPlan');
	}

	public function process(Vtiger_Request $request) {
		
		$mode = $request->getmode();
		
		if($this->isMethodExposed($mode)) {
			$this->invokeExposedMethod($mode, $request);
		}else {
			//by default show field layout
			$this->showUserPlan($request);
		}
	}

	public function showUserPlan($request){
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$viewer->assign('USERS', Settings_UserPlan_Module_Model::getUsers());		
		$viewer->assign('PLANS', Settings_UserPlan_Module_Model::getPlan());
		$viewer->view('Index.tpl', $qualifiedModuleName);
	}

	public function LoadPlan($request){
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$viewer->assign('USERS', Settings_UserPlan_Module_Model::getUsers());		
		$viewer->assign('PLANS', Settings_UserPlan_Module_Model::getPlan());
		//added by danial 12/04/2018
		//$viewer->assign('ROLES', Settings_UserPlan_Module_Model::getUserRole());
		$viewer->view('UserPlan.tpl', $qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.Index"
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

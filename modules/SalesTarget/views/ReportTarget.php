<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class SalesTarget_ReportTarget_View extends Vtiger_List_View {

	public function process(Vtiger_Request $request) {
		//echo"<pre>";print_r($request);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$viewer = $this->getViewer($request);
		$resultTargets = SalesTarget_Record_Model::getActiveSalesTargetListOption($recordId);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('RESULT_TARGETS',$resultTargets);
       		$viewer->assign('RECORD_ID', $recordId);
		$viewer->view('ReportTarget.tpl', 'SalesTarget');
		
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
			'modules.SalesTarget.resources.Target'	
		);
	
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

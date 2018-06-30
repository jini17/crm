<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_CurrentSubscription_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$linkId = $request->get('linkid');		
		$moduleModel = Home_Module_Model::getInstance($moduleName);

		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('DATADETAILS', $moduleModel->getSubscriptionDetail());
		$viewer->assign('SHORTNAME', $dbconfig['db_name']);
		
		$viewer->assign('MODULE_NAME', $moduleName);

		$content = $request->get('content');
		if(!empty($content)) {
			$viewer->view('dashboards/CurrentSubscription.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/CurrentSubheader.tpl', $moduleName);
		}
	}
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	public function getHeaderScripts(Vtiger_Request $request) {

		$jsFileNames = array(
			'modules.Vtiger.resources.dashboards.Widget',
		);

		$headerScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		return $headerScriptInstances;
	}
}
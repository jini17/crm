<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Employee_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$type = $request->get('department');
		
		
		$moduleModel = Home_Module_Model::getInstance($moduleName);
		$birthdays = $moduleModel->getDepartments();
		//$departmentlist = 

		$viewer->assign('TYPELABEL', $typeLabel);
				
		$page = $request->get('page');
		$linkId = $request->get('linkid');
	
		$moduleModel = Home_Module_Model::getInstance($moduleName);
		$birthdays = $moduleModel->getBirthdays($group, $type);
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());

		
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('MODULE_NAME', $moduleName);

		$viewer->assign('MODELS', $birthdays);
		
		$content = $request->get('content');
		if(!empty($content)) {
			$viewer->view('dashboards/BirthdaysContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/Birthdays.tpl', $moduleName);
		}
	}
	
	function getHeaderScripts(Vtiger_Request $request) { 
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Emails.resources.MassEdit"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

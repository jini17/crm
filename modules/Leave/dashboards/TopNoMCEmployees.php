<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Leave_TopNoMCEmployees_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		//global $adb;
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$department = $request->get('department');
		$departmentList = getAllPickListValues('department');

		$typeLabel = 'LBL_NO_EMPLOYEE_FOUND';

		$leavemodel = Users_LeavesRecords_Model::widgetTopNOMCEmployee($department);
		
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $department);
		$viewer->assign('DEPARTMENT', $departmentList);
		$viewer->assign('TYPELABEL', $typeLabel);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/TopNoMCEmployeesContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/TopNoMCEmployees.tpl', $moduleName);
		}
	}
}

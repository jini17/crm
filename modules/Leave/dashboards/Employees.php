<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Leave_Employees_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$department = $request->get('department');
		$departmentList = getAllPickListValues('department');
		
		if($department == '' || $department == null)
			$type = 'Technical';
		
		$leavemodel = Users_LeavesRecords_Model::widgetTopNOMCEmployee($type);
			
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('TYPE', $type);
		
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/EmployeesContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/Employees.tpl', $moduleName);
		}
	}
}

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
		$LIMIT = 4;
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$department = $request->get('department');
		$departmentList = getAllPickListValues('department');

		$typeLabel = 'LBL_NO_EMPLOYEE_FOUND';

		
		$page = $request->get('page');
		if(empty($page)) {
			$page = 1;
		}
		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $page);
		$pagingModel->set('limit', $LIMIT);
		$leavemodel = Users_LeavesRecords_Model::widgetTopNOMCEmployee($department, $pagingModel);
		

		$linkId = $request->get('linkid');
		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId(), $request->get('tab'));
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $department);
		$viewer->assign('DEPARTMENT', $departmentList);
		$viewer->assign('TYPELABEL', $typeLabel);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$viewer->assign('PAGE', $page);
		$viewer->assign('NEXTPAGE', ($pagingModel->get('topcount') < $LIMIT)? 0 : $page+1);

		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/TopNoMCEmployeesContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/TopNoMCEmployees.tpl', $moduleName);
		}
	}
}

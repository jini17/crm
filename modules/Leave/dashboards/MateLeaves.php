<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Leave_MateLeaves_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		
		$type = $request->get('type');
		
		if($type == '' || $type == null)
			$type = 'thisweek';
		
		$typeLabel = 'LBL_IN_TODAY';

		if($type=='today') {
			$typeLabel = 'LBL_IN_TODAY';
		} else if($type=='tomorrow') {	
			$typeLabel = 'LBL_IN_TOMORROW';
		} else if($type=='thisweek') {	
			$typeLabel = 'LBL_IN_THIS_WEEK';
		} else if($type=='nextweek') {	
			$typeLabel = 'LBL_IN_NEXT_WEEK';
		} else if($type=='thismonth') {	
			$typeLabel = 'LBL_IN_THIS_MONTH';
		} 

		$department = $request->get('department');
		
		$departmentList = getAllPickListValues('department');
		
		$leavemodel = Users_LeavesRecords_Model::getWidgetsColleaguesLeave($type, $department);	


		$page = $request->get('page');
		$linkId = $request->get('linkid');

		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $type );
		$viewer->assign('VALUELABEL', $typeLabel);
		$viewer->assign('DEPARTMENT', $departmentList);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/ColleaguesContent.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/Colleagues.tpl', $moduleName);
		}
	}
}

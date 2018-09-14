<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class EmployeeContract_Document_Expiring_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$type = $request->get('type');
		$filter = $request->get('group');

		$leaveTypelist = Users_LeavesRecords_Model::getLeaveTypeList($currentUser->getId());
		$value = $type;
		if($type == '' || $type == null) {
				$value = 'leavetype';
				$filter = $leaveTypelist[0]['leavetypeid'];
		}
		
		$valueLabel = 'LBL_LEAVE_TYPE';

		if($type=='leavetype') {
			$valueLabel = $valueLabel;
		}  else if($type=='latest') {	
			$valueLabel = 'LBL_LAST_5_LEAVES';
		}
		
		
		
		$leavemodel = Users_LeavesRecords_Model::getMyLeaves($currentUser->getId(), date('Y'), $value, $filter);	
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $value );
		$viewer->assign('VALUELABEL', $valueLabel);
		
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$viewer->assign('LEAVE_TYPE_LIST', $leaveTypelist);
		$viewer->assign('DURATION', $duration);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/DocumentExpiringContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/DocumentExpiring.tpl', $moduleName);
		}
	}
}

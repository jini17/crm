<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Leave_MembersLeaves_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$duration = $request->get('duration');
		$group = $request->get('group');
		$linkId = $request->get('linkid');
		
		$leavemodel = Users_LeavesRecords_Model::widgetgetusersleaves($group, $duration);
		$timeLabel = vtranslate('LBL_TODAY',$moduleName);

		if($duration == 'today') {
			$timeLabel = vtranslate('LBL_IN_TODAY',$moduleName);
		} else if($duration == 'nextsevendays') {
			$timeLabel = vtranslate('LBL_IN_NEXTSEVENDAYS',$moduleName);
		} else if ($duration == 'nextthirtydays'){
			$timeLabel = vtranslate('LBL_IN_NEXTTHIRTYDAYS',$moduleName);
		}	
		
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('TIME_LABEL', $timeLabel);
		$viewer->assign('MODELS', $leavemodel);
		$content = $request->get('content');
		if(!empty($content)) {
			$viewer->view('dashboards/MembersLeavesContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/MembersLeaves.tpl', $moduleName);
		}
	}
}

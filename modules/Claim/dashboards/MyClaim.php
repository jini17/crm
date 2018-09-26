<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Claim_MyClaim_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$type = $request->get('type');
		
		if($type == '' || $type == null) {
				$type = 'leavetype';
		}
		
		$valueLabel = 'LBL_CLAIM_TYPE';

		if($type=='leavetype') {
			$valueLabel = $valueLabel;
			
		}  else if($type=='latest') {	
		
			$valueLabel = 'LBL_LAST_5_CLAIM';
		}
		
		$leavemodel = Users_LeavesRecords_Model::getWidgetsMyLeaves($currentUser->getId(), date('Y'), $type);	
		$page = $request->get('page');
		$linkId = $request->get('linkid');

		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $type );
		$viewer->assign('VALUELABEL', $valueLabel);
		$viewer->assign('USERID', $currentUser->getId());
		
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $leavemodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/MyClaimContent.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/MyClaim.tpl', $moduleName);
		}
	}
}

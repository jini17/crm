<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Claim_MyTeamClaim_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {

		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		$type = $request->get('type');
		$userModel = Users_ClaimRecords_Model::getMyTeamMembers($currentUser->getId());
		$select_value = $request->get('employee_name');
		
		if($type == '' || $type == null) {
				$type = 'claimtype';
		}
		
		$valueLabel = 'LBL_CLAIM_TYPE';

		if($type=='claimtype') {
			$valueLabel = $valueLabel;
			
		}  else if($type=='pending') {	
		
			$valueLabel = 'LBL_PENDING_APPROVAL';
		}
		
		
			
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		$claimmodel = Users_ClaimRecords_Model::getMyTeamClaim($currentUser->getId(), date('Y'), 1, 1,$select_value,'');
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('VALUE', $type );
		$viewer->assign('VALUELABEL', $valueLabel);
		$viewer->assign('USERID', $currentUser->getId());
		
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('USERMODELS', $userModel);
		$viewer->assign('MODELS', $claimmodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/MyTeamClaimContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/MyTeamClaim.tpl', $moduleName);
		}
	}
}

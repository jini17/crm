<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditClaim_View extends Vtiger_Index_View {

	public function process(Vtiger_Request $request) { //print_r($request);die;
		
		$moduleName 	= $request->getModule();

		$current_user 	= Users_Record_Model::getCurrentUserModel();
		$jobgrade 		= $current_user->grade_id;
		
		$claimid 		= $request->get('record');  
		$userId 		= $request->get('userId');
		$claimstatus 	= $request->get('claimstatus');
		$manager 		= $request->get('manager');

		$claimtypelist 	= Users_ClaimRecords_Model::getClaimTypeList($userId);

		$viewer 		= $this->getViewer($request);
	
		//Enter Edit Mode if leave id = ''
		if(!empty($claimid) || $claimid != ""){

			$claimdetail = Users_ClaimRecords_Model::getClaimDetail($claimid);
		}

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->assign('USERID', $userId);
		$viewer->assign('CLAIMID', $claimid);
		$viewer->assign('CLAIMTYPELIST', $claimtypelist);
		$viewer->assign('CLAIMSTATUS', $claimstatus);
		$viewer->assign('MANAGER',$manager);
		$viewer->assign('JOBGRADE',$jobgrade);

		$viewer->assign('CLAIM_DETAIL', $claimdetail);
		$viewer->view('EditAjaxClaim.tpl', $moduleName);
	}
	 
}

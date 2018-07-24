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
		$moduleName = $request->getModule(); 
		$claimid = $request->get('record');  
		$userId = $request->get('userId');
		$claimstatus = $request->get('claimstatus');

		$viewer = $this->getViewer($request);
		$claimtype = Users_ClaimRecords_Model::getClaimTypeList($userId,$claimid);

		$claimstatuslist = Users_ClaimRecords_Model::getClaimStatusList($userId,$claimid);

		$userslist=Users_ClaimRecords_Model::getAllUsersList($userId);	

		$jobgrade=Users_ClaimRecords_Model::getJobGrade($userId);

		$manager = $request->get('manager');
		
		//Enter Edit Mode if leave id = ''
		if(!empty($claimid) || $claimid != ""){
		$claimdetail = Users_ClaimRecords_Model::getClaimDetail($claimid);
		//echo '<br>FIRST AZ <br><pre>';print_r($claimdetail);echo '</pre>';die;
		}
		$startDateField = array(	"mandatory"=>true,
						"presence"=>true,
						"quickcreate"=>false,
						"masseditable"=>false,
						"defaultvalue"=>false,
						"type"=>"date",
						"name"=>"start_date",
						"label"=>"Start Date",
						"date-format"=>"dd-mm-yyyy"	);
		$endDateField = array(	"mandatory"=>true,
						"presence"=>true,
						"quickcreate"=>false,
						"masseditable"=>false,
						"defaultvalue"=>false,
						"type"=>"date",
						"name"=>"end_date",
						"label"=>"End Date",
						"date-format"=>"dd-mm-yyyy"	);

		//$validator= '[{"name":"greaterThanDependentFieldOrMoreThanLeaveBalance","params":["start_date,leave_type"]}]';//Modified By Safuan-Validate leave balance and date 
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->assign('USERID', $userId);
		$viewer->assign('CLAIMID', $claimid);
		$viewer->assign('CLAIMTYPELIST', $claimtype);
		$viewer->assign('CLAIMSTATUSLIST', $claimstatuslist);
		$viewer->assign('CLAIMSTATUS', $claimstatus);
		$viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
		$viewer->assign('USERSLIST', $userslist);
		$viewer->assign('MANAGER',$manager);
		$viewer->assign('JOBGRADE',$jobgrade);

		$viewer->assign('CURRENTYEAR', date('Y'));
		$viewer->assign('STARTDATEFIELD', $startDateField);
		$viewer->assign('ENDDATEFIELD', $endDateField);
		$viewer->assign('VALIDATOR', $validator);

		$viewer->assign('CLAIM_DETAIL', $claimdetail);
		$viewer->view('EditAjaxClaim.tpl', $moduleName);
	}
	 
}

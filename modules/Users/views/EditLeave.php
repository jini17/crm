<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditLeave_View extends Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		global $current_user;
		
		$moduleName = $request->getModule();
		$leaveid = $request->get('record');
		$userId = $request->get('userId');
		$leavestatus = $request->get('leavestatus');
		$manager = $request->get('manager');
		
		$viewer = $this->getViewer($request);
		
		
		if(!$manager){
			$userId = $current_user->id;	
		} 
		
		$leavetype=Users_LeavesRecords_Model::getLeaveTypeList($userId);

		$userslist=Users_LeavesRecords_Model::getAllUsersList($userId);

		
		
		//Enter Edit Mode if leave id = ''
		if(!empty($leaveid) || $leaveid != ""){
		$leavedetail = Users_LeavesRecords_Model::getLeaveDetail($leaveid);
		//echo '<br>FIRST AZ <br><pre>';print_r($leavedetail);echo '</pre>';
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
		$viewer->assign('LEAVEID', $leaveid);
		$viewer->assign('LEAVETYPELIST', $leavetype);
		
		$viewer->assign('LEAVESTATUS', $leavestatus);
		$viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
		$viewer->assign('USERSLIST', $userslist);
		$viewer->assign('MANAGER',$manager);

		$viewer->assign('CURRENTYEAR', date('Y'));
		$viewer->assign('STARTDATEFIELD', $startDateField);
		$viewer->assign('ENDDATEFIELD', $endDateField);
	//	$viewer->assign('VALIDATOR', $validator);

		$viewer->assign('LEAVE_DETAIL', $leavedetail);
		$viewer->view('EditAjaxLeave.tpl', $moduleName);
	}
	 
}

<?php
//Added by jitu@secondcrm.com pm 24 oct 2014


///***  edited from  class Users_SaveSubModuleAjax_Action extends Vtiger_SaveAjax_Action {    ***/

class Users_SaveSubModuleAjax_Action extends Vtiger_BasicAjax_Action  {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('saveEducation');
		$this->exposeMethod('saveLanguage');
		$this->exposeMethod('saveSkill');
		$this->exposeMethod('saveProject');
		$this->exposeMethod('saveWorkExp');
		$this->exposeMethod('saveEmergencyContact');	
		$this->exposeMethod('saveLeave');
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}
	
	public function saveEducation(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		$request['is_studying']= $_REQUEST['is_studying'];
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_EduRecord_Model::saveEducationDetail($request);
		    $msg    = $return=='1'? vtranslate("LBL_INSTITUTION_UPDATE_SUCCESS","Users"):vtranslate("LBL_INSTITUTION_ADD_SUCCESS","Users"); 	
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}
	
	public function saveProject(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		$response = new Vtiger_Response();
		try{
		    $return = Users_ProjectRecord_Model::saveProjectDetail($request);
		    $msg    = $return=='1'? vtranslate("LBL_PROJECT_UPDATE_SUCCESS","Users"):vtranslate("LBL_PROJECT_ADD_SUCCESS","Users"); 		
		
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}
	
	public function saveWorkExp(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		$request['isworking']= $_REQUEST['isworking'];
		
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_WorkExpRecord_Model::saveworkexpDetail($request);
		    $msg    = $return=='1'? vtranslate("LBL_WORKEXP_UPDATE_SUCCESS","Users"):vtranslate("LBL_WORKEXP_ADD_SUCCESS","Users"); 		
		
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}
	
	public function saveLanguage(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_SkillsRecord_Model::saveSoftSkillDetail($request);
		    if($return ==3) {
			$msg = vtranslate("LBL_LANGUAGE_DUPLICATE_WARNING","Users");
		    } else {	 	
		    	$msg    = $request['record']==''? vtranslate("LBL_LANGUAGE_ADD_SUCCESS","Users"):vtranslate("LBL_LANGUAGE_UPDATE_SUCCESS","Users"); 			    
			}	
		
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();
	}


	public function saveEmergencyContact(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_EmergencyRecord_Model::saveContactDetail($request);
		    $msg    = $return=='1'? vtranslate("LBL_CONTACT_UPDATE_SUCCESS","Users"):vtranslate("LBL_CONTACT_ADD_SUCCESS","Users"); 		
		
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}
	public function saveSkill(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		$request['isview']= $_REQUEST['isview'];
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_SkillsRecord_Model::saveUserSkill($request);
		    if($return ==3) {
			$msg = vtranslate("LBL_SKILL_DUPLICATE_WARNING","Users");
		    } else {	 	
		    	$msg    = vtranslate("LBL_SKILL_ADD_SUCCESS","Users"); 		
		     }	
		   $response->setResult($msg);
			
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}

/*
	public function saveLeave(Vtiger_Request $request) {
		
		$module = $request->getModule();
		$request= $_REQUEST['form'];
		//$request['isview']= $_REQUEST['isview'];
		//$request['is_studying']= $_REQUEST['is_studying'];
		
		$response = new Vtiger_Response();
		try{
		    $return = Users_LeavesRecords_Model::saveLeaveDetail($request);
		    $msg    = $return=='1'? vtranslate("LBL_INSTITUTION_UPDATE_SUCCESS","Users"):vtranslate("LBL_INSTITUTION_ADD_SUCCESS","Users"); 	
		    $response->setResult($msg);
		}catch(Exception $e){
		    $response->setError($e->getCode(),$e->getMessage());
		}
		$response->emit();

	}
*/


	//Saving leave in-/new/edit/managerapproval//
	public function saveLeave(Vtiger_Request $request) { 

	//$request= $_REQUEST['form'];	
	$module = $request->getModule();
	$db = PearDatabase::getInstance();
	include_once 'include/Webservices/Create.php';
	$user = new Users();
	global $current_user;
	
    $current_usersaving = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	
	$applicant_id = $request->get('current_user_id');
	$leaveid= $request->get('record'); 
	
	$wsleaveType    = vtws_getWebserviceEntityId('LeaveType', $request->get('leave_type'));
	//echo $wsleaveType;die;
	$wsUser		= vtws_getWebserviceEntityId('Users', $request->get('replaceuser'));
	$wsCurrentUser	= vtws_getWebserviceEntityId('Users', $current_user->id);	
	$manager= $request->get('manager');
	$startdate = date('Y-m-d',strtotime($request->get('start_date')));
	$enddate = date('Y-m-d',strtotime($request->get('end_date')));

	//Check if leave is already applied during startdate and enddate by loggedIN User
	
	if($manager == 'false' || $manager == '' ) {  
	
		if ($leaveid =='') { 
			$resultleave = $db->pquery("SELECT vtiger_leave.leaveid FROM vtiger_leave 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leave.leaveid 
				WHERE ((fromdate between ? AND ?) OR (todate between ? AND ?)) AND (vtiger_leave.leavestatus ='Apply' || vtiger_leave.leavestatus ='New' || vtiger_leave.leavestatus ='Approved') AND vtiger_crmentity.smcreatorid = ? AND vtiger_crmentity.deleted=0",
			array($startdate, $enddate, $startdate, $enddate, $current_user->id));
		}		
		else { 
			$resultleave = $db->pquery("SELECT vtiger_leave.leaveid FROM vtiger_leave 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leave.leaveid 
				WHERE ((fromdate between ? AND ?) OR (todate between ? AND ?)) AND (vtiger_leave.leavestatus ='Apply' || vtiger_leave.leavestatus ='Approved') AND vtiger_crmentity.smcreatorid = ? AND vtiger_crmentity.deleted=0",
			array($startdate, $enddate, $startdate, $enddate, $current_user->id));
		}

	
		$date1 = strtotime($startdate);
		$date2 = strtotime($enddate);

		if($date1 > $date2){
			$response = new Vtiger_Response();
			$msg    = "date_wrong";
			$response->setResult($msg);
			$response->emit();	
			exit();
		}
		else{
		  // Date 2 is >
		}

			
		if($db->num_rows($resultleave) > 0) { 
			$response = new Vtiger_Response();
			$msg    = "JS_USER_ALREADY_APPLIED";
			$response->setResult($msg);
			$response->emit();	
			exit();
		}
	}


		
		//Check If new record.//
		if(empty($leaveid) || $leaveid==""){
 		$response = new Vtiger_Response();
		
		//$total_taken = ceil(abs($end - $start) / 86400);
		//New Create leave
			try {	
			
			//print_r($current_user);
			$starthalf = $request->get('chkboxstarthalf')==1?0.5:0;
			$endhalf  = $request->get('chkboxendhalf')==1?0.5:0;
			$startdate = date('Y-m-d',strtotime($request->get('start_date')));
			$enddate = date('Y-m-d',strtotime($request->get('end_date')));
			$takenleave = Users_LeavesRecords_Model::getWorkingDays($startdate,$enddate)-($starthalf+$endhalf);	
	
			$data = array (
					'leavetype' => $wsleaveType,
					'fromdate'=> $request->get('start_date'),
					'todate'  => $request->get('end_date'),
					'replaceuser_id'  => $wsUser,
					'reasonofleave'  => $request->get('reason'),
					'total_taken'  => $takenleave,
					'starthalf'  => $request->get('chkboxstarthalf'),
					'endhalf'  => $request->get('chkboxendhalf'),
					'leavestatus'  => $request->get('savetype'),
					'assigned_user_id' =>  $wsCurrentUser,
				);
				
				$leave = vtws_create('Leave', $data,$current_usersaving);
				$msg    = $leave != null ? vtranslate("LBL_CREATE_SUCCESS","Users"):vtranslate("LBL_CREATE_FAILED","Users");

		    	$response->setResult($msg);
			
			} catch (WebServiceException $ex) {
				echo $ex->getMessage();
			}

		$response->emit();

		}else{ 
		//update leave
 		$response = new Vtiger_Response();
		
	
			include_once 'include/Webservices/Revise.php';
			include_once 'modules/Leave/Leave.php';
			try {
					 $wsid = vtws_getWebserviceEntityId('Leave', $leaveid);
					//Edit and manager approval
					if($manager == 'true' || ($current_user->is_admin=='on' && $request->get('savetype')=='Approved'))
					{	
						$approvedate = date('Y-m-d');
						$approveby = $current_user->first_name.' '.$current_user->last_name;	
						$leavetype = $request->get('leave_type');
						$starthalf = $request->get('chkboxstarthalf')==1?0.5:0;
						$endhalf  = $request->get('chkboxendhalf')==1?0.5:0;
						$wsid = vtws_getWebserviceEntityId('Leave', $leaveid);
						$data = array(
							'id' => $wsid,
							'leavestatus'  => $request->get('savetype'),
							'reasonnotapprove'  => $request->get('rejectionreasontxt'),
							'approveby'=>$approveby,
							'approvedate'=>$approvedate,
							);
							if($request->get('	')=='Approved') { 
								
								$startdate = date('Y-m-d',strtotime($request->get('hdnstartdate')));
								$enddate = date('Y-m-d',strtotime($request->get('hdnenddate')));
								$takenleave = Users_LeavesRecords_Model::getWorkingDays($startdate,$enddate)-($starthalf+$endhalf);
								//find the total balance leave
								$userbalanceleave = Users_LeavesRecords_Model::getUserBalance($request->get('current_user_id'), $leavetype);

								if($userbalanceleave<$takenleave) {
									$msg = vtranslate("LBL_LESS_BALANCE","Users");
								} else { 
									$userupdateid=$request->get('current_user_id');
									$leabalq="UPDATE secondcrm_user_balance SET leave_count = leave_count-$takenleave WHERE user_id=$userupdateid AND leave_type=$leavetype";
									$resultx = $db->pquery($leabalq,array());
								}
							} 
						$leave = vtws_revise($data, $current_usersaving);
						//print_r($leave);die;
						$msg    = $request->get('savetype')=='Approved'?vtranslate("LBL_APPROVED","Users"):vtranslate("LBL_NOT_APPROVED","Users");
					}else{ 
						$starthalf = $request->get('chkboxstarthalf')==1?0.5:0;
						$endhalf  = $request->get('chkboxendhalf')==1?0.5:0;
						$startdate = date('Y-m-d',strtotime($request->get('start_date')));
						$enddate = date('Y-m-d',strtotime($request->get('end_date')));
						$takenleave = Users_LeavesRecords_Model::getWorkingDays($startdate,$enddate)-($starthalf+$endhalf);	
						$wsid = vtws_getWebserviceEntityId('Leave', $leaveid);
						$data = array(
							'id' => $wsid,
							'leavetype' => $wsleaveType,
							'fromdate' => $startdate,
							'todate'  => $enddate,
							'replaceuser_id'  => $wsUser,
							'reasonofleave'  => $request->get('reason'),
							'leavestatus'  => $request->get('savetype'),
							'total_taken'  => $takenleave,
							'assigned_user_id' =>  $wsCurrentUser,
							);
						$leave = vtws_revise($data, $current_usersaving);
						//print_r($leave);
						$msg    = $leave != null ? vtranslate("LBL_EDIT_SUCCESS","Users"):vtranslate("LBL_EDIT_FAILED","Users");
					}
		    		$response->setResult($msg);

			} catch (WebServiceException $ex) {
				echo $ex->getMessage();
			}
		$response->emit();
		}

	}

}
?>

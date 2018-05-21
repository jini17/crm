<?php
class Users_DeleteSubModuleAjax_Action extends Vtiger_Delete_Action {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('deleteSubModule');
		/*$this->exposeMethod('deleteEducation');
		$this->exposeMethod('deleteProject');
		$this->exposeMethod('deleteWorkExp');
		$this->exposeMethod('deleteLanguage');	
		$this->exposeMethod('deleteSkill');
		$this->exposeMethod('deleteLeave');	
		$this->exposeMethod('cancelLeave');	*/
	}

	public function process(Vtiger_Request $request) {
		 $mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	public function deleteSubModule($request) {

		global $adb;
		$adb->setDebug(true);
		//echo 'pre';print_r($_REQUEST);
		$sourceModule = $request->get('sourcemodule');
		include_once 'include/Webservices/Delete.php';
		echo 'modules/'.$sourceModule.'/'.$sourceModule.'.php';
		include_once 'modules/'.$sourceModule.'/'.$sourceModule.'.php';

		$user = new Users();
       	
       	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
		$record = $request->get('record');
		$response = new Vtiger_Response();

		try {
			$wsid = vtws_getWebserviceEntityId($sourceModule, $record); // Module_Webservice_ID x CRM_ID
			vtws_delete($wsid, $current_user);
		} catch (WebServiceException $ex) {
			echo $msg = $ex->getMessage();

			if($msg == ""){
				$response->setResult(array('msg'=>vtranslate('LBL_'.$sourceModule.'_DELETED_SUCCESSFULLY', $sourceModule)));
			} else {
				$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $sourceModule)));
			}
		}

		$response->emit();	
	}

	public function deleteProject($request){
		$project_id = $request->get('record');
		$isdeleted  = Users_ProjectRecord_Model::deleteProjectPermanently($project_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		if($isdeleted==1){
			$response->setResult(array('msg'=>vtranslate('LBL_PROJECT_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();
	}

	public function deleteEducation($request){
		$edu_id = $request->get('record');
		$isdeleted  = Users_EduRecord_Model::deleteEducationPermanently($edu_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		if($isdeleted==1){
			$response->setResult(array('msg'=>vtranslate('LBL_EDUCATION_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();
	}
	public function deleteWorkExp($request){
		$uw_id = $request->get('record');
		$isdeleted  = Users_WorkExpRecord_Model::deleteWorkExpPermanently($uw_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		if($isdeleted==1){
			$response->setResult(array('msg'=>vtranslate('LBL_WORKEXP_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();
	}

	public function deleteLanguage($request){
		$lang_id = $request->get('record');
		$isdeleted  = Users_SkillsRecord_Model::deleteLanguagePermanently($lang_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		if($isdeleted==1){
			$response->setResult(array('msg'=>vtranslate('LBL_LANGUAGE_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();
	}

	public function deleteSkill($request){
		$lang_id = $request->get('record');
		$isdeleted  = Users_SkillsRecord_Model::deleteSkillPermanently($lang_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();
		if($isdeleted==1){
			$response->setResult(array('msg'=>vtranslate('LBL_Skill_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();
	}

	public function deleteLeave($request) {
		//echo 'pre';print_r($_REQUEST);
		include_once 'include/Webservices/Delete.php';
		include_once 'modules/Leave/Leave.php';
		$user = new Users();
       		$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
		$leaveid = $_REQUEST['record'];
		//$project_id = $request->get('record');
		//$isdeleted  = Users_ProjectRecord_Model::deleteProjectPermanently($project_id);
        	$moduleName = $request->getModule();
		$response = new Vtiger_Response();

		try {
			$wsid = vtws_getWebserviceEntityId('Leave', $leaveid); // Module_Webservice_ID x CRM_ID
			vtws_delete($wsid, $current_user);
		} catch (WebServiceException $ex) {
			echo $msg = $ex->getMessage();
		}


		if($msg == ""){
			$response->setResult(array('msg'=>vtranslate('LBL_LEAVE_DELETED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setResult(array('msg'=>vtranslate('LBL_PROBLEM_IN_DELETION', $moduleName)));
		}
		$response->emit();

	}
	public function cancelLeave($request) {
		//update leave
 		$response = new Vtiger_Response();
		$leaveid = $request->get('record');
		$leavetype = $request->get('leave_type');
		$userupdateid = $request->get('user_id');
		$leavestatus = $request->get('leavestatus');
		$user = new Users();
      	 	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
			include_once 'include/Webservices/Revise.php';
			include_once 'modules/Leave/Leave.php';
		
			try {
				$wsid = vtws_getWebserviceEntityId('Leave', $leaveid);

				$data = array(
						'id' => $wsid,	
						'leavestatus'  => 'Cancel',
					);
				
				$leave = vtws_revise($data, $current_user);
				//print_r($leave);
				
				if($leavestatus == 'Approved'){
					$result = Users_LeavesRecords_Model::CancelUserLeave($leaveid, $userupdateid, $leavetype);
				}
				$msg    = $leave['leavestatus'] == 'Cancel' ? vtranslate("LBL_CANCEL_SUCCESS","Users"):vtranslate("LBL_CANCEL_FAILED","Users");
				$response->setResult(array('msg'=>$msg));
		    	
			} catch (WebServiceException $ex) {
				echo $ex->getMessage();
			}


		$response->emit();
	
	}

}
?>

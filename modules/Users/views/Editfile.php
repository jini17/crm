<?php
class Users_Editfile_View extends Vtiger_Index_View {

	function __construct() {
		parent::__construct();
       		$this->exposeMethod('EditLanguage');
	        $this->exposeMethod('EditSkill');
	}


	function process(Vtiger_Request $request) {
        	$mode = $request->get('mode');
		if(!empty($mode)) {
		    $this->invokeExposedMethod($mode, $request);
		  return;
	       }
	}
	
	public function EditLanguage(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$lang_id = $request->get('record');
		$userId = $request->get('userId');
		$selected_id = $request->get('selected_id');
		$viewer->assign('MODULE',$moduleName);

		$SkillModuleModel = Users_SkillsModule_Model::getLangInstance();

		$skillUserModel	= Users_SkillsRecord_Model::getLangInstance();

		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->assign('LANGUAGE_RECORD_MODEL',$SkillModuleModel);
		$viewer->assign('LANG_ID',$lang_id);
		$viewer->assign('USERID',$userId);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('LANGUAGE_LIST',$skillUserModel->getAllLanguage($userId,$selected_id));
		$langdetail = array();	
		if(!empty($lang_id)) {
			$langdetail = $skillUserModel->getSoftSkillDetail($lang_id);
			
		}
		$viewer->assign('LANGUAGE_DETAIL',$langdetail);		
		echo $viewer->view('EditAjaxLang.tpl',$moduleName,true);
	}

	public function EditSkill(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$userId = $request->get('userId');
		$userRecordModel = Users_SkillsRecord_Model::getCurrentUserModel();
		
		$viewer = $this->getViewer($request);
		$SkillList = $userRecordModel->getALLSKills($userId);
	
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->assign('USERID', $userId);
		$viewer->assign('SKILL_LIST', $SkillList);
		$viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
		$viewer->view('AddSkill.tpl', $moduleName);
	}
}

?>

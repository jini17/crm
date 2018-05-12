<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditEmergency_View extends Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$userId = $request->get('userId');
		$userRecordModel = Users_EmergencyRecord_Model::getCurrentUserModel();
		
		$emergencydetailmodel = $userRecordModel->getUserEmergencyContact($userId); 
		$homephonefield = array(	"mandatory"=>true,
						"presence"=>true,
						"quickcreate"=>false,
						"masseditable"=>false,
						"defaultvalue"=>false,
						"type"=>"phoneregex",
						"name"=>"home_phone",
						"label"=>"Home Phone"
							);
		$officephonefield = array(	"mandatory"=>true,
						"presence"=>true,
						"quickcreate"=>false,
						"masseditable"=>false,
						"defaultvalue"=>false,
						"type"=>"phoneregex",
						"name"=>"office_phone",
						"label"=>"Office Phone"
							);
		$mobilephonefield = array(	"mandatory"=>true,
						"presence"=>true,
						"quickcreate"=>false,
						"masseditable"=>false,
						"defaultvalue"=>false,
						"type"=>"phoneregex",
						"name"=>"mobile",
						"label"=>"Mobile Phone"
							);
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $moduleName);
		$viewer->assign('USERID', $userId);
		$viewer->assign('HOMEPHONE', $homephonefield);
		$viewer->assign('OFFICEPHONE', $officephonefield);
		$viewer->assign('MOBILEPHONE', $mobilephonefield);	
		$viewer->assign('EMERGENCY_DETAIL', $emergencydetailmodel);
		$viewer->view('EditAjaxEmergency.tpl', $moduleName);
	}
}

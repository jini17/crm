<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Added By Mabruk on 02/04/2018
 ************************************************************************************/

class Settings_UserPlan_UserPlanAjax_View extends Settings_Vtiger_Index_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('ChangePlan');
		$this->exposeMethod('LoadRole');
	}
	
	public function process(Vtiger_Request $request) {
		
		$mode = $request->get('mode');
	
		if($this->isMethodExposed($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}else {
			//by default show field layout
			echo $this->ChangePlan($request);
			return;
		}
	}
	
	public function ChangePlan($request) {
		$qualifiedModuleName = $request->getModule(false);

		$viewer = $this->getViewer($request);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$username = $request->get('username');
		$plantitle = $request->get('plantitle');
		$viewer->assign('PLANS',Settings_UserPlan_Module_Model::getFilteredPlan());
		//$viewer->assign('ROLES', Settings_UserPlan_Module_Model::getAllRole());
		$viewer->assign('USERNAME',$username);
		$viewer->assign('PLANTITLE',$plantitle);
		$viewer->view('EditPlan.tpl', $qualifiedModuleName);
	}

	public function LoadRole($request) {
		
		$ROLES = Settings_UserPlan_Module_Model::getAllRole($request->get('planid'));

		 $response = new Vtiger_Response();
        try{
            $response->setResult(array('success'=>true,'roles'=>$ROLES));
        }catch(Exception $e){
            $response->setError($e->getCode(),$e->getMessage());
        }
        $response->emit();

	}
}

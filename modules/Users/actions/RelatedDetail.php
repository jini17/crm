<?php

class Users_RelatedDetail_Action extends Vtiger_Action_Controller {
	
	function checkPermission(Vtiger_Request $request) {
		return true;
	}

	function process(Vtiger_Request $request) {
		
		$record = $request->get('record');
		$moduleName = $request->getModule();
		$moduleModel = Users_Module_Model::getInstance($moduleName);

		$result = array();	
		$result = $moduleModel->getRelatedDetails($record);
		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
		
	}
}
?>
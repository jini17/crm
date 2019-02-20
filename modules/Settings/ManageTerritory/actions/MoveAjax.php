<?php
/*+***********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
 *************************************************************************************/

class Settings_ManageTerritory_MoveAjax_Action extends Settings_Vtiger_Basic_Action {

	public function preProcess(Vtiger_Request $request) {
		return;
	}

	public function postProcess(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		 $tree = $request->get('tree');
		 $parentTreeId = $request->get('parent_treeid');
		 $regionid = $request->get('regionid');		

		$parentTree = Settings_ManageTerritory_Record_Model::getdataInstanceById($regionid, $parentTreeId);
		$recordModel = Settings_ManageTerritory_Record_Model::getdataInstanceById($regionid, $tree);

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		try {	
			$recordModel->moveTo($parentTree);
		} catch (AppException $e) {
			$response->setError('Move Region Failed');
		}
		$response->emit();
	}
}

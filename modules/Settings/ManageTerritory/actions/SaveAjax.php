<?php
error_reporting(E_ALL & ~E_NOTICE);
/*+***********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
 *************************************************************************************/

class Settings_ManageTerritory_SaveAjax_Action extends Settings_Vtiger_Basic_Action {

	public function preProcess(Vtiger_Request $request) {
		return;
	}

	public function postProcess(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$regionname = $request->get('regionname');
		$subregionname = $request->get('subregionname');

		$mode = $request->get('mode');
		if(empty($mode)){
			$mode = "createregion";	
		}

		$regiontree = $request->get('regiontree');
		 $regionid = $request->get('regionid');

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		if($mode == 'createregion'){
			$newregionid = Settings_ManageTerritory_Record_Model::saveNewRegion($regionname);
			if(empty($newregionid)){
				$response->setError('Create Region Failed');
			}else{
				$response->setResult($newregionid);
			}
		}elseif($mode == 'savesubregion'){
			$result = Settings_ManageTerritory_Record_Model::saveSubRegion($subregionname, $regiontree, $regionid);
			if(!$result){
				$response->setError('Create Sub Region Failed');
			}else{
				$response->setResult($regionid);
			}
		}elseif($mode == 'deleteregion'){
			$result = Settings_ManageTerritory_Record_Model::deleteRegion($regionid);
			if(!$result){

				$response->setResult(array('msg'=>'Delete Failed'));
			}else{
				$response->setResult(array('msg'=>'Delete Sucessfull'));
			}
		}
		$response->emit();
	}
}

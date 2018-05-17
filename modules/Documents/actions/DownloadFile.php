<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Documents_DownloadFile_Action extends Vtiger_Action_Controller {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();

		if(!Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $request->get('record'))) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $moduleName));
		}
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		
		$documentRecordModel = Vtiger_Record_Model::getInstanceById($request->get('record'), $moduleName);
		//Download the file
		$response = $documentRecordModel->downloadFile();
		
		/*if($response=='Failure'){ 
		   $res = new Vtiger_Response();
		   $res->setResult('JS_FILE_NOT_FOUND');
		   $res->emit();
		} else {
		   $res = new Vtiger_Response();
		   $res->setResult('JS_FILE_FOUND');
		   $res->emit();
		}*/
		if($request->get('ajax')==11){
			//Update the Download Count
			$documentRecordModel->updateDownloadCount();
		}
	}
}

<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class EmailTemplates_Delete_Action extends Vtiger_Delete_Action {
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$record = $request->get('record');
        $currentUser = Users_Record_Model::getCurrentUserModel();
		$currentUserPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		
		if(!$currentUserPrivilegesModel->isPermitted($moduleName, 'Delete', $record) || !$currentUser->isAdminUser()) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}


	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$ajaxDelete = $request->get('ajaxDelete');
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$recordModel = EmailTemplates_Record_Model::getInstanceById($recordId);
		$response = new Vtiger_Response();

		if($recordModel->isSystemTemplate() || !$currentUser->isAdminUser() ) {
			$response->setError('502', vtranslate('LBL_NO_PERMISSIONS_TO_DELETE_SYSTEM_TEMPLATE', $moduleName));
			return $response;
		}	
		$moduleModel = $recordModel->getModule();

		$recordModel->delete($recordId);

		$listViewUrl = $moduleModel->getListViewUrl();
		
		if($ajaxDelete) {
			$response->setResult($listViewUrl);
		} else {
			header("Location: $listViewUrl");
		}
		return $response;
	}
}

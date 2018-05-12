<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_MultipleCompany_Delete_Action extends Vtiger_Delete_Action {

	public function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if(!$currentUser->isAdminUser()) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function process(Vtiger_Request $request) {
		$id_array = explode(';',$request->get('idlist'));
		$moduleModel = Settings_MultipleCompany_Detail_Model::getInstanceId($recordId);	
		$db = PearDatabase::getInstance();
		$isBusiness = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getSupportMultipleCompany();
		
		foreach($id_array as $key => $recordId) {
			if(!empty($recordId)) {
				$sql = "DELETE FROM vtiger_organizationdetails WHERE organization_id =?";
				$db->pquery($sql, array($recordId));
				$isBusiness = 0;
				Settings_MultipleCompany_Detail_Model::updateCustomNumbering($isBusiness,$recordId, 'CompanyDeletion');
			}
		}
		//replaced header location function with below one by jitu@Tar 
		$response = new Vtiger_Response();
		$response->setResult(array('success',true));
		$response->emit();
		//End here
	}
}
	

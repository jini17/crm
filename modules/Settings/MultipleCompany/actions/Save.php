<?php
/* ===================================================================
Modified By: Jitendra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 12 / 6 / 2014
Change Reason: Multiple Company Details , New file created
=================================================================== */
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
* 
 ********************************************************************************/
class Settings_MultipleCompany_Save_Action extends Vtiger_Action_Controller {
	
	public function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if(!$currentUser->isAdminUser()) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function process(Vtiger_Request $request) {
		$recordId = $request->get('organization_id');
		$qualifiedModuleName = $request->getModule(false);
		$moduleModel = Settings_MultipleCompany_Detail_Model::getInstanceId($recordId);
		
		$status = false;
		$saveLogo = 1;
		$logoSupportedFormats = array('jpeg', 'jpg', 'png', 'pjpeg', 'x-png');
        	if(!empty($_FILES['binFile']['name'])) {
	
			// Check for php code injection
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
		
			$filetypes = finfo_file($finfo, $_FILES['binFile']["tmp_name"]) ;
			finfo_close($finfo);
			
			$filetype = explode('/', $filetypes);
			if (!in_array($filetype[1],$logoSupportedFormats)) {
				$saveLogo = 0;
			}
			
			if ($saveLogo==1) {  
			    $moduleModel->saveLogo();
			}
		}
		
		if($saveLogo ==1) {
			$fields = $moduleModel->getFields();
			foreach ($fields as $fieldName => $fieldType) {
				$fieldValue = $request->get($fieldName);
				if ($fieldName === 'logoname') { 
					if (!empty($_FILES['binFile']['name'])) { 
						$fieldValue = ltrim(basename(" " . $_FILES['binFile']['name']));
					} else { 
						$fieldValue = $moduleModel->get($fieldName);
					}
					
				}
				$moduleModel->set($fieldName, $fieldValue);
			}
			$moduleModel->save();
		
			$reloadUrl = $moduleModel->getIndexViewUrl();
			//Update the Modnumbering for company 
			if($recordId =='') {
				$recordId = Settings_MultipleCompany_Detail_Model::getUniqueId();
				//Check System Support to Multiple Company Feature for Busines document.
				$isBusiness = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getSupportMultipleCompany();
				if($isBusiness == 1) {
					Settings_MultipleCompany_Detail_Model::updateCustomNumbering($isBusiness,$recordId,'AddCompany');
				} 		
			}
		
		}
		else {
			 $reloadUrl = $moduleModel->getEditViewUrl();
			 $reloadUrl .= '&organizationid='.$recordId.'&error=LBL_INVALID_IMAGE';
		} 
		header('Location: ' . $reloadUrl);
	}
}
?>

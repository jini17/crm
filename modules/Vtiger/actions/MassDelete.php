<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
require_once 'testAPI/vendor/autoload.php';

class Vtiger_MassDelete_Action extends Vtiger_Mass_Action {

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModuleActionPermission($moduleModel->getId(), 'Delete')) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}
	}

	function preProcess(Vtiger_Request $request) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		if($request->get('selected_ids') == 'all' && $request->get('mode') == 'FindDuplicates') {
			$recordIds = Vtiger_FindDuplicate_Model::getMassDeleteRecords($request);
		} else {
			$recordIds = $this->getRecordsListFromRequest($request);
		}
		$cvId = $request->get('viewname');
		foreach($recordIds as $recordId) { 
			if(Users_Privileges_Model::isPermitted($moduleName, 'Delete', $recordId)) {
				$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleModel);
				$recordModel->delete();
				deleteRecordFromDetailViewNavigationRecords($recordId, $cvId, $moduleName);

			//Added By Mabruk For Google Drive Integration on 28/03/2018 	
			if ($moduleName == 'Documents'){	
				global $adb;
				$result = $adb->pquery("SELECT filelocationtype FROM vtiger_notes WHERE notesid = ?",array($recordId));
				$filelocationtype = $adb->query_result($result,0,'filelocationtype'); 

				$result2 = $adb->pquery("SELECT path FROM vtiger_attachments LEFT JOIN vtiger_seattachmentsrel ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid LEFT JOIN vtiger_notes ON vtiger_seattachmentsrel.crmid = vtiger_notes.notesid WHERE vtiger_notes.notesid = ?",array($recordId));
				$fileId = $adb->query_result($result2,0,'path');
				if ($filelocationtype == 'G'){
					$client = Vtiger_Functions::getClient();
					$service = new Google_Service_Drive($client);
					$response = $service->files->delete($fileId);
				}
			}
			//End	
			}
		}
		$response = new Vtiger_Response();
		$response->setResult(array('viewname'=>$cvId, 'module'=>$moduleName));
		$response->emit();
	}
}

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

class Vtiger_Delete_Action extends Vtiger_Action_Controller {

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$record = $request->get('record');

		$currentUserPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPrivilegesModel->isPermitted($moduleName, 'Delete', $record)) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
		}

		if ($record) {
			$recordEntityName = getSalesEntityType($record);
			if ($recordEntityName !== $moduleName) {
				throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
			}
		}
	}

	
	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$ajaxDelete = $request->get('ajaxDelete');
		$recurringEditMode = $request->get('recurringEditMode');
		
		$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
		$recordModel->set('recurringEditMode', $recurringEditMode);
		$moduleModel = $recordModel->getModule();

		//Added By Mabruk for Google Drive Integration on 28/03/2018	
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
		//End Edit - Mabruk

		$recordModel->delete();
		$cv = new CustomView();
		$cvId = $cv->getViewId($moduleName);
		deleteRecordFromDetailViewNavigationRecords($recordId, $cvId, $moduleName);
		$listViewUrl = $moduleModel->getListViewUrl();
		if($ajaxDelete) {
			$response = new Vtiger_Response();
			$response->setResult($listViewUrl);
			return $response;
		} else {
			header("Location: $listViewUrl");
		}
	}

	public function validateRequest(Vtiger_Request $request) {
		$request->validateWriteAccess();
	}
}

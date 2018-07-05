<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Office365_List_View extends Vtiger_PopupAjax_View {

	protected $noRecords = false;

	public function __construct() {
		$this->exposeMethod('Contacts');
		$this->exposeMethod('Calendar');
	}

	function process(Vtiger_Request $request) {
		switch ($request->get('operation')) {
			case "sync" : $this->renderSyncUI($request);
				break;
			case "removeSync" : if($request->validateWriteAccess()){
									$this->deleteSync($request);
								}
				break;
			case "changeUser" :     $request->set('sourcemodule', 'Contacts');
									$this->deleteSync($request);
									$request->set('sourcemodule', 'Calendar');
									$this->deleteSync($request);
									$this->renderSyncUI($request);

									break;
			default: $this->renderWidgetUI($request);
				break;
		}
	}

	function renderWidgetUI(Vtiger_Request $request) {
		$sourceModule = $request->get('sourcemodule');
		$viewer = $this->getViewer($request);
		$oauth2 = new Office365_Oauth2_Connector($sourceModule);
		$firstime = $oauth2->hasStoredToken();
		$user = Users_Record_Model::getCurrentUserModel();
		$viewer->assign('MODULE_NAME', $request->getModule());
		$viewer->assign('FIRSTTIME', $firstime);
		$viewer->assign('STATE', 'home');
		$viewer->assign('SYNCTIME', Office365_Utils_Helper::getLastSyncTime($sourceModule));
		$viewer->assign('SOURCEMODULE', $request->get('sourcemodule'));
		$viewer->assign('SCRIPTS',$this->getHeaderScripts($request));
		$viewer->assign('SYNC_ENABLED', Office365_Utils_Helper::checkSyncEnabled($sourceModule, $user));
		$viewer->view('Contents.tpl', $request->getModule());
	}

	function renderSyncUI(Vtiger_Request $request) {

		$sourceModule = $request->get('sourcemodule');
		$viewer = $this->getViewer($request);
		$viewer->assign('SCRIPTS',$this->getHeaderScripts($request));
		$oauth2 = new Office365_Oauth2_Connector($sourceModule);
		
		if ($request->has('oauth_verifier')) {
			
			try {
				$oauth2->getHttpClient($sourceModule);
			} catch (Exception $e) {
				$viewer->assign('DENY', true);
			}
			$viewer->assign('MODULE_NAME', $request->getModule());
			$viewer->assign('STATE', 'CLOSEWINDOW');
			$viewer->view('Contents.tpl', $request->getModule());
		} else {

			if (!empty($sourceModule)) {
				try {
				
					$records = $this->invokeExposedMethod($sourceModule);
					
				} catch (Zend_Gdata_App_HttpException $e) {
					$errorCode = $e->getResponse()->getStatus();
					if($errorCode == 401) {
						$this->removeSynchronization($request);
						$response = new Vtiger_Response();
						$response->setError(401);
						$response->emit();
						return false;
					}
				}
			}
			$firstime = $oauth2->hasStoredToken();
			$viewer->assign('MODULE_NAME', $request->getModule());
			$viewer->assign('FIRSTTIME', $firstime);
			$viewer->assign('RECORDS', $records);
			$viewer->assign('NORECORDS', $this->noRecords);
			$viewer->assign('SYNCTIME', Office365_Utils_Helper::getLastSyncTime($sourceModule));
			$viewer->assign('STATE', $request->get('operation'));
			$viewer->assign('SOURCEMODULE', $request->get('sourcemodule'));

			if (!$firstime) {
				
				$viewer->view('Contents.tpl', $request->getModule());

			} else {
				echo $viewer->view('ContentDetails.tpl', $request->getModule(), true);
			}
		}
		
	}

	/**
	 * Sync Contacts Records 
	 * @return <array> Count of Contacts Records
	 */
	public function Contacts($userId = false) {
		if(!$userId)
			$user = Users_Record_Model::getCurrentUserModel();
		else {
			$user = new Users();
			$user = $user->retrieve_entity_info($userId, 'Users');
			$user = Users_Record_Model::getInstanceFromUserObject($user);
		}
		$controller = new Office365_Contacts_Controller($user);
		$syncDirection = Office365_Utils_Helper::getSyncDirectionForUser($user);
		$records = array();
		if(Office365_Utils_Helper::checkSyncEnabled('Contacts', $user)) {
			$records = $controller->synchronize(true,$syncDirection[0],$syncDirection[1],'Office365Contacts');
		}

		$syncRecords = $this->getSyncRecordsCount($records);
		$syncRecords['vtiger']['more'] = $controller->targetConnector->moreRecordsExits();
		$syncRecords['office365']['more'] = $controller->sourceConnector->moreRecordsExits();
		return $syncRecords;
	}

	/**
	 * Sync Calendar Records 
	 * @return <array> Count of Calendar Records
	 */
	public function Calendar($userId = false) {

		if(!$userId)
			$user = Users_Record_Model::getCurrentUserModel();
		else {
			$user = new Users();
			$user = $user->retrieve_entity_info($userId, 'Users');
			$user = Users_Record_Model::getInstanceFromUserObject($user);
		}


        $controller = new Office365_Calendar_Controller($user);

		$syncDirection = Office365_Utils_Helper::getSyncDirectionForUser($user,'Calendar');

		$records = array();
		if(Office365_Utils_Helper::checkSyncEnabled('Calendar', $user)) {
			$records = $controller->synchronize(true,$syncDirection[0],$syncDirection[1],'Office365Calendar');
		}
		$syncRecords = $this->getSyncRecordsCount($records);
		$syncRecords['vtiger']['more'] = $controller->targetConnector->moreRecordsExits();
		$syncRecords['office365']['more'] = $controller->sourceConnector->moreRecordsExits();
		return $syncRecords;
	}

	/**
	 * Removes Synchronization
	 */
	function removeSynchronization($request) {
		$sourceModule = $request->get('sourcemodule');
		$userModel = Users_Record_Model::getCurrentUserModel();
		Office365_Module_Model::removeSync($sourceModule, $userModel->getId());
	}

	function deleteSync($request) {
		$sourceModule = $request->get('sourcemodule');
		$userModel = Users_Record_Model::getCurrentUserModel();
		Office365_Module_Model::deleteSync($sourceModule, $userModel->getId());
	}

	/**
	 * Return the sync record added,updated and deleted count
	 * @param type $syncRecords
	 * @return array
	 */
	public function getSyncRecordsCount($syncRecords) { 
		$countRecords = array(	'vtiger'	=> array('update' => 0, 'create' => 0, 'delete' => 0),
								'office365'	=> array('update' => 0, 'create' => 0, 'delete' => 0));
		foreach ($syncRecords as $key => $records) {
			if ($key == 'push') {
				$pushRecord = false;
				if (count($records) == 0) {
					$pushRecord = true;
				}
				foreach ($records as $record) {
					foreach ($record as $type => $data) {
						if ($type == 'source') {
							if ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {
								$countRecords['vtiger']['update']++;
							} elseif ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_CREATE_MODE) {
								$countRecords['vtiger']['create']++;
							} elseif ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
								$countRecords['vtiger']['delete']++;
							}
						}
					}
				}
			} else if ($key == 'pull') {
				$pullRecord = false;
				if (count($records) == 0) {
					$pullRecord = true;
				}
				foreach ($records as $type => $record) {
					foreach ($record as $type => $data) {
						if ($type == 'target') {
							if ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_UPDATE_MODE) {
								$countRecords['office365']['update']++;
							} elseif ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_CREATE_MODE) {
								$countRecords['office365']['create']++;
							} elseif ($data->getMode() == WSAPP_SyncRecordModel::WSAPP_DELETE_MODE) {
								$countRecords['office365']['delete']++;
							}
						}
					}
				}
			}
		}

		if ($pullRecord && $pushRecord) {
			$this->noRecords = true;
		}
		return $countRecords;
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	public function getHeaderScripts(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		return $this->checkAndConvertJsScripts(array("~libraries/bootstrap/js/bootstrap-popover.js","modules.$moduleName.resources.List"));

	}

	public function validateRequest(Vtiger_Request $request) {
		//don't do validation because there is a redirection from office365
	}
}


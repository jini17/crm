<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
vimport('~~/include/Webservices/Custom/ChangePassword.php');

class Users_SaveAjax_Action extends Vtiger_SaveAjax_Action {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('userExists');
		$this->exposeMethod('validateSubscription');
		$this->exposeMethod('savePassword');
		$this->exposeMethod('restoreUser');
		$this->exposeMethod('transferOwner');
		$this->exposeMethod('changeUsername');
		$this->exposeMethod('changeAccessKey');
	}

	public function checkPermission(Vtiger_Request $request) {
		$currentUserModel = Users_Record_Model::getCurrentUserModel();

		$userId = $request->get('userid');
		if(!$currentUserModel->isAdminUser() && !in_array($currentUserModel->roleid, array('H2','H12','H13'))) {
			$mode = $request->getMode();
			if($mode == 'savePassword' && (isset($userId) && $currentUserModel->getId() != $userId)) {
				throw new AppException(vtranslate('LBL_PERMISSION_DENIED1', 'Vtiger'));
			} else if(in_array($mode, array('userExists','restoreUser','transferOwner','changeUsername'))) {
				throw new AppException(vtranslate('LBL_PERMISSION_DENIED2', 'Vtiger'));
			} else if($mode != 'savePassword' && ($currentUserModel->getId() != $request->get('record'))) {
				throw new AppException(vtranslate('LBL_PERMISSION_DENIED3', 'Vtiger'));
			}
		}
	}

	public function process(Vtiger_Request $request) {
		global $adb;
                                       //   $adb->setDebug(TRUE);
		$mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}

		//added by jitu@Birthday date format
		if($request->get('field')=='birthday'){
			$value = date('Y-m-d',strtotime($request->get('value')));
			$request->set($request->get('field'),$value);	
		}
		else if($request->get('field')=='date_joined'){
			$value = date('Y-m-d',strtotime($request->get('value')));
			$request->set($request->get('field'),$value);	
		}//end here	
		elseif($request->get('field')=='theme'){                 
                                              $request->set($request->get('field'),$request->get('value'));	
                                            }

                                     
		$recordModel = $this->saveRecord($request);

		$fieldModelList = $recordModel->getModule()->getFields();
		$result = array();
		foreach ($fieldModelList as $fieldName => $fieldModel) {
			$fieldValue = $displayValue = Vtiger_Util_Helper::toSafeHTML($recordModel->get($fieldName));
			if ($fieldModel->getFieldDataType() !== 'currency') {
				$displayValue = $fieldModel->getDisplayValue($fieldValue, $recordModel->getId());
			}
			if($fieldName == 'language') {
				$displayValue =  Vtiger_Language_Handler::getLanguageLabel($fieldValue);
			}
			if(($fieldName == 'currency_decimal_separator' || $fieldName == 'currency_grouping_separator') && ($displayValue == '&nbsp;')) {
				$displayValue = vtranslate('Space', 'Users');
			}
			$result[$fieldName] = array('value' => $fieldValue, 'display_value' => $displayValue);
		}

		$result['_recordLabel'] = $recordModel->getName();
		$result['_recordId'] = $recordModel->getId();

		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param Vtiger_Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	public function getRecordModelFromRequest(Vtiger_Request $request) {
		$recordModel = parent::getRecordModelFromRequest($request);
		$fieldName = $request->get('field');

		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if ($fieldName === 'is_admin' && (!$currentUserModel->isAdminUser() || !$request->get('value'))) {
			$recordModel->set($fieldName, 'off');
		}

		if($fieldName == "is_owner") {
			$recordId = $request->get('record');
			$moduleName = $request->getModule();
			if(!empty($recordId)) {
				$existingRecordModel =  Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
				$recordModel->set($fieldName,$existingRecordModel->get($fieldName));
			}
		}
		return $recordModel;
	}


	public function userExists(Vtiger_Request $request){
		$module = $request->getModule();
		$userName = $request->get('user_name');
		$roleid = $request->get('roleid');
		$status = Users_Record_Model::isUserExists($userName);
		$response = new Vtiger_Response();
		$response->setResult($status, $validate);
		$response->emit();
	}

	public function validateSubscription(Vtiger_Request $request){ 
		$module = $request->getModule();
		$roleid = $request->get('roleid');
		$validate = Users_Record_Model::isValidateUserSubscription($roleid);
		$response = new Vtiger_Response();
		$response->setResult($validate);
		$response->emit();
	}

	public function savePassword(Vtiger_Request $request) {
		$module = $request->getModule();
		$userModel = vglobal('current_user');
		$newPassword = $request->get('new_password');
		$oldPassword = $request->get('old_password');

		//Edited by jitu@28-04-2015 for password validation as per password setup		
		$checkPassword = Settings_Password_Record_Model::checkPassword($newPassword);
		$validity = Settings_Password_Record_Model::PasswordValidity('pwd_reuse',$request->get('userid'), $newPassword);
		if(!$checkPassword){
			if($validity !=1) {
				$wsUserId = vtws_getWebserviceEntityId($module, $request->get('userid'));
				$wsStatus = vtws_changePassword($wsUserId, $oldPassword, $newPassword, $newPassword, $userModel);		
			}
		} 
		
		$response = new Vtiger_Response();
		if ($checkPassword) {
			$response->setError($checkPassword,$checkPassword);
		} else if($validity==1) {
			$response->setError(vtranslate('LBL_CANT_USE_EXIST_PWD', 'Users'));
		} elseif($wsStatus['message']) {
			$response->setResult($wsStatus);
			/*
			$oldPassword = strtolower(md5($oldPassword));
			$newPassword = strtolower(md5($newPassword));
			if ($currentUserModel->isAdminUser()) {
				$oldPassword = Users_Record_Model::getUserCurrentPassword($request->get('userid'));
			}	
			$response->setResult($wsStatus);
			$finalarray = array();
			$finalarray['mode'] = 'CP';
			$finalarray['id'] = $request->get('userid');
	 		$finalarray['user_password'] = array('oldval'=>$oldPassword,'newval'=>$newPassword);
			$em = new VTEventsManager($db);		
			$em->triggerEvent('vtiger.users.changepassword', $finalarray);
			*/
		} else {
			//$response->setError(vtranslate('LBL_PASSWORD_INCORRECT_NEW','Users'));
			$response->setError('JS_PASSWORD_INCORRECT_OLD', 'JS_PASSWORD_INCORRECT_OLD');
		}
		//End here
		$response->emit();
	}

		/*
		 * To restore a user
		 * @param Vtiger_Request Object
		 */
		public function restoreUser(Vtiger_Request $request) {
			$moduleName = $request->getModule();
			$record = $request->get('userid');

			$recordModel = Users_Record_Model::getInstanceById($record, $moduleName);
				$recordModel->set('status', 'Active');
				$recordModel->set('id', $record);
				$recordModel->set('mode', 'edit');
				$recordModel->save();

				$db = PearDatabase::getInstance();
				$db->pquery("UPDATE vtiger_users SET deleted=? WHERE id=?", array(0,$record));

				$userModuleModel = Users_Module_Model::getInstance($moduleName);
				$listViewUrl = $userModuleModel->getListViewUrl();

			$response = new Vtiger_Response();
			$response->setResult(array('message'=>vtranslate('LBL_USER_RESTORED_SUCCESSFULLY', $moduleName), 'listViewUrl' => $listViewUrl));
			$response->emit();
		}

	/*
	 * Function to transfer CRM owner without deleting User
	 */
	public function transferOwner(Vtiger_Request $request) {
		$moduleName = $request->getModule(false);
		$record = $request->get('record');
		$usersInstance = CRMEntity::getInstance($moduleName);
		$status = $usersInstance->transferOwnership($record);
		$response = new Vtiger_Response();
		if($status) {
			$response->setResult(array('message' => vtranslate('LBL_OWNERSHIP_TRANSFERRED_SUCCESSFULLY', $moduleName)));
		} else {
			$response->setError(vtranslate('LBL_OWNERSHIP_TRANSFERRED_FAILED', $moduleName));
		}
		$response->emit();
	}

	/**
	 * Function to change username
	 */
	public function changeUsername(Vtiger_Request $request) {
		$response = new Vtiger_Response();
		$userId = $request->get('userid');

		$status = Users_Record_Model::changeUsername($request->get('newUsername'), $request->get('newPassword'), $request->get('oldPassword'), $userId);
		if($status['success']) {
			$response->setResult($status['message']);
		}else{
			$response->setError($status['message']);
		}
		$response->emit();
	}

	public function changeAccessKey(Vtiger_Request $request) {
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$response = new Vtiger_Response();
		try {
			$recordModel = Users_Record_Model::getInstanceById($recordId, $moduleName);
			 $oldAccessKey = $recordModel->get('accesskey');

			$entity = $recordModel->getEntity();
			$entity->createAccessKey();

			require_once('modules/Users/CreateUserPrivilegeFile.php');
			createUserPrivilegesfile($recordId);
			//Vtiger_AccessControl::clearUserPrivileges($recordId);
			//$recordModel = Users_Record_Model::getInstanceFromPreferenceFile($recordId);
			//$newAccessKey = $recordModel->get('accesskey');

			$recordModel = Users_Record_Model::getInstanceById($recordId, $moduleName);
			$newAccessKey = $recordModel->get('accesskey');
			
			if ($newAccessKey != $oldAccessKey) {
				$response->setResult(array('success' => true, 'message' => vtranslate('LBL_ACCESS_KEY_UPDATED_SUCCESSFULLY', $moduleName), 'accessKey' => $newAccessKey));
			} else {
				$response->setError(vtranslate('LBL_FAILED_TO_UPDATE_ACCESS_KEY', $moduleName));
			}
		} catch (Exception $ex) {
			$response->setError($ex->getMessage());
		}
		$response->emit();
	}
}

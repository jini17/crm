<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Office365_Setting_View extends Vtiger_PopupAjax_View {

	public function __construct() {
		$this->exposeMethod('emitContactSyncSettingUI');
	}

	public function process(Vtiger_Request $request) {
		switch ($request->get('sourcemodule')) {
			case "Contacts" : $this->emitContactsSyncSettingUI($request);
				break;
			case "Calendar" : $this->emitCalendarSyncSettingUI($request);
				break;
		}
	}

	public function emitCalendarSyncSettingUI(Vtiger_Request $request) {
		$user = Users_Record_Model::getCurrentUserModel();
		$connector = new Office365_Contacts_Connector(FALSE);
		$oauth2 = new Office365_Oauth2_Connector($request->get('sourcemodule'));
		$isSyncReady = 'no';
		$selectedOffice365Calendar = Office365_Utils_Helper::getSelectedCalendarForUser($user);
		if($oauth2->hasStoredToken()) {
			$controller = new Office365_Calendar_Controller($user);
			$connector = $controller->getTargetConnector();
			try {
				$calendars = $connector->pullCalendars();
				$validCalendarSelected = false;
				foreach($calendars as $calendarsDetails) {
					if($calendarsDetails['id'] == $selectedOffice365Calendar || $selectedOffice365Calendar == 'primary')
						$validCalendarSelected = true;
				}
				if(!$validCalendarSelected) $selectedOffice365Calendar = 'primary';
				$isSyncReady = 'yes';
			} catch(Exception $e) {
				$calendars = array();
				$selectedOffice365Calendar = 'primary';
			}
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULENAME', $request->getModule());
		$viewer->assign('SOURCE_MODULE', $request->get('sourcemodule'));
		$viewer->assign('OFFICE365_CALENDARS', $calendars);
		$viewer->assign('SELECTED_OFFICE365_CALENDAR', $selectedOffice365Calendar);
		$viewer->assign('SYNC_DIRECTION',Office365_Utils_Helper::getSyncDirectionForUser($user, $request->get('sourcemodule')));
		$viewer->assign('IS_SYNC_READY',$isSyncReady);

		echo $viewer->view('CalendarSyncSettings.tpl', $request->getModule(), true);
	}

	public function emitContactsSyncSettingUI(Vtiger_Request $request) {
	   echo $this->intializeContactsSyncSettingParameters($request);
	}

	public function intializeContactsSyncSettingParameters(Vtiger_Request $request) {
		
		$user = Users_Record_Model::getCurrentUserModel();
		$connector = new Office365_Contacts_Connector(FALSE);
		$fieldMappping = Office365_Utils_Helper::getFieldMappingForUser();
		$oauth2 = new Office365_Oauth2_Connector($request->get('sourcemodule'));
		$isSyncReady = 'no';
		if($oauth2->hasStoredToken()) {
			$controller = new Office365_Contacts_Controller($user);
			$connector = $controller->getTargetConnector();
			
			$groups = $connector->pullGroups();
			$isSyncReady = 'yes';
		}
		$targetFields = $connector->getFields();
		$selectedGroup = Office365_Utils_Helper::getSelectedContactGroupForUser();
		$syncDirection = Office365_Utils_Helper::getSyncDirectionForUser($user);
		$contactsModuleModel = Vtiger_Module_Model::getInstance($request->get('sourcemodule'));
		$mandatoryMapFields = array('salutationtype','firstname','lastname','title','account_id','birthday',
			'email','secondaryemail','mobile','phone','homephone','mailingstreet','otherstreet','mailingpobox',
			'otherpobox','mailingcity','othercity','mailingstate','otherstate','mailingzip','otherzip','mailingcountry',
			'othercountry','otheraddress','description','mailingaddress','otheraddress');
		$customFieldMapping = array();
		$contactsFields = $contactsModuleModel->getFields();
		foreach($fieldMappping as $vtFieldName => $office365FieldDetails) {
			if(!in_array($vtFieldName, $mandatoryMapFields) && ($contactsFields[$vtFieldName] && $contactsFields[$vtFieldName]->isViewable()))
				$customFieldMapping[$vtFieldName] = $office365FieldDetails;
		}
		$skipFields = array('reference','contact_id','leadsource','assigned_user_id','donotcall','notify_owner',
			'emailoptout','createdtime','modifiedtime','contact_no','modifiedby','isconvertedfromlead','created_user_id',
			'portal','support_start_date','support_end_date','imagename');
		$emailFields = $phoneFields = $urlFields = $otherFields = array();
		$disAllowedFieldTypes = array('reference','picklist','multipicklist');
		$sourceModule = $request->get('sourcemodule');
		foreach($contactsFields as $contactFieldModel) {
			if($contactFieldModel->isEditable() && !in_array($contactFieldModel->getFieldName(),array_merge($mandatoryMapFields,$skipFields))) {
				if($contactFieldModel->getFieldDataType() == 'email')
					$emailFields[$contactFieldModel->getFieldName()] = decode_html(vtranslate($contactFieldModel->get('label'), $sourceModule));
				else if($contactFieldModel->getFieldDataType() == 'phone') 
					$phoneFields[$contactFieldModel->getFieldName()] = decode_html(vtranslate($contactFieldModel->get('label'), $sourceModule));
				else if($contactFieldModel->getFieldDataType() == 'url')
					$urlFields[$contactFieldModel->getFieldName()] = decode_html(vtranslate($contactFieldModel->get('label'), $sourceModule));
				else if(!in_array ($contactFieldModel->getFieldDataType(), $disAllowedFieldTypes))
					$otherFields[$contactFieldModel->getFieldName()] = decode_html(vtranslate($contactFieldModel->get('label'), $sourceModule));
			}
		}

		$viewer = $this->getViewer($request);
		if($request->get('onlyOffice365ToVtiger')) {
			$viewer->assign('ONLY_OFFICE365_TO_VTIGER', true);
		}
		$viewer->assign('MODULENAME', 'Office365');
		$viewer->assign('SOURCE_MODULE', $request->get('sourcemodule'));
		$viewer->assign('SELECTED_GROUP', $selectedGroup);
		$viewer->assign('SYNC_DIRECTION', $syncDirection);
		$viewer->assign('OFFICE365_GROUPS', $groups);
		$viewer->assign('OFFICE365_FIELDS',$targetFields);
		$viewer->assign('FIELD_MAPPING',$fieldMappping);
		$viewer->assign('CUSTOM_FIELD_MAPPING',$customFieldMapping);
		$viewer->assign('VTIGER_EMAIL_FIELDS',$emailFields);
		$viewer->assign('VTIGER_PHONE_FIELDS',$phoneFields);
		$viewer->assign('VTIGER_URL_FIELDS',$urlFields);
		$viewer->assign('VTIGER_OTHER_FIELDS',$otherFields);
		$viewer->assign('IS_SYNC_READY',$isSyncReady);
		$onlyContents = $request->get('onlyContents');
		if($request->get('mode') == 'office365Import'){
			return $viewer->view('Office365ImportContents.tpl','Office365',true);
		}
		if($onlyContents){
			return $viewer->view('ContactSyncSettingsContents.tpl', 'Office365', true);
		}else{
			return $viewer->view('ContactsSyncSettings.tpl', 'Office365', true);
		}
	}

}

?>
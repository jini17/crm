<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Office365_Index_View extends Vtiger_ExtensionViews_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('settings');
	}

	function getUserEmail() {
		$user = Users_Record_Model::getCurrentUserModel();		
		$oauth2 = new Office365_Oauth2_Connector('Contacts');
		if($oauth2->hasStoredToken()) {
			$controller = new Office365_Contacts_Controller($user);
			$connector = $controller->getTargetConnector();
			$profileInfo = json_decode($connector->getUserProfileInfo(),true);
		}
		return $profileInfo['email'];
	}

	/**
	 * Function to check if sync is ready
	 * @return <boolean> true/false
	 */
	function checkIsSyncReady() {

		
		$oauth2 = new Office365_Oauth2_Connector('Contacts');
		
		$isSyncReady = false;
		if($oauth2->hasStoredToken()) {
			$isSyncReady = true;
		
		}

		return $isSyncReady;
	}

	function Settings(Vtiger_Request $request) {
		
		
		
		$user = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);
		$moduleName = $request->get('extensionModule');
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
	
		$oauth2 = new Office365_Oauth2_Connector('Contacts');
		$isSyncReady = false;
		
		if($oauth2->hasStoredToken()) {	
			
			$controller = new Office365_Contacts_Controller($user);
			$connector = $controller->getTargetConnector();
			
			try { 
				$contactGroups = $connector->pullGroups();
				
				
			} catch(Exception $e) {
				
				$contactGroups = array();
			}
			$isSyncReady = true;
		}
		
		$oauth2 = new Office365_Oauth2_Connector('Calendar');
	
		$selectedOffice365Calendar = Office365_Utils_Helper::getSelectedCalendarForUser($user);
	
		if($oauth2->hasStoredToken()) { 
			
			$controller = new Office365_Calendar_Controller($user);
			
			$connector = $controller->getTargetConnector(); //echo "<pre>";print_r($connector);die;
			$validCalendarSelected = false;
			
			try { 
				$calendars = $connector->pullCalendars();
				foreach($calendars as $calendarsDetails) {
					if($calendarsDetails['id'] == $selectedOffice365Calendar || $selectedOffice365Calendar == 'primary')
						$validCalendarSelected = true; 
				}
			} catch(Exception $e) {
				$calendars = array();
			}
			if(!$validCalendarSelected) $selectedOffice365Calendar = 'primary'; 
		}
		
		
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('SOURCEMODULE', $request->getModule());
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('CONTACTS_ENABLED', Office365_Utils_Helper::checkSyncEnabled('Contacts'));
		$viewer->assign('CALENDAR_ENABLED', Office365_Utils_Helper::checkSyncEnabled('Calendar'));
		$viewer->assign('SELECTED_CONTACTS_GROUP', Office365_Utils_Helper::getSelectedContactGroupForUser());
		$viewer->assign('OFFICE365_CONTACTS_GROUPS', $contactGroups);
		$viewer->assign('SELECTED_OFFICE365_CALENDAR', $selectedOffice365Calendar);
		$viewer->assign('OFFICE365_CALENDARS', $calendars);
		$viewer->assign('CONTACTS_SYNC_DIRECTION', Office365_Utils_Helper::getSyncDirectionForUser());
		$viewer->assign('CALENDAR_SYNC_DIRECTION', Office365_Utils_Helper::getSyncDirectionForUser(false, 'Calendar'));
		$viewer->assign('IS_SYNC_READY', $isSyncReady);
		$viewer->assign('USER_EMAIL', $this->getUserEmail());
		$viewer->assign('PARENT', $request->get('parent'));
		$viewer->view('ExtensionSettings.tpl', $moduleName);
	
	}
}
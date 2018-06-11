<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Calendar_CalendarActions_Action extends Vtiger_BasicAjax_Action {

	function __construct() {
		$this->exposeMethod('fetchAgendaViewEventDetails');
		$this->exposeMethod('updateMOMContent');
		$this->exposeMethod('sendAgendaOrMOM');
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if (!empty($mode) && $this->isMethodExposed($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	//Added By Mabruk For Meeting MOM
	public function updateMOMContent(Vtiger_Request $request) {
		$result = array();
		$data = $request->get('content');	
		$moduleName = $request->getModule();
       // echo "<pre>"; print_r($data); die;
		global $adb;		
		$result = $adb->pquery("UPDATE vtiger_activitycf SET min_meeting = ? WHERE activityid = ?", array($data, $request->get('id')));

		$response = new Vtiger_Response();
		$response->setResult($data);
		$response->emit();
	}

	//Added By Mabruk For Sending Emails
	public function sendAgendaOrMOM(Vtiger_Request $request) {
		require_once('modules/Emails/mail.php');
		require_once('modules/Emails/Emails.php');
		$emails = $request->get('emails');
		$body = $request->get('body');
		$subject = $request->get('subject');
		$contentType = $request->get('contentType');
		
		$subject = $contentType . " for " . $subject;
		//Email Details using PHPMailer with attachment
		$vtigerMailer = new PHPMailer();
		$vtigerMailer->IsSMTP();
		$vtigerMailer->Host = 'mail.secondcrm.com';
		$vtigerMailer->Port = '587';
		$vtigerMailer->SMTPAuth = true;
		$vtigerMailer->Username = 'mabruk@secondcrm.com';
		$vtigerMailer->Password = 'quintiq123@';
		$vtigerMailer->SMTPDebug  = 0;
		$vtigerMailer->IsHTML(true); 
		$vtigerMailer->AddAddress($emails);		
		$vtigerMailer->From='support@agiliux';
		$vtigerMailer->FromName="Agiliux";
		$vtigerMailer->Subject = $subject;		
		$vtigerMailer->Body = $body;

		foreach ($emails as $email) {
			$vtigerMailer->AddAddress($email);
		//	echo $email;
		}
		//$vtigerMailer->AddAddress("mabruk@secondcrm.com");
		$vtigerMailer->Send();		
	}

	public function fetchAgendaViewEventDetails(Vtiger_Request $request) {
		$result = array();
		$eventId = $request->get('id');
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance('Events');
		$recordModel = Events_Record_Model::getInstanceById($eventId);

		$result[vtranslate('Assigned To')] = getUserFullName($recordModel->get('assigned_user_id'));
		if ($recordModel->get('priority')) {
			$result[vtranslate('Priority', $moduleName)] = $recordModel->get('priority');
		}
		if ($recordModel->get('location')) {
			$result[vtranslate('Location', $moduleName)] = $recordModel->get('location');
		}
		if ($recordModel->get('contact_id')) {
			$contact_id = Vtiger_Field_Model::getInstance('contact_id', $moduleModel);
			$result[vtranslate($contact_id->get('label'), $moduleName)] = $contact_id->getDisplayValue($recordModel->get('contact_id'));
		}
		if ($recordModel->get('parent_id')) {
			$parent_id = Vtiger_Field_Model::getInstance('parent_id', $moduleModel);
			$result[vtranslate($parent_id->get('label'), $moduleName)] = $parent_id->getDisplayValue($recordModel->get('parent_id'));
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}

}

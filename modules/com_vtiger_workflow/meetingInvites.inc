<?php
//Created By Mabruk for Meeting MOM
/*error_reporting(1);
ini_set('display_erros',1);
  
  register_shutdown_function('handleErrors');        
    function handleErrors() {  
          
       $last_error = error_get_last();  
      
       if (!is_null($last_error)) { // if there has been an error at some point  
      
          // do something with the error  
          print_r($last_error);  
      
       }  
      
    } */
include 'config.inc.php';
require_once('modules/Emails/mail.php');
require_once('modules/Emails/Emails.php');


function meetingInvites($entity) {
	global $adb, $log,$current_user,$site_URL;
	//$adb->setDebug(true);
	$entityArray 		= get_object_vars($entity);
	echo "<pre>"; print_r($entityArray); die();
	$idArray 		= explode('x',$entityArray['data']['id']);


	/*****************Edited By Mabruk**************************/
	//echo "<pre>";print_r($entityArray['data']);die();
	$id = $idArray[1];				
	//echo $entity->getModuleName();
	//echo $id;

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
	$vtigerMailer->From='support@agiliux.com';
	$vtigerMailer->FromName="Agiliux";
	$vtigerMailer->Subject = 'Meeting Invites';	

	$fieldValues = $entityArray['data'];
	$today = date('d-m-Y');
	$meetingDate = date("d-m-Y",strtotime($fieldValues['date_start']));
	//Boolean Variable send for checking if Today is less than Meeting Date or not
	$send = $today < $meetingDate || $today == $meetingDate;	
	$status = '';
	$emails = array();
	
	global $adb;
	$adb->setDebug(true);
	$result = $adb->pquery("SELECT vtiger_contactdetails.contactid AS contactid, CONCAT(firstname,' ',lastname) AS name, email FROM vtiger_contactdetails LEFT JOIN vtiger_cntactivityrel ON vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid WHERE vtiger_cntactivityrel.activityid = ?", array($id));
	$numOfRows = $adb->num_rows($result);

	if ($numOfRows > 0) {
		for ($i = 0; $i < $numOfRows; $i++){
			$name = $adb->query_result($result,$i,'name');
			$email = $adb->query_result($result,$i,'email');
			$contactid = $adb->query_result($result,$i,'contactid');
			$contactResult = $adb->pquery("SELECT status FROM contact_invite_details WHERE contactid = ? AND activityid = ?", array($contactid, $id));		
			$rows = $adb->num_rows($contactResult);

			if ($rows == 0)
				$adb->pquery("INSERT INTO contact_invite_details VALUES (?,?,'Sent','Contacts')", array($id,$contactid));
			else 
				$status = $adb->query_result($contactResult,0,'status');

			$accept = "
			&nbsp;<a href=" . $site_URL . "meetingInvite.php?status=Accepted&contactid=$contactid&activityid=$id&type=contact style='text-decoration:none'><input type='submit' value='Accept'></a>
			";

			$decline = "
				&nbsp;<a href=" . $site_URL . "meetingInvite.php?status=Declined&contactid=$contactid&activityid=$id&type=contact style='text-decoration:none'><input type='submit' value='Decline'></a>
			";
				   
		    $content = 'Dear ' . $name .'<br><br>
		    	You are invited to the following meeting: ' . $fieldValues['subject'] . '<br>' . $accept . '&nbsp;' . $decline;

		    if ($send && $status != 'Accepted' && $status != 'Declined')	{
			    $vtigerMailer->ClearAddresses();	
			    $vtigerMailer->AddAddress($email);	
			    $vtigerMailer->Body = $content;
			    $vtigerMailer->Send();
			}    
		}
	}	

	$result2 = $adb->pquery("SELECT CONCAT(first_name, ' ', last_name) AS name, inviteeid, email1, vtiger_invitees.status FROM vtiger_users LEFT JOIN vtiger_invitees ON vtiger_invitees.inviteeid = vtiger_users.id WHERE vtiger_invitees.activityid = ?", array($id));
	$numOfRows2 = $adb->num_rows($result2);	

	if ($numOfRows2 > 0) {
		for ($i = 0; $i < $numOfRows2; $i++){
			$name = $adb->query_result($result2,$i,'name');
			$email = $adb->query_result($result2,$i,'email1');
			$userid = $adb->query_result($result2,$i,'inviteeid');
			$status = $adb->query_result($result2,$i,'status');
			

			$accept = "
			&nbsp;<a href=" . $site_URL . "meetingInvite.php?status=Accepted&userid=$userid&activityid=$id&type=user style='text-decoration:none'><input type='submit' value='Accept'></a>
			";

			$decline = "
				&nbsp;<a href=" . $site_URL . "meetingInvite.php?status=Declined&userid=$userid&activityid=$id&type=user style='text-decoration:none'><input type='submit' value='Decline'></a>
			";
				   
		    $content = 'Dear ' . $name .'<br><br>
		    	You are invited to the following meeting: ' . $fieldValues['subject'] . '<br>' . $accept . '&nbsp;' . $decline;	

		    if ($send && $status != 'Accepted' && $status != 'Declined')	{
			    $vtigerMailer->ClearAddresses();	
			    $vtigerMailer->AddAddress($email);	
			    $vtigerMailer->Body = $content;
			    $vtigerMailer->Send();
			}		    		
		}
	}

	//Insert Subject into agenda if Agenda field is empty
	if ($fieldValues['agenda'] == '' || $fieldValues['agenda'] == null) {
		$agenda = "<b>Subject: </b>" . $fieldValues['subject'];
		$adb->pquery("UPDATE vtiger_activitycf SET agenda = ? WHERE activityid = ?", array($agenda,$id));
	}

}
/**********************************Edit Done***************************/




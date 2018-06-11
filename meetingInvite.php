<?php
	require('config.inc.php');
	require_once('include/utils/utils.php');
	require_once('modules/Calendar/Calendar.php');
	require_once('modules/Contacts/Contacts.php');
	require_once('modules/Users/Users.php');
	/*error_reporting(1);
		ini_set('display_erros',1);

		  register_shutdown_function('handleErrors');
		    function handleErrors() {

		       $last_error = error_get_last();

		       if (!is_null($last_error)) { // if there has been an error at some point

			  // do something with the error
			  print_r($last_error);

		       }

		    }*/

	//Update Meeting Status based on the Request	    
	global $adb;
	//$adb->setDebug(true);
	if (isset($_REQUEST)) {
		$status = $_REQUEST['status'];
		$type = $_REQUEST['type'];

		if ($type == 'user')
			$adb->pquery("UPDATE vtiger_invitees SET status = ? WHERE activityid = ? AND inviteeid = ?",array($_REQUEST['status'], $_REQUEST['activityid'], $_REQUEST['userid']));	
		else
			$adb->pquery("UPDATE contact_invite_details SET status = ? WHERE activityid = ? AND contactid = ?",array($_REQUEST['status'], $_REQUEST['activityid'], $_REQUEST['contactid']));			
	}

	echo "Thanks for your response."

?>
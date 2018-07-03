<?php
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
require_once 'include/utils/utils.php';
require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
$adb->setDebug(true);
$emm = new VTEntityMethodManager($adb); 

//$emm->addEntityMethod("Module Name","Label", "Path to file" , "Method Name" );
$emm->addEntityMethod("Events", "Send Meeting Invites", "modules/com_vtiger_workflow/meetingInvites.inc", "meetingInvites");
//$emm->removeEntityMethod('Calendar', 'Send Meeting Invites');

?>

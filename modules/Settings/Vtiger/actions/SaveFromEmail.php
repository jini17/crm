<?php
/* ===================================================================
Created By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Edited By: Muhammad Afiq Bin Azmi (afiq@secondcrm.com)
Modified Date: 6 / 16 / 2014
Change Reason: Multiple Email Details Feature, File modified
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the SecondCRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is SecondCRM.
 * Portions created by SecondCRM are Copyright (C) SecondCRM.
 * All Rights Reserved.
* 
 ********************************************************************************/

$adb = PearDatabase::getInstance();
$saveflag="true";
if($saveflag=="true")
{		
	$name=from_html($_REQUEST['name']);
	$email=from_html($_REQUEST['email']);
	$id=from_html($_REQUEST['id']);
	

	if($_REQUEST['id'] > 0)
		
		$sSql = "select * from vtiger_multiplefromaddress where email='".$email."' and id != '".$_REQUEST['id']."'";
		
	else

		$sSql = "select * from vtiger_multiplefromaddress where email='".$email."'";
		
	$result = $adb->pquery($sSql, array());
	if($adb->num_rows($result) > 0)
	{
		
		$error_str = 'from_mail_error=Email Id '.$email.' already exists';
		$action = 'EmailConfig';
		
		header("Location: index.php?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=4&fieldid=15");
	}
	else
	{
		if($_REQUEST["id"] <= 0)
		{
	
			$sql11="SELECT id FROM vtiger_multiplefromaddress";
			$result11 = $adb->pquery($sql11, array());
			
			if($adb->num_rows($result11) <= 0)
			{

				$sql3 = "INSERT INTO vtiger_multiplefromaddress (name, email) values (?, ?)";				
				$params3 = array($name, $email);
				
			}
			else
			{
				$sql3 = "INSERT INTO vtiger_multiplefromaddress (name, email) values (?, ?)";
				$params3 = array($name, $email);
				
			}									
		}
		else
		{

			$sql3 = "UPDATE vtiger_multiplefromaddress SET name= ?, email = ? WHERE id=?";
			$params3 = array($name, $email, $_REQUEST["id"]);
			
		}
		$adb->pquery($sql3, $params3);	
		header("Location: index.php?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=4&fieldid=15");
	}
}	
?>


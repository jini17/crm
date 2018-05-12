<?php
/* ===================================================================
Created By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Edited By: Muhammad Afiq Bin Azmi (afiq@secondcrm.com)
Modified Date: 6 / 16 / 2014
Change Reason: Multiple Email Details Feature, File modified
=================================================================== */

/*+********************************************************************************
 * The contents of this file are subject to the SecondCRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is SecondCRM.
 * Portions created by SecondCRM are Copyright (C) SecondCRM.
 * All Rights Reserved.
 ********************************************************************************/

$idlist = $_REQUEST['idlist'];
$id_array=explode(';', $idlist);

$adb = PearDatabase::getInstance();

for($i=0;$i < count($id_array)-1;$i++) {
	$sql = "delete from vtiger_multiplefromaddress where id =?";
	$adb->pquery($sql, array($id_array[$i]));
}

header("Location:index.php?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=4&fieldid=15");

?>

<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Claim_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_claim';
	var $baseIndex = 'claimid';
	var $listFields = array('claimno' => 'Claim No','transactiondate'=>'Transcation Date','claim_status'=>'Status', 'attachment'=>'Attachment'	,'totalamount'=>'Total Amount', 'category'=>'Claim Type');
	var $nameFields = array('claimno');
	var $name = 'Claim';

	public function getCreateRecordUrl() {
		return "index.php?module=Claim&parent=Settings&view=Edit";
	}

}
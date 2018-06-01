<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_ClaimType_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_claimtype';
	var $baseIndex = 'claimtypeid';
	var $listFields = array('claim_type' => 'Claim Type', 'claim_code' => 'Claim Code', 'color_code' =>'Color Code');
	var $nameFields = array('claim_type');
	var $name = 'Claim Type';

	public function getCreateRecordUrl() {
		return "javascript:Settings_ClaimType_List_Js.triggerAdd(event)";
	}

}
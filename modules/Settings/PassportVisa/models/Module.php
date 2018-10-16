<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_PassportVisa_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_passportvisa';
	var $baseIndex = 'passportvisaid';
	var $listFields = array('ppvisatitle' => 'Passport No','smownerid'=>'Passport Name','pp_status'=>'Passport Status', 'visa_type'=>'Visa Type');
	var $nameFields = array('ppvisatitle');
	var $name = 'PassportVisa';

	public function getCreateRecordUrl() {
		return "index.php?module=PassportVisa&parent=Settings&view=Edit";
	}

}
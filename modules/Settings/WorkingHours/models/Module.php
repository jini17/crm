<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_WorkingHours_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_workinghours';
	var $baseIndex = 'workinghoursid';
	var $listFields = array('whno' => 'ID','whtitle'=>'Title','wh_status'=>'Status');
	var $nameFields = array('whtitle');
	var $name = 'WorkingHours';

	public function getCreateRecordUrl() {
		return "index.php?module=WorkingHours&parent=Settings&view=Edit";
	}

}
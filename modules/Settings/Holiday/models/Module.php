<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Holiday_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_holiday';
	var $baseIndex = 'holidayid';
	var $listFields = array('holiday_id'=>'Holiday Id','holiday_name' => 'Holiday Name','start_date'=>'Start Date','end_date'=>'End Date', 'location'=>'Location');
	var $nameFields = array('holiday_name');
	var $name = 'Holiday';

	public function getCreateRecordUrl() {
		return "index.php?module=Holiday&parent=Settings&view=Edit";
	}

}
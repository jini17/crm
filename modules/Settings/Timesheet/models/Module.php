<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_TimeSheet_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_timesheet';
	var $baseIndex = 'timesheetid';
	var $listFields = array('tsno' => 'Timesheet No','date'=>'Date', 'description' => 'Description', 'timestart'=>'Time Start', 'timeend'=>'Time End', 'tstype '=>'Type');
	var $nameFields = array('tsno');
	var $name = 'Timesheet';

	public function getCreateRecordUrl() {
		return "index.php?module=Timesheet&parent=Settings&view=Edit";
	}

}
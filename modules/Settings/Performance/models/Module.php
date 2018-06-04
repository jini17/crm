<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Performance_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_performance';
	var $baseIndex = 'performanceid';
	var $listFields = array('yearly_review' => 'Yearly Review','quarterly_review'=>'Quarterly Review', 'responsibility' => 'Responsibility', 'employee_remarks'=>'Employee Remarks', 'superior_remarks'=>'	Superior Remarks','smownerid'=>'Assigned User');
	var $nameFields = array('yearly_review');
	var $name = 'Performance';

	public function getCreateRecordUrl() {
		return "index.php?module=Performance&parent=Settings&view=Edit";
	}

}
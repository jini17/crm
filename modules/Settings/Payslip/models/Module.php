<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Payslip_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_payslip';
	var $baseIndex = 'palyslipid';
	var $listFields = array('payslipno' => 'PaySlip No', 'emp_name' => 'Employee Name','basic_sal'=>'Basic Salary','total_deduction'=>'Total Deduction', 'gross_pay'=>'Gross Pay','net_pay'=>'Net Pay');
	var $nameFields = array('payslipno');
	var $name = 'Payslip';

	public function getCreateRecordUrl() {
		return "index.php?module=Payslip&parent=Settings&view=Edit";
	}

}
?>
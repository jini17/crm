<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Quotes Record Model Class
 */
class Payslip_Record_Model extends Inventory_Record_Model {

	
	/**
	 * Function to get this record and details as PDF
	 */
	public function getPDF() {
		$recordId = $this->getId();
		$moduleName = $this->getModuleName();

		$controller = new Vtiger_PayslipPDFController($moduleName);
		$controller->loadRecord($recordId);

		$fileName = $moduleName.'_'.getModuleSequenceNumber($moduleName, $recordId);
		$controller->Output($fileName.'.pdf', 'D');
	}

	public function getPaymentRelatedHead($paymentId) {
		$db = PearDatabase::getInstance();

		$query = "SELECT vtiger_account.accountname, vtiger_contactdetails.firstname, 					vtiger_contactdetails.lastname 
			FROM vtiger_payments
			LEFT JOIN vtiger_account ON vtiger_payments.relatedto = vtiger_account.accountid
			LEFT JOIN vtiger_contactdetails ON vtiger_payments.relatedto = vtiger_contactdetails.contactid
			WHERE vtiger_payments.paymentsid =?";
		$params = array($paymentId);
		$result = $db->pquery($query, $params);
		$noOfRows = $db->num_rows($result);

		$Records = array();
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);
			$contactname = $row['firstname'].' '.$row['lastname'];
			$Records['AccountName'] = $row['accountname']==''?trim($contactname):$row['accountname'];
			$Records['ContactName'] = trim($contactname)==''?$row['accountname']:trim($contactname);
		}
		return $Records;
	}

	


	public function getPaymentShipBillAddress($paymentId) {
		$db = PearDatabase::getInstance();
		$result = $db->pquery("SELECT * from vtiger_organizationdetails WHERE organization_id=?", array($paymentId));		
		$row  = $db->query_result_rowdata($result, 0);	
		$noOfRows = $db->num_rows($result);	
		$Records = array();
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);

			$Records['organization_title']	= $row['organization_title'];
			$Records['organizationname'] 		= $row['organizationname']; 
    		$Records['address'] 		= $row['address'];
    		$Records['city'] 		= $row['city'];
			$Records['state'] 		= $row['state'];
			$Records['country'] 		= $row['country'];
			$Records['code'] 		= $row['code'];
			$Records['phone'] 		= $row['phone'];
			$Records['fax'] 		= $row['fax'];
			$Records['website'] 		= $row['website'];
			$Records['logoname'] 		= $row['logoname'];
			$Records['logo_path'] 		= "test/logo/".$Records['logoname'];
			$Records['registration_no'] 		= $row['vatid'];	

		}
		
		return $Records;
		
	}
	
	public function paymentDetail($paymentId) {
		$db = PearDatabase::getInstance();
			
		$query = "SELECT * FROM vtiger_payslip INNER JOIN vtiger_payslipcf ON vtiger_payslipcf.payslipid = vtiger_payslip.payslipid  
			WHERE vtiger_payslip.payslipid =?";
		$params = array($paymentId);
		$result = $db->pquery($query, $params);
		$noOfRows = $db->num_rows($result);
		$Records = array();
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);

			$Records['payslipid']	= $row['payslipid'];
			$Records['payslipno'] 		= $row['payslipno']; 
    		$Records['emp_name'] 		= $row['emp_name'];
    		$Records['ic_passport'] 		= $row['ic_passport'];
			$Records['socso_no'] 		= $row['socso_no'];
			$Records['tax_no'] 		= $row['tax_no'];
			$Records['designation'] 		= $row['designation'];
			$Records['pay_month'] 		= $row['pay_month'];
			$Records['pay_year'] 		= $row['pay_year'];
			$Records['company_details'] 		= $row['company_details'];
			$Records['basic_sal'] 		= $row['basic_sal'];
			$Records['transport_allowance'] 		= $row['transport_allowance'];
			$Records['ph_allowance'] 		= $row['ph_allowance'];
			$Records['parking_allowance'] 		= $row['parking_allowance'];
			$Records['ot_meal_allowance'] 		= $row['ot_meal_allowance'];
			$Records['oth_allowance'] 		= $row['oth_allowance'];
			$Records['gross_pay'] 		= $row['gross_pay'];
			$Records['net_pay'] 		= $row['net_pay'];
			$Records['emp_epf'] 		= $row['emp_epf'];
			$Records['emp_socso'] 		= $row['emp_socso'];
			$Records['lhdn'] 		= $row['lhdn'];
			$Records['zakat'] 		= $row['zakat'];
			$Records['other_deduction'] 		= $row['other_deduction'];
			$Records['total_deduction'] 		= $row['total_deduction'];
			$Records['employer_epf'] 		= $row['employer_epf'];
			$Records['employer_socso'] 		= $row['employer_socso'];
			$Records['employer_eis'] 		= $row['employer_eis'];
			$Records['hrdf'] 		= $row['hrdf'];
			$Records['total_comp_contribution'] = $row['total_comp_contribution'];
	

		}
		return $Records;
	}

}

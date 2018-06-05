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

	public function getPayslipRelatedHead($paymentId) {
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

	public function getBillShipAddress($paymentId, $relatedid, $setype) {
		$db = PearDatabase::getInstance();
		$account = self::getPaymentRelatedHead($paymentId);
		$customerName = $account['AccountName'];
		
		if($setype =='Accounts') {
			$query = "SELECT vtiger_account.accountid, vtiger_accountbillads.bill_pobox, 						vtiger_accountbillads.bill_street,vtiger_accountbillads.bill_city,
					vtiger_accountbillads.bill_code, vtiger_accountbillads.bill_state, 						vtiger_accountbillads.bill_country, vtiger_accountshipads.ship_country,
					vtiger_accountshipads.ship_city,vtiger_accountshipads.ship_code,
					vtiger_accountshipads.ship_state, vtiger_accountshipads.ship_pobox,
					vtiger_accountshipads.ship_street 
				FROM vtiger_account LEFT JOIN vtiger_accountbillads
						ON vtiger_accountbillads.accountaddressid = vtiger_account.accountid
				LEFT JOIN vtiger_accountshipads ON vtiger_accountshipads.accountaddressid = vtiger_account.accountid		WHERE  vtiger_account.accountid=?";	
		} else {
			$query  = "SELECT vtiger_contactaddress.contactaddressid, vtiger_contactaddress.mailingpobox as bill_pobox,vtiger_contactaddress.mailingstreet as bill_street,vtiger_contactaddress.mailingcity as bill_city, vtiger_contactaddress.mailingstate as bill_state, vtiger_contactaddress.mailingcountry as bill_country, vtiger_contactaddress.mailingzip as bill_code, vtiger_contactaddress.otherpobox as ship_pobox,vtiger_contactaddress.otherstreet as ship_street,vtiger_contactaddress.othercity as ship_city, vtiger_contactaddress.otherstate as ship_state, vtiger_contactaddress.othercountry as ship_country, vtiger_contactaddress.otherzip as ship_code FROM vtiger_contactdetails LEFT JOIN vtiger_contactaddress ON vtiger_contactaddress.contactaddressid=vtiger_contactdetails.contactid WHERE  vtiger_contactaddress.contactaddressid=?";	
		}
			$result = $db->pquery($query,array($relatedid));
			$Records = array();
			$noOfRows = $db->num_rows($result);
			for($i=0; $i<$noOfRows; ++$i) {
				$row = $db->query_result_rowdata($result, $i);
				$billpobox = $row['bill_pobox'];
				$billstreet = $row['bill_street'];
				$billcity = $row['bill_city'];
				$billstate = $row['bill_state'];
				$billcountry = $this->convertCountryLabel($row['bill_country']);
				$billcode = $row['bill_code'];
				$shippobox = $row['ship_pobox'];
				$shipstreet=$row['ship_street'];
				$shipcity = $row['ship_city'];
				$shipstate = $row['ship_state'];
				$shipcountry = $this->convertCountryLabel($row['ship_country']);
				$shipcode = $row['ship_code'];
			}

			$billAddress	= $customerName."<br />".$this->joinValues(array($billpobox, $billstreet), ' ');
			$billAddress .= "<br />".$this->joinValues(array($billcity, $billcode), ',')." ".$billstate;
			$billAddress .= "<br />".$billcountry;
			
			$shipAddress	= $customerName."<br />".$this->joinValues(array($shippobox, $shipstreet), ' ');
			$shipAddress .= "<br />".$this->joinValues(array($shipcity, $shipcode), ',')." ".$shipstate;
			$shipAddress .= "<br />".$shipcountry;

			$Records['BillAddress'] = $billAddress; 
			$Records['ShipAddress'] = $shipAddress;
		
		return $Records;
	}


	public function getPayslipShipBillAddress($paymentId) {
		$db = PearDatabase::getInstance();
		$result = $db->pquery("SELECT tblVTC.setype,tblVTP.relatedto FROM vtiger_payments tblVTP INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid = tblVTP.relatedto WHERE tblVTP.paymentsid = ? AND tblVTC.deleted=0", array($paymentId));		
		$row  = $db->query_result_rowdata($result, 0);		
		$setype = $row['setype'];
		$relatedid = $row['relatedto'];
		
		$Records = self::getBillShipAddress($paymentId, $relatedid, $setype);
		

		/*
		$query = "SELECT vtiger_accountbillads.bill_pobox, vtiger_accountbillads.bill_street, 					vtiger_accountbillads.bill_city, vtiger_accountbillads.bill_state, 					vtiger_accountbillads.bill_country,vtiger_accountshipads.ship_country,
				vtiger_accountshipads.ship_city,vtiger_accountshipads.ship_code,
				vtiger_accountshipads.ship_state, vtiger_accountshipads.ship_pobox,
				vtiger_accountshipads.ship_street, vtiger_payments.paymentsid
			FROM vtiger_payments	
			LEFT JOIN vtiger_contactdetails ON  vtiger_contactdetails.contactid = vtiger_payments.relatedto 
			LEFT JOIN vtiger_accountbillads 
				ON  vtiger_contactdetails.accountid = vtiger_accountbillads.accountaddressid 
					OR vtiger_accountbillads.accountaddressid = vtiger_payments.relatedto
			LEFT JOIN vtiger_accountshipads 
				ON vtiger_contactdetails.accountid = vtiger_accountshipads.accountaddressid
					OR vtiger_accountshipads.accountaddressid = vtiger_payments.relatedto
			WHERE vtiger_payments.paymentsid = ?";
		
		$params = array($paymentId);
		$result = $db->pquery($query, $params);
		$Records = array();
		$noOfRows = $db->num_rows($result);
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);
			$billpobox = $row['bill_pobox'];
			$billstreet = $row['bill_street'];
			$billcity = $row['bill_city'];
			$billstate = $row['bill_state'];
			$billcountry = $row['bill_country'];
			$billcode = $row['bill_code'];
			$shippobox = $row['ship_pobox'];
			$shipstreet=$row['ship_street'];
			$shipcity = $row['ship_city'];
			$shipstate = $row['ship_state'];
			$shipcountry = $row['ship_country'];
			$shipcode = $row['ship_code'];
		}

			$billAddress	= $customerName."<br />".$this->joinValues(array($billpobox, $billstreet), ' ');
			$billAddress .= "<br />".$this->joinValues(array($billcity, $billcode), ',')." ".$billstate;
			$billAddress .= "<br />".$billcountry;
			
			$shipAddress	= $customerName."<br />".$this->joinValues(array($shippobox, $shipstreet), ' ');
			$shipAddress .= "<br />".$this->joinValues(array($shipcity, $shipcode), ',')." ".$shipstate;
			$shipAddress .= "<br />".$shipcountry;

			$Records['BillAddress'] = $billAddress; 
			$Records['ShipAddress'] = $shipAddress;
		*/
		return $Records;
		
	}
	
	public function paymentDetail($paymentId) {
		$db = PearDatabase::getInstance();
			
		$query = "SELECT * FROM vtiger_payments INNER JOIN vtiger_paymentscf ON vtiger_paymentscf.paymentsid = vtiger_payments.paymentsid  
			WHERE vtiger_payments.paymentsid =?";
		$params = array($paymentId);
		$result = $db->pquery($query, $params);
		$noOfRows = $db->num_rows($result);
		$Records = array();
		for($i=0; $i<$noOfRows; ++$i) {
			$row = $db->query_result_rowdata($result, $i);
			$Records['paymentreference']	= $row['paymentref'];
			$Records['amount'] 		= $row['amount']; 
    			$Records['paymentfor'] 		= $row['paymentfor'];
			$Records['refno'] 		= $row['refno'];
			$Records['mode'] 		= $row['paymentmode'];
			$Records['bankname'] 		= $row['bankname'];
			$Records['bankaccountname'] 	= $row['bankaccountname'];
			$Records['remarks'] 		= $row['remarks'];
		}
		return $Records;
	}

}

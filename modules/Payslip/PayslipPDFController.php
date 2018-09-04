<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
error_reporting(E_ALL && ~E_NOTICE);
ini_set('display_erros',1);
  
register_shutdown_function('handleErrors');        
    function handleErrors() {  
          
       $last_error = error_get_last();  
      
       if (!is_null($last_error)) { // if there has been an error at some point  
      
          // do something with the error  
          print_r($last_error);  
      
       }  
      
    }  
include_once 'include/InventoryPDFController.php';

class Vtiger_PaymentsPDFPayController extends Vtiger_InventoryPDFController 
{ 
	var $pdfmodule = array();

	//modified by jitu@secondcrm.com set action as per click link in more menu 
	//for different payment viewer 
	function __construct($module,$action) {

		$this->moduleName = $module;
		$this->action 	= $action;
		$paymentsettings = Inventory_Record_Model::fetchPaymentPdfSettings($module);
		
		foreach($paymentsettings as $key=>$val) {
			$this->pdfmodule[$key] = $val;		
		}
		//echo "<pre>";print_r($this->pdfmodule);
	}

	function buildHeaderModelTitle() {
		return sprintf("%s#%s", rtrim($this->moduleName, 's').' No', $this->focusColumnValue('paymentno'));
	}
	function loadRecord($id) { 		
		
		global $current_user;
		
		$this->focus = $focus = CRMEntity::getInstance($this->moduleName);
		
		$focus->retrieve_entity_info($id,$this->moduleName);
		$focus->apply_field_security();
		$focus->id = $id;
		$this->associated_products = getAssociatedProducts($this->moduleName,$focus);
	}	

	function buildHeaderModelColumnCenter() {
		$id 		= $_REQUEST['record'];		
		$paymenthead 	= Payments_Record_Model::getPaymentRelatedHead($id);
		
		$customerName 	= $paymenthead['AccountName'];
		$contactName 	= $paymenthead['ContactName'];
		
		$customerNameLabel = getTranslatedString('Customer Name', $this->moduleName);
		$contactNameLabel = getTranslatedString('Contact Name', $this->moduleName);
		$contactDetails = $this->getContactDetails();
		$contactcf  = $this->getContactCFDetails();
		//$paymentcf  = $this->getPaymentCFDetails();
		
		$modelColumnCenter = array(
		           $contactNameLabel	=>	/*$salutation.*/$contactName,
		           'Contact_Details'	=>	$contactDetails,
		           'Contact_CF'		=>	$contactcf,
		           'Month'		=>	$this->focusColumnValue('paymentfor'),
		           //'Payment_CF'		=>	$paymentcf,
		
			);
		return $modelColumnCenter;
	}
	
	//START added by hafizah@secondcrm to fetch all contact details
	function getContactDetails() {
			global $adb;
			$contactid = $this->focus->column_fields['relatedto'];
			if(!empty($contactid)) {
				$result = $adb->pquery("SELECT * FROM vtiger_contactdetails WHERE contactid=?", array($contactid));
				$contactdetails = array (
					'email' => decode_html($adb->query_result($result,0,'email')),
					'salutation' => decode_html($adb->query_result($result,0,'salutation')),
					'firstname' => decode_html($adb->query_result($result,0,'firstname')),
					'lastname' => decode_html($adb->query_result($result,0,'lastname')),
					'phone' => decode_html($adb->query_result($result,0,'phone')),
					'designation' => decode_html($adb->query_result($result,0,'title')),
					'mobile' => decode_html($adb->query_result($result,0,'mobile')),
					'department' => decode_html($adb->query_result($result,0,'department')),
							
				);
				return $contactdetails;
			}
			return false;	
		}
	//END added by hafizah@secondcrm to fetch all contact in Payments Module
	
	function getContactCFDetails() {
			global $adb;
			$contactid = $this->focus->column_fields['relatedto'];
			if(!empty($contactid)) {
				$result = $adb->pquery("SELECT vtiger_contactscf.* FROM vtiger_contactdetails INNER JOIN vtiger_contactscf ON vtiger_contactscf.contactid = vtiger_contactdetails.contactid WHERE vtiger_contactscf.contactid =?", array($contactid));
				$contactP = array (
					'ICNO' => decode_html($adb->query_result($result,0,'cf_1190')),
					'EPFNO' => decode_html($adb->query_result($result,0,'cf_1317')),
					'TAXNO' => decode_html($adb->query_result($result,0,'cf_1399')),		
				);
				return $contactP;
			}
			return false;	
		}
	
	
	function getPaymentCFDetails() {
			global $adb;
			$no_of_decimal_places = getCurrencyDecimalPlaces();
			$paymentid = $this->focus->column_fields['paymentno'];
			if(!empty($paymentid)) {
				$result = $adb->pquery("SELECT vtiger_paymentscf.* FROM vtiger_payments INNER JOIN vtiger_paymentscf ON vtiger_paymentscf.paymentsid = vtiger_payments.paymentsid WHERE vtiger_payments.paymentno =?", array($paymentid));
		 		$paymentP = array (
					'BasicPay' =>  decode_html(number_format($adb->query_result($result,0,'cf_1359'), getCurrencyDecimalPlaces(),'.', ',')),
					'ProAll' =>  decode_html(number_format($adb->query_result($result,0,'cf_1361'), getCurrencyDecimalPlaces(),'.', ',')),
					'Travel' =>  decode_html(number_format($adb->query_result($result,0,'cf_1363'), getCurrencyDecimalPlaces(),'.', ',')),
					'EPF' =>  decode_html(number_format($adb->query_result($result,0,'cf_1373'), getCurrencyDecimalPlaces(),'.', ',')),
					'SOCSO' =>  decode_html(number_format($adb->query_result($result,0,'cf_1375'), getCurrencyDecimalPlaces(),'.', ',')),
					'ADVANCE' =>  decode_html(number_format($adb->query_result($result,0,'cf_1377'), getCurrencyDecimalPlaces(),'.', ',')),
					'LOAN' =>  decode_html(number_format($adb->query_result($result,0,'cf_1379'), getCurrencyDecimalPlaces(),'.', ',')),
					'TAX' =>  decode_html(number_format($adb->query_result($result,0,'cf_1381'), getCurrencyDecimalPlaces(),'.', ',')),
					'UPL' =>  decode_html(number_format($adb->query_result($result,0,'cf_1383'), getCurrencyDecimalPlaces(),'.', ',')),
					'EARNING' =>  decode_html(number_format($adb->query_result($result,0,'cf_1387'), getCurrencyDecimalPlaces(),'.', ',')),
					'DEDUCTION' =>  decode_html(number_format($adb->query_result($result,0,'cf_1389'), getCurrencyDecimalPlaces(),'.', ',')),
					'CLAIM' =>  decode_html(number_format($adb->query_result($result,0,'cf_1385'), getCurrencyDecimalPlaces(),'.', ',')),
					'epfemployee' =>  decode_html(number_format($adb->query_result($result,0,'cf_1365'), getCurrencyDecimalPlaces(),'.', ',')),
					'epfemployer' =>  decode_html(number_format($adb->query_result($result,0,'cf_1367'), getCurrencyDecimalPlaces(),'.', ',')),
					'socsoemployee' =>  decode_html(number_format($adb->query_result($result,0,'cf_1369'), getCurrencyDecimalPlaces(),'.', ',')),
					'socsoemployer' =>  decode_html(number_format($adb->query_result($result,0,'cf_1371'), getCurrencyDecimalPlaces(),'.', ',')),
					'netpayment' =>  decode_html(number_format($adb->query_result($result,0,'cf_1391'), getCurrencyDecimalPlaces(),'.', ',')),
					'totalpayment' =>  decode_html(number_format($adb->query_result($result,0,'cf_1393'), getCurrencyDecimalPlaces(),'.', ',')),
					
					
					//'EPFNO' => decode_html($adb->query_result($result,0,'cf_1317')),		
				);
				return $paymentP;
			}
			return false;	
		}
	

	function buildHeaderModelColumnRight() {
		$endpage="1";
		
		if($this->pdfmodule['headerdate'] == 'T') {
			$issuedate 	= $this->formatDate($this->focusColumnValue('duedate'));
			
		} else if($this->pdfmodule['headerdate'] == 'C') {
			$headerdate 	= explode(' ',$this->focusColumnValue('CreatedTime'));
			$issuedate  	= $this->formatDate($headerdate[0]);
		} else {
			$headerdate 	= explode(' ',$this->focusColumnValue('ModifiedTime'));
			$issuedate  	= $this->formatDate($headerdate[0]);
		}		
		
		
		$id 		= $_REQUEST['record'];
		$paymentdetails = Payments_Record_Model::paymentDetail($id);
		$currencySymbol = $this->buildCurrencySymbol();
		

		$phonelable 	= getTranslatedString('LBL_PHONE', $this->moduleName);
		$issueByLabel 	= getTranslatedString('Department', $this->moduleName);
		$paymentAddress = Payments_Record_Model::getPaymentShipBillAddress($id);
		
		$issueDateLabel = getTranslatedString('Name', $this->moduleName);
		$validDateLabel = getTranslatedString('Position', $this->moduleName);
		$billingAddressLabel = getTranslatedString('Billing Address', $this->moduleName);
		$grandtotallabel	= getTranslatedString("RTOTAL", $this->moduleName);	


		$columnRightArray = array();
		$columnRightArray[$issueDateLabel] = $this->formatDate($this->focusColumnValue('paymentdate'));
		$columnRightArray[$validDateLabel] = $issuedate;
	
		
		if($this->pdfmodule['showperson_name']==1) {
			$columnRightArray[$issueByLabel] = $this->resolveReferenceLabel($this->focusColumnValue('assigned_user_id'),'Users');
		}
		if($this->pdfmodule['showphone']==1) {
			$columnRightArray[$phonelable] = $this->getRelatedPhone($this->focusColumnValue('relatedto'));
		}
		
				
		$columnRightArray[$grandtotallabel."(RM)"] = $this->formatPrice($paymentdetails['amount']);
		
		$modelColumnRight = array(
				'dates' => $columnRightArray,
				$billingAddressLabel  => $paymentAddress['BillAddress']
		);
		if($this->pdfmodule['showshipping']==1) {
			$shippingAddressLabel = $this->pdfmodule['shippinglabel'];
			$modelColumnRight = array_merge($modelColumnRight,array($shippingAddressLabel=>$paymentAddress['ShipAddress']));	

		}		
		return $modelColumnRight;
	}

	function buildContentModels() {
		$contentModels = array();
		$id = $_REQUEST['record'];
		//retreiving the vtiger_invoice info
		$paymentdetails = Payments_Record_Model::paymentDetail($id);
	
		$contentModels = array();
			
			if($this->pdfmodule['paymentref'] ==1) {
				$contentModels[getTranslatedString('Payment Ref',$this->moduleName)] = $paymentdetails['paymentreference'];	}

			if($this->paympdfmoduleent['paymentammount'] ==1) {
			$contentModels[getTranslatedString('Amount',$this->moduleName)] = $paymentdetails['amount'];
			}

			if($this->pdfmodule['paymentfor'] ==1) {
			$contentModels[getTranslatedString('Payment For',$this->moduleName)] = $paymentdetails['paymentfor'];
			}

			if($this->pdfmodule['paymentrefno'] ==1) {
			$contentModels[getTranslatedString('Ref No(CC No|A/C N0|Cheque No)',$this->moduleName)] = $paymentdetails['refno'];
			}

			if($this->pdfmodule['paymentmode'] ==1) {
			$contentModels[getTranslatedString('Mode',$this->moduleName)] = $paymentdetails['mode'];
			}

			if($this->pdfmodule['paymentbankname'] ==1) {
			$contentModels[getTranslatedString('Bank Name',$this->moduleName)] = $paymentdetails['bankname'];
			}

			if($this->pdfmodule['paymentbankaccount'] ==1) {
			$contentModels[getTranslatedString('Bank Account Name',$this->moduleName)] = $paymentdetails['bankaccountname'];
			}

			$contentModels[getTranslatedString('Description',$this->moduleName)] = $paymentdetails['remarks'];		$contentModels['TermsCondition'.'#'.$this->focusColumnValue('terms_conditions')] = Vtiger_Util_Helper::getTnCDescription(from_html($this->focusColumnValue('terms_conditions'))); //Added by jitu on 22-01-2015 
	
	                $paymentscf = $this->getPaymentCFDetails();
			$contentModels['paymentscf'][] = $paymentscf;
		
		return $contentModels;
	}
	
	function getWatermarkContent() {
		return $this->focusColumnValue('paymentno');
	}
}
?>

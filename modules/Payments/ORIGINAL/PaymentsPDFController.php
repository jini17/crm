<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'include/InventoryPDFController.php';

class Vtiger_PaymentsPDFController extends Vtiger_InventoryPDFController 
{ 
	var $pdfmodule = array();
	
	function __construct($module) {

		$this->moduleName = $module;
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
		
		$modelColumnCenter = array(
			);
		return $modelColumnCenter;
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
		$issueByLabel 	= getTranslatedString('Issued By', $this->moduleName);
		$paymentAddress = Payments_Record_Model::getPaymentShipBillAddress($id);
		
		$issueDateLabel = getTranslatedString('Issued Date', $this->moduleName);
		$validDateLabel = getTranslatedString('Due Date', $this->moduleName);
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
	
		
		return $contentModels;
	}
	
	function getWatermarkContent() {
		return $this->focusColumnValue('paymentno');
	}
}
?>

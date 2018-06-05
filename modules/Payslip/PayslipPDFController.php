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
include_once 'vtlib/Vtiger/PDF/TCPDF.php';
include_once dirname(__FILE__). '/PaymentsPDFHeaderViewer.php';
include_once dirname(__FILE__). '/PaymentsViewer.php';


class Vtiger_PaymentsPDFController extends Vtiger_InventoryPDFController 
{ 
	var $pdfmodule = array();
	
	############################################ Constructor ###############################################	
	function __construct($module) {

		$this->moduleName = $module;
		$invoicesettings = Inventory_Record_Model::fetchPaymentPdfSettings($module);
		
		foreach($invoicesettings as $key=>$val) {
			$this->pdfmodule[$key] = $val;		
		}
	}

	function getPDFGenerator() {
		return new Vtiger_PDF_Generator();
	}
	
	########################################### End here ###################################################
	
	############################################ Header Section ############################################ 

	function getHeaderViewer() {
		$headerViewer = new PaymentsPDFHeaderViewer();
		$headerViewer->setModel($this->buildHeaderModel());
		return $headerViewer;
	}

	function buildHeaderModel() {
		$headerModel = new Vtiger_PDF_Model();
		$headerModel->set('title', $this->buildHeaderModelTitle());
		$headerModel->set('module', $this->moduleName);
		$modelColumns = array($this->buildHeaderModelColumnLeft(), $this->buildHeaderModelColumnCenter(), $this->buildHeaderModelColumnRight());
		$headerModel->set('pdfsettings',$this->pdfmodule);
		$headerModel->set('columns', $modelColumns);

		return $headerModel;
	}

	function buildHeaderModelTitle() {
		return sprintf("%s#%s", rtrim($this->moduleName, 's').' No', $this->focusColumnValue('paymentno'));
	}

	function buildHeaderModelColumnLeft() {
		global $adb;
		// Company information
		//Added By jitu@secondcrm.com on 1-10-2014
		 $companyid = $this->focus->column_fields['company_details'];	
		 $result = $adb->pquery("SELECT * FROM vtiger_organizationdetails WHERE organization_id =?", array($companyid));
		$num_rows = $adb->num_rows($result);
		if($num_rows) {
			$resultrow = $adb->fetch_array($result);

			$addressValues = array();
			$addressValues[] = $resultrow['address'];
			if(!empty($resultrow['city'])) $addressValues[]= "<br />".$resultrow['city'];
			if(!empty($resultrow['code'])) $addressValues[]= $resultrow['code'];
			if(!empty($resultrow['state'])) $addressValues[]= $resultrow['state'].",";
			if(!empty($resultrow['country'])) $addressValues[]= $resultrow['country'];

			$additionalCompanyInfo = array();
			if(!empty($resultrow['phone']))		$additionalCompanyInfo[]= "<br />".getTranslatedString("Tel: ", $this->moduleName). $resultrow['phone'];
			if(!empty($resultrow['fax']))		$additionalCompanyInfo[]= "/".getTranslatedString(" Fax: ", $this->moduleName). $resultrow['fax'];
			
			$logo = "test/logo/".$resultrow['logoname'];			

			$modelColumnLeft = array(
					'logo' => $logo,
					'summary' => decode_html($resultrow['organizationname']),
					'content' => decode_html($this->joinValues($addressValues, ' '). $this->joinValues($additionalCompanyInfo, ' ')),
					'vatid' =>$resultrow['vatid'],
			);
		}

		return $modelColumnLeft;
	}

	function buildHeaderModelColumnCenter() {
		$id 		= $_REQUEST['record'];		
		$paymenthead 	= Payments_Record_Model::getPaymentRelatedHead($id);
	
		$customerName 	= $paymenthead['AccountName'];
		$contactName 	= $paymenthead['ContactName'];
		
		$customerNameLabel = getTranslatedString('Customer Name', $this->moduleName);
		$contactNameLabel = getTranslatedString('Contact Name', $this->moduleName);
		
		$modelColumnCenter = array();

		$modelColumnCenter[$contactNameLabel]		= $contactName;
		$modelColumnCenter[$customerNameLabel] 		= $customerName;
		
		return $modelColumnCenter;
	}

	function buildHeaderModelColumnRight() {
		
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
		if($this->pdfmodule['showphone']==1 && $phone !='') {
			$columnRightArray[$phonelable] = $this->getRelatedPhone($this->focusColumnValue('relatedto'));
		}
		
		$columnRightArray[$grandtotallabel." ($currencySymbol)"]= $this->formatPrice($final_details['grandTotal']);			
		$columnRightArray[$grandtotallabel." ($currencySymbol)"] = $this->formatPrice($paymentdetails['amount']);
		
		$modelColumnRight = array(
				'dates' => $columnRightArray
		);
		
		if($this->pdfmodule['showshipping']==1) {
			$shippingAddressLabel = $this->pdfmodule['shippinglabel'];
			$modelColumnRight = array_merge($modelColumnRight,array($shippingAddressLabel=>$paymentAddress['ShipAddress']));	

		}
		$modelColumnRight =  array_merge($modelColumnRight,array($billingAddressLabel  =>$paymentAddress['BillAddress']));	
		
		return $modelColumnRight;
	}

	############################################### End Here ##################################################

	############################################## Content Section ############################################

	function getContentViewer() {
			$contentViewer = new PaymentsViewer();
			$contentViewer->setContentModels($this->buildContentModels());
			$contentViewer->setWatermarkModel(array_merge($this->buildHeaderModelColumnRight(),array("title"=>$this->buildHeaderModelTitle())));

		return $contentViewer;
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
			$contentModels['headerinfo'] = $this->buildHeaderModelColumnLeft();
			$contentModels['pdfsettings'] = $this->pdfmodule;
			$contentModels[getTranslatedString('Description',$this->moduleName)] = $paymentdetails['remarks'];		$contentModels['TermsCondition'.'#'.$this->focusColumnValue('terms_conditions')] = Vtiger_Util_Helper::getTnCDescription(from_html($this->focusColumnValue('terms_conditions'))); //Added by jitu on 22-01-2015 
	
		
		return $contentModels;
	}
	############################################### End here ####################################################
}
?>

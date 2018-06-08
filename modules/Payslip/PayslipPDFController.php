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
include_once dirname(__FILE__). '/PayslipPDFHeaderViewer.php';
include_once dirname(__FILE__). '/PayslipViewer.php';


class Vtiger_PayslipPDFController extends Vtiger_InventoryPDFController 
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

		$headerViewer = new PayslipPDFHeaderViewer();	
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

		$paymenthead 	= Payslip_Record_Model::getPaymentRelatedHead($id);
	
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
		
		
		
		
		$id 		= $_REQUEST['record'];
		$paymentdetails = Payslip_Record_Model::paymentDetail($id);
		$currencySymbol = $this->buildCurrencySymbol();
		
		$currencySymbol = $this->buildCurrencySymbol();
		$phonelable 	= getTranslatedString('LBL_PHONE', $this->moduleName);
		$issueByLabel 	= getTranslatedString('Issued By', $this->moduleName);
		$paymentAddress = Payslip_Record_Model::getPaymentShipBillAddress($paymentdetails['company_details']);
		$employee_and_company=array_merge($paymentdetails,$paymentAddress);
	

		return $employee_and_company;
	}

	############################################### End Here ##################################################

	############################################## Content Section ############################################

	function getContentViewer() {
			$contentViewer = new PayslipViewer();
			$contentViewer->setContentModels($this->buildContentModels());
			$contentViewer->setWatermarkModel(array_merge($this->buildHeaderModelColumnRight(),array("title"=>$this->buildHeaderModelTitle())));

		return $contentViewer;
	}


	function buildContentModels() {
		$contentModels = array();
		$id = $_REQUEST['record'];
		//retreiving the vtiger_invoice info
		$paymentdetails = Payslip_Record_Model::paymentDetail($id);
		
		$contentModels = array();
		
			if($this->pdfmodule['paymentref'] ==1) {
				$contentModels[getTranslatedString('Basic Salary',$this->moduleName)] = $paymentdetails['basic_sal'];	}

			if($this->pdfmodule['paymentammount'] ==1) {
			$contentModels[getTranslatedString('Gross Pay',$this->moduleName)] = $paymentdetails['gross_pay'];
			}

			if($this->pdfmodule['paymentfor'] ==1) {
			$contentModels[getTranslatedString("E'R EPF",$this->moduleName)] = $paymentdetails['emp_epf'];
			$contentModels[getTranslatedString("E'R SOCSO",$this->moduleName)] = $paymentdetails['emp_socso'];
			$contentModels[getTranslatedString("HRDF",$this->moduleName)] = $paymentdetails['hrdf'];
			$contentModels[getTranslatedString("E'R EIS",$this->moduleName)] = $paymentdetails['employer_eis'];
			$contentModels[getTranslatedString("Total Contributions",$this->moduleName)] = $paymentdetails['total_comp_contribution'];
			}


			if($this->pdfmodule['paymentmode'] ==1) {
			$contentModels[getTranslatedString('',$this->moduleName)] = $paymentdetails['other_deduction'];
				$contentModels[getTranslatedString('',$this->moduleName)] = $paymentdetails['total_deduction'];
			}

			$contentModels['headerinfo'] = $this->buildHeaderModelColumnLeft();
			
			$contentModels['pdfsettings'] = $this->pdfmodule;
			
	
		
		return $contentModels;
	}
	############################################### End here ####################################################
}
?>

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
include_once dirname(__FILE__). '/SalesOrderPDFHeaderViewer.php';
include_once dirname(__FILE__). '/SalesOrderPDFContentViewer.php';

class Vtiger_SalesOrderPDFController extends Vtiger_InventoryPDFController{

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
		$headerViewer = new SalesOrderPDFHeaderViewer();
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
		$singularModuleNameKey = 'SINGLE_'.$this->moduleName;
		$translatedSingularModuleLabel = getTranslatedString($singularModuleNameKey, $this->moduleName);
		if($translatedSingularModuleLabel == $singularModuleNameKey) {
			$translatedSingularModuleLabel = getTranslatedString($this->moduleName, $this->moduleName);
		}
		return sprintf("%s#%s", $translatedSingularModuleLabel, $this->focusColumnValue('salesorder_no'));
	}

	function buildHeaderBillingAddress() {
		$customerName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');	
		
		$billPoBox	= $this->focusColumnValues(array('bill_pobox'));
		$billStreet = $this->focusColumnValues(array('bill_street'));
		$billCity	= $this->focusColumnValues(array('bill_city'));
		$billState	= $this->focusColumnValues(array('bill_state'));
		$billCountry 	= $this->focusColumnValues(array('bill_country'));
		$billCode	=  $this->focusColumnValues(array('bill_code'));

		$address	= $customerName."<br />".$this->joinValues(array($billPoBox, $billStreet), ' ');
		$address .= "<br />".$this->joinValues(array($billCity, $billCode), ',')." ".$billState;
		$address .= "<br />".$billCountry;
		return $address;
	}	
	
	function buildHeaderShippingAddress() {
		$customerName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');
		$shipPoBox	= $this->focusColumnValues(array('ship_pobox'));
		$shipStreet = $this->focusColumnValues(array('ship_street'));
		$shipCity	= $this->focusColumnValues(array('ship_city'));
		$shipState	= $this->focusColumnValues(array('ship_state'));
		$shipCountry = $this->focusColumnValues(array('ship_country'));
		$shipCode	=  $this->focusColumnValues(array('ship_code'));
		$address	= $customerName."<br />".$this->joinValues(array($shipPoBox, $shipStreet), ' ');
		$address .= "<br />".$this->joinValues(array($shipCity, $shipCode), ',')." ".$shipState;
		$address .= "<br />".$shipCountry;
		return $address;
	}

	function buildHeaderModelColumnCenter() {
		
		$contactName = $this->resolveReferenceLabel($this->focusColumnValue('contact_id'), 'Contacts');
		$accountName = $this->resolveReferenceLabel($this->focusColumnValue('account_id'), 'Accounts');
		$purchaseOrder = $this->focusColumnValue('vtiger_purchaseorder');
		$salesOrder	= $this->resolveReferenceLabel($this->focusColumnValue('salesorder_id'));
		$salutation 	= $this->buildSalutation();
		
		$quoteDetails = $this->getSORelatedQuotesNo();
		
		$quotelabel = getTranslatedString('Quote_Details', $this->moduleName);
		$contactNameLabel = getTranslatedString('Contact Name', $this->moduleName);
		$purchaseOrderLabel = getTranslatedString('Purchase Order', $this->moduleName);
		$salesOrderLabel = getTranslatedString('Sales Order', $this->moduleName);
		$remarkslabel	= getTranslatedString('Remarks', $this->moduleName);
		$salesorderlableno = getTranslatedString('SalesOrder No', $this->moduleName);
		$modelColumnCenter = array(
				$contactNameLabel	=>	/*$salutation.*/$contactName,
				'Subject'		=>	$this->focusColumnValue('subject'),
				//$salesorderlableno 	=> 	$this->focusColumnValue('salesorder_no'), asked by rahima 
				$quotelabel		=>	$quoteDetails['quote_no']
			);

		if($this->focusColumnValue('description') !=''){
			$modelColumnCenter[$remarkslabel] = $this->focusColumnValue('description');	
		}

		return $modelColumnCenter;
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
			
			$companyDetails = Vtiger_Record_Model::getInstanceById($companyid, 'OrganizationDetails');
			$imagedetails = $companyDetails->getImageDetails();
            $logo = $imagedetails[0]['path'].'_'.$imagedetails[0]['name'];	

            if(!file_exists($logo)){
            	$logo = 'test/loginlogo/second-crm-logo.png';
            }
   
			$modelColumnLeft = array(
					'logo' => $logo,
					'summary' => decode_html($resultrow['organizationname']),
					'content' => decode_html($this->joinValues($addressValues, ' '). $this->joinValues($additionalCompanyInfo, ' ')),
					'vatid' =>$resultrow['vatid'],
			);
		}

		return $modelColumnLeft;
	}

	function buildHeaderModelColumnRight() {
		
		if($this->pdfmodule['headerdate'] == 'T') {
			$issuedate 	= $this->formatDate($this->focusColumnValue('issuedate'));
		} else if($this->pdfmodule['headerdate'] == 'C') {
			$headerdate 	= explode(' ',$this->focusColumnValue('createdtime'));
			$issuedate  	= $this->formatDate($headerdate[0]);
		} else {
			$headerdate 	= explode(' ',$this->focusColumnValue('modifiedtime'));
			$issuedate  	= $this->formatDate($headerdate[0]);
		}	

		$currencySymbol = $this->buildCurrencySymbol();
		$associated_products = $this->associated_products;
		$final_details = $associated_products[1]['final_details'];	
		$issueByLabel = getTranslatedString('Issued By', $this->moduleName);
		$phonelable 	= getTranslatedString('LBL_PHONE', $this->moduleName);
		$issueDateLabel = getTranslatedString('Issued Date', $this->moduleName);
		$validDateLabel = getTranslatedString('Valid Date', $this->moduleName);
		$billingAddressLabel = getTranslatedString('Billing Address', $this->moduleName);
		$shippingAddressLabel = getTranslatedString('Shipping Address', $this->moduleName);
		$grandtotallabel	= getTranslatedString("RTOTAL", $this->moduleName);	
		
		$columnRightArray = array();
		
		if($this->focusColumnValue('issuedate') !='') 
			$columnRightArray[$issueDateLabel] = $issuedate;

		if($this->focusColumnValue('validtill') !='')
			$columnRightArray[$validDateLabel] = $this->formatDate($this->focusColumnValue('validtill'));
	

		if($this->pdfmodule['showperson_name']==1) {
			$columnRightArray[$issueByLabel] = $this->resolveReferenceLabel($this->focusColumnValue('assigned_user_id'),'Users');
		}
		$phone = $this->getRelatedPhone($this->focusColumnValue('contact_id'));
		if($this->pdfmodule['showphone']==1 && $phone !='') {
			$columnRightArray[$phonelable] = $phone;
		}
		
		$columnRightArray[$grandtotallabel." ($currencySymbol)"]= $this->formatPrice($final_details['grandTotal']);
		$modelColumnRight = array(
				'dates' => $columnRightArray,			
			);
		
		if($this->pdfmodule['showshipping']==1) { 
			if($this->pdfmodule['shippinglabel'] !='') {
				$shippingAddressLabel = $this->pdfmodule['shippinglabel'];
			}	

		$modelColumnRight = array_merge($modelColumnRight,array($shippingAddressLabel=>$this->buildHeaderShippingAddress()));	
		}	

		$modelColumnRight =  array_merge($modelColumnRight,array($billingAddressLabel  => $this->buildHeaderBillingAddress()));	
	
		return $modelColumnRight;
	}
	
	############################################### End Here ##################################################

	############################################## Content Section ############################################

	function getContentViewer() {
		$contentViewer = new SalesOrderPDFContentViewer();
		$contentViewer->setContentModels($this->buildContentModels());
		$contentViewer->setSummaryModel($this->buildSummaryModel());
		$contentViewer->setLabelModel($this->buildContentLabelModel());
		$contentViewer->setWatermarkModel(array_merge($this->buildHeaderModelColumnRight(),array("title"=>$this->buildHeaderModelTitle())));
		return $contentViewer;
	}

	function buildContentModels() { 
		$associated_products = $this->associated_products;
		$contentModels = array();
		$productLineItemIndex = 0;
		$totaltaxes = 0;
		$sno = 1;
		$no_of_decimal_places = getCurrencyDecimalPlaces();
		foreach($associated_products as $productLineItem) { 
			++$productLineItemIndex;

			$contentModel = new Vtiger_PDF_Model();

			$discountPercentage  = 0.00;
			$total_tax_percent = 0.00;
			$producttotal_taxes = 0.00;
			$quantity = ''; $listPrice = ''; $discount = ''; $taxable_total = '';
			$tax_amount = ''; $producttotal = '';
		
			//added by jitu
			$procode  = $productLineItem["hdnProductcode{$productLineItemIndex}"];
			$prod_description = $productLineItem["productDescription{$productLineItemIndex}"];
			$prod_comment = $productLineItem["comment{$productLineItemIndex}"];
			//end here

			$quantity	= $productLineItem["qty{$productLineItemIndex}"];
			$listPrice	= $productLineItem["listPrice{$productLineItemIndex}"];
			$discount	= $productLineItem["discountTotal{$productLineItemIndex}"];
			$taxable_total = $quantity * $listPrice - $discount;
			$taxable_total = number_format($taxable_total, $no_of_decimal_places,'.','');
			$producttotal = $taxable_total;
			if($this->focus->column_fields["hdnTaxType"] == "individual") {
				for($tax_count=0;$tax_count<count($productLineItem['taxes']);$tax_count++) {
					$tax_percent = $productLineItem['taxes'][$tax_count]['percentage'];
					$total_tax_percent += $tax_percent;
					$tax_amount = (($taxable_total*$tax_percent)/100);
					$producttotal_taxes += $tax_amount;
				}
			}

			$producttotal_taxes = number_format($producttotal_taxes, $no_of_decimal_places,'.','');
			$producttotal = $taxable_total+$producttotal_taxes;
			$producttotal = number_format($producttotal, $no_of_decimal_places,'.','');
			$tax = $producttotal_taxes;
			$totaltaxes += $tax;
			$totaltaxes = number_format($totaltaxes, $no_of_decimal_places,'.','');
			$discountPercentage = $productLineItem["discount_percent{$productLineItemIndex}"];
			$productName = decode_html($productLineItem["productName{$productLineItemIndex}"]);
			//get the sub product
			$subProducts = $productLineItem["subProductArray{$productLineItemIndex}"];
			if($subProducts != '') {
				foreach($subProducts as $subProduct) {
					$productName .="\n"." - ".decode_html($subProduct);
				}
			}
			$contentModel->set('Name', $productName);
			$contentModel->set('SNo', $sno);
			$contentModel->set('OrderCode', $procode);	//added by jitu
			$contentModel->set('Quantity', $quantity);
			$contentModel->set('Price',     number_format($listPrice, getCurrencyDecimalPlaces(),'.', ''));
			$contentModel->set('Discount',  number_format($discount, getCurrencyDecimalPlaces(),'.', ''));
			$contentModel->set('Tax',       number_format($tax, getCurrencyDecimalPlaces(),'.', ''));
			$contentModel->set('Total',     number_format($producttotal, getCurrencyDecimalPlaces(),'.', ''));
			$contentModel->set('Comment',   decode_html(nl2br($productLineItem["comment{$productLineItemIndex}"])));
			$contentModel->set('Description',   decode_html(nl2br(str_replace('&nbsp;',' ',$prod_description)))); //added by jitu
			$contentModel->set('ProductComment',   decode_html(nl2br(str_replace('&nbsp;',' ',$prod_comment))));
			
			$contentModel->set('discountdetails',   $productLineItem['discountdetails']);	

			$contentModels['contents'][] = $contentModel;
			$sno++;
		}
			$contentModels['pdfsettings'] = $this->pdfmodule;
			$contentModels['hdnTaxType'] = $this->focus->column_fields["hdnTaxType"];
			$contentModels['headerinfo'] = $this->buildHeaderModelColumnLeft();
			$contentModels['footer'][] = Vtiger_Util_Helper::getTnCDescription(from_html($this->focusColumnValue('terms_conditions')));
			
			$this->totaltaxes = $totaltaxes; //will be used to add it to the net total

		return $contentModels;
	}
	
	function buildContentLabelModel() {

		$currencySymbol = $this->buildCurrencySymbol();

		$labelModel = new Vtiger_PDF_Model();
		$labelModel->set('SNo',      getTranslatedString('S.No',$this->moduleName));
		$labelModel->set('Code',    getTranslatedString('Order Code#',$this->moduleName));		
		$labelModel->set('Name',      getTranslatedString('Item',$this->moduleName));
		$labelModel->set('Quantity',  getTranslatedString('Quantity',$this->moduleName));
		//$labelModel->set('Price',     getTranslatedString('LBL_LIST_PRICE',$this->moduleName)." ($currencySymbol)");
		$labelModel->set('Price',     getTranslatedString('LBL_LIST_PRICE',$this->moduleName));
		$labelModel->set('Discount',  getTranslatedString('Discount',$this->moduleName));
		$labelModel->set('Tax',       getTranslatedString('Tax',$this->moduleName));
		$labelModel->set('Total',     getTranslatedString('Total',$this->moduleName));
		$labelModel->set('Comment',   getTranslatedString('Comment'),$this->moduleName);
		$labelModel->set('Description',getTranslatedString('Description',$this->moduleName));
		
		return $labelModel;
	}

	function buildSummaryModel() {
		$associated_products = $this->associated_products;
		$final_details = $associated_products[1]['final_details'];

		$summaryModel = new Vtiger_PDF_Model();

		$netTotal = $discount = $handlingCharges =  $handlingTaxes = 0;
		$adjustment = $grandTotal = 0;

		$productLineItemIndex = 0;
		$sh_tax_percent = 0;
		foreach($associated_products as $productLineItem) {
			++$productLineItemIndex;
			$netTotal += $productLineItem["netPrice{$productLineItemIndex}"];
		}
		$netTotal = number_format(($netTotal + $this->totaltaxes), getCurrencyDecimalPlaces(),'.', '');
		$summaryModel->set(getTranslatedString("Net Total", $this->moduleName), number_format($netTotal,getCurrencyDecimalPlaces(),'.', ''));

		$discount_amount = number_format($final_details["discountTotal_final"], getCurrencyDecimalPlaces(),'.', '');
		$summaryModel->set(getTranslatedString("Discount", $this->moduleName), number_format($discount_amount,getCurrencyDecimalPlaces(),'.', ''));
		$summaryModel->set('DiscountDetails', $final_details['finaldiscountdetails']);	
		//echo "<pre>";print_r($summaryModel);
		$group_total_tax_percent = '0.00';
		//To calculate the group tax amount
		if($final_details['taxtype'] == 'group') {
			$group_tax_details = $final_details['taxes'];
			for($i=0;$i<count($group_tax_details);$i++) {
				$group_total_tax_percent += $group_tax_details[$i]['percentage'];
			}
			$summaryModel->set(getTranslatedString("Tax:", $this->moduleName)."($group_total_tax_percent%)", number_format($final_details['tax_totalamount'],getCurrencyDecimalPlaces(),'.', ''));
		}
		//Shipping & Handling taxes
		$sh_tax_details = $final_details['sh_taxes'];
		for($i=0;$i<count($sh_tax_details);$i++) {
			$sh_tax_percent = $sh_tax_percent + $sh_tax_details[$i]['percentage'];
		}
		//obtain the Currency Symbol
		$currencySymbol = $this->buildCurrencySymbol();

		$summaryModel->set(getTranslatedString("Shipping & Handling Charges", $this->moduleName), number_format($final_details['shipping_handling_charge'],getCurrencyDecimalPlaces(),'.', ''));
		$summaryModel->set(getTranslatedString("Shipping & Handling Tax:", $this->moduleName)."($sh_tax_percent%)", number_format($final_details['shtax_totalamount'],getCurrencyDecimalPlaces(),'.', ''));
		$summaryModel->set(getTranslatedString("Adjustment", $this->moduleName), number_format($final_details['adjustment'],getCurrencyDecimalPlaces(),'.', '')); 
		$summaryModel->set(getTranslatedString("Grand Total", $this->moduleName)." ($currencySymbol)", number_format($final_details['grandTotal'],getCurrencyDecimalPlaces(),'.', '')); // TODO add currency string


		if ($this->moduleName == 'Invoice') { //Added by jitu for invoice balance n received
			$receivedVal = number_format($this->focusColumnValue("received"), getCurrencyDecimalPlaces(),'.', '');
			
			if (!$receivedVal) {
				$this->focus->column_fields["received"] = number_format(0,getCurrencyDecimalPlaces(),'.', '');
				
			}
			//If Received value is exist then only Recieved, Balance details should present in PDF
			if ($this->formatPrice($this->focusColumnValue("received")) > 0) {
				$summaryModel->set(getTranslatedString("Received", $this->moduleName), number_format($this->focusColumnValue("received"),getCurrencyDecimalPlaces(),'.', ''));
				$summaryModel->set(getTranslatedString("Balance", $this->moduleName), number_format($this->focusColumnValue("balance"),getCurrencyDecimalPlaces(),'.', ''));
			}
		}
		return $summaryModel;
	}
	
	function getSORelatedQuotesNo() {
			global $adb;
			$salesorderid = $this->focus->id;
			if(!empty($salesorderid)) {
				$result = $adb->pquery("SELECT quote_no FROM vtiger_quotes LEFT JOIN vtiger_salesorder ON vtiger_quotes.quoteid = vtiger_salesorder.quoteid WHERE salesorderid=?
", array($salesorderid));
				$salesorderquotedetails = array (
					'quote_no' => decode_html($adb->query_result($result,0,'quote_no')),	
				);
				return $salesorderquotedetails;
			}
			return false;	
		}
	############################################### End here ####################################################	
}
?>

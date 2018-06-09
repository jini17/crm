<?php
/* ===================================================================
Modified By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 21 / 11 / 2009
Change Reason: Pdf Cinfigurator change, File overwritten
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: from crm-now  www.crm-now.de
 * All Rights Reserved.
 * modified by: crm-now, www.crm-now.de
 ********************************************************************************/
function createpdffile ($idnumber,$purpose='', $path='',$current_id='') {

	require_once('libraries/tcpdf/tcpdf.php');
	require_once('libraries/tcpdf/config/tcpdf_config.php');
	require_once('modules/Payslip/Payslip.php');
	require_once('include/database/PearDatabase.php');
	//require_once('include/utils/InventoryUtils.php');
	//require_once('include/utils/PDFutils.php');

	//CODE ADDED BY IZZATY ON 14-10-2011
 	require_once('include/logging.php');
	$log =& LoggerManager::getLogger('pdfcreator');
	//CODE END ADDED ON 14-10-201

	global $FOOTER_PAGE, $default_font, $font_size_footer, $NUM_FACTURE_NAME, $pdf_strings, $Payment_no, $footer_margin;
	global $org_name, $org_address, $org_city, $org_code, $org_country, $org_irs, $org_taxid, $org_phone, $org_fax, $org_website;
	//CODE ADDED BY IZZATY ON 18-10-2011
	global $account_name,$contact_name,$contact_lastname,$relatedto;
	//CODE END ADDED ON 18-10-2011
	global $VAR40_NAME, $VAR3_NAME, $VAR4_NAME,$ORG_POSITION,$VAR_PAGE, $VAR_OF;
	//bank information - content
	global $bank_name , $bank_street , $bank_city ,$bank_zip ,$bank_country, $bank_account, $bank_routing, $bank_iban, $bank_swift;
	//bank information - labels from language files
	global $ACCOUNT_NUMBER, $ROUTING_NUMBER, $SWIFT_NUMBER, $IBAN_NUMBER;
	global $columns, $logoradio, $logo_name, $footerradio, $pageradio;
	global $adb,$app_strings,$focus,$current_user;
	$module = 'Payslip';
	//get the stored configuration values
	//$pdf_config_details = getAllPDFDetails('Payment');
	//set font
	//$default_font = getTCPDFFontsname ($pdf_config_details[fontid]);
	if ($default_font =='') $default_font = 'Helvetica';
	$font_size_header = $pdf_config_details[fontsizeheader];
	$font_size_address = $pdf_config_details[fontsizeaddress];
	$font_size_body = $pdf_config_details[fontsizebody];
	$font_size_footer = $pdf_config_details[fontsizefooter];
        //$logo_name='1294629935_logo_company.jpg';
	//select comma or dot as numberformat
	//European Format
	//$decimal_precision = 2;
	//$decimals_separator = ',';
	//$thousands_separator = '.';
	//US Format
	//THIS CODES COMMENTED BY IZZATY ON 11-10-2011
	//$decimal_precision = 2;
	//$decimals_separator = '.';
	//$thousands_separator = ',';
	//END COMMENTED ON 11-10-2011
	include("languages/en_us/Payslip.php");
	$language = "EN";
	

	$sql="select vtiger_currency_info.currency_symbol from vtiger_currency_info inner join vtiger_users on vtiger_users.currency_id =vtiger_currency_info.id where vtiger_users.id= ".$current_user->id;
	$result = $adb->query($sql);
	$currency_symbol = $adb->query_result($result,0,'currency_symbol');

	//internal number
	$id = $idnumber;

	//retreiving the payment info
	$focus = new Payslip();
	$focus->retrieve_entity_info($_REQUEST['record'],"Payslip");
	//$account_name = decode_html(getAccountName($focus->column_fields['account_id']));
	$payslipno = $focus->column_fields['payslipno'];
	$emp_name=$focus->column_fields['emp_name'];
	$ic_passport=$focus->column_fields['ic_passport'];
	$epf_no=$focus->column_fields['epf_no'];
	$socso_no=$focus->column_fields['socso_no'];
	$tax_no=$focus->column_fields['tax_no'];
	$designation=$focus->column_fields['designation'];
	$pay_month=$focus->column_fields['pay_month'];
	$pay_year=$focus->column_fields['pay_year'];
	$company_details=$focus->column_fields['company_details'];
	$basic_sal=$focus->column_fields['basic_sal'];
	$transport_allowance=$focus->column_fields['transport_allowance'];
	$ph_allowance=$focus->column_fields['ph_allowance'];
	$parking_allowance=$focus->column_fields['parking_allowance'];
	$ot_meal_allowance=$focus->column_fields['ot_meal_allowance'];
	$oth_allowance=$focus->column_fields['oth_allowance'];
	$gross_pay=$focus->column_fields['gross_pay'];
	$net_pay=$focus->column_fields['net_pay'];
	$emp_epf=$focus->column_fields['emp_epf'];
	$emp_socso=$focus->column_fields['emp_socso'];
	$lhdn=$focus->column_fields['lhdn'];
	$zakat=$focus->column_fields['zakat'];
	$other_deduction=$focus->column_fields['other_deduction'];
	$total_deduction=$focus->column_fields['total_deduction'];
	$employer_epf=$focus->column_fields['employer_epf'];
	$employer_socso=$focus->column_fields['employer_socso'];
	$employer_eis=$focus->column_fields['employer_eis'];
	$hrdf=$focus->column_fields['hrdf'];
	$total_comp_contribution=$focus->column_fields['total_comp_contribution'];

	// get owner information
	$sql="SELECT * FROM vtiger_users,vtiger_crmentity WHERE vtiger_users.id = vtiger_crmentity.smownerid AND vtiger_crmentity.crmid = '".$_REQUEST['record']."'";
	$result = $adb->query($sql);
	$owner_lastname = $adb->query_result($result,0,'last_name');
	$owner_firstname = $adb->query_result($result,0,'first_name');
	$owner_phone = $adb->query_result($result,0,'phone_work');
	//display owner?
	$owner = $pdf_config_details['owner'];
	//display owner phone#?
	$ownerphone = $pdf_config_details['ownerphone'];

	// Owner information
	$sql="SELECT * FROM vtiger_users,vtiger_crmentity WHERE vtiger_users.id = vtiger_crmentity.smownerid AND vtiger_crmentity.crmid = '".$id."'";
	$result = $adb->query($sql);
	$owner_lastname = $adb->query_result($result,0,'last_name');
	$owner_firstname = $adb->query_result($result,0,'first_name');

	
	
	// description field for first page
	$description = decode_html($focus->column_fields["description"]);
	// get company and banking information from settings
	//QUERY EDITED BY IZZATY ON 18-10-2011
	$add_query = "select * from vtiger_organizationdetails WHERE organization_id='".$company_details."'"; /* Code modified by liana on 18th Mar, 2010 */



	$result = $adb->query($add_query);
	
	$num_rows = $adb->num_rows($result);
	//CODE ADDED BY IZZATY ON  18-10-2011
	$log->debug("Number of rows:".$num_rows);
	//CODE END ADDED ON 18-10-2011
	
	if($num_rows > 0)
	{
		$org_name = $adb->query_result($result,0,"organizationname");
		$org_address = $adb->query_result($result,0,"address");
		$org_city = $adb->query_result($result,0,"city");
		$org_state = $adb->query_result($result,0,"state");
		$org_country = $adb->query_result($result,0,"country");
		$org_code = $adb->query_result($result,0,"code");
		$org_phone = $adb->query_result($result,0,"phone");
		$org_fax = $adb->query_result($result,0,"fax");
		$org_taxid = $adb->query_result($result,0,"tax_id"); 
		$org_irs = $adb->query_result($result,0,"irs");
		$org_website = $adb->query_result($result,0,"website");

		$logo_name = $adb->query_result($result,0,"logoname");
		//CODE ADDED BY IZZATY ON 18-10-2011
		$log->debug("Value for logo name:".$logo_name);
		/*//CODE END ADDED ON 18-10-2011
		$bank_name = $adb->query_result($result,0,"bankname");
		$bank_street = $adb->query_result($result,0,"bankstreet");
		$bank_city = $adb->query_result($result,0,"bankcity"); 
		$bank_zip = $adb->query_result($result,0,"bankzip");
		$bank_country = $adb->query_result($result,0,"bankcountry");
		$bank_account = $adb->query_result($result,0,"bankaccount");
		$bank_routing = $adb->query_result($result,0,"bankrouting");
		$bank_iban = $adb->query_result($result,0,"bankiban");
		$bank_swift = $adb->query_result($result,0,"bankswift");*/
	}

	/*End codes here*/
	// ************************ BEGIN POPULATE DATA ***************************
	//get the Associated Products for this Sales Order 
	$focus->id = $focus->column_fields["record_id"];
	$associated_products = array_shift(getAssociatedProducts("Payslip",$focus));

	

	//This $final_details array will contain the final total, discount, Group Tax, S&H charge, S&H taxes and adjustment
	$final_details = $associated_products['final_details'];

	//getting the Net Total
	$price_subtotal = $final_details["hdnSubTotal"];
	$price_subtotal_formated = number_format($price_subtotal,$decimal_precision,$decimals_separator,$thousands_separator);

	//Final discount amount/percentage
	$discount_amount = $final_details["discount_amount_final"];
	$discount_percent = $final_details["discount_percentage_final"];

	if($discount_amount != "") 
		{
		$price_discount = $discount_amount;
		$price_discount_formated = number_format($price_discount,$decimal_precision,$decimals_separator,$thousands_separator);
		}
	else if($discount_percent != "")
	{
		//This will be displayed near Discount label 
		$final_price_discount_percent = "(".number_format($discount_percent,$decimal_precision,$decimals_separator,$thousands_separator)." %)";
		$price_discount = ($discount_percent*$final_details["hdnSubTotal"])/100;
		$price_discount_formated = number_format($price_discount,$decimal_precision,$decimals_separator,$thousands_separator);
	}
	else
	{
		$price_discount = "0.00";
	}
	//Adjustment
	$price_adjustment = $final_details["adjustment"];
	$price_adjustment_formated = number_format($price_adjustment,$decimal_precision,$decimals_separator,$thousands_separator);
	//Grand Total
	$price_total = $final_details["grandTotal"];
	$price_total_formated = number_format($price_total,$decimal_precision,$decimals_separator,$thousands_separator);

	//To calculate the group tax amount
	if($final_details['taxtype'] == 'group')
	{
		$group_tax_total = $final_details['tax_totalamount'];
		$price_salestax = $group_tax_total;
		$price_salestax_formated = number_format($price_salestax,$decimal_precision,$decimals_separator,$thousands_separator);

		$group_total_tax_percent = '0.00';
		$group_tax_details = $final_details['taxes'];
		for($i=0;$i<count($group_tax_details);$i++)
		{
			$group_total_tax_percent = $group_total_tax_percent+$group_tax_details[$i]['percentage'];
		}
	}

	//S&H amount
	$sh_amount = $final_details['shipping_handling_charge'];
	$price_shipping_formated = number_format($sh_amount,$decimal_precision,$decimals_separator,$thousands_separator);

	//S&H taxes
	$sh_tax_details = $final_details['sh_taxes'];
	$sh_tax_percent = '0.00';
	for($i=0;$i<count($sh_tax_details);$i++)
	{
		$sh_tax_percent = $sh_tax_percent + $sh_tax_details[$i]['percentage'];
	}
	$sh_tax_amount = $final_details['shtax_totalamount'];
	$price_shipping_tax = number_format($sh_tax_amount,$decimal_precision,$decimals_separator,$thousands_separator);

	//to calculate the individuel tax amounts included we should get all available taxes and then retrieve the corresponding tax values

	$tax_details = getAllTaxes('available');
	$numer_of_tax_types = count($tax_details);
	for($tax_count=0;$tax_count<count($tax_details);$tax_count++)
	{
		$taxtype_listings[taxname.$tax_count] = $tax_details[$tax_count]['taxname'];
		$taxtype_listings[percentage.$tax_count] = $tax_details[$tax_count]['percentage'];
		$taxtype_listings[value.$tax_count] = '0';
	}
	
	//This is to get all prodcut details as row basis

	//Population of current date
	$addyear = strtotime("+0 year");
	$dat_fmt = (($current_user->date_format == '')?('dd-mm-yyyy'):($current_user->date_format));
	$date_issued = (($dat_fmt == 'dd-mm-yyyy')?(date('d-m-Y',$addyear)):(($dat_fmt == 'mm-dd-yyyy')?(date('m-d-Y',$addyear)):(($dat_fmt == 'yyyy-mm-dd')?(date('Y-m-d', $addyear)):(''))));
	$date_issued = str_replace ("-",".",$date_issued);

	// ************************ END POPULATE DATA ***************************
	//************************BEGIN PDF FORMATING**************************
	// Extend the TCPDF class to create custom Header and Footer
	class MYPDF extends TCPDF 
	{
		//modifiy tcpdf class footer
		public function Footer() 
		{
			//To make the function Footer() work properly
			$this->AliasNbPages();

			if (!isset($this->original_lMargin)) 
			{
				$this->original_lMargin = $this->lMargin;
			}
			if (!isset($this->original_rMargin)) 
			{
				$this->original_rMargin = $this->rMargin;
			}
			include("modules/Payslip/pdf_templates/footer.php");
		}
	}
	$page_num='1';
	// create new PDF document
	//$pdf = new PDF( 'P', 'mm', 'A4' );
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true); 
	// set font
	$pdf->SetFont($default_font, " ", $default_font_size);
	$pdf->setPrintHeader(0); //header switched off permanently
	// auto break on
	//$pdf->SetAutoPageBreak(true); 
	// set footer fonts
	//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set pdf information
	$pdf-> SetTitle ($FACTURE." ".$id);
	$pdf-> SetAuthor ($owner_firstname." ".$owner_lastname.", ".$org_name);
	$pdf-> SetSubject ($account_name);
	//CODE ADDED BY IZZATY ON 12-10-2011
	$pdf-> SetSubject ($contact_name);
	//CODE END ADDED ON 12-10-2011
	$pdf-> SetCreator ('CRM System crm-now/PS: www.crm-now.de ');
	//list product names as keywords
	$productlisting = implode(", ",$product_name);
	$pdf-> SetKeywords ($productlisting);
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,PDF_MARGIN_FOOTER);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	//set some language-dependent strings
	$pdf->setLanguageArray($l); 
	//initialize document
	$pdf->AliasNbPages();
	//in reference to body.php -> if a new page must be added if the space available for summary is too small
	$new_page_started = false;
	$pdf->AddPage();
	$pdf-> setImageScale(1.5);

	include("modules/Payslip/pdf_templates/header.php");
	display();
	$pdf->SetFont($default_font, " ", $font_size_body);
	include("modules/Payment/pdf_templates/body.php");
	//formating company name for file name
	$export_org = utf8_decode($account_name);
	//CODE ADDED BY IZZATY ON 12-11-2011
	$export_org = utf8_decode($contact_name);
	//CODE END ADDED ON 12-11-2011
	$export_org = strtolower($export_org);
	$export_org = decode_html(strtolower($export_org));
	$export_org = str_replace ( " ", "", $export_org );

	if ($purpose=='save') {
		// save PDF file at SO
		$pdf->Output($path.$current_id."_".$pdf_strings['FACTURE'].'_'.$date_issued.'.pdf','F'); 
		return $pdf_strings['FACTURE'].'_'.$date_issued.'.pdf';
	}
	// issue pdf
	elseif ($purpose=='print'){
	//COMMENTED AND ADDED BY IZZATY ON 23-12-2011
	//$pdf->Output('Payment_'.$FACTURE.'_'.$date_issued.'.pdf','D');
	$pdf->Output('Payment_'.$account_name.$contact_name.'_'.$date_issued.'.pdf','D');
	//END COMMENTED AND ADDED
	$pdf->Output('storage/Payment_'.$_REQUEST['record'].'.pdf','F'); 
	} 
	elseif ($purpose=='send'){
	// send pdf with mail
		//switch($language)
		//{
			//case "EN":
				$pdf->Output('storage/Payment.pdf','F'); //added file name to make it work in IE, also forces the download giving the user the option to save
				//break;
			//case "DE":
				//$pdf->Output('storage/Bestellung.pdf','F'); //added file name to make it work in IE, also forces the download giving the user the option to save
				//break;
			//case "PL":
				//$pdf->Output('storage/Oferta.pdf','F'); //added file name to make it work in IE, also forces the download giving the user the option to save
				//break;
		//}
		return;
	}
	exit;
}
?>

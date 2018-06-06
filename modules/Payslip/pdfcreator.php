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
	$focus->retrieve_entity_info($_REQUEST['record'],"Payment");
	//$account_name = decode_html(getAccountName($focus->column_fields['account_id']));
	//CODE ADDED BY IZZATY ON 12-10-2011
	//$contact_name = decode_html(getContactName($focus->column_fields['contact_id']));
	//CODE END ADDED ON 12-10-2011
	$Payment_no = $focus->column_fields['paymentno'];

	//get the payment date set
	//$date_to_display_array = array (str_replace ("-",".",getDisplayDate(date("d-m-Y"))));
	$date_created = $focus->column_fields['createdtime']; 
	//$date_array = explode(" ",$payment_date); 
	$date_created = getValidDisplayDate($date_created);
	$date_created = str_replace ("-",".",$date_created);
	//$date_array = explode(" ",$date_created); 
	//$date_to_display_array[1] = str_replace ("-",".",$date_array[0]);
	$date_modified = $focus->column_fields['modifiedtime'];
	//$date_array = explode(" ",$payment_date); 
	$date_modified = getValidDisplayDate($date_modified);
	$date_modified = str_replace ("-",".",$date_modified);
	//$date_array = explode(" ",$date_modified); 
	//$date_to_display_array[2] = str_replace ("-",".",$date_array[0]);
	$date_to_display = $date_to_display_array[$pdf_config_details['dateused']]; 

	//number of lines after headline
	$space_headline = $pdf_config_details['space_headline'];

	//display logo?
	$logoradio = $pdf_config_details['logoradio'];

	//display customer sign?
	$clientid = $pdf_config_details['clientid'];
	
	//display summary?
	$summaryradio = $pdf_config_details['summaryradio'];

	//display footer?
	$footerradio = $pdf_config_details['footerradio'];
	//display footer page number?
	$pageradio = $pdf_config_details['pageradio'];

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

	/* Start of code modified by liana on 18th Mar, 2010 */
	// condition field for last page
	//changes by hazman to fix T&C output : display id instead of T&C
	    //end by hazman
	/* End of code modified by liana on 18th Mar, 2010 */
	
	// description field for first page
	$description = decode_html($focus->column_fields["description"]);
	// get company and banking information from settings
	//QUERY EDITED BY IZZATY ON 18-10-2011
	$add_query = "select * from vtiger_organizationdetails WHERE organizationid='".$focus->column_fields["cf_756"]."'"; /* Code modified by liana on 18th Mar, 2010 */
	//$add_query = "select * from vtiger_organizationdetails";

	//CODE ADDED BY IZZATY ON 18-10-2011
	$log->debug("value for focus cf_756:".$focus->column_fields["cf_756"]);
	//CODE END ADDED ON 18-10-2011	

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
		//CODE END ADDED ON 18-10-2011
		$bank_name = $adb->query_result($result,0,"bankname");
		$bank_street = $adb->query_result($result,0,"bankstreet");
		$bank_city = $adb->query_result($result,0,"bankcity"); 
		$bank_zip = $adb->query_result($result,0,"bankzip");
		$bank_country = $adb->query_result($result,0,"bankcountry");
		$bank_account = $adb->query_result($result,0,"bankaccount");
		$bank_routing = $adb->query_result($result,0,"bankrouting");
		$bank_iban = $adb->query_result($result,0,"bankiban");
		$bank_swift = $adb->query_result($result,0,"bankswift");
	}
	/*Add codes by liana*/
	//QUERY EDITED BY IZZATY ON 19-10-2011
	$paymentid = $_REQUEST['record'];
	$my_query="select vtiger_account.accountname,vtiger_accountbillads.*,vtiger_accountshipads.*,vtiger_payment.*,
vtiger_contactdetails.*, vtiger_contactaddress.* FROM vtiger_payment 
	LEFT JOIN vtiger_account ON vtiger_account.accountid=vtiger_payment.linkto
	LEFT JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid=vtiger_payment.linkto
	LEFT JOIN vtiger_accountbillads ON vtiger_account.accountid=vtiger_accountbillads.accountaddressid
	LEFT JOIN vtiger_accountshipads ON vtiger_account.accountid=vtiger_accountshipads.accountaddressid 
	LEFT JOIN vtiger_contactaddress ON
vtiger_contactdetails.contactid=vtiger_contactaddress.contactaddressid
	WHERE paymentid=$paymentid";
	//QUERY END EDITED
	$my_result=$adb->query($my_query);
	$num_rows=$adb->num_rows($my_result);
	if($num_rows > 0)
	{
		$payment_ref=$adb->query_result($my_result,0,"paymentreference");
		$account_name=$adb->query_result($my_result,0,"accountname");
		//CODE ADDED ON 12-10-2011 BY IZZATY
		$contact_name=$adb->query_result($my_result,0,"firstname");
		$contact_lastname=$adb->query_result($my_result,0,"lastname");
		$relatedto=$adb->query_result($my_result,0,"linkto"); 
		//CODE END ADDED
		$amount=$adb->query_result($my_result,0,"amount");
		$payment_for=$adb->query_result($my_result,0,"paymentfor");
		$ref_no=$adb->query_result($my_result,0,"referenceno");
		$bank_name=$adb->query_result($my_result,0,"bankname");
		$payment_no=$adb->query_result($my_result,0,"paymentno");
	//CODE ADDED BY IZZATY ON 18-10-2011
	//$date_to_display_array = array (str_replace ("-",".",getDisplayDate(date("d-m-Y"))));
	$payment_date = $adb->query_result($my_result,0,"paymentdate"); 
	//$date_array = explode(" ",$payment_date); 
	$payment_date = getValidDisplayDate($payment_date);
	$payment_date = str_replace ("-",".",$payment_date);
	//CODE END ADDED ON 18-10-2011
		//$payment_date=$adb->query_result($my_result,0,"paymentdate");
		$descriptions=$adb->query_result($my_result,0,"description");
		
		/*Billing address*/
		$bill_street=$adb->query_result($my_result,0,"bill_street");
		$bill_code=$adb->query_result($my_result,0,"bill_code");
		$bill_city=$adb->query_result($my_result,0,"bill_city");
		$bill_state=$adb->query_result($my_result,0,"bill_state");
		$bill_country=$adb->query_result($my_result,0,"bill_country");
		
		/*Shipping address*/
		$ship_street=$adb->query_result($my_result,0,"ship_street");
		$ship_code=$adb->query_result($my_result,0,"ship_code");
		$ship_city=$adb->query_result($my_result,0,"ship_city");
		$ship_state=$adb->query_result($my_result,0,"ship_state");
		$ship_country=$adb->query_result($my_result,0,"ship_country");

		//CODE ADDED ON 19-10-2011 BY IZZATY
		/*Mailing address*/
		$mail_street=$adb->query_result($my_result,0,"mailingstreet");
		$mail_city=$adb->query_result($my_result,0,"mailingcity");
		$mail_state=$adb->query_result($my_result,0,"mailingstate");
		$mail_postal=$adb->query_result($my_result,0,"mailingzip");
		$mail_country=$adb->query_result($my_result,0,"mailingcountry");
		/*Other address*/
		$other_street=$adb->query_result($my_result,0,"otherstreet");
		$other_city=$adb->query_result($my_result,0,"othercity");
		$other_state=$adb->query_result($my_result,0,"otherstate");
		$other_postal=$adb->query_result($my_result,0,"otherzip");
		$other_country=$adb->query_result($my_result,0,"othercountry");
		//CODE END ADDED ON 19-10-2011

	}
	/*End codes here*/
	// ************************ BEGIN POPULATE DATA ***************************
	//get the Associated Products for this Sales Order 
	$focus->id = $focus->column_fields["record_id"];
	$associated_products = getAssociatedProducts("Payment",$focus);
	$num_products = count($associated_products);

	//This $final_details array will contain the final total, discount, Group Tax, S&H charge, S&H taxes and adjustment
	$final_details = $associated_products[1]['final_details'];

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
	for($i=1,$j=$i-1;$i<=$num_products;$i++,$j++)
	{
		$product_code[$i] = $associated_products[$i]['hdnProductcode'.$i];
		$product_name[$i] = decode_html($associated_products[$i]['productName'.$i]);
		$prod_description[$i] = decode_html($associated_products[$i]['productDescription'.$i]);
		$qty[$i] = $associated_products[$i]['qty'.$i];
		$qty_formated[$i] = number_format($associated_products[$i]['qty'.$i],$decimal_precision,$decimals_separator,$thousands_separator);
		$comment[$i] = decode_html($associated_products[$i]['comment'.$i]);
		$unit_price[$i] = number_format($associated_products[$i]['unitPrice'.$i],$decimal_precision,$decimals_separator,$thousands_separator);
		$list_price[$i] = number_format($associated_products[$i]['listPrice'.$i],$decimal_precision,$decimals_separator,$thousands_separator);
		$list_pricet[$i] = $associated_products[$i]['listPrice'.$i];
		$discount_total[$i] = $associated_products[$i]['discountTotal'.$i];
		$discount_totalformated[$i] = number_format($associated_products[$i]['discountTotal'.$i],$decimal_precision,$decimals_separator,$thousands_separator);
		//added by crm-now
		$usageunit[$i] = $associated_products[$i]['usageunit'.$i];
		//look whether the entry already exists, if the translated string is available then the translated string other wise original string will be returned
		$usageunit[$i] = getTranslatedString($usageunit[$i], 'Products');
		$taxable_total = $qty[$i]*$list_pricet[$i]-$discount_total[$i];

		$producttotal = $taxable_total;
		$total_taxes = '0.00';
		
		
		if($focus->column_fields["hdnTaxType"] == "individual")
		{
			$total_tax_percent = '0.00';
			//This loop is to get all tax percentage and then calculate the total of all taxes
			for($tax_count=0;$tax_count<count($associated_products[$i]['taxes']);$tax_count++)
			{
				$tax_percent = $associated_products[$i]['taxes'][$tax_count]['percentage'];
				$total_tax_percent = $total_tax_percent+$tax_percent;
				$tax_amount = (($taxable_total*$tax_percent)/100);
				//calculate the tax amount for any available tax percentage
				$detected_tax = substr(array_search ($total_tax_percent,$taxtype_listings), -1);
				$taxtype_listings [value.$detected_tax] = $taxtype_listings [value.$detected_tax]+$tax_amount;
				$total_taxes = $total_taxes+$tax_amount;
			}
			$producttotal = $taxable_total+$total_taxes;
			$product_line[$j][$pdf_strings['Tax']] = " ($total_tax_percent %) ".number_format($total_taxes,$decimal_precision,$decimals_separator,$thousands_separator);
		    // combine product name, description and comment to one field based on settings
		}

	    // combine product name, description and comment to one field based on settings
		if($focus->column_fields["hdnTaxType"] == "individual") $product_selection = $iproddetails;
		else $product_selection = $gproddetails;
			switch($product_selection)
			{
			    case 1:
						$product_name_long[$i] = $product_name[$i];
			    break;
			    case 2:
						$product_name_long[$i] = $prod_description[$i];
			    break;
			    case 3:
						$product_name_long[$i] = $product_name[$i]."\n".$prod_description[$i];
			    break;
			    case 4:
						$product_name_long[$i] = $comment[$i];
			    break;
			    case 5:
						$product_name_long[$i] = $product_name[$i]."\n".$comment[$i];
			    break;
			    case 6:
					if ($prod_description[$i]!=''){
						$product_name_long[$i] = $prod_description[$i]."\n".$comment[$i];
						}
					else
						$product_name_long[$i] = $comment[$i];
			    break;
			    case 7:
					if ($prod_description[$i]!=''){
						$product_name_long[$i] = $product_name[$i]."\n".$prod_description[$i]."\n".$comment[$i];
						}
					else
						$product_name_long[$i] = $product_name[$i]."\n".$comment[$i];
			    break;
			    default:
					if ($prod_description[$i]!=''){
						$product_name_long[$i] = $product_name[$i]."\n".$prod_description[$i]."\n".$comment[$i];
						}
					else
						$product_name_long[$i] = $product_name[$i]."\n".$comment[$i];
			    break;
			}

		$prod_total[$i] = number_format($producttotal,$decimal_precision,$decimals_separator,$thousands_separator);

		$product_line[$j][$pdf_strings['Position']] = $j+1;
		$product_line[$j][$pdf_strings['OrderCode']] = $product_code[$i];
		$product_line[$j][$pdf_strings['Description']] = $product_name_long[$i];
		$product_line[$j][$pdf_strings['Qty']] = $qty_formated[$i];
		$product_line[$j][$pdf_strings['Unit']] = $usageunit[$i];
		$product_line[$j][$pdf_strings['UnitPrice']] = $list_price[$i];
		$product_line[$j][$pdf_strings['Discount']] = $discount_totalformated[$i];
		$product_line[$j][$pdf_strings['LineTotal']] = $prod_total[$i];

	}

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
			include("modules/Payment/pdf_templates/footer.php");
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
	//$pdf->SetY(PDF_MARGIN_HEADER);
	include("modules/Payment/pdf_templates/header.php");
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

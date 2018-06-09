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

 	require_once('include/logging.php');
	$log =& LoggerManager::getLogger('pdfcreator');

	global $FOOTER_PAGE, $default_font, $font_size_footer, $NUM_FACTURE_NAME, $pdf_strings, $Payment_no, $footer_margin;
	global $org_name, $org_address, $org_city, $org_code, $org_country, $org_irs, $org_taxid, $org_phone, $org_fax, $org_website;
	global $account_name,$contact_name,$contact_lastname,$relatedto;
	global $VAR40_NAME, $VAR3_NAME, $VAR4_NAME,$ORG_POSITION,$VAR_PAGE, $VAR_OF;
	global $bank_name , $bank_street , $bank_city ,$bank_zip ,$bank_country, $bank_account, $bank_routing, $bank_iban, $bank_swift;
	global $ACCOUNT_NUMBER, $ROUTING_NUMBER, $SWIFT_NUMBER, $IBAN_NUMBER;
	global $columns, $logoradio, $logo_name, $footerradio, $pageradio;
	global $adb,$app_strings,$focus,$current_user;
	$module = 'Payslip';
	if ($default_font =='') $default_font = 'Helvetica';
	include("languages/en_us/Payslip.php");
	$language = "EN";
	


	


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
	$pdf->SetFont($default_font, " ", '10');
	$pdf->setPrintHeader(0); //header switched off permanently

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set pdf information
	$pdf-> SetSubject ($account_name);
	//CODE ADDED BY IZZATY ON 12-10-2011
	$pdf-> SetSubject ($contact_name);
	//CODE END ADDED ON 12-10-2011
	$pdf-> SetCreator ('CRM System crm-now/PS: www.crm-now.de ');
	//list product names as keywords
	//Disable automatic page break
	$pdf->SetAutoPageBreak(true,PDF_MARGIN_FOOTER);
	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 
	//set some language-dependent strings
	//$pdf->setLanguageArray($l);
	//initialize document
	$pdf->AliasNbPages();
	//in reference to body.php -> if a new page must be added if the space available for summary is too small
	$new_page_started = false;
	$pdf->AddPage();
	$pdf-> setImageScale(1.5);

	include("modules/Payslip/pdf_templates/header.php");
	//display();
	$pdf->SetFont($default_font, " ", '12');
	include("modules/Payslip/pdf_templates/body.php");
	//formating company name for file name
	$export_org = utf8_decode($account_name);
	//CODE ADDED BY IZZATY ON 12-11-2011
	$export_org = utf8_decode($contact_name);
	//CODE END ADDED ON 12-11-2011
	$export_org = strtolower($export_org);
	$export_org = decode_html(strtolower($export_org));
	$export_org = str_replace ( " ", "", $export_org );

				$pdf->Output('storage/Payment.pdf','D'); //added file name to make it work in IE, also forces the download giving the user the option to save

		return;
	exit;
}
?>

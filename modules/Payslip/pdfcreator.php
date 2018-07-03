<?php
/* ===================================================================
Modified By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 21 / 11 / 2009
Change Reason: Pdf Cinfigurator change, File overwritten
=================================================================== */

/*********************************************************************************
** Created By Nirbhay Shah
 ********************************************************************************/
function createpdffile ($payslipid,$purpose='', $path='',$current_id='') {

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
	

	global $adb;
	//$adb->setDebug(true);
	$query = "SELECT * FROM vtiger_payslip INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_payslip.payslipid INNER JOIN vtiger_users ON vtiger_users.id = vtiger_payslip.emp_name WHERE vtiger_crmentity.deleted = 0 AND payslipid = ?";
	$result = $adb->pquery($query,array($payslipid));

    $emp_name = $adb->query_result($result,0,'first_name');
    $userid = $adb->query_result($result,0,'id');
    $company_details = $adb->query_result($result,0,'company_details');
    $designation = $adb->query_result($result,0,'designation');
    $ic_passport = $adb->query_result($result,0,'ic_passport');
    $epf_no = $adb->query_result($result,0,'epf_no');
    $socso_no = $adb->query_result($result,0,'socso_no');
    $tax_no = $adb->query_result($result,0,'tax_no');
    $pay_month = $adb->query_result($result,0,'pay_month');
    $pay_year = $adb->query_result($result,0,'pay_year');
    $basic_sal = $adb->query_result($result,0,'basic_sal');
    $transport_allowance = $adb->query_result($result,0,'transport_allowance');
    $ph_allowance = $adb->query_result($result,0,'ph_allowance');
    $parking_allowance = $adb->query_result($result,0,'parking_allowance');
    $ot_meal_allowance = $adb->query_result($result,0,'ot_meal_allowance');
    $oth_allowance = $adb->query_result($result,0,'oth_allowance');
    $gross_pay = $adb->query_result($result,0,'gross_pay');
    $net_pay = $adb->query_result($result,0,'net_pay');
    $emp_epf = $adb->query_result($result,0,'emp_epf');
    $emp_socso = $adb->query_result($result,0,'emp_socso');
    $lhdn = $adb->query_result($result,0,'lhdn');
    $zakat = $adb->query_result($result,0,'zakat');
    $other_deduction = $adb->query_result($result,0,'other_deduction');
    $total_deduction = $adb->query_result($result,0,'total_deduction');
    $employer_epf = $adb->query_result($result,0,'employer_epf');
    $employer_socso = $adb->query_result($result,0,'employer_socso');
    $employer_eis = $adb->query_result($result,0,'employer_eis');
    $hrdf = $adb->query_result($result,0,'hrdf');
    $total_comp_contribution = $adb->query_result($result,0,'total_comp_contribution');
    //echo  $emp_name;die;

    /**
     * Query to add Emp Designation
     */


	$query1 = "SELECT department FROM vtiger_crmentity INNER JOIN vtiger_employeecontract ON vtiger_crmentity.crmid = vtiger_employeecontract.employeecontractid WHERE deleted = 0 AND setype = 'EmployeeContract' AND smownerid = ? ORDER BY createdtime DESC";

	$result1 = $adb->pquery($query1,array($userid));

    $dept = $adb->query_result($result1,0,'department');


    /**
     * Query to add Company Details
     */


    $query2 = "SELECT * FROM vtiger_organizationdetails WHERE organization_id = ?";

    $result2 = $adb->pquery($query2,array($company_details));

    $organization_title = $adb->query_result($result2,0,'organization_title');
    $organizationname = $adb->query_result($result2,0,'organizationname');
    $address = $adb->query_result($result2,0,'address');
    $city = $adb->query_result($result2,0,'city');
    $state = $adb->query_result($result2,0,'state');
    $country = $adb->query_result($result2,0,'country');
    $code = $adb->query_result($result2,0,'code');
    $phone = $adb->query_result($result2,0,'phone');
    $fax = $adb->query_result($result2,0,'fax');
    $website = $adb->query_result($result2,0,'website');
    $vatid = $adb->query_result($result2,0,'vatid');
   // $title = $adb->query_result($result2,0,'department');

    //die;
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
	//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set pdf information
	$pdf-> SetSubject ($account_name);
	//CODE ADDED BY IZZATY ON 12-10-2011
	$pdf-> SetSubject ($contact_name);
	//CODE END ADDED ON 12-10-2011
	//$pdf-> SetCreator ('CRM System crm-now/PS: www.crm-now.de ');
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

	//include("modules/Payslip/pdf_templates/header.php");
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

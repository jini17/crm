<?php
/* ===================================================================
Modified By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 21 / 11 / 2009
Change Reason: Pdf Cinfigurator change, File overwritten
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the GPL License v.3.0
 * You may not use this file except in compliance with the License
 * The Original Code is:  crm-now, www.crm-now.de
 * All Rights Reserved.
*
 ********************************************************************************/
$name_ceo ="John Brown";
$irs_number ="123456";
$org_taxid ="383484848";
$bank_account ="37373737";
$bank_routing ="556677";
$bank_name ="Sample Bank";
$bank_swift = "SW 34333";
$bank_iban ="ENG 000111";
global $footerradio, $pageradio;
global $FOOTER_PAGE, $default_font, $font_size_footer, $SalesOrder_no, $NUM_FACTURE_NAME, $pdf_strings, $footer_margin;
global $org_name, $org_address, $org_city, $org_code, $org_country, $org_irs, $org_taxid, $org_phone, $org_fax, $org_website;
global $VAR_PAGE, $VAR_OF;
//bank information - labels from language files
global $ACCOUNT_NUMBER, $ROUTING_NUMBER, $SWIFT_NUMBER, $IBAN_NUMBER;
$this->SetFont($default_font,'',$font_size_footer);
if ($footerradio =='true') {
	$this->SetTextColor(120,120,120,true);
	//*** first column
	$this->SetFont($default_font,'',$font_size_footer);
	$this->SetXY(PDF_MARGIN_LEFT , -PDF_MARGIN_FOOTER+8);
	$this->Cell(20,4,$org_name,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT , -PDF_MARGIN_FOOTER+12);
	$this->Cell(20,4,$org_address,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT , -PDF_MARGIN_FOOTER+16);
	$this->Cell(20,4,$org_code." ".$org_city,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT , -PDF_MARGIN_FOOTER+20);
	$this->Cell(20,4,$org_country,0,0,'L');
	//draw line
	$x =PDF_MARGIN_LEFT+43;
	$this->SetDrawColor(120,120,120);
	$this->Line($x,$this->h - PDF_MARGIN_FOOTER+9,$x,$this->h - PDF_MARGIN_FOOTER+23);
	//*** second column
	$this->SetXY(PDF_MARGIN_LEFT+45 , -PDF_MARGIN_FOOTER+8);
	$this->Cell(20,4,$pdf_strings['VAR_PHONE']." ".$org_phone,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+45 , -PDF_MARGIN_FOOTER+12);
	$this->Cell(20,4,$pdf_strings['VAR_FAX']." ".$org_fax,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+45 , -PDF_MARGIN_FOOTER+16);
	$this->Cell(20,4,$pdf_strings['VAR_TAXID'].' '.$org_taxid,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+45 , -PDF_MARGIN_FOOTER+20);
	$this->Cell(20,4,$org_irs,0,0,'L');
	//draw line
	$x =PDF_MARGIN_LEFT+83;
	$this->Line($x,$this->h - PDF_MARGIN_FOOTER+9,$x,$this->h - PDF_MARGIN_FOOTER+23);

	//third column
	$this->SetXY(PDF_MARGIN_LEFT+85 , -PDF_MARGIN_FOOTER+8);
	$this->Cell(20,4,$bank_name,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+85 , -PDF_MARGIN_FOOTER+12);
	$this->Cell(20,4,$pdf_strings['ACCOUNT_NUMBER']." ".$bank_account,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+85 , -PDF_MARGIN_FOOTER+16);
	$this->Cell(20,4,$pdf_strings['ROUTING_NUMBER']." ".$bank_routing,0,0,'L');
	//draw line
	$x =PDF_MARGIN_LEFT+130;
	$this->Line($x,$this->h - PDF_MARGIN_FOOTER+9,$x,$this->h - PDF_MARGIN_FOOTER+23);

	//fourth column
	$this->SetXY(PDF_MARGIN_LEFT+132 , -PDF_MARGIN_FOOTER+8);
	$this->Cell(20,4,$pdf_strings['SWIFT_NUMBER']." ".$bank_swift,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+132 , -PDF_MARGIN_FOOTER+12);
	$this->Cell(20,4,$pdf_strings['IBAN_NUMBER']." ".$bank_iban,0,0,'L');
	$this->SetXY(PDF_MARGIN_LEFT+132 , -PDF_MARGIN_FOOTER+16);
	$this->Cell(20,4,$org_website,0,0,'L');
}
if ($pageradio =='true') {
	//reset colors
	$this->SetTextColor(0,0,0,true);				
	//Print page number with quote id
	$this->SetXY(PDF_MARGIN_LEFT, -PDF_MARGIN_FOOTER+22);
	if (trim($requisition_no) != '') $SOID = $requisition_no;
	else $SOID = $SalesOrder_no;
	$this->Cell(0,10,$pdf_strings['NUM_FACTURE_NAME'].' '.$SOID.', '.$pdf_strings['VAR_PAGE'].' '.$this->PageNo().' '.$pdf_strings['VAR_OF'].' '.$this->getAliasNbPages(),0,0,'C');
}
	//reset colors
	$this->SetTextColor(0,0,0,true);				
?>
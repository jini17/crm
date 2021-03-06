<?php
/* ===================================================================
Modified By: Sakti Prasad Mishra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 21 / 11 / 2009
Change Reason: Pdf Cinfigurator change, File overwritten
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  crm-now, www.crm-now.com
* Portions created by crm-now are Copyright (C)  crm-now c/o im-netz Neue Medien GmbH.
* All Rights Reserved.
 *
 ********************************************************************************/
//CODES COMMENTED BY IZZATY ON 14-10-2011
//$pdf-> SetTitle ($FACTURE." ".$org_name);
// set pdf information
//$pdf-> SetAuthor ($contact_name);
$pdf-> SetSubject ($account_name);
$pdf-> SetCreator ('CRM System crm-now/PS: www.crm-now.de ');
//list product names as keywords
//$productlisting = implode(", ",$product_name);
//$pdf-> SetKeywords ($productlisting);
//CODES END COMMENTED ON 14-10-2011
$pdf-> setImageScale(1.5);



//CODES ADDED BY IZZATY ON 14-10-2011
require_once('include/logging.php');
$log =& LoggerManager::getLogger('header');
//CODES END ADDED ON 14-10-2011
global $logo_name;
//CODES ADDED BY IZZATY ON 14-10-2011
$log->debug("angel is here:".$logo_name);



// ************* Begin Top-Right Header ***************


		$pdf = $parent->getPDF();
		$pdf->SetFont('Helvetica', '', 11);
		$headerFrame = $parent->getHeaderFrame();
		$headerColumnWidth = $headerFrame->w/3.0;
		$pdfsettings = $this->model->get('pdfsettings'); 
		
		$modelColumns = $this->model->get('columns');
		$modelColumn0 = $modelColumns[0];
		$modelColumn2 = $modelColumns[2];
		$pdf->setCellPadding(5);
		$vatlabel = getTranslatedString('VATID');
//set location
$xmargin = '150';
$ymargin = '30';
$xdistance = '25';
$pdf->SetXY($xmargin,$ymargin);
// define standards
$pdf->SetFont($default_font,'',$font_size_header);

// so number-label
$paymentNo=decode_html($payment_no);
$pdf->SetXY('149','27');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['NUM_FACTURE_NAME'],0,0);
$pdf->SetXY('170','27');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
//$pdf->text($xmargin+25,$ymargin,$paymentNo);

//so number-content
//we get the SO # from the entry field, if not set the record id is used
if (trim($requisition_no) != '') $pdf->text($xmargin+$xdistance,$ymargin,$requisition_no);
else $pdf->text($xmargin+$xdistance,$ymargin,$Payment_no);
//so date
$pdf->SetFont($default_font,'',$font_size_header);
//so date - label
$pdf->text($xmargin,$ymargin+5,$pdf_strings['DATE']);
$pdf->SetXY('170','32'); 
$pdf->Cell(20,$pdf->getFontSize(),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+25,$ymargin+5,$date_issued);
//$pdf->text($xmargin+25,$ymargin+5,date(getNewDisplayDate()));
//delivery date
$pdf->SetFont($default_font,'',$font_size_header);
//so delivery - label
$paymentDate=decode_html($payment_date);
$pdf->text($xmargin,$ymargin+10,$pdf_strings['PAYMENTDATE']);
$pdf->SetXY('170','37');
$pdf->Cell(20,$pdf->getFontSize(),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+25,$ymargin+10,$paymentDate);
//so delivery -content
$pdf->text($xmargin+$xdistance,$ymargin+10,$delivery_date);

//print owner if requested
if ($owner =='true'){
	//owner label
	$pdf->text($xmargin,$ymargin+15,$pdf_strings['ISSUER']);
	//owner-content
	$pdf->text($xmargin+$xdistance,$ymargin+15,$owner_firstname.' '.$owner_lastname);
}
if ($ownerphone =='true'){
	//owner label
	$pdf->text($xmargin,$ymargin+20,$pdf_strings['PHONE']);
	//owner-content
	$pdf->text($xmargin+$xdistance,$ymargin+20,$owner_phone);
}
//print customer markif set
if ($clientid =='true'){
	if ($customermark!='')
	{
		// label
		$pdf->text($xmargin,$ymargin+25,$pdf_strings['YOUR_SIGN']);
		//content
		$pdf->text($xmargin+$xdistance,$ymargin+25,$customermark);
	}
}

//to add contact name in the top right corner(by Ahmed@24/03/2011)

//end add
// used to define the y location for the body
$ylocation_rightheader= $pdf->GetY();
// ************** End Top-Right Header *****************

// ************** Begin Top-Left Header **************
// Address
$xmargin = '20';
$ymargin = '35';
//senders info
$pdf->SetTextColor(120,120,120);
// companyBlockPositions -> x,y,width
/*
$companyText=$org_name." - ".$org_address." - ".$org_code." ".$org_city;
$pdf->SetFont($default_font,'B',6);
$pdf->text($xmargin+1,$ymargin,$companyText);
 *

$pdf->SetTextColor(0,0,0);
$pdf->SetFont($default_font,'B',$font_size_address);
$billPositions = array($xmargin,$ymargin,"60");
if ($contact_name!='') 
{
	if ($bill_country!='Deutschland') {
		if ($contact_department!='') 
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
		else
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
	}
	else {
		if ($contact_department!='') 
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
		else
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
	}
}
elseif ($bill_country!='Deutschland') $billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
else $billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city;

$pdf->SetFont($default_font, "", $font_size_address);
$pdf->SetXY ($xmargin,$ymargin);
$pdf->MultiCell(60,$pdf->getFontSize(), $billText,0,'L');

*/
//add by liana on 22022010
$companyText=decode_html ($org_name);
$company_org_add_Text=decode_html ($org_address);
$company_org_Text=decode_html ($org_code." ".$org_city);
$company_phone=decode_html($org_phone);
$company_fax=decode_html($org_fax);
$pdf->SetFont($default_font,'B',11);
$pdf->text($xmargin,$ymargin,$companyText);
$pdf->SetFont($default_font,'B',9);
$pdf->text($xmargin,$ymargin+4,$company_org_add_Text);
$pdf->text($xmargin,$ymargin+8,$company_org_Text);
$pdf->SetXY('19','44');
$pdf->Cell(20,$pdf->getFontSize(),$pdf_strings['Label_tel'],0,0);
$pdf->text($xmargin+7.5,$ymargin+12,$company_phone);
$pdf->SetXY('19','48');
$pdf->Cell(20,$pdf->getFontSize(),$pdf_strings['Label_fax'],0,0);
$pdf->text($xmargin+7.5,$ymargin+16,$company_fax);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont($default_font,'B',$font_size_address);
$billPositions = array($xmargin,$ymargin,"60");


if ($contact_name!='') 
{
	if ($bill_country!='Deutschland')
	 {
		if ($contact_department!='') 
		{
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;	
			$shipText=$account_name."\n".$contact_department."\n".$contact_name."\n".$ship_street."\n".$ship_code." ".$ship_city."\n".$ship_country;		
			//CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS FROM CONTACTS
			$mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
			$otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n ".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
			//CODE END ADDED ON 19-10-2011
		}
		else
		{
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
			$shipText=$account_name."\n".$contact_name."\n".$ship_street."\n".$ship_code." ".$ship_city."\n".$ship_country;	
			//CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS FROM CONTACTS
			$mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
			$otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
			//CODE END ADDED ON 19-10-2011
		}
	}
	else
	 {
		if ($contact_department!='') 
		{
			$billText=$account_name."\n".$contact_department."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
			$shipText=$account_name."\n".$contact_department."\n".$contact_name."\n".$ship_street."\n".$ship_code." ".$ship_city;	
			//CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS FROM CONTACTS
			$mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
			$otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
			//CODE END ADDED ON 19-10-2011
		}
		else
		{
			$billText=$account_name."\n".$contact_name."\n".$bill_street."\n".$bill_code." ".$bill_city;
			$shipText=$account_name."\n".$contact_name."\n".$ship_street."\n".$ship_code." ".$ship_city;
			//CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS FROM CONTACTS
			$mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
			$otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
			//CODE END ADDED ON 19-10-2011
		}
	}
}

elseif ($bill_country!='Deutschland')
{
     $billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
     $shipText=$account_name."\n".$ship_street."\n".$ship_code." ".$ship_city."\n".$ship_country;
     //CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS
     $mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
     $otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n ".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
   //CODE END ADDED ON 19-10-2011
}
else
{
     $billText=$account_name."\n".$bill_street."\n".$bill_code." ".$bill_city."\n".$bill_country;
     $shipText=$account_name."\n".$ship_street."\n".$ship_code." ".$ship_city."\n".$ship_country;
    //CODE ADDED BY IZZATY ON 19-10-2011 FOR OTHER ADDRESS
    $mailText=$contact_name." ".$contact_lastname."\n".$mail_street."\n".$mail_postal." ".$mail_city."\n".$mail_state."\n".$mail_country;
    $otherText=$contact_name." ".$contact_lastname."\n".$other_street."\n".$other_postal." ".$other_city."\n".$other_state."\n".$other_country;
   //CODE END ADDED ON 19-10-2011
}

$pdf->SetXY('20','57.5');
$pdf->Cell(20,$pdf->SetFont('Helvetica',"B",10),$pdf_strings['BILL'],0,0);
//CODE ADDED BY IZZATY ON 19-10-2011 TO PRINT ACCOUNT/CONTACT BILL/MAIL ADDRESS
if ($contact_name!='') 
{
  if ($contact_department!='') 
  {
    $billText = decode_html ($billText);
  }
  else
  {
    $billText = decode_html ($mailText);
  }
}
//CODE END ADDED ON 19-10-2011

$pdf->SetXY('100','57.5');
$pdf->Cell(20,$pdf->SetFont('Helvetica',"B",10),$pdf_strings['SHIP'],0,0);
//CODE ADDED BY IZZATY ON 19-10-2011 TO PRINT ACCOUNT/CONTACT ADDRESS SHIP/OTHER ADDRESS
if ($contact_name!='') 
{
  if ($contact_department!='') 
  {
    $shipText=decode_html ($shipText);
  }
  else
  {
    $shipText=decode_html ($otherText);
  }
}
//CODE END ADDED ON 19-10-2011
 
//end

$pdf->SetFont($default_font, "", $font_size_address);
$pdf->SetXY ($xmargin,$ymargin+27);
$pdf->MultiCell(60,$pdf->SetFont('Helvetica','',9), $billText,0,'L');

$pdf->SetXY ($xmargin+80,$ymargin+27);
$pdf->Multicell(60,$pdf->SetFont('Helvetica','',9),$shipText,0,'L');



$pdf->SetTextColor(0,0,0);
$pdf->SetFont($default_font,'B',$font_size_address);

// ********** End Top-Left Header ******************
//***** empty space below the address required ************
$pdf->SetTextColor(255,255,255); 
		//Line break
		$pdf->Ln(20);
//set start y location for body
if ($pdf->GetY() > $ylocation_rightheader) $ylocation_after = $pdf->GetY();
else $ylocation_after = $ylocation_rightheader;
$pdf->SetTextColor(0,0,0);

?>

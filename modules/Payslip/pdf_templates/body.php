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
//definitions
// get y location info from header
//ADDED BY IZZATY ON 18-10-2011
global $account_name,$contact_name,$contact_lastname,$relatedto;
//END ADDED
$ymargin__below_header = $ylocation_after;
//color for text
$pdf->SetTextColor(0,0,0);
//color for lines
$pdf->SetDrawColor(180,180,180);
// distance between lines and product rows
$line_distance = 2;
$line_distance_products = 4;
//at first page include headline with description 
//write the headline
$pdf->SetXY( PDF_MARGIN_LEFT, $ymargin__below_header-3);
$pdf->SetFont( $default_font, "B", $font_size_body+10);
$pdf->Cell($pdf->GetStringWidth($pdf_strings['FACTURE']),$pdf->SetFont('Helvetica',B,10), $pdf_strings['FACTURE'],0,1);
$pdf->SetFont( $default_font, "", $font_size_body);
//insert empty line below headline
for($l=0;$l< $space_headline;$l++) {
	$pdf->Ln($pdf->getFontSize());
}
//write the contents of the description field
//$pdf->MultiCell('180',$line_distance, $description,0,'L',0);
$current_y_location = $pdf->GetY();
//insert empty line below description
$pdf->Ln($pdf->getFontSize());
/* ************ Begin Table Setup ********************** */
// Each of these arrays needs to have matching keys
// "key" => "Length"
// space for the total of columns depends on the x_margin
// for x_margin= 20 (DIN 5008 = 2cm left margin ) total of columns needs to be 180 in order to fit the table correctly
//get colums settings from DB
// *** enabled=1 means that this column is part of a possible selection
// *** seleced = checked menas that the colums is part of the selection if enabled=1
$pdfcolumnsettings = getAllPDFColums ($module);
$column_body_content_group_sel= $pdfcolumnsettings[0];
$column_body_content_individual_sel= $pdfcolumnsettings[1];
$columnline_positions = array('Position'=>'R','OrderCode'=>'L','Description'=>'L','Qty'=>'R','Unit'=>'R','UnitPrice'=>'R','Discount'=>'R','Tax'=>'R','LineTotal'=>'R');
if($focus->column_fields["hdnTaxType"] == "individual") $column_body_content = $pdfcolumnsettings[1];
else $column_body_content = $pdfcolumnsettings[0];
// the maximum width of all columns must bec 180
//the width for each column if all columns are selected is predefined, if a column gets unchecked the space is added to the description column 
$columnwidth_taken =0;
//define the column positions and sizes
foreach ($column_body_content as $key => $value) {
		if ($value['selected'] =='checked="checked"' and $value['enabled'] =='1')
		{
			$colsAlign[$pdf_strings[$key]] = $columnline_positions[$key] ;
			$current_columnwidht = getcolumnwidht($key,$focus->column_fields["hdnTaxType"]);
			$cols[$pdf_strings[$key]] = $current_columnwidht;
			$columnwidth_taken = $columnwidth_taken + $current_columnwidht;
		}
	}
$cols[$pdf_strings[' ']] = $cols[$pdf_strings[' ']]+ (180 - $columnwidth_taken);

//***********begin product list table header ******************/ 
$x_value     = PDF_MARGIN_LEFT;
foreach ($cols as $lib =>$pos)
{
	$text = $lib;
	$pdf->SetX($x_value-2);
	$pdf->Cell($pos,$pdf->getFontSize(),$text,0,0,$colsAlign[$lib],0,0);
	$x_value += $pos;
}
$pdf->Ln($pdf->getFontSize()); 
$line_y_location= $pdf->GetY();

//***********end product list table header ******************/

/*Add codes by LIANA*/

//$pdf->SetFont('Times','',12);
$paymentRef=decode_html($payment_ref);
//$contact_name=decode_html($contact_name);
//$account_name=decode_html($account_name);
//CODE BY IZZATY ON 12-10-2011
//$relatedToContact=decode_html($contact_name);
//CODE END ADDED
$relatedTo=decode_html($account_name);
$relatedTo=decode_html($contact_name);
$amount=decode_html($amount);
$paymentFor=decode_html($payment_for);
$refNo=decode_html($ref_no);
$bankName=decode_html($bank_name);
$descriptions=decode_html($descriptions);

$pdf->SetXY('20','110');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['PaymentRef'],0,0);
$pdf->SetXY('90','110');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+78,$paymentRef);

$pdf->SetXY('20','115');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['RelatedTo'],0,0);
$pdf->SetXY('90','115');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+83,$account_name);
//CODE ADDED BY IZZATY ON 19-10-2011 TO PRINT FIRSTNAME AND LASTNAME CONTINUOSLY
$pdf->text($xmargin+77,$ymargin+83,$contact_name." ".$contact_lastname);
//END ADDED ON 19-10-2011
//THIS CODE WAS COMMENTED BY IZZATY ON 19-10-2011
//$pdf->text($xmargin+77,$ymargin+86.5,$contact_lastname);
//END COMMENTED ON 19-10-2011

$pdf->SetXY('20','120');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Amount'],0,0);
$pdf->SetXY('90','120');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+88,$amount);

$pdf->SetXY('20','125');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['PaymentFor'],0,0);
$pdf->SetXY('90','125');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+93,$paymentFor);

$pdf->SetXY('20','130');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['RefNo'],0,0);
$pdf->SetXY('90','130');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+98,$refNo);

$pdf->SetXY('20','135');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['BankName'],0,0);
$pdf->SetXY('90','135');
$pdf->Cell(20,$pdf->SetFont('Helvetica','',9),$pdf_strings['Colon'],0,0);
$pdf->text($xmargin+77,$ymargin+103,$bankName);

$pdf->SetXY('20','155');
$pdf->Cell(20,$pdf->SetFont('Helvetica',"B",10),$pdf_strings['Descriptions'],0,0);
$pdf->Ln(7);
$pdf->SetFont( 'Helvetica', '',9);
$pdf->MultiCell(0,0,$descriptions,'','L');
/*End codes added here*/



/******** start populating conditions ****************/
//assuming for condition width = 180 (full page width) 
$pdf->SetFont( $default_font, "", $font_size_body);
//set distance to summary
$current_y_location  = $line_y_location + 3*$line_distance;
$pdf->SetXY(PDF_MARGIN_LEFT, $current_y_location);
$pdf->MultiCell('180',$line_distance, $conditions,0,'L',0);

function getcolumnwidht($column,$taxmode) {
	$max = '180';
	$reserved = '78';
	If ($taxmode =='individual') $defined_columnsizes = array('Position'=>'10','OrderCode'=>'20','Description'=>'21','Qty'=>'15','Unit'=>'20','UnitPrice'=>'22','Discount'=>'15','Tax'=>'32','LineTotal'=>'25');
	else $defined_columnsizes = array('Position'=>'10','OrderCode'=>'20','Description'=>'53','Qty'=>'15','Unit'=>'20','UnitPrice'=>'22','Discount'=>'15', 'LineTotal'=>'25');
	$columnswidth = $defined_columnsizes[$column];
return $columnswidth;
}


?>

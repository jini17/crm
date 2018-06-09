<?php

ob_start();
/* ************** header.jpg *********************** */
//$pdf->Image('test/logo/amslogo.png', $x='45', $y='25', $w='120', $h='10', $type='', $link='', $align='center', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
/* ************** End header *********************** */



$xmargin = '20';
$ymargin = '40';
//$modulename=decode_html("");
$pdf->SetFont($default_font,'',10.5);
//$pdf->MultiCell(160,$pdf->getFontSize(),$modulename,0,'C',0,0,$xmargin,$ymargin);

/*********************Start Section A**************************/
# Start Payments table in HTML by Haziq
$pdf->Ln(13);
$html = <<<EOD

<p align="right">Soft Solvers Solutions Sdn Bhd<br />(890813-X)<br />C2-3-7, Block C2, CBD Perdana 3, Persiaran Cyberpoint<br />Timur, Cyber 12, 63000 Cyberjaya, Selangor.<br />0386874433</p>


EOD;

// output the HTML content
$pdf->writeHTML($html, true, false, false, false, '');
# End
//End Page 2




/* ************** enddate.jpg *********************** */
//$pdf->Image('test/logo/date.jpg', $x='10', $y=$line_y_location+15 , $w='190', $h='120', $type='', $link='', $align='center', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
/* ************** enddate *********************** */

/* ************** enddate.jpg *********************** */
//$pdf->Image('test/logo/full_hitam.jpg', $x='10', $y=$line_y_location+15 , $w='190', $h='250', $type='', $link='', $align='center', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
/* ************** enddate *********************** */

/* ************** Start 3rd Page *********************** */
//$pdf->SetXY('3','20');
//$xmargin = '3';
//$ymargin = '20';
//$line_y_location= $pdf->GetY();

/* ************** End 3rd Page *********************** */
?>

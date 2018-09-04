<?php

ob_start();
/* ************** header.jpg *********************** */
//$pdf->Image('test/logo/amslogo.png', $x='45', $y='25', $w='120', $h='10', $type='', $link='', $align='center', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false);
/* ************** End header *********************** */



$xmargin = '20';
$ymargin = '0';
$pdf->SetFont($default_font,'',10.5);


/*********************Start Section A**************************/
# Start Payments table in HTML by Haziq
$pdf->Ln(0);

if($logo_name=='' OR $logo_name==null){

	$logo_name = "Agiliux-logo.png";

}
$html = <<<EOD
<table cellpadding="10" border="0">
<tr>  
  <td align="right"><img src="test/logo/$logo_name" height="100" width="300"></img></td>
  <td align="left">$organizationname<br />$address<br />$city , $state, $country, $code<br />Tel: $phone</td>
</tr>
</table>
EOD;

// output the HTML content
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Line(10.5,$pdf->GetY(), 201, $pdf->GetY());
$pdf->Line(10.5,$pdf->GetY()+1, 201, $pdf->GetY()+1);
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

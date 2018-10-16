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
include_once('header.php');
$pdf->Ln(5);
$html = <<<EOD
<table border="0">
  <tr>
    <td align="center" colspan="2"><b><u><font size=15>Pay Slip</font></b></u></td>
  </tr>
</table>

<br/>

<table border="0">  
    <tr>
        <td>
            <b>Name             : $emp_name</b>
        </td>
        <td>
            <b>IC NO            : $ic_passport</b>
        </td>
    </tr>
    <tr>
        <td>
            <b>Position         : $designation</b>
        </td>
        <td>
            <b>Month           : $pay_month/$pay_year</b>
        </td>
        
    </tr>
     <tr>
         <td>
            <b>Department   : $department</b>
        </td>
        <td>
            <b>TAX NO        : $tax_no</b>
        </td>
    </tr>
</table>

<br>

<br /><!--item list start-->
                <table cellpadding="5" border="0">
                    <tr><table cellpadding="5" cellspacing="0" border="1">
                    <tr>
                        <th align="center" bgcolor="#A4A4A4"><b>EARNING</b></th>
                        <th align="center" bgcolor="#A4A4A4"><b>AMOUNT</b></th>
                        <th align="center" bgcolor="#A4A4A4"><b>DEDUCTIONS</b></th>
                        <th align="center" bgcolor="#A4A4A4"><b>AMOUNT</b></th>
                    </tr>
                  <tr>
                    <td>Basic Pay<br/>Traveling Allowance</td>
                    <td align="center">$currency_symbol $basic_sal<br/>$currency_symbol $transport_allowance</td>
                    <td>EPF<br/>SOCSO<br/>TAX / LHDN</td>
                    <td align="right">$currency_symbol $emp_epf<br/>$currency_symbol $emp_socso<br/>$currency_symbol $lhdn</td>
                  </tr>
                   <tr>
                    <td><b>TOTAL EARNING</b></td>
                    <td align="center"><b>$currency_symbol $total_earning</b></td>
                    <td><b>TOTAL DEDUCTIONS</b></td>
                    <td align="right"><b>$currency_symbol$total_deduction</b></td>
                  </tr>
                  <tr>
                    <td colspan="2"></td>
                    <td rowspan="3"><br/><br/>CLAIM</td>
                    <td align="center" rowspan="3"><br/><br/></td>
                  </tr>
                  <tr>
                    <td align="center" bgcolor="#A4A4A4"><b>EPF CONTRIBUTION</b></td>
                    <td align="center" bgcolor="#A4A4A4"><b>SOCSO CONTRIBUTION</b></td>
                  </tr>
                  <tr>
                    <td rowspan="3">By Employee                                    $currency_symbol $emp_epf<br/>By Employer                                $currency_symbol $employer_epf</td>
                    <td rowspan="3">By Employee                                  $currency_symbol $emp_socso<br/>By Employer                              $currency_symbol $employer_socso</td>
                  </tr>
                  <tr>
                    <td rowspan="2"><b>NET PAYMENT<br/><br/>TOTAL PAYMENT</b></td>
                    <td align="center"><b>$currency_symbol$net_pay</b></td>
                  </tr>
                  <tr>
                    <td align="center"><b>$currency_symbol$total_earning</b></td>
                  </tr>
            </table></td></tr>

            <br/>
            <br/>


EOD;

// output the HTML content
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Line(10.5,$pdf->GetY(), 201, $pdf->GetY());
$pdf->Line(10.5,$pdf->GetY()+1, 201, $pdf->GetY()+1);
$pdf->MultiCell(150, 7, "(Computer Generated No Signature Required)", 0, 'L', 0, 1, 58,$pdf->GetY());
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

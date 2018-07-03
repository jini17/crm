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
$pdf->Ln(13);
$html = <<<EOD

<p align="right"><b>$organization_title</b><br />$organizationname<br />$address<br />$city , $state, $country, $code<br />$phone<br />Fax : $fax<br />$website</p>

<b align="left">
$emp_name
</b>
                                                                                               
Period($pay_month $pay_year)
<br><br>
<table>
    <tr>
        <td>
            Position : $designation
        </td>
        <td>
            EPF No : $epf_no
        </td>
        <td rowspan="3" align="right">
        <font color="#008b8b"><b>Net Pay  </font><br /> $net_pay</b>
        </td>
    </tr>
     <tr>
        <td>
            Dept : $dept
        </td>
        <td>
            SOSCO : $socso_no
        </td>
    </tr>
    <tr>
        <td>
            IC/Passport : $ic_passport
        </td>
        <td>
            Income Tax No : $tax_no
        </td>
    </tr>
</table>

<br>



<b>
<font color=#5f9ea0>
Employee Earning
<hr>
</font></b>
<table align="left">
    <tr>
        <td>
            Basic
        </td>
        <td align="right">
            $basic_sal
        </td>
    </tr>
    <tr>
        <td>
            Transport Allowance
        </td>
        <td align="right">
            $transport_allowance
        </td>
    </tr>
    <tr>
        <td>
            Phone Allowance
        </td>
        <td align="right">
            $ph_allowance
        </td>
    </tr>
    <tr>
        <td>
            Parking Allowance
        </td>
        <td align="right">
            $parking_allowance
        </td>
    </tr>
    <tr>
        <td>
            Over Time Meal Allowance
        </td>
        <td align="right">
            $ot_meal_allowance
        </td>
    </tr>
    <tr>
        <td>
            Other Allowance
        </td>
        <td align="right">
            $oth_allowance
        </td>
    </tr>
    
</table>
<br><br>
<b>
<font color=#5f9ea0>
Employee Deduction
</font>
<hr>
<table>
    <tr>
        <td>
            Zakat
        </td>
        <td align="right">
            $zakat
        </td>
    </tr>
    <tr>
        <td>
            LHDN
        </td>
        <td align="right">
            $lhdn
        </td>
    </tr>
    <tr>
        <td>
            Employee EPF
        </td>
        <td align="right">
            $emp_epf
        </td>
    </tr>
    <tr>
        <td>
            Employee SOCSO
        </td>
        <td align="right">
            $emp_socso
        </td>
    </tr>
    <tr>
        <td>
            Other Dedcutions
        </td>
        <td align="right">
            $other_deduction
        </td>
    </tr>
    <tr>
        <td>
            Total Deduction
        </td>
        <td align="right">
            $total_deduction
        </td>
    </tr>
</table>
<br><br>
<b><font color="#5f9ea0">
Company Contribution
</font>
<hr>
<table>
    <tr>
        <td>
            Employer EPF
        </td>
        <td align="right">
            $employer_epf
        </td>
    </tr>
    <tr>
        <td>
            Employer SOCSO
        </td>
        <td align="right">
            $employer_socso
        </td>
    </tr>
        <tr>
        <td>
            Employer EIS
        </td>
        <td align="right">
            $employer_eis
        </td>
    </tr>
    <tr>
        <td>
            HRDF
        </td>
        <td align="right">
            $hrdf
        </td>
    </tr>
    <tr>
        <td>
            Total Company Contribution
        </td>
        <td align="right">
            $total_comp_contribution
        </td>
    </tr>
</table>
</b>
             



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

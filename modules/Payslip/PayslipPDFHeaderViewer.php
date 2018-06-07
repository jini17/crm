<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
	include_once 'vtlib/Vtiger/PDF/inventory/HeaderViewer.php';

	class PayslipPDFHeaderViewer extends Vtiger_PDF_InventoryHeaderViewer {

		function display($parent) {
		
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
		
		list($imageWidth, $imageHeight, $imageType, $imageAttr) = $parent->getimagesize($modelColumn0['logo']);
			$w = $imageWidth;
			if($w > 220) {
				$w=165;
			}
			/*
			$h = $imageHeight;
			if($h >180) {
				$h = 135;
			}*/
		/* start logo, address & doc type*/	
		if($this->model) {	//added by jitu@secondcrm.com for firstpage header
			$invoicetitlearray  = explode('#',$this->model->get('title'));
			$module = rtrim(strtoupper($this->model->get('module')),'S');
			$pdftitle = $module;		
			
			$html = "
			<table border=\"1\">
				<tr>
					<td width=\"250pt\">";
					$html .= "</td>
					<td width=\"40pt\"></td>
					<td width=\"250pt\" >
						
					";
					/*doc type table start*/
					$html .="
							<table cellpadding=\"3\" cellspacing=\"2\" border=\"1\">
								<span style=\"font-size:15pt\"><strong>{$modelColumn0[summary]}</strong></span><br />(890813-X)<br/>
						   {$modelColumn0[content]}<br />";
					foreach($modelColumn2 as $label => $value) { 
						if(is_array($value)) {
							foreach($value as $l=>$v) {
								$text = $l;	
								$textvalue = $v;	
								if(strpos($l,'Total Amount (')!==False) {	
									$text = '<strong>'.$l.'</strong>';
									$textvalue = '<strong>'.$v.'</strong>';
								} 		
									
					 		}
					$html .= "</table></td>
				</tr></table><br />";
				/*doc type table end*/
				/* end logo, address & doc type*/
				
				//Empty lines after header				
				$html .= str_repeat('<br />',$pdfsettings['emptyline']);
						
				$html .= <<<EOF
					<br/><br/><table border="1">
						<tr>
EOF;
				} else {
					/* Address **/
					$html .= "<td width=\"425pt\">
							<span style=\"font-size:15pt\"><strong>Jitendra Gupta</strong> (Employee No: 006/0414)</span><br /><br/>
							<table width=\"400pt\" border=\"1\">
							<tr>
							<td><span style=\"font-size:10pt\">Position: SR. System Analyst</span><br/>
								<span style=\"font-size:10pt\">Dept: Technical</span><br/>
								<span style=\"font-size:10pt\">IC/Passport: P9477763</span></td>

							<td><span style=\"font-size:10pt\">EPF No: N/A</span><br/>
								<span style=\"font-size:10pt\">SOCSO No: N/A</span><br/>
								<span style=\"font-size:10pt\">Income Tax No: SG2333132104</span></td>
							</tr>
							</table>
						</td>
						<td>
						<span> Period: <strong>March 2018</strong></span><br/><br/>
						<table border=\"1\" width=\"100pt\" style=\"border-color:#FF0000;\">
							<tr>
							<td><span align=\"right\" style=\"font-size:10pt\" >NET PAY</span><br/><span align=\"right\" style=\"font-size:10pt\">RM 3,600.16</span></td>
							</tr>
							</table>
						</td>";
				}
			}			
			$html .="</tr></table>";
			

			$pdf->writeHTML($html, true, false, true, false, '');

			$html = '<!--item list start-->
				<table cellpadding="5" border="1">
					<tr><td colspan="3"><h3>Employee Earnings</h3></td>
					<td><h3>Current</h3></td></tr>';
		$html .='</table><br /><br />';
		
	
		$html .= '<!--item list start-->
				<table cellpadding="5" border="1">
					<tr><td colspan="3"><h3>Employee Deductions</h3></td>
					<td><h3>Current</h3></td></tr>';
					 $html .= '<tr colspan="'.$totalcols.'">'.$line.'</tr>'; 
					 
					 $html .='</table><br /><br />';
		
		

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
		
		$html .= '<!--item list start-->
				<table cellpadding="5" border="1">
					<tr><td colspan="3"><h3>Company Contributions</h3></td>
					<td><h3>Current</h3></td></tr>';
		$html .='</table><br /><br />';
		
		$pdf->writeHTML($html, true, false, true, false, '');

		}
			
	}
	
}
?>

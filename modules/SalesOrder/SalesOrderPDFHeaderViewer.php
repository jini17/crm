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

	class SalesOrderPDFHeaderViewer extends Vtiger_PDF_InventoryHeaderViewer {

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
			$pdftitle = $this->model->get('module')=='SalesOrder'?'SALES ORDER':$this->model->get('module');		
			
			$html = "
			<table border=\"0\">
				<tr>
					<td width=\"250pt\">";
				if($modelColumn0['logo'] !='') {
				
					$html .= "<img align=\"right\" border=\"0\" height=\"$h\" width=\"$w\" src=\"$modelColumn0[logo]\" /><br />";
				}
				
					$html .= "<span style=\"font-size:11pt\"><strong>{$modelColumn0[summary]}</strong></span><br />
						   {$modelColumn0[content]}<br />{$vatlabel} :  {$modelColumn0['vatid']}";			$html .= "</td>
					<td width=\"40pt\"></td>
					<td width=\"250pt\" >
						<span align=\"right\" style=\"font-size:20pt;font-weight:bold;\">{$pdftitle}</span><br />
					";
					/*doc type table start*/
					$html .="
							<table cellpadding=\"3\" cellspacing=\"2\" border=\"0\">
								<tr bgcolor=\"#D6EEF8\">
									<td>{$invoicetitlearray[0]}</td>
									<td>{$invoicetitlearray[1]}</td>
								</tr>";
					foreach($modelColumn2 as $label => $value) { 
						if(is_array($value)) {
							foreach($value as $l=>$v) {
								$text = $l;	
								$textvalue = $v;	
								if(strpos($l,'Total Amount (')!==False) {	
									if (strpos($textvalue, '.')===false) {
										$text = '<strong>'.$l.'</strong>';
										$textvalue = '<strong>'.$v.'</strong>'.'<strong>'.'.00'.'</strong>';
									}
									else{
										$text = '<strong>'.$l.'</strong>';
										$textvalue = '<strong>'.$v.'</strong>';
									}
								} 		
								$html .= "<tr bgcolor=\"#D6EEF8\">
											<td style=\"font-size:$style\">{$text}</td> 
											<td style=\"font-size:$style\">{$textvalue}</td> 
								 </tr>"; 	
					 		}
					$html .= "</table></td>
				</tr></table><br />";
				/*doc type table end*/
				/* end logo, address & doc type*/
				
				//Empty lines after header				
				$html .= str_repeat('<br />',$pdfsettings['emptyline']);
						
				$html .= <<<EOF
					<table border="0">
						<tr>
EOF;
				} else {
					/* Address **/
					$html .= "<td width=\"250pt\">
							<span style=\"font-size:11pt\">{$label}</span><br />
								{$value}
						</td>";
				}
			}			
			$html .= 
			"</tr>
			</table><br /><br />";
			$modelColumnCenter = $modelColumns[1];

			if (isset($modelColumnCenter['Quote_Details'])) {
				unset($modelColumnCenter['Quote_Details']);
			}

			foreach($modelColumnCenter as $label => $value) { 
				if(!empty($value)) {
					if($label == 'Contact Name') $label = 'Att';
					$html .= "
						<table width=\"540pt\">
							<tr>
							<td width=\"80pt\"><font color=\"#333\"><strong>{$label}</strong></font></td>
							<td width=\"475pt\"><font color=\"#333\">: {$value}</font></td>
							</tr>
						</table>";
				}
			}		

			$pdf->writeHTML($html, true, false, true, false, '');
		}
			
	}
	
}
?>

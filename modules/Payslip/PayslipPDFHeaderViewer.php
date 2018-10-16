<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once dirname(__FILE__) . '/../viewers/ContentViewer.php';

class Vtiger_PDF_PaymentPayViewer extends Vtiger_PDF_ContentViewer {

	protected $headerRowHeight = 8;
	protected $onSummaryPage   = false;

	function __construct() {
		// NOTE: General A4 PDF width ~ 189 (excluding margins on either side)
			
		$this->cells = array( // Name => Width
			'Code'    => 20,
			'Name'    => 70,
			'Quantity'=> 20,
			'Price'   => 20,
			//'Discount'=> 19,
			'Tax'     => 20,
			'Total'   => 30
		);
	}
	
	function initDisplay($parent) {

		$pdf = $parent->getPDF();
		//$modelColumns = $this->model->get('columns');
	}
	
	function drawCellBorder($parent, $cellHeights=False) {		
		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
		
		if(empty($cellHeights)) $cellHeights = array();

		$offsetX = 0;
		foreach($this->cells as $cellName => $cellWidth) {
			$cellHeight = isset($cellHeights[$cellName])? $cellHeights[$cellName] : $contentFrame->h;

			$offsetY = $contentFrame->y-$this->headerRowHeight;			
			
			$pdf->MultiCell($cellWidth, $cellHeight, "", 0, 'L', 0, 1, $contentFrame->x+$offsetX, $offsetY);
			$offsetX += $cellWidth;
		}
	}

	function display($parent) {
		$this->displayPreLastPage($parent);
		//$this->displayLastPage($parent);
		
		
	}

	function displayPreLastPage($parent) {
		$parent->createPage();
		$pdf = $parent->getPDF();
                //$modelColumnCenter = $modelColumns[1];
		$models = $this->contentModels;
		$models2 = $models['paymentscf'][0];
	
		$html .= '<br /><!--item list start-->
				<table cellpadding="5" border="0">
					<tr><table cellpadding="5" cellspacing="0" border="1">
  <tr>
    <th align="center" bgcolor="#A4A4A4"><b>EARNING</b></th>
    <th align="center" bgcolor="#A4A4A4"><b>AMOUNT</b></th>
    <th align="center" bgcolor="#A4A4A4"><b>DEDUCTIONS</b></th>
    <th align="center" bgcolor="#A4A4A4"><b>AMOUNT</b></th>
  </tr>
  <tr>
    <td>Basic Pay<br/>Project Allowance<br/>Traveling Allowance</td>
    <td align="center">'. $models2 ['BasicPay'] .'<br/>'. $models2 ['ProAll'] .'<br/>'. $models2 ['Travel'] .'</td>
    <td>EPF<br/>SOCSO<br/>ADVANCE<br/>LOAN<br/>TAX / LHDN<br/>UPL</td>
    <td align="right">'. $models2 ['EPF'] .'<br/>'. $models2 ['SOCSO'] .'<br/>'. $models2 ['ADVANCE'] .'<br/>'. $models2 ['LOAN'] .'<br/>'. $models2 ['TAX'] .'<br/>'. $models2 ['UPL'] .'</td>
  </tr>
  <tr>
    <td><b>TOTAL EARNING</b></td>
    <td align="center"><b>'. $models2 ['EARNING'] .'</b></td>
    <td><b>TOTAL DEDUCTIONS</b></td>
    <td align="right"><b>'. $models2 ['DEDUCTION'] .'</b></td>
  </tr>
  <tr>
    <td colspan="2"></td>
    <td rowspan="3"><br/><br/>CLAIM</td>
    <td align="center" rowspan="3"><br/><br/>'. $models2 ['CLAIM'] .'</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#A4A4A4"><b>EPF CONTRIBUTION</b></td>
    <td align="center" bgcolor="#A4A4A4"><b>SOCSO CONTRIBUTION</b></td>
  </tr>
  <tr>
    <td rowspan="3">By Employee            '. $models2 ['epfemployee'] .'<br/>By Employer             '. $models2 ['epfemployer'] .'</td>
    <td rowspan="3">By Employee            '. $models2 ['socsoemployee'] .'<br/>By Employer             '. $models2 ['socsoemployer'] .'</td>
  </tr>
  <tr>
    <td rowspan="2"><b>NET PAYMENT<br/><br/>TOTAL PAYMENT</b></td>
    <td align="center"><b>'. $models2 ['netpayment'] .'</b></td>
  </tr>
  <tr>
    <td align="center"><b>'. $models2 ['totalpayment'] .'</b></td>
  </tr>
</table></td></tr>';
		$termid = '';
		foreach($models as $key=>$item) {
			
			if($key == 'Description') {
				$description = 	$item;
				
			} else if(strpos($key,'#') !==false) {
				
				$keys = explode('#',$key);
				if($keys[1] == 8) {
					 $termid = $keys[1];
				} else if($keys[1] == 9) {	
					$termid = $keys[1];				
				} else {
					$terms = $item;		
				}	
			}
			
		}			
					
		$html .='</table><br /><br />';
		
		$html .= "<table cellpadding=\"5\" border=\"0\">";
			if($description !='') { 
				$html .= "<tr><td><h3>Description</h3></td></tr>
						<tr>
							<td>".nl2br($description)."</td>	
						</tr>";
						
			}
			$html .="<tr>
							<td>".html_entity_decode($terms)."</td>	
						</tr>";
				
			$html .= "</table>";
		
		$pdf->writeHTML($html, true, false, true, false, '');
		if($termid ==8) {
			$pdf->Line(10.5,$pdf->GetY(), 201, $pdf->GetY());
			$pdf->Line(10.5,$pdf->GetY()+1, 201, $pdf->GetY()+1);
			$pdf->MultiCell(150, 7, "(Computer Generated No Signature Required)", 0, 'L', 0, 1, 58,$pdf->GetY());
		}
		if($termid ==9) {	
			$pdf->MultiCell(45, 7,"Received By: ",0,'L',0,1,8,$pdf->GetY()-15);
			$pdf->MultiCell(90, 7,"--------------------------------",0,'L',0,1,8,$pdf->GetY());
			$pdf->MultiCell(30, 7,"Name:",0,'L',0,1,8,$pdf->GetY()-3);
			$pdf->MultiCell(30, 7,"Date:",0,'L',0,1,8,$pdf->GetY()-3);
		}
		$this->onSummaryPage = true;
		
	}

	function displayLastPage($parent) {
		// Add last page to take care of footer display
		if($parent->createLastPage()) {
			$this->onSummaryPage = false;
		}
	}

	function drawStatusWaterMark($parent) {
		$pdf = $parent->getPDF();

		$waterMarkPositions=array("30","180");
		$waterMarkRotate=array("45","50","180");

		$pdf->SetFont('Arial','B',50);
		$pdf->SetTextColor(230,230,230);
		$pdf->Rotate($waterMarkRotate[0], $waterMarkRotate[1], $waterMarkRotate[2]);
		$pdf->Text($waterMarkPositions[0], $waterMarkPositions[1], 'created');
		$pdf->Rotate(0);
		$pdf->SetTextColor(0,0,0);
	}
}

<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once 'vtlib/Vtiger/PDF/inventory/ContentViewer.php';

class PayslipViewer extends Vtiger_PDF_ContentViewer {

	protected $headerRowHeight = 8;
	protected $onSummaryPage   = false;

	function initDisplay($parent) {

		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
	}
	
	
	function display($parent) {

		$parent->createPage();
		$pdf = $parent->getPDF();
		$models = $this->contentModels;
		$headersummary = $this->watermarkModel;
		
		$labelModels = $this->labelModel;
		$headerinfo  = $models['headerinfo']; 
		
		$pdfsettings = $models['pdfsettings'];
		
		$h1=0;$h2=0;
		if($pdfsettings['showlogo']==1) {
			$h1 = 30;
		} 
		
		if($pdfsettings['showorgaddress']==1) { 
			 $h2 = $pdf->getStringHeight($headerinfo['content'],45);
		}

		if($pdfsettings['showsummary']==1) {
			 $h2 = $pdf->getStringHeight($headersummary['title'].'<br />'.implode('<br />',$headersummary['dates']),35);
		}
		
		if($h1==0) {
			$topmargin = 30+$h2;	
		} else {
			$topmargin = $h1+$h2;
		}

		$pdf->SetTopMargin(15);
		$pdf->SetAutoPageBreak(true,15);

		$models = $this->contentModels;
	
		
	/*	if($termid ==8) {
			$pdf->Line(10.5,$pdf->GetY(), 201, $pdf->GetY());
			$pdf->Line(10.5,$pdf->GetY()+1, 201, $pdf->GetY()+1);
			$pdf->MultiCell(150, 7, "(Computer Generated No Signature Required)", 0, 'L', 0, 1, 58,$pdf->GetY());
		}
	*/	
		//print footer
		$pdf->InFooter = true;
		if($pdfsettings['showpager'] == 1 & $pdfsettings['repeatfooter']!=1) { 
			for($step=0;$step<$pages;$step++) {
				$pdf->setPage($step+1);
				$pageno = "Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages();
				//comment by jitu for hiding footer/header in other pages	
				$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
			}
		}
		
		$this->onSummaryPage = true;
		
	}
}

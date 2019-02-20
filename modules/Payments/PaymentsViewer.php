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

class PaymentsViewer extends Vtiger_PDF_ContentViewer {

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
		//echo ($h1+h2);
		if($h1==0) {
			$topmargin = 30+$h2;	
		} else {
			$topmargin = $h1+$h2;
		}

		$pdf->SetTopMargin(65);
		$pdf->SetAutoPageBreak(true,35);

		$models = $this->contentModels;
	
		$html .= '<br /><!--item list start-->
				<table cellpadding="5" border="0">
					<tr><td colspan="3"><h3>Payment Information</h3></td></tr>';
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
			else {
				if($key == 'Amount') {
					$key = $key.' <strong>(RM)</strong>';
				}
				if($key !='headerinfo' && $key !='pdfsettings' && $item!='') {
					$html .= '<tr>
							<td width="220pt"><strong>'.$key.'</strong></td>
								<td width="10pt"><strong>:</strong></td>
								<td width="230pt">'.$item.'</td>
						</tr>';
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
		$pages = $pdf->getNumPages();
		$w =  $pdf->getPageWidth();
		$h =  $pdf->getPageHeight();
				
		$marginx = 5;
		$marginy = 32;
		$x = 5;
		$y = 10;	
		
		if($pdfsettings['repeatheader'] == 1) {
			$vatlabel = getTranslatedString('VATID');
			$headertitlearray  = explode('#',$headersummary['title']);
			$pdftitle = $headertitlearray[0];
			
			
			for($step=0;$step<$pages;$step++) {
				$headerpart = '';
				if($step+1 > 1) {
					$pdf->setPage($step+1);
				
						if($headerinfo['logo'] !='' && $pdfsettings['showlogo'] ==1) {
							list($imageWidth, $imageHeight, $imageType, $imageAttr) = $parent->getimagesize($headerinfo['logo']);		
							$w1 = $imageWidth;
							if($w1 > 220) {
								$w1=165;
							}
							$logohtml = '<img align="right" border="0" width="'.$w1.'" src="'.$headerinfo['logo'].'" /><br />';
							$pdf->writeHTMLCell(165, 50, $x, $y,$logohtml, 0,0, 0,true, '', true);
						}	
						if($pdfsettings['showorgaddress'] ==1) {
							$companyaddress = "<span style=\"font-size:15pt\">".$headerinfo['summary']."</span><br />".$headerinfo[content]."<br />".$vatlabel." :  ".$headerinfo['vatid'];
							$ymargin = $h1==0?$y:$y+15;			
						$pdf->writeHTMLCell(250, 120, $x, $ymargin,$companyaddress, 0,0, 0,true, '', true);	
						}

						if($pdfsettings['showsummary'] ==1) {
							//$summarypart ='<span align="center" style="font-size:20pt;font-weight:bold;">'.$pdftitle."</span><br />";			
							$summarypart ='<table align="right" cellpadding="3" cellspacing="2" border="0">
								<tr align="left" width="100pt" bgcolor="#D6EEF8">
									<td>'.$headertitlearray[0].'</td>
									<td>'.$headertitlearray[1].'</td>
								</tr>';
							foreach($headersummary['dates'] as $label => $value) { 
								$text = $label;	
								$textvalue = $value;
								if(strpos($label,'Total Amount (')!==False) {	
									$text = '<strong>'.$label.'</strong>';
									$textvalue = '<strong>'.$value.'</strong>';
								} 		
								$summarypart .= '<tr align="left" bgcolor="#D6EEF8">
										<td style="font-size:11pt">'.$text.'</td><td style="font-size:11pt">'.$textvalue.'</td></tr>'; 	
							}
							$summarypart .= '</table></td>';
							$pdf->writeHTMLCell(90, 120, 120, 12,$summarypart, 0,0, 0,true, '', true);	
						}
				}
			}
		}
		//end here 
	
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
		if($pdfsettings['showfooter'] == 1) {
			
			$footercontent = decode_html(stripslashes($pdfsettings['customfooter']));
			if(empty($pdfsettings['customfooter']) || $pdfsettings['customfooter']=='&nbsp;') { 
				$footercontent = '';
			}
			if($pdfsettings['repeatfooter'] ==1) { 	
				for($step=0;$step<$pages;$step++) {
					$pdf->setPage($step+1);
					$pdf->writeHTMLCell($w, 50, $marginx, $h-$marginy,$footercontent, 0,0, 0,true, '', true);				$pageno = "<i>Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages()."</i>";
					//comment by jitu for hiding footer/header in other pages	
					$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
				}

			} elseif($pdfsettings['showpager'] != 1 && $pdfsettings['repeatfooter'] ==1) {
				$pdf->setPage(1);
				$pdf->writeHTMLCell($w, 50, $marginx, $h-$marginy,$footercontent, 0,0, 0,true, '', true);				$pageno = "<i>Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages()."</i>";
				//comment by jitu for hiding footer/header in other pages	
				$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
			}
			$pdf->InFooter = false;
		} 
		//End here

		$this->onSummaryPage = true;
		
	}
}

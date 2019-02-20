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

class SalesOrderPDFContentViewer extends Vtiger_PDF_InventoryContentViewer {

	protected $headerRowHeight = 8;
	protected $onSummaryPage   = false;

	function initDisplay($parent) {

		$pdf = $parent->getPDF();
		$contentFrame = $parent->getContentFrame();
	}

	function calculateWidth($totalcolumsArray) {

		$widthArray = array();
		$totalcolums = $totalcolumsArray[0];
		$pdfsettings = $totalcolumsArray[1];

		switch($totalcolums) {
			
			case 1 :
				 $widthArray = array(0,0,540,0,0,0,0,0,0);
			break;

			case 2 :
				if($pdfsettings['sno']==1) {
					$widthArray = array(20,0,520,0,0,0,0,60);
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray = array(0,60,480,0,0,0,0,60);
					} else {
						$widthArray = array(0,0,480,60,60,60,60,60);
					}
				}
			break;
		
			case 3 :
				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,440,0,0,0,0,0);
					} else {
						$widthArray = array(20,0,440,60,60,60,60,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,420,60,60,60,60,60);
					} else {
						$widthArray =  array(0,0,420,60,60,60,60,60);
					}
				}
			break;
			case 4 :

				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,400,60,60,60,60,60);
					} else {
						$widthArray = array(20,0,400,60,60,60,60,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,360,60,60,60,60,60);
					} else {
						$widthArray =  array(0,0,360,60,60,60,60,60);
					}
				}
			break;
			case 5 :
				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,280,60,70,70,70,60);
					} else {
						$widthArray = array(20,0,280,60,70,70,70,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,300,60,60,60,70,70);
					} else {
						$widthArray =  array(0,0,300,60,60,60,70,70);
					}
				}

			break;
			case 6 :
		
				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,240,60,60,60,60,60);
					} else {
						$widthArray = array(20,0,240,60,60,60,60,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,240,60,60,60,60,60);
					} else {
						$widthArray =  array(0,0,240,60,60,60,60,60);
					}
				}

			break;
			case 7 :
				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,220,60,60,60,60,60);
					} else {
						$widthArray = array(20,0,220,60,60,60,60,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,180,60,60,60,60,60);
					} else {
						$widthArray =  array(0,0,180,60,60,60,60,60);
					}
				}

			break;
			case 8 :

				if($pdfsettings['sno']==1) {
					if($pdfsettings['order']==1) {
						$widthArray = array(20,60,160,60,60,60,60,60);
					} else {
						$widthArray = array(20,0,160,60,60,60,60,60);
					}
					
				} else { 
					if($pdfsettings['order']==1) {
						$widthArray =  array(0,60,120,60,60,60,60,60);
					} else {
						$widthArray =  array(0,0,120,60,60,60,60,60);
					}
				}
			break;
		}
		
		return $widthArray;
	}
	

	function getLineItemCols($mode,$labelModels,$pdfsettings) {

		$cols = array();
		$i = 0;
		$totalcolsArray = $this->getNoCols($mode,$pdfsettings);	
		
		$calculatewidth = $this->calculateWidth($totalcolsArray);

		if($mode == 'individual') {
			if($pdfsettings['showindno'] ==1) {
				$cols[$i]['label'] = $labelModels->get('SNo');
				$cols[$i]['align'] = 'left';
				$cols[$i]['width'] = $calculatewidth[0];
				$i++;				
			}
			
			//added by jitu@secondcrm.com on 19012016 for show ordercode
			if($pdfsettings['showindorder'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Code');
				$cols[$i]['align'] = 'left';
				$cols[$i]['width'] = $calculatewidth[1];
				$i++;				
			}//end here

	
			if($pdfsettings['showinddesc'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Name');
				$cols[$i]['align'] = 'left';
				$cols[$i]['width'] = $calculatewidth[2]; 				
				$i++;
			}
			if($pdfsettings['showindsqm'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Quantity'); 
				$cols[$i]['align'] = 'left';				
				$cols[$i]['width'] = $calculatewidth[3]; 				
				$i++;
			}
			if($pdfsettings['showindpricesqm'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Price');
				$cols[$i]['align'] = 'left'; 				
				$cols[$i]['width'] = $calculatewidth[4];  				
				$i++;
			}
			if($pdfsettings['showinddiscount'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Discount'); 
				$cols[$i]['align'] = 'right';			
				$cols[$i]['width'] = $calculatewidth[5];				
				$i++;	
			}
			if($pdfsettings['showindgst'] ==1) { 
				$cols[$i]['label'] = getTranslatedString($labelModels->get('Tax')); 
				$cols[$i]['align'] = 'right';
				$cols[$i]['width'] = $calculatewidth[6];			
				$i++;					
			}
			if($pdfsettings['showindamount'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Total'); 
				$cols[$i]['align'] = 'right';				
				$cols[$i]['width'] = $calculatewidth[7];    				
				$i++;
			}
			
		} else { 
			if($pdfsettings['showgroupno'] ==1) {
				$cols[$i]['label'] = $labelModels->get('SNo'); 
				$cols[$i]['align'] = 'left';		
				$cols[$i]['width'] = $calculatewidth[0]; 				
				$i++;			
			}
				
			//added by jitu@secondcrm.com on 19012016 for show ordercode
			if($pdfsettings['showgrouporder'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Code');
				$cols[$i]['align'] = 'left';
				$cols[$i]['width'] = $calculatewidth[1];
				$i++;				
			}//end here			

			if($pdfsettings['showgroupdesc'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Name');
				$cols[$i]['align'] = 'left'; 				
				$cols[$i]['width'] = $calculatewidth[2];			
				$i++;
			}
			if($pdfsettings['showgroupsqm'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Quantity'); 
				$cols[$i]['align'] = 'left';				
				$cols[$i]['width'] = $calculatewidth[3]; 				
				$i++;
			}
			if($pdfsettings['showgpricesqm'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Price'); 
				$cols[$i]['align'] = 'left';				
				$cols[$i]['width'] = $calculatewidth[4];   				
				$i++;
			}
			if($pdfsettings['showgroupdiscount'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Discount'); 
				$cols[$i]['align'] = 'right';
				$cols[$i]['width'] = $calculatewidth[5]; 				
				$i++;				
			}
			if($pdfsettings['showgroupamount'] ==1) {
				$cols[$i]['label'] = $labelModels->get('Total'); 	
				$cols[$i]['align'] = 'right';			
				$cols[$i]['width'] = $calculatewidth[6];  				
				$i++;
			}
		}	
		return $cols;	

	}

	function getNoCols($mode, $pdfsettings) {
		
		$retcols = 0;
		$colsettings = array();
		if($mode == 'individual') { 
			if($pdfsettings['showindno']==1) { $retcols++; $colsettings['sno'] = 1;}
			if($pdfsettings['showindorder']==1) { $retcols++; $colsettings['order'] = 1;}
			if($pdfsettings['showinddesc']==1) { $retcols++; $colsettings['item'] = 1;}
			if($pdfsettings['showindsqm']==1) { $retcols++; $colsettings['qty'] = 1;}
			if($pdfsettings['showindpricesqm']==1) {$retcols++; $colsettings['price'] = 1;}
			if($pdfsettings['showinddiscount']==1) {$retcols++;$colsettings['discount'] = 1;}
			if($pdfsettings['showindgst']==1) {$retcols++;$colsettings['tax'] = 1;}
			if($pdfsettings['showindamount']==1) {$retcols++;$colsettings['amount'] = 1;}
			 
		} else {
			if($pdfsettings['showgroupno']==1) { $retcols++; $colsettings['sno'] = 1;}
			if($pdfsettings['showgrouporder']==1) { $retcols++; $colsettings['order'] = 1;}
			if($pdfsettings['showgroupdesc']==1) { $retcols++; $colsettings['item'] = 1;}
			if($pdfsettings['showgroupsqm']==1) { $retcols++; $colsettings['qty'] = 1;}
			if($pdfsettings['showgpricesqm']==1) {$retcols++; $colsettings['price'] = 1;}
			if($pdfsettings['showgroupdiscount']==1) {$retcols++;$colsettings['discount'] = 1;}
			if($pdfsettings['showgroupamount']==1) {$retcols++;$colsettings['amount'] = 1;}
		}
		return array($retcols,$colsettings);			
	}

	function getLineItemVals($mode, $pdfsettings,$models) {

		$colValues = array();
		
		$totalcolsArray = $this->getNoCols($mode,$pdfsettings);
		$calculatewidth = $this->calculateWidth($totalcolsArray);
		
		$totalModels = count($models);
		
		if($mode == 'individual') {
			
			for ($index = 0; $index < $totalModels; $index++) {
				$i=0;
				$serial = $index+1;
				$model = $models[$index];
				
				//modified by jitu@secondcrm for fetch Item description & order code
				$description = $model->get('Description')!=''?'<br />'.$model->get('Description'):'';
				$comment = $model->get('Comment')!=''?'<br />'.$model->get('Comment'):'';
				$ordercode = $model->get('OrderCode');

				if($pdfsettings['showindno'] ==1) {
					$colValues[$index][$i]['value'] = $serial; 
					$colValues[$index][$i]['align'] = 'left';
					$colValues[$index][$i]['width'] = $calculatewidth[0];
					$i++;				
				}
				//order code 
				if($pdfsettings['showindorder'] ==1) {
					$colValues[$index][$i]['value'] = $ordercode; 
					$colValues[$index][$i]['align'] = 'left';
					$colValues[$index][$i]['width'] = $calculatewidth[1];
					$i++;				
				}

				if($pdfsettings['showinddesc'] ==1) {
					if($pdfsettings['showlineitemdiscountdetails']==1 && $pdfsettings['showinddiscount'] ==1) {			
						$discountdetails = $model->get('discountdetails'); 
						$array = array($model->get('Name').$description.$comment,$discountdetails);
						$colValues[$index][$i]['value'] = $array;
					} else {
						$colValues[$index][$i]['value'] = $model->get('Name').$description.$comment;
					}	
					$colValues[$index][$i]['align'] = 'left';
					$colValues[$index][$i]['width'] = $calculatewidth[2]; 				
					$i++;
				}
				if($pdfsettings['showindsqm'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Quantity'); 	
					$colValues[$index][$i]['align'] = 'left';
					$colValues[$index][$i]['width'] = $calculatewidth[3]; 				
					$i++;
				}
				if($pdfsettings['showindpricesqm'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Price'); 			
					$colValues[$index][$i]['align'] = 'right';//modified by jitu align right as Price value
					$colValues[$index][$i]['width'] = $calculatewidth[4]; 				
					$i++;
				}
				if($pdfsettings['showinddiscount'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Discount');
					$colValues[$index][$i]['align'] = 'right';
					$colValues[$index][$i]['width'] = $calculatewidth[5];  				
					$i++;
				}
				 
				if($pdfsettings['showindgst'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Tax'); 
					$colValues[$index][$i]['align'] = 'right';	
					$colValues[$index][$i]['width'] = $calculatewidth[6]; 				
					$i++;					
				}
				if($pdfsettings['showindamount'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Total');
					$colValues[$index][$i]['align'] = 'right';	
					$colValues[$index][$i]['width'] = $calculatewidth[7]; 				
					$i++;
				}
			}
			
		} else { 
			for ($index = 0; $index < $totalModels; $index++) {
				$discountdetails = array();
				$i=0;
				$serial = $index+1;
				$discountdetails = array();
				$model = $models[$index];
				$description = $model->get('Description')!=''?'<br />'.$model->get('Description'):'';
				$comment = $model->get('Comment')!=''?'<br />'.$model->get('Comment'):'';
				$ordercode = $model->get('OrderCode');
				if($pdfsettings['showgroupno'] ==1) {
					$colValues[$index][$i]['value'] = $serial; 	
					$colValues[$index][$i]['align'] = 'left';	
					$colValues[$index][$i]['width'] = $calculatewidth[0];
					$i++;			
				}

				if($pdfsettings['showgrouporder'] ==1) {
					$colValues[$index][$i]['value'] = $ordercode; 
					$colValues[$index][$i]['align'] = 'left';	
					$colValues[$index][$i]['width'] = $calculatewidth[1];
					$i++;				
				}
			
				if($pdfsettings['showgroupdesc'] ==1) {
					if($pdfsettings['showlineitemdiscountdetails']==1 && $pdfsettings['showgroupdiscount'] ==1) {			
						$discountdetails = $model->get('discountdetails'); 
						$array = array($model->get('Name').$description.$comment);
						if(is_array($discountdetails))
						{	
							$array = array($model->get('Name').$description.$comment, $discountdetails);

						}
							
						$colValues[$index][$i]['value'] = $array;
					} else {
						$colValues[$index][$i]['value'] = $model->get('Name').$description.$comment;
					}	
					$colValues[$index][$i]['align'] = 'left';	
					$colValues[$index][$i]['width'] = $calculatewidth[2];
					$i++;
				}
				if($pdfsettings['showgroupsqm'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Quantity');
					$colValues[$index][$i]['align'] = 'left';	
					$colValues[$index][$i]['width'] = $calculatewidth[3];		
					$i++;
				}
				if($pdfsettings['showgpricesqm'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Price'); 
					$colValues[$index][$i]['align'] = 'right';	//modified by jitu align right as Price value
					$colValues[$index][$i]['width'] = $calculatewidth[4];
					$i++;
				}
				if($pdfsettings['showgroupdiscount'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Discount'); 
					$colValues[$index][$i]['align'] = 'right';	
					$colValues[$index][$i]['width'] = $calculatewidth[5];
					$i++;				
				}
				if($pdfsettings['showgroupamount'] ==1) {
					$colValues[$index][$i]['value'] = $model->get('Total'); 	
					$colValues[$index][$i]['align'] = 'right';	
					$colValues[$index][$i]['width'] = $calculatewidth[6];
					$i++;
				}
			}	
		}
		return $colValues;	

	}


	function getSummaryDiscounts($pdfsettings, $discountdetails) {
		$output = array();
		if($pdfsettings['showoveralldiscountdetails'] ==1) {
				foreach($discountdetails as $discounts) {
					if($discounts['discount_amount'] !=0) {
						if($discounts['postdiscount_criteria']=='P'){
							$output[$discounts['discount_title'].' ('.$discounts['postdiscount_value'].'%)'] = $discounts['discount_amount'];
						} else {
							$output[$discounts['discount_title']] = $discounts['discount_amount'];
						}
					}		
				}
		}
		return $output;
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
			$topmargin = $h1+$h2+10;
		}	

		if($pdfsettings['repeatheader'] ==0) {
			$topmargin = 20;
		}
		
	
		$pdf->SetTopMargin($topmargin);
		$footercontent = decode_html(stripslashes($pdfsettings['customfooter']));
		$footercontentheight = $pdf->getStringHeight($footercontent,240)+10;
		$showfooter = $pdfsettings['showfooter'];
		$showpager  = $pdfsettings['showpager'];

		if($showfooter==1) {
			$pdf->SetAutoPageBreak(true,$footercontentheight);
		} else {
			$footercontentheight = 0;
			$pdf->SetAutoPageBreak(true,15);
		}

		
		$hdnTaxType  = $models['hdnTaxType'];	 	

		$footers = $models['footer'];
		$description = $models['description'][0];
		$models = $models['contents'];
		
		$totalModels = count($models);
		
		$headerCols  = $this->getLineItemCols($hdnTaxType,$labelModels,$pdfsettings); 			
		
		$totalwidth = 0;
		/* Start Product Line Heading */
		$html .= '<!--item list start-->
				<table cellpadding="5" border="0">
					<tr bgcolor="#D5F9CE">';
							foreach($headerCols as $label) {
								$totalwidth += $label['width'];
							$html .= '<td align ="left" width="'.$label['width'].'" align="'.$label['align'].'"><strong>'.$label['label'].'</strong></td>';
							}
						 $html .= '</tr>';
		/* End Product Line label */

		/* Start Product line value Line Value */	
		$lineitemValues = $this->getLineItemVals($hdnTaxType,$pdfsettings,$models);
			foreach($lineitemValues as $key=>$values) {
				$html .= '<tr>';
					foreach($values as $val) 
					{		
						if(is_array($val['value'])) {
				
							$title = $val['value'][0];
							$valstr = $title."<br />";
							$discounts = $val['value'][1];
							if(count($discounts)>0 && $discounts !='') { 
								foreach($discounts as $discount) { 
								   if($discount['discount_amount']!=0) {
								   	if($discount['postdiscount_criteria']=='P') {
										$valstr .= "<i style='font-size:11pt;'>".$discount['discount_title']." (".$discount['postdiscount_value']."%) : ".$discount['discount_amount']."</i><br />";
									} else {
										$valstr .= "<i style='font-size:11pt;'>".$discount['discount_title']." : ".$discount['discount_amount']."</i><br />";
									}	
								   }	
								}
							}	
						} else {
							$valstr = $val['value'];
						}
						$html .= '<td width="'.$val['width'].'" align="'.$val['align'].'">'.$valstr.'</td>';
					}
				 $html .= ' </tr>';
			}
				
			$html .= '</table>';
			$line = str_repeat('_', 88);
			$html .= $line.'<br /><table cellpadding="5" border="0">';
				 
		
		/* End Product line value Line Value */
		$html .= '</table><br /><!--item list end-->';
	
		$pdf->writeHTML($html, true, false, true, false, '');
		//print separate summary detail in next page if 
		
		$summaryhtml = '<!--subtotal start-->
			<table cellpadding="5"  border="0">
				<tr><td width="25pt"></td><td width="235pt">'.$description.'</td>';
		
			$summaryhtml .= '<td><table cellpadding="5"  border="0">';
			$summaryCellKeys = $this->contentSummaryModel->keys();

			$bgcolortotal = '';

			$summarydiscounts = $this->getSummaryDiscounts($pdfsettings, $this->contentSummaryModel->get('DiscountDetails'));
			//echo "<pre>";print_r($summarydiscounts);
			foreach($summaryCellKeys as $key) {
				$keyvalue = $this->contentSummaryModel->get($key);
				
				if(!empty($keyvalue) && $keyvalue !='0.00') {
					/* Start Summary Like Sub Total & Total Info */
					if(strpos($key,'Total(') !==False) {
						$bgcolortotal = '#F9F0D6';
					} 	
						
					if($key == 'Discount') {
						$summaryhtml .= '<tr><td colspan="3" width="210pt"  bgcolor='.$bgcolortotal.'><strong>'.$key.':</strong></td>	
						<td align="right" width="70pt"  bgcolor='.$bgcolortotal.'>'.$keyvalue.'</td>
						</tr>';
						
					} else if($key == 'DiscountDetails'){ 
						foreach($summarydiscounts as $kindex=>$val) {
							$summaryhtml .= '<tr><td colspan="3" width="210pt"  bgcolor='.$bgcolortotal.'><i>'.$kindex.':</i></td>	
						<td align="right" width="70pt"  bgcolor='.$bgcolortotal.'>'.$val.'</td>
						</tr>';
						}
					} else {
						$summaryhtml .= '<tr><td colspan="3" width="210pt"  bgcolor='.$bgcolortotal.'><strong>'.$key.':</strong></td>	
						<td align="right" width="70pt"  bgcolor='.$bgcolortotal.'>'.$keyvalue.'</td>
						</tr>';
					}
				}
			/* End Summary Like Sub Total & Total Info */
		}
		$summaryhtml .='</table></td></tr></table>';	

		$summaryheight = $pdf->getStringHeight($summaryhtml,240);
		$pgheight = $pdf->getPageHeight();
		$currheight = $pdf->GetY();
		if($showfooter==1) {
			if($summaryheight > $pgheight-$currheight-$footercontentheight) {
				$pdf->AddPage();
			}
		} else {
			if($summaryheight > $pgheight-$currheight) {
				$pdf->AddPage();
			}
		}			
		
	 	$pdf->writeHTML($summaryhtml, true, false, true, false, '');
		$pdf->Line(101,$pdf->GetY()-3, 201, $pdf->GetY()-3);
		$pdf->Line(101,$pdf->GetY()-2, 201, $pdf->GetY()-2);	

		$termncondition = html_entity_decode(str_replace('&nbsp;','',$footers[0]));	
		/* Start Terms & Condition */

		$html = <<<EOF
		<div style="clear:both"></div><br />	
			<span>
				{$termncondition}
			</span>
		</div>
EOF;
		/* End Terms & Condition */
		//$pdf->writeHTMLCell(250, 120, $x, $pdf->GetY()+15,$html, 0,0, 0,true, '', true);	
		$pdf->writeHTML($html, true, false, true, false, '');
		
		$pages = $pdf->getNumPages();
		$w =  $pdf->getPageWidth();
		$h =  $pdf->getPageHeight();
				
		$marginx = 5;
		$marginy = $footercontentheight;
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
							$companyaddress = "<span style=\"font-size:15pt\"><br /><br />".$headerinfo['summary']."</span><br />".$headerinfo[content]."<br />".$vatlabel." :  ".$headerinfo['vatid'];
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
								//add by amir
								if(strpos($label,'Total Amount (')!==False) {	

									if (strpos($textvalue, '.')===false) {
										$text = '<strong>'.$label.'</strong>';
										$textvalue = '<strong>'.$value.'</strong>'.'<strong>'.'.00'.'</strong>';
									}
									else{
										$text = '<strong>'.$label.'</strong>';
										$textvalue = '<strong>'.$value.'</strong>';
									}
								} 		
								//end here
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
		if($pdfsettings['showpager'] == 1) { 
			for($step=0;$step<$pages;$step++) {
				$pdf->setPage($step+1);
				$pageno = "Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages();
				//comment by jitu for hiding footer/header in other pages	
				$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
			}
		}
		if($pdfsettings['showfooter'] == 1) {
			
			if(empty($pdfsettings['customfooter']) || $pdfsettings['customfooter']=='&nbsp;') { 
				$footercontent = '';
			}
			if($pdfsettings['repeatfooter'] ==1) { 	
				for($step=0;$step<$pages;$step++) {
					$pdf->setPage($step+1);
					$pdf->writeHTMLCell($w, 50, $marginx, $h-$marginy,$footercontent, 0,0, 0,true, '', true);		
					if($pdfsettings['showpager'] == 1) {
						$pageno = "<i>Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages()."</i>";		
						//comment by jitu for hiding footer/header in other pages	
						$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
					}
					
				}

			} elseif($pdfsettings['showpager'] != 1 && $pdfsettings['repeatfooter'] !=1) {
				$pdf->setPage(1);
				$pdf->writeHTMLCell($w, 50, $marginx, $h-$marginy,$footercontent, 0,0, 0,true, '', true);				$pageno = "<i>Page ".$pdf->getAliasNumPage().' of '.$pdf->getAliasNbPages()."</i>";
				//comment by jitu for hiding footer/header in other pages	
			//	$pdf->writeHTMLCell(200, 50, ($w/2 - 20), ($h-10),$pageno, 0,0, 0,true, '', false);
			}
			$pdf->InFooter = false;
		} 
		//End here

		$this->onSummaryPage = true;
	}

	function displayLastPage($parent) {
		// Add last page to take care of footer display
		if($parent->createLastPage()) {
			$this->onSummaryPage = false;
		}
	}
	
}
?>

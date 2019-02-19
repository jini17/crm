<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class SalesTarget_Record_Model extends Vtiger_Record_Model {

	/**
	 * Static Function to get the instance of all the User Record models
	 * @return <Array> - List of LeaveAllocation_Record_Model instances
	 */

	public static function getActiveTargets($targetIds){
		$db = PearDatabase::getInstance();
		$targetSQL = "SELECT * 
				FROM 
					vtiger_salestarget 
				INNER JOIN 
				 	vtiger_crmentity 
				ON 
					vtiger_crmentity.crmid = vtiger_salestarget.salestargetid
				WHERE 
					vtiger_salestarget.targetstatus = 'Active'
				AND 
				  	vtiger_crmentity.deleted = '0' AND salestargetid IN (".implode(',',$targetIds).")";
		$sqlActiveTarget = $db->pquery($targetSQL,array());
		$arrayVar = array();
		$tblEmpty = $db->pquery("DELETE FROM secondcrm_targets_value WHERE targetsid IN (?)",array(implode(',',$targetIds)));
		$error = '';
		while($activeTargetRow = $db->fetchByAssoc($sqlActiveTarget)){
		$sql = self::targetSQL($activeTargetRow);
		$result_d = $db->pquery($sql,array());
			
			if($db->num_rows($result_d)>0){ 
			$sqlInsertNewTarget = "INSERT INTO secondcrm_targets_value (actual_target_count, targetsid, module, month_year, actual_target_amount,  region, user_group, products) (".$sql.")";
			$result = $db->pquery($sqlInsertNewTarget);
				
				if(!$result) {	
					$error += 1; 
				} else {
					$error = 0;
				}
				//$updateSqlquery = "SELECT ";;
			} 
			else {
				if($error !=0) 
					$error = 'N';
			}
		}//while close
		return $error;	

	}
	public function targetSQL($activeTargetRow){
		$targetId = $activeTargetRow['salestargetid'];
		$targetModuleCombine = explode(",",$activeTargetRow['targetmodule']);
		$targetModule = $targetModuleCombine[0];
		$targetDateColumn = $targetModuleCombine[2];
		$targetTerritory = $activeTargetRow['targetterritory'];
		if($targetTerritory !='all' && $targetTerritory !='') {
			$targetTerritory = "'" . implode("','", explode(',', $targetTerritory)) . "'";
		}
		$targetUser = $activeTargetRow['targetuser'];
		$targetProduct = $activeTargetRow['linktoproduct'];
		$combineTerritory = $activeTargetRow['combineterritory'];
		$combineProduct = $activeTargetRow['combineproduct'];
		$targetStartingMonth = $activeTargetRow['startingmonth'];		
		$targetYear = $activeTargetRow['targetyear'];
		$startDate = date("Y-m-d",strtotime($targetStartingMonth.$targetYear));
		//echo"<br>";
		$endDate = date('Y-m-d', strtotime("+12 months", strtotime($startDate)));
	
		if($targetModule == "Quotes"){
			$main_tbl = "vtiger_quotes";	
			$cf_tbl = "vtiger_quotescf";	
			$id = "quoteid";
			$duedate = "vtiger_quotes.$targetDateColumn";
			if($targetDateColumn == 'createdtime') 
				$duedate = "tblVTCRM.createdtime";

			$status = "vtiger_quotes.quotestage = '".$targetModuleCombine[1]."'";
			$regionColumn = " vtiger_quotes.region";
		}
		else if($targetModule == 'Invoice'){
			$main_tbl = "vtiger_invoice";	
			$cf_tbl = "vtiger_invoicecf";	
			$id = "invoiceid";
			$duedate = "vtiger_invoice.$targetDateColumn";
			if($targetDateColumn == 'createdtime') 
				$duedate = "tblVTCRM.createdtime";
			$status = "vtiger_invoice.invoicestatus = '".$targetModuleCombine[1]."'";
			$regionColumn = " vtiger_invoice.region";
		} 
		else if($targetModule == 'SalesOrder'){
			$main_tbl = "vtiger_salesorder";	
			$cf_tbl = "vtiger_salesordercf";	
			$id = "salesorderid";
			$duedate = "vtiger_salesorder.$targetDateColumn";
			if($targetDateColumn == 'createdtime') 
				$duedate = "tblVTCRM.createdtime";
			$status = "vtiger_salesorder.sostatus = '".$targetModuleCombine[1]."'";
			$regionColumn = " vtiger_salesorder.region";
		} 
		else if($targetModule == 'Payments'){
			$main_tbl = "vtiger_payments";	
			$cf_tbl = "vtiger_paymentscf";	
			$id = "paymentsid";
			$duedate = "vtiger_payments.$targetDateColumn";
			if($targetDateColumn == 'createdtime') 
				$duedate = "tblVTCRM.createdtime";
			$status = "vtiger_payments.payment_status = '".$targetModuleCombine[1]."'";
			$regionColumn = " vtiger_payments.region";  

		}
 		else {
			$main_tbl = "vtiger_potential";	
			$cf_tbl = "vtiger_potentialscf";	
			$id = "potentialid";
			$duedate = "vtiger_potential.$targetDateColumn";
			if($targetDateColumn == 'createdtime') 
				$duedate = "tblVTCRM.createdtime";	
			$status = "vtiger_potential.sales_stage = '".$targetModuleCombine[1]."'";
			$regionColumn = " vtiger_potential.region";  

		}
		//start main sql stmt
		$targetMainSQL = "SELECT COUNT($main_tbl.$id) AS actual_count, ".$targetId." AS TargetID,  tblVTCRM.setype AS modulename, DATE_FORMAT($duedate,'%Y-%m-01') as month_year, ";
	
		if($targetModule == 'Potentials') {
			$targetMainSQL .= " SUM($main_tbl.amount) AS actual_amount";
		} else if($targetModule == 'Payments') {
			$targetMainSQL .= " SUM($main_tbl.amount - $main_tbl.discount) AS actual_amount";
		} else  {
			 if($targetProduct != NULL && $targetProduct !='') {
				if($combineProduct == "1") {	
		//		$targetMainSQL .= "  SUM((tblVTPRODREL.listprice*tblVTPRODREL.quantity - coalesce(tblVTPRODREL.discount_amount,0))) AS actual_amount";
				$targetMainSQL .= "  SUM(((SELECT (tblVTPRODREL.listprice*tblVTPRODREL.quantity - (tblVTPRODREL.listprice*tblVTPRODREL.quantity*$main_tbl.discount_amount/SUM(tblVTPRL.listprice*tblVTPRL.quantity))) FROM vtiger_inventoryproductrel tblVTPRL WHERE tblVTPRL.id=tblVTPRODREL.id) -coalesce(tblVTPRODREL.discount_amount,0))) AS actual_amount";
				} else {
				//	$targetMainSQL .= "  (tblVTPRODREL.listprice*tblVTPRODREL.quantity - coalesce(tblVTPRODREL.discount_amount,0)) AS actual_amount";
					$targetMainSQL .= "  SUM((SELECT (tblVTPRODREL.listprice*tblVTPRODREL.quantity - (tblVTPRODREL.listprice*tblVTPRODREL.quantity*$main_tbl.discount_amount/SUM(tblVTPRL.listprice*tblVTPRL.quantity))) FROM vtiger_inventoryproductrel tblVTPRL WHERE tblVTPRL.id=tblVTPRODREL.id) -coalesce(tblVTPRODREL.discount_amount,0)) AS actual_amount";		
				}
			} else {
				$targetMainSQL .= "  SUM($main_tbl.pre_tax_total)  AS actual_amount";
			}
		}	

		//from and join stmt
		$fromNjoin = "
			FROM 
			$main_tbl 
		Inner JOIN 
			vtiger_crmentity tblVTCRM 
		ON 
			tblVTCRM.crmid = $main_tbl.$id 
		AND 
			tblVTCRM.setype = '$targetModule'

		Inner JOIN 
			$cf_tbl
		ON 
			$cf_tbl.$id = $main_tbl.$id";
		$fromNjoin .= '';
		if($targetModule == 'Potentials') {
			if($targetProduct != NULL && $targetProduct !='') 
				$fromNjoin .=" LEFT JOIN vtiger_seproductsrel tblVTPRODREL ON tblVTPRODREL.crmid = $main_tbl.$id
						LEFT JOIN vtiger_products tblVTPROD ON tblVTPROD.productid = tblVTPRODREL.productid";
		} else if($targetModule == 'Payments' ) {
			$fromNjoin .=" ";
		} else  {
			if($targetProduct != NULL && $targetProduct !='') {
				$fromNjoin .=" LEFT JOIN vtiger_inventoryproductrel tblVTPRODREL ON tblVTPRODREL.id = $main_tbl.$id
						LEFT JOIN vtiger_products tblVTPROD ON tblVTPROD.productid = tblVTPRODREL.productid";
			}	
		}
		
		//where stmt
		$where = " 
			WHERE 
				$status 
			AND 
				tblVTCRM.deleted = '0'
			AND 
				$duedate >= '".$startDate."' 
			AND 
				$duedate < '".$endDate."'";
		
		if($targetModule == 'Payments') {
			$where .= " AND $main_tbl.payment_type = 'Income'";
		}	
	
		if($targetTerritory != NULL && $targetTerritory !='' ){ 
			if($targetTerritory=="all"){
				if($combineTerritory == "1"){
					$groupbyterritory = "";
					$targetMainSQL .= ", (Select GROUP_CONCAT(concat(tree,'#',regionid) SEPARATOR ',') FROM secondcrm_region_data ) AS territory";
				} else {
					$targetMainSQL .=", $regionColumn AS territory";
					$groupbyterritory = $regionColumn;
		
				}
				$where .= " ";
			} else {
				if($combineTerritory == "1"){
					$groupbyterritory = "";
					$targetTerritorycol = $activeTargetRow['targetterritory'];
					$targetTerritorycol = "". implode(",", explode(',', $targetTerritorycol)) . "";	
					$targetMainSQL .= ",".'"'.$targetTerritorycol.'"'." AS territory";
				} else {
					$targetMainSQL .= ", $regionColumn AS territory";
					$groupbyterritory = $regionColumn;
		
				}
				$where .= " AND $regionColumn IN ($targetTerritory)";
			}
		} else { 
				$groupbyterritory = "";
				$targetMainSQL .= ", ' ' AS territory";
				$where .= "";
		}

		if($targetUser != NULL  && $targetUser !='' ){
			//check owner type
			$userarray = explode(',',$targetUser);
			$db = PearDatabase::getInstance();
			$ownertype = Vtiger_Multiusergroup_UIType::getOwnerType($userarray[0]);
			if($ownertype == 'User') {
				$groupbyuser = "tblVTCRM.smownerid";
				$where   .= " AND tblVTCRM.smownerid IN ($targetUser)";
				$targetMainSQL .= ", tblVTCRM.smownerid AS user";
			} else {
				//find all users in case of groups
				$groupbyuser = "tblVTCRM.smownerid";
				$where   .= " AND tblVTCRM.smownerid IN ($targetUser)";
				$targetMainSQL .= ", tblVTCRM.smownerid AS user";
			}		
		} else {
			$groupbyuser = "";
			$targetMainSQL .= ", tblVTCRM.smownerid AS user";
			$where .= "";		
		}
		
	
		if($targetProduct != NULL && $targetProduct !='' && $targetModule !='Payments' && $targetModule !='Potentials'){ 
			if($targetProduct == "all"){
				if($combineProduct == "1"){
					$groupbyproduct = "";
					$targetMainSQL .= ", (SELECT GROUP_CONCAT(productid SEPARATOR ',' ) FROM vtiger_products) AS productrel_id";
				} else {
					$groupbyproduct = "tblVTPROD.productid";
					$targetMainSQL .= ", tblVTPROD.productid AS productrel_id";
				}
				$where .= " ";
			} else {
				if($combineProduct == "1"){
					$groupbyproduct = "";
					$targetMainSQL .= ",'".($targetProduct)."' AS productrel_id";
				} else {
					$groupbyproduct = "tblVTPRODREL.productid";
					$targetMainSQL .= ", tblVTPRODREL.productid AS productrel_id";					
				}
				$where   .= " AND tblVTPRODREL.productid IN ($targetProduct)";
			}
		} else {	
					$groupbyproduct = "";
					$targetMainSQL .= ", ' ' AS productrel_id";
					$where   .= "";
		}
		$group = '';
	

		if($groupbyterritory != NULL){ 
			$groupbyterritory = " GROUP BY " .$groupbyterritory;
			$group .= $groupbyterritory;
		}
		
		if($groupbyuser != NULL){

			if(strpos($group,'GROUP BY') !== false) {
				$group .= ', '.$groupbyuser;
			} else {
			   $groupbyuser = " GROUP BY " .$groupbyuser;
			   $group .= $groupbyuser;	
			}	
		}

		if ($groupbyproduct != NULL){

			if(strpos($group,'GROUP BY') !== false) {
				$group .= ', '.$groupbyproduct;
			} else {
			   $groupbyproduct = " GROUP BY month_year ";
			   $group .= $groupbyproduct;	
			}
		}
		
		$salesTargetSql =  $targetMainSQL.$fromNjoin.$where;
		
		if(empty($group)) {
			$group .=" GROUP BY month_year";
		} else {
			$group .=", month_year";
		}	
		return $salesTargetSql.$group;
	}

	public static function getActiveSalesTargetListOption($id){
		$db = PearDatabase::getInstance();
		$and = "";
		$activeTarget = "SELECT distinct  tblSCTV.targetsid, concat(vtiger_salestarget.target_title,' ',vtiger_salestarget.targetno) as target_title,vtiger_salestarget.salestargetid FROM vtiger_salestarget 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_salestarget.salestargetid
				INNER JOIN secondcrm_targets_value tblSCTV ON tblSCTV.targetsid = vtiger_salestarget.salestargetid
				WHERE vtiger_salestarget.targetstatus = 'Active' AND vtiger_crmentity.deleted = '0'";

		$SQL = $activeTarget;
		$sqlActiveTarget = $db->pquery($SQL,array());
		$option = "<option value=''>Select One</option>";
		while($result = $db->fetchByAssoc($sqlActiveTarget)){
			$option .= "<option value='".$result['salestargetid']."'";
			if($id === $result['salestargetid']){
				$option .=" selected";
			}
			$option .=">".$result['target_title']."</option>";
			
		}
		return $option;
	}

	public static function getSalesTargetDetail($id){
		$db = PearDatabase::getInstance();
		$activeTarget = "SELECT * 
				FROM 
					vtiger_salestarget 
				INNER JOIN 
				 	vtiger_crmentity 
				ON 
					vtiger_crmentity.crmid = vtiger_salestarget.salestargetid
				WHERE 
					vtiger_salestarget.targetstatus = 'Active'
				AND 
				  	vtiger_crmentity.deleted = '0'
				AND
					vtiger_salestarget.salestargetid =?
				";
		$sqlActiveTarget = $db->pquery($activeTarget,array($id));
		$data = array();
		$data[] = $db->query_result($sqlActiveTarget,0,"startingmonth");
		$data[] = $db->query_result($sqlActiveTarget,0,"targettype");	
		return $data;
	}

	public static function getSalesTargetFullDetail($id){
		$db = PearDatabase::getInstance();
		$activeTarget = "SELECT * 
				FROM 
					vtiger_salestarget 
				INNER JOIN 
				 	vtiger_crmentity 
				ON 
					vtiger_crmentity.crmid = vtiger_salestarget.salestargetid
				WHERE 
					vtiger_salestarget.targetstatus = 'Active'
				AND 
				  	vtiger_crmentity.deleted = '0'
				AND
					vtiger_salestarget.salestargetid =?
				";
		$sqlActiveTarget = $db->pquery($activeTarget,array($id));
		$data = array();
		$data[] = $db->query_result($sqlActiveTarget,0,"target_title");	
		$data[] = $db->query_result($sqlActiveTarget,0,"targetno");	
		return $data;
	}

	public function viewSalesReport($target, $cols, $group,$targettype,$cond,$duplicateheader) {
		$db = PearDatabase::getInstance();
		$targetdata = array();

		$getTargetDetail = self::getSalesTargetDetail($target);

		if ($targettype =='Count') {
			$insqlpart = ", group_concat(concat(tblSCT.actual_target_count,'#',date_format(tblSCT.month_year,'%b')) SEPARATOR '::') AS targetCol";
		} else {
			$insqlpart = ", group_concat(concat(tblSCT.actual_target_amount,'#',date_format(tblSCT.month_year,'%b')) SEPARATOR '::') AS targetCol";
		}	

		$targetdata = array();
	
		switch($group) {
					
			case 'Territory' :
				$colA = 'UserGroup';
				$colB = 'Product';

				$query = "SELECT tblSCT.region AS ".$group.", tblSCT.user_group AS ".$colA.", tblSCT.products AS ".$colB." ".$insqlpart.",tblVTST.* 
					FROM secondcrm_targets_value tblSCT
					LEFT JOIN vtiger_salestarget tblVTST ON tblVTST.salestargetid = tblSCT.targetsid
					WHERE tblSCT.targetsid = ? GROUP BY tblSCT.region, tblSCT.user_group, tblSCT.products";
			break;

			case 'UserGroup' :
				$colA = 'Territory';
				$colB = 'Product';

				$query = "SELECT tblSCT.user_group AS ".$group.", tblSCT.region AS ".$colA.", tblSCT.products AS ".$colB." ".$insqlpart.",tblVTST.*  
						FROM secondcrm_targets_value tblSCT
					LEFT JOIN vtiger_salestarget tblVTST ON tblVTST.salestargetid = tblSCT.targetsid
					WHERE tblSCT.targetsid = ? GROUP BY tblSCT.user_group, tblSCT.region, tblSCT.products";
			break;
		
			case 'Product' :
				$colA = 'Territory';
				$colB = 'UserGroup';

				$query = "SELECT tblSCT.products AS ".$group.", tblSCT.region AS ".$colA.", tblSCT.user_group AS ".$colB." ".$insqlpart.",tblVTST.* 
					FROM secondcrm_targets_value tblSCT
					LEFT JOIN vtiger_salestarget tblVTST ON tblVTST.salestargetid = tblSCT.targetsid
					WHERE tblSCT.targetsid = ? GROUP BY tblSCT.products, tblSCT.region, tblSCT.user_group";
			break;

			default :

				$colA = 'Territory';
				$colB = 'UserGroup';
				$group = 'Product';
				$query = "SELECT group_concat(tblSCT.products SEPARATOR '::')  AS ".$group.", group_concat(tblSCT.region SEPARATOR '::') AS ".$colA.", group_concat(tblSCT.user_group SEPARATOR '::') AS ".$colB." ".$insqlpart.",tblVTST.* 
					FROM secondcrm_targets_value tblSCT
					LEFT JOIN vtiger_salestarget tblVTST ON tblVTST.salestargetid = tblSCT.targetsid
					WHERE tblSCT.targetsid = ?";
							
		}
			//echo $query;
			$reportresult = $db->pquery($query,array($target));
			$num_rows = $db->num_rows($reportresult); 
			$gcol = '';
			$jq = -1;	
			$js = -1;
			$groupcolumn  = '';
			array_shift($cols); 
			array_shift($cols); 
			if($num_rows >0) { 
				for($i=0;$i<$num_rows;$i++) {
					$Q1total = 0;
					$Q2total = 0;
					$Q3total = 0;
					$Q4total = 0;
					$actual = 0;
					$annualtotal = 0;
					$groupcol  = $db->query_result($reportresult,$i,strtolower($group));
					$firstcols = $db->query_result($reportresult,$i,strtolower($colA));
					$secondcols = $db->query_result($reportresult,$i,strtolower($colB));	
					$targetcols = $db->query_result($reportresult,$i,"targetcol");
					///echo $groupcol ."=>".$firstcols."=>".$secondcols."=>".$targetcols."<br />";	
					
					if(trim($firstcols)=='') {
						$firstcol = '-';					
					} else {
						$firstcolarray = array_unique(explode('::',$firstcols));
						$firstcol = self::getColumnValue($firstcolarray[0],$colA);
					}
	
					if(trim($secondcols)=='') {
						$secondcol = '-';					
					} else {
						$secondcolarray = array_unique(explode('::',$secondcols));
						$secondcol = self::getColumnValue($secondcolarray[0],$colB);
					}					
					
					if(trim($groupcol) =='') {
						$groupcol = '';						
					} else {
						$groupcol = strtoupper(self::getColumnValue($groupcol,$group));
					}
				
					$targetcolarray = explode('::',$targetcols);
			
					foreach($targetcolarray as $targetcol) {
						$array = explode('#', $targetcol);
						$targetColumns[$array[1]] = $array[0]; 		
					}

					if($gcol =='') {
						$gcol = $groupcol;
						$js++;
					} else if($gcol == $groupcol) {
						$js++;
					} else {
						$js = 0;
						$gcol = $groupcol;
						$jq++;
					}
					
						
					foreach($cols as $col) {
						
						$mcol = $col;
						if($col =='Mar') { 
							$mcol ='March';		
						} else if($col == 'Jul') {
							$mcol = 'July';	
						}
						
						$target = $db->query_result($reportresult,$i,strtolower($mcol)."target");
						$actual = isset($targetColumns[$col])?number_format((float)$targetColumns[$col], 2, '.', ''):number_format((float)0.00, 2, '.', '');
						$targetdata[$jq][$gcol][$js][$colA] = $firstcol;
						$targetdata[$jq][$gcol][$js][$colB] = $secondcol;	
						$targetdata[$jq][$gcol][$js][$col]['Actual'] = $actual;	
				 		$targetdata[$jq][$gcol][$js][$col]['Target']  = number_format((float)$target, 2, '.', ''); 			
						if(isset($cond['q'])) { 
							if($getTargetDetail[0] ='January') {
								
								if($col =='Q1') { 
									foreach(array('Jan','Feb','Mar') as $val) {
										$Q1total  += isset($targetColumns[$val])?number_format((float)$targetColumns[$val], 2, '.', ''):number_format((float)0.00, 2, '.', '');
									}	
									
									
								} else if($col =='Q2') {
									foreach(array('Apr','May','Jun') as $val) {
										$Q2total += isset($targetColumns[$val])?number_format((float)$targetColumns[$val], 2, '.', ''):number_format((float)0.00, 2, '.', '');
									}	
									
								} else if($col =='Q3') {
									foreach(array('Jul','Aug','Sep') as $val) {
										$Q3total += isset($targetColumns[$val])?number_format((float)$targetColumns[$val], 2, '.', ''):number_format((float)0.00, 2, '.', '');
									}	
									
								} else if($col =='Q4') {
									foreach(array('Oct','Nov','Dec') as $val) {
										$Q4total += isset($targetColumns[$val])?number_format((float)$targetColumns[$val], 2, '.', ''):number_format((float)0.00, 2, '.', '');
									}	
									
								}		  	
							} else {
								if($col =='Q1') {	
									foreach(array('Apr','May','Jun') as $val) {
										$Q1total  += isset($targetColumns[$val])?$targetColumns[$val]:0;
									}
								} else if($col =='Q2') {
									foreach(array('Jul','Aug','Sep') as $val) {
										$Q2total  +=isset($targetColumns[$val])?$targetColumns[$val]:0;
									}
																	
								} else if($col =='Q3') {
									foreach(array('Oct','Nov','Dec') as $val) {
										$Q3total  += isset($targetColumns[$val])?$targetColumns[$val]:0;
									}							
								} else if($col =='Q4') {	
									foreach(array('Jan','Feb','Mar') as $val) {
										$Q4total  += isset($targetColumns[$val])?$targetColumns[$val]:0;
									}	
								}		
							}
							if($col =='Q1')
								$targetdata[$jq][$gcol][$js][$col]['Actual']  = number_format((float)$Q1total, 2, '.', '');
							if($col =='Q2')
								$targetdata[$jq][$gcol][$js][$col]['Actual']  = number_format((float)$Q2total, 2, '.', '');
							if($col =='Q3')
								$targetdata[$jq][$gcol][$js][$col]['Actual']  = number_format((float)$Q3total, 2, '.', '');
							if($col =='Q4')
								$targetdata[$jq][$gcol][$js][$col]['Actual']  = number_format((float)$Q4total, 2, '.', '');
						} //end Quaterly condition
							
						if(isset($cond['a']) && $col =='Annual') {
							foreach(array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') as $val) {
								$annualtotal  += isset($targetColumns[$val])?number_format((float)$targetColumns[$val], 2, '.', ''):number_format((float)0.00, 2, '.', '');
							}	
							$targetdata[$jq][$gcol][$js][$col]['Actual'] =$annualtotal; $annualtotal;					
						}
					
					} //end cols foreach
					
					unset($targetColumns);
				} //end for loop
			}//if condition

		//echo "<pre>";print_r($targetdata);
		return $targetdata;
	}

	public function getColumnValue($columnvalue, $coltype) {
		$db = PearDatabase::getInstance();
			
		if($coltype == 'UserGroup') {
			$ownertype = 	Vtiger_Multiusergroup_UIType::getOwnerType($columnvalue);
			if($ownertype == 'Group') {
				$name = getGroupName($columnvalue);
			} else {
				$name = getUserName($columnvalue);
			}	
			if(is_array($name)) {
				$name = $name[0];
			}
		} else if($coltype == 'Product') {
			$result = $db->pquery("SELECT group_concat(productname SEPARATOR ', ') AS product FROM vtiger_products WHERE productid IN ($columnvalue)",array());
			$name = '('.$db->query_result($result,0,"product").')';	
			
		} else {
			$name = Vtiger_Multiregion_UIType::getDisplayValue($columnvalue);
		}

		return $name;
	}
	
	function getGenerationDate($targetId){	
		$db = PearDatabase::getInstance();
		$result = $db->pquery("SELECT date_format(updated_date,'%d-%m-%Y %H:%i:%s') as updated_date FROM secondcrm_targets_value WHERE targetsid =? LIMIT 0,1",array($targetId));
		$date = $db->query_result($result,0,"updated_date");
		return $date;
	}
	
	/**
	 * Function exports reports data into a Excel file
	 */
	function getReportXLS($targetId,$request) {
		
		$rootDirectory = vglobal('root_directory');
		$tmpDir = vglobal('tmp_dir');
		$targetDetails = SalesTarget_Record_Model::getSalesTargetFullDetail($targetId);

		$tempFileName = tempnam($rootDirectory.$tmpDir, 'xls');
		$fileName = decode_html($targetDetails[0]).'.xls';
		SalesTarget_Record_Model::writeReportToExcelFile($tempFileName,$request);

		if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
			header('Pragma: public');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		}

		header('Content-Type: application/x-msexcel');
		header('Content-Length: '.@filesize($tempFileName));
		header('Content-disposition: attachment; filename="'.$fileName.'"');

		$fp = fopen($tempFileName, 'rb');
		fpassthru($fp);

	}


	function writeReportToExcelFile($fileName,$request) {

		global $currentModule, $current_language;
		$mod_strings = return_module_language($current_language, $currentModule);
		
		$targetid = $request->get('targetid');
		$generatedate = self::getGenerationDate($targetid);
		$groupby = $request->get('groupby');
		$targetDetails = SalesTarget_Record_Model::getSalesTargetFullDetail($targetid);

		$headercolumns = array();
		$duplicateheader = array();

		if($groupby == 'Territory') {
			array_push($headercolumns,"UserGroup");
			array_push($headercolumns,"Product");
			
		} else if($groupby == 'UserGroup') {
			array_push($headercolumns,"Territory");
			array_push($headercolumns,"Product");
		} else {
			array_push($headercolumns,"Territory");
			array_push($headercolumns,"UserGroup");	
		}
		$result = SalesTarget_Record_Model::getSalesTargetDetail($targetid);
		$jq = 1;
		$startmonth = $result[0];
		if($request->get('monthly') !='') {
			$cond['m'] = $request->get('monthly');
			for($i=1;$i<=12;$i++) {
				$month = date('M', strtotime($startmonth));
				array_push($headercolumns,$month);	
				if($i%3==0 && $request->get('quaterly') !='') {
				  $cond['q'] = $request->get('quaterly');
				  array_push($headercolumns,'Q'.$jq);	
				  $jq++;	
				}
				$startmonth = date('M',strtotime("+1 month", strtotime($month)));
			}
			
		} 
		if($request->get('quaterly') !='' && $request->get('monthly') =='') {
			$cond['q'] = $request->get('quaterly');
			array_push($headercolumns,'Q1');
			array_push($headercolumns,'Q2');
			array_push($headercolumns,'Q3');
			array_push($headercolumns,'Q4');	
		}

		if($request->get('annually') !='') {	
			 $cond['a'] = $request->get('annually');
			 for($i=1;$i<=12;$i++) {
				$month = date('M', strtotime($startmonth));
				array_push($duplicateheader,$month);	
				$startmonth = date('M',strtotime("+1 month", strtotime($month)));
			}
			 array_push($headercolumns, 'Annual');
		}		 

		require_once("libraries/PHPExcel/PHPExcel.php");

		$workbook = new PHPExcel();
		$workbook->getProperties()
			    ->setCreator("SecondCRM")
			    ->setTitle("Export SalesTarget Report")
			    ->setSubject("Export SalesTarget Report");
		$worksheet = $workbook->setActiveSheetIndex(0);

		$reportData = SalesTarget_Record_Model::viewSalesReport($targetid,$headercolumns,$groupby,$result[1],$cond,$duplicateheader);
		$title_styles = array(
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'097E86')),
			'font' => array( 'bold' => true, 'color' => array('rgb' => 'ffffff'),'size'  => 12),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)	
   		);
		$header1_styles = array(
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'EB772A')),
			'font' => array( 'bold' => true, 'color' => array('rgb' => 'ffffff'),'size'  => 11),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)	
		);
		$header2_styles = array(
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'5E8F2D') ),
			'font' => array( 'bold' => true, 'color' => array('rgb' => 'ffffff'),'size'  => 11),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)	
		);
		$data_styles = array(
			'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 'color' => array('rgb'=>'E1E0F7') ),
			'font' => array( 'color' => array('rgb' => '000000'),'size'  => 11),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);

		
		$worksheet->getDefaultStyle()->getFont()->setName('Arial');
		$worksheet->getDefaultStyle()->getFont()->setSize(13); 
		$worksheet->getPageMargins()->setTop(30);
		$worksheet->getPageMargins()->setRight(3.75);
		$worksheet->getPageMargins()->setLeft(3.75);
		$worksheet->getPageMargins()->setBottom(3);	
		$worksheet->mergeCells('A1:J1');		
		$worksheet->getStyle('A1:J1')->applyFromArray($title_styles);
		$worksheet->getRowDimension(1)->setRowHeight(40);	
		$worksheet->setCellValue('A1',$targetDetails[0]."\n".'Generated on: '.$generatedate."\n".'Group By :'. $groupby);
		$colsarray = array('Product','Territory', 'UserGroup');	
		if(isset($headercolumns)) {
			$count = 0;
			$rowcount = 4;
			
		foreach($reportData as $i=>$datavalues) {	
			foreach($reportData[$i] as $k=>$array_value) {
				$count = 0;
				$worksheet->mergeCells('A'.$rowcount.':'.'J'.$rowcount);
				$worksheet->getStyle('A'.$rowcount.':'.'J'.$rowcount)->applyFromArray($header1_styles);
				$worksheet->getRowDimension($rowcount)->setRowHeight(20);
				$worksheet->setCellValueExplicitByColumnAndRow($count, $rowcount, $k, true);
				$rowcount++;

				$startCol = 'A';
				$endCol   = PHPExcel_Cell::stringFromColumnIndex(count($headercolumns)*2-3);	
				$worksheet->getStyle($startCol.$rowcount.':'.$endCol.$rowcount)->applyFromArray($header2_styles);		$worksheet->getRowDimension($rowcount)->setRowHeight(20);
				foreach($headercolumns as $key=>$value) {
					
					if(in_array($value,$colsarray)) {
						$worksheet->mergeCells($startCol.$rowcount.':'.$startCol.($rowcount+1));						$worksheet->setCellValueExplicitByColumnAndRow($count, $rowcount, $value, true);					$startCol = chr(ord($startCol)+1);
						 $count = $count + 1;
					} else {
						$merge = SalesTarget_Record_Model::cellsToMergeByColsRow($count,($count+1),$rowcount);
						$worksheet->mergeCells($merge);
						$worksheet->setCellValueExplicitByColumnAndRow($count, $rowcount, $value, true);					
						$endCol = PHPExcel_Cell::stringFromColumnIndex(count($headercolumns)*2-3);	
						$worksheet->getStyle($startCol.($rowcount+1).':'.$endCol.($rowcount+1))->applyFromArray($header2_styles);			$worksheet->setCellValueExplicitByColumnAndRow($count, ($rowcount+1), 'Actual', true);
						$worksheet->setCellValueExplicitByColumnAndRow($count+1, ($rowcount+1), 'Target', true);					$count = $count + 2;
					}
					 
				}
				$rowcount++;
				
			    }
				foreach($datavalues as $hdr=>$values) {
					$rowcount++;
					foreach($values as $key=>$vals) {
						$colcount = 0;
						foreach($vals as $j=>$val) {
							$startCol = 'A';
							$endCol   = PHPExcel_Cell::stringFromColumnIndex(count($headercolumns)*2-3);	
							$worksheet->getStyle($startCol.$rowcount.':'.$endCol.$rowcount)->applyFromArray($data_styles);				$worksheet->getRowDimension($rowcount)->setRowHeight(20);
							
							if(in_array($j,$colsarray)) {
								$worksheet->setCellValueExplicitByColumnAndRow($colcount, $rowcount, $val, true);							$colcount = $colcount + 1;
							} else {
								$worksheet->setCellValueExplicitByColumnAndRow($colcount, $rowcount, $val['Actual'], true);					$worksheet->setCellValueExplicitByColumnAndRow(($colcount+1), $rowcount, $val['Target'], true);
								$colcount = $colcount + 2;	
							}
							
						}
						$rowcount++;
					}	
					
				}
			$rowcount+=2;	
			} //end outer foreachloop
		}

		$workbookWriter = PHPExcel_IOFactory::createWriter($workbook, 'Excel5');
		$workbookWriter->save($fileName);
	}
	
	function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1){
	    $merge = 'A1:A1';
	    if($start>=0 && $end>=0 && $row>=0){
		$start = PHPExcel_Cell::stringFromColumnIndex($start);
		$end = PHPExcel_Cell::stringFromColumnIndex($end);
		$merge = "$start{$row}:$end{$row}";
	    }
	    return $merge;
}

}

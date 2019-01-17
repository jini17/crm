

<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_ClaimRecords_Model extends Vtiger_Record_Model {
    
    public static function getLeavesInstance($id=null) {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM vtiger_leaves WHERE leavesid=?';
        $params = array($id);
        $result = $db->pquery($query,$params);
	if($db->num_rows($result) > 0) {
            $instance = new self();
            $row = $db->query_result_rowdata($result,0);
            $instance->setData($row);
        } else {
		$instance = new self();
	}
        return $instance;
    }

    public function getCreateClaimURL() {
	return '?module=Users&view=EditClaim';
    }

	//Created by Safuan
	public function getClaimType($claimtypeid){
	$db = PearDatabase::getInstance();
	$query = "SELECT vtiger_claimtype.claimtypeid, vtiger_claimtype.claim_type, vtiger_claimtype.claim_no, vtiger_claimtype.claim_code, vtiger_claimtype.color_code, vtiger_claimtype.claim_status, vtiger_claimtype.claim_description, allocation_claimrel.transaction_limit, allocation_claimrel.monthly_limit, allocation_claimrel.yearly_limit FROM vtiger_claimtype INNER JOIN allocation_claimrel ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid WHERE claimtypeid = $claimtypeid";
	
	$result = $db->pquery($query,array());
	$rowdetail = array();
	$rowdetail['claimtypeid'] = $db->query_result($result, $i, 'claimtypeid');
	$rowdetail['claim_type'] = $db->query_result($result, $i, 'claim_type');
	$rowdetail['claim_no'] = $db->query_result($result, $i, 'claim_no');
	$rowdetail['claim_code'] = $db->query_result($result, $i, 'claim_code');
	$rowdetail['color_code'] = $db->query_result($result, $i, 'color_code');
	$rowdetail['claim_status'] = $db->query_result($result, $i, 'claim_status');
	$rowdetail['claim_description'] = $db->query_result($result, $i, 'claim_description');
	$rowdetail['transaction_limit'] = $db->query_result($result, $i, 'transaction_limit');
	$rowdetail['monthly_limit'] = $db->query_result($result, $i, 'monthly_limit');
	$rowdetail['yearly_limit'] = $db->query_result($result, $i, 'yearly_limit');

	return $rowdetail;

	}

	// Added By Mabruk
	public function getClaimForEmployeeContract($id,$year){ 

		$db 	= PearDatabase::getInstance(); //$db->setDebug(true); 
		
		$query 	= "SELECT claimid, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status, taxinvoice, attachment,approved_by
				FROM vtiger_claim 
				LEFT JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_claim.claimid
				LEFT JOIN vtiger_employeecontract
				ON vtiger_employeecontract.employee_id = vtiger_claim.employee_id
				WHERE vtiger_employeecontract.employeecontractid = ? 
				AND vtiger_crmentity.deleted=0 AND DATE_FORMAT(transactiondate, '%Y') = ? AND vtiger_crmentity.deleted=0";
		$result = $db->pquery($query, array($id,$year));

		$myclaims=array();

		for($i=0;$db->num_rows($result)>$i;$i++){ 

		        $rowdetail = self::getClaimType($db->query_result($result, $i, 'category'));
				$transactiondate = $db->query_result($result, $i, 'transactiondate');
				$rowUsedAmount 	= self::getClaimTypeUsedAmount($userid, $rowdetail['claimtypeid'],$transactiondate);		
			
				$used 			= $rowUsedAmount['yused'];
				$yearlylimit 	= $rowdetail['yearly_limit'];
				if($yearlylimit !='' && $yearlylimit != '0.00'){
					$allocated = $yearlylimit;
					$balance = $allocated-$used;
				} else {
					$allocated = 'No Limit';
					$balance = 'No Limit';
				}
				$myclaims[$i]['allocated']  = $allocated;
				$myclaims[$i]['used'] 		= $used;
				$myclaims[$i]['balance']    = $balance;
				
			
			$myclaims[$i]['category']   = $rowdetail['claim_type'];	
		}
		//print_r($myclaims);die;
		return $myclaims;

	}	


	//Created by Safuan for fetching current user leaves for current year//	
	public function getMyWidgetsClaim($userid,$year, $type = false){ 
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		//echo $type;
		$limit = '';

		if($type=='latestclaim')
			$limit = " ORDER BY transactiondate DESC LIMIT 0, 5";	

		$query = "SELECT claimid, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status, taxinvoice, attachment,approved_by
				FROM vtiger_claim 
				INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_claim.claimid
				WHERE vtiger_claim.employee_id = ?
				AND vtiger_crmentity.deleted=0 AND DATE_FORMAT(transactiondate, '%Y') = ? AND claim_status ='Approved' AND vtiger_crmentity.deleted=0 ".$limit;

		$result = $db->pquery($query,array($userid, $year));
		$myclaims=array();

		for($i=0;$db->num_rows($result)>$i;$i++){ 

	        $rowdetail = self::getClaimType($db->query_result($result, $i, 'category'));
			$transactiondate = $db->query_result($result, $i, 'transactiondate');
			$rowUsedAmount 	= self::getClaimTypeUsedAmount($userid, $rowdetail['claimtypeid'],$transactiondate);
		
			if($type =='latestclaim'){
				$myclaims[$i]['totalamount'] = 	$db->query_result($result, $i, 'totalamount');
				$myclaims[$i]['transactiondate'] = 	$transactiondate;
			} else{
				$used 			= $rowUsedAmount['yused'];
				$yearlylimit 	= $rowdetail['yearly_limit'];
				if($yearlylimit !='' && $yearlylimit != '0.00'){
					$allocated = $yearlylimit;
					$balance = $allocated-$used;
				} else {
					$allocated = 'No Limit';
					$balance = 'No Limit';
				}
				$myclaims[$i]['allocated']  = $allocated;
				$myclaims[$i]['used'] 		= $used;
				$myclaims[$i]['balance']    = $balance;
				
			}
			$myclaims[$i]['category']   = $rowdetail['claim_type'];	
		}
		
		return $myclaims;

	}


	//Created by Safuan for fetching team leaves//
	public function getMyTeamWidgetClaim($userid, $year, $type, $selectedmember){

		$db = PearDatabase::getInstance();

		global $current_user;
		$teamreporttoquery = "SELECT id FROM vtiger_users WHERE reports_to_id=$userid";
		$resulteamreport = $db->pquery($teamreporttoquery,array());
		
		$teamidreport= array();
		for($i=0;$db->num_rows($resulteamreport)>$i;$i++){ 
			$teamidreport[] = $db->query_result($resulteamreport, $i, 'id');
		}
		$allteammate= implode(",", $teamidreport);

		if(!empty($selectedmember)) {
			$memcondition 	= " AND vtiger_claim.employee_id = $selectedmember";
		} else if(count($teamidreport)>0){
			$memcondition	= "AND vtiger_claim.employee_id IN (".$allteammate.")";	
		}	
		
		if($type == 'claimtype'){

			$querygetteamclaim="SELECT CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, category, sum(totalamount) as yused, vtiger_claim.employee_id 
						FROM vtiger_claim 
						INNER JOIN vtiger_crmentity
						ON vtiger_crmentity.crmid = vtiger_claim.claimid
	                   	INNER JOIN vtiger_users
	                    ON vtiger_claim.employee_id=vtiger_users.id AND vtiger_claim.employee_id is NOT NUlL
						WHERE vtiger_crmentity.deleted=0 ".$memcondition." AND DATE_FORMAT(transactiondate, '%Y') = $year 
						AND vtiger_claim.claim_status = 'Approved' group by vtiger_claim.employee_id, vtiger_claim.category";
			
			$resultgetteamleave = $db->pquery($querygetteamclaim,array());
			$myteamclaims=array();	

			for($i=0;$db->num_rows($resultgetteamleave)>$i;$i++){
				
				$claimTypeid 					= $db->query_result($resultgetteamleave, $i, 'category'); 
	            $rowdetail 						= self::getClaimType($claimTypeid);
				$myteamclaims[$i]['fullname'] 	= $db->query_result($resultgetteamleave, $i, 'fullname');
				$myteamclaims[$i]['category'] 	= $rowdetail['claim_type'];
				$employee_id 					= $db->query_result($resultgetteamleave, $i, 'employee_id'); 

				$yearlylimit 	 = $rowdetail['yearly_limit'];
				$rowdetailUsed 	 = self::getClaimTypeUsedAmount($employee_id, $claimTypeid, $transactiondate);
				$used 			 = $db->query_result($resultgetteamleave, $i, 'yused'); 
					
				if($yearlylimit !='' && $yearlylimit != '0.00'){
					$allocated 	 = $yearlylimit;
					$balance 	 = $allocated-$used ;

				} else {
					$allocated = 'No Limit';
					$balance = 'No Limit';
				}
				$myteamclaims[$i]['allocated']  = $allocated;
				$myteamclaims[$i]['used'] 		= $used;
				$myteamclaims[$i]['balance']    = $balance;
			}
		} else {
			$querygetteamclaim="SELECT vtiger_claim.claimid, vtiger_claim.employee_id, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, category, 
						totalamount, transactiondate, claim_status FROM vtiger_claim 
						INNER JOIN vtiger_crmentity	ON vtiger_crmentity.crmid = vtiger_claim.claimid
	                   	INNER JOIN vtiger_users ON vtiger_claim.employee_id=vtiger_users.id AND vtiger_claim.employee_id is NOT NUlL
						WHERE vtiger_crmentity.deleted=0 ".$memcondition." AND DATE_FORMAT(transactiondate, '%Y') = ? AND claim_status='Apply'
						ORDER BY fullname ASC ";

			$resultgetclaims = $db->pquery($querygetteamclaim,array($year));
			$myteamclaims=array();	

			for($i=0;$db->num_rows($resultgetclaims)>$i;$i++){
				$claim_id 						= $db->query_result($resultgetclaims, $i, 'claimid'); 
				$claimTypeid 					= $db->query_result($resultgetclaims, $i, 'category'); 
				$employee_id 					= $db->query_result($resultgetclaims, $i, 'employee_id'); 
				$transactiondate 				= $db->query_result($resultgetclaims, $i, 'transactiondate'); 
				$totalamount					= $db->query_result($resultgetclaims, $i, 'totalamount'); 
				$claim_status 					= $db->query_result($resultgetclaims, $i, 'claim_status'); 
	            $rowdetail 						= self::getClaimType($claimTypeid);
				$myteamclaims[$i]['fullname'] 	= $db->query_result($resultgetclaims, $i, 'fullname');
				$myteamclaims[$i]['category'] 	= $rowdetail['claim_type'];
				$myteamclaims[$i]['transactiondate'] = $transactiondate;
				$myteamclaims[$i]['totalamount'] = $totalamount; 
				 //index.php?module=Users&view=PreferenceDetail&parent=Settings&record=177
				$myteamclaims[$i]['icon'] = "<a href='index.php?module=Users&view=PreferenceDetail&record=$current_user->id&parent=Settings&appid=$employee_id&claimid=$claim_id&tab=claim'><i class='fa fa-check' title='Action'></i></a>";
			}			
		}	
		
		return $myteamclaims;
	}


	//Created by Jitu for fetching current user claims for current year//	
	public function getMyClaim($userid,$year){ 

		$db = PearDatabase::getInstance();
		//$db->setDebug(true);

		$query = "SELECT claimid, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status, taxinvoice, attachment,approved_by
				FROM vtiger_claim 
				INNER JOIN vtiger_crmentity
				ON vtiger_crmentity.crmid = vtiger_claim.claimid
				WHERE vtiger_claim.employee_id = ?
				AND vtiger_crmentity.deleted=0 AND DATE_FORMAT(transactiondate, '%Y') = ? AND vtiger_crmentity.deleted=0 ";

		$result = $db->pquery($query,array($userid, $year));
		$myleave=array();

		for($i=0;$db->num_rows($result)>$i;$i++){ 

			$claimid          = $db->query_result($result, $i, 'claimid');
	        $attachment       = self::getAttachment($claimid);

			$rowdetail = self::getClaimType($db->query_result($result, $i, 'category'));
			$claimtype[$i]['claimid'] = $db->query_result($result, $i, 'claimid');
			$claimtype[$i]['claimno'] = $db->query_result($result, $i, 'claimno');
			$claimtype[$i]['claimtypeid'] = $rowdetail['claimtypeid'];
			$claimtype[$i]['category'] = $rowdetail['claim_type'];
			//$myleave[$i]['category'] = $db->query_result($result, $i, 'category');
			$claimtype[$i]['color_code'] = $rowdetail['color_code'];
			$claimtype[$i]['transaction_limit'] = $rowdetail['transaction_limit'];
			$claimtype[$i]['monthly_limit'] = $rowdetail['monthly_limit'];
			$claimtype[$i]['yearly_limit'] = $rowdetail['yearly_limit'];
			//$myleave[$i]['starthalf'] = $rowdetail['starthalf'];
			//$myleave[$i]['endhalf'] = $rowdetail['endhalf'];
			$transactiondate = $db->query_result($result, $i, 'transactiondate');
			$claimtype[$i]['transactiondate'] = Vtiger_Date_UIType::getDisplayDateValue($transactiondate);
			$claimtype[$i]['description'] = $db->query_result($result, $i, 'description'); 
			$claimtype[$i]['totalamount'] = $db->query_result($result, $i, 'totalamount'); 
			$claimtype[$i]['claim_status'] = $db->query_result($result, $i, 'claim_status');
			$claimtype[$i]['taxinvoice'] = $db->query_result($result, $i, 'taxinvoice'); 
			$claimtype[$i]['attachment'] = $attachment;
			$claimtype[$i]['approved_by'] = $db->query_result($result, $i, 'approved_by');
			
			$rowUsedAmount = self::getClaimTypeUsedAmount($userid, $rowdetail['claimtypeid'],$transactiondate);
			$balance = 0;
				if ($claimtype[$i]['monthly_limit'] > 0) {
					$balance = $claimtype[$i]['monthly_limit']- $rowUsedAmount['mused'];
					if($balance > $claimtype[$i]['transaction_limit']){
						$balance = $claimtype[$i]['transaction_limit'];
					}
					
				} elseif($claimtype[$i]['yearly_limit'] > 0){
					$balance = $claimtype[$i]['yearly_limit']- $rowUsedAmount['yused'];
					if($balance > $claimtype[$i]['transaction_limit']){
						$balance = $claimtype[$i]['transaction_limit'];
					}
				}
				$claimtype[$i]['balance'] = $balance;

		}
		
		return $claimtype;

	}

	
	  public static function getAttachment($record){
             $db = PearDatabase::getInstance();
             //$db->setDebug(true);
             $result = $db->pquery("SELECT vtiger_attachments.attachmentsid, vtiger_attachments.path, vtiger_attachments.name FROM vtiger_attachments LEFT JOIN vtiger_seattachmentsrel 
                ON vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid
                WHERE vtiger_seattachmentsrel.crmid=?", array($record));

             if($db->num_rows($result)>0){
                return $db->query_result($result, 0, 'attachmentsid');
             } else {
                return '';
             }

        }

	public function getJobGrade($recordId){ 

	$db = PearDatabase::getInstance();
	
	$query = "SELECT vtiger_employeecontract.job_grade FROM vtiger_employeecontract 
			INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_employeecontract.employeecontractid 
			WHERE vtiger_crmentity.deleted=0 AND vtiger_employeecontract.employee_id=? ORDER BY vtiger_crmentity.createdtime DESC Limit 0, 1";

	$result = $db->pquery($query, array($recordId));


	$myjobgrade = $db->query_result($result, 0, 'job_grade');
	
	
	return $myjobgrade;

	}

	public function getClaimTypeUsedAmount($userid, $claimtypeid, $applydate){  
		
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);

		$mstart = date('Y-m', strtotime($applydate)).'-01';//date('Y-m-').'01-';
		$mend   = date('Y-m', strtotime($applydate)).'-31';//date('Y-m-d');
		$ystart = date('Y', strtotime($applydate)).'01-01';//date('Y-m-d');'01-01';

		$mresult = $db->pquery("SELECT SUM(secondcrm_claim_balance.amount) AS mused FROM secondcrm_claim_balance 
								WHERE secondcrm_claim_balance.user_id=? AND secondcrm_claim_balance.claim_id = ? AND claimdate between ? AND ? ", array($userid, $claimtypeid, $mstart, $mend));
		$yresult = $db->pquery("SELECT SUM(secondcrm_claim_balance.amount) AS yused FROM secondcrm_claim_balance 
								WHERE secondcrm_claim_balance.user_id=? AND secondcrm_claim_balance.claim_id = ? AND claimdate between ? AND ? ", array($userid, $claimtypeid, $ystart, $mend));
		$usedClaim=array();	
		

			$usedClaim['mused'] = $db->query_result($mresult, 0, 'mused');
			$usedClaim['yused'] = $db->query_result($yresult, 0, 'yused');
		
		return $usedClaim;	

	}

	//added by jitu for concat color and balance in dropdown 
	public function getClaimTypeList($userid){  

		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$result = $db->pquery("SELECT job_grade FROM vtiger_employeecontract tblVTEC 
							INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid=tblVTEC.employeecontractid
							INNER JOIN vtiger_employeecontractcf tblVTECF ON tblVTECF.employeecontractid = tblVTEC.employeecontractid
							WHERE tblVTC.deleted=0 AND tblVTEC.employee_id=? ORDER BY tblVTC.createdtime DESC LIMIT 0, 1", array($userid));
							
		$userModel = Vtiger_Record_Model::getInstanceById($userid, 'Users');					
		$dateofJoining = $userModel->get('date_joined');
		
		$grade_id	   = $db->query_result($result, 0, 'job_grade');	
		$datediff = time() - strtotime($dateofJoining);				 
		$earneddays = round($datediff / (60 * 60 * 24));
		$year	   = date('Y');	

		$query = "SELECT vtiger_claimtype.claimtypeid, vtiger_claimtype.claim_type,vtiger_claimtype.color_code,allocation_claimrel.transaction_limit,
		allocation_claimrel.monthly_limit,allocation_claimrel.yearly_limit from vtiger_claimtype INNER JOIN vtiger_crmentity ON vtiger_claimtype.claimtypeid=vtiger_crmentity.crmid 
		LEFT JOIN allocation_claimrel ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid
		LEFT JOIN allocation_list ON allocation_list.allocation_id = allocation_claimrel.allocation_id
		LEFT JOIN allocation_graderel ON allocation_graderel.allocation_id = allocation_list.allocation_id
		WHERE vtiger_crmentity.deleted=0 AND allocation_list.status ='on' AND allocation_graderel.grade_id=?
		 AND allocation_list.allocation_year=?";

		$result = $db->pquery($query,array($grade_id, $year));

		$claimtype=array();	
		$claimtypeid  = '';
		if($db->num_rows($result)>0) {	
			for($i=0;$i<$db->num_rows($result);$i++) {
				$claimtypeid = $db->query_result($result, $i, 'claimtypeid');
				$claimtype[$i]['claimtypeid'] = $claimtypeid ;
				$claimtype[$i]['claimtype'] = $db->query_result($result, $i, 'claim_type');	
				$claimtype[$i]['color_code'] = $db->query_result($result, $i, 'color_code');
				
				$monthlimit = $db->query_result($result, $i, 'monthly_limit');
				$claimtype[$i]['monthly_limit'] = $monthlimit;	

				if($translimit=='0.00'){
					$claimtype[$i]['monthly_limit'] = 'No Limit';	
				}
				
				$translimit = $db->query_result($result, $i, 'transaction_limit');
				$claimtype[$i]['transaction_limit'] = $translimit;	

				if($translimit=='0.00'){
					$claimtype[$i]['transaction_limit'] = 'No Limit';	
				}
				
				$yearlylimit = $db->query_result($result, $i, 'yearly_limit');
				$claimtype[$i]['yearly_limit'] = $yearlylimit;	
				
				if($yearlylimit=='0.00'){
					$claimtype[$i]['yearly_limit'] = 'No Limit';	
				}

				$rowdetail = self::getClaimTypeUsedAmount($userid,$claimtypeid,date('Y-m-d'));

				$balance = 0;
				if ($monthlimit > 0) {
					$balance = $monthlimit - $rowdetail['mused'];
					if($balance > $translimit ){
						$balance = $translimit;
					}
					
				} elseif($yearlylimit > 0){
					$balance = $yearlylimit- $rowdetail['yused'];
					if($balance > $translimit){
						$balance = $translimit;
					}
				}
				$claimtype[$i]['balance'] = $balance;			
			} 

		}
		return $claimtype;	

	}


	public function getClaimStatusList(){  
		
		$db = PearDatabase::getInstance();
		global $current_user;	

		 $query = "SELECT * from vtiger_claim_status";

		$result = $db->pquery($query,array());

		$claimtype=array();	
		$claim_statusid  = '';
		if($db->num_rows($result)>0) {	
			for($i=0;$i<$db->num_rows($result);$i++) {
				
				if($claim_statusid != $db->query_result($result, $i, 'claim_statusid')) {
					$claimstatus[$i]['claim_statusid'] = $db->query_result($result, $i, 'claim_statusid');
					$claimstatus[$i]['claim_status'] = $db->query_result($result, $i, 'claim_status');
					$claimstatusid = $db->query_result($result, $i, 'claim_status');
				} 
			}
		}
		return $claimstatus;	

	}


	//Created by Safuan for fetching leave types//	
	//modified by jitu for concate color and balance in dropdown 
	public function getTotaClaimTypeList($userid,$claimid){
	$db = PearDatabase::getInstance();
	global $current_user;	
	$query = "SELECT tblVTLT.claimtypeid, tblVTLT.claim_type, tblVTLT.color_code FROM vtiger_claimtype tblVTLT INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid = tblVTLT.claimtypeid WHERE tblVTC.deleted=0";
	$result = $db->pquery($query,array());
	$claimtype=array();	
	for($i=0;$db->num_rows($result)>$i;$i++){
		$claimtype[$i]['claimtypeid'] = $db->query_result($result, $i, 'claimtypeid');
		$claimtype[$i]['claim_type'] = $db->query_result($result, $i, 'claim_type');
	}
	return $claimtype;	

	}	

	//Created by Safuan for fetching team leaves//
	public function getMyTeamClaim($userid, $year, $page, $max,$selectedmember,$selectedleavetype){

		$db = PearDatabase::getInstance();

		global $current_user;
		$teamreporttoquery = "SELECT id FROM vtiger_users WHERE reports_to_id=$userid";
		$resulteamreport = $db->pquery($teamreporttoquery,array());
		
		$teamidreport= array();
		for($i=0;$db->num_rows($resulteamreport)>$i;$i++){ 
			$teamidreport[] = $db->query_result($resulteamreport, $i, 'id');
		}
		$allteammate= implode(",", $teamidreport);

		//For Pagination tools
		if ($page>1){	
			$row = (($page-1) * $max);
		} else{
			$row=0;
		}

		
		$claimtypecondtion	= '';	

		if(!empty($selectedmember)) {
			$memcondition 	= " AND vtiger_claim.employee_id = $selectedmember";
		} else if(count($teamidreport)>0){
			$memcondition	= "AND vtiger_claim.employee_id IN (".$allteammate.")";	
		}	
		
		
		$querygetteamleave="SELECT claimid, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.id, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status,taxinvoice, attachment,approved_by,resonforreject
					FROM vtiger_claim 
					INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = vtiger_claim.claimid
                   	INNER JOIN vtiger_users
                    ON vtiger_claim.employee_id=vtiger_users.id
					WHERE vtiger_crmentity.deleted=0 ".$memcondition." AND DATE_FORMAT(transactiondate, '%Y') = $year 
					AND (vtiger_claim.claim_status = 'Apply' 
						OR vtiger_claim.claim_status = 'Approved'
						OR vtiger_claim.claim_status = 'Cancel'
						OR vtiger_claim.claim_status = 'Not Approved')" .$claimtypecondtion;
		

		
		//For pagination
		if(!empty($max) || $max != ''){
			$querygetteamleave.=" LIMIT $row,$max"; 
		}


		$resultgetteamleave = $db->pquery($querygetteamleave,array());
		$myteamleave=array();	

		for($i=0;$db->num_rows($resultgetteamleave)>$i;$i++){
			$claimid                        = $db->query_result($resultgetteamleave, $i, 'claimid');
            $attachment                     = self::getAttachment($claimid);

			$rowdetail = self::getClaimType($db->query_result($resultgetteamleave, $i, 'category'));
			$myteamleave[$i]['claimid'] = $claimid ;
			$myteamleave[$i]['claimno'] = $db->query_result($resultgetteamleave, $i, 'claimno');
			$myteamleave[$i]['fullname'] = $db->query_result($resultgetteamleave, $i, 'fullname');
			$myteamleave[$i]['claimtypeid'] = $rowdetail['claimtypeid'];
			$myteamleave[$i]['category'] = $rowdetail['claim_type'];
			//$myteamleave[$i]['category'] = $db->query_result($resultgetteamleave, $i, 'category');
			$myteamleave[$i]['color_code'] = $rowdetail['color_code'];
			$transactiondate = $db->query_result($resultgetteamleave, $i, 'transactiondate');
			$myteamleave[$i]['transactiondate'] = Vtiger_Date_UIType::getDisplayDateValue($transactiondate);
			$myteamleave[$i]['description'] = $db->query_result($resultgetteamleave, $i, 'description'); 
			$myteamleave[$i]['resonforreject'] = $db->query_result($resultgetteamleave, $i, 'resonforreject'); 
			$myteamleave[$i]['totalamount'] = $db->query_result($resultgetteamleave, $i, 'totalamount');
			
			$myteamleave[$i]['taxinvoice'] = $db->query_result($resultgetteamleave, $i, 'taxinvoice'); 
			$myteamleave[$i]['attachment'] = $attachment;
			$myteamleave[$i]['applicantid'] = $db->query_result($resultgetteamleave, $i, 'id');
			$applicantid = $myteamleave[$i]['applicantid'];  
			$myteamleave[$i]['approved_by'] = $db->query_result($resultgetteamleave, $i, 'approved_by');
			$myteamleave[$i]['transaction_limit'] = $rowdetail['transaction_limit'];
			$myteamleave[$i]['monthly_limit'] = $rowdetail['monthly_limit']; 
			$myteamleave[$i]['yearly_limit'] = $rowdetail['yearly_limit'];
			$myteamleave[$i]['claim_status'] = $db->query_result($resultgetteamleave, $i, 'claim_status');  

			$rowdetailUsed = self::getClaimTypeUsedAmount($userid,$rowdetail['claimtypeid'], $transactiondate);
			$balance = 0;
			if ($myteamleave[$i]['monthly_limit'] > 0) {
				$balance = $myteamleave[$i]['monthly_limit']- $rowdetailUsed['mused'];
				if($balance > $myteamleave[$i]['transaction_limit']){
					$balance = $myteamleave[$i]['transaction_limit'];
				}
				
			} elseif($myteamleave[$i]['yearly_limit'] > 0){
				$balance = $myteamleave[$i]['yearly_limit']- $rowdetailUsed['yused'];
				if($balance > $myteamleave[$i]['transaction_limit']){
					$balance = $myteamleave[$i]['transaction_limit'];
				}
			}
			$myteamleave[$i]['balance'] = $balance;

		}
	return $myteamleave;
	}

	
	public function getClaimDetail($claimid){
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
	$query = "SELECT vtiger_claim.*
			FROM vtiger_claim 
			INNER JOIN vtiger_crmentity
			ON vtiger_crmentity.crmid = vtiger_claim.claimid
			WHERE vtiger_claim.claimid = $claimid
			AND vtiger_crmentity.deleted=0";
	$result = $db->pquery($query,array());
	$claimdetails=array();	

		$claimdetails['claimid'] = $db->query_result($result, 0, 'claimid');
		$claimdetails['claimno'] = $db->query_result($result, 0, 'claimno');
		$claimdetails['description'] = $db->query_result($result, 0, 'description');
		$claimdetails['transactiondate'] = Vtiger_Date_UIType::getDisplayDateValue($db->query_result($result, $i, 'transactiondate'));
		$claimdetails['totalamount'] = $db->query_result($result, 0, 'totalamount'); 
		$claimdetails['claim_status'] = $db->query_result($result, 0, 'claim_status');
		$claimdetails['taxinvoice'] = $db->query_result($result, 0, 'taxinvoice');
		$claimdetails['attachment'] = $db->query_result($result, 0, 'attachment');
		$claimdetails['category'] = $db->query_result($result, 0, 'category');
		$claimdetails['approved_by'] = $db->query_result($result, 0, 'approved_by');
		$claimdetails['resonforreject'] = $db->query_result($result, 0, 'resonforreject');  
		
	return $claimdetails;

	}

	
	public function getAllUsersList($userid){
		$db = PearDatabase::getInstance();
		$query = "SELECT id, CONCAT(first_name, ' ', last_name) AS fullname 
				FROM vtiger_users WHERE id !=?";
		
		$result = $db->pquery($query,array($userid));
		$users=array();	
		for($i=0;$db->num_rows($result)>$i;$i++){
			$users[$i]['id'] = $db->query_result($result, $i, 'id');
			$users[$i]['fullname'] = $db->query_result($result, $i, 'fullname');
 
		}
	return $users;
	}
	
	//Created by Jitu@secondcrm for get my team member list on 17 mar 2015
	public function getMyTeamMembers($userid){
		$db = PearDatabase::getInstance();
		$query = "SELECT id, CONCAT(first_name, ' ', last_name) AS fullname 
				FROM vtiger_users WHERE reports_to_id =?";
		
		$result = $db->pquery($query,array($userid));
		$users=array();	
		for($i=0;$db->num_rows($result)>$i;$i++){
			$users[$i]['id'] = $db->query_result($result, $i, 'id');
			$users[$i]['fullname'] = $db->query_result($result, $i, 'fullname');
 
		}
	return $users;
	}

	//Added by Jitu@secondcrm on 06-03-2015
	//without holiday and weekends	
	public function getWorkingDays($from,$to){
	
	    $db = PearDatabase::getInstance();	
	    $endDate   = strtotime($to);
	    $startDate = strtotime($from);
	    $holidays = array();
	    $rsholidays = $db->pquery("SELECT tblVTH.holiday_date, tblVTH.holiday_endate 
			FROM vtiger_holiday tblVTH INNER JOIN vtiger_crmentity tblVTC 
				ON tblVTC.crmid = tblVTH.holidayid WHERE  ((? between tblVTH.holiday_date AND  tblVTH.holiday_endate ) OR  (? between tblVTH.holiday_date AND tblVTH.holiday_endate)) AND tblVTC.deleted=0",array($from, $to));
				
		for($i=0;$i<$db->num_rows($rsholidays);$i++) {
			$holiday_date = $db->query_result($rsholidays, $i, 'holiday_date');
			$holiday_endate	= $db->query_result($rsholidays, $i, 'holiday_endate');
			if(strtotime($holiday_date) == strtotime($holiday_endate)){
				$holidays[] = $holiday_date;	
			} else {
				//insert dates in array through forloop
				$day = 86400; 
				$start	= strtotime($holiday_date);
				$end	= strtotime($holiday_endate);
				$numdays= ceil(($end - $start) / 86400) + 1;
				for($j=0;$j<$numdays;$j++) {
					$holidays[] = date('Y-m-d', ($start + ($j * $day))); 	
				}
			}
			
		}	
	  	
	    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
	    //We add one to inlude both dates in the interval.
	     $days = ($endDate - $startDate) / 86400 + 1;

	    $no_full_weeks = floor($days / 7);
	    $no_remaining_days = fmod($days, 7);

	    //It will return 1 if it's Monday,.. ,7 for Sunday
	    $the_first_day_of_week = date("N", $startDate);
	    $the_last_day_of_week = date("N", $endDate);

	    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
	    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
	    if ($the_first_day_of_week <= $the_last_day_of_week) {
		if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
		if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
	    }
	    else {
		// (edit by Tokes to fix an edge case where the start day was a Sunday
		// and the end day was NOT a Saturday)

		// the day of the week for start is later than the day of the week for end
		if ($the_first_day_of_week == 7) {
		    // if the start date is a Sunday, then we definitely subtract 1 day
		    $no_remaining_days--;

		    if ($the_last_day_of_week == 6) {
		        // if the end date is a Saturday, then we subtract another day
		        $no_remaining_days--;
		    }
		}
		else {
		    // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
		    // so we skip an entire weekend and subtract 2 days
		    $no_remaining_days -= 2;
		}
	    }

	    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
	//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
	   $workingDays = $no_full_weeks * 5;
	    if ($no_remaining_days > 0 )
	    {
	      $workingDays += $no_remaining_days;
	    }

	    //We subtract the holidays
	    foreach($holidays as $holiday){
		$time_stamp=strtotime($holiday);
		//If the holiday doesn't fall in weekend
		if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
		    $workingDays--;
	    }

	    return $workingDays;
	}
	



	/* MANAGER CHECKER -By Safuan- 
	*  Check if a user is a manager by the result of selecting the vtiger_users reports_tp_id */
	public function checkIfManager($userid){
		$db = PearDatabase::getInstance();
		$query="SELECT COUNT(*) AS total FROM vtiger_users WHERE reports_to_id=?";

		$result = $db->pquery($query,array($userid));
		$count = $db->query_result($result, 0, 'total');
		if($count>0){
			return 'true';
		}else{
			return 'false';		
		}

	}

	/*Check leave balance */
	public function getUserBalance($userid, $leavetype) {
		$db = PearDatabase::getInstance();
		$year = date('Y');
		//if year end process run then user can apply leave for next year other wise current year
		$sql  = "SELECT MAX(year) as year from secondcrm_user_balance LIMIT 0,1";
		$res = $db->pquery($sql,array());
		$year = $db->query_result($res, 0, 'year');
		if($year > date("Y")) {
			$year = $year;	
		 } //end here 

		$query="SELECT leave_count AS total FROM secondcrm_user_balance WHERE leave_type=? AND year=? AND user_id=?";

		$result = $db->pquery($query,array($leavetype,$year,$userid));
		$count = $db->query_result($result, 0, 'total');
	 return $count;	
	}
	
	/*USED IN MEMBERS LEAVES WIDGET - By Safuan
	**FUNCTION Get users leaves by sorting */
	public function widgetgetusersleaves($group, $filter) {
		$db = PearDatabase::getInstance();

		$querygetleave="SELECT leaveid, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.id, reasonofleave, leavetype, fromdate, todate, leavestatus, reasonnotapprove
					FROM vtiger_leave 
					INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = vtiger_leave.leaveid
                   			INNER JOIN vtiger_users
                    			ON vtiger_crmentity.smownerid=vtiger_users.id
					AND vtiger_crmentity.deleted=0 
					AND (vtiger_leave.leavestatus = 'Apply' 
						OR vtiger_leave.leavestatus = 'Approved'
						OR vtiger_leave.leavestatus = 'Not Approved'
						OR vtiger_leave.leavestatus = 'Cancel') ";
			
		if($group=='' || $group=='all'){
			if($filter=='today' || $filter==''){
				$querygetleave.= " WHERE fromdate = CURDATE() ";
			}elseif($filter=='nextsevendays'){
				$querygetleave.= " WHERE fromdate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ";
			}elseif($filter=='nextthirtydays'){
				$querygetleave.= " WHERE fromdate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) ";
			}
		}else{
		global $current_user;
		
		$teamreporttoquery = "SELECT id FROM vtiger_users WHERE reports_to_id=$current_user->id";
		$resulteamreport = $db->pquery($teamreporttoquery,array());
		
		$teamidreport= array();
		for($i=0;$db->num_rows($resulteamreport)>$i;$i++){
			$teamidreport[] = $db->query_result($resulteamreport, $i, 'id');
		}
			
			//if(count($teamidreport)>0) { 
				$allteammate= implode(",", $teamidreport);

				$querygetleave .=" AND vtiger_crmentity.smownerid IN($allteammate) ";
		
				if($filter=='today' || $filter==''){
					$querygetleave.= " AND fromdate = CURDATE() ";
				}elseif($filter=='nextsevendays'){
					$querygetleave.= " AND fromdate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) ";
				}elseif($filter=='nextthirtydays'){
					$querygetleave.= " AND fromdate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) ";
				}
		 	//}	
		}
		$querygetleave .= " ORDER BY RAND() LIMIT 5 ";
		// echo $querygetleave;
		$resultgetusersleave = $db->pquery($querygetleave,array());
		$usersleave=array();	

		for($i=0;$db->num_rows($resultgetusersleave)>$i;$i++){
			$rowdetail = self::getLeaveType($db->query_result($resultgetusersleave, $i, 'leavetype'));;	
			$usersleave[$i]['id'] = $db->query_result($resultgetusersleave, $i, 'leaveid');
			$usersleave[$i]['fullname'] = $db->query_result($resultgetusersleave, $i, 'fullname');
			$usersleave[$i]['leave_reason'] = $db->query_result($resultgetusersleave, $i, 'reasonofleave');
			$usersleave[$i]['leave_type'] = $rowdetail['leavetype'];
			$usersleave[$i]['color_code'] = $rowdetail['colorcode'];
			
			$fromdate= date('d-M', strtotime($db->query_result($resultgetusersleave, $i, 'fromdate')));
			$todate= date('d-M', strtotime($db->query_result($resultgetusersleave, $i, 'todate')));

			if(strtotime($fromdate) == strtotime($todate)){
				$usersleave[$i]['duration'] = $fromdate;
			}else{
				$duration= $fromdate . ' to ' . $todate;
				$usersleave[$i]['duration'] = $duration;
			}

			$usersleave[$i]['leavestatus'] = $db->query_result($resultgetusersleave, $i, 'leavestatus');
			$usersleave[$i]['applicantid'] = $db->query_result($resultgetusersleave, $i, 'id'); 
			$usersleave[$i]['reasonnotapprove'] = $db->query_result($resultgetusersleave, $i, 'reasonnotapprove'); 
		}
	return $usersleave;
	}
	/*USED IN LEAVES APPROVAL WIDGET - By Safuan
	**FUNCTION Get team leaves and link*/
	public function widgetgetmyteamleaves($filter) {
		$db = PearDatabase::getInstance();
		global $current_user;
		$teamreporttoquery = "SELECT id FROM vtiger_users WHERE reports_to_id=$current_user->id";
		$resulteamreport = $db->pquery($teamreporttoquery,array());
		
		$teamidreport= array();
		for($i=0;$db->num_rows($resulteamreport)>$i;$i++){
			$teamidreport[] = $db->query_result($resulteamreport, $i, 'id');
		}
		$allteammate= implode(",", $teamidreport);


		$querygetteamleave="SELECT leaveid, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.id, reasonofleave, leavetype, fromdate, todate, leavestatus, reasonnotapprove
					FROM vtiger_leave 
					INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = vtiger_leave.leaveid
                   			INNER JOIN vtiger_users
                    			ON vtiger_crmentity.smownerid=vtiger_users.id
					WHERE vtiger_crmentity.smownerid IN($allteammate)
					AND vtiger_crmentity.deleted=0 
					AND (vtiger_leave.leavestatus = 'Apply')
					ORDER BY fromdate DESC LIMIT 5";

		$resultgetteamleave = $db->pquery($querygetteamleave,array());
		$myteamleave=array();	

		for($i=0;$db->num_rows($resultgetteamleave)>$i;$i++){
			$rowdetail = self::getLeaveType($db->query_result($resultgetteamleave, $i, 'leavetype'));;	
			$myteamleave[$i]['id'] = $db->query_result($resultgetteamleave, $i, 'leaveid');
			$leaveid = $db->query_result($resultgetteamleave, $i, 'leaveid');
			$applicantid = $db->query_result($resultgetteamleave, $i, 'id');
			$namelink = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave" onclick="gotoLeavePreference()";>'.$db->query_result($resultgetteamleave, $i, 'fullname').'</a>';

			$myteamleave[$i]['fullname'] = $namelink;
			

			$myteamleave[$i]['leave_reason'] = $db->query_result($resultgetteamleave, $i, 'reasonofleave');
			$myteamleave[$i]['leave_type'] = $rowdetail['leavetype'];
			$myteamleave[$i]['color_code'] = $rowdetail['colorcode'];
			
			$fromdate= date('d-M', strtotime($db->query_result($resultgetteamleave, $i, 'fromdate')));
			$todate= date('d-M', strtotime($db->query_result($resultgetteamleave, $i, 'todate')));
		
			if(strtotime($fromdate) == strtotime($todate)){
				$myteamleave[$i]['duration'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave" onclick="gotoLeavePreference()";>'.$fromdate.'</a>';
			}else{
				$duration= $fromdate . ' to ' . $todate;
				$myteamleave[$i]['duration'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave" onclick="gotoLeavePreference()";>'.$duration.'</a>';
			}
		
			$myteamleave[$i]['leavestatus'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave" onclick="gotoLeavePreference()";>'.$db->query_result($resultgetteamleave, $i, 'leavestatus').'</a>';
			$myteamleave[$i]['icon'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave" onclick="gotoLeavePreference()";><i class="icon-exclamation-sign alignBottom" title="'.vtranslate('LBL_LEAVE_APPROVED', 'Users').'"></i></a>';

			$myteamleave[$i]['applicantid'] = $db->query_result($resultgetteamleave, $i, 'id'); 
			$myteamleave[$i]['reasonnotapprove'] = $db->query_result($resultgetteamleave, $i, 'reasonnotapprove'); 
		}
	return $myteamleave;

	}
	//ADDED BY SAFUAN - ADDING BACK LEAVE BALANCE- DeleteSubModuleAjax.php In Function cancelLeave()
	public function CancelUserLeave($leaveid, $userupdateid, $leavetype){
		$db = PearDatabase::getInstance();
		$leavearr= self::getLeaveDetail($leaveid);
		
		$startdate=$leavearr['from_date'];
		$enddate=$leavearr['to_date'];
		$starthalf=$leavearr['starthalf']==1?0.5:0;
		$endhalf=$leavearr['endhalf']==1?0.5:0;
		$takenleave = Users_LeavesRecords_Model::getWorkingDays($startdate,$enddate)-($starthalf+$endhalf);
		//$takenleave = (($enddate - $startdate) / 86400)+1-($starthalf+$endhalf);

		$leavecancelsql="UPDATE secondcrm_user_balance SET leave_count = leave_count+$takenleave 
				WHERE user_id=$userupdateid AND leave_type= $leavetype";
		$result = $db->pquery($leavecancelsql,array());
		return $result;		
	}

	/*Added by jitu@secondcrm on 25 Feb 2015 
	 * Use to check it allocate leave or not
	*/
	public function hasAllocateLeave($user_id) {
		$db = PearDatabase::getInstance();		
		$hasleave = false;
		
		$checkleaveallocresult = $db->pquery("SELECT 1 FROM secondcrm_user_balance tblSCUB LEFT JOIN vtiger_leavetype tblVTLT ON tblVTLT.leavetypeid = tblSCUB.leave_type
	INNER JOIN allocation_list tblVTLA ON tblVTLA.leavetype_id=tblVTLT.leavetypeid  
	INNER JOIN vtiger_grade	 tblVTG ON tblVTG.gradeid = tblVTLA.grade_id WHERE user_id =?",array($user_id));	
		//$checkalreadyapplyresult = $db->pquery("SELECT tblVTL.leavestatus FROM vtiger_leave tblVTL INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid = tblVTL.leaveid WHERE tblVTC.deleted =0 AND tblVTL.fromdate > CURDATE() AND tblVTL.todate < CURDATE() AND (tblVTL.leavestatus != 'Cancel' OR tblVTL.leavestatus !='Approved' ) AND tblVTC.smcreatorid = ?",array($user_id));	
		if($db->num_rows($checkleaveallocresult) > 0) {
			$hasleave = true;
		}
		return $hasleave;
	}

	/*
  public function saveEducationDetail($request)
	{

	}
	*/


}

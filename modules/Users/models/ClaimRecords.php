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
	$query = "SELECT * FROM vtiger_claimtype WHERE claimtypeid = $claimtypeid";
	
	$result = $db->pquery($query,array());
	$rowdetail = array();
	$rowdetail['claimtypeid'] = $db->query_result($result, $i, 'claimtypeid');
	$rowdetail['claim_type'] = $db->query_result($result, $i, 'claim_type');
	$rowdetail['claim_no'] = $db->query_result($result, $i, 'claim_no');
	$rowdetail['claim_code'] = $db->query_result($result, $i, 'claim_code');
	$rowdetail['color_code'] = $db->query_result($result, $i, 'color_code');
	$rowdetail['claim_status'] = $db->query_result($result, $i, 'claim_status');
	$rowdetail['claim_description'] = $db->query_result($result, $i, 'claim_description');
	$rowdetail['transactionlimit'] = $db->query_result($result, $i, 'transactionlimit');
	$rowdetail['monthlylimit'] = $db->query_result($result, $i, 'monthlylimit');
		 $rowdetail['yearlylimit'] = $db->query_result($result, $i, 'yearlylimit');

	return $rowdetail;

	}

	//Created by Safuan for fetching current user leaves for current year//	
	public function getMyClaim($userid,$year){ 
	$db = PearDatabase::getInstance();
	
	$query = "SELECT claimid, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status, taxinvoice, attachment,approved_by
			FROM vtiger_claim 
			INNER JOIN vtiger_crmentity
			ON vtiger_crmentity.crmid = vtiger_claim.claimid
			WHERE vtiger_crmentity.smownerid = ?
			AND vtiger_crmentity.deleted=0 AND DATE_FORMAT(transactiondate, '%Y') = ? AND vtiger_crmentity.deleted=0 ";

	$result = $db->pquery($query,array($userid, $year));
	$myleave=array();

	for($i=0;$db->num_rows($result)>$i;$i++){ 
		$rowdetail = self::getClaimType($db->query_result($result, $i, 'category'));
		$myleave[$i]['claimid'] = $db->query_result($result, $i, 'claimid');
		$myleave[$i]['claimno'] = $db->query_result($result, $i, 'claimno');
		$myleave[$i]['category'] = $rowdetail['claim_type'];
		//$myleave[$i]['category'] = $db->query_result($result, $i, 'category');
		$myleave[$i]['color_code'] = $rowdetail['color_code'];
		//$myleave[$i]['starthalf'] = $rowdetail['starthalf'];
		//$myleave[$i]['endhalf'] = $rowdetail['endhalf'];
		$myleave[$i]['transactiondate'] = $db->query_result($result, $i, 'transactiondate');
		$myleave[$i]['description'] = $db->query_result($result, $i, 'description'); 
		$myleave[$i]['totalamount'] = $db->query_result($result, $i, 'totalamount'); 
		$myleave[$i]['claim_status'] = $db->query_result($result, $i, 'claim_status'); 
		$myleave[$i]['taxinvoice'] = $db->query_result($result, $i, 'taxinvoice'); 
		$myleave[$i]['attachment'] = $db->query_result($result, $i, 'attachment'); 
		$myleave[$i]['approved_by'] = $db->query_result($result, $i, 'approved_by'); 

	}
	
	return $myleave;

	}


	//Created by Safuan for fetching leave types//	
	//modified by jitu for concate color and balance in dropdown 
	public function getClaimTypeList($userid,$claimid){  
	$db = PearDatabase::getInstance();
	global $current_user;	
	//Modified by jitu for showing  all except those are onetime if user already applied..
	$condleave = '';
	$conduser = '';
	$year = date("Y");
	//if year end process run then user can apply leave for next year other wise current year
	$sql  = "SELECT MAX(year) as year from secondcrm_user_balance LIMIT 0,1";
	$res = $db->pquery($sql,array());
	$year = $db->query_result($res, 0, 'year');

	if($year > date("Y")) {
		$year = $year;	
	 } //end here 
	
	if(!empty($leaveid)) {
		$condleave = " AND tblSCUB.user_id= ".$userid." AND tblVTLT.leavetypeid NOT IN (SELECT tblVTL.leavetype FROM vtiger_leave tblVTL INNER JOIN vtiger_crmentity tblVTCC ON tblVTCC.crmid=tblVTL.leaveid AND tblVTCC.deleted=0 
LEFT JOIN vtiger_leavetype tblVTLTT ON tblVTLTT.leavetypeid = tblVTL.leavetype WHERE ((tblVTLTT.leave_frequency = 'Onetime' AND tblVTL.leavestatus !='Not Approved' && tblVTL.leavestatus !='Cancel' && tblVTL.leaveid != $leaveid)) AND tblVTCC.smownerid=$userid)";
	}
	if(!empty($userid) && empty($leaveid)) {
		$conduser = " AND tblSCUB.user_id= ".$userid." AND tblVTLT.leavetypeid NOT IN (SELECT tblVTL.leavetype FROM vtiger_leave tblVTL INNER JOIN vtiger_crmentity tblVTCC ON tblVTCC.crmid=tblVTL.leaveid AND tblVTCC.deleted=0 
		LEFT JOIN vtiger_leavetype tblVTLTT ON tblVTLTT.leavetypeid = tblVTL.leavetype WHERE ((tblVTLTT.leave_frequency = 'Onetime' AND tblVTL.leavestatus !='Not Approved' && tblVTL.leavestatus !='Cancel')) AND tblVTCC.smownerid=$userid)";
	}	
	
	/*$query = "SELECT DISTINCT tblVTLT.leavetypeid,tblSCUB.leave_type, tblVTLT.title, tblVTLT.colorcode,tblSCUB.leave_count, tblVTLT.halfdayallowed FROM secondcrm_user_balance tblSCUB 
	INNER JOIN allocation_list tblVTLA ON tblVTLA.leavetype_id=tblSCUB.leave_type
	INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid = tblVTLA.allocation_id
	INNER JOIN vtiger_leavetype tblVTLT ON tblVTLT.leavetypeid = tblVTLA.leavetype_id
	LEFT JOIN vtiger_leave tblVTL ON tblVTL.leavetype = tblSCUB.leave_type  
	 WHERE tblVTC.deleted=0 ".$conduser." AND year = '".$year."' ".$condleave. " ORDER BY tblVTLT.leavetypeid ASC"; */

	 $query = "SELECT * from vtiger_claimtype";

	$result = $db->pquery($query,array());

	$claimtype=array();	
	$claimtypeid  = '';
	if($db->num_rows($result)>0) {	
		for($i=0;$i<$db->num_rows($result);$i++) {
			
			if($claimtypeid != $db->query_result($result, $i, 'claimtypeid')) {
				$claimtype[$i]['claimtypeid'] = $db->query_result($result, $i, 'claimtypeid');
				$claimtype[$i]['claimtype'] = $db->query_result($result, $i, 'claim_type');
				$claimtypeid = $db->query_result($result, $i, 'claim_type');
			} 
		}
	}
	return $claimtype;	

	}


		public function getClaimStatusList($userid,$claimid){  
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
		}else{
			$row=0;
		}
		$memcondition		= "AND vtiger_crmentity.smownerid IN (".$allteammate.")";	
		$leavetypecondtion	= '';	
		if(!empty($selectedmember)) {
			$memcondition = " AND vtiger_crmentity.smownerid = $selectedmember";
		}
		if(!empty($selectedleavetype)) {
			$leavetypecondtion = " AND vtiger_claim.category = $selectedleavetype";
		}	
		$querygetteamleave="SELECT claimid, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.id, claimno, category, transactiondate, vtiger_claim.description, totalamount, claim_status,taxinvoice, attachment,approved_by
					FROM vtiger_claim 
					INNER JOIN vtiger_crmentity
					ON vtiger_crmentity.crmid = vtiger_claim.claimid
                   			INNER JOIN vtiger_users
                    			ON vtiger_crmentity.smownerid=vtiger_users.id
					WHERE vtiger_crmentity.deleted=0 ".$memcondition." AND DATE_FORMAT(transactiondate, '%Y') = $year 
					AND (vtiger_claim.claim_status = 'Apply' 
						OR vtiger_claim.claim_status = 'Approved'
						OR vtiger_claim.claim_status = 'Rejected')" .$leavetypecondtion;
		//For pagination
		if(!empty($max) || $max != ''){
		$querygetteamleave.=" LIMIT $row,$max"; 
		}


		$resultgetteamleave = $db->pquery($querygetteamleave,array());
		$myteamleave=array();	

		for($i=0;$db->num_rows($resultgetteamleave)>$i;$i++){
			$rowdetail = self::getClaimType($db->query_result($resultgetteamleave, $i, 'category'));
			$myteamleave[$i]['claimid'] = $db->query_result($resultgetteamleave, $i, 'claimid');
			$myteamleave[$i]['claimno'] = $db->query_result($resultgetteamleave, $i, 'claimno');
			$myteamleave[$i]['fullname'] = $db->query_result($resultgetteamleave, $i, 'fullname');
			$myteamleave[$i]['category'] = $rowdetail['claim_type'];
			//$myteamleave[$i]['category'] = $db->query_result($resultgetteamleave, $i, 'category');
			$myteamleave[$i]['color_code'] = $rowdetail['color_code'];
			$myteamleave[$i]['transactiondate'] = $db->query_result($resultgetteamleave, $i, 'transactiondate');
			$myteamleave[$i]['description'] = $db->query_result($resultgetteamleave, $i, 'description'); 
			$myteamleave[$i]['totalamount'] = $db->query_result($resultgetteamleave, $i, 'totalamount');
			$myteamleave[$i]['claim_status'] = $db->query_result($resultgetteamleave, $i, 'claim_status'); 
			$myteamleave[$i]['taxinvoice'] = $db->query_result($resultgetteamleave, $i, 'taxinvoice'); 
			$myteamleave[$i]['attachment'] = $db->query_result($resultgetteamleave, $i, 'attachment');
			$myteamleave[$i]['applicantid'] = $db->query_result($resultgetteamleave, $i, 'id');  
			$myteamleave[$i]['approved_by'] = $db->query_result($resultgetteamleave, $i, 'approved_by'); 

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
		$claimdetails['transactiondate'] = date("d-m-Y", strtotime($db->query_result($result, 0, 'transactiondate')));
		$claimdetails['totalamount'] = $db->query_result($result, 0, 'totalamount'); 
		$claimdetails['claim_status'] = $db->query_result($result, 0, 'claim_status');
		$claimdetails['taxinvoice'] = $db->query_result($result, 0, 'taxinvoice');
		$claimdetails['attachment'] = $db->query_result($result, 0, 'attachment');
		$claimdetails['category'] = $db->query_result($result, 0, 'category');
		$claimdetails['approved_by'] = $db->query_result($result, 0, 'approved_by');
		$claimdetails['reasonnotapprove'] = $db->query_result($result, 0, 'reasonnotapprove');  
		//echo "Nirbhay Nirbhay<pre>";print_r($claimdetails);die;
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

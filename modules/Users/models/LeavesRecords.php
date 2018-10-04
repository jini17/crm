<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_LeavesRecords_Model extends Vtiger_Record_Model {

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

    public function getCreateLeaveURL() {
                return '?module=Users&view=EditLeave';
    }

        //Created by Safuan
        public function getLeaveType($leaveid){
        $db = PearDatabase::getInstance();
        $query = "SELECT title,colorcode FROM vtiger_leavetype WHERE leavetypeid = $leaveid";

        $result = $db->pquery($query,array());
        $rowdetail = array();
        $rowdetail['leavetype'] = $db->query_result($result, $i, 'title');
        $rowdetail['colorcode'] = $db->query_result($result, $i, 'colorcode');

        return $rowdetail;

        }

        public function getAllLeaveTypeList(){
        $db = PearDatabase::getInstance();
        $query = "SELECT * FROM vtiger_leavetype";

        $result = $db->pquery($query);
        $rowdetail = array();
        for($i=0;$db->num_rows($result)>$i;$i++){

                $rowdetail[$i]['title'] = $db->query_result($result, $i, 'title');
                $rowdetail[$i]['colorcode'] = $db->query_result($result, $i, 'colorcode');
        }


        return $rowdetail;

        }

        //Created by Safuan for fetching current user leaves for current year//	
        public function getMyLeaves($userid, $year){

        $db = PearDatabase::getInstance();
       // $db ->setDebug(true);
        $result = $db->pquery("SELECT job_grade FROM vtiger_employeecontract tblVTEC 
                                INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid=tblVTEC.employeecontractid
                                INNER JOIN vtiger_employeecontractcf tblVTECF ON tblVTECF.employeecontractid = tblVTEC.employeecontractid
                                WHERE tblVTC.deleted=0 AND tblVTEC.employee_id=? ORDER BY tblVTC.createdtime DESC LIMIT 0, 1", array($userid));

                $userModel = Vtiger_Record_Model::getInstanceById($userid, 'Users');					
                $dateofJoining = $userModel->get('date_joined');

                $grade_id	   = $db->query_result($result, 0, 'job_grade');	
                $datediff = time() - strtotime($dateofJoining);				 
                $earneddays = round($datediff / (60 * 60 * 24));
                $curr_year	   = date('Y');	


                $query = "SELECT leaveid, vtiger_users.id, reasonofleave, vtiger_leave.leavetype, vtiger_leavetype.title,vtiger_leavetype.colorcode,reasonofleave,  fromdate, todate, leavestatus,employee_id
                        FROM vtiger_leave 
                        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leave.leaveid 
                        INNER JOIN vtiger_users ON vtiger_leave.employee_id=vtiger_users.id 
                        LEFT JOIN vtiger_leavetype ON vtiger_leavetype.leavetypeid= vtiger_leave.leavetype 
                        WHERE vtiger_crmentity.deleted=0 AND vtiger_leave.employee_id =?  AND DATE_FORMAT(fromdate, '%Y') = ?";		




        $result = $db->pquery($query,array($userid, $year));

        $myleave=array();	

        for($i=0;$db->num_rows($result)>$i;$i++){
                $leaveid                        = $db->query_result($result, $i, 'leaveid');
                $attachment                     = self::getAttachment($leaveid);
                $myleave[$i]['leave_type']      = $db->query_result($result, $i, 'title');
                $myleave[$i]['leavetypeid']     = $db->query_result($result, $i, 'leave_type');
                $myleave[$i]['colorcode']       = $db->query_result($result, $i, 'colorcode');
                $myleave[$i]['fromdate']        = $db->query_result($result, $i, 'fromdate');
                $myleave[$i]['todate']          = $db->query_result($result, $i, 'todate');
                $myleave[$i]['leavestatus']     = $db->query_result($result, $i, 'leavestatus');
                $myleave[$i]['id']              = $leaveid;
                $myleave[$i]['applicantid']     = $db->query_result($result, $i, 'employee_id'); 
                $myleave[$i]['leavestatus']     = $db->query_result($result, $i, 'leavestatus'); 
                $myleave[$i]['leave_reason']    = $db->query_result($result, $i, 'reasonofleave'); 
                $myleave[$i]['fileid']          = $attachment; 
        }

        return $myleave;

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

        public function getLeaveTypeDetail($user_id, $leavetype){
                $db = PearDatabase::getInstance();

                $query = "SELECT sum(secondcrm_user_balance.leave_count) as takenleave FROM secondcrm_user_balance WHERE user_id=? AND leave_type=? AND year=?";
                $result = $db->pquery($query, array($user_id, $leavetype, date('Y')));
                return $db->query_result($result, 0, 'takenleave');

        }

        //Created by Safuan for fetching current user leaves for current year//	
        public function getWidgetsMyLeaves($userid, $year, $filtertype=null){

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
                $curr_year	   = date('Y');	

                if($filtertype =='leavetype'){

                        $query = "SELECT vtiger_leavetype.leavetypeid, vtiger_leavetype.title, allocation_leaverel.ageleave, allocation_leaverel.numberofleavesmore, allocation_leaverel.numberofleavesless
                                                FROM allocation_leaverel
                                                LEFT JOIN allocation_list ON allocation_list.allocation_id=allocation_leaverel.allocation_id
                                                LEFT JOIN allocation_graderel ON allocation_graderel.allocation_id=allocation_list.allocation_id
                                                LEFT JOIN vtiger_leavetype ON vtiger_leavetype.leavetypeid = allocation_leaverel.leavetype_id
                                                WHERE allocation_graderel.grade_id=? AND allocation_list.allocation_year=?";	

                        $result = $db->pquery($query,array($grade_id, $year));
                        $myleave=array();	
                        $balance = 0;
                        for($i=0;$db->num_rows($result)>$i;$i++){
                                $conditionage = $db->query_result($result, $i, 'ageleave');	
                                $leavemore	  = $db->query_result($result, $i, 'numberofleavesmore');
                                $leaveless 	  = $db->query_result($result, $i, 'numberofleavesless');
                                $title	   	  = $db->query_result($result, $i, 'title');		
                                $leavetype	  = $db->query_result($result, $i, 'leavetype');
                                $takenleave   = self::getLeaveTypeDetail($userid, $leavetype);
                                if($takenleave=='' || $takenleave ==null)
                                        $takenleave = 0;

                                if($earneddays > $conditionage){
                                        $allocateleave = $leavemore;
                                } else {
                                        $allocateleave = $leaveless;
                                }
                                $balanceleave = $allocateleave-$takenleave;

                                if($balanceleave > 0) {
                                        $balance++;
                                }
                                $myleave['display'][$i]['allocateleaves'] 	= $allocateleave;
                                $myleave['display'][$i]['takenleave'] 		= $takenleave;
                                $myleave['display'][$i]['balanceleave'] 	= $balanceleave;	
                                $myleave['display'][$i]['leavetype'] 		= $title;

                        }				
                        $myleave['balance'] = $balance;				
                } else {
                        $result = $db->pquery("SELECT vtiger_leavetype.title, vtiger_leave.fromdate, vtiger_leave.leavestatus FROM vtiger_leave
                                                                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_leave.leaveid
                                                                LEFT JOIN vtiger_leavetype ON vtiger_leavetype.leavetypeid=vtiger_leave.leavetype
                                                                WHERE vtiger_crmentity.deleted=0 AND vtiger_leave.employee_id=? ORDER BY vtiger_leave.fromdate DESC, vtiger_leavetype.title ASC  LIMIT 0, 5", array($userid));

                        $myleave=array();	

                        for($i=0;$db->num_rows($result)>$i;$i++){						
                                $myleave[$i]['title'] 			= $db->query_result($result, $i, 'title');
                                $myleave[$i]['fromdate'] 		= date('jS M, Y',strtotime($db->query_result($result, $i, 'fromdate')));
                                $myleave[$i]['leavestatus'] 	= $db->query_result($result, $i, 'leavestatus');
                        }

                }
                return $myleave;
        }

        //Created by Safuan for fetching leave types//	
        //modified by jitu for concate color and balance in dropdown 
        public function getLeaveTypeList($userid){ 

                $db = PearDatabase::getInstance();

                $result = $db->pquery("SELECT job_grade FROM vtiger_employeecontract tblVTEC 
                                                        INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid=tblVTEC.employeecontractid
                                                        INNER JOIN vtiger_employeecontractcf tblVTECF ON tblVTECF.employeecontractid = tblVTEC.employeecontractid
                                                        WHERE tblVTC.deleted=0 AND tblVTEC.employee_id=? ORDER BY tblVTC.createdtime DESC LIMIT 0, 1", array($userid));

                $userModel = Vtiger_Record_Model::getInstanceById($userid, 'Users');					
                $dateofJoining = $userModel->get('date_joined');

                $grade_id	   = $db->query_result($result, 0, 'job_grade');	
                $datediff = time() - strtotime($dateofJoining);				 
                $earneddays = round($datediff / (60 * 60 * 24));
                $curr_year	   = date('Y');	

                //Get all leavetypes with balance for which leave to be apply
                $leavers = $db->pquery("SELECT distinct tblVTLT.title, tblVTLT.leavetypeid, allocleaverel.ageleave, allocleaverel.numberofleavesmore, 
                                        allocleaverel.numberofleavesless FROM vtiger_leavetype tblVTLT 
                                        INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid=tblVTLT.leavetypeid
                                        LEFT JOIN allocation_leaverel allocleaverel ON allocleaverel.leavetype_id = tblVTLT.leavetypeid 
                                        LEFT JOIN allocation_graderel ON allocation_graderel.allocation_id=allocleaverel.allocation_id
                                        LEFT JOIN allocation_list alloclist ON alloclist.allocation_id=allocleaverel.allocation_id AND alloclist.status='on'			
                                        WHERE tblVTC.deleted=0 AND alloclist.allocation_year=? AND allocation_graderel.grade_id=? 
                                        ", array($curr_year, $grade_id));			

                $norows = $db->num_rows($leavers);
                $data	= array();

                //check LeaveType balance with Earned days
                if($norows > 0){

                        for($i=0;$i<$norows;$i++){
                                $leavetype		= $db->query_result($leavers,$i, 'title');
                                $leavetypeid	= $db->query_result($leavers,$i, 'leavetypeid');
                                //get all taken leaves against to leavetype
                                $rstaken 		= $db->pquery("SELECT SUM(leave_count) as takenleave FROM secondcrm_user_balance WHERE user_id=? AND leave_type=? AND year=?",
                                         array($userid, $leavetypeid, $curr_year));
                                $takenleave 	= $db->query_result($rstaken,0, 'takenleave');
                                $leavetypeid 	= $db->query_result($leavers,$i, 'leavetypeid');
                                $ageleave	 	= $db->query_result($leavers,$i, 'ageleave');
                                $nummoreleave 	= $db->query_result($leavers,$i, 'numberofleavesmore');
                                $numlessleave 	= $db->query_result($leavers,$i, 'numberofleavesless');

                                if($earneddays > $ageleave){
                                        $balance_leave = $nummoreleave - $takenleave;
                                } else {
                                        $balance_leave = $numlessleave - $takenleave;
                                }
                                if($balance_leave>0) {
                                        $data[$i]['leavetypeid'] 	= $leavetypeid;			
                                        $data[$i]['leavetype'] 	 	= $leavetype;
                                        $data[$i]['leave_remain']	= $balance_leave;
                                        $data[$i]['leave_used']		= $takenleave;
                                } 	
                        }	
                }	
                return $data;
        }


        //Created by Safuan for fetching leave types//	
        //modified by jitu for concate color and balance in dropdown 
        public function getTotaLeaveTypeList($userid,$leaveid){
        $db = PearDatabase::getInstance();
        global $current_user;	

        $query = "SELECT tblVTLT.leavetypeid, tblVTLT.title, tblVTLT.colorcode 
        FROM vtiger_leavetype tblVTLT
        INNER JOIN vtiger_crmentity tblVTC ON tblVTC.crmid = tblVTLT.leavetypeid
         WHERE tblVTC.deleted=0 ";

        $result = $db->pquery($query,array());
        $leavetype=array();	
        for($i=0;$db->num_rows($result)>$i;$i++){
                $leavetype[$i]['leavetypeid'] = $db->query_result($result, $i, 'leavetypeid');
                $leavetype[$i]['leavetype'] = $db->query_result($result, $i, 'title');
        }
        return $leavetype;	

        }	

        //Created by Safuan for fetching team leaves//
        public function getMyTeamLeave($userid, $year, $page, $max,$selectedmember,$selectedleavetype){

                $db = PearDatabase::getInstance();
                //$db->setDebug(true);
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
                        $leavetypecondtion = " AND vtiger_leave.leavetype = $selectedleavetype";
                }	
                $querygetteamleave="SELECT leaveid, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.id, reasonofleave, leavetype, fromdate, todate, leavestatus, reasonnotapprove,starthalf, endhalf
                                        FROM vtiger_leave 
                                        INNER JOIN vtiger_crmentity	ON vtiger_crmentity.crmid = vtiger_leave.leaveid
                                INNER JOIN vtiger_users ON vtiger_leave.employee_id=vtiger_users.id
                    LEFT JOIN vtiger_leavetype ON vtiger_leavetype.leavetypeid=	vtiger_leave.leavetype		
                                        WHERE vtiger_crmentity.deleted=0 ".$memcondition." AND DATE_FORMAT(fromdate, '%Y') = $year
                                        AND vtiger_leave.leavestatus IN ('Apply','Approved','Not Approved','Cancel')" .$leavetypecondtion;
                //For pagination
                if(!empty($max) || $max != ''){
                        $querygetteamleave.=" LIMIT $row,$max"; 
                }


                $resultgetteamleave = $db->pquery($querygetteamleave,array());
                $myteamleave=array();	

                for($i=0;$db->num_rows($resultgetteamleave)>$i;$i++){
                        $leaveid                        = $db->query_result($resultgetteamleave, $i, 'leaveid');
                        $attachment                     = self::getAttachment($leaveid);
                        $rowdetail = self::getLeaveType($db->query_result($resultgetteamleave, $i, 'leavetype'));;	
                        $myteamleave[$i]['id'] =  $leaveid;
                        $myteamleave[$i]['fullname'] = $db->query_result($resultgetteamleave, $i, 'fullname');
                        $myteamleave[$i]['leave_reason'] = $db->query_result($resultgetteamleave, $i, 'reasonofleave');
                        $myteamleave[$i]['leave_type'] = $rowdetail['leavetype'];
                        $myteamleave[$i]['leavetypeid'] = $db->query_result($resultgetteamleave, $i, 'leavetype');
                        $myteamleave[$i]['color_code'] = $rowdetail['colorcode'];
                        $myteamleave[$i]['starthalf'] = $rowdetail['starthalf'];
                        $myteamleave[$i]['endhalf'] = $rowdetail['endhalf'];
                        $myteamleave[$i]['from_date'] = $db->query_result($resultgetteamleave, $i, 'fromdate');
                        $myteamleave[$i]['to_date'] = $db->query_result($resultgetteamleave, $i, 'todate'); 
                        $myteamleave[$i]['leavestatus'] = $db->query_result($resultgetteamleave, $i, 'leavestatus');
                        $myteamleave[$i]['applicantid'] = $db->query_result($resultgetteamleave, $i, 'id'); 
                        $myteamleave[$i]['reasonnotapprove'] = $db->query_result($resultgetteamleave, $i, 'reasonnotapprove'); 
                        $myteamleave[$i]['fileid']          = $attachment; 
                }

        return $myteamleave;
        }

        //Created by Safuan
        public function getLeaveDetail($leaveid){
                $db = PearDatabase::getInstance();
        $query = "SELECT leaveid, reasonofleave, leavetype, fromdate, todate, replaceuser_id, leavestatus,starthalf, endhalf, reasonnotapprove
                        FROM vtiger_leave 
                        INNER JOIN vtiger_crmentity
                        ON vtiger_crmentity.crmid = vtiger_leave.leaveid
                        WHERE vtiger_leave.leaveid = $leaveid
                        AND vtiger_crmentity.deleted=0";
        $result = $db->pquery($query,array());
        $leavedetails=array();	

                $leavedetails['id'] = $db->query_result($result, 0, 'leaveid');
                $leavedetails['leave_reason'] = $db->query_result($result, 0, 'reasonofleave');
                $leavedetails['leave_type'] = $db->query_result($result, 0, 'leavetype');
                $leavedetails['from_date'] = date("d-m-Y", strtotime($db->query_result($result, 0, 'fromdate')));
                $leavedetails['to_date'] = date("d-m-Y", strtotime($db->query_result($result, 0, 'todate'))); 
                $leavedetails['replaceuser'] = $db->query_result($result, 0, 'replaceuser_id'); 
                $leavedetails['leavestatus'] = $db->query_result($result, 0, 'leavestatus');
                $leavedetails['starthalf'] = $db->query_result($result, 0, 'starthalf');
                $leavedetails['endhalf'] = $db->query_result($result, 0, 'endhalf');
                $leavedetails['reasonnotapprove'] = $db->query_result($result, 0, 'reasonnotapprove'); 

        return $leavedetails;
        }
        //Created by Safuan
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
            $rsholidays = $db->pquery("SELECT tblVTH.start_date, tblVTH.end_date 
                        FROM vtiger_holiday tblVTH INNER JOIN vtiger_crmentity tblVTC 
                                ON tblVTC.crmid = tblVTH.holidayid WHERE  ((? between tblVTH.start_date AND  tblVTH.end_date ) OR  (? between tblVTH.start_date AND tblVTH.end_date)) AND tblVTC.deleted=0",array($from, $to));

                for($i=0;$i<$db->num_rows($rsholidays);$i++) {
                        $holiday_date = $db->query_result($rsholidays, $i, 'start_date');
                        $holiday_endate	= $db->query_result($rsholidays, $i, 'end_date');
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
                                        ON vtiger_leave.employee_id=vtiger_users.id
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
        public function widgetgetmyteamleaves($filter=null) {

                $db = PearDatabase::getInstance();
                //$db->setDebug(true);
                global $current_user;

                if($filter == 'today'){
                        $query = " AND DATE_FORMAT(CURDATE(),'%m-%d') between DATE_FORMAT(fromdate,'%m-%d') and DATE_FORMAT(todate,'%m-%d')  ";

                } elseif($filter == 'tomorrow'){
                        $query = " AND DATE_FORMAT(fromdate,'%m-%d') = DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%m-%d') ";			


                } elseif($filter == 'thisweek'){
                        $query = " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(fromdate,'%m-%d'))) = WEEKOFYEAR(CURDATE())"; 


                } elseif($filter == 'nextweek'){
                        $query = " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(fromdate,'%m-%d'))) = WEEKOFYEAR(CURDATE())+1";


                } elseif($filter == 'thismonth'){
                        $query = " AND DATE_FORMAT(fromdate,'%m') = DATE_FORMAT(CURDATE(),'%m')";			
                } 


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
                                        WHERE vtiger_leave.employee_id IN ($allteammate)
                                        AND vtiger_crmentity.deleted=0 
                                        AND (vtiger_leave.leavestatus = 'Apply') ".$query. " ORDER BY fromdate DESC LIMIT 5";


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
                                $myteamleave[$i]['duration'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave&parent=Settings">'.$fromdate.'</a>';
                        }else{
                                $duration= $fromdate . ' to ' . $todate;
                                $myteamleave[$i]['duration'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave&parent=Settings">'.$duration.'</a>';
                        }

                        $myteamleave[$i]['leavestatus'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave&parent=Settings">'.$db->query_result($resultgetteamleave, $i, 'leavestatus').'</a>';
                        $myteamleave[$i]['icon'] = '<a href="index.php?module=Users&appid='.$applicantid.'&leaveid='.$leaveid.'&view=PreferenceDetail&record='.$current_user->id.'&tab=leave&parent=Settings"><i class="icon-exclamation-sign alignBottom" title="'.vtranslate('LBL_LEAVE_APPROVED', 'Users').'"></i></a>';

                        $myteamleave[$i]['applicantid'] = $db->query_result($resultgetteamleave, $i, 'id'); 
                        $myteamleave[$i]['reasonnotapprove'] = $db->query_result($resultgetteamleave, $i, 'reasonnotapprove'); 
                }

        return $myteamleave;

        }
        //ADDED BY SAFUAN - ADDING BACK LEAVE BALANCE- DeleteSubModuleAjax.php In Function cancelLeave()
        public function CancelUserLeave($leaveid, $userupdateid, $leavetype){
                $db = PearDatabase::getInstance();
                $leavearr= self::getLeaveDetail($leaveid);

                $startdate	 = $leavearr['from_date'];
                $enddate	 = $leavearr['to_date'];
                $leavestatus = $leavearr['leavestatus'];
                $starthalf	 = $leavearr['starthalf']==1?0.5:0;
                $endhalf	 = $leavearr['endhalf']==1?0.5:0;
                $takenleave	 = $leavearr['total_taken'];
                //$takenleave = Users_LeavesRecords_Model::getWorkingDays($startdate,$enddate)-($starthalf+$endhalf);
                //$takenleave = (($enddate - $startdate) / 86400)+1-($starthalf+$endhalf);
                if($leavestatus=='Approved'){
                        $leavecancelsql="UPDATE secondcrm_user_balance SET leave_count = leave_count-? WHERE user_id=? AND leave_type= ? AND year=?";
                        $result = $db->pquery($leavecancelsql,array($takenleave, $userupdateid, $leavetype, date('Y')));	
                } 	
                return $result;		
        }


        public function getHolidayList($monthname=null,$type = ""){
                $db = PearDatabase::getInstance();
                //$db->setDebug(true);
                $filtercond = '';
                if($monthname == 1|| $monthname == 2 || $monthname == 3 || $monthname == 4 || $monthname == 5 || $monthname == 6 
                        || $monthname == 7 || $monthname == 8 || $monthname == 9 || $monthname == 10 || $monthname == 11 || $monthname == 12){


                        $filtercond = " AND MONTH(vtiger_holiday.start_date)=".$monthname;

                }

                if($type == 'today'){
                        $filtercond = " AND DATE_FORMAT(CURDATE(),'%m-%d') BETWEEN DATE_FORMAT(vtiger_holiday.start_date,'%m-%d') AND DATE_FORMAT(vtiger_holiday.end_date,'%m-%d')";

                        }elseif($type == 'thisyear'){
                        $filtercond = " AND DATE_FORMAT(CURDATE() ,'%Y')  = DATE_FORMAT(vtiger_holiday.start_date,'%Y') OR DATE_FORMAT(CURDATE() ,'%Y')  = DATE_FORMAT(vtiger_holiday.end_date,'%Y')  ";			


                        }elseif($type == 'thisweek'){
                        $filtercond = " AND   (YEARWEEK(vtiger_holiday.start_date, 1) = YEARWEEK(CURDATE(), 1)  OR YEARWEEK(vtiger_holiday.end_date, 1) = YEARWEEK(CURDATE(), 1) )"; 
                        /*$query .= "WHERE DATE_ADD( birthday, INTERVAL YEAR( CURDATE() ) - YEAR( birthday ) YEAR )
                                        BETWEEN CURDATE()
                                        AND DATE_ADD( CURDATE() , INTERVAL 7
                                        DAY ))";			
                        */

                        }elseif($type == 'nextweek'){
                        $filtercond = "  AND  YEARWEEK(vtiger_holiday.start_date) = YEARWEEK(NOW() + INTERVAL 1 WEEK) OR YEARWEEK(vtiger_holiday.end_date) = YEARWEEK(NOW() + INTERVAL 1 WEEK)";
                /*	$query .= "WHERE DATE_ADD( birthday, INTERVAL YEAR( CURDATE() + INTERVAL 7 DAY ) - YEAR( birthday ) YEAR )
                                        BETWEEN CURDATE() + INTERVAL 7 DAY
                                        AND DATE_ADD( CURDATE() + INTERVAL 7
                                        DAY , INTERVAL 7 DAY ))";
                */	

                        }elseif($type == 'thismonth'){
                        $filtercond = " AND DATE_FORMAT(vtiger_holiday.start_date,'%m') = DATE_FORMAT(CURDATE(),'%m') OR  DATE_FORMAT(vtiger_holiday.end_date,'%m') = DATE_FORMAT(CURDATE(),'%m')";			


                        }
                     
                $query = "SELECT holiday_name, DAY(start_date) AS startday, MONTH(start_date) AS startmonth, DAY(end_date) AS endday, MONTH(end_date) AS endmonth, YEAR(end_date) AS endyear FROM vtiger_holiday INNER JOIN vtiger_crmentity 
                                        ON vtiger_crmentity.crmid = vtiger_holiday.holidayid 
                                        WHERE vtiger_crmentity.deleted=0 ".$filtercond;
   
                $result = $db->pquery($query,array());
 
                $rowdetail = array();
                for($i=0; $i < $db->num_rows($result);$i++){

                        $rowdetail[$i]['holiday_name'] = $db->query_result($result, $i, 'holiday_name');
                        $rowdetail[$i]['start_date_day'] = $db->query_result($result, $i, 'startday');
                        $rowdetail[$i]['start_date_month'] = $db->query_result($result, $i, 'startmonth');
                        $rowdetail[$i]['end_date_day'] = $db->query_result($result, $i, 'endday');
                        $rowdetail[$i]['end_date_month'] = $db->query_result($result, $i, 'endmonth');
                        $rowdetail[$i]['end_date_year'] = $db->query_result($result, $i, 'endyear');
                }

                return $rowdetail;
}


        public function getEmployeeImage($userId){

                        $db = PearDatabase::getInstance();

                        $query = "SELECT vtiger_attachments.attachmentsid, vtiger_attachments.path, vtiger_attachments.name FROM vtiger_attachments
                                  LEFT JOIN vtiger_salesmanattachmentsrel ON vtiger_salesmanattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
                                  WHERE vtiger_salesmanattachmentsrel.smid=?";

                        $result = $db->pquery($query, array($userId));

                        $imageId = $db->query_result($result, 0, 'attachmentsid');
                        $imagePath = $db->query_result($result, 0, 'path');
                        $imageName = $db->query_result($result, 0, 'name');

                        //decode_html - added to handle UTF-8 characters in file names
                        $imageOriginalName = urlencode(decode_html($imageName));

                        $imageDetails = $imagePath.$imageId.'_'.$imageOriginalName;
                        return $imageDetails;
        }

        public function widgetTopNOMCEmployee($department){
                $db = PearDatabase::getInstance();

                $deptCond = '';
                if($department !=''){
                        $deptCond = " AND department='$department'";
                }
                $query = "SELECT count(vtiger_leave.employee_id) as leavecount, vtiger_users.id,
                                        CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, 
                                        vtiger_users.department, vtiger_users.title 
                                        FROM vtiger_leave 
                                        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_leave.leaveid
                                        LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_leave.employee_id
                                        WHERE vtiger_crmentity.deleted = 0 AND vtiger_users.deleted = 0 AND vtiger_leave.leavetype=790 ".$deptCond ." 
                                        GROUP BY vtiger_leave.employee_id ORDER BY leavecount ASC LIMIT 4";
                
                $result = $db->pquery($query, array());
                $numrows = $db->num_rows($result);
                $employeelist = array();

                for($i=0;$i<$numrows;$i++){

                        //$employeelist[$i]['imagedetail'] = self::getEmployeeImage($db->query_result($result, $i, 'id'));
                        $employeelist[$i]['empname'] = $db->query_result($result, $i, 'fullname');
                        $employeelist[$i]['userid'] = $db->query_result($result, $i, 'id');
                        $employeelist[$i]['department'] = $db->query_result($result, $i, 'department');
                        $employeelist[$i]['title'] = $db->query_result($result, $i, 'title');
                        $employeelist[$i]['leavecount'] = $db->query_result($result, $i, 'leavecount');
                }
                return $employeelist;

        }

        public function getMonthName($month){
                switch ($month) {
                        case '1':
                                $month = "Jan";
                                break;
                        case '2':
                                $month = "Feb";
                                break;
                        case '3':
                                $month = "Mar";
                                break;
                        case '4':
                                $month = "Apr";
                                break;
                        case '5':
                                $month = "May";
                                break;
                        case '6':
                                $month = "June";
                                break;
                        case '7':
                                $month = "July";
                                break;
                        case '8':
                                $month = "Aug";
                                break;
                        case '9':
                                $month = "Sept";
                                break;
                        case '10':
                                $month = "Oct";
                                break;
                        case '11':
                                $month = "Nov";
                                break;
                        case '12':
                                $month = "Dec";
                                break;

                        default:
                                $month = "undefined";
                                break;
                }
                return $month;
        }

   public function getWidgetsColleaguesLeave($type, $department){
        $db = PearDatabase::getInstance();

        $deptCond = '';

        if($department !=''){
                $deptCond = " AND vtiger_users.department='$department'";
        }

        if($type == 'today'){
            $query = " AND DATE_FORMAT(CURDATE(),'%m-%d') between DATE_FORMAT(fromdate,'%m-%d') and DATE_FORMAT(todate,'%m-%d')  ";

        } elseif($type == 'tomorrow'){
            $query = " AND DATE_FORMAT(fromdate,'%m-%d') = DATE_FORMAT(CURDATE() + INTERVAL 1 DAY,'%m-%d') ";           


        } elseif($type == 'thisweek'){
            $query = " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(fromdate,'%m-%d'))) = WEEKOFYEAR(CURDATE())"; 


        } elseif($type == 'nextweek'){
                $query = " AND WEEKOFYEAR(CONCAT(YEAR(CURDATE()),'-', date_format(fromdate,'%m-%d'))) = WEEKOFYEAR(CURDATE())+1";


        } elseif($type == 'thismonth'){
                $query = " AND DATE_FORMAT(fromdate,'%m') = DATE_FORMAT(CURDATE(),'%m')";           
        } 

        $sql = "SELECT vtiger_users.id, CONCAT(vtiger_users.first_name, ' ', vtiger_users.last_name) AS fullname, vtiger_users.department, 
                                vtiger_leave.fromdate, vtiger_leave.todate                      
                FROM vtiger_leave 
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_leave.leaveid
                LEFT JOIN vtiger_users ON vtiger_users.id=vtiger_leave.employee_id
                WHERE vtiger_crmentity.deleted = 0 AND vtiger_users.deleted = 0 AND vtiger_leave.leavestatus='Approved' ".$deptCond . $query;
        
        $result = $db->pquery($sql, array());
        $numrows = $db->num_rows($result);
        $employeelist = array();

        for($i=0;$i<$numrows;$i++){
            $employeelist[$i]['userid'] = $db->query_result($result, $i, 'id');
            $employeelist[$i]['empname'] = $db->query_result($result, $i, 'fullname');
            $employeelist[$i]['department'] = $db->query_result($result, $i, 'department');
            $employeelist[$i]['fromdate'] = $db->query_result($result, $i, 'fromdate');
            $employeelist[$i]['todate'] = $db->query_result($result, $i, 'todate');
        }

        return $employeelist;

   }     
}

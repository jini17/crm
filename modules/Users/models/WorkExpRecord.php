<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_WorkExpRecord_Model extends Users_Record_Model {
    
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM secondcrm_userworkexp WHERE uw_id=?';
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
    	
	/**
	 * Static Function to get the instance of the User Record model for the current user
	 * @return Users_Record_Model instance
	 */
	public static $currentUserModels = array();
	public static function getCurrentUserModel() {
		//TODO : Remove the global dependency
		$currentUser = vglobal('current_user');
		if(!empty($currentUser)) {
			
			// Optimization to avoid object creation every-time
			// Caching is per-id as current_user can get swapped at runtime (ex. workflow)
			$currentUserModel = NULL;
			if (isset(self::$currentUserModels[$currentUser->id])) {
				$currentUserModel = self::$currentUserModels[$currentUser->id];
				if ($currentUser->column_fields['modifiedtime'] != $currentUserModel->get('modifiedtime')) {
					$currentUserModel = NULL;
		}
			}
			if (!$currentUserModel) {
				$currentUserModel = self::getInstanceFromUserObject($currentUser);
				self::$currentUserModels[$currentUser->id] = $currentUserModel;
			}
			return $currentUserModel;
		}
		return new self();
	}

	/**
	 * Static Function to get the instance of the User Record model from the given Users object
	 * @return Users_Record_Model instance
	 */
	public static function getInstanceFromUserObject($userObject) {
		$objectProperties = get_object_vars($userObject);
		$userModel = new self();
		foreach($objectProperties as $properName=>$propertyValue){
			$userModel->$properName = $propertyValue;
		}
		return $userModel->setData($userObject->column_fields)->setModule('Users')->setEntity($userObject);
	}

	public function getAllDesignationlist() {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_designation"; 
		$params = array();
		$result = $db->pquery($sql,$params);
			
		$designation = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$designation[$i]['designation_id'] = $db->query_result($result, $i, 'designation_id');
				$designation[$i]['designation'] = $db->query_result($result, $i, 'designation');
			}
		}
		return $designation;	
	}

	public function getAllLocationlist() {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_location"; 
		$params = array();
		$result = $db->pquery($sql,$params);
			
		$location = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$location[$i]['location_id'] = $db->query_result($result, $i, 'location_id');
				$location[$i]['location'] = $db->query_result($result, $i, 'location');
			}
		}
		return $location;	
	}
	
	public function getAllCompanylist() {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_company"; 
		$params = array();
		$result = $db->pquery($sql,$params);
			
		$company = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$company[$i]['company_id'] = $db->query_result($result, $i, 'company_id');
				$company[$i]['company_title'] = $db->query_result($result, $i, 'company_title');
				$company[$i]['company_location'] = $db->query_result($result, $i, 'company_location');;	
			}
		}
		return $company;	
	}

	public function getWorkExpDetail($uw_id) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCW.uw_id, tblSCW.company_id,tblSCC.company_title, 
				tblSCW.designation_id, tblSCD.designation,
				tblSCW.currentlyworking, 	
				tblSCW.location_id, tblSCL.location,
				DATE_FORMAT(tblSCW.start_date,'%d-%m-%Y') AS start_date, 
				DATE_FORMAT(tblSCW.end_date,'%d-%m-%Y') AS end_date, 
				tblSCW.description, tblSCW.IsView AS isview
                                FROM secondcrm_userworkexp tblSCW 
				LEFT JOIN secondcrm_company tblSCC ON tblSCC.company_id	= tblSCW.company_id
                                LEFT JOIN secondcrm_designation tblSCD ON tblSCD.designation_id = tblSCW.designation_id
				LEFT JOIN secondcrm_location tblSCL ON tblSCL.location_id = tblSCW.location_id
			WHERE tblSCW.uw_id=?"; 
		$params = array($uw_id);
		$result = $db->pquery($sql,$params);
			
		$workexpDetail = array();
		$workexpDetail['company_id'] = $db->query_result($result, 0, 'company_id');      
		$workexpDetail['company'] = $db->query_result($result, 0, 'company');      
		$workexpDetail['uw_id'] = $db->query_result($result, 0, 'uw_id');
		$workexpDetail['currentlyworking'] = $db->query_result($result, 0, 'currentlyworking');
		$workexpDetail['designation_id'] = $db->query_result($result, 0, 'designation_id');
		$workexpDetail['designation'] = $db->query_result($result, 0, 'designation');
		$workexpDetail['location_id'] = $db->query_result($result, 0, 'location_id');
		$workexpDetail['location'] = $db->query_result($result, 0, 'location');
		$workexpDetail['start_date'] = $db->query_result($result, 0, 'start_date');
		$workexpDetail['end_date'] = $db->query_result($result,0, 'end_date');
		$workexpDetail['description'] = $db->query_result($result, 0, 'description');
		$workexpDetail['isview'] = $db->query_result($result, 0, 'isview');
		
		return $workexpDetail;		
	}
	
	public function getUserWorkExpList($userId) {
			
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCW.uw_id, tblSCW.company_id,tblSCC.company_title, 
				tblSCD.designation,
				tblSCL.location,
				DATE_FORMAT(tblSCW.start_date,'%b-%Y') AS start_date, DATE_FORMAT(tblSCW.end_date,'%b-%Y') AS end_date, tblSCW.description, tblSCW.IsView AS isview
                                FROM secondcrm_userworkexp tblSCW 
				LEFT JOIN secondcrm_company tblSCC ON tblSCC.company_id	= tblSCW.company_id
                                LEFT JOIN secondcrm_designation tblSCD ON tblSCD.designation_id = tblSCW.designation_id
				LEFT JOIN secondcrm_location tblSCL ON tblSCL.location_id = tblSCW.location_id
			WHERE tblSCW.user_id=? AND tblSCW.deleted=0"; 
		$params = array($userId);
		$result = $db->pquery($sql,$params);
		$userWorkExpList = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$userWorkExpList[$i]['company_id'] = $db->query_result($result, $i, 'company');
				$userWorkExpList[$i]['company_title'] = $db->query_result($result, $i, 'company_title');
				$userWorkExpList[$i]['uw_id'] = $db->query_result($result, $i, 'uw_id');
				$userWorkExpList[$i]['designation'] = $db->query_result($result, $i, 'designation');
				$userWorkExpList[$i]['location'] = $db->query_result($result, $i, 'location');
				$userWorkExpList[$i]['start_date'] = $db->query_result($result, $i, 'start_date');
				$userWorkExpList[$i]['end_date'] = $db->query_result($result,$i, 'end_date');
				$userWorkExpList[$i]['description'] = $db->query_result($result, $i, 'description');
				$userWorkExpList[$i]['isview'] = $db->query_result($result, $i, 'isview');
			}
		}
		return $userWorkExpList;		
	}
	
	public function saveworkexpDetail($request)
	{
		$db  = PearDatabase::getInstance();
		$params 	= array();
		$userid  	= $request['current_user_id'];
		$uwId  		= $request['record'];
		$comId  	= decode_html($request['company_title']);
		$desId  	= decode_html($request['designation']);
		$isworking  	= $request['isworking'];
		$locId  	= decode_html($request['location']);
		$startDate 	= date('Y-m-d',strtotime(decode_html($request['start_date'])));
		if($isworking =='0'){
			$endDate	= date('Y-m-d',strtotime(decode_html($request['end_date'])));
		} else{
			$endDate	='';
		}	
		$jobDesc  	= decode_html($request['description']);
		$isview  	= decode_html($request['isview']);		
		$comTxt 	= decode_html($request['companytxt']);
		$desigTxt 	= decode_html($request['designationtxt']);
		$locTxt 	= decode_html($request['locationtxt']);
		if($uwId==0 && !empty($comTxt)) {
			$resultcom = $db->pquery("INSERT INTO secondcrm_company(company_title) VALUES(?)",array	($comTxt));		$resultcomID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'company_id'");
			$comId = $db->query_result($resultcomID, 0, 'company_id');	
		}
		if($desId==0 && !empty($desigTxt)) {
			$resultdesg = $db->pquery("INSERT INTO secondcrm_designation(designation) VALUES(?)",array($desigTxt));		
			$resultdesID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'designation_id'");
			$desId 	= $db->query_result($resultdesID, 0, 'designation_id');		
		}
		if($locId==0 && !empty($locTxt)) {
			$resultloc = $db->pquery("INSERT INTO secondcrm_location(location) VALUES(?)",array($locTxt));		
			$resultlocID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'location_id'");
			$locId 	= $db->query_result($resultlocID, 0, 'location_id');		
		}
		
		if(!empty($uwId)) {
			$params = array($comId,$desId,$locId,$startDate,$endDate,$jobDesc,$isview,$isworking,$uwId);			
			$result = $db->pquery("UPDATE secondcrm_userworkexp SET company_id = ?,designation_id=?,location_id=?, start_date = ?, end_date=?,description = ?, isview=?, currentlyworking=? WHERE 	uw_id=?",array($params));
			$return = 1;	

		} else {
			$params = array($userid, $comId,$desId,$locId,$startDate,$endDate,$jobDesc,$isview, $isworking);
			$result = $db->pquery("INSERT INTO secondcrm_userworkexp SET user_id = ?, company_id = ?,designation_id=?,location_id=?, start_date = ?, end_date=?,description = ?, isview=?, currentlyworking=?", array($params));
			$return = 0;
		}	
		 
		return $return;
	}
	
	//Delete Work Experience
	public function deleteWorkExpPermanently($uwId){	
		$db  		= PearDatabase::getInstance();
		$params 	= array();
		if(!empty($uwId)) {
			$params = array($uwId);
			
			$result = $db->pquery("UPDATE secondcrm_userworkexp SET deleted = 1 WHERE uw_id=?",array($params));
			return 1;
		} else {
			return 0;
		}
	}	
	
 }  

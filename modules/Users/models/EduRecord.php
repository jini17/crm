<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_EduRecord_Model extends Users_Record_Model {
    
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
       
	$query = 'SELECT * FROM secondcrm_education WHERE edu_id=?';
        
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

	public function getAllInstituionlist() {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_institution"; 
		$params = array();
		$result = $db->pquery($sql,$params);
			
		$institution = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$institution_id = $db->query_result($result, $i, 'institution_id');
				$institutionname	= $db->query_result($result, $i, 'institution');
				$institution[$i]['institution_id'] = $institution_id;
				$institution[$i]['institution'] = $institutionname;	
			}
		}
		return $institution;	
	}
	
	public function getAllAreaOfStudylist() {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_studyarea"; 
		$params = array();
		$result = $db->pquery($sql,$params);
			
		$major = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$major[$i]['major_id'] = $db->query_result($result, $i, 'major_id');
				$major[$i]['major'] = $db->query_result($result, $i, 'major');;	
			}
		}
		return $major;	
	}

	public function getEducationDetail($edu_id) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCE.edu_id, tblSCE.institution_id,tblSCI.institution, 
				DATE_FORMAT(tblSCE.start_date,'%d-%m-%Y') AS start_date, is_studying,
				DATE_FORMAT(tblSCE.end_date,'%d-%m-%Y') AS end_date, tblSCE.education_level, tblSCE.major_id,tblSCSA.major, 				tblSCE.description, tblSCE.isview FROM secondcrm_education tblSCE 
				LEFT JOIN secondcrm_institution tblSCI ON tblSCI.institution_id	= tblSCE.institution_id
				LEFT JOIN secondcrm_studyarea tblSCSA ON tblSCSA.major_id = tblSCE.major_id
			WHERE tblSCE.deleted = 0 AND tblSCE.edu_id=?"; 
		$params = array($edu_id);
		$result = $db->pquery($sql,$params);
			
		$educationDetail = array();
		$educationDetail['institution_id'] = $db->query_result($result, 0, 'institution_id');      
		$educationDetail['edu_id'] = $db->query_result($result, 0, 'edu_id');
		$educationDetail['is_studying'] = $db->query_result($result, 0, 'is_studying');	
		$educationDetail['start_date'] = $db->query_result($result, 0, 'start_date');
		$educationDetail['end_date'] = $db->query_result($result, 0, 'end_date');
		$educationDetail['education_level'] = $db->query_result($result, 0, 'education_level');
		$educationDetail['major_id'] = $db->query_result($result,0, 'major_id');
		$educationDetail['description'] = $db->query_result($result, 0, 'description');
		$educationDetail['isview'] = $db->query_result($result, 0, 'isview');
		
		return $educationDetail;		
	}

	public function getRandomUserEducationList($userId) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCE.edu_id, tblSCE.institution_id,tblSCI.institution, 
				DATE_FORMAT(tblSCE.start_date,'%b-%Y') AS start_date, is_studying,
				DATE_FORMAT(tblSCE.end_date,'%b-%Y') AS end_date, tblSCE.education_level, tblSCE.major_id,tblSCSA.major, 				tblSCE.description, tblSCE.isview FROM secondcrm_education tblSCE 
				LEFT JOIN secondcrm_institution tblSCI ON tblSCI.institution_id	= tblSCE.institution_id
				LEFT JOIN secondcrm_studyarea tblSCSA ON tblSCSA.major_id = tblSCE.major_id
			WHERE tblSCE.user_id = ? AND tblSCE.deleted = 0 ORDER BY RAND()
LIMIT 3"; 
		$params = array($userId);
		$result = $db->pquery($sql,$params);
			
		$userEducationList = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$userEducationList[$i]['institution_id'] = $db->query_result($result, $i, 'institution_id');		$userEducationList[$i]['institution'] = $db->query_result($result, $i, 'institution');
				$userEducationList[$i]['edu_id'] = $db->query_result($result, $i, 'edu_id');
				$userEducationList[$i]['start_date'] = $db->query_result($result, $i, 'start_date');
				$userEducationList[$i]['is_studying'] = $db->query_result($result, $i, 'is_studying');
				$userEducationList[$i]['end_date'] = $db->query_result($result, $i, 'end_date');
				$userEducationList[$i]['education_level'] = $db->query_result($result, $i, 'education_level');
				$userEducationList[$i]['major_id'] = $db->query_result($result, $i, 'major_id');
				$userEducationList[$i]['major'] = $db->query_result($result, $i, 'major');
				$userEducationList[$i]['description'] = $db->query_result($result, $i, 'description');
				$userEducationList[$i]['isview'] = $db->query_result($result, $i, 'isview');
			}
		}
		return $userEducationList;		
	}
	
	public function getUserEducationList($userId) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCE.edu_id, tblSCE.institution_id,tblSCI.institution, 
				DATE_FORMAT(tblSCE.start_date,'%b-%Y') AS start_date, is_studying,
				DATE_FORMAT(tblSCE.end_date,'%b-%Y') AS end_date, tblSCE.education_level, tblSCE.major_id,tblSCSA.major, 				tblSCE.description, tblSCE.isview FROM secondcrm_education tblSCE 
				LEFT JOIN secondcrm_institution tblSCI ON tblSCI.institution_id	= tblSCE.institution_id
				LEFT JOIN secondcrm_studyarea tblSCSA ON tblSCSA.major_id = tblSCE.major_id
			WHERE tblSCE.user_id = ? AND tblSCE.deleted = 0"; 
		$params = array($userId);
		$result = $db->pquery($sql,$params);
			
		$userEducationList = array();
		if($db->num_rows($result) > 0) {
			for($i=0;$i<$db->num_rows($result);$i++) {
			  	$userEducationList[$i]['institution_id'] = $db->query_result($result, $i, 'institution_id');		$userEducationList[$i]['institution'] = $db->query_result($result, $i, 'institution');
				$userEducationList[$i]['edu_id'] = $db->query_result($result, $i, 'edu_id');
				$userEducationList[$i]['start_date'] = $db->query_result($result, $i, 'start_date');
				$userEducationList[$i]['is_studying'] = $db->query_result($result, $i, 'is_studying');
				$userEducationList[$i]['end_date'] = $db->query_result($result, $i, 'end_date');
				$userEducationList[$i]['education_level'] = $db->query_result($result, $i, 'education_level');
				$userEducationList[$i]['major_id'] = $db->query_result($result, $i, 'major_id');
				$userEducationList[$i]['major'] = $db->query_result($result, $i, 'major');
				$userEducationList[$i]['description'] = $db->query_result($result, $i, 'description');
				$userEducationList[$i]['isview'] = $db->query_result($result, $i, 'isview');
			}
		}
		return $userEducationList;		
	}
	
	public function saveEducationDetail($request)
	{
		$db  = PearDatabase::getInstance();
		$params 	= array();
		$userid  	= $request['current_user_id'];
		$eduId  	= $request['record'];
		$insId  	= decode_html($request['institution_name']);
		$studying  	= $request['is_studying'];	
		$startdate  	= date('Y-m-d',strtotime(decode_html($request['start_date'])));
		if($studying =='0'){
			$endDate	= date('Y-m-d',strtotime(decode_html($request['end_date'])));
		} else{
			$endDate	='';
		}	
		$education_level= decode_html($request['education_level']);
		$majorId  	= decode_html($request['areaofstudy']);
		$majorTxt 	= decode_html($request['majortxt']);
		$description  	= decode_html($request['description']);
		$isview  	= decode_html($request['isview']);	
		
		$insTxt 	= decode_html($request['institutiontxt']);

		if($insId ==0 && !empty($insTxt)) {
           	 //check the institute exist or not
           	 $resultcheck  = $db->pquery("SELECT institution_id FROM secondcrm_institution WHERE institution = ?",array($insTxt));
		    if($db->num_rows($resultcheck) == 0){
		        $resultIns = $db->pquery("INSERT INTO secondcrm_institution(institution) VALUES(?)",array($insTxt));
		        $resultinID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'institution_id'");
		        $insId = $db->query_result($resultinID, 0, 'institution_id');
		    } else {
		        $insId = $db->query_result($resultcheck, 0, 'institution_id');
		    }    
                
        	}
	
        	if($majorId == 0 && !empty($majorTxt)) {
           	 //check the area of study exist or not
            	$resultmajorcheck  = $db->pquery("SELECT major_id FROM secondcrm_studyarea WHERE major = ?",array($majorTxt));
	    		if($db->num_rows($resultmajorcheck) == 0){
				$resultmajor = $db->pquery("INSERT INTO secondcrm_studyarea(major) VALUES(?)",array($majorTxt));
				$resultmajorID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'major_id'");
				$majorId = $db->query_result($resultmajorID, 0, 'major_id');
		    	} else {
		       		$majorId = $db->query_result($resultmajorcheck, 0, 'major_id');
		    	}    
        	}
		
		if(!empty($eduId)) {
			$params = array($insId,$startdate,$endDate,$education_level,$majorId,$description,$isview,$studying, $eduId);	
			$result = $db->pquery("UPDATE secondcrm_education SET institution_id = ?,start_date=?,end_date=?, education_level = ?, major_id=?, description = ?, isview=?,is_studying=? WHERE edu_id=?",array($params));
			$return = 1;	

		} else {
			$params = array($userid, $insId,$startdate,$endDate,$education_level,$majorId,$description,$isview,$studying);
			$result = $db->pquery("INSERT INTO secondcrm_education SET user_id = ?, institution_id = ?,start_date=?,end_date=?, education_level = ?, major_id=?, description = ?, isview=?, is_studying=? ", array($params));
			$return = 0;
		}	
		 
		return $return;
	}

	//Delete Education
	public function deleteEducationPermanently($eduId){	
		$db  		= PearDatabase::getInstance();
		$params 	= array();
		if(!empty($eduId)) {
			$params = array($eduId);
			$result = $db->pquery("UPDATE secondcrm_education SET deleted = 1 WHERE edu_id=?",array($params));
			return 1;
		} else {
			return 0;
		}
	}
 }  

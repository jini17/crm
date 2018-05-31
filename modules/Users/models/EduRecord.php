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
		$sql = "SELECT vtiger_education.* FROM vtiger_education 
				INNER JOIN vtiger_crmentity	ON vtiger_crmentity.crmid = vtiger_education.educationid
				WHERE vtiger_crmentity.deleted=0 AND vtiger_education.educationid=?"; 
		$params = array($edu_id);
		$result = $db->pquery($sql,$params);
			
		$educationDetail = array();
		$educationDetail['institution_name'] = $db->query_result($result, 0, 'institution_name');      
		$educationDetail['educationid'] = $db->query_result($result, 0, 'educationid');
		$educationDetail['currently_studying'] = $db->query_result($result, 0, 'currently_studying');	
		$educationDetail['start_date'] = $db->query_result($result, 0, 'start_date');
		$educationDetail['end_date'] = $db->query_result($result, 0, 'end_date');
		$educationDetail['education_level'] = $db->query_result($result, 0, 'education_level');
		$educationDetail['area_of_study'] = $db->query_result($result,0, 'area_of_study');
		$educationDetail['description'] = $db->query_result($result, 0, 'description');
		$educationDetail['public'] = $db->query_result($result, 0, 'public');
		
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

		$db = PearDatabase::getInstance();
		
		$query = "SELECT vtiger_education.* FROM vtiger_education
			INNER JOIN vtiger_crmentity
			ON vtiger_crmentity.crmid = vtiger_education.educationid
			WHERE vtiger_crmentity.smownerid = ? AND vtiger_crmentity.deleted=0";

		$result = $db->pquery($query,array($userId));
		$eduList=array();	
	
		for($i=0;$db->num_rows($result)>$i;$i++){
			$eduList[$i]['institution_name'] = $db->query_result($result, $i, 'institution_name');
			$eduList[$i]['educationid'] = $db->query_result($result, $i, 'educationid');
			$eduList[$i]['start_date'] = date('M-Y',strtotime($db->query_result($result, $i, 'start_date')));
			$eduList[$i]['end_date'] =  date('M-Y',strtotime($db->query_result($result, $i, 'end_date')));
			$eduList[$i]['is_studying'] = $db->query_result($result, $i, 'currently_studying');
			$eduList[$i]['education_level'] = $db->query_result($result, $i, 'education_level');
			$eduList[$i]['area_of_study'] = $db->query_result($result, $i, 'area_of_study');
			$eduList[$i]['description'] = $db->query_result($result, $i, 'description');
			$eduList[$i]['public'] = $db->query_result($result, $i, 'public');
		}

		return $eduList;

	}		
	
	public function saveEducationDetail($request)
	{
		include_once('modules/Education/Education.php');
		$db  = PearDatabase::getInstance();
		//$db->setDebug(true);
		$params 	= array();
		$userid  	= $request['current_user_id'];
		$eduId  	= $request['record'];
		$insId  	= decode_html(trim($request['institution_name']));
		$startdate  = date('Y-m-d',strtotime($request['start_date']));
		$studying  	= $request['is_studying'];	
		
		if($studying ==0){
			$endDate	= date('Y-m-d',strtotime($request['end_date']));
		} else{
			$endDate	='';
		}	
		$education_level= decode_html($request['education_level']);
		$majorId  	= decode_html($request['areaofstudy']);
		$majorTxt 	= decode_html($request['majortxt']);
		$description  	= decode_html($request['description']);
		$isview  	= decode_html($request['isview']);	
		
		$insTxt 	= decode_html(trim($request['institutiontxt']));

		if($insId ==0 && !empty($insTxt)) {
           	 //check the institute exist or not
	           	 $resultcheck  = $db->pquery("SELECT institution_id FROM secondcrm_institution WHERE institution = ?",array($insTxt));
			    if($db->num_rows($resultcheck) == 0){
			        $resultIns = $db->pquery("INSERT INTO secondcrm_institution(institution) VALUES(?)",array($insTxt));
			    }
			     $insId = $insTxt;    
                
        }
	
        	if($majorId == 0 && !empty($majorTxt)) {
           	 //check the area of study exist or not
            	$resultmajorcheck  = $db->pquery("SELECT major_id FROM secondcrm_studyarea WHERE major = ?",array($majorTxt));
	    		if($db->num_rows($resultmajorcheck) == 0){
					$resultmajor = $db->pquery("INSERT INTO secondcrm_studyarea(major) VALUES(?)",array($majorTxt));
				}
				$majorId = $majorTxt; 
        	}

			$education = new Education();
			$education->column_fields['institution_name'] 	= $insId;	
			$education->column_fields['start_date'] 		= $startdate;	
			$education->column_fields['currently_studying'] = $studying;	
			$education->column_fields['end_date'] 			= $endDate;	
			$education->column_fields['education_level'] 	= $education_level;	
			$education->column_fields['area_of_study'] 		= $majorId;	
			$education->column_fields['description'] 		= $description;
			$education->column_fields['public'] 			= $isview;
			$education->column_fields['assigned_user_id'] 	= $userid;
			
		if(!empty($eduId)) {
			//update Education
			$education->mode = 'edit';
			$education->id = $eduId;
			$return = 1;
			$db->pquery("UPDATE vtiger_education SET institution_name=?, start_date=?, currently_studying=?, end_date=?, education_level=?,area_of_study=?, description=?,public=? WHERE educationid=?", array($insId, $startdate, $studying, $endDate,$education_level, $majorId, $description, $isview, $eduId));
		} else {
			$education->mode = '';
			$return = 0;
		}	
	
		$response = $education->save('Education');
		return $return;
	}
 }  

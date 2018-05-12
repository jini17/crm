<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_ProjectRecord_Model extends Users_Record_Model {
    
    public function getId() {
        return $this->get('project_id');
    }
    
    public function getName() {
        return $this->get('title');
    }

    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
       
	$query = 'SELECT * FROM secondcrm_project WHERE project_id=?';
        
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

	public function getAllDesignationlist($userid) {
		$db  = PearDatabase::getInstance();
		$params = array($userid);
		$designation = array();	
		$designation1 = array();	
		$designation2 = array();	
		$result1 = $db->pquery("SELECT CONCAT('W#','',tblSCUW.uw_id) AS designation_id, 'W' AS 'relation_type',
						CONCAT(tblSCD.designation,' at ',tblSCC.company_title,', ', 							tblSCC.company_location) AS designation
					FROM secondcrm_userworkexp tblSCUW
						LEFT JOIN secondcrm_designation tblSCD 
							ON tblSCD.designation_id = tblSCUW.designation_id
						LEFT JOIN secondcrm_company tblSCC 
							ON tblSCC.company_id = tblSCUW.company_id
						LEFT JOIN secondcrm_location tblSCL 
							on tblSCL.location_id = tblSCUW.location_id
					WHERE tblSCUW.user_id=?",$params);

		$result2 = $db->pquery("SELECT CONCAT('E#','',tblSCE.Edu_id) AS designation_id,'E' AS 'relation_type',
						CONCAT(tblSCI.institution,', ',tblSCSA.major) 
						AS designation FROM secondcrm_education tblSCE
						LEFT JOIN secondcrm_institution tblSCI 
							ON tblSCI.institution_id = tblSCE.institution_id
						LEFT JOIN secondcrm_studyarea tblSCSA
							ON tblSCSA.major_id = tblSCE.major_id
					WHERE tblSCE.user_id=?",$params);	 
		
		if($db->num_rows($result1) > 0) {
			for($i=0;$i<$db->num_rows($result1);$i++) {
			  	$designation1[$i]['designation_id'] = $db->query_result($result1, $i, 'designation_id');
				$designation1[$i]['designation'] = $db->query_result($result1, $i, 'designation');
				$designation1[$i]['relation_type'] = $db->query_result($result1, $i, 'relation_type');	
			}
		}
		if($db->num_rows($result2) > 0) {
			for($j=0;$j<$db->num_rows($result2);$j++) {
			  	$designation2[$j]['designation_id'] = $db->query_result($result2, $j, 'designation_id');
				$designation2[$j]['designation'] = $db->query_result($result2, $j, 'designation');
				$designation2[$j]['relation_type'] = $db->query_result($result2, $j, 'relation_type');	
			}
		}
		$designation = array_merge($designation1,$designation2);
		return $designation;	
	}
	
	public function getProjectDetail($project_id) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT tblSCP.project_id, tblSCP.title,
				CONCAT(tblSCP.relation_type,'#',tblSCP.relation_id) AS 'designation', 
				tblSCP.project_month,tblSCP.project_year,tblSCP.project_url, 
				tblSCP.description,tblSCP.isview 
			FROM secondcrm_project tblSCP 
			WHERE tblSCP.deleted = 0 AND tblSCP.project_id=?"; 
		$params = array($project_id);
		$result = $db->pquery($sql,$params);
			
		$projectDetail 			= array();
		$projectDetail['title'] 	= $db->query_result($result, 0, 'title');      
		$projectDetail['designation'] 	= $db->query_result($result, 0, 'designation');
		$projectDetail['project_month'] = $db->query_result($result, 0, 'project_month');
		$projectDetail['project_year'] 	= $db->query_result($result, 0, 'project_year');
		$projectDetail['project_url'] 	= $db->query_result($result,0, 'project_url');
		$projectDetail['description'] 	= $db->query_result($result, 0, 'description');
		$projectDetail['isview'] 	= $db->query_result($result, 0, 'isview');
		
		return $projectDetail;		
	}
	
	public function getUserProjectList($userId) {
		$db  = PearDatabase::getInstance();
		$params = array($userId);
		$result1 = $db->pquery("SELECT tblSCP.project_id, tblSCP.title, 
						CONCAT('E#','',tblSCE.Edu_id) AS designatoin_id,
						CONCAT(tblSCI.institution,', ',tblSCSA.major) AS designation, 
						tblSCP.project_month,tblSCP.project_year,tblSCP.project_url, 
						tblSCP.description,tblSCP.isview,tblSCP.relation_type 
				FROM secondcrm_project tblSCP 
				LEFT JOIN secondcrm_education tblSCE ON tblSCE.edu_id = tblSCP.relation_id
				LEFT JOIN secondcrm_institution tblSCI ON tblSCI.institution_id = tblSCE.institution_id
				LEFT JOIN secondcrm_studyarea tblSCSA ON tblSCSA.major_id = tblSCE.major_id
				WHERE tblSCP.deleted = 0  AND tblSCP.user_id = ? AND tblSCP.relation_type='E'",$params);
			
		$result2 = $db->pquery("SELECT tblSCP.project_id, tblSCP.title, 
						CONCAT('W#','',tblSCUW.uw_id) AS designatoin_id, 
						CONCAT(tblSCD.designation,' at ',tblSCC.company_title,', ', 							tblSCL.location) AS designation,
						tblSCP.project_month,tblSCP.project_year,tblSCP.project_url, 
						tblSCP.description,tblSCP.isview,tblSCP.relation_type 
				FROM secondcrm_project tblSCP 
				LEFT JOIN secondcrm_userworkexp tblSCUW ON tblSCUW.uw_id = tblSCP.relation_id
				LEFT JOIN secondcrm_designation tblSCD 
							ON tblSCD.designation_id = tblSCUW.designation_id
						LEFT JOIN secondcrm_company tblSCC 
							ON tblSCC.company_id = tblSCUW.company_id
						LEFT JOIN secondcrm_location tblSCL 
							on tblSCL.location_id = tblSCUW.location_id
			WHERE tblSCP.deleted = 0  AND tblSCP.user_id = ? AND tblSCP.relation_type='W'",$params);
		$$userWEProjectList = array();	
		$userEduProjectList = array();
		$userProjectList = array();
		if($db->num_rows($result1) > 0) {
			for($i=0;$i<$db->num_rows($result1);$i++) {
			  	$userEduProjectList[$i]['project_id']    = $db->query_result($result1, $i, 'project_id');			$userEduProjectList[$i]['title']	      = $db->query_result($result1, $i, 'title');
				$userEduProjectList[$i]['designation']   = $db->query_result($result1, $i, 'designation');
				$userEduProjectList[$i]['project_month'] = $db->query_result($result1, $i, 'project_month');		$userEduProjectList[$i]['project_year']  = $db->query_result($result1, $i, 'project_year');
				$userEduProjectList[$i]['project_url']   = $db->query_result($result1, $i, 'project_url');
				$userEduProjectList[$i]['description']   = $db->query_result($result1, $i, 'description');
				$userEduProjectList[$i]['isview'] 	      = $db->query_result($result1, $i, 'isview');
				$userEduProjectList[$i]['relation_type'] 	      = $db->query_result($result1, $i, 'relation_type');
			}
		}
		$userWEProjectList = array();
		if($db->num_rows($result2) > 0) {
			for($j=0;$j<$db->num_rows($result2);$j++) {
			  	$userWEProjectList[$j]['project_id'] = $db->query_result($result2, $j, 'project_id');			$userWEProjectList[$j]['title'] = $db->query_result($result2, $j, 'title');
				$userWEProjectList[$j]['designation'] = $db->query_result($result2, $j, 'designation');
				$userWEProjectList[$j]['project_month'] = $db->query_result($result2, $j, 'project_month');
				$userWEProjectList[$j]['project_year'] = $db->query_result($result2, $j, 'project_year');
				$userWEProjectList[$j]['project_url'] = $db->query_result($result2, $j, 'project_url');
				$userWEProjectList[$j]['description'] = $db->query_result($result2, $j, 'description');
				$userWEProjectList[$j]['isview'] = $db->query_result($result2, $j, 'isview');
				$userWEProjectList[$j]['relation_type'] = $db->query_result($result2, $j, 'relation_type');	
			}
		}
			$userProjectList = array_merge($userEduProjectList,$userWEProjectList);

		return $userProjectList;		
	}
	
	public function saveProjectDetail($request)
	{
		$db  = PearDatabase::getInstance();
		$params 	= array();
		$userid  	= $request['current_user_id'];
		$projectId  	= $request['record'];
		$title  	= decode_html($request['title']);
		$designationarray  = explode('#',decode_html($request['designation']));
		$relation_id 	= $designationarray[1];
		$relation_type 	= $designationarray[0];		
		$project_month 	= decode_html($request['project_month']);
		$project_year	= decode_html($request['project_year']);
		$project_url  	= decode_html($request['project_url']);
		$description  	= decode_html($request['description']);
		$isview  	= decode_html($request['isview']);		
	
		if(!empty($projectId)) {
			$params = array($title,$relation_id, $relation_type, $project_month,$project_year,$project_url,$description,$isview,$projectId);
			$result = $db->pquery("UPDATE secondcrm_project SET title = ?, relation_id=?,relation_type=?, project_month=?,project_year=?, project_url = ?, description = ?, isview=? WHERE project_id=?",array($params));
			$return = 1;	

		} else {
			$params = array($userid, $title,$relation_id, $relation_type, $project_month, $project_year,$project_url,$description,$isview);
			$result = $db->pquery("INSERT INTO secondcrm_project SET user_id = ?, title = ?, relation_id=?,relation_type=?,project_month=?,project_year=?, project_url = ?, description = ?, isview=?", array($params));
			$return = 0;
		}	
		 
		return $return;
	}

	//Deleted Project 
	public function deleteProjectPermanently($projectId){	
		$db  = PearDatabase::getInstance();
		$params 	= array();
		if(!empty($projectId)) {
			$params = array($projectId);
			$result = $db->pquery("UPDATE secondcrm_project SET deleted = 1 WHERE project_id=?",array($params));
			return 1;
		} else {
			return 0;
		}
	}

 }  

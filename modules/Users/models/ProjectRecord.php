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
                $result1 = $db->pquery("SELECT * FROM secondcrm_designation", array());

                if($db->num_rows($result1) > 0) {
                        for($i=0;$i<$db->num_rows($result1);$i++) {
                                $designation[$i]['designation_id'] = $db->query_result($result1, $i, 'designation_id');
                                $designation[$i]['designation'] = $db->query_result($result1, $i, 'designation');
                        }
                }
                return $designation;	
        }

        public function getProjectDetail($project_id) {
                $db  = PearDatabase::getInstance();
                // /$db->setDebug(true);
                $params = array($project_id);
                $result = $db->pquery("SELECT employeeprojectsid,project_title,occupation, project_url, project_description, ispublic , date_FORMAT(project_start_date,'%m') as project_month, date_FORMAT(project_start_date,'%Y') as project_year
                                        FROM vtiger_employeeprojects
                                        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_employeeprojects.employeeprojectsid
                                        WHERE vtiger_crmentity.deleted = 0 AND vtiger_employeeprojects.employeeprojectsid=?", $params);


                $projectDetail 			= array();
                $projectDetail['title'] 		= $db->query_result($result, 0, 'project_title');  
                $projectDetail['employeeprojectsid'] 		= $db->query_result($result, 0, 'employeeprojectsid');          
                $projectDetail['designation'] 	= $db->query_result($result, 0, 'occupation');
                $projectDetail['project_month'] = $db->query_result($result, 0, 'project_month');
                $projectDetail['project_year'] 	= $db->query_result($result, 0, 'project_year');
                $projectDetail['project_url'] 	= $db->query_result($result,0, 'project_url');
                $projectDetail['description'] 	= $db->query_result($result, 0, 'project_description');
                $projectDetail['isview'] 		= $db->query_result($result, 0, 'ispublic');

                return $projectDetail;		
        }

        public function getUserProjectList($userId) {
             $currentUserModel = Users_Record_Model::getCurrentUserModel();
              $current_user_id = $currentUserModel->get('id');
              $role                        = $currentUserModel->get('roleid');
              
                $db  = PearDatabase::getInstance();
                //$db->setDebug(true);
                $params = array($userId);
                $result2 = $db->pquery("SELECT employeeprojectsid,project_title,occupation, project_url, project_description,ispublic , date_FORMAT(project_start_date,'%b %Y') as project_start_date,vtiger_crmentity.smownerid FROM vtiger_employeeprojects
                                         INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_employeeprojects.employeeprojectsid
                                        WHERE vtiger_crmentity.deleted = 0  AND vtiger_crmentity.smownerid = ?", $params);
                $userWEProjectList = array();
                if($db->num_rows($result2) > 0) {
                        for($j=0;$j<$db->num_rows($result2);$j++) {
                            
                        $permission = Users_Record_Model::recordPermission($role,$db->query_result($result2, $j, 'smownerid'),$current_user_id,$db->query_result($result2, $j, 'ispublic'));
                             if($permission){
                                $userWEProjectList[$j]['employeeprojectsid'] = $db->query_result($result2, $j, 'employeeprojectsid');			
                                $userWEProjectList[$j]['title'] = $db->query_result($result2, $j, 'project_title');
                                $userWEProjectList[$j]['designation'] = $db->query_result($result2, $j, 'occupation');
                                $userWEProjectList[$j]['project_start_date'] = $db->query_result($result2, $j, 'project_start_date');
                                $projectUrl = $db->query_result($result2, $j, 'project_url');
                                if(stripos($projectUrl,'http://') ===false){
                                    $projectUrl = 'http://'.$projectUrl;
                                }
                                $userWEProjectList[$j]['project_url'] = $projectUrl;
                                $userWEProjectList[$j]['description'] = $db->query_result($result2, $j, 'project_description');
                                $userWEProjectList[$j]['isview'] = $db->query_result($result2, $j, 'ispublic');
                             }
                        }
                }

                return $userWEProjectList;		
        }

        public function saveProjectDetail($request)
        {
                include_once("modules/EmployeeProjects/EmployeeProjects.php");

                $db  = PearDatabase::getInstance();
                //$db->setDebug(true);
                $params 		= array();
                $userid  		= $request['current_user_id'];
                $projectId  	= $request['record'];
                $title  		= decode_html($request['title']);
                $desId  		= decode_html(trim($request['designation']));
                $destxt 		= decode_html($request['designation_titletxt']);

                $project_month 	= decode_html($request['project_month']);
                $project_year	= decode_html($request['project_year']);
                $project_url  	= decode_html($request['project_url']);
                $description  	= decode_html($request['description']);
                $isview  		= decode_html($request['isview']);		
                $start_date 	= $project_year.'-'.$project_month.'-'.'01';
                if($desId ==0 && !empty($destxt)) {
                 //check the desgination exist or not
                         $resultcheck  = $db->pquery("SELECT designation_id FROM secondcrm_designation WHERE designation = ?",array($destxt));
                            if($db->num_rows($resultcheck) == 0){
                                $resultIns = $db->pquery("INSERT INTO secondcrm_designation(designation) VALUES(?)",array($destxt));
                            }
                             $desId = $destxt;    

        }

                $project = new EmployeeProjects();
                        $project->column_fields['project_title'] 		= $title;	
                        $project->column_fields['occupation']                                  = $desId;	
                        $project->column_fields['project_start_date'] 	= $start_date;	
                        $project->column_fields['project_url']                                  = $project_url;	
                        $project->column_fields['ispublic'] 		= $isview;	
                        $project->column_fields['project_description'] 	= $description;
                        $project->column_fields['assigned_user_id'] 	= $userid;

                if(!empty($projectId)) {
                        //update Education
                        $project->mode = 'edit';
                        $project->id = $projectId;
                        $return = 1;
                        $db->pquery("UPDATE vtiger_employeeprojects SET project_title=?, project_start_date=?, occupation=?, project_url=?, ispublic=?,project_description=? WHERE employeeprojectsid=?", array($title, $start_date, $desId, $project_url,
                                $isview, $description, $projectId));
                } else {
                        $project->mode = '';
                        $return = 0;
                }	

                $response = $project->save('EmployeeProjects');
                return $return;
        }
 }  
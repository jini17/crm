<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_SkillsRecord_Model extends Vtiger_Record_Model {

    public static function getLangInstance($id=null) {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM secondcrm_softskill WHERE ss_id=?';
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

    public static function getSkillInstance($id=null) {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM secondcrm_skills WHERE skill_id=?';
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
        protected static $currentUserModels = array();
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



        public function getAllLanguage($userId,$lang_Id) {
                $db  = PearDatabase::getInstance();
                $and = '';	
                if($lang_Id !='') {
                        $and = " AND language_id !=".$lang_Id; 
                }	
                $sql = "SELECT * FROM secondcrm_language WHERE language_id NOT IN (SELECT language_id FROM secondcrm_softskill WHERE user_id = ? $and AND deleted=0) "; 
                $params = array($userId);
                $result = $db->pquery($sql,$params);

                $language = array();
                if($db->num_rows($result) > 0) {
                        for($i=0;$i<$db->num_rows($result);$i++) {
                                $language[$i]['language_id'] = $db->query_result($result, $i, 'language_id');
                                $language[$i]['language'] = $db->query_result($result, $i, 'language');
                        }
                }
                return $language;	
        }

        public function getUserSoftSkillList($userId) {
                $db  = PearDatabase::getInstance();
                $sql = "SELECT tblSCSS.ss_id, tblSCSS.language_id, tblSCL.language, tblSCSS.proficiency,tblSCSS.isview 	FROM secondcrm_softskill tblSCSS INNER JOIN secondcrm_language tblSCL 
                                ON tblSCL.language_id=tblSCSS.language_id AND tblSCSS.deleted=0 AND tblSCSS.user_id=?";
                $params = array($userId);
                $result = $db->pquery($sql,$params);

                $userlanguage = array();
                if($db->num_rows($result) > 0) {
                        for($i=0;$i<$db->num_rows($result);$i++) {
                                $userlanguage[$i]['ss_id'] = $db->query_result($result, $i, 'ss_id');
                                $userlanguage[$i]['language_id'] = $db->query_result($result, $i, 'language_id');
                                $userlanguage[$i]['language'] = $db->query_result($result, $i, 'language');
                                $userlanguage[$i]['proficiency'] = $db->query_result($result, $i, 'proficiency');
                                $userlanguage[$i]['isview'] = $db->query_result($result, $i, 'isview');
                                                                                     $userlanguage[$i]['color']   = $this->get_color('vtiger_expertise_level','expertise_level',$db->query_result($result, $i, 'proficiency'));
                        }
                }
                return $userlanguage;	
        }

        public function getSoftSkillDetail($ss_id) {
                $db  = PearDatabase::getInstance();
                $sql = "SELECT tblSCSS.language_id, tblSCL.language, tblSCSS.proficiency,tblSCSS.isview FROM secondcrm_softskill tblSCSS INNER JOIN secondcrm_language tblSCL 
                                ON tblSCL.language_id=tblSCSS.language_id AND tblSCSS.deleted=0 AND tblSCSS.ss_id=?"; 
                $params = array($ss_id);
                $result = $db->pquery($sql,$params);

                $languagedetail = array();
                $languagedetail['language_id'] = $db->query_result($result, 0, 'language_id');      
                $languagedetail['language'] = $db->query_result($result, 0, 'language');
                $languagedetail['proficiency'] = $db->query_result($result, 0, 'proficiency');
                $languagedetail['isview'] = $db->query_result($result, 0, 'isview');

                return $languagedetail;		
        }
        public function saveSoftSkillDetail($request)
        {
                $db  = PearDatabase::getInstance();
                $params 	= array();
                $userid  	= $request['current_user_id'];
                $ssId  		= $request['record'];
                $langId  	= decode_html($request['language']);
                $proficiency  	= decode_html($request['proficiency']);
                //$isview  	= decode_html($request['isview']);		
                $langTxt 	= ucwords(decode_html($request['langtxt']));

                if($langId==0 && !empty($langTxt)) {
                        //check the language exist or not
                        $resultcheck  = $db->pquery("SELECT language_id FROM secondcrm_language WHERE language = ?",array($langTxt));
                        $existrec = $db->num_rows($resultcheck);
                        if($existrec==0){
                                $resultlang = $db->pquery("INSERT INTO secondcrm_language(language) VALUES(?)",array($langTxt));
                                $resultlangID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'language_id'");
                                $langId = $db->query_result($resultlangID, 0, 'language_id');

                                $params = array($userid, $langId,$proficiency);
                                $result = $db->pquery("INSERT INTO secondcrm_softskill SET user_id = ?, language_id = ?,proficiency=?", array($params));
                                $return = 0;	
                        } else {
                                $return = 3;
                        }	
                } else {
                        if(!empty($ssId)) {
                                $params = array($proficiency,$ssId);			
                                $result = $db->pquery("UPDATE secondcrm_softskill SET proficiency=? WHERE ss_id=?",array($params));			$return = 1;	

                        } else {
                                $params = array($userid, $langId,$proficiency);
                                $result = $db->pquery("INSERT INTO secondcrm_softskill SET user_id = ?, language_id = ?,proficiency=?", array($params));
                                $return =0;	
                        }
                }

                return $return;
        }

        //Delete Language
        public function deleteLanguagePermanently($langId){

                $db  		= PearDatabase::getInstance();
                //$db->setDebug(true);
                $params 	= array();
                if(!empty($langId)) {
                        $params = array($langId);
                        $result = $db->pquery("DELETE FROM  secondcrm_softskill WHERE ss_id=?",array($params));
                        return 1;
                } else {
                        return 0;
                }

        }

        public function getSkill($skillId) { 

                $db     = PearDatabase::getInstance();
                $db->setDebug(1);
                $result = $db->pquery("SELECT skill_title FROM secondcrm_skillmaster WHERE skill_id = ?", array($skillId)); 

                return array('skill_id' => $skillId, 'skill' => $db->query_result($result, 0, 'skill_title'));
               
        }

        public function getALLSkills($userId) {
                $db  = PearDatabase::getInstance();
                $sql = "SELECT secondcrm_skillmaster.skill_id,secondcrm_skillmaster.skill_title FROM secondcrm_skillmaster WHERE skill_id NOT IN (SELECT skill_id FROM secondcrm_skills WHERE user_id = ?)"; 
                $params = array($userId);
                $result = $db->pquery($sql,$params);

                $SkillList = array();
                if($db->num_rows($result) > 0) {
                        for($i=0;$i<$db->num_rows($result);$i++) {
                                $SkillList[$i]['skill_id']  = $db->query_result($result, $i, 'skill_id');      
                                $SkillList[$i]['skill']     = $db->query_result($result, $i, 'skill_title');
                        }
                }
                return $SkillList;		
        }

        public function getSkillLabel($skillId, $userId) {

                $db     = PearDatabase::getInstance();
                $result = $db->pquery("SELECT skill_label FROM secondcrm_skills WHERE skill_id = ? AND user_id = ?", array($skillId, $userId));

                return $db->query_result($result, 0, 'skill_label'); 

        }

        public function getUserSkillCloud($userId) {

                $db  = PearDatabase::getInstance();
                $sql = "SELECT tblSCS.skill_id, tblSCSM.skill_title, tblSCS.endorsement, tblSCS.skill_label
                                FROM secondcrm_skills tblSCS 
                                LEFT JOIN secondcrm_skillmaster tblSCSM ON tblSCSM.skill_id = tblSCS.skill_id
                                WHERE tblSCS.user_id=?";
                $params = array($userId);
                $result = $db->pquery($sql,$params);

                $UserSkillCloud = array();
                if($db->num_rows($result) > 0) {
                        for($i=0;$i<$db->num_rows($result);$i++) {
                                $UserSkillCloud[$i]['skill_id'] = $db->query_result($result, $i, 'skill_id');
                                $UserSkillCloud[$i]['skill_title'] = $db->query_result($result, $i, 'skill_title');
                                $UserSkillCloud[$i]['endorsement'] = $db->query_result($result, $i, 'endorsement');
                                $UserSkillCloud[$i]['skill_label'] = $db->query_result($result, $i, 'skill_label');
                                $UserSkillCloud[$i]['color']   = $this->get_color('vtiger_add_skill','add_skill',$db->query_result($result, $i, 'skill_label'));

                        }
                }
                return $UserSkillCloud;		
        }



        public function saveUserSkill($request)
        {
                $db  = PearDatabase::getInstance();
                $params 	= array();
                $userid  	= $request['current_user_id'];
                $skill_id  	= decode_html($request['skill']);
                $skillTxt 	= decode_html($request['skilltxt']);
                $skillLabel = decode_html($request['skill_label']);
                
                if (isset($request['oldSkill'])) {

                   $db->pquery("DELETE FROM secondcrm_skills WHERE skill_id = ? AND user_id = ?", array($request['oldSkill'], $userid));    

                }

                if($skill_id==0 && !empty($skillTxt)) {
                        //check the skill exist or not
                        $resultcheck  = $db->pquery("SELECT skill_id FROM secondcrm_skillmaster WHERE skill_title = ?",array($skillTxt));
                        $existrec = $db->num_rows($resultcheck);
                        if($existrec == 0){ 
                                $resultskill = $db->pquery("INSERT INTO secondcrm_skillmaster(skill_title) VALUES(?)",array($skillTxt));
                                $resultskillID =  $db->pquery("SELECT LAST_INSERT_ID() AS 'skill_id'");
                                $skill_id = $db->query_result($resultskillID, 0, 'skill_id');
                                $params = array($skill_id, $userid, $skillLabel);
                                $result = $db->pquery("INSERT INTO secondcrm_skills SET skill_id = ?, user_id = ?, skill_label=?", array($params));				
                                $return = 1;
                        } else {
                                $return = 3;
                        }

                } else {
                        $params = array($skill_id, $skillLabel,$userid);
                        $result = $db->pquery("INSERT INTO secondcrm_skills SET skill_id = ?,skill_label=?, user_id = ?", array($params));	
                        $return = 0;
                }
                return $return;	
        }

        //Delete Skill
        public function deleteSkillPermanently($skillId, $userId){	
                $db  		= PearDatabase::getInstance();
                $params 	= array();
                if(!empty($skillId) && !empty($userId)) {
                        $params = array($skillId, $userId);                        
                        $result = $db->pquery("DELETE FROM secondcrm_skills WHERE skill_id=? and user_id = ?", $params);
                        return 1;
                } else {
                        return 0;
                }

        }

        public function get_color($table,$column,$skill){
           $db = PearDatabase::getInstance();
           //$db->setDebug(true);
           $translated = str_replace(array("'",'"'),"",vtranslate($skill,"Users"));
           $sql = "SELECT color FROM ".$table." WHERE $column = '$translated'";
           $query = $db->pquery($sql,array());
           $num_rows = $db->num_rows($query);
           if($num_rows > 0){
               $color = $db->query_result($query,0,'color');
           }else{
                $color = "#000";
           }
           return $color;
        }

 }  

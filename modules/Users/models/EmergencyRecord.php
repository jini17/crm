<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_EmergencyRecord_Model extends Users_Record_Model {
    
    public static function getInstance($id=null) {
        $db = PearDatabase::getInstance();
       
	$query = 'SELECT * FROM secondcrm_emergencycontact WHERE user_id=?';
        
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

	public function getUserEmergencyContact($userId) {
		$db  = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_emergencycontact WHERE user_id=?"; 
		$params = array($userId);
		$result = $db->pquery($sql,$params);
		$contacts = array();
		if($db->num_rows($result) > 0) {
			  	$contacts['contact_name'] = $db->query_result($result, 0, 'contact_name');
				$contacts['home_phone'] = $db->query_result($result, 0, 'home_phone');
				$contacts['office_phone'] = $db->query_result($result, 0, 'office_phone');
				$contacts['mobile'] = $db->query_result($result, 0, 'mobile');
				$contacts['relationship'] = $db->query_result($result, 0, 'relationship');
				$contacts['isview']	   = $db->query_result($result, 0, 'isview');
		}
		return $contacts;	
	}

	
	public function saveContactDetail($request)
	{
		$db  = PearDatabase::getInstance();
		$params 	= array();
		$userid  	= $request['current_user_id'];
		$contact_name  	= decode_html($request['contact_name']);
		$home_phone  	= decode_html($request['home_phone']);
		$office_phone  	= decode_html($request['office_phone']);
		$mobile		= decode_html($request['mobile']);
		$relationship  	= decode_html($request['relationship']);
		$isview  	= decode_html($request['isview']);		
				
          	 //check the contact exist or not
           	 $resultcheck  = $db->pquery("SELECT * FROM secondcrm_emergencycontact WHERE user_id=?",array($userid));
		 if($db->num_rows($resultcheck) == 0){
			$resultIns = $db->pquery("INSERT INTO secondcrm_emergencycontact(user_id,contact_name,isview,home_phone,office_phone,mobile,relationship) VALUES(?,?,?,?,?,?,?)",array($userid,$contact_name,$isview,$home_phone,$office_phone,$mobile,$relationship));
			return 0;
		 } else {
		        $resultIns = $db->pquery("UPDATE secondcrm_emergencycontact SET contact_name =?,isview=?,home_phone=?,office_phone=?,mobile=?,relationship=? WHERE user_id=?",array($contact_name,$isview,$home_phone,$office_phone,$mobile,$relationship,$userid));
			return 1;
		 }    
        }
 }  

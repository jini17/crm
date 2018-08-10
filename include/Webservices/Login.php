<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
	
	function vtws_login($username,$pwd){
		
		global $short_url;
		
		$user = new Users();
		$userId = $user->retrieve_user_id($username);
		
		$token = vtws_getActiveToken($userId);
		if($token == null){
			throw new WebServiceException(WebServiceErrorCode::$INVALIDTOKEN,"Specified token is invalid or expired");
		}
		
		$accessKey = vtws_getUserAccessKey($userId);
		if($accessKey == null){
			throw new WebServiceException(WebServiceErrorCode::$ACCESSKEYUNDEFINED,"Access key for the user is undefined");
		}
		
		$accessCrypt = md5($token.$accessKey);
		if(strcmp($accessCrypt,$pwd)!==0){
			throw new WebServiceException(WebServiceErrorCode::$INVALIDUSERPWD,"Invalid username or password");
		}
		$user = $user->retrieveCurrentUserInfoFromFile($userId);
		if($user->status != 'Inactive'){
			
			//Insert  into vtiger_loginhistory for webservice login call
			$browser = Settings_MaxLogin_Module_Model::browserDetect();	
			$moduleModel = Users_Module_Model::getInstance('Users');
			
			if($_SERVER['HTTP_HOST']==$short_url || $_SERVER['HTTP_HOST']=='localhost' 
				|| stripos($_SERVER['HTTP_HOST'],'192.168.2.') !==false) { 
				$usip=$_SERVER['REMOTE_ADDR'];	//add one more param IP address by jitu@28Dec2016
			} else {
				$usip=$_SERVER['REMOTE_ADDR'];	//add one more param IP address by jitu@28Dec2016	
			}
			
			$moduleModel->saveLoginHistory($username,'Signed in', 'WS Call', $usip);
			//end here
			
			return $user;
		}
		throw new WebServiceException(WebServiceErrorCode::$AUTHREQUIRED,'Given user is inactive');
	}
	
	function vtws_getActiveToken($userId){
		global $adb;
		
		$sql = "select token from vtiger_ws_userauthtoken where userid=? and expiretime >= ?";
		$result = $adb->pquery($sql,array($userId,time()));
		if($result != null && isset($result)){
			if($adb->num_rows($result)>0){
				return $adb->query_result($result,0,"token");
			}
		}
		return null;
	}
	
	function vtws_getUserAccessKey($userId){
		global $adb;
		
		$sql = "select accesskey from vtiger_users where id=?";
		$result = $adb->pquery($sql,array($userId));
		if($result != null && isset($result)){
			if($adb->num_rows($result)>0){
				return $adb->query_result($result,0,"accesskey");
			}
		}
		return null;
	}
	
?>
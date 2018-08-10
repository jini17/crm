<?php

/**
 * Description of Second CRM Login/Logout History
 *
 * @author jitu 
 */

 function vtws_loginhistory($username, $type,$userIPAddress, $browser) { 
	
	global $adb;
		
		if($browser==null){
			
			$browser = Settings_MaxLogin_Module_Model::browserDetect();	
		}
		if($type=='Login') {

			$loginTime = date("Y-m-d H:i:s");
	       		$query = "INSERT INTO vtiger_loginhistory (user_name, user_ip, logout_time, login_time, status, browser) VALUES (?,?,?,?,?,?)";
			$params = array($username, $userIPAddress, '0000-00-00 00:00:00',  $loginTime, 'Signed in', $browser);
			$result = $adb->pquery($query, $params);
			if($result)
				return array($userIPAddress);

		} else {
			$outtime = date("Y-m-d H:i:s");
			$loginIdQuery = "SELECT MAX(login_id) AS login_id FROM vtiger_loginhistory WHERE user_name=? AND user_ip=?";
			$result = $adb->pquery($loginIdQuery, array($username, $userIPAddress));
			$loginid = $adb->query_result($result,0,"login_id");

			if (!empty($loginid)){
				$query = "UPDATE vtiger_loginhistory SET logout_time =?, status=? WHERE login_id = ?";
				$result = $adb->pquery($query, array($outtime, 'Signed off', $loginid));
			} 
			return array("Logout successfull");		
		}
		
 }

?>

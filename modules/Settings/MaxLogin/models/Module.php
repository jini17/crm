<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
class Settings_MaxLogin_Module_Model extends Settings_Vtiger_Module_Model {
	public function getConfig() {
		$db = PearDatabase::getInstance();
		$result = $db->query("SELECT * FROM vtiger_maxlogin", true);
		for($i = 0; $i < $db->num_rows($result); $i++){
			$output[] = $db->query_result($result, $i, 'value');
		}
		return $output;
	}

	static public function getBruteForceSettings() {
		$db = PearDatabase::getInstance();
		$result = $db->query("SELECT * FROM vtiger_maxlogin", true);
		$output = $db->query_result_rowdata($result, 0);
		return $output;
	}    

	static public function getBlockedUsers() {		
		$db = PearDatabase::getInstance();
		$bruteforceSettings = self::getBruteForceSettings();
		$attempsNumber = $bruteforceSettings[0];

		$userquery = "SELECT distinct user_name FROM `vtiger_loginhistory` WHERE `status` = 'Failed login' ORDER BY `login_time`";
		$result = $db->pquery($userquery, array());
		$output = array();		
	
		for ($i=0; $i < $db->num_rows($result); $i++) {  
			$counter = 0;    
			$username = $db->query_result($result, $i, 'user_name');
			$query = "SELECT status, user_ip, login_time, browser
				FROM vtiger_loginhistory WHERE user_name = ? AND unblock=0 
				ORDER BY login_time DESC "; 			
		
			$resultrow = $db->pquery($query, array($username));
			$counts = $db->num_rows($resultrow);
			
			if($counts > 0) {
				$userips = array();
				$logintime = array();
				$browser = array();
				for($j=0;$j<$counts;$j++) {
					$status = $db->query_result($resultrow, $j, 'status');	
					if($status =='Failed login'){
						$counter++;
						$userips[] = $db->query_result($resultrow, $i, 'user_ip');
						$logintime[] = $db->query_result($resultrow, $i, 'login_time');
						$browser[] = $db->query_result($resultrow, $i, 'browser');
						
					} else {	
						break 1;
					}
				}
				if($counter >= $attempsNumber) { 
					$output[$i]['userips']	= implode(', ',array_unique($userips));
					$output[$i]['username']	= $username;
					$output[$i]['date'] 	= implode(', ',array_unique($logintime));
					$output[$i]['browsers']	= implode(', ',array_unique($browser));
				}
  			}
		
		}	
		return $output;
	}

	static public function browserDetect() {
	   
		$browser = $_SERVER['HTTP_USER_AGENT'];
	   
		if(strpos($browser, 'MSIE') !== FALSE)
		   return 'Internet explorer';
		 elseif(strpos($browser, 'Trident') !== FALSE) //For Supporting IE 11
			return 'Internet explorer';
		 elseif(strpos($browser, 'Firefox') !== FALSE)
		   return 'Mozilla Firefox';
		 elseif(strpos($browser, 'Chrome') !== FALSE)
		   return 'Google Chrome';
		 elseif(strpos($browser, 'Opera Mini') !== FALSE)
		   return "Opera Mini";
		 elseif(strpos($browser, 'Opera') !== FALSE)
		   return "Opera";
		 elseif(strpos($browser, 'Safari') !== FALSE)
		   return "Safari";
		 else
		   return 'unknow';       
	}

	static public function checkBlocked($username) {
		$db = PearDatabase::getInstance();

		$query = "SELECT * FROM `vtiger_maxlogin` LIMIT 1";    
		$result = $db->pquery($query, array());
		$ip = $_SERVER['REMOTE_ADDR'];
		$now = date("Y-m-d H:i:s");

		$bruteforceSettings =  $db->query_result_rowdata($result, 0);
		$attempsNumber = $bruteforceSettings[0];
		$blockTime = $bruteforceSettings[1];

		$query = "SELECT status FROM vtiger_loginhistory WHERE user_name = ? AND unblock=0
			ORDER BY login_time DESC "; 			
		$result = $db->pquery($query, array ($username) );
		$counts = $db->num_rows($result);
		$counter = 0;
		if($counts > 0) {
			for($i=0;$i<$counts;$i++) {
				$status = $db->query_result($result, $i, 'status');	
				if($status =='Failed login'){
					$counter++;
				} else {	
					break 1;
				}
			}
			
			if($counter >= $attempsNumber) return true; 
		} else {
			return false;
		}		
	}	
}

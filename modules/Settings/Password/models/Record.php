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
class Settings_Password_Record_Model extends Vtiger_Record_Model {
	public function getPassDetail($type = false) {
		$db = PearDatabase::getInstance();
		$sql = 'SELECT * FROM vtiger_password';
		$p = array();
		if($type){
			$sql .= " WHERE type = ?";
			$p = array($type);
		}
		$result = $db->pquery($sql,$p, true);
		for($i = 0; $i < $db->num_rows($result); $i++){
			$resp[$db->query_result($result, $i, 'type')] =  $db->query_result($result,$i, 'val');
		}
		return $resp;
	}
	public function setPassDetail($type,$vale) {
		$db = PearDatabase::getInstance();
		$result = $db->pquery("UPDATE vtiger_password SET `val` = ? WHERE `type` = ?",array($vale,$type), true);
	}

	public function validation($type,$vale) {
		if($type == 'min_length' || $type == 'max_length' || $type == 'pwd_exp' || $type == 'pwd_reuse'){
			return is_numeric($vale) || empty($vale);
		}
		if($type == 'big_letters' || $type == 'small_letters' || $type == 'numbers' || $type == 'special'){
			if( $vale == false || $vale == true){
				return true;
			}else{
				return false;
			}
			
		}
	}
	public function checkPassword($pass) {
		$conf = self::getPassDetail();
		$moduleName = 'Password';
		if ( strlen($pass) > $conf['max_length'] && $conf['max_length'] !='') {
			return vtranslate("Maximum password length", $moduleName).' '.$conf['max_length'].' '.vtranslate("characters", $moduleName);
		}
		if ( strlen($pass) < $conf['min_length'] && $conf['min_length'] !='') {
			return vtranslate("Minimum password length", $moduleName).' '.$conf['min_length'].' '.vtranslate("characters", $moduleName);
		}
		if ($conf['numbers'] == 'true' && !preg_match("#[0-9]+#", $pass)) {
			return vtranslate("Password should contain numbers", $moduleName);
		}
		if ($conf['big_letters'] == 'true' && !preg_match("#[A-Z]+#", $pass)) {
			return vtranslate("Uppercase letters from A to Z", $moduleName);
		}
		if ($conf['small_letters'] == 'true' && !preg_match("#[a-z]+#", $pass)) {
			return vtranslate("Lowercase letters a to z", $moduleName);
		}
		if ($conf['special'] == 'true' && !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $pass)) {
			return vtranslate("Password should contain special characters", $moduleName);
		}
		return false;
	}

	public function PasswordValidity($type,$username,$password) {
		
		$db = PearDatabase::getInstance();
		$conf = self::getPassDetail($type);
		$flag = 'N';

		$password = strtolower(md5($password));
		if($type == 'pwd_exp' && $conf['pwd_exp'] !='') {
			$query = "SELECT tblVTU.date_entered, tblSCAB.changedon,tblSCAB.recordid FROM vtiger_users tblVTU 
			LEFT JOIN secondcrm_admintracker_basic tblSCAB ON tblSCAB.recordid = tblVTU.id AND tblSCAB.status = 'Password Updated' WHERE tblVTU.user_name = ? AND tblVTU.user_hash = ? ORDER BY tblSCAB.changedon DESC LIMIT 0,1";	
			
			$result = $db->pquery($query,array($username,$password));

			if($db->num_rows($result) > 0) {

				$createtime = $db->query_result($result, 0, 'date_entered');
				$changedon = $db->query_result($result, 0, 'changedon');
				$lastmodified = is_null($changedon)?$createtime:$changedon;
				$now = time(); 
				$your_date = strtotime($lastmodified);
				$days = floor(($now - $your_date)/(60*60*24));
				if($days > $conf[$type]) {
					$flag =  1;
				} else {
					$flag =  2;
				}	

			} else {
				$flag =  0;
			}	
		} else if($type == 'pwd_reuse' && $conf['pwd_reuse'] !=' '){

			$query = "SELECT tblSCAD.postvalue FROM vtiger_users tblVTU 
			LEFT JOIN secondcrm_admintracker_basic tblSCAB ON tblSCAB.recordid = tblVTU.id AND tblSCAB.status = 'Password Updated' 
			LEFT JOIN secondcrm_admintracker_detail tblSCAD ON tblSCAD.id = tblSCAB.id
WHERE tblVTU.id = ? ORDER BY tblSCAB.changedon DESC LIMIT 0, ".$conf[$type];
			$result = $db->pquery($query,array($username));
			
			if($db->num_rows($result) > 0) {
				for($i = 0; $i < $db->num_rows($result); $i++){
					$dbpwd = $db->query_result($result,$i, 'postvalue');
					
					if($dbpwd ==$password) { 
						$flag = 1;
						break 1;	
					}
				}
			}
		}
		return $flag;
   	}
}

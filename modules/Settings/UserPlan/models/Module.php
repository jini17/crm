
<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 30/03/2018
 *************************************************************************************/

class Settings_UserPlan_Module_Model extends Vtiger_Module_Model {
	function getUsers(){
		$db = PearDatabase::getInstance();
		$sql = $db->pquery('SELECT vtiger_users.id, user_name, rolename, group_concat(plantitle) as plantitle ,secondcrm_plan.planid FROM secondcrm_plan LEFT JOIN secondcrm_userplan ON secondcrm_userplan.planid = secondcrm_plan.planid RIGHT JOIN vtiger_users ON vtiger_users.id = secondcrm_userplan.userid LEFT JOIN vtiger_user2role ON vtiger_user2role.userid = vtiger_users.id RIGHT JOIN vtiger_role ON vtiger_role.roleid = vtiger_user2role.roleid WHERE user_name <> "admin" group by user_name',array());
		$numOfRows = $db->num_rows($sql);
		$users = array();
		for($i=0; $i< $numOfRows;$i++){
			$users[$i]['name'] = $db->query_result($sql,$i,'user_name');
			$users[$i]['id'] = $db->query_result($sql,$i,'id');
			$users[$i]['planid'] = $db->query_result($sql,$i,'planid');
			$users[$i]['plantitle'] = str_replace(',','+',$db->query_result($sql,$i,'plantitle'));
			$users[$i]['role'] = $db->query_result($sql,$i,'rolename');
		}
		return $users;
	}

	function getPlan(){
		$db = PearDatabase::getInstance();
		$plan = array();
		$sql = $db->pquery('SELECT COUNT(userid) as users,nousers,plantitle, secondcrm_plan.planid FROM secondcrm_plan LEFT JOIN secondcrm_userplan ON secondcrm_userplan.planid = secondcrm_plan.planid  GROUP BY plantitle',array());
		$numOfRows = $db->num_rows($sql);
		for($i=0; $i< $numOfRows;$i++){
			$plan[$i]['plantitle'] = $db->query_result($sql,$i,'plantitle');
			$plan[$i]['planid'] = $db->query_result($sql,$i,'planid');
			$plan[$i]['nousers'] = $db->query_result($sql,$i,'nousers');
			$plan[$i]['users'] = $db->query_result($sql,$i,'users');
		}
		return $plan;
	}

	function getAllRole($planid){
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$role = array();
		if($planid==5){
			$sql = $db->pquery('SELECT roleid, rolename FROM vtiger_role WHERE planid IN (2, 3)',array());
		} else {
			$sql = $db->pquery('SELECT roleid, rolename FROM vtiger_role WHERE planid=?',array($planid));
		}
		$numOfRows = $db->num_rows($sql);
		for($i=0; $i< $numOfRows;$i++){
			$role[$i]['roleid'] = $db->query_result($sql,$i,'roleid');
			$role[$i]['rolename'] = $db->query_result($sql,$i,'rolename');
			
		}
		return $role;
	}
	function getFilteredPlan(){
		$db = PearDatabase::getInstance();
		$plan = array();
		$planTitle = array();
		$sql = $db->pquery('SELECT COUNT(userid) as users,nousers,plantitle,isactive,secondcrm_plan.planid FROM secondcrm_plan LEFT JOIN secondcrm_userplan ON secondcrm_userplan.planid = secondcrm_plan.planid GROUP BY plantitle',array());
		$numOfRows = $db->num_rows($sql);
		for($i=0; $i< $numOfRows;$i++){
			$plan[$i]['plantitle'] = $db->query_result($sql,$i,'plantitle');
			$plan[$i]['nousers'] = $db->query_result($sql,$i,'nousers');
			$plan[$i]['users'] = $db->query_result($sql,$i,'users');
			$plan[$i]['planid'] = $db->query_result($sql,$i,'planid');
			$plan[$i]['balance'] = $plan[$i]['nousers'] - $plan[$i]['users'];
			$plan[$i]['isactive'] = $db->query_result($sql,$i,'isactive');

			if ($plan[$i]['nousers'] == $plan[$i]['users'] || $plan[$i]['isactive'] == 0 || $plan[$i]['nousers'] == 0){
				unset($plan[$i]);
			}			
		}
		return $plan;
	}
	//Added by danial 12/04/2018
	// function getUserRole(){
	// 	$db = PearDatabase::getInstance();
	// 	//$db->setDebug(true);
	// 	$role = array();
	// 	$sql = $db->pquery('SELECT rolename,vtiger_role.planid FROM vtiger_role LEFT JOIN secondcrm_plan ON vtiger_role.planid = secondcrm_plan.planid',array());
	// 	$numOfRows = $db->num_rows($sql);
	// 	for($i=0; $i< $numOfRows;$i++){
	// 		$role[$i]['role'] = $db->query_result($sql,$i,'rolename');
			
	// 	}
	// 	//echo '<pre>';print_r($role);die;
	// 	return $role;
	// }	
}

?>
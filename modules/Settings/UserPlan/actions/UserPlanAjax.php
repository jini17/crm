<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 02/04/2018
 *************************************************************************************/

Class Settings_UserPlan_UserPlanAjax_Action extends Settings_Vtiger_IndexAjax_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('updatePlan');	}

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	public function updatePlan(Vtiger_Request $request){
		$newPlan = $request->get('newPlan'); 
		$oldPlan = $request->get('oldPlan');
		$userid  = $request->get('userid');
		$roleid	 = $request->get('role');

		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$sql = $db->pquery('UPDATE secondcrm_userplan SET planid = ? WHERE userid = ?' ,array($newPlan,$userid));
		$plan = array();
		$oldPlanUpdate = '';
		$newPlanUpdate = '';
		//$db->pquery("")

		$sql2 = $db->pquery('SELECT COUNT(userid) as users,nousers,secondcrm_plan.planid FROM secondcrm_plan 
			LEFT JOIN secondcrm_userplan ON secondcrm_userplan.planid = secondcrm_plan.planid GROUP BY plantitle',array());
		$numOfRows = $db->num_rows($sql2);
		for($i=0; $i< $numOfRows;$i++){
			$plan[$i]['planid'] = $db->query_result($sql2,$i,'planid');
			$plan[$i]['nousers'] = $db->query_result($sql2,$i,'nousers');
			$plan[$i]['users'] = $db->query_result($sql2,$i,'users');

			if ($plan[$i]['planid'] == $oldPlan){
				$oldPlanUpdate = $plan[$i]['users'] . "/" . $plan[$i]['nousers'];
			}

			if ($plan[$i]['planid'] == $newPlan){
				$newPlanUpdate = $plan[$i]['users'] . "/" . $plan[$i]['nousers'];
			}
		}
		//start for role update

		$db->pquery("DELETE from secondcrm_userplan WHERE userid=?", array($userid));
		if($newPlan ==5) { 
			$db->pquery("INSERT INTO secondcrm_userplan(userid, planid) VALUES(?,?)", array($userid, 2));
			$db->pquery("INSERT INTO secondcrm_userplan(userid, planid) VALUES(?,?)", array($userid, 3));	
		} else {
			$db->pquery("INSERT INTO secondcrm_userplan(userid, planid) VALUES(?,?)", array($userid, $newPlan));
		}	
		$db->pquery("update vtiger_user2role set roleid=? where userid=?",array($roleid, $userid)); 

		//end here 
		$response = new Vtiger_Response();
		$response->setResult(array( 'success' => true, 'newPlanUpdate' => $newPlanUpdate, 'oldPlanUpdate' => $oldPlanUpdate));
		$response->emit(); 
	}	

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.Index"
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
?>	

<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 24/05/2018
 ************************************************************************************/

class Settings_LoginHistory_ShowUpdates_View extends Settings_Vtiger_List_View{
	
	function postProcess(Vtiger_Request $request) {
		return false;
	}

	public function process(Vtiger_Request $request) {

		$qualifiedName = $request->getModule(false);
		$sessionId = $request->get('sessionId');

		$viewer = $this->getViewer($request);
		$viewer->assign('DATA',$this->showActivities($sessionId));
		$viewer->view('showUpdates.tpl',$qualifiedName); 
		
		//$response = $this->showActivities($sessionId); print_r($response);

    }

	/**
	 * Added to support Engagements view in Vtiger7
	 * @param Vtiger_Request $request
	 */
	function showActivities($session_id){
		global $adb; //$adb->setDebug(true);
		$result = $adb->pquery("SELECT * FROM vtiger_modtracker_basic WHERE session_id = ? AND status IN (0,1,2) ORDER BY changedon DESC",array($session_id));
		$numOfRows = $adb->num_rows($result);
		$data = array();

		for ($i = 0; $i < $numOfRows; $i++) {			
			$data[$i]['id'] = $id = $adb->query_result($result, $i, "id");			
			$data[$i]['changedon'] = $changedon = date('d-m-Y H:i:s',strtotime($adb->query_result($result, $i, "changedon")));
			$data[$i]['module'] = $module = $adb->query_result($result, $i, "module");


			$whodid = $adb->query_result($result, $i, "whodid");		
			$crmid = $adb->query_result($result, $i, "crmid");

			$status = $adb->query_result($result, $i, "status");
			if ($status == 0) {
				$data[$i]['status'] = "Modified";
				$resultForModification = $adb->pquery("SELECT fieldname,prevalue,postvalue FROM vtiger_modtracker_detail WHERE id = ?", array($id));
				$countRows = $adb->num_rows($resultForModification);
				$modificationData = array();
				
				for ($j = 0; $j < $countRows; $j++){
					$fieldname = $adb->query_result($resultForModification, $j, "fieldname"); 
					$prevalue = $adb->query_result($resultForModification, $j, "prevalue");
					$postvalue = $adb->query_result($resultForModification, $j, "postvalue");
					$modificationData[$j]['fieldname'] = $fieldname;
					$modificationData[$j]['prevalue'] = $prevalue;
					$modificationData[$j]['postvalue'] = $postvalue;
				}

				$data[$i]['modificationData'] = $modificationData;

			}
				
			else if ($status == 1) 
				$data[$i]['status'] = "Deleted";
				
			else if ($status == 2)
				$data[$i]['status'] = "Created";					
			
			$result2 = $adb->pquery("SELECT tablename, fieldname,  entityidfield  FROM vtiger_entityname WHERE modulename = ?", array($module));
			$tablename = $adb->query_result($result2, 0, 'tablename');
			$fieldname = $adb->query_result($result2, 0, 'fieldname');
			$entityfield = $adb->query_result($result2, 0, 'entityidfield'); 
	
			if (strpos($fieldname,",")){
				$columns = explode(",", $fieldname); 
				$resultentity = $adb->pquery("SELECT concat($columns[0],' ', $columns[1]) AS name FROM $tablename INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $tablename.$entityfield WHERE $tablename.$entityfield = ?", array($crmid));
				$data[$i]['name'] = $name = $adb->query_result($resultentity, 0, 'name');
			}
			else {
				$resultentity = $adb->pquery("SELECT $fieldname FROM $tablename INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $tablename.$entityfield WHERE $tablename.$entityfield = ?", array($crmid));
				$data[$i]['name'] = $name = $adb->query_result($resultentity, 0, $fieldname);
			}			
		}
	return $data;	
	}
}

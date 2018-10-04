<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_RelatedRecordsAjax_Action extends Vtiger_Action_Controller {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('getRelatedRecordsCount');
	}

	function checkPermission(Vtiger_Request $request) {
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		if (!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/**
	 * Function to get count of all related module records of a given record
	 * @param type $request
	 */
	function getRelatedRecordsCount($request) {
		$parentRecordId = $request->get("recordId");
		$parentModule = $request->get("module");
		$parentModuleModel = Vtiger_Module_Model::getInstance($parentModule);
		$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentRecordId, $parentModuleModel);
		$relationModels = $parentModuleModel->getRelations();
		$relatedRecordsCount = array();
		
		foreach ($relationModels as $relation) {
			$relationId = $relation->getId();
			$relatedModuleName = $relation->get('relatedModuleName');
			if($relatedModuleName =='ClaimType'){ 
					$db = PearDatabase::getInstance();
					$result = $db->pquery("SELECT job_grade FROM vtiger_employeecontract WHERE employeecontractid=?", array($parentRecordId));
					$grade_id = $db->query_result($result, 0, 'job_grade');
					$year = date('Y');
				
					$relationQuery = "SELECT count(vtiger_claimtype.claim_type) as 'count' FROM vtiger_claimtype 	
					LEFT JOIN allocation_claimrel ON allocation_claimrel.claim_id=vtiger_claimtype.claimtypeid
					LEFT JOIN allocation_list ON allocation_list.allocation_id=allocation_claimrel.allocation_id
					WHERE allocation_claimrel.grade_id='$grade_id' AND allocation_list.allocation_year='$year'";
					$result = $db->pquery($relationQuery, array());
					$relatedRecordsCount[$relationId] = $db->query_result($result, 0, 'count');

				} else {	
					$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $relatedModuleName, $relation->get('label'));
					$count = $relationListView->getRelatedEntriesCount();
					$relatedRecordsCount[$relationId] = $count;
				}	
				
		}
		$response = new Vtiger_Response();
		$response->setResult($relatedRecordsCount);
		$response->emit();
	}

}

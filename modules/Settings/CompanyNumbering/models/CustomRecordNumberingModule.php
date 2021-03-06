<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_CompanyNumbering_CustomRecordNumberingModule_Model extends Vtiger_Module_Model {

	/**
	 * Function to get focus of this object
	 * @return <type>
	 */
	public function getFocus() {
		if (!$this->focus) {
			$this->focus = CRMEntity::getInstance($this->getName());
		}
		return $this->focus;
	}

	/**
	 * Function to get Instance of this module
	 * @param <String> $moduleName
	 * @return <Settings_Vtiger_CustomRecordNumberingModule_Model> $moduleModel
	 */
	public static function getInstance($moduleName, $tabId = false) {
		$moduleModel = new self();
		$moduleModel->name = $moduleName;
		if ($tabId) {
			$moduleModel->id = $tabId;
		}
		return $moduleModel;
	}

	/**
	 * Function to ger Supported modules for Custom record numbering
	 * @return <Array> list of supported modules <Vtiger_Module_Model>
	 */
	public static function getSupportedModules() {
		$db = PearDatabase::getInstance();
		//added Payments module in sql by jitu@SERREQ2369
		$sql = "SELECT tabid, name FROM vtiger_tab WHERE (isentitytype = ? OR name='Payments') AND presence = ? AND tabid IN (SELECT DISTINCT tabid FROM vtiger_field WHERE uitype = ?)";
		$result = $db->pquery($sql, array(1, 0, 4));
		$numOfRows = $db->num_rows($result);

		for($i=0; $i<$numOfRows; $i++) {
			$tabId = $db->query_result($result, $i, 'tabid');
			$modulesModels[$tabId] = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getInstance($db->query_result($result, $i, 'name'), $tabId);
		}

		return $modulesModels;
	}

	/**
	* Function to check is It support Multiple Company Feature or not
	* @return boolean True/False
	*/
	public static function getSupportMultipleCompany() {
		$db = PearDatabase::getInstance();
		$sql = "SELECT business FROM secondcrm_companynumbering";
		$result = $db->pquery($sql,array());
		$Business = $db->query_result($result, 0, 'business');
		return $Business;
	}

	/**
	 * Function to get module custom numbering data
	 * @return <Array> data of custom numbering data
	 */
	public function getModuleCustomNumberingData($sourceCompany=1) {
		
		$moduleInfo = $this->getFocus()->getModuleSeqInfo($this->getName(),$sourceCompany);
		//end
		return array(
				'prefix' => $moduleInfo[0],
				'sequenceNumber' => $moduleInfo[1]
		);
	}
	
	/**
	 * Function to set Module sequence
	 * @return <Array> result of success
	 */
	public function setModuleSequence($sourceCompany) {
		$moduleName = $this->getName();
		$prefix = $this->get('prefix');
		$sequenceNumber = $this->get('sequenceNumber');
		$status = $this->getFocus()->setModuleSeqNumber('configure', $moduleName, $prefix, $sequenceNumber,$sourceCompany);
		$success = array('success' => $status);
		if (!$status) {
			$db = PearDatabase::getInstance();
			$result = $db->pquery("SELECT cur_id FROM vtiger_modentity_num WHERE semodule = ? AND prefix = ? AND organization_id = ?", array($moduleName, $prefix,$sourceCompany));
			$success['sequenceNumber'] = $db->query_result($result, 0, 'cur_id');
		}

		return $success;
	}

	/**
	* Function to update record sequences which are under this module
	* @return <Array> result of success
	*/
	public function updateRecordsWithSequence($company) {
		return $this->getFocus()->updateMissingSeqNumber($this->getName(),$company);
	}

	/**
	* Added by afiq@secondcrm.com on 7/23/2014 for Multiple Company Numbering Setting
	*/
	public static function getCompanyList() {
		$db = PearDatabase::getInstance();

		$aCompanyList = array();
		$iOptionIndex = 0;
		$query1 = 'SELECT organization_id, organization_title FROM vtiger_organizationdetails ORDER BY organization_id';
		$result1 = $db->pquery($query1, array());
		$iMaxServer = $db->num_rows($result1);
		for($iK=0;$iK<$iMaxServer;$iK++)
		{
			$iOptionIndex++;
			
			$aCompanyList[$iOptionIndex]['id'] = $db->query_result($result1,$iK,'organization_id');
			$aCompanyList[$iOptionIndex]['title'] = $db->query_result($result1,$iK,'organization_title');
		}
		
		return $aCompanyList;
	}//End
	
	//Added by afiq@secondcrm.com on 7/23/2014 for Multiple Company Numbering Setting
	public static function getCompanyNumberingSetting() {
		$db = PearDatabase::getInstance();
		$query = "SELECT business FROM secondcrm_companynumbering";
		$result = $db->pquery($query, array());
		$isFlagCompanyNumbering = $db->query_result($result,0,'business');
		if($isFlagCompanyNumbering==1){
			return 1;
		} else {
			return 0;
		}
	}
}

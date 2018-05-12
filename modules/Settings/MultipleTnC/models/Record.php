<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

require_once 'include/events/include.inc';

/**
 * Term & Condition Record Model Class
 */
class Settings_MultipleTnC_Record_Model extends Settings_Vtiger_Record_Model {

	/**
	 * Function to get the Id
	 * @return <Number> MultipleTnC Id
	 */
	public function getId() {
		return $this->get('id');
	}

	/**
	 * Function to set the Id
	 * @param <Number> MultipleTnC Id
	 * @return <Settings_MultipleTnC_Reord_Model> instance
	 */
	public function setId($id) {
		return $this->set('id', $id);
	}

	/**
	 * Function to get the MultipleTnC Title
	 * @return <String>
	 */
	public function getName() {
		return $this->get('title');
	}

	/**
	 * Function to get the description of the MultipleTnC
	 * @return <String>
	 */
	public function getDescription() {
		return $this->get('tandc');
	}

	/**
	 * Function to get the Edit View Url for the MultipleTnC
	 * @return <String>
	 */
	public function getEditViewUrl() {
		return '?module=MultipleTnC&parent=Settings&view=Edit&record='.$this->getId();
	}
z
	/**
	 * Function to get the Delete Action Url for the current group
	 * @return <String>
	 */
	public function getDeleteActionUrl() {
		return 'index.php?module=MultipleTnC&parent=Settings&view=DeleteAjax&record='.$this->getId();
	}
    
    /**
	 * Function to get the Detail Url for the current group
	 * @return <String>
	 */
    public function getDetailViewUrl() {
        return '?module=MultipleTnC&parent=Settings&view=Detail&record='.$this->getId();
    }

	/**
	 * Function to get the instance of Groups record model from query result
	 * @param <Object> $result
	 * @param <Number> $rowNo
	 * @return Settings_Groups_Record_Model instance
	 */
	public static function getInstanceFromQResult($result, $rowNo) {
		$db = PearDatabase::getInstance();
		$row = $db->query_result_rowdata($result, $rowNo);
		$tnc = new self();
		return $tnc->setData($row);
	}

	/**
	 * Function to get all the groups
	 * @return <Array> - Array of Settings_Groups_Record_Model instances
	 */
	public static function getAll() {
		$db = PearDatabase::getInstance();

		$sql = 'SELECT * FROM vtiger_inventory_tandc';
		$params = array();
		$result = $db->pquery($sql, $params);
		$noOfGroups = $db->num_rows($result);
		$TermnCondition = array();
		for ($i = 0; $i < $noOfGroups; ++$i) {
			$TnC = self::getInstanceFromQResult($result, $i);
			$TermnCondition[$TnC->getId()] = $TnC;
		}
		return $TermnCondition;
	}

	/**
	 * Function to get the instance of Group model, given group id or name
	 * @param <Object> $value
	 * @return Settings_Groups_Record_Model instance, if exists. Null otherwise
	 */
	public static function getInstance($value) {
		$db = PearDatabase::getInstance();
		$sql = 'SELECT * FROM vtiger_inventory_tandc WHERE id = ?';
		
		$params = array($value);
		$result = $db->pquery($sql, $params);
		if ($db->num_rows($result) > 0) {
			return self::getInstanceFromQResult($result, 0);
		}
		return null;
	}
	
	/* Function to get the instance of the TermNCondition by Name
    * @param type $name -- name of the group
    * @return null/TermNCondition instance
    */
   public static function getInstanceByName($name, $excludedRecordId = array()) {
       $db = PearDatabase::getInstance();
       $sql = 'SELECT * FROM vtiger_inventory_tandc WHERE title=?';
       $params = array($name);
	   
       if(!empty($excludedRecordId)){
           $sql.= ' AND id NOT IN ('.generateQuestionMarks($excludedRecordId).')';
           $params = array_merge($params,$excludedRecordId);
       }
	   
       $result = $db->pquery($sql, $params);
       if($db->num_rows($result) > 0) {
		   return self::getInstanceFromQResult($result, 0);
	   }
	   return null;
   }

}

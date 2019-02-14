<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ManageDiscount_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'secondcrm_discount2role';
	var $baseIndex = 'id';
	var $listFields = array('sequence' => 'Sequence', 'discount_title' => 'Discount Title', 'discount_value' => 'Discount Value', 'discount_status' => 'Status','discount_level' => 'Discount Level');
	var $nameFields = array('');
	var $name = 'ManageDiscount';

	/**
	 * Function to get editable fields from this module
	 * @return <Array> List of fieldNames
	 */
	public function getEditableFieldsList() {
		return array('value', 'status');
	}

	/**
	 * Function to update sequence of several records
	 * @param <Array> $sequencesList
	 */
	public function updateSequence($sequencesList) {
		$db = PearDatabase::getInstance();

		$updateQuery = "UPDATE secondcrm_discount2role SET sequence = CASE";

		foreach ($sequencesList as $sequence => $recordId) {
			$updateQuery .= " WHEN id = $recordId THEN $sequence ";
		}
		$updateQuery .= " END";
		//echo $updateQuery;
		$db->pquery($updateQuery, array());
	}
	
	public function hasCreatePermissions() {
		return false;
	}
	
	public function isPagingSupported() {
		return false;
	}

}

<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'modules/Vtiger/CRMEntity.php';

class Claim extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_claim';
	var $table_index= 'claimid';

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_claimcf', 'claimid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'vtiger_claim', 'vtiger_claimcf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_claim' => 'claimid',
		'vtiger_claimcf'=>'claimid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Claim No ' => Array('claim', 'claimno'),
		'Assigned To' => Array('crmentity','smownerid')
	);
	var $list_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Claim No ' => 'claimno',
		'Assigned To' => 'assigned_user_id',
	);

	// Make the field link to detail view
	var $list_link_field = 'claimno';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Claim No ' => Array('claim', 'claimno'),
		'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
	);
	var $search_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Claim No ' => 'claimno',
		'Assigned To' => 'assigned_user_id',
	);

	// For Popup window record selection
	var $popup_fields = Array ('claimno');

	// For Alphabetical search
	var $def_basicsearch_col = 'claimno';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'claimno';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('claimno','assigned_user_id');

	var $default_order_by = 'claimno';
	var $default_sort_order='ASC';

	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
	function vtlib_handler($moduleName, $eventType) {
		global $adb;
 		if($eventType == 'module.postinstall') {
			// TODO Handle actions after this module is installed.
		} else if($eventType == 'module.disabled') {
			// TODO Handle actions before this module is being uninstalled.
		} else if($eventType == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
			// TODO Handle actions after this module is updated.
		}
 	}

 	/*function save_module($module) {

 		$this->insertIntoAttachment($this->id,$module);

 		$db = PearDatabase::getInstance();
 		$currentUser 	= Users_Record_Model::getCurrentUserModel();

		$claimassign	= $_REQUEST['assigned_user_id'];
		$claimId		= $_REQUEST['category'];	
		$claimamount 	= $_REQUEST['totalamount'];	

		$result 		= $db->pquery("SELECT date_joined, job_grade FROM vtiger_employeecontract 
				INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_employeecontract.employeecontractid
				WHERE vtiger_crmentity.deleted=0 AND vtiger_crmentity.smownerid=? ORDER BY vtiger_crmentity.createdtime DESC Limit 0, 1", array($claimassign));
		if($db->num_rows($result)>0){
			$date_joined = $db->query_result($result, 0, 'date_joined');
			$job_grade = $db->query_result($result, 0, 'job_grade');

		} 
		
		$datediff = time() - strtotime($date_joined);
		$age = round($datediff / (60 * 60 * 24));

		if($date_joined=='' OR $date_joined==null){
			$age = 0;
		} 

		//fetch formula for Claim amount allocation table
		$resultclaim = $db->pquery("SELECT if(age_claim < $age, claimamountless, claimamountmore) as claim_amount FROM allocation_list WHERE claimtype_id	=? AND status='on' AND grade_id=?", array($claimId, $job_grade));
		if($db->num_rows($resultclaim)>0){ 
			$claimamount = $db->query_result($resultclaim, 0, 'claim_amount');
		} 
		$db->pquery("UPDATE vtiger_claim SET totalamount=? WHERE claimid=?", array($claimamount, $this->id));

	}*/

/*	function insertIntoAttachment($id,$module)
	{
		global $log, $adb;
		//$adb->setDebug(true);
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");

		$file_saved = false;

		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$files['original_name'] = vtlib_purify($_REQUEST[$fileindex.'_hidden']);
				//echo $this->column_fields['filelocationtype'];die;
				$file_saved = $this->uploadAndSaveFile($id,$module,$files,'Attachment');
			   $adb->pquery("UPDATE vtiger_claim SET attachment=? WHERE claimid=?",array($files['name'],$this->id));
			}
		}
		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}*/
}
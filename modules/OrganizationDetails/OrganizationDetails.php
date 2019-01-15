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

class OrganizationDetails extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_organizationdetails';
	var $table_index= 'organization_id';

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_organizationdetailscf', 'organization_id');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'vtiger_organizationdetails', 'vtiger_organizationdetailscf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_organizationdetails' => 'organization_id',
		'vtiger_organizationdetailscf'=>'organization_id');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Organization No' => Array('organizationdetails', 'organization_title'),
		'Assigned To' => Array('crmentity','smownerid')
	);
	var $list_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Organization No' => 'organization_title',
		'Assigned To' => 'assigned_user_id',
	);

	// Make the field link to detail view
	var $list_link_field = 'organization_title';

	// For Popup listview and UI type support
	var $search_fields = Array(
		/* Format: Field Label => Array(tablename, columnname) */
		// tablename should not have prefix 'vtiger_'
		'Organization No' => Array('organizationdetails', 'organization_title'),
		'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
	);
	var $search_fields_name = Array (
		/* Format: Field Label => fieldname */
		'Organization No' => 'organization_title',
		'Assigned To' => 'assigned_user_id',
	);

	// For Popup window record selection
	var $popup_fields = Array ('organization_title');

	// For Alphabetical search
	var $def_basicsearch_col = 'organization_title';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'organization_title';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('organization_title','assigned_user_id');

	var $default_order_by = 'organization_title';
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

 	function save_module($module)
	{
		//Inserting into attachments
		if(count($_FILES)>0)
			$this->insertIntoAttachment($this->id, $module);
		
	}

	function insertIntoAttachment($id,$module)
	{
		global  $log,$adb;
		
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");

		$file_saved = false;
		

		foreach($_FILES['imagename'] as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
			      if($_REQUEST[$fileindex.'_hidden'] != '')
				      $files['original_name'] = vtlib_purify($_REQUEST[$fileindex.'_hidden']);
			      else
				      $files['original_name'] = stripslashes($files['name']);
			      $files['original_name'] = str_replace('"','',$files['original_name']);
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}
		
		if($files['original_name'] !=''){
			$adb->pquery('UPDATE vtiger_organizationdetails SET imagename = ? WHERE organization_id = ?',array($files['original_name'],$id));
		}	

		//Remove the deleted vtiger_attachments from db - Products
		if($module == 'OrganizationDetails' && $_REQUEST['imgDeleted'] =='true')
		{
				$imageid = trim($_REQUEST['imageid']);
			
				$attach_res = $adb->pquery("select vtiger_attachments.attachmentsid, vtiger_attachments.path, vtiger_attachments.name from vtiger_attachments inner join vtiger_seattachmentsrel on vtiger_attachments.attachmentsid=vtiger_seattachmentsrel.attachmentsid where crmid=? and vtiger_attachments.attachmentsid=?", array($id,$imageid ));
				$attachments_id = $adb->query_result($attach_res,0,'attachmentsid');
				$path = $adb->query_result($attach_res,0,'path');
				$name = $adb->query_result($attach_res,0,'name');
				$del_res1 = $adb->pquery("delete from vtiger_attachments where attachmentsid=?", array($attachments_id));
				$del_res2 = $adb->pquery("delete from vtiger_seattachmentsrel where attachmentsid=?", array($attachments_id));
				@unlink($path.$attachments_id .'_'.$name);
			
		}
		
		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}

}
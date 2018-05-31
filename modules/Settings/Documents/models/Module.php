<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Documents_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_notes';
	var $baseIndex = 'notesid';
	var $listFields = array('note_no' => 'Document Serial No','title'=>'Title', 'filename' => 'File Name', 'filedownloadcount'=>'Download Count', 'filesize'=>'Size of File');
	var $nameFields = array('note_no');
	var $name = 'Documents';

	public function getCreateRecordUrl() {
		return "index.php?module=Documents&parent=Settings&view=Edit&doc_type=HR";
	}

}
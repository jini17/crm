<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/*
 * Settings Module Model Class
 */
class Settings_MultipleTnC_TnC_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_inventory_tandc';
	var $baseIndex = 'id';
	var $listFields = array('title' => 'Term Title', 'tandc' => 'Description');
	var $name = 'TNC';

	/**
	 * Function to get the url for default view of the module
	 * @return <string> - url
	 */
	public function getDefaultUrl() {
		return 'index.php?module=MultipleTnC&parent=Settings&view=List';
	}

	/**
	 * Function to get the url for create view of the module
	 * @return <string> - url
	 */
	public function getCreateTnCUrl() {
		return 'index.php?module=MultipleTnC&parent=Settings&view=Edit';
	}
}

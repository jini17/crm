<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.

  *************************************************************************************/

class Settings_Vtiger_FullContactConfigModule_Model extends Settings_Vtiger_Module_Model {


	var $fileName = 'modules/Contacts/actions/Config.php';
	var $completeData;
	var $data;

	/**
	 * Function to read config file
	 * @return <Array> The data of config file
	 */
	public function readFile() {
		if (!$this->completeData) {
			$this->completeData = file_get_contents($this->fileName);
		}
		return $this->completeData;
	}
	
	/**
	 * Function to get CompanyDetails Menu item
	 * @return menu item Model
	 */
	public function getMenuItem() {
		$menuItem = Settings_Vtiger_MenuItem_Model::getInstance('LBL_FULLCONTACT_CONFIG');
		return $menuItem;
	}
    
	/**
	 * Function to get Edit view Url
	 * @return <String> Url
	 */
	public function getEditViewUrl() {
		$menuItem = $this->getMenuItem();
		return '?module=Vtiger&parent=Settings&view=FullContactConfigEdit&block='.$menuItem->get('blockid').'&fieldid='.$menuItem->get('fieldid');
	}

	/**
	 * Function to get Advance Edit view Url
	 * @return <String> Url
	 */
	// public function getAdvanceEditViewUrl() {
	// 	$menuItem = $this->getMenuItem();
	// 	return '?module=Vtiger&parent=Settings&view=AdvanceGoogleConfigEdit&block='.$menuItem->get('blockid').'&fieldid='.$menuItem->get('fieldid');
	// }

	/**
	 * Function to get Detail view Url
	 * @return <String> Url
	 */
	public function getDetailViewUrl() {
		$menuItem = $this->getMenuItem();
		return '?module=Vtiger&parent=Settings&view=FullContactConfigDetail&block='.$menuItem->get('blockid').'&fieldid='.$menuItem->get('fieldid');
	}

	public function getIndexViewUrl() {
		$menuItem = $this->getMenuItem();
		return '?module=Vtiger&parent=Settings&view=FullContactConfigIndex&block='.$menuItem->get('blockid').'&fieldid='.$menuItem->get('fieldid');
	}

	/**
	 * Function to get Viewable data of config details
	 * @return <Array>
	 */
	public function getViewableData() {
		//Mabruk Fullcontact
		if (!$this->getData()) {
			global $adb;

			$result = $adb->pquery("SELECT * FROM ss_contactenrichment",array());

			$data['bearer'] = $adb->query_result($result,0,'bearer');
			$data['preference'] = $adb->query_result($result,0,'preference');
			$data['status'] = $adb->query_result($result,0,'active');

			if ($data['status'] == 1)
				$data['status'] = "Active";
			else 
				$data['status'] = "Inactive";

			if ($data['preference'] == "person")
				$data['preference'] = "Person Enrichment (Modules: Leads, Contacts)";
			else if ($data['preference'] == "company")
				$data['preference'] = "Company Enrichment (Modules: Organizations)";
			else if ($data['preference'] == "both")
				$data['preference'] = "Both (Modules: Leads, Contacts, Organizations)";
			$this->setData($data);
		}
		return $this->getData();
	}


	/**
	 * Function to get editable fields
	 * @return <Array> list of field names
	 */
	public function getEditableFields() {
		//Mabruk Fullcontact
		return array(
			'status' => array('label' => 'Data Enrichment Feature','fieldType' => 'picklist'),
			'preference'	=> array('label' => 'Enrichment Preference','fieldType' => 'picklist'),
			'bearer'	=> array('label' => 'LBL_BARRIER','fieldType' => 'input'),			
		);
	}

	/**
	 * Function to save the data
	 */
	public function save() {
		$fileContent = $this->completeData;
		$updatedFields = $this->get('updatedFields'); //print_r($updatedFields);
		//$validationInfo = $this->validateFieldValues($updatedFields);
		$validationInfo = true;

		if ($validationInfo === true) {
			foreach ($updatedFields as $fieldName => $fieldValue) {
				$fieldValue  = trim($fieldValue);
				$patternString = "\$%s = '%s';";
				$pattern = '/\$' . $fieldName . '[\s]+=([^;]+);/';
				$replacement = sprintf($patternString, $fieldName, ltrim($fieldValue, '0'));
				$fileContent = preg_replace($pattern, $replacement, $fileContent); //echo $fieldName; echo $fieldValue;
			}
			
			$filePointer = fopen($this->fileName, 'w');
			fwrite($filePointer, $fileContent);
			fclose($filePointer);
		}
		return $validationInfo;
	}

	/**
	 * Function to validate the field values
	 * @param <Array> $updatedFields
	 * @return <String> True/Error message
	 */
	public function validateFieldValues($updatedFields){
		if (trim($updatedFields['bearer']) =='' || trim($updatedFields['bearer'])==NULL ) {
			return "LBL_INVALID_BARRIER";
		}
		return true;
	}

	/**
	 * Function to get the instance of Config module model
	 * @return <Settings_Vtiger_ConfigModule_Model> $moduleModel
	 */
	public static function getInstance() {
		$moduleModel = new self();
		$moduleModel->getViewableData();
		return $moduleModel;
	}
}

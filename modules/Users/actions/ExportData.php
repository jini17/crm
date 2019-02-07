<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ***********************************************************************************/

class Users_ExportData_Action extends Vtiger_ExportData_Action {

	function checkPermission(Vtiger_Request $request) {
			$currentUser = Users_Record_Model::getCurrentUserModel();
		if ($currentUser->isAdminUser() || in_array($currentUser->roleid, array('H2','H12','H13'))) {
			return true;
		}
		return false;
	}



	var $exportableFields = array(	'user_name'		=> 'User Name',
									//'title'			=> 'Title',
									'first_name'	=> 'First Name',
									'last_name'		=> 'Last Name',
									'email1'		=> 'Email',
									'email2'		=> 'Other Email',
									'secondaryemail'=> 'Secondary Email',
									'phone_work'	=> 'Office Phone',
									'phone_mobile'	=> 'Mobile',
									'phone_fax'		=> 'Fax',
									'address_street'=> 'Street',
									'address_city'	=> 'City',
									'address_state'	=> 'State',
									'address_country'	=> 'Country',
									'address_postalcode'=> 'Postal Code');

	private $picklistValues;
	private $fieldArray;
	private $fieldDataTypeCache = array();

	/**
	 * Function exports the data based on the mode
	 * @param Vtiger_Request $request
	 */

	function ExportData(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
		$moduleName = $request->get('source_module');
		if ($moduleName) {
			$this->moduleInstance = Vtiger_Module_Model::getInstance($moduleName);
			$this->moduleFieldInstances = $this->moduleInstance->getFields();
			$skipfields = array('user_password', 'confirm_password', 'sameaddresscheck', 'is_admin', 'imagename');
			foreach($this->moduleFieldInstances as $key=>$field) {
		
				if(in_array($key, $skipfields)){
					continue;
				} else {
					$this->exportableFields[$key] = $field->label;
				}	
			}

			$this->focus = CRMEntity::getInstance($moduleName);
			$query = $this->getExportQuery($request);
			$result = $db->pquery($query, array());
			$headers = $this->exportableFields;
			foreach ($headers as $header) {
				$translatedHeaders[] = vtranslate(html_entity_decode($header, ENT_QUOTES), $moduleName);
			}

			$entries = array();
			for ($i=0; $i<$db->num_rows($result); $i++) {

				$entries[] = $this->sanitizeValues($db->fetchByAssoc($result, $i));
			}
			
			return $this->output($request, $translatedHeaders, $entries);
		}
	}

	/**
	 * this function takes in an array of values for an user and sanitizes it for export
	 * @param array $arr - the array of values
	 */

	function sanitizeValues($arr){
		
		//echo "<pre>";print_r($arr);
		$db = PearDatabase::getInstance();
		
		$this->fieldArray = $this->moduleFieldInstances;
			
		foreach($arr as $fieldName=>&$value){

			if(isset($this->fieldArray[$fieldName])){
				$fieldInfo = $this->fieldArray[$fieldName];
			}else {
				unset($arr[$fieldName]);
				continue;
			}

			//Track if the value had quotes at beginning
			$beginsWithDoubleQuote = strpos($value, '"') === 0;
			$endsWithDoubleQuote = substr($value,-1) === '"'?1:0;

			$value = trim($value,"\"");
			$uitype = $fieldInfo->get('uitype');
			$fieldname = $fieldInfo->get('name');

			if(!$this->fieldDataTypeCache[$fieldName]) {
				$this->fieldDataTypeCache[$fieldName] = $fieldInfo->getFieldDataType();
			}
			$type = $this->fieldDataTypeCache[$fieldName];
			
			//Restore double quote now.
			if ($beginsWithDoubleQuote) $value = "\"{$value}";
			if($endsWithDoubleQuote) $value = "{$value}\"";
			if($uitype == 15 || $uitype == 16){

				if(empty($this->picklistValues[$fieldname])){
					$this->picklistValues[$fieldname] = $this->fieldArray[$fieldname]->getPicklistValues();
				}
				// If the value being exported is accessible to current user
				// or the picklist is multiselect type.
	
				if($uitype == 33 || $uitype == 16 || array_key_exists($value,$this->picklistValues[$fieldname])){
					// NOTE: multipicklist (uitype=33) values will be concatenated with |# delim
					$value = trim($value);
				} else {
					$value = '';
				}

			} elseif($uitype == 101 || $type == 'userReference') {
				$value = Vtiger_Util_Helper::getOwnerName($value);

			} elseif($uitype == 21){
				$value = strip_tags($value);
				$value = str_replace('&nbsp;','',$value);
				
			} elseif($type=='boolean'){

				if($value==0 || $value ==NULL){
					$value = 'No';
				} else {
					$value = 'Yes';
				}

			}elseif($type == 'currencyList'){
					$value = getCurrencyName($value);	
			} elseif($type == 'userRole'){
				$value = trim($value);
				$value = getRoleName($value);
			} elseif($type == 'date') {
				if ($value && $value != '0000-00-00') {
					$value = DateTimeField::convertToUserFormat($value);
				}
			} 
			$arr[$fieldName] = $value;
		}
		return $arr;
	}	

	/**
	 * Function that generates Export Query based on the mode
	 * @param Vtiger_Request $request
	 * @return <String> export query
	 */
	function getExportQuery(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$cvId = $request->get('viewname');
		$moduleName = $request->get('source_module');

		$queryGenerator = new QueryGenerator($moduleName, $currentUser);
		if (!empty($cvId)) {
			$queryGenerator->initForCustomViewById($cvId);
		}

		$acceptedFields = array_keys($this->exportableFields);
		$queryGenerator->setFields($acceptedFields);
		return $queryGenerator->getQuery();
	}

}

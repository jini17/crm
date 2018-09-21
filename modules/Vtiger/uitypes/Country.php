<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Country_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Country.tpl';
	}

	/**
	 * Function to get the display value in detail view
	 * @param <Integer> crmid of record
	 * @return <String>
	 */
	public function getEditViewDisplayValue($value) {
			return $value;
	}

	/**
	 * Function to get display value
	 * @param <String> $value
	 * @param <Number> $recordId
	 * @return <String> display value
	 */
	public function getDisplayValue($value, $recordId) {
		/*$db = PearDatabase::getInstance();
		$result = $db->pquery('SELECT country FROM secondcrm_country WHERE countryid = ?',array($value));
		$displayValue = '';
		if($db->num_rows($result)) {
			$displayValue = $db->query_result($result, 0, 'country');
		}*/
		//modified by jitu for making text as country name	
		$displayValue  = $value;	
		return $displayValue;
	}
	
}

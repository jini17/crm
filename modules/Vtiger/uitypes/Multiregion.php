<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Multiregion_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Multiregion.tpl';
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($value) {
		$displayvalue = array();		
		if($value == NULL) return;

		if($value!='all') {
			$db = PearDatabase::getInstance();
			$territories = explode(',',$value);
		
			foreach($territories as $territory) {
		
				$arr = explode('#',$territory);
			
				$result = $db->pquery("SELECT region FROM secondcrm_region_data WHERE tree = ? AND regionid = ?",array($arr[0],$arr[1]));
				if($db->num_rows($result) > 0) {
					 $displayvalue[] = $db->query_result($result,0,"region");
				}
			}
		} else {
			$displayvalue[] = 'All';
		}	
			$displayvalue = implode(', ',$displayvalue);
		if(strpos($displayvalue,',') !==false)  
			return '('.$displayvalue.')';
		else 
			return $displayvalue;
	}

	public function getDBInsertValue($value) {
		
		if(is_array($value)){
           		$value = implode(',', $value);
        	}
        	return $value;
	}
}

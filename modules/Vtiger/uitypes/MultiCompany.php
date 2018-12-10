<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_MultiCompany_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/MultiCompany.tpl';
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($values) {
        
        if($values == NULL && !is_array($values)) return;
        	$values = explode(' |##| ', $values);
        	foreach($values as $value){
	            $companyModel = Vtiger_Util_Helper::getCompanyTitle($value);
	            $displayvalue[] = $companyModel[0]['organization_title'];
        	}
    	$displayvalue = implode(',&nbsp;',$displayvalue);
        return $displayvalue;
	}
	 public function getListSearchTemplateName() {
        return 'uitypes/MultiCompanySearchView.tpl';
    }
}
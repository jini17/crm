<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Multiproduct_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Multiproduct.tpl';
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($value) {
   		if($value == NULL) return;

		$db = PearDatabase::getInstance();
		$values = explode(',',$value);
		
		foreach($values as $productid){
			$currentUser = Users_Record_Model::getCurrentUserModel();
			if($productid != 'all') {
				$result = $db->pquery("SELECT productname FROM vtiger_products WHERE productid = ?",array($productid));		
				if($db->num_rows($result) > 0) {
					 $product = $db->query_result($result,0,"productname");
				}
				$detailViewUrl = "index.php?module=Products&view=Detail&record=".$productid;
				if(!$currentUser->isAdminUser()){
				
					$displayvalue[] = $product;
			
				} else {
					$displayvalue[] = "<a href=" .$detailViewUrl. ">" .$product. "</a>";
				}
			} else {
				$displayvalue[] = 'All';
			}
		}
		
		$displayvalue = implode(',&nbsp;',$displayvalue);
        	
		return $displayvalue;   
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getWSDisplayValue($value) {
   		if($value == NULL) return;

		$db = PearDatabase::getInstance();
		$values = explode(',',$value);
		
		foreach($values as $productid){
			$currentUser = Users_Record_Model::getCurrentUserModel();
			
			$result = $db->pquery("SELECT productname FROM vtiger_products WHERE productid = ?",array($productid));		if($db->num_rows($result) > 0) {
				 $product = $db->query_result($result,0,"productname");
			}
			$detailViewUrl = "index.php?module=Products&view=Detail&record=".$productid;
			if(!$currentUser->isAdminUser()){
				$displayvalue[] = $product;
			
			} else {
				$displayvalue[] = $product;
			}
		}
		
		$displayvalue = implode(', <br />',$displayvalue);
        	
		return $displayvalue;   
	}
     
}

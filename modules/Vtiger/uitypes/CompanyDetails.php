<?php
/* ===================================================================
Modified By: Jitu, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 19 / 09 / 2014
Change Reason: Multiple Company Details , New file created
=================================================================== */

class Vtiger_CompanyDetails_UIType extends Vtiger_Base_UIType {
    
	public function getTemplateName() {
		return 'uitypes/CompanyDetails.tpl';
	}
        
   	public function getDetailViewTemplateName() {
            return 'uitypes/StringDetailView.tpl';
   	}

   	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	public function getDisplayValue($value) {
        
        $companyModel = Vtiger_Util_Helper::getCompanyTitle($value);
	    $displayvalue = $companyModel[0]['organization_title'];
    
        return $displayvalue;
	}
       
}

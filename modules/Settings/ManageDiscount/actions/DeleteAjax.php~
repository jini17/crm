<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_ManageDiscount_DeleteAjax_Action extends Settings_Vtiger_Index_Action {



	public function process(Vtiger_Request $request) {
		$discounts = $request->get('discounts');
		$qualifiedModuleName = $request->getModule(false);

		$flag = false;
		if(!empty($discounts)) {
			$save = Settings_ManageDiscount_Record_Model::deleteDiscount($discounts);
			$flag = true;
		}
		
		$response = new Vtiger_Response();
		$response->setResult(array($flag));
		$response->emit();
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            $request->validateWriteAccess(); 
        }
}

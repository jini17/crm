<?php
/*+**********************************************************************************
 * Author: Jitendra Gupta 
 * Get All Terms N Condition for particular Company
 * All Rights Softsolvers Reserved.
 ************************************************************************************/

class Inventory_TnCAjax_View extends Inventory_ServicesPopup_View {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('getTermsNConditionForCompany');
	}
	
	function process (Vtiger_Request $request) {
		$mode = $request->get('mode');
		if($this->isMethodExposed($mode)) {
            		$this->invokeExposedMethod($mode, $request);
        	}
	}

	public function getTermsNConditionForCompany(Vtiger_Request $request) {
		$moduleName = $request->get('module');
		
		$company_Id = $request->get('company_Id');
		$getCompanyTermsCondition = Vtiger_Util_Helper::getAllCompanyTermsConditions($company_Id);

		$response = new Vtiger_Response();
		$response->setResult($getCompanyTermsCondition);
		$response->emit();
	}

}

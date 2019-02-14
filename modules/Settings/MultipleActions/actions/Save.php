<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleActions_Save_Action extends Settings_Vtiger_Index_Action {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$data = array();
		$actioncodes = array('Leads_cla', 'Quotes_giq', 'Quotes_gsq', 'Quotes_gpq', 'SalesOrder_cis', 'SalesOrder_cps', 'SalesOrder_cds','HelpDesk_cih', 'Invoice_cdi', 'Quotes_sqe', 'Invoice_sie', 'SalesOrder_sse', 'DeliveryOrder_sde', 'ServiceContracts_csr','SalesOrder_sor', 'Quotes_qor', 'Invoice_ior', 'PurchaseOrder_por', 'DeliveryOrder_dor');
		
				
		foreach($actioncodes as $k=>$value) {
			$restrict = 0;
			$data[$k]['statusvalue']= '';
			
			
			if($request->get($value)) {
				$restrict = 1;
				$data[$k]['statusvalue']= is_array($request->get($value.'_action'))?implode(',',$request->get($value.'_action')):$request->get($value.'_action');
			}
				$restrictarr = explode('_',$value);
				$data[$k]['module']	= $restrictarr[0];
				$data[$k]['actioncode']	= strtoupper($restrictarr[1]);
				$data[$k]['isrestrict']	= $restrict;
				$data[$k]['userid']	= $currentUser->id;
			
		}
		$result = Settings_MultipleActions_Record_Model::saveRecord($data);
		$responce = new Vtiger_Response();
	        $responce->setResult(array('success'=>true));
	        $responce->emit();
	}
}

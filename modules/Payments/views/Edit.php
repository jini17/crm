<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class Payments_Edit_View extends Vtiger_Edit_View {

	public function process(Vtiger_Request $request) {

		//added by jitu@20082015 for currency drop down
		$viewer = $this->getViewer($request);
		$currencies = Payments_Module_Model::getAllCurrencies();
		$viewer->assign('CURRENCIES', $currencies);

		if($request->get('sourceModule') && $request->get('sourceRecord')) {
			//Added by jitu@06072015 for fetch salesorder detail from		
			global $adb;
			
			$sourceModule = $request->get('sourceModule');
			$linktomodule  = $request->get('linktomodule');	//Account
			$record = $request->get('sourceRecord');
			$relatedcontact  = $request->get('relatedcontact'); //Contact
		

			$relatedid = $linktomodule=='' || $linktomodule==0?$relatedcontact:$linktomodule;
			$request->set('relatedto', $relatedid);
	
		
			//end here
			$amount = $request->get('amount');
			if($sourceModule == 'Invoice') {
				$payment_res = $adb->pquery("select company_details from vtiger_invoice where invoiceid = ?", array($record));	$companyid = $adb->query_result($payment_res,0,'company_details');
				$request->set('company_details', $companyid);
	
			} elseif($sourceModule == 'SalesOrder') {
				$payment_res = $adb->pquery("select company_details from vtiger_salesorder where salesorderid = ?", array($record));	$companyid = $adb->query_result($payment_res,0,'company_details');
				$request->set('company_details', $companyid);
			} elseif($sourceModule == 'PurchaseOrder') {
				$payment_res = $adb->pquery("select company_details from vtiger_purchaseorder where purchaseorderid = ?", array($record));	$companyid = $adb->query_result($payment_res,0,'company_details');
				$request->set('company_details', $companyid);
			}				
				$request->set('amount', (float) str_replace(',', '', $amount));
			//End here
		}
		parent::process($request);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$moduleName = $request->getModule();
		$moduleEditFile = 'modules.'.$moduleName.'.resources.Edit';
		
		unset($headerScriptInstances[$moduleEditFile]);


		$jsFileNames = array(
				'modules.'.$moduleName.'.resources.Edit',
		);
		$jsFileNames[] = $moduleEditFile;
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

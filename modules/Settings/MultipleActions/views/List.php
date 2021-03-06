<?php
/* ===================================================================
Modified By: Jitendra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 19 / 04 / 2015
Change Reason: Multiple Actions, New file created
=================================================================== */

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleActions_List_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		$db = PearDatabase::getInstance();
		$sql = "SELECT * FROM secondcrm_multipleactions";
		
		$result = $db->pquery($sql, array());
		$return_data = null;
		$num_rows = $db->num_rows($result);
		for($i=0; $i<$num_rows; $i++) {
		    $row = $db->query_result_rowdata($result,$i);
		      $return_data[$row['actioncode']] = $row;
		}

		$modules = array("Leads"=>"leadstatus", "HelpDesk"=>"ticketstatus", "ServiceContracts"=>"contract_status", "Invoice"=>"invoicestatus","PurchaseOrder"=>"postatus", "SalesOrder"=>"sostatus", "Quotes"=>"quotestage", "DeliveryOrder"=>"");
		
		//getStatus of Modules 
		foreach($modules as $module=>$picklist) {
			//fetch all status respective Module
			if($picklist !='') { 
				$PickListValues[$module] = Settings_MultipleActions_Record_Model::getPickistValues($picklist);
			}
		}
		//echo "<pre>";print_r($PickListValues);
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('ERROR_MESSAGE', $request->get('error'));
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
       		$viewer->assign('DETAILS', $return_data);
		$viewer->assign('PICKLIST_VALUES',$PickListValues);
		$viewer->view('List.tpl', $qualifiedModuleName);
	}
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_MULTIPLE_ACTIONS',$qualifiedModuleName);
	}

}

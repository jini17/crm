<?php
/* ===================================================================
Modified By: Zulhisyam, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 11 / 06 / 2014
Change Reason: Multiple Terms An Conditions , New file created
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
class Settings_MultipleTnC_Save_Action extends Vtiger_Action_Controller {
	public function checkPermission(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if(!$currentUser->isAdminUser()) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function process(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();		
		$inv_type	     ='Inventory';        	
		$inventory_title     = decode_html($request->get('term_title'));		
		$inv_tandc	     = addslashes($request->get('inventory_tandc'));
		$inv_companyIds      = $request->get('companies');	
		$mode		     = $request->get('mode');
		if($mode == 'edit') {
			$recordId = $request->get('record');
			$params = array($recordId );
			//remove all previous assigned companies 
			$result = $db->pquery("DELETE FROM secondcrm_tnc_assigncompany WHERE tncid = ?", $params);
			//Update term details
			$result = $db->pquery("UPDATE vtiger_inventory_tandc SET title = '".$inventory_title."', 
						tandc = '".$inv_tandc."' WHERE id = ?",array($params));
		} else {
			//Find the last insert ID 
			$result   = $db->pquery("SELECT id FROM vtiger_inventory_tandc_seq",array());
			$lastId   = $db->query_result($result, 0, 'id');
			$recordId = $lastId+1;

			//Insert term details
			$result = $db->pquery("INSERT INTO vtiger_inventory_tandc SET id = ".$recordId.", 
			title = '".$inventory_title."', tandc = '".$inv_tandc."', type = '".$inv_type."'",array());
			$result = $db->pquery("UPDATE vtiger_inventory_tandc_seq SET id = ".$recordId."",array());

		}
		//Insert all assigned company to related termid	
		$sql = "INSERT INTO secondcrm_tnc_assigncompany(tncid, organization_id) VALUES ";
		foreach($inv_companyIds as $companyid) {
			$sql .= "( ".$recordId.", ".$companyid."),";	
		}
		//trim last comma(,) in sql
		$sql = rtrim($sql,',');
		$result = $db->pquery($sql, array());			
		
		$reloadUrl = "index.php?module=MultipleTnC&parent=Settings&view=List";
		header('Location: ' . $reloadUrl);
	}

}
?>

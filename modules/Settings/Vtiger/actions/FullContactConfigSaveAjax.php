<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 Created by DANIAL FAJAR
 ************************************************************************************/

class Settings_Vtiger_FullContactConfigSaveAjax_Action extends Settings_Vtiger_Basic_Action {

	public function process(Vtiger_Request $request) {
		global $adb;
		$response = new Vtiger_Response();
		$qualifiedModuleName = $request->getModule(false);
		$bearer = $request->get('bearer');
		$preference = $request->get('preference');
		$status = $request->get('status'); 

		$result = $adb->pquery("SELECT 1 FROM ss_contactenrichment", array());
		if ($adb->num_rows($result) == 0)
			$adb->pquery("INSERT INTO ss_contactenrichment VALUES (?,?,?,?)", array(1, $preference, $bearer, $status));	
		else
			$adb->pquery("UPDATE ss_contactenrichment SET preference = ?, bearer = ?, active = ?",array($preference, $bearer, $status));
		
		$response->setResult("Success");
		$response->emit();
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            $request->validateWriteAccess(); 
        }
}

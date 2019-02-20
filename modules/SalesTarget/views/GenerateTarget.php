<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class SalesTarget_GenerateTarget_View extends Vtiger_List_View {

	public function process(Vtiger_Request $request) {
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$targetids = $request->get('selected_ids');
		$resultTargets = SalesTarget_Record_Model::getActiveTargets($targetids);

		$response = new Vtiger_Response();
		if(is_numeric($resultTargets)) {
			if($resultTargets ==0) {
				$response->setResult(array(vtranslate('LBL_GENERATE_SUCCESSFULLY', $moduleName)));
			} else {
				$response->setError(array(vtranslate('LBL_GENERATE_FAILED', $moduleName)));
			}
			
		} else {
			$response->setError(array(vtranslate('LBL_NO_RELEVENT_DATA', $moduleName)));
		}
		$response->emit();
	}
}

<?php
/*+***********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
 *************************************************************************************/

class Settings_ManageTerritory_Delete_Action extends Settings_Vtiger_Basic_Action {

	public function process(Vtiger_Request $request) {
		 $moduleName = $request->getModule();
		 $qualifiedModuleName = $request->getModule(false);
		 $regiontree = $request->get('parenttree');
		 $regionid = $request->get('regionid');
		 $transferRecordId = $request->get('transfer_record');

		$recordModel = Settings_ManageTerritory_Record_Model::getdataInstanceById($regionid, $regiontree);

		$transferToRegion = Settings_ManageTerritory_Record_Model::getdataInstanceById($regionid, $transferRecordId);
		if($recordModel && $transferToRegion) {
			$recordModel->delete($transferToRegion);
		}

		$redirectUrl = 'index.php?module=ManageTerritory&parent=Settings&view=Edit&record='.$regionid;
		header("Location: $redirectUrl");
	}
        
}

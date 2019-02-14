<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_Export_View extends Vtiger_Export_View {

	function checkPermission(Vtiger_Request $request) {
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if ($currentUser->isAdminUser() || in_array($currentUser->roleid, array('H2','H12','H13'))) {
			return true;
		}
		return false;
	}
	
}
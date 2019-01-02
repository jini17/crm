<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_Popup_View extends Vtiger_Popup_View {
    
    function checkPermission(Vtiger_Request $request) {
		global $current_user;
        $moduleName = $request->getModule();
        $sourceModuleName = $request->get('src_module');
        $sourceFieldName = $request->get('src_field');
        if( $moduleName == 'Users' && $sourceModuleName == 'Quotes' && $sourceFieldName == 'assigned_user_id1' ) {
            return true;
        }
        if( $moduleName == 'Users' && ($sourceModuleName == 'EmployeeContract' || $sourceModuleName == 'PassportVisa' || $sourceModuleName == 'Leave') && ($sourceFieldName == 'employee_id' || $sourceFieldName == 'reports_to') &&  ($current_user->roleid=='H12' || $current_user->roleid=='H13')) { 
            return true;
        }
        return parent::checkPermission($request);
    }
}

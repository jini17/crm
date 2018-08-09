<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Added By Mabruk for user limit per role validation while creating a user
 ************************************************************************************/
/*
error_reporting(1);
        ini_set('display_erros',1);

          register_shutdown_function('handleErrors');
            function handleErrors() {

               $last_error = error_get_last();

               if (!is_null($last_error)) { // if there has been an error at some point

              // do something with the error
              print_r($last_error);

               }

            } */
class Users_UserLimitPerRoleValidation_Action extends Vtiger_BasicAjax_Action {    
    
    public function process(Vtiger_Request $request) {
		global $adb;
        $currentUser = Users_Record_Model::getCurrentUserModel();
		$recordModel = Vtiger_Record_Model::getInstanceById($currentUser->getId(), 'Users');
        
	    $result = $adb->pquery("SELECT COUNT(secondcrm_userplan.userid) AS users,
                                secondcrm_plan.nousers AS maxusers
                                FROM vtiger_role
                                LEFT JOIN secondcrm_plan
                                ON secondcrm_plan.planid = vtiger_role.planid
                                LEFT JOIN secondcrm_userplan
                                ON secondcrm_userplan.planid = secondcrm_plan.planid
                                WHERE vtiger_role.roleid = ?
                                GROUP BY secondcrm_userplan.planid", array($request->get('roleid')));

        $users = $adb->query_result($result, 0, "users");
        $maxusers = $adb->query_result($result, 0, "maxusers");

        $response = new Vtiger_Response();
        try{
            $recordModel->save();
            if ($users >= $maxusers)
                $response->setResult(array('result'=>false));
            else
                $response->setResult(array('result'=>true));
        }catch(Exception $e){
            $response->setError($e->getCode(),$e->getMessage());
        }
        $response->emit();
    }
}

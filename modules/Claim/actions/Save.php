<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Claim_Save_Action extends Vtiger_Save_Action {

	public function process(Vtiger_Request $request){
		
		$db = PearDatabase::getInstance();
		$currentUser 	= Users_Record_Model::getCurrentUserModel();
		$record = $request->get('record');
		
		if($record =='') {
			$request->set('assigned_user_id', $currentUser->id);
		}
		parent::process($request);
	}
}

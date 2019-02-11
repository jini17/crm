<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_ManageDiscount_DeleteAjax_View extends Settings_Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		$recordId = $request->get('record');
		$mode = $request->get('mode');
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);


		$viewer = $this->getViewer($request);
		//echo "<pre>";echo "XDXD</pre>";
		if($mode=='new'){
			$recordModel = Settings_ManageDiscount_Record_Model::getInstanceById('new', $qualifiedModuleName);
			$viewer->assign('RECORD_MODEL', $recordModel);
		}else{
			$recordModel = Settings_ManageDiscount_Record_Model::getInstanceById($recordId, $qualifiedModuleName);
			$viewer->assign('RECORD_MODEL', $recordModel);
		}
		
		$maindiscount=Settings_ManageDiscount_Record_Model::getMainDiscount();
		$userslist=Settings_ManageDiscount_Record_Model::getAllUsers();
		$rolelist=Settings_ManageDiscount_Record_Model::getAllRoles();
		//echo "<pre>";print_r($recordModel);echo "</pre>";
		
		$viewer->assign('ROLESLIST', $rolelist);
		$viewer->assign('USERSLIST', $userslist);
		$viewer->assign('MAINDISCOUNT', $maindiscount);
		$viewer->assign('MODE', $mode);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('RECORD', $recordId);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->view('DeleteAjax.tpl', $qualifiedModuleName);
	}

}

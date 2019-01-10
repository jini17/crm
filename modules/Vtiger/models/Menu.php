<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Vtiger Menu Model Class
 */
 
class Vtiger_Menu_Model extends Vtiger_Module_Model {

	/**
	 * Static Function to get all the accessible menu models with/without ordering them by sequence
	 * @param <Boolean> $sequenced - true/false
	 * @return <Array> - List of Vtiger_Menu_Model instances
	 */
	public static function getAll($sequenced = false) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$restrictedModulesList = array('Emails', 'ProjectMilestone','Leads', 'ProjectTask', 'ModComments', 'Integration', 'PBXManager', 'Dashboard', 'Home');

		$allModules = parent::getAll(array('0','2'));
		$menuModels = array();
		$moduleSeqs = Array();
		$moduleNonSeqs = Array();
		foreach($allModules as $module){
			if($module->get('tabsequence') != -1){
				$moduleSeqs[$module->get('tabsequence')] = $module;
			}else {
				$moduleNonSeqs[] = $module;
			}
		}
		ksort($moduleSeqs);
		$modules = array_merge($moduleSeqs, $moduleNonSeqs);

		foreach($modules as $module) {
			if ((($userPrivModel->isAdminUser() || $currentUser->get('roleid')=='H12' || $currentUser->get('roleid')=='H13') ||
					$userPrivModel->hasGlobalReadPermission() ||
					$userPrivModel->hasModulePermission($module->getId())) & !in_array($module->getName(), $restrictedModulesList) ) {
					$menuModels[$module->getName()] = $module;

			}
		}

		return $menuModels;
	}

	/**
	 * Static Function to get all the accessible module model for Quick Create
	 * @return <Array> - List of Vtiger_Menu_Model instances
	 */
	public static function getAllForQuickCreate() {
		global $adb;
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$restrictedModulesList = array('Emails', 'ModComments', 'Integration', 'PBXManager', 'Dashboard', 'Home');
		$allModules = parent::getAll(array('0', '2'));
		$menuModels = array();

		foreach ($allModules as $module) {
			if (($userPrivModel->isAdminUser() || $userPrivModel->hasGlobalReadPermission() || $userPrivModel->hasModulePermission($module->getId())) && !in_array($module->getName(), $restrictedModulesList) && $module->get('parent') != '') {
				$menuModels[$module->getName()] = $module;
			}
		}

		uksort($menuModels, array('Vtiger_MenuStructure_Model', 'sortMenuItemsByProcess'));
		return $menuModels;
	}

	/**
	 * Static Function to get all the accessible module model for Quick Create
	 * Added By Mabruk
	 * @return <Array> - List of Vtiger_Menu_Model instances
	 */
	public static function getQuickCreateModulesAndIcons() {

		global $adb;		
		$menuModels  = array();
		$currentUser = Users_Record_Model::getCurrentUserModel();


		$result 	= $adb->pquery("SELECT vtiger_tab.name, vtiger_tab.moduleicon 
								FROM `vtiger_tab`
								LEFT JOIN secondcrm_planpermission 
								ON secondcrm_planpermission.tabid = vtiger_tab.tabid
								WHERE quickcreate = 1
								AND secondcrm_planpermission.visible = 1 
								AND secondcrm_planpermission.planid = ?", array($_SESSION['plan']));
		$numOfRows 	= $adb->num_rows($result);
		
		for ($i = 0; $i < $numOfRows; $i++) {

			$moduleName = $adb->query_result($result, $i, 'name');

			if(!in_array($currentUser->roleid, array('H2', 'H12', 'H13')) && $moduleName == 'Users') 
				continue;			
			
			$menuModels[$i]['moduleName'] = $moduleName;
			$menuModels[$i]['moduleIcon'] = $adb->query_result($result, $i, 'moduleicon');

		}

		return array_values(array_filter($menuModels));

	}	

}

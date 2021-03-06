<?php
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
class Settings_MaxLogin_Show_View extends Settings_Vtiger_Index_View{

	public function process(Vtiger_Request $request) {
        	$settings = Settings_MaxLogin_Module_Model::getBruteForceSettings();
        	$blockedUsers = Settings_MaxLogin_Module_Model::getBlockedUsers();
		
		$viewer = $this->getViewer ($request);
		$qualifiedModuleName = $request->getModule(false);
        	
        	$viewer->assign('MODULE', $qualifiedModuleName);
		$viewer->assign('ATTEMPS_NUMBER', $settings[0]);
		$viewer->assign('BLOCK_TIME', $settings[1]);
        	$viewer->assign('BLOCKED', $blockedUsers);
		$viewer->view('Show.tpl', $qualifiedModuleName);
	}

	public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.MaxLogin",	
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

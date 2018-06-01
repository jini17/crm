<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/


	class Timesheet_Listview_View extends Vtiger_Index_View {

		public function preProcess(Vtiger_Request $request, $display = true) {
			$viewer = $this->getViewer($request);
			$moduleName = $request->getModule();
			$viewer->assign('MODULE_NAME', $moduleName);
			$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
			$viewer->assign('IS_CREATE_PERMITTED', $moduleModel->isPermitted('CreateView'));
			$viewer->assign('IS_MODULE_EDITABLE', $moduleModel->isPermitted('EditView'));
			$viewer->assign('IS_MODULE_DELETABLE', $moduleModel->isPermitted('Delete'));

			parent::preProcess($request, false);
			if($display) {
				$this->preProcessDisplay($request);
			}
		}

		protected function preProcessTplName(Vtiger_Request $request) {
			return 'ListviewPreProcess.tpl';
		}

		public function process(Vtiger_Request $request) {
			$mode = $request->getMode();
			
			$viewer = $this->getViewer($request);
			$currentUserModel = Users_Record_Model::getCurrentUserModel();
			
			$viewer->assign('CURRENT_USER', $currentUserModel);
			$viewer->assign('IS_CREATE_PERMITTED', isPermitted('Timesheet', 'CreateView'));

			$viewer->view('Timesheet.tpl', $request->getModule());
		}

		public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$jsFileNames = array(
		 	"modules.Timesheet.resources.Listview"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	}	
?>
<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ManageDiscount_List_View extends Settings_Vtiger_List_View {


	public function process(Vtiger_Request $request) {
		//echo "<pre>IN PROCESS</pre>";
		//echo "<pre>";print_r($request);echo "</pre>";
		$viewer = $this->getViewer($request);
		$this->initializeListViewContents($request, $viewer);
		$viewer->view('ListViewContents.tpl', $request->getModule(false));
	}

	public function initializeListViewContents(Vtiger_Request $request, Vtiger_Viewer $viewer) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);

		$listViewModel = Settings_ManageDiscount_ListView_Model::getInstance($qualifiedModuleName);
		$listViewModel->set('orderby', 'sequence');		 

		$pagingModel = new Vtiger_Paging_Model();

		if(!$this->listViewHeaders){
			$this->listViewHeaders = $listViewModel->getListViewHeaders();
		}
		if(!$this->listViewEntries){
			$this->listViewEntries = $listViewModel->getListViewEntries($pagingModel);
		}
		//echo "<pre>";print_r($this->listViewEntries);echo "</pre>";
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('MODULE_MODEL', $listViewModel->getModule());
		$viewer->assign('PAGING_MODEL', $pagingModel);
		$viewer->assign('LISTVIEW_HEADERS', $this->listViewHeaders);
		$viewer->assign('LISTVIEW_ENTRIES', $this->listViewEntries);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		
	}

}

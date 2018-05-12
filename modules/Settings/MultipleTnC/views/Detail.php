<?php
/**===================================================================
Modified By: Zulhisyam, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 11 / 06 / 2014
Change Reason: Multiple Terms An Conditions , New file created
===================================================================**/

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleTnC_Detail_View extends Settings_Vtiger_Index_View {
    
    public function process(Vtiger_Request $request) {
        $cnt = 0;
        $db = PearDatabase::getInstance();
        
        $model = Settings_MultipleTnC_Detail_Model::getInstance();
        $model1 = Settings_MultipleTnC_Detail_Model::getInstances();
        $conditionText = $model->getText();
        $conditionType = $model1->getType();
        $viewer = $this->getViewer($request);   
        $qualifiedName = $request->getModule(false);
        
        $iId = $_REQUEST['id'];
        
        $query = "SELECT * FROM vtiger_inventory_tandc WHERE id='$iId'";
        $result = $db->pquery($query, array());
        
        $inventory_type = $db->query_result($result,0,'type');
        $inventory_title = $db->query_result($result,0,'title');
        $inventory_tandc = $db->query_result($result,0,'tandc');
        $viewer->assign('ID', $iId);
        $RES_COMPANY = Settings_MultipleTnC_CompanyTnC_Model::getAllCompanyByTnC($iId);
			
		foreach($RES_COMPANY as $Company) {
			$SELECTED_COMPANY[] = $Company['organization_title']; 	
		}	
		$SELECTED_COMPANY	= implode('<br>',$SELECTED_COMPANY);
        if (isset($inventory_type))
            $viewer->assign("TERMTYPE",$inventory_type);
        if (isset($inventory_title))
            $viewer->assign("TERMTITLE",$inventory_title);
        if (isset($inventory_tandc))
            $viewer->assign("TERMTANDC",$inventory_tandc);
        
        $viewer->assign('CONDITION_TEXT',$conditionText);
		$viewer->assign('SELECTED_COMPANY',$SELECTED_COMPANY);	
        $viewer->assign('CONDITION_TYPE', $conditionType);
        $viewer->assign('MODEL',$model);
        $viewer->view('Detail.tpl',$qualifiedName);
        
    }
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_TERMS_AND_CONDITIONS',$qualifiedModuleName);
	}	
			
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.TermsAndConditions"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}

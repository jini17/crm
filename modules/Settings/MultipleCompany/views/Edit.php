<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_MultipleCompany_Edit_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		$moduleModel = Settings_MultipleCompany_Detail_Model::getInstance();
		
                $db = PearDatabase::getInstance();
              	$viewer = $this->getViewer($request);
                
                $iId = $_REQUEST['organizationid'];
                $sql="select * from vtiger_organizationdetails WHERE organization_id='$iId'";
                $result = $db->pquery($sql, array());
                $organization_name = str_replace('"','&quot;',$db->query_result($result,0,'organizationname'));
                $organization_title = str_replace('"','&quot;',$db->query_result($result,0,'organization_title'));
                $organization_address= $db->query_result($result,0,'address');
                $organization_city = $db->query_result($result,0,'city');
                $organization_state = $db->query_result($result,0,'state');
                $organization_code = $db->query_result($result,0,'code');
                $organization_country = $db->query_result($result,0,'country');
                $organization_phone = $db->query_result($result,0,'phone');
                $organization_fax = $db->query_result($result,0,'fax');
                $organization_website = $db->query_result($result,0,'website');
		$organization_VatID = $db->query_result($result,0,'vatid');
                $organization_logoname = $db->query_result($result,0,'logoname');

                $viewer->assign("ORGANIZATIONID",$iId);
                if (isset($organization_title))
                        $viewer->assign("ORGANIZATIONTITLE",$organization_title);
                /*Codes added/modified end here -by RAHIMAH on Aug 12,2011*/
                if (isset($organization_name))
                        $viewer->assign("ORGANIZATIONNAME",$organization_name);
                if (isset($organization_address))
                        $viewer->assign("ORGANIZATIONADDRESS",$organization_address);
                if (isset($organization_city))
                        $viewer->assign("ORGANIZATIONCITY",$organization_city);
                if (isset($organization_state))
                        $viewer->assign("ORGANIZATIONSTATE",$organization_state);
                if (isset($organization_code))
                        $viewer->assign("ORGANIZATIONCODE",$organization_code);
                if (isset($organization_country))
                        $viewer->assign("ORGANIZATIONCOUNTRY",$organization_country);
                if (isset($organization_phone))
                        $viewer->assign("ORGANIZATIONPHONE",$organization_phone);
                if (isset($organization_fax))
                        $viewer->assign("ORGANIZATIONFAX",$organization_fax);
                if (isset($organization_website))
                        $viewer->assign("ORGANIZATIONWEBSITE",$organization_website);
		if (isset($organization_VatID))
                        $viewer->assign("ORGANIZATIONVATID",$organization_VatID);
                if ($organization_logoname == '') 
                        $organization_logoname = vtlib_purify($_REQUEST['prev_name']);
                if (isset($organization_logoname)) 
                        $viewer->assign("ORGANIZATIONLOGONAME",$organization_logoname);
                
                $viewer->assign('MODULE_MODEL', $moduleModel);
		$viewer->assign('ERROR_MESSAGE', $request->get('error'));
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->view('Edit.tpl', $qualifiedModuleName);
	}
	
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_COMPANY_DETAILS',$qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.Edit"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
    
}

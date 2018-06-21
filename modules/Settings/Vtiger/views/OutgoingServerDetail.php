<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Vtiger_OutgoingServerDetail_View extends Settings_Vtiger_Index_View {
    
    public function process(Vtiger_Request $request) {
        $systemDetailsModel = Settings_Vtiger_Systems_Model::getInstanceFromServerType('email', 'OutgoingServer');
        $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(false);
		//die;
		//added by afiq@secondcrm.com on 6/16/2014 for multiple from address
        $return_data = Users_Record_Model::getMultipleAddress2();
		$viewer->assign('DETAILS', $return_data);
		//end of code
		
        $viewer->assign('MODEL',$systemDetailsModel);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedName);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());

        $this->showListView($request);
		
        //$viewer->view('OutgoingServerList.tpl',$qualifiedName);
    }
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_OUTGOING_SERVER',$qualifiedModuleName);
	}
	
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();
        //echo "<pre>"; print_r($moduleName); die;
		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.OutgoingServer"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}


	/**
     * Created by Nirbhay and Mabruk to show list view for Outgoing server
     */
	public function showListView(Vtiger_Request $request){
        global $adb;
       // $adb->setDebug(true);
	    $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(false);

        $result = $adb->pquery("SELECT * FROM vtiger_systems",array());

        $count = $adb->num_rows($result);
        $data = array();

        for($i=0;$i<$count;$i++){
	        $data[$i]['server'] = $adb->query_result($result,$i,'server');
	        $data[$i]['from_email_field'] = $adb->query_result($result,$i,'from_email_field');
	        $data[$i]['smtp_auth'] = $adb->query_result($result,$i,'smtp_auth');
	        $data[$i]['isdefault'] = $adb->query_result($result,$i,'isdefault');
	        $data[$i]['server_username'] = $adb->query_result($result,$i,'server_username');
	        $data[$i]['id'] = $adb->query_result($result,$i,'id');
        }
        //die;

        $viewer->assign('DATA',$data);



        $viewer->view('OutgoingServerList.tpl',$qualifiedName);

    }
}

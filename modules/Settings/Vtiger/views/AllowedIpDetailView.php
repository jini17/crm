<?php
/*+**********************************************************************************
 * Created By Nirbhay Shah 17-04-2018
 * For Allowed IP's

 ************************************************************************************/


class Settings_Vtiger_AllowedIpDetailView_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$qualifiedName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		global $adb;
       // $adb->setDebug(true);
		$query = "SELECT * FROM allowed_ip ";
		$result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);
        $values = array();
        $users = array();
        $type = array();

        for($i=0;$i<$count;$i++){
            $values[$i]['checkbox'] = $adb->query_result($result, $i,'ip_id');
            $values[$i]['ip'] = $adb->query_result($result, $i,'ip');
            $values[$i]['iprestriction_type'] = $adb->query_result($result, $i,'iprestriction_type');
            $values[$i]['type'] = $adb->query_result($result, $i,'type');
            $values[$i]['isactive'] = $adb->query_result($result, $i,'isactive');
            if($values[$i]['isactive'] == '1'){
                $values[$i]['isactive'] = 'Active';
            }else{
                $values[$i]['isactive'] = 'Inactive';
            }

        }

        $defaultvaluequery = "SELECT * FROM allowed_ip_default";
        $defaulvalueresult = $adb->pquery($defaultvaluequery,array());

        $defaultvalue = $adb->query_result($defaulvalueresult,0,'defaultvalue');

        if($defaultvalue == 'allowed'){
            $defaultvalue = '';
        }else{
            $defaultvalue = 'checked';
        }
        //echo "<pre>"; print_r($values); die;
        $viewer->assign('DEFAULTVALUE', $defaultvalue);
        $viewer->assign('VALUES', $values);
        //$viewer->assign('USERS', $users);
        //$viewer->assign('TYPE', $type);

        $viewer->view('AllowedIp.tpl', $qualifiedName);
	}
	
	function getPageTitle(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		return vtranslate('LBL_ALLOWED_IP',$qualifiedModuleName);
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
			"modules.Settings.$moduleName.resources.AllowedIp",
			'~/libraries/jquery/colorbox/jquery.colorbox-min.js',
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	function getHeaderCss(Vtiger_Request $request) {
		$headerCssInstances = parent::getHeaderCss($request);

		$cssFileNames = array(
			'~/libraries/jquery/colorbox/jquery.colorbox.css',
			'~/libraries/jquery/colorbox/colorbox.css',
		);
		$cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
		$headerCssInstances = array_merge($headerCssInstances, $cssInstances);

		return $headerCssInstances;
	}
}


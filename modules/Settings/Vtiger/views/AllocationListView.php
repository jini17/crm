<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/18/18
 * Time: 6:27 PM
 */


class Settings_Vtiger_AllocationListView_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        global $adb;

        $query = "SELECT * FROM allowed_ip ";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);
        $values = array();
        $users = array();
        $type = array();

        for($i=0;$i<$count;$i++){
            $values[$i]['checkbox'] = $adb->query_result($result, $i,'ip');
            $values[$i]['ip'] = $adb->query_result($result, $i,'ip');
            $values[$i]['user_name'] = $adb->query_result($result, $i,'user_name');
            $values[$i]['type'] = $adb->query_result($result, $i,'type');


        }

        //echo "<pre>"; print_r($values); die;

        $viewer->assign('VALUES', $values);
        //$viewer->assign('USERS', $users);
        //$viewer->assign('TYPE', $type);

       // $viewer->view('AllowedIp.tpl', $qualifiedName);
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

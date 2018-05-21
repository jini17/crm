<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/18/18
 * Time: 6:14 PM
 */


class Settings_Vtiger_LeaveTypeListView_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        global $adb;
        //$adb->setDebug(true);
        $query = "SELECT * FROM vtiger_leavetype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_claimtype.claimtypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);
        //echo "<pre>"; print_r($count); die;
        $values = array();
        $users = array();
        $type = array();

        for($i=0;$i<$count;$i++){
            $values[$i]['checkbox'] = $adb->query_result($result, $i,'claimtypeid');
            $values[$i]['claim_type'] = $adb->query_result($result, $i,'claim_type');
            $values[$i]['claim_code'] = $adb->query_result($result, $i,'claim_code');
            $values[$i]['claim_status'] = $adb->query_result($result, $i,'claim_status');
            if($values[$i]['claim_status'] == 'on'){
                $values[$i]['claim_status'] = 'Active';
            }else{
                $values[$i]['claim_status'] = 'Inactive';
            }

        }


        //echo "<pre>"; print_r($values); die;

        $viewer->assign('VALUES', $values);
        //$viewer->assign('USERS', $users);
        //$viewer->assign('TYPE', $type);

        $viewer->view('LeaveTypeDetailView.tpl', $qualifiedName);
    }

    function getPageTitle(Vtiger_Request $request) {
        $qualifiedModuleName = $request->getModule(false);
        return vtranslate('LBL_LEAVE_TYPE',$qualifiedModuleName);
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
            "modules.Settings.$moduleName.resources.LeaveType",
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

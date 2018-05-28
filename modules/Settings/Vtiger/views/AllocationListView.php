<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/18/18
 * Time: 6:14 PM
 */


class Settings_Vtiger_AllocationListView_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        global $adb;
        //$adb->setDebug(true);
        $query = "SELECT * FROM Allocation_list";
        $resultalloc = $adb->pquery($query,array());
        $count = $adb->num_rows($resultalloc);

        $values = array();
        $users = array();
        $type = array();

        for($i=0;$i<$count;$i++){
            $values[$i]['checkbox'] = $adb->query_result($resultalloc, $i,'allocation_id');
            $leavetype_id = $adb->query_result($resultalloc, $i,'leavetype_id');


            /**** Getting the name of the leave type ******************/
            $query = "SELECT * FROM vtiger_leavetype WHERE leavetypeid = ?";
            $result = $adb->pquery($query,array($leavetype_id));
            $values[$i]['leavetype'] = $adb->query_result($result,0,'title');

            /**** Getting the name of the claim type ******************/
            $claimtype_id = $adb->query_result($resultalloc, $i,'claimtype_id');
            $query = "SELECT * FROM vtiger_claimtype WHERE claimtypeid = ?";
            $result = $adb->pquery($query,array($claimtype_id));
            $values[$i]['claimtype'] = $adb->query_result($result,0,'claim_type');

            /**** Getting the name of the grade ******************/
            $grade_id = $adb->query_result($resultalloc, $i,'grade_id');
            $query = "SELECT * FROM vtiger_grade WHERE gradeid = ?";
            $result = $adb->pquery($query,array($grade_id));
            $values[$i]['grade'] = $adb->query_result($result,0,'grade');



           // $benifittype_id = $adb->query_result($result, $i,'benefittype_id');

            $values[$i]['status'] = $adb->query_result($result, $i,'status');

        }

       //echo "<pre>"; print_r($values); die;

        $viewer->assign('VALUES', $values);

        $viewer->view('AllocationDetailView.tpl', $qualifiedName);
    }

    function getPageTitle(Vtiger_Request $request) {
        $qualifiedModuleName = $request->getModule(false);
        return vtranslate('LBL_ALLOCATION_TYPE',$qualifiedModuleName);
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
            "modules.Settings.$moduleName.resources.Allocation",
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

<?php
/**
 * Created by PhpStorm.
 * Modified By Mabruk
 * User: root
 * Date: 5/18/18
 * Time: 6:14 PM
 */


class Settings_Vtiger_ClaimAllocationListView_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        global $adb;
        //$adb->setDebug(true);
        $query = "SELECT * FROM allocation_list";
        $resultalloc = $adb->pquery($query,array());
        $count = $adb->num_rows($resultalloc);

        $values = array();
        $users = array();
        $type = array();

        // Modified By Mabruk
        for($i=0;$i<$count;$i++){ 
            $allocationId = $values[$i]['checkbox'] = $adb->query_result($resultalloc, $i,'allocation_id');
            //$values[$i]['allocationtitle'] = $adb->query_result($resultalloc, $i,'allocation_title');           


            /**** Getting the name of the leave type ******************/
            /*$query = "SELECT * FROM vtiger_leavetype WHERE leavetypeid = ?";
            $result = $adb->pquery($query,array($leavetype_id));
            $values[$i]['leavetype'] = $adb->query_result($result,0,'title');*/

            $values[$i]['allocationtitle'] = $adb->query_result($resultalloc, $i,'allocation_title');
            /**** Getting the name of the claim type ******************/
            $claimTypeResult = $adb->pquery("SELECT GROUP_CONCAT(claim_type) AS claims FROM vtiger_claimtype INNER JOIN allocation_claimrel ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid WHERE allocation_claimrel.allocation_id = ?", array($allocationId));

            $values[$i]['claimtype'] = $adb->query_result($claimTypeResult,0,'claims');
        

            /**** Getting the name of the grade ******************/
            $gradeResult = $adb->pquery("SELECT GROUP_CONCAT(grade) AS grade FROM vtiger_grade INNER JOIN allocation_graderel ON allocation_graderel.grade_id = vtiger_grade.gradeid WHERE allocation_graderel.allocation_id = ?", array($allocationId));

            $values[$i]['grade'] = $adb->query_result($gradeResult,0,'grade');



           // $benifittype_id = $adb->query_result($result, $i,'benefittype_id');
            $status = $adb->query_result($resultalloc, $i,'status');
           // echo "<br>Status : ".$status;
            if($status=='on'){
                $values[$i]['status'] = 'Active';
            }
            else{
                $values[$i]['status'] = 'Inactive';
            }

        }

       //echo "<pre>"; print_r($values); die;

        $viewer->assign('VALUES', $values);

        $viewer->view('ClaimAllocationDetailView.tpl', $qualifiedName);
    }

    function getPageTitle(Vtiger_Request $request) {
       $qualifiedModuleName = $request->getModule(false);
        return vtranslate('LBL_ALLOCATION_TYPE','Vtiger');
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
            "modules.Settings.$moduleName.resources.Allocation",
            '~/libraries/jquery/colorbox/jquery.colorbox-min.js',
            '~/libraries/jquery/Toggle-Switches-Switcher/jquery.switcher.js',
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
            '~/libraries/jquery/Toggle-Switches-Switcher/switcher.css',
        );
        $cssInstances = $this->checkAndConvertCssStyles($cssFileNames);
        $headerCssInstances = array_merge($headerCssInstances, $cssInstances);

        return $headerCssInstances;
    }
}

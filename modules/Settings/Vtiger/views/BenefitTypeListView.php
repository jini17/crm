<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 5/18/18
 * Time: 6:14 PM
 */


class Settings_Vtiger_BenefitTypeListView_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        global $adb;
        //$adb->setDebug(true);




        $query = "SELECT vtiger_benefittype.* FROM vtiger_benefittype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_benefittype.benefittypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);
        //echo "<pre>"; print_r($count); die;
        $values = array();
        $users = array();
        $type = array();

        for($i=0;$i<$count;$i++){
            $values[$i]['checkbox'] = $adb->query_result($result, $i,'benefittypeid');
            $values[$i]['benefit_title'] = $adb->query_result($result, $i,'title');
            $values[$i]['benefit_code'] = $adb->query_result($result, $i,'benefit_code');
            $values[$i]['benefit_status'] = $adb->query_result($result, $i,'status');
           // echo $adb->query_result($result, 1,'status');die;
            if($values[$i]['benefit_status'] == 'on'){
                $values[$i]['benefit_status'] = 'Active';
            }else{
                $values[$i]['benefit_status'] = 'Inactive';
            }

        }


     //  echo "<pre>"; print_r($values); die;

        $viewer->assign('VALUES', $values);
        //$viewer->assign('USERS', $users);
        //$viewer->assign('TYPE', $type);

        $viewer->view('BenefitTypeDetailView.tpl', $qualifiedName);
    }

    function getPageTitle(Vtiger_Request $request) {
        $qualifiedModuleName = $request->getModule(false);
        return vtranslate('LBL_BENEFIT_TYPE',$qualifiedModuleName);
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
            "modules.Settings.$moduleName.resources.BenefitType",
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

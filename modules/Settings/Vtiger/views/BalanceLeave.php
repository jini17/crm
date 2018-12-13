<?php
/**
 * Created by PhpStorm.
 * Modified By Jitu
 * User: root
 */


class Settings_Vtiger_BalanceLeave_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
        $qualifiedName = $request->getModule(false);
        $viewer = $this->getViewer($request);
        
        $db = PearDatabase::getInstance();
        $query = "SELECT vtiger_grade.gradeid, vtiger_grade.grade FROM vtiger_grade 
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_grade.gradeid
                WHERE vtiger_crmentity.deleted=0";
         $result = $db->pquery($query, array());
         $numrows = $db->num_rows($result);
         $grades = array();
        
         for($i=0; $i<$numrows;$i++) {
             $grades[$db->query_result($result,$i, 'gradeid')] = $db->query_result($result,$i, 'grade');
         }      
        $userList =  Users_Record_Model::getAll(true);
        $user_model = Users_Record_Model::getCurrentUserModel();
        $leavetypes = Users_LeavesRecords_Model::getAllLeaveTypeList();
        $viewer = $this->getViewer($request);
        $usersleavestatus = $user_model->UsersLeaveStatus();

        $viewer->assign('USERS_LEAVESTATUS',$usersleavestatus);
        $viewer->assign('LEAVETYPES',$leavetypes);
        $viewer->assign('UsersList',$userList);
        $viewer->assign('Grades', $grades);
        $viewer->assign('MODULE',$moduleName);
        $viewer = $this->getViewer($request);
        $viewer->view('CheckUserLeaveStatus.tpl',$qualifiedName);
    }

    function getPageTitle(Vtiger_Request $request) {
       $qualifiedModuleName = $request->getModule(false);
        return vtranslate('Year End Process','Vtiger');
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

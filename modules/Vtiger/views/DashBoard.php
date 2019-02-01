<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Dashboard_View extends Calendar_TaskManagement_View {

        protected static $selectable_dashboards;

        function checkPermission(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                if(!Users_Privileges_Model::isPermitted($moduleName, $actionName)) {
                        throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
                }
        }

        function preProcess(Vtiger_Request $request, $display=true) {
                parent::preProcess($request, false);
                $viewer = $this->getViewer($request);
                $moduleName = $request->getModule();
                //get last login time & IP address
                global $adb;
               // $adb->setDebug(true);
                $current_user = Users_Record_Model::getCurrentUserModel();  
                $sUserName = $current_user->user_name;
                $sql="select login_time from vtiger_loginhistory WHERE user_name ='$sUserName' ORDER BY login_time DESC LIMIT 1,1";
                $result=$adb->pquery($sql, array());
                $rows=$adb->num_rows($result);

                if ($rows == 0){
                        $sql="select login_time,user_ip from vtiger_loginhistory WHERE status='Signed in' AND user_name ='$sUserName' ORDER BY login_id DESC";
                }else{
                        $sql="select login_time,user_ip from vtiger_loginhistory WHERE user_name ='$sUserName' ORDER BY login_time DESC LIMIT 1,1";
                }

                $result = $adb->pquery($sql, array());
                $sLastLoginTime = decode_html($adb->query_result($result,0,'login_time'));
                $sLastUserIP = decode_html($adb->query_result($result,0,'user_ip'));
                $viewer->assign("LAST_LOGIN_TIME", $sLastLoginTime);
                $viewer->assign("LAST_USER_IP", $sLastUserIP);
                //End here
                 
                $Trial_expire = Users_Record_Model::trial_expire();
                
                $viewer->assign("TRIAL_INFO",$Trial_expire);
                 if($_SESSION['loggedin_now'] === false){
                    $viewer->assign("LOGGED_NOW",'in');
                    $_SESSION['loggedin_now'] = TRUE;
                 }
                 else{
                        $viewer->assign("LOGGED_NOW",'out');
                 }
            
                 if($_SESSION['multi_login'] == "yes"){
                       $viewer->assign("MULTI_LOGIN",'yes');
                     $_SESSION['multi_login'] = "no";
                 }
                 else{
                       $viewer->assign("MULTI_LOGIN",'no');
                 }
                 
                 if($_SESSION['first_time_login'] == 'yes'){
                      $_SESSION['first_time_login'] = "no";
                     $viewer->assign("LOGGED_FIRST_TIME",'no');
                 }
                 else{
                     $viewer->assign("LOGGED_FIRST_TIME",'no');
                 }
                 
                $crm_record_no = $this->CRM_ENTITY_CHECKER();

               if($crm_record_no){
                  $viewer->assign("DATA_RESET","Yes");
               }
               else {
                  $viewer->assign("DATA_RESET","No");
               }
                                                               
                $dashBoardModel = Vtiger_DashBoard_Model::getInstance($moduleName);
                //check profile permissions for Dashboards

                $moduleModel = Vtiger_Module_Model::getInstance('Dashboard');
                $userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
                $permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

                if($permission) {
                        // TODO : Need to optimize the widget which are retrieving twice
                        $dashboardTabs = $dashBoardModel->getActiveTabs();
                        if ($request->get("tabid")) {
                                $tabid = $request->get("tabid");
                        } else {
                                // If no tab, then select first tab of the user
                                $tabid = $dashboardTabs[0]["id"];
                        }
                        $dashBoardModel->set("tabid", $tabid);
                        $widgets = $dashBoardModel->getSelectableDashboard();
                        self::$selectable_dashboards = $widgets;
                } else {
                        $widgets = array();
                }

                $viewer->assign('MODULE_PERMISSION', $permission);
                $viewer->assign('WIDGETS', $widgets);
                $viewer->assign('MODULE_NAME', $moduleName);

                if($display) {
                    $this->preProcessDisplay($request);
                }
        }

        function preProcessTplName(Vtiger_Request $request) {
                return 'dashboards/DashBoardPreProcess.tpl';
        }

        function process(Vtiger_Request $request) {
        
                $viewer = $this->getViewer($request);
                $moduleName = $request->getModule();
                $dashBoardModel = Vtiger_DashBoard_Model::getInstance($moduleName);
                $current_user = 
                //check profile permissions for Dashboards
                $moduleModel = Vtiger_Module_Model::getInstance('Dashboard');
                $userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
                $permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());
                if($permission) {
                        // TODO : Need to optimize the widget which are retrieving twice
                   $dashboardTabs = $dashBoardModel->getActiveTabs();
                   if($request->get("tabid")){
                           $tabid = $request->get("tabid");
                   } else {
                           // If no tab, then select first tab of the user
                           $tabid = $dashboardTabs[0]["id"];
                   }
                   $dashBoardModel->set("tabid",$tabid);
                        $widgets = $dashBoardModel->getDashboards($moduleName);
                } else {
                        return;
                }

                $viewer->assign('MODULE_NAME', $moduleName);
                $viewer->assign('WIDGETS', $widgets);
                $viewer->assign('DASHBOARD_TABS', $dashboardTabs);
                $viewer->assign('DASHBOARD_TABS_LIMIT', $dashBoardModel->dashboardTabLimit);
                $viewer->assign('SELECTED_TAB',$tabid);
                $current_user = Users_Record_Model::getCurrentUserModel();

            if(self::$selectable_dashboards) {
            
                      
                        $viewer->assign('SELECTABLE_WIDGETS', self::$selectable_dashboards);
                        $viewer->assign("EMPLOYEE_GROUP", $this->get_widgets_by_group("employee", $modulename,$current_user->get("id"),$tabid));


                        $viewer->assign("SALES", $this->get_widgets_by_group("sales", $modulename,$current_user->get("id"),$tabid));
                        $viewer->assign("SERVICE", $this->get_widgets_by_group("service", $modulename,$current_user->get("id"),$tabid));


                        $viewer->assign("CHART_GROUP", $this->get_widgets_by_group("chart", $modulename,$current_user->get("id"),$tabid));
                        $viewer->assign("LEAVECLAIM_GROUP",  $this->get_widgets_by_group("leaveclaim", $modulename,$current_user->get("id"),$tabid));
                        $viewer->assign("GENERAL_GROUP",  $this->get_widgets_by_group("general", $modulename,$current_user->get("id"),$tabid));
            }
            
                $viewer->assign('CURRENT_USER', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('TABID',$tabid);
                $viewer->view('dashboards/DashBoardContents.tpl', $moduleName);
        }

        public function postProcess(Vtiger_Request $request) {
                parent::postProcess($request);
        }
        
        
    /**
     * GET tabs  by group
     * @param type $group
     * @param type $modulename
     */
        public function get_widgets_by_group($group,$modulename,$userid,$tab_id){
            $data = array();
            $db   = PearDatabase::getInstance(); 
            //$db->setDebug(true);
            // Update By Mabruk
            $sql = "SELECT * from vtiger_links 
                    INNER JOIN vtiger_module_dashboard_widgets ON vtiger_module_dashboard_widgets.linkid = vtiger_links.linkid
                    WHERE linktype = 'DASHBOARDWIDGET' 
                    AND widgetgroup = '$group'
                    AND userid = '$userid'
                    AND dashboardtabid = '$tab_id'";             

            $query = $db->pquery($sql,array());
            $num_rows =  $db->num_rows($query);
            if($num_rows > 0){
                for($i =0; $i < $num_rows; $i++){

                    $data[$i]["URL"]        = $db->query_result($query, $i,'linkurl')."&linkid=".$db->query_result($query, $i,'linkid');
                    $data[$i]['linkid']     = $db->query_result($query, $i,'linkid');
                    $data[$i]['name']       = $db->query_result($query, $i,'linklabel');
                    $data[$i]['title']      = vtranslate($db->query_result($query, $i,'linklabel'), $modulename);  
                    $data[$i]['is_closed']  = $db->query_result($query, $i,'is_closed'); 
                    $data[$i]['width']      = 1;
                    $data[$i]['height']     = 1;
                    
                }
            }
            
            return $data;
        }

        public function is_widget_used($user_id,$tab_id,$linkid){
            $db = PearDatabase::getInstance();
            $sql = "SELECT * from vtiger_module_dashboard_widgets WHERE userid=$userid AND dashboardtabid = '$tab_id' AND linkid = '$linkid'";
            $query = $db->pquery($sql,array());
            $num_rows = $db->num_rows($query);
            if($num_rows > 0){
                return 1;
            }
            return 0;
        }

        /**
         * Added By Khaled
         * @return boolean
         */
        public function CRM_ENTITY_CHECKER(){
            $db = PearDatabase::getInstance();
            $query = $db->pquery("SELECT count(*) as total_rows FROM   vtiger_crmentity ");
            if($db->query_result($query,0,'total_rows') > 0){
                return true;
            }
            else{
                 return false;
            }
        }
        /**
         * Function to get the list of Script models to be included
         * @param Vtiger_Request $request
         * @return <Array> - List of Vtiger_JsScript_Model instances
         */
        public function getHeaderScripts(Vtiger_Request $request) {
                $headerScriptInstances = parent::getHeaderScripts($request);
                $moduleName = $request->getModule();

                $jsFileNames = array(
                        '~/libraries/jquery/gridster/jquery.gridster.min.js',
                        '~/libraries/jquery/jqplot/jquery.jqplot.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.canvasTextRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.pieRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.barRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.categoryAxisRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.pointLabels.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.funnelRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.barRenderer.min.js',
                        '~/libraries/jquery/jqplot/plugins/jqplot.logAxisRenderer.min.js',
                        '~/libraries/jquery/VtJqplotInterface.js',
                        '~/libraries/jquery/vtchart.js',
                        '~layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/lib/jquery/gridster/jquery.gridster.min.js',
                        '~/libraries/jquery/vtchart.js',
                        'modules.Vtiger.resources.DashBoard',
                        'modules.'.$moduleName.'.resources.DashBoard',
                        'modules.Vtiger.resources.dashboards.Widget',
                        '~/layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/modules/Vtiger/resources/Detail.js',
                        '~/layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/modules/Reports/resources/Detail.js',
                        '~/layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/modules/Reports/resources/ChartDetail.js',
                        "modules.Emails.resources.MassEdit",
                        "modules.Vtiger.resources.CkEditor",
                        "~layouts/".Vtiger_Viewer::getDefaultLayoutName()."/lib/bootstrap-daterangepicker/moment.js",
                        "~layouts/".Vtiger_Viewer::getDefaultLayoutName()."/lib/bootstrap-daterangepicker/daterangepicker.js",
                );

                $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
                $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
                return $headerScriptInstances;
        }

        /**
         * Function to get the list of Css models to be included
         * @param Vtiger_Request $request
         * @return <Array> - List of Vtiger_CssScript_Model instances
         */
        public function getHeaderCss(Vtiger_Request $request) {
                $parentHeaderCssScriptInstances = parent::getHeaderCss($request);

                $headerCss = array(
                        '~layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/lib/jquery/gridster/jquery.gridster.min.css',
                        '~layouts/'.Vtiger_Viewer::getDefaultLayoutName().'/lib/bootstrap-daterangepicker/daterangepicker.css',
                        '~libraries/jquery/jqplot/jquery.jqplot.min.css'
                );
                $cssScripts = $this->checkAndConvertCssStyles($headerCss);
                $headerCssScriptInstances = array_merge($parentHeaderCssScriptInstances , $cssScripts);
                return $headerCssScriptInstances;
        }



    public function generateColors(Vtiger_Request $request) {
        $moduleName = $request->getModule();
        $moduleName = 'Calendar';
        $module = Vtiger_Module_Model::getInstance($moduleName);
        $field = Vtiger_Field_Model::getInstance('taskpriority', $module);
        $priorities = $field->getPicklistValues();

        if (!$request->get('colors')) {
            $colors = array();
            foreach ($priorities as $key => $value) {
                $colors[$key] = $this->getColor($key);
            }
        } else {
            $colors = $request->get('colors');
        }
        return $colors;
    }

    public function getColor($priority) {
        $color = '';
        switch ($priority) {
            case 'High':$color = '#FF5555'; break;
            case 'Medium':$color = '#03C04A';   break;
            case 'Low':$color = '#54A7F5';  break;
            default:    $color = '#'.dechex(rand(0x000000, 0xFFFFFF));
                break;
        }
        return $color;
    }
}

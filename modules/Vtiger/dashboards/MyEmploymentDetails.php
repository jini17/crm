<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_MyEmploymentDetails_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {
            global $site_URL;
                $db = PearDatabase::getInstance();
               // $db->setDebug(true);
                $currentUser            = Users_Record_Model::getCurrentUserModel();
                $viewer                      = $this->getViewer($request);
                $moduleName         = $request->getModule();
                $departmentList     = getAllPickListValues('department');
                $moduleModel        = Home_Module_Model::getInstance($moduleName);
                $dept                         = $request->get('department');
                $page                        = $request->get('page');
                $linkId                         = $request->get('linkid');
print_r($currentUser);
                $moduleModel  = Home_Module_Model::getInstance($moduleName);
                $widget               = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
                
                $users                  = $this->get_employee($db, $dept);
                $first_name = $currentUser->get('first_name');
                $job_grade = $this->grade($currentUser->get('id'));
                $designation =  $currentUser->get('designation');
                $department = $currentUser->get('department');
                $reportto       = "";
                $contract_expiry = "";
                
                $viewer->assign('REQUEST_DEPARTMENT', $dept);
                $viewer->assign('DEPARTMENT', $departmentList);
                $viewer->assign('WIDGET', $widget);
                $viewer->assign('MODULE_NAME', $moduleName);
                $viewer->assign('DATA', $users);
                $viewer->assign('URL',$site_URL);

                $content = $request->get('content');
             
//                if(!empty($content)) {
//                        $viewer->view('dashboards/MyEmploymentDetailsContents.tpl', $moduleName);
//                } else {
//                        $viewer->view('dashboards/MyEmploymentDetails.tpl', $moduleName);
//                }
                
        }

        
        function getHeaderScripts(Vtiger_Request $request) { 
                $headerScriptInstances = parent::getHeaderScripts($request);
                $moduleName = $request->getModule();
                $jsFileNames = array(
                        "modules.Emails.resources.MassEdit"
                );
                $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
                $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
                return $headerScriptInstances;
        }

        /**
         * Get the Grade
         * @param type $db
         * @param type $id
         * @return type
         */
        function grade($db,$id){
             $sql = "SELECT grade from vtiger_grade WHERE gradeid = $id ";
             $query = $db->pquery($sql,array());
             $grade = $db->query_result($query,0,'grade');
             return $grade;
        }
        
        /**
         * Get Reporting Manage 
         * @param type $db
         * @param type $id
         * @return type
         */
        function report_to($db,$id){
            $sql = "select first_name from vtiger_users WHERE id = $id"; 
              $query = $db->pquery($sql,array());
             $report_to = $db->query_result($query,0,'first_name');
             return $report_to;
        }
        /**
   * 
   * @param type $db
   * @param type $department
   * @return string
   */
        function get_employee($db,$department){
        $sql = "SELECT id,first_name,last_name,department FROM vtiger_users WHERE status = 'Active' ";
        
        if($department != NULL){
            $sql .= "  AND  department='$department'";
        }
        
        $query = $db->pquery($sql);
        $numrows = $db->num_rows($query);
        $data = array();
        
        for($i =0; $i < $numrows; $i++ ){
            $data[$i]['empid'] = $db->query_result($query,$i,'id');
            $data[$i]['first_name'] = $db->query_result($query,$i,'first_name');
            $data[$i]['last_name'] = $db->query_result($query,$i,'last_name');
            $data[$i]['department'] = $db->query_result($query,$i,'department');
        }
        print_r();
        return $data;
    }        
        

       
}


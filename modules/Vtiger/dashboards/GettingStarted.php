<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_GettingStarted_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {
            global $site_URL;
                $db = PearDatabase::getInstance();
               // $db->setDebug(true);
                $currentUser            = Users_Record_Model::getCurrentUserModel();
                $viewer                       = $this->getViewer($request);
                $moduleName         = $request->getModule();                
                $moduleModel       = Home_Module_Model::getInstance($moduleName);
                $widget                    = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
               
                $viewer->assign('WIDGET', $widget);
                $viewer->assign('MODULE_NAME', $moduleName);
            
                $viewer->assign('URL',$site_URL);

                $content = $request->get('content');
             
                if(!empty($content)) {
                        $viewer->view('dashboards/GettingStartedContents.tpl', $moduleName);
                } else {
                        $viewer->view('dashboards/GettingStarted.tpl', $moduleName);
                }
                
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
           
            $data                   = array();
            $sql                      = "select id,first_name,last_name from vtiger_users WHERE id = $id"; 
            $query                = $db->pquery($sql,array());
            $report_to        = $db->query_result($query,0,'first_name');
            $data['name']  = $report_to ." ".$db->query_result($query,0,'last_name');
            $data['id']          = $db->query_result($query,0,'id');
             return $data;
        }
        /**
   * 
   * @param type $db
   * @param type $department
   * @return string
   */
        function get_employee($db,$department){
        $sql = "SELECT id,first_name,last_name,department FROM vtiger_users WHERE status = 'Active' ";
        

        $query               = $db->pquery($sql);
        $numrows        = $db->num_rows($query);
        $data                 = array();
        
        for($i =0; $i < $numrows; $i++ ){
            $data[$i]['empid']                = $db->query_result($query,$i,'employee_no');
            $data[$i]['first_name']       = $db->query_result($query,$i,'first_name');
            $data[$i]['last_name']        = $db->query_result($query,$i,'last_name');
            $data[$i]['department']     = $db->query_result($query,$i,'department');
            $data[$i]['department']     = $db->query_result($query,$i,'department');
        }
        
        return $data;
    }        

    /**
     * SELECT * FROM `` 
     * @param type $db
     * @param type $id
     * @return type
     */
    public function get_designation_job_type($db,$id){
        $sql = "SELECT  vtiger_employeecontract.employeecontractid as employeecontractid,contract_expiry_date,designation,job_type from vtiger_employeecontract "
                . " INNER JOIN vtiger_employeecontractcf ON vtiger_employeecontract.employeecontractid = vtiger_employeecontractcf.employeecontractid "
                . " WHERE vtiger_employeecontract.employee_id = ".$id;
        $query                         = $db->pquery($sql,array());
        $djt['deg']                   = $db->query_result($query,0,'designation');
        $djt['job_type']        = $db->query_result($query,0,'job_type');
        $djt['contract_id']        = $db->query_result($query,0,'employeecontractid');
          $djt['exp_date']        = $db->query_result($query,0,'contract_expiry_date');
        return $djt;
        
    }
    
    public function  get_contract_start_date($db,$id){
        
        $sql                         = "SELECT DATE_FORMAT(createdtime,'%M %d, %Y') as started_from from vtiger_crmentity WHERE `setype` LIKE '%contract%' AND `smownerid` = $id ";
        $query                   = $db->pquery($sql,array());
        $contract_start  = $db->query_result($query,0,'started_from');
        return $contract_start;
        
    }
    
    public function get_image($db,$id,$name){
        return $name;
        $sql = "SELECT path from vtiger_attachments WHERE attachementid = $id AND name ='$name' ";
         $query                   = $db->pquery($sql,array());
        $path   = $db->query_result($query,0,'path');
        return $path.$name;
        
        
    }
    

       
}



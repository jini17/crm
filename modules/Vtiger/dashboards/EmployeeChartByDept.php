<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_EmployeeChartByDept_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {
               global $site_URL;
                $db = PearDatabase::getInstance();
                //$db->setDebug(true);
                $currentUser        = Users_Record_Model::getCurrentUserModel();
                $viewer                   = $this->getViewer($request);
                $moduleName      = $request->getModule();
                $departmentList  = getAllPickListValues('department');
                $age_groupList    = getAllPickListValues('age_group');
                $genderList           = getAllPickListValues('gender');
                
                $department     = $request->get('department');
                $gender              = $request->get('gender');
                $age_group       = $request->get('age_group');
                $chartTYPE          = $request->get('type');
                
//                if($chartTYPE ==''){
//                    $chartTYPE  = 'pieChart';
//                }
                $dept                  = $this->department($deparment);
                $agegroup         = $this->age_group($age_group);
                $Gender             = $this->gender($gender);
                
                $moduleModel = Home_Module_Model::getInstance($moduleName);
                
                $viewer->assign('REQUEST_DEPARTMENT', $dept);
                $viewer->assign('REQUEST_AGE_GROUP', $agegroup);
                $viewer->assign('REQUEST_GENDER', $Gender);
                
                $viewer->assign('DEPARTMENT', $departmentList);
                $viewer->assign('AGE_GROUP', $age_groupList);
                $viewer->assign('GENDER', $genderList);
                $viewer->assign('CHART_TYPE',$chartTYPE);
               
                $page     = $request->get('page');
                $linkId     = $request->get('linkid');
             
                $moduleModel  = Home_Module_Model::getInstance($moduleName);
                $empbydept       = $this->get_employee_by_dept($db,$department,$site_URL);
                $widget               = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId(), $request->get('tab'));

                //print_r($empbydept);
                $viewer->assign('WIDGET', $widget);
                $viewer->assign('MODULE_NAME', $moduleName);

                $viewer->assign('DATA', json_encode($empbydept));

                $content = $request->get('content');
            
                if(!empty($content)) {
                        $viewer->view('dashboards/EmployeeChartByDeptContents.tpl', $moduleName);
                } else {
                        $viewer->view('dashboards/EmployeeChartByDept.tpl', $moduleName);
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
 * 
 * @param type $deparment
 * @return type
 */
        function department($deparment){
            if($department=='' || $department==null){
                                                $department = 'Technical';
            }
                return $deparment;
        }
        /**
         * 
         * @param string $agroup
         * @return string
         */
        function age_group($agroup){
                if($agroup=='' || $agroup==null){
                            $agroup = 'Gen X';
                         }
                         return $agroup;

        }
        /**
         * 
         * @param string $gender
         * @return string
         */
        function gender($gender){
               if($gender=='' || $gender==null){
                                                $gender = 'Male';
            }
            return $gender;
        }
        
        /**
         * Employee Chart By Department 
         * @param type $db
         * @param type $where
         * @return type
         */
        public function get_employee_by_dept($db,$where,$url){
           //$db->setDebug(TRUE);
            $data = array();
            $sql = 'SELECT vtiger_employeecontract.department as dept,COUNT(*) as total FROM vtiger_employeecontract   INNER JOIN vtiger_department ON vtiger_employeecontract.department = vtiger_department.department WHERE color !="" ';
              if($where != NULL){
                  $sql .= " AND vtiger_employeecontract.department='$where' ";                  
              }
              
            $sql .= ' group BY vtiger_employeecontract.department';

           $query = $db->pquery($sql,array());
           $num_rows = $db->num_rows($query);
           if($num_rows > 0){
                for($i = 0; $i < $num_rows; $i++){
                     $dept= $db->query_result($query,$i,'dept');
                     $counts= $db->query_result($query,$i,'total');
                     $data['labels'][] ="&nbsp;".$dept;
                     $data['values'][] =$counts;
                      $data['links'][] =$url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["department","e","'.$dept.'"]]]';
                     $data['colors'][] =$this->get_dept_colors($db, $dept);
                }
           }
           else{
               $data['labels'][]    = "&nbsp;";
                $data['values'][]  = "";
                $data['links'][]      = $url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["department","e","'.$dept.'"]]]';
                $data['colors'][]   = "#ffffff";
           }
      
           return $data;
        }
        
        function get_dept_colors($db,$dept){
                $sql                = "SELECT * from vtiger_department where department = '$dept'";
                $query          = $db->pquery($sql);
                $numrows   = $db->num_rows($query);
                if($numrows > 0){
                    $color      = $db->query_result($query,0,'color');
                }
                else{
                    $color      = "#fff";
                }

                return $color;
        }
}

<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_EmployeeChartByAge_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {
                $db = PearDatabase::getInstance();
              // $db->setDebug(true);
                $currentUser        = Users_Record_Model::getCurrentUserModel();
                $viewer                   = $this->getViewer($request);
                $moduleName      = $request->getModule();
                $departmentList  = getAllPickListValues('department');
                $age_groupList    = getAllPickListValues('age_group');
                $genderList           = getAllPickListValues('gender');
                
                $department     = $request->get('type');
               if(empty($department)){
                   $department = NULL;
               }
              
//               echo $department;
                $gender              = $request->get('gender');
                $age_group       = $request->get('age_group');
//                $chartTYPE          = $request->get('type');
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
                $empbydept       = $this->get_employee_by_AGE($db,$department);
                $widget               = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());

           

                $viewer->assign('WIDGET', $widget);
                $viewer->assign('MODULE_NAME', $moduleName);

                $viewer->assign('DATA', json_encode($empbydept));

                $content = $request->get('content');
            
                if(!empty($content)) {
                        $viewer->view('dashboards/EmployeeChartByAgeContents.tpl', $moduleName);
                } else {
                        $viewer->view('dashboards/EmployeeChartByAge.tpl', $moduleName);
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
         * Get Age Group Chart Data
         * 
         * @param type $db
         * @param type $where
         * @return type
         */
        public function get_employee_by_AGE($db,$where=NULL){
           
            $data = array();
            $sql = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  != '0000' ";
           
           if($where != NULL){
               $sql .= "  AND department = '$where' ";
           }
            $sql .= " GROUP BY DATE_FORMAT(birthday,'%Y')";
   
           $query = $db->pquery($sql,array());
            $num_rows = $db->num_rows($query);
              
           if($num_rows > 0){
                for($i = 0; $i < $num_rows; $i++){
                     $age_year= $db->query_result($query,$i,'age_range');
                     $counts= $db->query_result($query,$i,'total');
                     if($age_year >= '1946' && $age_year <= '1954'){
                           $data['labels'][] ="Baby Boomers (1946-1954)";
                           $data['values'][] =$counts;
                     }
                     elseif($age_year >= '1955' && $age_year <= '1965'){
                          $data['labels'][] ="Boomers (1955-1965)";
                           $data['values'][] =$counts;
                     }
                     elseif($age_year >= '1966' && $age_year <= '1976'){
                          $data['labels'][] ="Generation X (1966-1976)";
                           $data['values'][] =$counts;
                     }
                     elseif($age_year >= '1977' && $age_year <= '1994'){
                          $data['labels'][] ="Generation Y (1977-1994)";
                           $data['values'][] =$counts;
                     }
                     else{
                          $data['labels'][] = [0,0];
                          $data['values'][] = [0,0];
                     }
                }
           }
             else{
               $data['labels'][] = [0,0];
               $data['values'][] = [0,0];
           }
           
           return $data;
        }
        
       
}

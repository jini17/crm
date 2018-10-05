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
            global $site_URL;
                $db = PearDatabase::getInstance();
               //$db->setDebug(true);
                $currentUser         = Users_Record_Model::getCurrentUserModel();
                $viewer                   = $this->getViewer($request);
                $moduleName      = $request->getModule();
                $departmentList  = getAllPickListValues('department');
                $age_groupList    = getAllPickListValues('age_group');
                $genderList           = getAllPickListValues('gender');
                $department        = $request->get('type');
                
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
                $empbydept       = $this->get_employee_by_AGE($db,$department,$site_URL);
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
        public function get_employee_by_AGE($db,$where=NULL,$url){
           
            $data = array();
           $sql_bbs = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  >= '1946'  AND  DATE_FORMAT(birthday,'%Y')  <=   '1954' ";
           $sql_bb = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  >= '1955'  AND  DATE_FORMAT(birthday,'%Y')  <=   '1965' ";
           $sql_x = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  >= '1966'  AND  DATE_FORMAT(birthday,'%Y')  <=   '1976'  ";
           $sql_y = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  >= '1977'  AND  DATE_FORMAT(birthday,'%Y')  <=   '1994'  ";
           $sql_z = "SELECT count(employeeno) as total,DATE_FORMAT(birthday,'%Y') as age_range from vtiger_users WHERE DATE_FORMAT(birthday,'%Y')  >= '1995'  AND  DATE_FORMAT(birthday,'%Y')  <=   '2012'  ";

           if($where != NULL){
               $sql .= "  AND department = '$where' ";
           }
            $sql .= " ";

           $bbs_query = $db->pquery($sql_bbs.$sql,array());
            $bb_query = $db->pquery($sql_bb.$sql,array());
            $genx_query = $db->pquery($sql_x.$sql,array());
            $geny_query = $db->pquery($sql_y.$sql,array());
             $genz_query = $db->pquery($sql_z.$sql,array());

            $data['labels'][] =  '&nbsp;Baby Boomers (1946-1954)' ;
            $data['values'][] = $db->query_result($bbs_query,0,'total');// (empty($db->query_result($bbs_query,0,'age_range'))?$db->query_result($bbs_query,0,'age_range'): $num_rows = $db->num_rows($bbs_query) );
            $data['links'][]    = $url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["birthday","h","01-01-1946"]],[["birthday","m","31-12-1954"]]]&nolistcache=1';
            $data['colors'][] = $this->get_agegroup_color($db, 'Baby Boomers (1946-1954)' );
            
            $data['labels'][] =  '&nbsp;Boomers (1955-1965)' ;
            $data['values'][] = $db->query_result($bb_query,0,'total');
            $data['links'][]    =$url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["birthday","h","01-01-1955"]],[["birthday","m","31-12-1965"]]]&nolistcache=1';
            $data['colors'][] = $this->get_agegroup_color($db, 'Boomers (1955-1965)' );
            
            $data['labels'][] =  "&nbsp;Generation X (1966-1976)" ;
            $data['values'][] =$db->query_result($genx_query,0,'total');//(empty($db->query_result($genx_query,0,'age_range'))?$db->query_result($genx_query,0,'age_range'): $num_rows = $db->num_rows($genx_query)  ); 
            $data['links'][]    =$url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["birthday","h","01-01-1966"]],[["birthday","m","31-12-1976"]]]&nolistcache=1';
            $data['colors'][] = $this->get_agegroup_color($db, 'Generation X (1966-1976)' );
   
            $data['labels'][] =  "&nbsp;Generation Y (1977-1994)" ;
            $data['values'][] =  $db->query_result($geny_query,0,'total');//(empty($db->query_result($genz_query,0,'age_range'))?$db->query_result($genz_query,0,'age_range'): $num_rows = $db->num_rows($genz_query) ); 
            $data['links'][]    = $url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["birthday","h","01-01-1977"]],[["birthday","m","31-12-1994"]]]&nolistcache=1';
            $data['colors'][] = $this->get_agegroup_color($db, 'Generation Y (1977-1994)' );
            
            $data['labels'][] =  "&nbsp;Generation Z (1995-2012)" ;
            $data['values'][] =  $db->query_result($genz_query,0,'total');//(empty($db->query_result($genz_query,0,'age_range'))?$db->query_result($genz_query,0,'age_range'): $num_rows = $db->num_rows($genz_query) ); 
            $data['links'][]    = $url.'/index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings&search_params=[[["birthday","h","01-01-1977"]],[["birthday","m","31-12-1994"]]]&nolistcache=1';
            $data['colors'][] = $this->get_agegroup_color($db, 'Generation Z (1995-2012)' );

         return $data;
        }
        
    function get_agegroup_color($db,$group){
        $sql = "SELECT age_group,color FROM vtiger_age_group  WHERE age_group='$group'";
        $query = $db->pquery($sql);
        $numrows = $db->num_rows($query);
        if($numrows > 0){
            $color = $db->query_result($query,0,'color');
        }
        else{
            $color = "#fff";
        }

        return $color;
    }        
        
}

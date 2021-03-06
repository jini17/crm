<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_ListViewAjax_View extends Vtiger_List_View{

        function __construct() {

                parent::__construct();
                        $this->exposeMethod('getUserEducation');
                        $this->exposeMethod('getUserWorkexp');
                        $this->exposeMethod('getUserSkills');
                        $this->exposeMethod('getUserProject');
                        $this->exposeMethod('getUserEmergency');
                        $this->exposeMethod('getUserLanguage');
                        $this->exposeMethod('getUserLeave');
                        $this->exposeMethod('getUserClaim');
                      //  $this->exposeMethod('getUsersLeaveStatus');
        }


        function process(Vtiger_Request $request) {;

                $mode = $request->get('mode');
                if(!empty($mode)) {
                    $this->invokeExposedMethod($mode, $request);
                  return;
               }
        }

        public function getUserEducation(Vtiger_Request $request){

                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $viewer->assign('MODULE',$moduleName);

                $EducationModuleModel = Users_EduModule_Model::getInstance();

                $eduUserModel	= Users_EduRecord_Model::getInstance();
                $eduList = $eduUserModel->getUserEducationList($recordId);
                $viewer->assign('EDUCATION_RECORD_MODEL',$EducationModuleModel);
                $viewer->assign('USERID',$recordId);

                $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('USER_EDUCATION_LIST',$eduList);

                echo $viewer->view('UsersEducation.tpl',$moduleName,true);
        }

        public function getUserWorkexp(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $viewer->assign('MODULE',$moduleName);

                $WorkExpModuleModel = Users_WorkExpModule_Model::getInstance();
                $WorkExpUserModel   = Users_WorkExpRecord_Model::getInstance();

                $viewer->assign('WORKEXP_RECORD_MODEL',$WorkExpModuleModel);
                $viewer->assign('USERID',$recordId);
                $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());

                $viewer->assign('USER_WORKEXP_LIST',$WorkExpUserModel->getUserWorkExpList($recordId));

                echo $viewer->view('UsersWorkExp.tpl',$moduleName,true);
        }

        public function getUserProject(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $viewer->assign('MODULE',$moduleName);

                $ProjectModuleModel	= Users_ProjectModule_Model::getInstance();

                $projectUserModel	= Users_ProjectRecord_Model::getInstance();
                $projectList = $projectUserModel->getUserProjectList($recordId);
                $viewer->assign('PROJECT_RECORD_MODEL',$ProjectModuleModel);
                $viewer->assign('USERID',$recordId);
                $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('USER_PROJECT_LIST',$projectList);

                echo $viewer->view('UsersProject.tpl',$moduleName,true);
        }

        public function getUserEmergency(Vtiger_Request $request) {
            $user_model = Users_Record_Model::getCurrentUserModel();
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $userid = $request->get('record');
      
                $EmergencyModuleModel= Users_EmergencyModule_Model::getInstance();

                $emergencyUserModel	= Users_EmergencyRecord_Model::getInstance();
                $viewer->assign('MODULE',$moduleName);	
                $viewer->assign('EMERGENCY_RECORD_MODEL',$EmergencyModuleModel);
                $viewer->assign('USERID',$userid);
                $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('USER_EMERGENCY_CONTACTS',$emergencyUserModel->getUserEmergencyContact($userid));
                echo $viewer->view('UsersEmergency.tpl',$moduleName,true);
        }

        public function getUserSkills(Vtiger_Request $request){ 
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $viewer->assign('MODULE',$moduleName);

                $LangModuleModel = Users_SkillsModule_Model::getLangInstance();

                $LangUserModel = Users_SkillsRecord_Model::getLangInstance();

                $SkillModuleModel = Users_SkillsModule_Model::getSkillInstance();
                $SkillUserModel = Users_SkillsRecord_Model::getSkillInstance();

                $viewer->assign('LANGUAGE_RECORD_MODEL',$LangModuleModel);
                $viewer->assign('SKILL_RECORD_MODEL',$SkillModuleModel);
                $viewer->assign('USERID',$recordId);
                $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
                $viewer->assign('USER_SOFTSKILL_LIST',$LangUserModel->getUserSoftSkillList($recordId));
                $viewer->assign('USER_SKILL_CLOUD',$SkillUserModel->getUserSkillCloud($recordId));
                $viewer->assign('SKILL_LIST',$SkillUserModel->getALLSKills($recordId));

                echo $viewer->view('UsersSkills.tpl',$moduleName,true);
        }
        public function getUserLanguage(Vtiger_Request $request){ 
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $viewer->assign('MODULE',$moduleName);

                $LangModuleModel = Users_SkillsModule_Model::getLangInstance();

                $LangUserModel = Users_SkillsRecord_Model::getLangInstance();

                $viewer->assign('LANGUAGE_RECORD_MODEL',$LangModuleModel);
                $viewer->assign('SKILL_RECORD_MODEL',$SkillModuleModel);
                $viewer->assign('USERID',$recordId);
                $viewer->assign('USER_MODEL', Users_SkillsRecord_Model::getCurrentUserModel());
                $viewer->assign('USER_SOFTSKILL_LIST',$LangUserModel->getUserSoftSkillList($recordId));
                echo $viewer->view('UsersSkills.tpl',$moduleName,true);
        }

        public function getUserLeave(Vtiger_Request $request) { 

                $db = PearDatabase::getInstance();
                //$db->setDebug(true);
                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record');
                $currentyear = date("Y");

                $selectedmember = '';
                $selectedleavetype = '';

                if(isset($_REQUEST['selyear'])) {
                        $currentyear = $request->get('selyear');
                }	
                if(isset($_REQUEST['selmember']) && $_REQUEST['selmember'] !='All') {
                        $selectedmember = $request->get('selmember');
                } 

                if(isset($_REQUEST['selleavetype']) && $_REQUEST['selleavetype'] !='All') {
                        $selectedleavetype = $request->get('selleavetype');
                }

                //check leave alloted to user or not
                $isCreate = count(Users_LeavesRecords_Model::getLeaveTypeList($recordId)) >0 ?true:false;

                $viewer->assign('ISCREATE',$isCreate);

                $manager = Users_LeavesRecords_Model::checkIfManager($recordId);

                $section  = $request->get('section');   

                $viewer->assign('MODULE',$moduleName);
                $viewer->assign('STARTYEAR',date('Y')-1);//Added By Jitu Date Combobox 
                $viewer->assign('ENDYEAR',(date('Y')+1));//Added By Jitu Date Combobox

                $viewer->assign('CREATE_LEAVE_URL', Users_LeavesRecords_Model::getCreateLeaveURL());
                $viewer->assign('USERID',$recordId);

                $viewer->assign('MANAGER',$manager);
                $viewer->assign('SECTION',$section);

                ####start Get My leave list##### 
                $myleaves = Users_LeavesRecords_Model::getMyLeaves($recordId, $currentyear); //echo $currentyear;
                $viewer->assign('CurrentDate', date('Y-m-d'));
                $viewer->assign('MYLEAVES', $myleaves);
                ####end my leave list###########

                $pageNumber = $request->get('pagenumber');//Added By Safuan MyTeamLeave Pagination
                if(empty($pageNumber)){
                        $pageNumber = '1';
                }

                $pageLimit = 5;// set number of row for each page here-//Added By Safuan MyTeamLeave Pagination

                ####start Get My Team leave list##### 
                $myteamleaves = Users_LeavesRecords_Model::getMyTeamLeave($recordId,$currentyear, $pageNumber, $pageLimit,$selectedmember,$selectedleavetype);
                $myteam = Users_LeavesRecords_Model::getMyTeamMembers($recordId);
                $leavetypelist = Users_LeavesRecords_Model::getTotaLeaveTypeList('','');
                $viewer->assign('MYTEAM', $myteam);
                $viewer->assign('LEAVETYPELIST', $leavetypelist);

                $viewer->assign('MYTEAMLEAVES', $myteamleaves);
                ####end my Team leave list###########

                ### Code for paging added by jitu@secondcrm.com on 28-01-2015####

                $totalCount = count(Users_LeavesRecords_Model::getMyTeamLeave($recordId,$currentyear, '', '',$selectedmember,$selectedleavetype));	//Added By Safuan MyTeamLeave Pagination
                $pageCount = ceil($totalCount / $pageLimit);

                if($pageNumber < $pageCount){
                        $nextpageexist = 1;		
                }else{
                        $nextpageexist = 0;		
                }
                if($pageNumber > 1){
                        $prevpageexist = 1;		
                }else{
                        $prevpageexist = 0;
                }

                $start = ($pageNumber -1)*$pageLimit+1;


                $end = $pageNumber * $pageLimit;
                if($end > $totalCount) {
                        $end = $totalCount;
                }
                if($totalCount ==0) {
                        $start = 0;
                        $end = 0;
                }

                $pagingModel = new Vtiger_Paging_Model();
                $pagingModel->set('page', $pageNumber);

                $pagingModel->set('prevPageExists', $prevpageexist);
                $pagingModel->set('range', array('start'=>$start, 'end'=>$end));
                $pagingModel->set('nextPageExists', $nextpageexist);
                $pcount = $pageCount;
                if($pageCount == 0){
                        $pageCount = 1;
                }

                $viewer->assign('PAGE_COUNT', $pageCount);
                $viewer->assign('PCOUNT',$pcount);
                $viewer->assign('LISTVIEW_COUNT', $totalCount);

                $viewer->assign('PAGE_LIMIT',$pageLimit);
                $viewer->assign('PAGING_MODEL', $pagingModel);

                $viewer->assign('PAGE_NUMBER',$pageNumber);
                $viewer->assign('LISTVIEW_ENTRIES_COUNT', '9');
                ### End	of code #################################################



                echo $viewer->view('UserLeaves.tpl',$moduleName,true);
        }


        public function getUserClaim(Vtiger_Request $request) { 
                $db = PearDatabase::getInstance();

                $moduleName = $request->getModule();
                $viewer = $this->getViewer($request);
                $recordId = $request->get('record'); 
                $currentyear = date("Y");

                //if year end process run then user can apply leave for next year other wise current year
                /*$sql  = "SELECT MAX(year) as year from secondcrm_user_balance LIMIT 0,1";
                $res = $db->pquery($sql,array());
                $currentyear = $db->query_result($res, 0, 'year');*/

                if($currentyear > date("Y")) {
                        $currentyear = $currentyear;	
                 } //end here 

                $selectedmember = '';
                $selectedclaimtype = '';

                if(isset($_REQUEST['selyear'])) {
                        $currentyear = $request->get('selyear');

                }	

                if(isset($_REQUEST['selmember']) && $_REQUEST['selmember'] !='All') {
                        $selectedmember = $request->get('selmember');
                } 

                if(isset($_REQUEST['selclaimtype']) && $_REQUEST['selclaimtype'] !='All') {
                        $selectedclaimtype = $request->get('selclaimtype');
                }


                //check leave alloted to user or not
                //$isCreate = Users_ClaimRecords_Model::hasAllocateLeave($recordId);
                $jobgrade = Users_ClaimRecords_Model::getJobGrade($recordId); 
                $_SESSION["myjobgrade"] = $jobgrade;

                //$_SESSION["favcolor"] = "yellow"; echo "hai"; echo $_SESSION["myjobgrade"]; echo $_SESSION["favcolor"];echo "hai";
                //check if he/she is already apply then restrict to user

                $isCreate = count(Users_ClaimRecords_Model::getClaimTypeList($recordId)) >0 ?true:false;

                $viewer->assign('ISCREATE',$isCreate);

                $manager = Users_ClaimRecords_Model::checkIfManager($recordId);
                $section  = $request->get('section');   

                $viewer->assign('MODULE',$moduleName);
                $viewer->assign('CURRENTYEAR',date('Y'));//Added By Jitu Date Combobox 
                $viewer->assign('CURYEAR',(date('Y')+1));//Added By Jitu Date Combobox
                $viewer->assign('STARTYEAR',date('Y')-1);//Added By Jitu Date Combobox
                $url =  Users_ClaimRecords_Model::getCreateClaimURL();

                $viewer->assign('CREATE_CLAIM_URL', Users_ClaimRecords_Model::getCreateClaimURL());
                $viewer->assign('USERID',$recordId);

                //echo $url;die;

                $viewer->assign('MANAGER',$manager);
                $viewer->assign('SECTION',$section);

                ####start Get My leave list##### 
                //$currentyear='2019';

                $myClaims = Users_ClaimRecords_Model::getMyClaim($recordId,$currentyear); //echo $currentyear;

                //print_r($myClaims);die;
                $viewer->assign('CurrentDate', date('Y-m-d'));
                $viewer->assign('MYCLAIM', $myClaims);
                ####end my leave list###########

                $pageNumber = $request->get('pagenumber');//Added By Safuan MyTeamLeave Pagination 
                if(empty($pageNumber)){
                        $pageNumber = '1';
                }

                $pageLimit = 5;// set number of row for each page here-//Added By Safuan MyTeamLeave Pagination


                ####start Get My Team leave list##### 
                $myteamclaims = Users_ClaimRecords_Model::getMyTeamClaim($recordId,$currentyear, $pageNumber, $pageLimit,$selectedmember,$selectedclaimtype);
                $myteam = Users_ClaimRecords_Model::getMyTeamMembers($recordId);
                $claimtypelist = Users_ClaimRecords_Model::getTotaClaimTypeList($userid,$claimid);
                $viewer->assign('MYTEAM', $myteam);
                $viewer->assign('CLAIMTYPELIST', $claimtypelist);

                $viewer->assign('MYTEAMCLAIMS', $myteamclaims);
                ####end my Team leave list###########

                ### Code for paging added by jitu@secondcrm.com on 28-01-2015####

                $totalCount = count(Users_ClaimRecords_Model::getMyTeamClaim($recordId,$currentyear, '', '',$selectedmember,$selectedclaimtype));	//Added By Safuan MyTeamLeave Pagination
                $pageCount = ceil($totalCount / $pageLimit);

                if($pageNumber < $pageCount){
                        $nextpageexist = 1;		
                }else{
                        $nextpageexist = 0;		
                }
                if($pageNumber > 1){
                        $prevpageexist = 1;		
                }else{
                        $prevpageexist = 0;
                }

                $start = ($pageNumber -1)*$pageLimit+1;


                $end = $pageNumber * $pageLimit;
                if($end > $totalCount) {
                        $end = $totalCount;
                }
                if($totalCount ==0) {
                        $start = 0;
                        $end = 0;
                }

                $pagingModel = new Vtiger_Paging_Model();
                $pagingModel->set('page', $pageNumber);

                $pagingModel->set('prevPageExists', $prevpageexist);
                $pagingModel->set('range', array('start'=>$start, 'end'=>$end));
                $pagingModel->set('nextPageExists', $nextpageexist);
                $pcount = $pageCount;
                if($pageCount == 0){
                        $pageCount = 1;
                }

                $viewer->assign('PAGE_COUNT', $pageCount);
                $viewer->assign('PCOUNT',$pcount);
                $viewer->assign('LISTVIEW_COUNT', $totalCount);

                $viewer->assign('PAGE_LIMIT',$pageLimit);
                $viewer->assign('PAGING_MODEL', $pagingModel);

                $viewer->assign('PAGE_NUMBER',$pageNumber);
                $viewer->assign('LISTVIEW_ENTRIES_COUNT', '9');
                ### End	of code #################################################



                echo $viewer->view('UserClaim.tpl',$moduleName,true);
        }

      /*  public function getUsersLeaveStatus(Vtiger_Request $request) { 
                $db = PearDatabase::getInstance();

                $moduleName = $request->getModule();
                $user_model = Users_Record_Model::getCurrentUserModel();

                //Get All Active Users
             //   $users = $user_model->getAccessibleUsers();
                 
                //Get All total-Used Leave List by Users
                $viewer = $this->getViewer($request);
                $usersleavestatus = $user_model->UsersLeaveStatus();
                $viewer->assign('USERS_LEAVESTATUS',$usersleavestatus);
                $viewer->assign('MODULE',$moduleName);
                $viewer = $this->getViewer($request);
              echo  $viewer->view('CheckUserLeaveStatus.tpl',$moduleName,true);

        }*/


        /**
         * Function to get the list of Script models to be included
         * @param Vtiger_Request $request
         * @return <Array> - List of Vtiger_JsScript_Model instances
         */
        function getHeaderScripts(Vtiger_Request $request) {
                $headerScriptInstances = parent::getHeaderScripts($request);

                $mode = $request->get('mode');

                $jsFileNames = array(
                        "~layouts/fask/modules/Vtiger/resources/List.js",
                );

                if($mode == 'getUserEducation'){
                        array_push($jsFileNames, "~layouts/fask/modules/Users/resources/Education.js");
                }
                if($mode == 'getUserWorkexp'){
                        array_push($jsFileNames, "~layouts/fask/modules/Users/resources/WorkExp.js");
                }
                if($mode == 'getUserProject'){
                        array_push($jsFileNames, "~layouts/fask/modules/Users/resources/EmployeeProjects.js");
                }

                if($mode == 'getUserLeave'){
                        array_push($jsFileNames, "~layouts/fask/modules/Users/resources/Leave.js");
                }
                if($mode == 'getUserClaim'){
                        array_push($jsFileNames, "~layouts/fask/modules/Users/resources/Claim.js");
                }

                $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
                $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
                return $headerScriptInstances;
        }

}

<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditEducation_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                $edu_id = $request->get('record');
                $userId = $request->get('userId');
                $userRecordModel = Users_EduRecord_Model::getCurrentUserModel();

                $viewer = $this->getViewer($request);
                $InstutionList = $userRecordModel->getAllInstituionlist();
                $MajorList = $userRecordModel->getAllAreaOfStudylist();
                if(!empty($edu_id)) {	
                    $educationdetailmodel = $userRecordModel->getEducationDetail($edu_id); 
                }
                $educationtype =  $userRecordModel->get_education_types();
                $startDateField = array(	"mandatory"=>true,
                                                "presence"=>true,
                                                "quickcreate"=>false,
                                                "masseditable"=>false,
                                                "defaultvalue"=>false,
                                                "type"=>"date",
                                                "name"=>"start_date",
                                                "label"=>"Start Date",
                                                "date-format"=>"dd-mm-yyyy"	);
                $endDateField = array(	"mandatory"=>true,
                                                "presence"=>true,
                                                "quickcreate"=>false,
                                                "masseditable"=>false,
                                                "defaultvalue"=>false,
                                                "type"=>"date",
                                                "name"=>"end_date",
                                                "label"=>"End Date",
                                                "date-format"=>"dd-mm-yyyy"	);

                $validator= '[{"name":"greaterThanDependentField","params":["start_date"]}]';
                $viewer->assign('MODULE', $moduleName);
                $viewer->assign('QUALIFIED_MODULE', $moduleName);
                $viewer->assign('USERID', $userId);
                $viewer->assign('EDU_ID', $edu_id);
                $viewer->assign('INSTITUTION_LIST', $InstutionList);
                $viewer->assign('MAJOR_LIST', $MajorList);
                $viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
                $viewer->assign('CURRENTYEAR', date('Y'));
                $viewer->assign('STARTDATEFIELD', $startDateField);
                $viewer->assign('ENDDATEFIELD', $endDateField);
                $viewer->assign('VALIDATOR', $validator);
                $viewer->assign('EDU_TYPE',$educationtype);
              
                $viewer->assign('EDUCATION_DETAIL', $educationdetailmodel);
                $viewer->view('EditAjaxEducation.tpl', $moduleName);
        }
}

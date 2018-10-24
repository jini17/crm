<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditWorkExp_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                $uw_id = $request->get('record');
                $userId = $request->get('userId');

                $userRecordModel = Users_WorkExpRecord_Model::getCurrentUserModel();

                $viewer = $this->getViewer($request);
                $CompanyList = $userRecordModel->getAllCompanylist();
                $DesignationList = $userRecordModel->getAllDesignationlist();
                $LocationList = $userRecordModel->getAllLocationlist();
                if(!empty($uw_id)) {	
                        $workexpdetailmodel = $userRecordModel->getWorkExpDetail($uw_id); 
                }
                $startDateField = array(	
                    "mandatory"=>true,
                    "presence"=>true,
                    "quickcreate"=>false,
                    "masseditable"=>false,
                    "defaultvalue"=>false,
                    "type"=>"date",
                    "name"=>"start_date",
                    "label"=>"Start Date",
                    "date-format"=>"dd-mm-yyyy"	);
                $endDateField = array(	
                    "mandatory"=>true,
                    "presence"=>true,
                    "quickcreate"=>false,
                    "masseditable"=>false,
                    "defaultvalue"=>false,
                    "type"=>"date",
                    "name"=>"end_date",
                    "label"=>"End Date",
                    "date-format"=>"dd-mm-yyyy"
                            );

                //$validator = array("name"=>"greaterThanDependentField","params"=>'["start_date"]');
                $validator= '[{"name":"greaterThanDependentField","params":["start_date"]}]';
                $viewer->assign('MODULE', $moduleName);
                $viewer->assign('QUALIFIED_MODULE', $moduleName);
                $viewer->assign('USERID', $userId);
                $viewer->assign('UW_ID', $uw_id);
                $viewer->assign('COMPANY_LIST', $CompanyList);
                $viewer->assign('DESIGNATION_LIST', $DesignationList);
                $viewer->assign('LOCATION_LIST', $LocationList);
                $viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
                $viewer->assign('WORKEXP_DETAIL', $workexpdetailmodel);
                $viewer->assign('STARTDATEFIELD', $startDateField);
                $viewer->assign('ENDDATEFIELD', $endDateField);
                $viewer->assign('VALIDATOR', $validator);
                $viewer->view('EditAjaxWorkExp.tpl', $moduleName);
        }
}

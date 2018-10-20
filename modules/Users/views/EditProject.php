<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_EditProject_View extends Vtiger_Index_View {

        public function process(Vtiger_Request $request) {
                $moduleName = $request->getModule();
                $project_id = $request->get('record');
                $userId = $request->get('userId');
                $userRecordModel = Users_ProjectRecord_Model::getCurrentUserModel();
                $designationList = $userRecordModel->getAllDesignationlist($userId);	
                $viewer = $this->getViewer($request);

                if(!empty($project_id)) {	
                        $projectdetailmodel = $userRecordModel->getProjectDetail($project_id); 
                }
                $Projectmonth = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
                $viewer->assign('MODULE', $moduleName);
                $viewer->assign('QUALIFIED_MODULE', $moduleName);
                $viewer->assign('USERID', $userId);
                $viewer->assign('PROJECT_ID', $project_id);
                $viewer->assign('DESIGNATION_LIST', $designationList);
                $viewer->assign('CURRENT_USER_MODEL', $userRecordModel);
                $viewer->assign('PROJECT_MONTH', $Projectmonth);
                $viewer->assign('CURRENTYEAR', date('Y'));
                $viewer->assign('PROJECT_DETAIL', $projectdetailmodel);
                $viewer->view('EditAjaxProject.tpl', $moduleName);
        }
}

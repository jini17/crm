<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class EmployeeContract_DocumentExpiring_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {

                $LIMIT = 5;

                $currentUser = Users_Record_Model::getCurrentUserModel();
                $viewer = $this->getViewer($request);

                $moduleName = $request->getModule();
                $type = trim($request->get('type'));

                if($type == '' || $type == null) {
                                $type = 'contract';
                }

                $valueLabel = 'LBL_EMPLOYEE_CONTRACT';

                if($type=='passport') {	
                        $valueLabel = 'LBL_PASSPORT';
                }	else if($type=='visa') {	
                        $valueLabel = 'LBL_VISA';
                }


                $page = $request->get('page');

                if(empty($page)) {
                        $page = 1;
                }
                $pagingModel = new Vtiger_Paging_Model();
                $pagingModel->set('page', $page);
                $pagingModel->set('limit', $LIMIT);


                $linkId = $request->get('linkid');
                $documentmodel = EmployeeContract_Record_Model::getExpiringDocument($type,$pagingModel);	
          
                $widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());

                $viewer->assign('WIDGET', $widget);
                $viewer->assign('VALUE', $value );
                $viewer->assign('VALUELABEL', $valueLabel);
                $viewer->assign('PAGE', $page);
                $viewer->assign('NEXTPAGE', ($pagingModel->get('recordcount') < $LIMIT)? 0 : $page+1);
                $viewer->assign('MODULE_NAME', $moduleName);
                $viewer->assign('MODELS', $documentmodel);
                $content = $request->get('content');


                if(!empty($content)) {
                        $viewer->view('dashboards/DocumentExpiringContent.tpl', $moduleName);
                } else {
                        $viewer->view('dashboards/DocumentExpiring.tpl', $moduleName);
                }
        }
}

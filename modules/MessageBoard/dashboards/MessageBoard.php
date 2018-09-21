<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class MessageBoard_MessageBoard_Dashboard extends Vtiger_IndexAjax_View {

        public function process(Vtiger_Request $request) {
                $db = PearDatabase::getInstance();
                  //$db->setDebug(true);

                $currentUser = Users_Record_Model::getCurrentUserModel();
                $viewer = $this->getViewer($request);
                $moduleName = $request->getModule();
                $page = $request->get('page');
                $linkId = $request->get('linkid');
                $widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId(), '');
                $viewer->assign('WIDGET', $widget);

                $viewer->assign('USERID', $currentUser->getId());
                 $sql =  "SELECT  first_name,employee_id,message,messagetime FROM vtiger_users   LEFT JOIN vtiger_messageboard on vtiger_users.id = vtiger_messageboard.employee_id";
                      //      . " LEFT JOIN vtiger_messageboard on vtiger_users.id = vtiger_messageboard.employee_id  WHERE vtiger_users.id = ?";
                  $query = $db->pquery($sql);
                   $rum_rows = $db->num_rows($query);
    
                $messages =array();
                   if($num_rows > 0){
                       for($i =0; $i < $num_rows; $i++){
                          $messages[$i]['first_name']   =      $adb->query_result($result,$i,"first_name");
                          $messages[$i]['message']       =       $adb->query_result($result,$i,"message");
                          $messages[$i]['messagetime']       =       $adb->query_result($result,$i,"messagetime");
                       }
                    }           
                $viewer->assign('ANNOUNCEMENTS', $messages);

                $viewer->assign('MODULE_NAME', $moduleName);
                $viewer->assign('MODELS', $leavemodel);
                $content = $request->get('content');


                if(!empty($content)) {
                        $viewer->view('dashboards/MessageBoardContents.tpl', $moduleName);
                } else {
                        $viewer->view('dashboards/MessageBoard.tpl', $moduleName);
                }
        }

        public function get_announcement($userid,$db,$role){
            $sql =  "SELECT  *  FROM vtiger_messageboard ";
              //      . " LEFT JOIN vtiger_messageboard on vtiger_users.id = vtiger_messageboard.employee_id  WHERE vtiger_users.id = ?";
            $query = $db->pquery($sql);
            $rum_rows = $db->num_rows($query);

            return $num_rows;

        }
}

<?php

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class MessageBoard_MessageBoard_Dashboard extends Vtiger_IndexAjax_View
{

    public function process(Vtiger_Request $request)
    {
        $db = PearDatabase::getInstance();
        // $db->setDebug(true);

        $currentUser = Users_Record_Model::getCurrentUserModel();
        $viewer = $this->getViewer($request);
        $moduleName = $request->getModule();
        $page = $request->get('page');
        $linkId = $request->get('linkid');
        $widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId(), '');
        $viewer->assign('WIDGET', $widget);

        $viewer->assign('USERID', $currentUser->getId());
        $sql = " SELECT  vtiger_messageboard.messageboardid as record_id,first_name,employee_id,message, vtiger_messageboard.title, createdtime FROM vtiger_messageboard  "
            . " INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_messageboard.messageboardid  "
            . " Left JOIN  vtiger_users  ON vtiger_users.id = vtiger_messageboard.employee_id "
            . " WHERE vtiger_crmentity.deleted=0 AND ( vtiger_users.reports_to_id = ? OR vtiger_messageboard.employee_id=?) ORDER BY vtiger_crmentity.createdtime DESC Limit 5";
        //. " LEFT JOIN vtiger_messageboard on vtiger_users.id = vtiger_messageboard.employee_id";
        $query = $db->pquery($sql, array($currentUser->getId(), $currentUser->getId()));
        $num_rows = $db->num_rows($query);

        $messages = array();


        for ($i = 0; $i < $num_rows; $i++) {
            $content_full = $db->query_result($query, $i, "message");
            $title = $db->query_result($query, $i, "title");
            $employee_id = $db->query_result($query, $i, "employee_id");
            $createtime = $db->query_result($query, $i, "createdtime");

            $detailViewModel = Vtiger_DetailView_Model::getInstance('Users', $employee_id);
            $recordModel = $detailViewModel->getRecord();
            $imageDetails = $recordModel->getImageDetails();
            $viewer = $this->getViewer($request);
            $imagepath = $imageDetails[0]['path'] . '_' . $imageDetails[0]['orgname'];

            if (!file_exists($imagepath)) {
                $imagepath = 'layouts/fask/skins/images/DefaultUserIcon.png';
            }

            $content = strip_tags(html_entity_decode(stripslashes(nl2br($content_full)), ENT_NOQUOTES, "Utf-8"));
            $pos = strpos($content, ' ', 30);
            $summery = substr($content, 0, $pos);

            $messages[$i]["first_name"] = $db->query_result($query, $i, "first_name");
            $messages[$i]["message"] = $summery;
            $messages[$i]["title"] = $title;
            $messages[$i]["messagetime"] = $this->time_elapsed_string($createtime);
            $messages[$i]["image"] = $imagepath;
            $messages[$i]["user_id"] = $db->query_result($query, $i, "employee_id");
            $messages[$i]["record_id"] = $db->query_result($query, $i, "record_id");

        }

        //Permission To create Message Board
        $moduleName = 'MessageBoard';
        $actionName = 'CreateView';
        $allowcreate = true;
        if(!Users_Privileges_Model::isPermitted($moduleName, $actionName, $record)) {
            $allowcreate = false;               
        } 
        $viewer->assign('ALLOWCREATE', $allowcreate);
        //end here


        $viewer->assign('ANNOUNCEMENTS', $messages);

        $viewer->assign('MODULE_NAME', $moduleName);
        $viewer->assign('MODELS', $num_rows);
        $content = $request->get('content');


        if (!empty($content)) {
            $viewer->view('dashboards/MessageBoardContents.tpl', $moduleName);
        } else {
            $viewer->view('dashboards/MessageBoard.tpl', $moduleName);
        }
    }

    public function get_announcement($userid, $db, $role)
    {
        $sql = "SELECT  *  FROM vtiger_messageboard ";
        //      . " LEFT JOIN vtiger_messageboard on vtiger_users.id = vtiger_messageboard.employee_id  WHERE vtiger_users.id = ?";
        $query = $db->pquery($sql);
        $rum_rows = $db->num_rows($query);

        return $rum_rows;

    }

    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * Function to get the list of Script models to be included
     * @param Vtiger_Request $request
     * @return <Array> - List of Vtiger_JsScript_Model instances
     */
    public function getHeaderScripts(Vtiger_Request $request)
    {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            'modules.Vtiger.resources.dashboards.Widget',

        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }

}

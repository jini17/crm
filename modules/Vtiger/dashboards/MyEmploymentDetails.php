<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_MyEmploymentDetails_Dashboard extends Vtiger_IndexAjax_View
{
    
    public function process(Vtiger_Request $request)
    {
        global $site_URL;
        $db          = PearDatabase::getInstance();
        // $db->setDebug(true);
        $currentUser = Users_Record_Model::getCurrentUserModel();
        $viewer      = $this->getViewer($request);
        $moduleName  = $request->getModule();
        $moduleModel = Home_Module_Model::getInstance($moduleName);
        
        $dept   = $request->get('department');
        $page   = $request->get('page');
        $linkId = $request->get('linkid');
        
        $moduleModel = Home_Module_Model::getInstance($moduleName);
        $widget      = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId(), $request->get('tab'));
        $users       = $this->get_employee($db, $dept);
        $first_name  = $currentUser->get('first_name');
        $last_name   = $currentUser->get('last_name');
        $employee_no = $currentUser->get('employeeno');
        $job_grade   = (strlen($currentUser->get('grade_id')) > 0) ? $this->grade($db, $currentUser->get('grade_id')) : "";
        
        $designation = $currentUser->get('Designation');
        $department  = $currentUser->get('department');
        $djt         = $this->get_designation_job_type($db, $currentUser->get('id'));
        
        $report_to           = (strlen($currentUser->get('reports_to_id')) > 0) ? $this->report_to($db, $currentUser->get('reports_to_id')) : "";
        //$thumb                   = $this->get_image($db, $currentUser->get('id'),$currentUser->get('image_name'));
        $thumb               = $currentUser->getImageDetails();
        $contract_start_date = $this->get_contract_start_date($db, $currentUser->get('id'));
        $curdate             = date('Y-m-d');
        $exp_date            = (strlen($djt['exp_date']) > 0) ? date('Y-m-d', strtotime($djt['exp_date'])) : "";
        $now                 = time(); // or your date as well
        $your_date           = (strlen($djt['exp_date']) > 0) ? strtotime($djt['exp_date']) : "0";
        $datediff            = (strlen($your_date) > 0) ? $now - $your_date : "";
        
        $alert_days = (strlen($datediff) > 0) ? round($datediff / (60 * 60 * 24)) : "";
        if ($alert_days <= 45) {
            $notify = "show";
        } else {
            $notify = "hide";
        }
        
        if ($thumb[0]['name'] == '' || !file_exists($thumb[0]['path'] . '_' . $thumb[0]['name'])) {
            $imagename = 'test/loginlogo/admin.jpg';
        } else {
            $imagename = $thumb[0]['path'] . '_' . $thumb[0]['name'];
        }
        $expirdays = -1;
        if(strlen($djt['exp_date']) > 0){
            $expirydate = (strlen($djt['exp_date']) > 0) ? date('M d, Y', strtotime($djt['exp_date'])) : "";
            $expirydays  = datediff($djt['exp_date'], date('Y-m-d'));

        }

        $info = array(
            'first_name' => $currentUser->get('first_name'),
            'employee_id' => $employee_no,
            'emp_name' => $first_name . " " . $last_name,
            'job_grade' => $job_grade,
            'designation' => $djt['deg'],
            'job_type' => $djt['job_type'],
            'department' => $department,
            'report_to' => $report_to,
            'expire' => $expirydate,
            'expirydays' =>$expirydays['days_total'],
            'thumb' => $imagename,
            'facebook' => $currentUser->get('facebook'),
            'twitter' => $currentUser->get('twitter'),
            'linkedin' => $currentUser->get('linkedin'),
            'notify' => $notify,
            'contract' => $djt['contract_id'],
            'emp_id' => $currentUser->get('id'),
            'roleid'=> $currentUser->roleid
        );
        //    print_r($info);
        //  exit();
        if ($djt['job_type'] == 'Permanent') {
            $info['contract_start'] = (strlen($currentUser->get('date_joined')) > 0) ? date('M d, Y', strtotime($currentUser->get('date_joined'))) : "";
        } else {
            $info['contract_start'] = $contract_start_date;
        }
        $viewer->assign('REQUEST_DEPARTMENT', $dept);
        $viewer->assign('DEPARTMENT', $departmentList);
        $viewer->assign('WIDGET', $widget);
        $viewer->assign('MODULE_NAME', $moduleName);
        
        $viewer->assign('DATA', $info);
        $viewer->assign('URL', $site_URL);
        
        $content = $request->get('content');
        
        if (!empty($content)) {
            $viewer->view('dashboards/MyEmploymentDetailsContents.tpl', $moduleName);
        } else {
            $viewer->view('dashboards/MyEmploymentDetails.tpl', $moduleName);
        }
        
    }
    
    
    function getHeaderScripts(Vtiger_Request $request)
    {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName            = $request->getModule();
        $jsFileNames           = array(
            "modules.Emails.resources.MassEdit"
        );
        $jsScriptInstances     = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
    
    /**
     * Get the Grade
     * @param type $db
     * @param type $id
     * @return type
     */
    function grade($db, $id)
    {
        $sql   = "SELECT grade from vtiger_grade WHERE gradeid = $id ";
        $query = $db->pquery($sql, array());
        $grade = $db->query_result($query, 0, 'grade');
        if (!empty($grade)) {
            return $grade;
        } else {
            return false;
        }
    }
    
    /**
     * Get Reporting Manage 
     * @param type $db
     * @param type $id
     * @return type
     */
    function report_to($db, $id)
    {
        
        $data      = array();
        $sql       = "select id,first_name,last_name from vtiger_users WHERE id = $id";
        $query     = $db->pquery($sql, array());
        $report_to = $db->query_result($query, 0, 'first_name');
        $num_rows  = $db->num_rows($query);
        if ($num_rows > 0) {
            $data['name'] = $report_to . " " . $db->query_result($query, 0, 'last_name');
            $data['id']   = $db->query_result($query, 0, 'id');
        } else {
            $data['name'] = "";
            $data['id']   = 0;
        }
        
        return $data;
    }
    /**
     * 
     * @param type $db
     * @param type $department
     * @return string
     */
    function get_employee($db, $department)
    {
        $sql     = "SELECT employeeno,first_name,last_name,department FROM vtiger_users WHERE status = 'Active' ";
        $query   = $db->pquery($sql);
        $numrows = $db->num_rows($query);
        $data    = array();
        
        if ($numrows > 0) {
            for ($i = 0; $i < $numrows; $i++) {
                $data[$i]['empid']      = $db->query_result($query, $i, 'employeeno');
                $data[$i]['first_name'] = $db->query_result($query, $i, 'first_name');
                $data[$i]['last_name']  = $db->query_result($query, $i, 'last_name');
                $data[$i]['department'] = $db->query_result($query, $i, 'department');
                
            }
        } else {
            $data[0]['empid']      = 0;
            $data[0]['first_name'] = "";
            $data[0]['last_name']  = "";
            $data[0]['department'] = "";
            
        }
        return $data;
    }
    
    /**
     * SELECT * FROM `` 
     * @param type $db
     * @param type $id
     * @return type
     */
    public function get_designation_job_type($db, $id)
    {
        $sql     = "SELECT  vtiger_employeecontract.employeecontractid as employeecontractid,contract_expiry_date,designation,job_type from vtiger_employeecontract " . " INNER JOIN vtiger_employeecontractcf ON vtiger_employeecontract.employeecontractid = vtiger_employeecontractcf.employeecontractid " . " WHERE vtiger_employeecontract.employee_id = " . $id;
        $query   = $db->pquery($sql, array());
        $numrows = $db->num_rows($query);

        if ($numrows > 0) {
            
            $job_type = $db->query_result($query, 0, 'job_type');
            $djt['contract_id'] = $db->query_result($query, 0, 'employeecontractid');
            $expirydate =  $db->query_result($query, 0, 'contract_expiry_date');
            $time = time();
            
            if($job_type !='Permanent' && strtotime($expirydate) < $time && $expirydate !=''){
                $djt['contract_id'] = 0; 
            }

            $djt['deg']         = $db->query_result($query, 0, 'designation');
            $djt['job_type']    = $job_type;
            $djt['exp_date']    = $expirydate;

        } else {
            $djt['deg']         = "";
            $djt['job_type']    = "";
            $djt['contract_id'] = 0;
            $djt['exp_date']    = "";
        }
        return $djt;
        
    }
    
    /**
     * Get User Contract Start Date
     * @param type $db
     * @param type $id
     * @return type
     */
    public function get_contract_start_date($db, $id)
    {
        
        $sql            = "SELECT DATE_FORMAT(createdtime,'%M %d, %Y') as started_from from vtiger_crmentity WHERE `setype` LIKE '%contract%' AND `smownerid` = $id ";
        $query          = $db->pquery($sql, array());
        $contract_start = $db->query_result($query, 0, 'started_from');
        return $contract_start;
        
    }
    /**
     * Get User Image
     * @param type $db - DB Connection
     * @param type $id - Attachment ID
     * @param type $name - Image Name
     * @return type
     */
    public function get_image($db, $id, $name)
    {
        return $name;
        $sql   = "SELECT path from vtiger_attachments WHERE attachementid = $id AND name ='$name' ";
        $query = $db->pquery($sql, array());
        $path  = $db->query_result($query, 0, 'path');
        return $path . $name;
        
    }
}
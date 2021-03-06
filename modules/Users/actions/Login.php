<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_Login_Action extends Vtiger_Action_Controller
{
    
    function loginRequired()
    {
        return false;
    }
    
    function checkPermission(Vtiger_Request $request)
    {
        return true;
    }
    
    function process(Vtiger_Request $request)
    {
        
        global $short_url, $site_URL, $adb;
        //$adb->setDebug(true);
        $username = trim($request->get('username'));
        $password = trim($request->getRaw('password'));

       


        //echo $allowedipres;die;
        //$allowedipres = true;
        /** 
         * Added By Khaled
         * Kill Multi Login Session
         * 
         */
        
        $adb      = PearDatabase::getInstance();
        $result   = $adb->pquery("SELECT login_id,session_id FROM vtiger_loginhistory WHERE DATE(login_time) = CURDATE() AND user_name = ? AND status = ? ORDER BY login_id ASC", array(
            $username,
            'Signed in'
        ));
        $num_rows = $adb->num_rows($result);
        if ($num_rows > 0) {
            for ($i = 0; $i < $num_rows; $i++) {
                $sessionID = $adb->query_result($result, $i, 'session_id');
                $loginid   = $adb->query_result($result, $i, 'login_id');
                if ($sessionID) {
                    //  session_id($sessionID);            
                    // session_destroy();
                    $time   = date("Y/m/d H:i:s");
                    $userIP = $_SERVER['REMOTE_ADDR'];
                    // update the user login info.
                    $query  = "Update vtiger_loginhistory set logout_time =?, status=? where login_id =  ?";
                    /**============
                     * Disabled temporary
                     */
                    //$result1 = $adb->pquery($query, array($username, 'Signed off', $loginid));
                    
                    
                }
            }
            session_start();
            $_SESSION['multi_login'] = "no"; //  Original Value yes Disabled for certain period of time
        } else {
            session_start();
            $_SESSION['multi_login'] = "no";
        }
        
        
        /** 
         * Added By Khaled
         * Get First Time Login
         */
        $first_time_login = first_time_loggedin($username);
        
        //echo $username;
        //echo "<br><br>".$password;die;
        $user                             = CRMEntity::getInstance('Users');
        $user->column_fields['user_name'] = $username;
        $moduleModel                      = Users_Module_Model::getInstance('Users');
        $browser                          = Settings_MaxLogin_Module_Model::browserDetect();
        
        $checkBlocked = Settings_MaxLogin_Module_Model::checkBlocked($username);
        if ($checkBlocked) {
            header('Location: index.php?module=Users&parent=Settings&view=Login&error=5');
            exit;
        }
        
        if ($_SERVER['HTTP_HOST'] == $short_url || $_SERVER['HTTP_HOST'] == 'localhost' || stripos($_SERVER['HTTP_HOST'], '192.168.2.') !== false) {
            $usip = $_SERVER['REMOTE_ADDR']; //add one more param IP address by jitu@28Dec2016
        } else {
            
            $usip = $_SERVER['HTTP_X_FORWARDED_FOR']; //add one more param IP address by jitu@28Dec2016    
        }
        
        
        $allowedipres = false;
        $allowedipres = $this->AllowedIp($usip, $username);
        if ($user->doLogin($password) && $allowedipres == true) {

            // Added By Mabruk
            $subscriptionCheck = $this->checkSubExpDate($username);

            if (!$subscriptionCheck) {

                header('Location: index.php?module=Users&parent=Settings&view=Login&error=13');          
                exit;

            }

            session_regenerate_id(true); // to overcome session id reuse.
            $userid = $user->retrieve_user_id($username);
            Vtiger_Session::set('AUTHUSERID', $userid);
            
            //setCookie 
            if ($request->get('keepcheck') == 'on') {
                setcookie('agiliuxuser', $username, time() + (86400 * 30), "/");
                setcookie('agiliuxpass', $password, time() + (86400 * 30), "/");
                setcookie('keepcheck', 1, time() + (86400 * 30), "/");
            }
            $loginpageinfo = Users_Record_Model::loginPageDetails();
            
            // For Backward compatability
            // TODO Remove when switch-to-old look is not needed
            $_SESSION['authenticated_user_id'] = $userid;
            $_SESSION['sessionout']            = $loginpageinfo['sessionout'];
            
            $db     = PearDatabase::getInstance();
            $result = $db->pquery("SELECT vtiger_role.planid FROM vtiger_role 
                                INNER JOIN vtiger_user2role  ON vtiger_user2role.roleid=vtiger_role.roleid WHERE vtiger_user2role.userid=?", array(
                $userid
            ));
            $plan   = $db->query_result($result, 0, 'planid');
            
            $_SESSION['plan']                        = $plan;
            $_SESSION['app_unique_key']              = vglobal('application_unique_key');
            $_SESSION['authenticated_user_language'] = vglobal('default_language');
            $_SESSION['LOGOUT_URL']                  = $site_URL;
            //Enabled session variable for KCFINDER 
            $_SESSION['KCFINDER']                    = array();
            $_SESSION['KCFINDER']['disabled']        = false;
            $_SESSION['KCFINDER']['uploadURL']       = "test/upload";
            $_SESSION['KCFINDER']['uploadDir']       = "../test/upload";
            $deniedExts                              = implode(" ", vglobal('upload_badext'));
            $_SESSION['KCFINDER']['deniedExts']      = $deniedExts;
            
            // End
            
            //    $moduleModel = Users_Module_Model::getInstance('Users');
            //    $moduleModel->saveLoginHistory($user->column_fields['user_name']);
            //End
            //Track the login History
            $browser              = Settings_MaxLogin_Module_Model::browserDetect();
            $moduleModel          = Users_Module_Model::getInstance('Users');
            $login_id             = $moduleModel->saveLoginHistory($user->column_fields['user_name'], 'Signed in', $browser, $usip);
            $_SESSION['login_id'] = $login_id;
            
            
            
            if (isset($_SESSION['return_params'])) {
                
                $return_params             = urldecode($_SESSION['return_params']);
                $_SESSION['logged_status'] = true;
                $_SESSION['loggedin_now']  = true;
                header("Location: index.php?$return_params");
                exit();
            } else {
                $_SESSION['loggedin_now'] = FALSE;
                header("Location: index.php");
                exit();
            }
        } else if ($allowedipres == false) {
            $moduleModel->saveLoginHistory($username, 'Failed login', $browser, $usip);
            header('Location: index.php?module=Users&parent=Settings&view=Login&error=9');
        } else {
            //Track the login History by jitu@10-04-2015
            $moduleModel->saveLoginHistory($username, 'Failed login', $browser, $usip);
            header('Location: index.php?module=Users&parent=Settings&view=Login&error=1');
            //    header ('Location: index.php?module=Users&parent=Settings&view=Login&error=login');
            exit;
        }
    }

    /*
     * Function added by Mabruk for checking subscription expiry date
     * added on 07-01-2018
     */
    function checkSubExpDate($user) {

        global $adb;
        //$adb->setDebug(true);

        $result     = $adb->pquery("SELECT secondcrm_plan.expiredate
                                FROM secondcrm_plan 
                                INNER JOIN secondcrm_userplan 
                                ON secondcrm_userplan.planid = secondcrm_plan.planid
                                INNER JOIN vtiger_users
                                ON vtiger_users.id = secondcrm_userplan.userid
                                WHERE vtiger_users.user_name = ?", array($user));

        $expiryDate = strtotime(date('d-m-Y',strtotime($adb->query_result($result,0,'expiredate'))));
        $today      = strtotime(date('d-m-Y'));       

        if ($expiryDate >= $today)
            return true;
        else 
            return false;

    }
    
    
    /*
     * Function added by nirbhay for allowed Ip's validation
     * added on 18-04-2018
     */
    function AllowedIp($usip, $username)
    {
        global $adb;
        //  $adb->setDebug(true);
        /**
         * Absolute IP validations
         */
        $query  = "SELECT ip_id,user_name, iprestriction_type FROM allowed_ip WHERE isactive = 1 AND type='Absolute' AND ip = ?";
        $result = $adb->pquery($query, array(
            $usip
        ));
        if ($adb->num_rows($result) > 0) {
            $user_name   = $adb->query_result($result, 0, 'user_name');
            $iprest_type = $adb->query_result($result, 0, 'iprestriction_type');
            
            $usernames = explode(',', $user_name);
            for ($i = 0; $i < count($usernames); $i++) {
                if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'notallowed') {
                    return false;
                } else if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'allowed') {
                    return true;
                }
            }
        }
        /**
         * Validation for range IP
         */
        $rangeip = explode(".", $usip);
        $range   = '';
        for ($i = 0; $i < 3; $i++) {
            if ($i != 2)
                $range .= $rangeip[$i] . ".";
            else
                $range .= $rangeip[$i];
        }
        $query       = "SELECT ip_id,user_name,iprestriction_type FROM allowed_ip WHERE ip LIKE ? AND type = 'Range'";
        $result      = $adb->pquery($query, array(
            $range
        ));
        $count       = $adb->num_rows($result);
        $user_name   = $adb->query_result($result, 0, 'user_name');
        $iprest_type = $adb->query_result($result, 0, 'iprestriction_type');
        $usernames   = explode(',', $user_name);
        
        for ($i = 0; $i < count($usernames); $i++) {
            if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'notallowed') {
                return false;
            } else if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'allowed') {
                return true;
            }
        }
        
        $querydefault  = "SELECT * FROM allowed_ip_default ";
        $resultdefault = $adb->pquery($querydefault, array());
        $count         = $adb->num_rows($resultdefault);
        
        if ($count > 0) {
            $defaultvalue = $adb->query_result($resultdefault, 0, 'defaultvalue');
            if ($defaultvalue == 'allowed') {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
        
        
        
    }
    
}
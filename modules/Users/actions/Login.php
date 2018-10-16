<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_Login_Action extends Vtiger_Action_Controller {

        function loginRequired() {
                return false;
        }

        function checkPermission(Vtiger_Request $request) {
                return true;
        } 

        function process(Vtiger_Request $request) {

                global $short_url ,$site_URL, $adb;
                //$adb->setDebug(true);
                $username = $request->get('username');
                $password = $request->getRaw('password');
                //echo $username;
                //echo "<br><br>".$password;die;
                $user = CRMEntity::getInstance('Users');
                $user->column_fields['user_name'] = $username;
                $moduleModel = Users_Module_Model::getInstance('Users');
                $browser = Settings_MaxLogin_Module_Model::browserDetect();

                $checkBlocked = Settings_MaxLogin_Module_Model::checkBlocked($username);
                if($checkBlocked){ 
                        header ('Location: index.php?module=Users&parent=Settings&view=Login&error=5');
                        exit;
                }

                if($_SERVER['HTTP_HOST']==$short_url || $_SERVER['HTTP_HOST']=='localhost' 
                                || stripos($_SERVER['HTTP_HOST'],'192.168.2.') !==false) { 
                        $usip=$_SERVER['REMOTE_ADDR'];	//add one more param IP address by jitu@28Dec2016
                } else {

                        $usip=$_SERVER['HTTP_X_FORWARDED_FOR'];	//add one more param IP address by jitu@28Dec2016	
                }


                $allowedipres = false;

                $allowedipres = $this->AllowedIp($usip,$username);

                //echo $allowedipres;die;
                //$allowedipres = true;

                if ($user->doLogin($password) && $allowedipres==true) {
                        session_regenerate_id(true); // to overcome session id reuse.

                        $userid = $user->retrieve_user_id($username);
                        Vtiger_Session::set('AUTHUSERID', $userid);

                        //setCookie 
                        if($request->get('keepcheck')=='on'){
                                setcookie('agiliuxuser', $username, time() + (86400 * 30), "/");
                                setcookie('agiliuxpass', $password, time() + (86400 * 30), "/");
                                setcookie('keepcheck', 1, time() + (86400 * 30), "/");
                        }	
                        $loginpageinfo  = Users_Record_Model::loginPageDetails();

                        // For Backward compatability
                        // TODO Remove when switch-to-old look is not needed
                        $_SESSION['authenticated_user_id'] = $userid;
                        $_SESSION['sessionout'] = $loginpageinfo['sessionout'];

                        $db = PearDatabase::getInstance();
                        $result = $db->pquery("SELECT vtiger_role.planid FROM vtiger_role 
                                INNER JOIN vtiger_user2role  ON vtiger_user2role.roleid=vtiger_role.roleid WHERE vtiger_user2role.userid=?", array($userid));
                        $plan = $db->query_result($result, 0, 'planid');

                        $_SESSION['plan'] = $plan;
                        $_SESSION['app_unique_key'] = vglobal('application_unique_key');
                        $_SESSION['authenticated_user_language'] = vglobal('default_language');
                        $_SESSION['LOGOUT_URL'] = $site_URL;
                        //Enabled session variable for KCFINDER 
                        $_SESSION['KCFINDER'] = array(); 
                        $_SESSION['KCFINDER']['disabled'] = false; 
                        $_SESSION['KCFINDER']['uploadURL'] = "test/upload"; 
                        $_SESSION['KCFINDER']['uploadDir'] = "../test/upload";
                        $deniedExts = implode(" ", vglobal('upload_badext'));
                        $_SESSION['KCFINDER']['deniedExts'] = $deniedExts;

                        // End

                        //Track the login History
                        $browser = Settings_MaxLogin_Module_Model::browserDetect();	
                        $moduleModel = Users_Module_Model::getInstance('Users');
                        $moduleModel->saveLoginHistory($user->column_fields['user_name'],'Signed in', $browser, $usip);

                //	$moduleModel = Users_Module_Model::getInstance('Users');
                //	$moduleModel->saveLoginHistory($user->column_fields['user_name']);
                        //End

                        if(isset($_SESSION['return_params'])) {
                                $return_params = urldecode($_SESSION['return_params']);
                                                                     $_SESSION['logged_status'] = true;
                                                                     $_SESSION['loggedin_now'] = true;
                                header("Location: index.php?$return_params");
                                exit();
                        } else {
                                                                    $_SESSION['loggedin_now'] = FALSE;
                                header("Location: index.php");
                                exit();
                        }

                } 
                else if($allowedipres==false) {
                    $moduleModel->saveLoginHistory($username, 'Failed login', $browser, $usip);
                    header('Location: index.php?module=Users&parent=Settings&view=Login&error=9');


        }else{
                   //Track the login History by jitu@10-04-2015
                        $moduleModel->saveLoginHistory($username, 'Failed login', $browser, $usip);
                        header('Location: index.php?module=Users&parent=Settings&view=Login&error=1');

                //	header ('Location: index.php?module=Users&parent=Settings&view=Login&error=login');
                        exit;
                }
        }


        /*
         * Function added by nirbhay for allowed Ip's validation
         * added on 18-04-2018
         */
        function AllowedIp($usip, $username){
            global $adb;
      //  $adb->setDebug(true);
        /**
         * Absolute IP validations
         */
        $query = "SELECT ip_id,user_name, iprestriction_type FROM allowed_ip WHERE isactive = 1 AND type='Absolute' AND ip = ?";
        $result = $adb->pquery($query,array($usip));
        if($adb->num_rows($result)>0) {
            $user_name = $adb->query_result($result, 0, 'user_name');
            $iprest_type = $adb->query_result($result, 0, 'iprestriction_type');

            $usernames = explode(',', $user_name);

            for ($i = 0; $i<count($usernames); $i++) {
                if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'notallowed') {
                    return false;
                }else if(($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'allowed'){
                   return true;
                }
            }
        }
         /**
         * Validation for range IP
         */
        $rangeip = explode(".",$usip);
        $range = '';
        for($i=0;$i<3;$i++){
            if($i!=2)
                $range .= $rangeip[$i].".";
            else
                $range .= $rangeip[$i];
        }
        $query = "SELECT ip_id,user_name,iprestriction_type FROM allowed_ip WHERE ip LIKE ? AND type = 'Range'";

        $result = $adb->pquery($query,array($range));
        $count = $adb->num_rows($result);

        $user_name = $adb->query_result($result, 0,'user_name');
        $iprest_type = $adb->query_result($result, 0, 'iprestriction_type');

        $usernames = explode(',', $user_name);

       //echo "<pre>"; print_r($iprest_type); die;
        for ($i = 0;$i< count($usernames); $i++) {
            if (($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'notallowed') {
                return false;
            }else if(($usernames[$i] == $username || $usernames[$i] == 'All Users') && $iprest_type == 'allowed'){
                return true;
            }
        }

        $querydefault = "SELECT * FROM allowed_ip_default ";

        $resultdefault = $adb->pquery($querydefault,array());
        $count = $adb->num_rows($resultdefault);

       // echo
        if($count > 0){
            $defaultvalue = $adb->query_result($resultdefault,0,'defaultvalue');
            if($defaultvalue == 'allowed'){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }



    }

}

<?php

/**
 * @author Jitendra Gupta<jitendraknp2004@gmail.com>
 * @param String $user_name
 * @param String $emailId	
 */

require_once 'include/utils/utils.php';
require_once 'include/utils/VtlibUtils.php';
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';
require_once 'modules/Vtiger/helpers/ShortURL.php';

function vtws_forgotpassword($user_name, $emailId) {

	global $adb;
	$adb = PearDatabase::getInstance();
	
	if (isset($user_name) && isset($emailId)) {
		$username = vtlib_purify($user_name);
		$result = $adb->pquery('select user_name, email1,first_name, last_name from vtiger_users where user_name= ? ', array($username));
		if ($adb->num_rows($result) > 0) {
			$email = $adb->query_result($result, 0, 'user_name');
			$first_name = $adb->query_result($result, 0, 'first_name');
			$last_name = $adb->query_result($result, 0, 'last_name');
		}

		if (vtlib_purify($emailId) == $email) {
			$time = time();
			$options = array(
			    'handler_path' => 'modules/Users/handlers/ForgotPassword.php',
			    'handler_class' => 'Users_ForgotPassword_Handler',
			    'handler_function' => 'changePassword',
			    'handler_data' => array(
				'username' => $username,
				'email' => $email,
				'time' => $time,
				'hash' => md5($username . $time)
			    )
			);
			$trackURL = Vtiger_ShortURL_Helper::generateURL($options);	
			//Modify by jitu@salespeer for send Link only in webservice calling 
			return array("url"=>$trackURL,"first_name"=>$first_name, "last_name"=>$last_name);
			/*$content = 'Dear Customer,<br><br> 
                            You recently requested a password reset for your Salespeer Account.<br> 
                            To create a new password, click on the link <a target="_blank" href=' . $trackURL . '>here</a>. 
                            <br><br> 
                            This request was made on ' . date("Y-m-d H:i:s") . ' and will expire in next 24 hours.<br><br> 
		            Regards,<br> 
		            Salespeer Support Team.<br>' ;
			
			$mail = new PHPMailer();
			setMailerProperties($mail, 'Request : ForgotPassword - Salespeer', $content, 'support@secondcrm.com', $username, $email);	
			$status = MailSend($mail);
			
			 if ($status === 1) {
				VTWS_PreserveGlobal::flush();
				return array('msgcode'=>6);
			} 
			else {
				$EMAILFAILED = "SMTP Error";			
				throw new WebServiceException(WebServiceErrorCode::$EMAILFAILED, 
					vtws_getWebserviceTranslatedString('LBL_'.
							WebServiceErrorCode::$EMAILFAILED));
			}
		*/ //end here
		} else {
			$INVALIDEMAILID = "Invalid Email ID";
        		throw new WebServiceException(WebServiceErrorCode::$INVALIDEMAILID, 
					vtws_getWebserviceTranslatedString('LBL_'.
							WebServiceErrorCode::$INVALIDEMAILID));
		}	
	} else {
		$MISSINGINPUTS = "mandatory field are missing";
		throw new WebServiceException(WebServiceErrorCode::$MISSINGINPUTS, 
					vtws_getWebserviceTranslatedString('LBL_'.
							WebServiceErrorCode::$MISSINGINPUTS));
	}		
}
?>

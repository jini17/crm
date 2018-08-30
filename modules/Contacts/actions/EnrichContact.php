<?php
/**
 * Created by PhpStorm.
 * User: Nirbhay
 * Date: 5/16/18
 * Time: 5:45 PM
 */
error_reporting(1);
		ini_set('display_erros',1);

		  register_shutdown_function('handleErrors');
		    function handleErrors() {

		       $last_error = error_get_last();

		       if (!is_null($last_error)) { // if there has been an error at some point

			  // do something with the error
			  print_r($last_error);

		       }

		    } 

require_once("include/database/PearDatabase.php");
global $adb;
//$adb->setDebug(true);


class Contacts_RelationAjax_Action extends Vtiger_RelationAjax_Action {

	

}	
 $query = "SELECT email FROM vtiger_contactdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid WHERE contactid = ? AND deleted = 0";
$result = $adb->pquery($query,array($_REQUEST['record']));

$emailid = $adb->query_result($result, 0 , 'email');

$resultbearer = $adb->pquery("SELECT bearer FROM ss_contactenrichment WHERE active = 1",array());
$bearer = $adb->query_result($resultbearer, 0 , 'bearer');



$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.fullcontact.com/v3/person.enrich");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"email": "'.$emailid.'"}');
curl_setopt($ch, CURLOPT_POST, 1);

$headers = array();
$headers[] = "Authorization: Bearer l64pERb0m2pKaZDtwkjd0BoaOdCsfiWi";
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);

}
$res = json_decode($result,true);
curl_close ($ch);

/*
 * Creating Update data
 */

$linkedin = $res['linkedin'];
//echo "<pre>"; print_r($linkedin); die;

$result = $adb->pquery("UPDATE vtiger_contactscf SET linkedin_id = ?",array($linkedin));

return true;

?>
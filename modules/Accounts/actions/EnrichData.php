<?php

/*error_reporting(1);
		ini_set('display_erros',1);

		  register_shutdown_function('handleErrors');
		    function handleErrors() {

		       $last_error = error_get_last();

		       if (!is_null($last_error)) { // if there has been an error at some point

			  // do something with the error
			  print_r($last_error);

		       }

		    } */

# Class for Data Enrichment API (Company)
# Created By Mabruk 
# For Accounts

class Accounts_EnrichData_Action extends Vtiger_Action_Controller
{

    function __construct()
    {
        
        $this->exposeMethod('enrichData');        

    }

    public function checkPermission(Vtiger_Request $request)
    {
        $moduleName = $request->getModule();
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);

        $userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        $permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

        if (!$permission) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
    }

    public function process(Vtiger_Request $request)
    {
        $mode = $request->getMode();
        if (!empty($mode) && $this->isMethodExposed($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }

    }

    /**
     * @param Vtiger_Request $request
     * Function Added By Mabruk For Data Enrichment
     * @throws Exception
     */
    function enrichData(Vtiger_Request $request)
    {
       
		require_once('modules/Accounts/Accounts.php');						

        global $adb, $current_user, $VTIGER_BULK_SAVE_MODE, $root_directory; 

        $VTIGER_BULK_SAVE_MODE 	= true;
        $message 				= "success"; //Default Value for message
        $reload 				= "no"; //Default Value for reload
		$accountid 				= $request->get('record');
		
		$query   				= "SELECT vtiger_account.website, vtiger_account.accountname
								   FROM vtiger_account								   
								   INNER JOIN vtiger_crmentity
								   ON vtiger_crmentity.crmid = vtiger_account.accountid
								   WHERE vtiger_account.accountid = ?
								   AND vtiger_crmentity.deleted = 0";

		$result  				= $adb->pquery($query,array($accountid));
		$companyName            = $adb->query_result($result, 0 , 'accountname');				
		$website 				= $adb->query_result($result, 0 , 'website');	
		$resultbearer 			= $adb->pquery("SELECT bearer FROM ss_contactenrichment WHERE active = 1",array());
		$bearer 				= $adb->query_result($resultbearer, 0 , 'bearer');

		if ($website != "" && $website != null) {
			
			// Company Enrichment API 
			$ch 			= curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://api.fullcontact.com/v3/company.enrich");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, '{"domain": "' . $website . '"}');
			curl_setopt($ch, CURLOPT_POST, 1);

			$headers   		= array();		
			$headers[] 		= "Authorization: Bearer $bearer";
			$headers[] 		= "Content-Type: application/x-www-form-urlencoded";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result 		= curl_exec($ch);		

			$companyDetails = json_decode($result,true);   
			curl_close ($ch);

			if (!isset($companyDetails['message'])) {

				$account 		= new Accounts();
				$account->id 	= $accountid;
				$account->retrieve_entity_info($account->id,'Accounts',false,true); 
				$account->mode = 'edit';

				// To Track History of Updates
				/*$em 			= new VTEventsManager($adb);
				$em->initTriggerCache();					
				$entityData 	= VTEntityData::fromCRMEntity($account);
				$em->triggerEvent("vtiger.entity.beforesave.modifiable", $entityData);
				$em->triggerEvent("vtiger.entity.beforesave", $entityData);				
				$em->triggerEvent("vtiger.entity.beforesave.final", $entityData);*/

				$trackerData = array();
				$counter     = 0;	


				// Mapping Fields for Company/Organization Details in account Module
				if (!empty($companyDetails['name'])) {

					$trackerData [$counter]['fieldname']   = "accountname";
					$trackerData [$counter]['prevalue']    = $account->column_fields['accountname']; 
					$companyName = $account->column_fields['accountname'] = $companyDetails['name'];
					$trackerData [$counter]['postvalue']   = $account->column_fields['accountname']; 
					$counter++;					

				}

				if (isset($companyDetails['details']['emails']['0']['value']) && !empty($companyDetails['details']['emails']['0']['value'])) {

					$email = $companyDetails['details']['emails']['0']['value'];

					$trackerData [$counter]['fieldname']  = "email1";
					$trackerData [$counter]['prevalue']   = $account->column_fields['email1']; 
					$account->column_fields['email1'] 	  = $email;
					$trackerData [$counter]['postvalue']  = $account->column_fields['email1']; 
					$counter++;					

				}

				if (isset($companyDetails['details']['emails']['1']['value']) && !empty($companyDetails['details']['emails']['1']['value'])) {

					$email = $companyDetails['details']['emails']['1']['value'];

					$trackerData [$counter]['fieldname']  = "email2";
					$trackerData [$counter]['prevalue']   = $account->column_fields['email2']; 
					$account->column_fields['email2'] 	  = $email;
					$trackerData [$counter]['postvalue']  = $account->column_fields['email2']; 
					$counter++;					

				}

				if (isset($companyDetails['details']['locations']['0']['formatted']) && !empty($companyDetails['details']['locations']['0']['formatted'])) {

					$address = $companyDetails['details']['locations']['0']['formatted'];

					$trackerData [$counter]['fieldname']  = "address1";
					$trackerData [$counter]['prevalue']   = $account->column_fields['address1']; 
					$account->column_fields['address1']   = $address;
					$trackerData [$counter]['postvalue']  = $account->column_fields['address1']; 
					$counter++;					

				}

				if (isset($companyDetails['details']['locations']['1']['formatted']) && !empty($companyDetails['details']['locations']['1']['formatted'])) {

					$address = $companyDetails['details']['locations']['1']['formatted'];

					$trackerData [$counter]['fieldname']  = "address2";
					$trackerData [$counter]['prevalue']   = $account->column_fields['address2']; 
					$account->column_fields['address2'] 	= $address;
					$trackerData [$counter]['postvalue']  = $account->column_fields['address2']; 
					$counter++;					

				}

				if (!empty($companyDetails['employees'])) {

					$trackerData [$counter]['fieldname']  = "employees";
					$trackerData [$counter]['prevalue']   = $account->column_fields['employees']; 
					$account->column_fields['employees'] 	= $companyDetails['employees'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['employees']; 
					$counter++;					

				}

				if (!empty($companyDetails['twitter'])) {

					$trackerData [$counter]['fieldname']  = "twitter";
					$trackerData [$counter]['prevalue']   = $account->column_fields['twitter']; 
					$account->column_fields['twitter'] 	= $companyDetails['twitter'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['twitter']; 
					$counter++;					

				}

				if (!empty($companyDetails['linkedin'])) {

					$trackerData [$counter]['fieldname']  = "linkedin";
					$trackerData [$counter]['prevalue']   = $account->column_fields['linkedin']; 
					$account->column_fields['linkedin'] 	= $companyDetails['linkedin'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['linkedin']; 
					$counter++;					

				}

				if (!empty($companyDetails['bio'])) {

					$trackerData [$counter]['fieldname']  = "bio";
					$trackerData [$counter]['prevalue']   = $account->column_fields['bio'];
					$account->column_fields['bio'] 		= $companyDetails['bio'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['bio']; 
					$counter++;					

				}

				if (!empty($companyDetails['logo'])) {

					$trackerData [$counter]['fieldname']  = "logo";
					$trackerData [$counter]['prevalue']   = $account->column_fields['logo'];	
					$account->column_fields['logo'] 		= $companyDetails['logo'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['logo']; 
					$counter++;					

				}

				if (!empty($companyDetails['founded'])) {

					$trackerData [$counter]['fieldname']  = "founded";
					$trackerData [$counter]['prevalue']   = $account->column_fields['founded'];	
					$account->column_fields['founded'] 	= $companyDetails['founded'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['founded']; 
					$counter++;					

				}

				if (!empty($companyDetails['category'])) {

					$trackerData [$counter]['fieldname']  = "category";
					$trackerData [$counter]['prevalue']   = $account->column_fields['category'];	
					$account->column_fields['category'] 	= $companyDetails['category'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['category']; 
					$counter++;					

				}

				if (!empty($companyDetails['facebook'])) {

					$trackerData [$counter]['fieldname']  = "facebook";
					$trackerData [$counter]['prevalue']   = $account->column_fields['facebook'];	
					$account->column_fields['facebook'] 	= $companyDetails['facebook'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['facebook']; 
					$counter++;					

				}

				if (!empty($companyDetails['location'])) {

					$trackerData [$counter]['fieldname']  = "location";
					$trackerData [$counter]['prevalue']   = $account->column_fields['company_location'];	
					$account->column_fields['location'] 	= $companyDetails['location'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['location']; 
					$counter++;					
				}

				if (!empty($companyDetails['locale'])) {

					$trackerData [$counter]['fieldname']  = "locale";
					$trackerData [$counter]['prevalue']   = $account->column_fields['locale'];	
					$account->column_fields['locale'] 	  = $companyDetails['locale'];
					$trackerData [$counter]['postvalue']  = $account->column_fields['locale']; 
					$counter++;			
				}	
				
				$account->save('Accounts');
				$reload 	= "yes";
				
				//$entityData = VTEntityData::fromCRMEntity($account);
				//$em->triggerEvent("vtiger.entity.aftersave", $entityData);
				//$em->triggerEvent("vtiger.entity.aftersave.final", $entityData);

				$tableId   = $adb->getUniqueId("vtiger_modtracker_basic"); 
				$date      = date("Y-m-d H:i:s");
				$sessionId = $_SESSION['session_id'];				

				$adb->pquery("INSERT INTO  vtiger_modtracker_basic VALUES (?,?,?,?,?,?,?,?)", array($tableId, $accountid, "Accounts", 1, $date, 0, $sessionId, 'yes'));

				foreach ($trackerData as $data) {

					$adb->pquery("INSERT INTO vtiger_modtracker_detail VALUES (?,?,?,?)", array($tableId, $data['fieldname'], $data['prevalue'], $data['postvalue']));

				}				

				$adb->pquery("UPDATE vtiger_crmentity SET label = '$companyName' WHERE crmid = ?", array($accountid));

				$file  = "Response: \n\n";
				$file .= print_r($companyDetails, true); 

				$file .= "\n\nCRM MAPPING: \n\n";
				$file .= print_r($account->column_fields, true); 

				file_put_contents($root_directory . "/Enrichment Logs/" . $accountid . '_' . date("d.m.Y H:i:s") . '.log', $file);					

			}

			else {

				if (preg_match('/\bWebhook\b/',$companyDetails['message']))
					$message = "Please try again later";
				else
					$message = $companyDetails['message'];

			}

		}					

		else
			$message = "Company Website field is empty, cannot perform data enrichment for Company";	

		// Sending Response to CRM	
		$response 	= new Vtiger_Response();
		$response->setResult(array("message" => $message, "reload" => $reload,"accountname" => $companyName ));
		$response->emit();

    }    
}

?>




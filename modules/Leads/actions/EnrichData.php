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

# Class for Data Enrichment API (Person/Company)
# Created By Mabruk 
# For Leads

class Leads_EnrichData_Action extends Vtiger_Action_Controller
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

		require_once('modules/Leads/Leads.php');		

        global $adb,$root_directory, $current_user,$VTIGER_BULK_SAVE_MODE;

        $VTIGER_BULK_SAVE_MODE 	= true; // To turn off the workflows

        $message 				= "success"; //Default Value for message
        $reload 				= "no"; //Default Value for reload
		$leadid 				= $request->get('record');
		
		$query   				= "SELECT vtiger_leaddetails.email, vtiger_leadscf.company_website 
								   FROM vtiger_leaddetails
								   INNER JOIN vtiger_leadscf
								   ON vtiger_leaddetails.leadid = vtiger_leadscf.leadid
								   INNER JOIN vtiger_crmentity
								   ON vtiger_crmentity.crmid = vtiger_leaddetails.leadid
								   WHERE vtiger_leaddetails.leadid = ?
								   AND vtiger_crmentity.deleted = 0";

		$result  				= $adb->pquery($query,array($leadid));
		$emailid 				= $adb->query_result($result, 0 , 'email');		
		$companyWebsite 		= $adb->query_result($result, 0 , 'company_website'); 
		$resultbearer 			= $adb->pquery("SELECT bearer FROM ss_contactenrichment WHERE active = 1",array());
		$bearer 				= $adb->query_result($resultbearer, 0 , 'bearer');

		if ($emailid != "" && $emailid != null) {

			// Person Enrichment API 
			$ch 			= curl_init();

			curl_setopt($ch, CURLOPT_URL, "https://api.fullcontact.com/v3/person.enrich");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, '{"email": "' . $emailid . '"}');
			curl_setopt($ch, CURLOPT_POST, 1);

			$headers   		= array();		
			$headers[] 		= "Authorization: Bearer $bearer";
			$headers[] 		= "Content-Type: application/x-www-form-urlencoded";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result        	= curl_exec($ch);		

			$personDetails 	= json_decode($result,true);
			curl_close ($ch);		


			// Update Data and Validation
			if (!isset($personDetails['status'])) {

				$lead 		= new Leads();
				$lead->id 	= $leadid;
				$lead->retrieve_entity_info($lead->id,'Leads',false,true); 
				$lead->mode = 'edit';

				// To Track History of Updates
				/*$em 			= new VTEventsManager($adb);
				$em->initTriggerCache();					
				$entityData 	= VTEntityData::fromCRMEntity($lead);
				$em->triggerEvent("vtiger.entity.beforesave.modifiable", $entityData);
				$em->triggerEvent("vtiger.entity.beforesave", $entityData);				
				$em->triggerEvent("vtiger.entity.beforesave.final", $entityData);*/

				$trackerData = array();
				$counter     = 0;				

				// Mapping Fields for contact Details
				if (!empty($personDetails['fullName'])) {

					if (!empty($personDetails['details']['name']['given'])) {

					$trackerData [$counter]['fieldname']  = "firstname";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['firstname']; 	
					$firstname = $lead->column_fields['firstname'] = $personDetails['details']['name']['given'] . " " . $personDetails['details']['name']['middle'];					
					$trackerData [$counter]['postvalue']  = $lead->column_fields['firstname']; 
					$counter++;	

					}					
					
					if (!empty($personDetails['details']['name']['family'])) {

						$trackerData [$counter]['fieldname']  = "lastname";
						$trackerData [$counter]['prevalue']   = $lead->column_fields['lastname']; 
						$lastname = $personDetails['details']['name']['family'];
						$lead->column_fields['lastname'] = $lastname; 
						$trackerData [$counter]['postvalue']  = $lead->column_fields['lastname']; 
						$counter++;

					}
				
				}				

				if (!empty($personDetails['details'][0]['value'])) {

					$trackerData [$counter]['fieldname']  = "phone";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['phone']; 
					$lead->column_fields['phone'] 		  = $personDetails['details'][0]['value'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['phone']; 
					$counter++;

				}

				if (!empty($personDetails['ageRange'])) {

					$trackerData [$counter]['fieldname']  = "age_range";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['age_range']; 
					$lead->column_fields['age_range'] 	= $personDetails['ageRange'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['age_range']; 
					$counter++;

				}

				if (!empty($personDetails['gender'])){

					$trackerData [$counter]['fieldname']  = "gender";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['gender']; 
					$lead->column_fields['gender'] 		= $personDetails['gender'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['gender']; 
					$counter++;

				}

				if (!empty($personDetails['location'])) {

					$trackerData [$counter]['fieldname']  = "location";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['location']; 
					$lead->column_fields['location'] 	= $personDetails['location'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['location']; 
					$counter++;

				}

				if (!empty($personDetails['organization'])) {

					$trackerData [$counter]['fieldname']  = "company";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['company']; 
					$lead->column_fields['company'] 	= $personDetails['organization'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['company']; 
					$counter++;

				}

				if (!empty($personDetails['title'])) {

					$trackerData [$counter]['fieldname']  = "designation";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['designation']; 
					$lead->column_fields['designation'] = $personDetails['title'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['designation']; 
					$counter++;

				}

				if (!empty($personDetails['twitter'])) {

					$trackerData [$counter]['fieldname']  = "twitter";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['twitter']; 
					$lead->column_fields['twitter'] 	= $personDetails['twitter'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['twitter']; 
					$counter++;

				}

				if (!empty($personDetails['facebook'])) {

					$trackerData [$counter]['fieldname']  = "facebook";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['facebook']; 
					$lead->column_fields['facebook'] 	= $personDetails['facebook'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['facebook']; 
					$counter++;					

				}

				if (!empty($personDetails['linkedin'])) {

					$trackerData [$counter]['fieldname']  = "linkedin";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['linkedin']; 
					$lead->column_fields['linkedin'] 	= $personDetails['linkedin'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['linkedin']; 
					$counter++;					

				}

				if (!empty($personDetails['avatar'])) {

					$trackerData [$counter]['fieldname']  = "avatar";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['avatar']; 
					$lead->column_fields['avatar'] 		= $personDetails['avatar'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['avatar']; 
					$counter++;					

				}

				if (!empty($personDetails['bio'])) {

					$trackerData [$counter]['fieldname']  = "bio";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['bio']; 
					$lead->column_fields['bio'] 		= $personDetails['bio'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['bio']; 
					$counter++;					

				}

				if (!empty($personDetails['website'])) {

					$trackerData [$counter]['fieldname']  = "website";
					$trackerData [$counter]['prevalue']   = $lead->column_fields['website']; 
					$lead->column_fields['website'] 	= $personDetails['website'];
					$trackerData [$counter]['postvalue']  = $lead->column_fields['website']; 
					$counter++;					

				}

				if ($companyWebsite != '' && $companyWebsite != null) {
				
					// Company Enrichment API
					$ch 	   		= curl_init();

					curl_setopt($ch, CURLOPT_URL, "https://api.fullcontact.com/v3/company.enrich");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, '{"domain": "' . $companyWebsite . '"}');
					curl_setopt($ch, CURLOPT_POST, 1);

					$headers   		= array();		
					$headers[] 		= "Authorization: Bearer $bearer";
					$headers[] 		= "Content-Type: application/x-www-form-urlencoded";
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$result 		= curl_exec($ch);		

					$companyDetails = json_decode($result,true);
					curl_close ($ch);

					if (!isset($companyDetails['message'])) {

						// Mapping Fields for Company/Organization Details in Lead Module
						if (!empty($companyDetails['twitter'])) {

							$trackerData [$counter]['fieldname']  = "company_twitter";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_twitter']; 
							$lead->column_fields['company_twitter'] 	= $companyDetails['twitter'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_twitter']; 
							$counter++;					

						}

						if (!empty($companyDetails['linkedin'])) {

							$trackerData [$counter]['fieldname']  = "company_linkedin";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_linkedin']; 
							$lead->column_fields['company_linkedin'] 	= $companyDetails['linkedin'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_linkedin']; 
							$counter++;					

						}

						if (!empty($companyDetails['bio'])) {

							$trackerData [$counter]['fieldname']  = "company_bio";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_bio'];
							$lead->column_fields['company_bio'] 		= $companyDetails['bio'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_bio']; 
							$counter++;					

						}

						if (!empty($companyDetails['logo'])) {

							$trackerData [$counter]['fieldname']  = "company_logo";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_logo'];	
							$lead->column_fields['company_logo'] 		= $companyDetails['logo'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_logo']; 
							$counter++;					

						}

						if (!empty($companyDetails['founded'])) {

							$trackerData [$counter]['fieldname']  = "company_founded";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_founded'];	
							$lead->column_fields['company_founded'] 	= $companyDetails['founded'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_founded']; 
							$counter++;					

						}

						if (!empty($companyDetails['category'])) {

							$trackerData [$counter]['fieldname']  = "company_category";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_category'];	
							$lead->column_fields['company_category'] 	= $companyDetails['category'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_category']; 
							$counter++;					

						}

						if (!empty($companyDetails['facebook'])) {

							$trackerData [$counter]['fieldname']  = "company_facebook";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_facebook'];	
							$lead->column_fields['company_facebook'] 	= $companyDetails['facebook'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_facebook']; 
							$counter++;					

						}

						if (!empty($companyDetails['location'])) {

							$trackerData [$counter]['fieldname']  = "company_location";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['company_location'];	
							$lead->column_fields['company_location'] 	= $companyDetails['location'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['company_location']; 
							$counter++;					

						}

						if (!empty($companyDetails['locale'])) {

							$trackerData [$counter]['fieldname']  = "locale";
							$trackerData [$counter]['prevalue']   = $lead->column_fields['locale'];	
							$lead->column_fields['locale'] 				= $companyDetails['locale'];
							$trackerData [$counter]['postvalue']  = $lead->column_fields['locale']; 
							$counter++;					

						}

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
					
				$lead->save('Leads');

				$reload 	= "yes";

				//$entityData = VTEntityData::fromCRMEntity($lead);
				//$em->triggerEvent("vtiger.entity.aftersave", $entityData);
				//$em->triggerEvent("vtiger.entity.aftersave.final", $entityData);

				$tableId   = $adb->getUniqueId("vtiger_modtracker_basic"); 
				$date      = date("Y-m-d H:i:s");
				$sessionId = $_SESSION['session_id'];				

				$adb->pquery("INSERT INTO  vtiger_modtracker_basic VALUES (?,?,?,?,?,?,?,?)", array($tableId, $leadid, "Leads", 1, $date, 0, $sessionId, 'yes'));

				foreach ($trackerData as $data) {

					$adb->pquery("INSERT INTO vtiger_modtracker_detail VALUES (?,?,?,?)", array($tableId, $data['fieldname'], $data['prevalue'], $data['postvalue']));

				}				

				$adb->pquery("UPDATE vtiger_crmentity SET label = '$firstname $lastname' WHERE crmid = ?", array($leadid));

				$file  = "Response(Person Details): \n\n";
				$file .= print_r($personDetails, true); 

				$file .= "\n\nResponse(Company Details): \n\n";
				$file .= print_r($companyDetails, true); 

				$file .= "\n\nCRM MAPPING: \n\n";
				$file .= print_r($lead->column_fields, true); 

				file_put_contents($root_directory . "/Enrichment Logs/" . $leadid . '_' . date("d.m.Y H:i:s") . '.log', $file);

			}

			else {				

				if ($personDetails['status'] == '202')
					$message = "Please try again later";
				else
					$message = $personDetails['message'];

			}
		}

		else 
			$message = "Primary Email field is empty, cannot perform data enrichment";



		// Sending Response to CRM	
		$response 	= new Vtiger_Response();

		$response->setResult(array("message" => $message, "reload" => $reload,"firstname" => $firstname, "lastname" => $lastname));

		$response->emit();

    }    
}

?>



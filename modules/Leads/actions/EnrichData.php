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
		require_once('modules/Users/Users.php');

        global $adb,$current_user,$VTIGER_BULK_SAVE_MODE;

        $VTIGER_BULK_SAVE_MODE 	= true;
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
					
				// Mapping Fields for Lead Details
				if (!empty($personDetails['fullName'])) {

					$firstname = $lead->column_fields['firstname'] 	= $personDetails['details']['name']['given'] . " " . $personDetails['details']['name']['middle'];	

					$lastname = $lead->column_fields['lastname'] 	= $personDetails['details']['name']['family'];
				
				}			

				if (!empty($personDetails['details'][0]['value']))
					$lead->column_fields['phone'] 		= $personDetails['details'][0]['value'];

				if (!empty($personDetails['ageRange']))
					$lead->column_fields['age_range'] 	= $personDetails['ageRange'];

				if (!empty($personDetails['gender']))
					$lead->column_fields['gender'] 		= $personDetails['gender'];

				if (!empty($personDetails['location']))
					$lead->column_fields['location'] 	= $personDetails['location'];

				if (!empty($personDetails['organization']))
					$lead->column_fields['company'] 	= $personDetails['organization'];

				if (!empty($personDetails['title']))
					$lead->column_fields['designation'] = $personDetails['title'];

				if (!empty($personDetails['twitter']))
					$lead->column_fields['twitter'] 	= $personDetails['twitter'];

				if (!empty($personDetails['facebook']))
					$lead->column_fields['facebook'] 	= $personDetails['facebook'];

				if (!empty($personDetails['linkedin']))
					$lead->column_fields['linkedin'] 	= $personDetails['linkedin'];

				if (!empty($personDetails['avatar']))
					$lead->column_fields['avatar'] 		= $personDetails['avatar'];

				if (!empty($personDetails['bio']))
					$lead->column_fields['bio'] 		= $personDetails['bio'];

				if (!empty($personDetails['website']))
					$lead->column_fields['website'] 	= $personDetails['website'];

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
						if (!empty($companyDetails['twitter']))
							$lead->column_fields['company_twitter'] 	= $companyDetails['twitter'];

						if (!empty($companyDetails['linkedin']))
							$lead->column_fields['company_linkedin'] 	= $companyDetails['linkedin'];

						if (!empty($companyDetails['bio']))
							$lead->column_fields['company_bio'] 		= $companyDetails['bio'];

						if (!empty($companyDetails['logo']))
							$lead->column_fields['company_logo'] 		= $companyDetails['logo'];

						if (!empty($companyDetails['founded']))
							$lead->column_fields['company_founded'] 	= $companyDetails['founded'];

						if (!empty($companyDetails['category']))
							$lead->column_fields['company_category'] 	= $companyDetails['category'];

						if (!empty($companyDetails['facebook']))
							$lead->column_fields['company_facebook'] 	= $companyDetails['facebook'];

						if (!empty($companyDetails['location']))
							$lead->column_fields['company_location'] 	= $companyDetails['location'];

						if (!empty($companyDetails['locale']))
							$lead->column_fields['locale'] 				= $companyDetails['locale'];

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
				$reload = "yes";

			}

			else {				

				if ($personDetails['status'] == '202')
					$message = "Please try again later";
				else
					$message = $personDetails['message'];

			}
		}

		else 
			$message 		 = "Primary Email field is empty, cannot perform data enrichment";


		// Sending Response to CRM	
		$response 	= new Vtiger_Response();
		$response->setResult(array("message" => $message, "reload" => $reload,"firstname" => $firstname, "lastname" => $lastname));
		$response->emit();

    }    
}

?>



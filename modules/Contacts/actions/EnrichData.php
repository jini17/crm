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
# For contacts

class Contacts_EnrichData_Action extends Vtiger_Action_Controller
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
       
		require_once('modules/Contacts/Contacts.php');						

        global $adb,$current_user,$VTIGER_BULK_SAVE_MODE, $root_directory;

        $VTIGER_BULK_SAVE_MODE 	= true;
        $message 				= "success"; //Default Value for message
        $reload 				= "no"; //Default Value for reload
		$contactid 				= $request->get('record');
		
		$query   				= "SELECT vtiger_contactdetails.email
								   FROM vtiger_contactdetails								   
								   INNER JOIN vtiger_crmentity
								   ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
								   WHERE vtiger_contactdetails.contactid = ?
								   AND vtiger_crmentity.deleted = 0";

		$result  				= $adb->pquery($query,array($contactid));
		$emailid 				= $adb->query_result($result, 0 , 'email');				
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

				$contact 		= new Contacts();
				$contact->id 	= $contactid;
				$contact->retrieve_entity_info($contact->id,'Contacts',false,true); 

				// To Track History of Updates
				//$em 			= new VTEventsManager($adb);
				//$em->initTriggerCache();				
				//$entityData 	= VTEntityData::fromCRMEntity($contact);
				//$em->triggerEvent("vtiger.entity.beforesave.modifiable", $entityData);
				//$em->triggerEvent("vtiger.entity.beforesave", $entityData);				
				//$em->triggerEvent("vtiger.entity.beforesave.final", $entityData);

				$contact->mode 	= 'edit';

				$trackerData = array();
				$counter     = 0;
					
				// Mapping Fields for contact Details
				if (!empty($personDetails['fullName'])) {

					if (!empty($personDetails['details']['name']['given'])) {

					$trackerData [$counter]['fieldname']  = "firstname";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['firstname']; 	
					$firstname = $contact->column_fields['firstname'] = $personDetails['details']['name']['given'] . " " . $personDetails['details']['name']['middle'];					
					$trackerData [$counter]['postvalue']  = $contact->column_fields['firstname']; 
					$counter++;	

					}					
					
					if (!empty($personDetails['details']['name']['family'])) {

						$trackerData [$counter]['fieldname']  = "lastname";
						$trackerData [$counter]['prevalue']   = $contact->column_fields['lastname']; 
						$lastname = $personDetails['details']['name']['family'];
						$contact->column_fields['lastname'] = $lastname; 
						$trackerData [$counter]['postvalue']  = $contact->column_fields['lastname']; 
						$counter++;

					}
				
				}			

				if (!empty($personDetails['details'][0]['value'])) {

					$trackerData [$counter]['fieldname']  = "phone";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['phone']; 
					$contact->column_fields['phone'] = $personDetails['details'][0]['value'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['phone']; 
					$counter++;

				}

				if (!empty($personDetails['ageRange'])) {

					$trackerData [$counter]['fieldname']  = "age_range";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['age_range']; 
					$contact->column_fields['age_range'] 	= $personDetails['ageRange'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['age_range'];
					$counter++; 

				}

				if (!empty($personDetails['gender'])) {

					$trackerData [$counter]['fieldname']  = "gender";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['gender']; 
					$contact->column_fields['gender'] 		= $personDetails['gender'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['gender']; 
					$counter++;

				}

				if (!empty($personDetails['location'])) {

					$trackerData [$counter]['fieldname']  = "location";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['location']; 
					$contact->column_fields['location'] 	= $personDetails['location'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['location'];
					$counter++;

				}

				if (!empty($personDetails['organization'])) {

					$trackerData [$counter]['fieldname']  = "company";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['company'];
					$contact->column_fields['company'] 		= $personDetails['organization'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['company'];
					$counter++;

				}

				if (!empty($personDetails['title'])) {

					$trackerData [$counter]['fieldname']  = "title";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['title'];
					$contact->column_fields['title'] 		= $personDetails['title'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['title'];
					$counter++;

				}

				if (!empty($personDetails['twitter'])) {

					$trackerData [$counter]['fieldname']  = "twitter";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['twitter'];
					$contact->column_fields['twitter'] 		= $personDetails['twitter'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['twitter'];
					$counter++;

				}

				if (!empty($personDetails['facebook'])) {

					$trackerData [$counter]['fieldname']  = "facebook";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['facebook'];
					$contact->column_fields['facebook'] 	= $personDetails['facebook'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['facebook'];
					$counter++;

				}

				if (!empty($personDetails['linkedin'])) {

					$trackerData [$counter]['fieldname']  = "linkedin";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['linkedin'];
					$contact->column_fields['linkedin'] 	= $personDetails['linkedin'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['linkedin'];
					$counter++;

				}

				if (!empty($personDetails['avatar'])) {

					$trackerData [$counter]['fieldname']  = "avatar";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['avatar'];
					$contact->column_fields['avatar'] 		= $personDetails['avatar'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['avatar'];
					$counter++;

				}

				if (!empty($personDetails['bio'])) {

					$trackerData [$counter]['fieldname']  = "bio";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['bio'];
					$contact->column_fields['bio'] 			= $personDetails['bio'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['bio'];
					$counter++;

				}

				if (!empty($personDetails['website'])) {

					$trackerData [$counter]['fieldname']  = "website";
					$trackerData [$counter]['prevalue']   = $contact->column_fields['website'];
					$contact->column_fields['website'] 		= $personDetails['website'];
					$trackerData [$counter]['postvalue']  = $contact->column_fields['website'];
					$counter++;

				}
				
				$contact->save('Contacts');
				$reload 	= "yes";
				
				//$entityData = VTEntityData::fromCRMEntity($contact);
				//$em->triggerEvent("vtiger.entity.aftersave", $entityData);
				//$em->triggerEvent("vtiger.entity.aftersave.final", $entityData);

				$tableId   = $adb->getUniqueId("vtiger_modtracker_basic"); 
				$date      = date("Y-m-d H:i:s");
				$sessionId = $_SESSION['session_id'];				

				$adb->pquery("INSERT INTO  vtiger_modtracker_basic VALUES (?,?,?,?,?,?,?,?)", array($tableId, $contactid, "Contacts", 1, $date, 0, $sessionId, 'yes'));

				foreach ($trackerData as $data) {

					$adb->pquery("INSERT INTO vtiger_modtracker_detail VALUES (?,?,?,?)", array($tableId, $data['fieldname'], $data['prevalue'], $data['postvalue']));

				}				

				$adb->pquery("UPDATE vtiger_crmentity SET label = '$firstname $lastname' WHERE crmid = ?", array($contactid));

				$file  = "Response: \n\n";
				$file .= print_r($personDetails, true); 

				$file .= "\n\nCRM MAPPING: \n\n";
				$file .= print_r($contact->column_fields, true); 

				file_put_contents($root_directory . "/Enrichment Logs/" . $contactid . '_' . date("d.m.Y H:i:s") . '.log', $file);

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




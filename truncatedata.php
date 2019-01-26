<?php

	/**
		Reset Database Script 
		@author Jitendraknp2004@gmail.com
		@createdtime : 11 July 2018

	*/
	
	include_once 'config.inc.php';
	include_once 'include/utils/utils.php';

	global $adb;
	$adb->setDebug(true);
	$adb->query("SET FOREIGN_KEY_CHECKS = 0");
	$result = $adb->pquery("SELECT distinct tablename FROM `vtiger_field` WHERE tablename !='vtiger_crmentity' AND uitype IN (SELECT distinct uitype FROM vtiger_field WHERE uitype NOT IN (15, 16, 33)) AND tabid NOT IN (29, 79) ORDER by tablename asc", array());

	$num = $adb->num_rows($result);

	for($i=0;$i<$num;$i++){
		$tablename = $adb->query_result($result, $i, 'tablename');
		$adb->query("Truncate table $tablename");
	}	
		$adb->query("Truncate table  vtiger_crmentity_seq");
		$adb->query("INSERT INTO vtiger_crmentity_seq (`id`) VALUES ('1')");
		$adb->query("Truncate table  allocation_list");
		$adb->query("Truncate table  allocation_list_seq");
		$adb->query("INSERT INTO allocation_list_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  allocation_benefitrel");
		$adb->query("Truncate table  allocation_claimrel");
		$adb->query("Truncate table  allocation_graderel");
		$adb->query("Truncate table  allocation_leaverel");
		$adb->query("Truncate table  allowed_ip");
		$adb->query("Truncate table  contact_invite_details");
		$adb->query("Truncate table  external_invitees");
		$adb->query("Truncate table  office365_sync_map");
		$adb->query("Truncate table  secondcrm_claim_balance");
		$adb->query("Truncate table  secondcrm_company");
		$adb->query("Truncate table  secondcrm_designation");
		$adb->query("Truncate table  secondcrm_education");
		$adb->query("Truncate table  secondcrm_emergencycontact");
		$adb->query("Truncate table  secondcrm_institution");
		$adb->query("Truncate table  secondcrm_language");
		$adb->query("Truncate table  secondcrm_location");
		$adb->query("Truncate table  secondcrm_project");
		$adb->query("Truncate table  secondcrm_regiontree");
		$adb->query("Truncate table  secondcrm_region_data");
		$adb->query("Truncate table  secondcrm_skillmaster");
		$adb->query("Truncate table  secondcrm_skills");
		$adb->query("Truncate table  secondcrm_softskill");
		$adb->query("Truncate table  secondcrm_studyarea");
		$adb->query("Truncate table  secondcrm_tnc_assigncompany");
		$adb->query("Truncate table  secondcrm_userplan");
		$adb->query("INSERT INTO secondcrm_userplan (`planid`,`userid`) VALUES ('4','1')");
		$adb->query("DELETE FROM vtiger_users WHERE id !=1");
		$adb->query("Truncate table  vtiger_user2role");
		$adb->query("INSERT INTO vtiger_user2role (`userid`,`roleid`) VALUES ('1','H2')");
		$adb->query("Truncate table  vtiger_webforms");
		$adb->query("Truncate table  vtiger_webforms_field");
		$adb->query("Truncate table  vtiger_smsnotifier_status");
		$adb->query("Truncate table  vtiger_smsnotifier");
		$adb->query("Truncate table  vtiger_smsnotifiercf");
		$adb->query("Truncate table  vtiger_systems");
		$adb->query("Truncate table  secondcrm_users_assigncompany");
		$adb->query("Truncate table  secondcrm_userworkexp");
		$adb->query("Truncate table  secondcrm_user_balance");
		$adb->query("Truncate table  ss_contactenrichment");
		$adb->query("Truncate table  vtiger_activityproductrel");
		$adb->query("Truncate table  vtiger_activity_recurring_info");
		$adb->query("Truncate table  vtiger_activity_reminder");
		$adb->query("Truncate table  vtiger_activity_reminder_popup");
		$adb->query("Truncate table  vtiger_asterisk");
		$adb->query("Truncate table  vtiger_asteriskextensions");
		$adb->query("Truncate table  vtiger_asteriskincomingcalls");
		$adb->query("Truncate table  vtiger_asteriskincomingevents");
		$adb->query("Truncate table  vtiger_attachments");
		$adb->query("Truncate table  vtiger_audit_trial");
		$adb->query("Truncate table  vtiger_calendar_user_activitytypes");
		$adb->query("Truncate table  vtiger_campaignaccountrel");
		$adb->query("Truncate table  vtiger_campaigncontrel");
		$adb->query("Truncate table  vtiger_cntactivityrel");
		$adb->query("Truncate table  vtiger_contpotentialrel");
		$adb->query("Truncate table  vtiger_convertleadmapping");
		$adb->query("Truncate table  vtiger_convertpotentialmapping");
		$adb->query("Truncate table  vtiger_crmentityrel");
		$adb->query("Truncate table  vtiger_crmsetup");
		$adb->query("Truncate table  vtiger_customerdetails");
		$adb->query("Truncate table  vtiger_emaildetails");
		$adb->query("Truncate table  vtiger_emailslookup");
		$adb->query("Truncate table  vtiger_email_access");
		$adb->query("Truncate table  vtiger_email_track");
		$adb->query("Truncate table  vtiger_freetagged_objects");
		$adb->query("Truncate table  vtiger_freetags");
		$adb->query("Truncate table  vtiger_freetags_seq");
		$adb->query("INSERT INTO vtiger_freetags_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_homedefault");
		$adb->query("Truncate table  vtiger_homereportchart");
		$adb->query("Truncate table  vtiger_homestuff");
		$adb->query("Truncate table  vtiger_homestuff_seq");
		$adb->query("INSERT INTO vtiger_homestuff_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_import_maps");
		$adb->query("Truncate table  vtiger_inventoryproductrel_seq");
		$adb->query("INSERT INTO vtiger_inventoryproductrel_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_inventoryshippingrel");
		$adb->query("Truncate table  vtiger_inventorysubproductrel");
		$adb->query("Truncate table  vtiger_inventory_tandc");
		$adb->query("Truncate table  vtiger_invitees");
		$adb->query("Truncate table  vtiger_loginhistory");
		$adb->query("Truncate table  vtiger_mailer_queue");
		$adb->query("Truncate table  vtiger_mailer_queueinfo");
		$adb->query("Truncate table  vtiger_mailer_queue_seq");
		$adb->query("INSERT INTO vtiger_mailer_queue_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_mailmanager_mailrecord");
		$adb->query("Truncate table  vtiger_mailmanager_mailattachments");
		$adb->query("Truncate table  vtiger_mailmanager_mailrel");
		$adb->query("Truncate table  vtiger_modcommentscf");
		$adb->query("Truncate table  vtiger_modtracker_basic");
		$adb->query("Truncate table  vtiger_modcommentscf");
		$adb->query("Truncate table  vtiger_modtracker_basic_seq");
		$adb->query("INSERT INTO vtiger_modtracker_basic_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_modtracker_detail");
		$adb->query("Truncate table  vtiger_modtracker_relations");
		$adb->query("Truncate table  vtiger_multiplefromaddress");
		$adb->query("Truncate table  vtiger_office365_event_calendar_mapping");
		$adb->query("Truncate table  vtiger_office365_oauth2");
		$adb->query("Truncate table  vtiger_office365_sync");
		$adb->query("Truncate table  vtiger_pbxmanager");
		$adb->query("Truncate table  vtiger_pbxmanagercf");
		$adb->query("Truncate table  vtiger_pbxmanager_gateway");
		$adb->query("Truncate table  vtiger_pbxmanager_phonelookup");
		$adb->query("Truncate table  vtiger_portalinfo");
		$adb->query("Truncate table  vtiger_recurringevents");
		$adb->query("Truncate table  vtiger_salesmanattachmentsrel");
		$adb->query("Truncate table  vtiger_salesmanactivityrel");
		$adb->query("Truncate table  vtiger_salesmanticketrel");
		$adb->query("Truncate table  vtiger_seactivityrel");
		$adb->query("Truncate table  vtiger_seactivityrel_seq");
		$adb->query("INSERT INTO vtiger_seactivityrel_seq (`id`) VALUES ('0')");
		$adb->query("Truncate table  vtiger_senotesrel");
		$adb->query("Truncate table  vtiger_seproductsrel");
		$adb->query("Truncate table  vtiger_shorturls");
		$adb->query("Truncate table  vtiger_tracker");
		$adb->query("Truncate table  vtiger_vendorcontactrel");
		$adb->query("Truncate table  vtiger_ws_userauthtoken");
		$adb->query("Truncate table  vtiger_emergencycontactcf");
		$adb->query("DELETE  FROM vtiger_organizationdetails WHERE organization_id !=1");
		$adb->query("DELETE  FROM vtiger_crmentity WHERE crmid !='1'");
		
		
		shell_exec('sudo chmod -R 0777 storage');
		shell_exec('rm -rf storage/*');

		$dir = 'user_privileges';
		$leave_files = array('audit_trail.php', 'default_module_view.php','enable_backup.php','index.html','sharing_privileges_1.php','user_privileges_1.php');

		foreach( glob("$dir/*") as $file ) {
    		
    		if( !in_array(basename($file), $leave_files) )
        		unlink($file);
		}

	$adb->disconnect();
	//connection close
?>
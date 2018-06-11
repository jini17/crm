<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk for Googe Drive Settings on 17/05/2018
 ************************************************************************************/
require_once 'testAPI/vendor/autoload.php';

class Settings_Vtiger_AdvanceGoogleConfigEdit_Action extends Settings_Vtiger_Basic_Action {

	public function __construct() {
		parent::__construct();
		$this->exposeMethod('updateAccessKey');
		$this->exposeMethod('uploadFileGenerateLink');
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if (!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	private function getGoogleClient($path){
		$client = new Google_Client();
	 	$client->setApplicationName('TEST');
	 	$client->setScopes(Google_Service_Drive::DRIVE);
	 	$client->setAuthConfig($path);
	 	$client->setAccessType('offline');

	 	return $client;
	}

	public function uploadFileGenerateLink(Vtiger_Request $request) {
		if (isset($_FILES)) {
			if ($_FILES["file"]["type"] == "application/json")
				move_uploaded_file($_FILES["file"]["tmp_name"],'testAPI/uploaded_file.json');
			else
				return "The file format is incorrect";
		}

		$file = JSON_decode(file_get_contents("testAPI/uploaded_file.json"),true);
		$file = $file["installed"];
		$client = $this->getGoogleClient('testAPI/uploaded_file.json');

	 	if (array_key_exists("client_id",$file) && array_key_exists("client_secret",$file)) {
	 		$authUrl = $client->createAuthUrl();
	 		copy('testAPI/uploaded_file.json','testAPI/client_secret.json');
	 		echo "Please copy the following URL and select your gmail account to get the Access Key:" . "\n\n" . $authUrl;
	 	}	 	
	 	else 
	 		echo "Please upload the correct file";
	}

	public function updateAccessKey(Vtiger_Request $request) {
		global $adb;
		$accesskey = $request->get('accesskey');
		$client = $this->getGoogleClient('testAPI/client_secret.json');

		$result = $adb->pquery("SELECT access_key FROM google_drive_credentials WHERE id = 'gid'",array());
		$DBAccess_key = $adb->query_result($result,0,'access_key');
		
		if ($DBAccess_key != $accesskey) {
			$adb->pquery("UPDATE google_drive_credentials SET access_key = ? WHERE id = 'gid'",array($accesskey));

			$accessToken = $client->fetchAccessTokenWithAuthCode($accesskey);

			file_put_contents("testAPI/drive-php-quickstart.json", json_encode($accessToken));
		}
	}	
        
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}

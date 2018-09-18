<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
require_once 'testAPI/vendor/autoload.php';

class EmployeeContract_Record_Model extends Vtiger_Record_Model {

	/**
	 * Function to get the Display Name for the record
	 * @return <String> - Entity Display Name for the record
	 */
	function getDisplayName() {
		return Vtiger_Util_Helper::getRecordName($this->getId());
	}

	function getDownloadFileURL() {
	
		$fileDetails = $this->getFileDetails();
		return 'index.php?module='. $this->getModuleName() .'&action=DownloadFile&record='. $this->getId() .'&fileid='. $fileDetails['attachmentsid'];
	}

	function getFileDetails() {
		$db = PearDatabase::getInstance();
		$fileDetails = array();
		$result = $db->pquery("SELECT * FROM vtiger_attachments
							INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
							WHERE crmid = ?", array($this->get('id')));

		if($db->num_rows($result)) {
			$fileDetails = $db->query_result_rowdata($result);
		}
		return $fileDetails;
	}

	function downloadFile() {
		$fileDetails = $this->getFileDetails();
		$fileContent = false; //print_r($fileDetails);die;

		
			$filePath = $fileDetails['path'];
			$fileName = $fileDetails['name'];


				$fileName = html_entity_decode($fileName, ENT_QUOTES, vglobal('default_charset'));
				$savedFile = $fileDetails['attachmentsid']."_".$fileName;

				while(ob_get_level()) {
					ob_end_clean();
				}
				$fileSize = filesize($filePath.$savedFile);
				$fileSize = $fileSize + ($fileSize % 1024);

				if (fopen($filePath.$savedFile, "r")) {
					$fileContent = fread(fopen($filePath.$savedFile, "r"), $fileSize);
					header("Content-type: ".$fileDetails['type']);
					header("Pragma: public");
					header("Cache-Control: private");
					header("Content-Disposition: attachment; filename=\"$fileName\"");
					header("Content-Description: PHP Generated Data");
                    header("Content-Encoding: none");
				}

			//Edit Done
			if($fileContent)	
				echo $fileContent;
		    else {
		    	echo "<script>window.history.back();alert('File Not found');</script>";
		    }
	}

	function updateFileStatus() {
		$db = PearDatabase::getInstance();

		$db->pquery("UPDATE vtiger_notes SET filestatus = 0 WHERE notesid= ?", array($this->get('id')));
	}

	function updateDownloadCount() {
		$db = PearDatabase::getInstance();
		$notesId = $this->get('id');

		$result = $db->pquery("SELECT filedownloadcount FROM vtiger_notes WHERE notesid = ?", array($notesId));
		$downloadCount = $db->query_result($result, 0, 'filedownloadcount') + 1;

		$db->pquery("UPDATE vtiger_notes SET filedownloadcount = ? WHERE notesid = ?", array($downloadCount, $notesId));
	}

	function getDownloadCountUpdateUrl() {
		return "index.php?module=Documents&action=UpdateDownloadCount&record=".$this->getId();
	}
	
	function get($key) {
		$value = parent::get($key);
		if ($key === 'notecontent') {
			return decode_html($value);
		}
		return $value;
	}

	function getExpiringDocument($filter, $pagingModel){
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		

		if($filter == 'contract' || $filter==null){
			$query = "SELECT concat(vtiger_users.first_name, '', vtiger_users.last_name) as fullname, vtiger_employeecontract.department, vtiger_employeecontract.designation, DAY(contract_expiry_date) as expirydate_day, MONTH(contract_expiry_date) as expirydate_month, YEAR(contract_expiry_date) as expirydate_year FROM vtiger_employeecontract 
					  INNER JOIN vtiger_employeecontractcf ON vtiger_employeecontractcf.employeecontractid=vtiger_employeecontract.employeecontractid 
					  INNER JOIN vtiger_users ON vtiger_users.id = vtiger_employeecontract.employee_id 
					  WHERE contract_expiry_date between curdate() AND ADDDATE(curdate(), 30) LIMIT ?, ?";
		}
		if($filter == 'passport'){
			$query = "SELECT  concat(vtiger_users.first_name, '', vtiger_users.last_name) as fullname, vtiger_users.department, vtiger_users.title as designation, DAY(date_expired) as expirydate_day, MONTH(date_expired) as expirydate_month, YEAR(date_expired) as expirydate_year FROM vtiger_passportvisa
					  INNER JOIN vtiger_users ON vtiger_users.id = vtiger_passportvisa.employee_id 
					  WHERE date_expired between curdate() AND ADDDATE(curdate(), 30) LIMIT ?, ?";
		}
		if($filter == 'visa'){
			$query = "SELECT concat(vtiger_users.first_name, '', vtiger_users.last_name) as fullname, vtiger_users.department, vtiger_users.title as designation, DAY(visa_date_expired) as expirydate_day, MONTH(visa_date_expired) as expirydate_month, YEAR(visa_date_expired) as expirydate_year FROM vtiger_passportvisa
					  INNER JOIN vtiger_users ON vtiger_users.id = vtiger_passportvisa.employee_id 
					  WHERE visa_date_expired between curdate() AND ADDDATE(curdate(), 30) LIMIT ?, ?";
		}
		$params = array();
		$params[] = $pagingModel->getStartIndex();
		$params[] = $pagingModel->getPageLimit();


		$result 	= $db->pquery($query, $params);
		$noOfRows 	= $db->num_rows($result);

		if($pagingModel->get('recordcount') < $noOfRows) {
			$pagingModel->set('recordcount', $noOfRows);
		}
		

		$rowdetails = array();
		for($i=0;$i<$noOfRows;$i++){
			$rowdetails[$i]['fullname'] = $db->query_result($result, $i, 'fullname');
			$rowdetails[$i]['department'] = $db->query_result($result, $i, 'department');
			$rowdetails[$i]['designation'] = $db->query_result($result, $i, 'designation');
			$rowdetails[$i]['expirydate_day'] = $db->query_result($result, $i, 'expirydate_day');
			$rowdetails[$i]['expirydate_month'] = $db->query_result($result, $i, 'expirydate_month');
			$rowdetails[$i]['expirydate_year'] = $db->query_result($result, $i, 'expirydate_year');
		}
		
		return $rowdetails;
	}
   
}

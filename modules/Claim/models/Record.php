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

class Claim_Record_Model extends Vtiger_Record_Model {

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
			echo $fileContent;
	}

	public function getWidgetsMyClaim($userid, $filtertype=null){

                $db = PearDatabase::getInstance();
                $db->setDebug(true);

                if($filtertype =='claimtype'){

                        $query = "SELECT vtiger_claimtype.yearlylimit AS allocated, SUM(vtiger_claim.totalamount) AS used, vtiger_claimtype.yearlylimit - SUM(vtiger_claim.totalamount) AS balance, vtiger_claimtype.claim_type AS claimtype FROM `vtiger_claim` 
                        	INNER JOIN vtiger_claimtype ON vtiger_claimtype.claimtypeid = vtiger_claim.category 
                        	WHERE vtiger_claim.employee_id = ?
                        	GROUP BY vtiger_claim.category";	

                        $result = $db->pquery($query,array($userid));
                        $myclaim=array();	
                        $balance = 0;
                        for($i=0;$db->num_rows($result)>$i;$i++){
                                $myclaim [$i]['allocated'] = $db->query_result($result, $i, 'allocated');	
                                $myclaim [$i]['used']	 	 = $db->query_result($result, $i, 'used');
                                $myclaim [$i]['balance']	 = $db->query_result($result, $i, 'balance');
                                $myclaim [$i]['claimtype'] = $db->query_result($result, $i, 'claimtype');
                                
                                /*$myclaim [$i]['allocated'] 	= $claim_allocated;
                                $myclaim [$i]['used'] 		= $claim_used;
                                $myclaim [$i]['balance'] 	= $claim_balance;	
                                $myclaim [$i]['claimtype'] 	= $claim_claimtype;*/

                        }

                } else {

                		$query = "SELECT vtiger_claimtype.claim_type, vtiger_claim.totalamount, vtiger_claim.transactiondate 
                        	FROM vtiger_claim 
							INNER JOIN vtiger_claimtype ON vtiger_claimtype.claimtypeid = vtiger_claim.category
							INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_claim.claimid
							WHERE vtiger_claim.employee_id = ?
							ORDER BY vtiger_claim.transactiondate DESC LIMIT 0, 5";

                        $result = $db->pquery($query,array($userid));

                        $myclaim=array();	

                        for($i=0;$db->num_rows($result)>$i;$i++){						
                                $myleave[$i]['claim_type'] 			= $db->query_result($result, $i, 'claim_type');
                                $myleave[$i]['total_amount'] 		= $db->query_result($result, $i, 'totalamount');
                                $myleave[$i]['transaction_date'] 	= $db->query_result($result, $i, 'transactiondate');
                        }

                }
                return $myclaim;
        }

	
	function getDownloadCountUpdateUrl() {
		return "index.php?module=Claim&action=UpdateDownloadCount&record=".$this->getId();
	}
}

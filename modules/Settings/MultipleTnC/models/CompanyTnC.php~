<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * MultipleTnC CompanyTnC Model Class
 */
class Settings_MultipleTnC_CompanyTnC_Model extends Vtiger_Base_Model {

	/**
	 * Function to get the Qualified Id of the Group Member
	 * @return <Number> Id
	 */
	public function getId() {
		return $this->get('id');
	}

	/**
	 * Function to get the Multiple Term & Condition Title
	 * @return <String>
	 */
	public function getTitle() {
		return $this->get('title');
	}

	/**
	 * Function to get all the Company By User
	 * @return <Array> - Array of Settings_MultipleTnC_CompanyTnC_Model instances
	 */
	public static function getAllCompanyByUser($user=NULL) {
		$company = array();
		$db = PearDatabase::getInstance();
		$currentUser = Users_Record_Model::getCurrentUserModel();
		if($user) {
			$sql = "SELECT tblVTOD.organization_id, tblVTOD.organization_title 
					FROM vtiger_organizationdetails tblVTOD 
				LEFT JOIN secondcrm_users_assigncompany tblSCUAC 
					ON tblSCUAC.organization_id = tblVTOD.organization_id 
				WHERE tblSCUAC.userid = ?";
			$params = array($user);

			} else {
			  $sql = "SELECT tblVTOD.organization_id, tblVTOD.organization_title 
					FROM vtiger_organizationdetails tblVTOD";	
			}
		$result = $db->pquery($sql, $params);
		$noOfCompany = $db->num_rows($result);			
		for($i=0;$i<$noOfCompany;$i++) {
			$organizationId	          = $db->query_result($result, $i, 'organization_id');
			$company['OrganizationId'][$i]  = $organizationId;
		}
		return $company;
	}
	
	/**
	 * Function to get all the Company By Terms & Condition
	 * @return <Array> - Array of Settings_MultipleTnC_CompanyTnC_Model instances
	 */
	public static function getAllCompanyByTnC($tnc=NULL) {
		$company = array();
		$db = PearDatabase::getInstance();
		
		if($tnc) {
			$sql    = "SELECT tblVTOD.organization_id, tblVTOD.organization_title 
					FROM vtiger_organizationdetails tblVTOD 
					LEFT JOIN secondcrm_tnc_assigncompany tblSCTAC 
					ON tblSCTAC.organization_id = tblVTOD.organization_id 
				   WHERE tblSCTAC.tncid = ?";
			$params = array($tnc);

		} else {
			  $sql = "SELECT tblVTOD.organization_id, tblVTOD.organization_title 
					FROM vtiger_organizationdetails tblVTOD";	
		}

		$result = $db->pquery($sql, $params);
		$noOfCompany = $db->num_rows($result);			
		for($i=0;$i<$noOfCompany;$i++) {
			$organizationId	          = $db->query_result($result, $i, 'organization_id');
			$company[$i]['organizationId'] = $organizationId;
			$company[$i]['organization_title'] = $db->query_result($result, $i, 'organization_title');;
		}
		return $company;
	}

}

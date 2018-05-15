<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
vimport('~~/modules/WSAPP/synclib/models/SyncRecordModel.php');

class Office365_Contacts_Model extends WSAPP_SyncRecordModel {
   
    /**
     * return id of Google Record
     * @return <string> id
     */
    public function getId($count) {

        return $this->data[$count]['Id'];
    }

    /**
     * return modified time of Google Record
     * @return <date> modified time 
     */
    public function getModifiedTime($count) {
        return $this->vtigerFormat($this->data[$count]['LastModifiedDateTime']);
    }
    
    function getNamePrefix($count) {
        $namePrefix = $this->data[$count]['Title'];
        if($namePrefix=="")
        $namePrefix="Mr/Mrs";
        return $namePrefix;
    }

    /**
     * return first name of Google Record
     * @return <string> $first name
     */
    function getFirstName($count) { 
        $fname = $this->data[$count]['GivenName'];
        return $fname;
    }

    /**
     * return Lastname of Google Record
     * @return <string> Last name
     */
    function getLastName($count) { 
        $lname = $this->data[$count]['Surname'];;
        return $lname;
    }

    /**
     * return Emails of Google Record
     * @return <array> emails
     */
    function getEmails($count) {
        $emails = $this->data[$count]['EmailAddresses'][0]['Address'];
     
        
        return $emails;
    }

    /**
     * return Phone number of Google Record
     * @return <array> phone numbers
     */
    function getPhones($count) {
        $phones = $this->data[$count]['MobilePhone1'];
       
        return $phones;
    }

    /**
     * return Addresss of Google Record
     * @return <array> Addresses
     */
    function getAddresses($count) {
        $addresses = $this->data[$count]['HomeAddress'];
       
        return $addresses;
    }
    
    function getUserDefineFieldsValues() {
      
        return null;
    }
    
    function getUrlFields($count) {
        $websiteFields = $this->data[$count]['BusinessHomePage'];       
        return $websiteFields;
    }
    
    function getBirthday($count) {
        return $this->data[$count]['Birthday'];
    }
    
    function getTitle($count) {
        return $this->data[$count]['Title'];
    }
    
   /* function getAccountName($userId) {
        /*$description = false;
        $orgName = $this->data['entity']['gd$organization'][0]['gd$orgName']['$t'];
        if(empty($orgName)) {
            $contactsModel = Vtiger_Module_Model::getInstance('Contacts');
            $accountFieldInstance = Vtiger_Field_Model::getInstance('account_id', $contactsModel);
            if($accountFieldInstance->isMandatory()) {
                $orgName = '????';
                $description = 'This Organization is created to support Office365 Contacts Synchronization. Since Organization Name is mandatory !';
            }
        }
        if(!empty($orgName)) {
            $db = PearDatabase::getInstance();
            $result = $db->pquery("SELECT crmid FROM vtiger_crmentity WHERE label = ? AND deleted = ? AND setype = ?", array($orgName, 0, 'Accounts'));
            if($db->num_rows($result) < 1) {
				try {
					$accountModel = Vtiger_Module_Model::getInstance('Accounts');
					$recordModel = Vtiger_Record_Model::getCleanInstance('Accounts');
				
					$fieldInstances = Vtiger_Field_Model::getAllForModule($accountModel);
					foreach($fieldInstances as $blockInstance) {
						foreach($blockInstance as $fieldInstance) {
							$fieldName = $fieldInstance->getName();
							$fieldValue = $recordModel->get($fieldName);
							if(empty($fieldValue)) {
								$defaultValue = $fieldInstance->getDefaultFieldValue();
								if($defaultValue) {
									$recordModel->set($fieldName, decode_html($defaultValue));
								}
								if($fieldInstance->isMandatory() && !$defaultValue) {
									$randomValue = Vtiger_Util_Helper::getDefaultMandatoryValue($fieldInstance->getFieldDataType());
									if($fieldInstance->getFieldDataType() == 'picklist' || $fieldInstance->getFieldDataType() == 'multipicklist') {
										$picklistValues = $fieldInstance->getPicklistValues();
										$randomValue = reset($picklistValues);
									}
									$recordModel->set($fieldName, $randomValue);
								}
							}
						}
					}
					$recordModel->set('mode', '');
					$recordModel->set('accountname', $orgName);
					$recordModel->set('assigned_user_id', $userId);
					$recordModel->set('source', 'OFFICE365');
					if($description) {
						$recordModel->set('description', $description);
					}
					$recordModel->save();
				} catch (Exception $e) {
					//TODO - Review
				}
            }
           // return $orgName;
           return null;
        }
        //return false;
        return null;
    }*/
    
    function getDescription() {
        return null;
    }

    /**
     * Returns the Google_Contacts_Model of Google Record
     * @param <array> $recordValues
     * @return Google_Contacts_Model
     */
    public static function getInstanceFromValues($recordValues) {
        $model = new Office365_Contacts_Model($recordValues);
        return $model;
    }

    /**
     * converts the Google Format date to 
     * @param <date> $date Google Date
     * @return <date> Vtiger date Format
     */
    public function vtigerFormat($date) {
        list($date, $timestring) = explode('T', $date);
        list($time, $tz) = explode('.', $timestring);

        return $date . " " . $time;
    }

}

?>

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

class Outlook_Contacts_Model extends WSAPP_SyncRecordModel {
    
    /**
     * return id of Google Record
     * @return <string> id
     */
    public function getId() {
        $arr=$this->value;
        $Id=array();
        if(is_array($arr)){
            foreach ($arr as $id) {
                $Id[]=$id->Id;
            }
        }
        else
            $Id=$this->value[0]->Id;
        return $Id;
    }

    /**
     * return modified time of Google Record
     * @return <date> modified time 
     */
    public function getModifiedTime() {
        return $this->vtigerFormat($this->value[0]->LastModifiedDateTime);
    }
    
    function getNamePrefix() {
        $arr=$this->value;
        $namePrefix=array();
        if(is_array($arr)){
            foreach ($arr as $key => $nameprefix) {
                $namePrefix[]=$nameprefix->Title;
            }
        }
        else
             $namePrefix = $this->value[0]->Title;
        return $namePrefix;
    }

    /**
     * return first name of Google Record
     * @return <string> $first name
     */
    function getFirstName() {
        $arr=$this->value;
        $fname=array();
        if(is_array($arr)){
            foreach ($arr as $Fname) {
                $fname[]=$Fname->GivenName;
            }
        }
        else
            $fname = $this->value[0]->GivenName;
        return $fname;
    }

    /**
     * return Lastname of Google Record
     * @return <string> Last name
     */
    function getLastName() {
        $arr=$this->value;
        $lname=array();
        if(is_array($arr)){
            foreach ($arr as $Lname) {
                $lname[]=$Lname->Surname;
            }
        }
        else
         $lname = $this->value[0]->Surname;
        return $lname;
    }

    /**
     * return Emails of Google Record
     * @return <array> emails
     */
    function getEmails() {
        $arr=$this->value;
        $emails=array();
        if(is_array($arr)){
            foreach ($arr as $address) {
                $emails[]=$address->EmailAddresses[0]->Address; 
            }
        }
        else
         $emails = $this->value[0]->EmailAddresses[0]->Address;        
        return $emails;
    }

    /**
     * return Phone number of Google Record
     * @return <array> phone numbers
     */
    function getPhones() {
         $arr=$this->value;
         $phones=array();
         if(is_array($arr)){
            foreach ($arr as $Phones) {
                $phones[]=$Phones->MobilePhone1;
            }
         }
         else
            $phones = $this->value->MobilePhone1;        
        return $phones;
    }

    /**
     * return Addresss of Google Record
     * @return <array> Addresses
     */
    function getAddresses() {
        $arr = $this->value;
        $addresses = array();
        if(is_array($arr)) {
            foreach ($arr as $address) {
                $structuredAddress = array(
                    'Street' => $address->BusinessAddress->Street,                
                    'City' => $address->BusinessAddress->City,
                    'State' => $address->BusinessAddress->State,
                    'CountryOrRegion' => $address->BusinessAddress->CountryOrRegion,
                    'PostalCode' => $address->BusinessAddress->PostalCode
                );
                $addresses[]['BusinessAddress'] = $structuredAddress;
            }
          

        }
        else{
            foreach ($arr as $address) {
            $structuredAddress = array(
                    'Street' => $address->BusinessAddress->Street,                
                    'City' => $address->BusinessAddress->City,
                    'State' => $address->BusinessAddress->State,
                    'CountryOrRegion' => $address->BusinessAddress->CountryOrRegion,
                    'PostalCode' => $address->BusinessAddress->PostalCode
                );
        }
            $addresses['BusinessAddress']=$structuredAddress;
        }
        return $addresses;
    }
    
    function getUserDefineFieldsValues() {
        $fieldValues = null;
       
        return $fieldValues;
    }
    
    function getUrlFields() {
        $websiteFields = $this->value;
        $urls = array();
        if(is_array($websiteFields)) {
            foreach($websiteFields as $website) {
                $urls = $website->BusinessHomePage;               
            }
        }
        return $urls;
    }
    
    function getBirthday() {
        $arr=$this->value;
         $birthday=array();
         if(is_array($arr)){
            foreach ($arr as $Birthdays) {
                $birthday[]=$Birthdays->Birthday;
            }
         }
         else
            $birthday = $this->value->Birthday;   
        return $birthday;
    }
    
    function getTitle() {
          $arr=$this->value;
         $title=array();
         if(is_array($arr)){
            foreach ($arr as $Titles) {
                $title[]=$Titles->Title;
            }
         }
         else
            $title = $this->value->Title; 
        return $title;
    }
    
    function getAccountName($userId) {
        $description = false;
        $orgName = $this->value->CompanyName;
        if(empty($orgName)) {
            $contactsModel = Vtiger_Module_Model::getInstance('Contacts');
            $accountFieldInstance = Vtiger_Field_Model::getInstance('account_id', $contactsModel);
            if($accountFieldInstance->isMandatory()) {
                $orgName = '????';
                $description = 'This Organization is created to support Google Contacts Synchronization. Since Organization Name is mandatory !';
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
					$recordModel->set('source', 'Outlook');
					if($description) {
						$recordModel->set('description', $description);
					}
					$recordModel->save();
				} catch (Exception $e) {
					//TODO - Review
				}
            }
            return $orgName;
        }
        return false;
    }
    
    function getDescription() {
        return null;
    }

    /**
     * Returns the Google_Contacts_Model of Google Record
     * @param <array> $recordValues
     * @return Google_Contacts_Model
     */
    public static function getInstanceFromValues($recordValues) {
        $model = new Outlook_Contacts_Model($recordValues);
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

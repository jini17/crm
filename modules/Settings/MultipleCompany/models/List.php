<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_MultipleCompany_List_Model extends Settings_Vtiger_Module_Model {

    STATIC $logoSupportedFormats = array('jpeg', 'jpg', 'png', 'gif', 'pjpeg', 'x-png');
    var $baseTable = 'vtiger_organizationdetails';
    var $baseIndex = 'organization_id';
    var $listFields = array('organizationname');
    var $nameFields = array('organizationname');
    var $logoPath = 'test/logo/';
    var $fields = array(
	'organization_title' => 'text',	
        'organizationname' => 'text',
        'logoname' => 'text',
        'address' => 'textarea',
        'city' => 'text',
        'state' => 'text',
        'code' => 'text',
        'country' => 'text',
        'phone' => 'text',
        'fax' => 'text',
        'website' => 'text'
    );

    /**
     * Function to get Edit view Url
     * @return <String> Url
     */
    public function getEditViewUrl() {
        return 'index.php?module=MultipleCompany&parent=Settings&view=Edit';
    }

    /**
     * Function to get CompanyDetails Menu item
     * @return menu item Model
     */
    public function getMenuItem() {
        $menuItem = Settings_Vtiger_MenuItem_Model::getInstance('LBL_COMPANY_DETAILS');
        return $menuItem;
    }

    /**
     * Function to get Index view Url
     * @return <String> URL
     */
    public function getIndexViewUrl() {
        $menuItem = $this->getMenuItem();
        return 'index.php?module=MutlipleCompany&parent=Settings&view=Detail&block=' . $menuItem->get('blockid') . '&fieldid=' . $menuItem->get('fieldid');
    }

    /**
     * Function to get fields
     * @return <Array>
     */
    public function getFields() {
        return $this->fields;
    }

    
    /**
     * Function to get the instance of Company details module model
     * @return <Settings_Vtiger_CompanyDetais_Model> $moduleModel
     */
    public static function getInstance() {
        $moduleModel = new self();
        $db = PearDatabase::getInstance();

        $result = $db->pquery("SELECT * FROM vtiger_organizationdetails", array());
        if ($db->num_rows($result) == 1) {
            $moduleModel->setData($db->query_result_rowdata($result));
            $moduleModel->set('id', $moduleModel->get('organization_id'));
        }

        $moduleModel->getFields();
        return $moduleModel;
    }




    //added by zul on jun 13, 2014
    public static function getListCompany() {

        $cnt = 0;
        $db = PearDatabase::getInstance();

        $query = "select * from vtiger_organizationdetails order by organization_id";
        $result = $db->pquery($query, array());

        $edit = "Edit  ";
        $del = "Del  ";
        $bar = "  | ";
        $cnt = 0;

        $return_data = array();
        while ($temprow = $db->fetch_array($result)) {
            $templatearray = array();
            $templatearray['organization_id'] = $db->query_result($result, $cnt, 'organization_id');
            $templatearray['organization_name'] = $db->query_result($result, $cnt, 'organizationname');
            $templatearray['organization_title'] = $db->query_result($result, $cnt, 'organization_title');
            $templatearray['organization_address'] = $db->query_result($result, $cnt, 'address');
            $templatearray['organization_city'] = $db->query_result($result, $cnt, 'city');
            $templatearray['organization_state'] = $db->query_result($result, $cnt, 'state');
            $templatearray['organization_code'] = $db->query_result($result, $cnt, 'code');
            $templatearray['organization_country'] = $db->query_result($result, $cnt, 'country');
            $templatearray['organization_phone'] = $db->query_result($result, $cnt, 'phone');
            $templatearray['organization_fax'] = $db->query_result($result, $cnt, 'fax');
            $templatearray['organization_website'] = $db->query_result($result, $cnt, 'website');
            //Handle for allowed organation logo/logoname likes UTF-8 Character
            $templatearray['organization_logo'] = decode_html($db->query_result($result, $cnt, 'logo'));
            $templatearray['organization_logoname'] = decode_html($db->query_result($result, $cnt, 'logoname'));
            $return_data[$cnt] = $templatearray;
            $cnt++;
        }
        return $return_data;
    }

}

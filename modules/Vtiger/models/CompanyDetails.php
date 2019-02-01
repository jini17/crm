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
 * CompanyDetails Record Model class
 */
class Vtiger_CompanyDetails_Model extends Vtiger_Base_Model {

    /**
     * Function to get the Company Logo
     * @return Vtiger_Image_Model instance
     */
    public function getLogo(){

        $companyid = decode_html($this->get('organization_id'));
        $recordModel = Vtiger_Record_Model::getInstanceById($companyid, 'OrganizationDetails');
        $imagedetails = $recordModel->getImageDetails();
        $logoName = decode_html($imagedetails[0]['name']);
        $logoModel = new Vtiger_Image_Model();

        if(!empty($logoName)) {
            $companyLogo = array();
            $companyLogo['imagepath'] = $imagedetails[0]['path'].'_'.$logoName;
            $companyLogo['alt'] = $imagedetails[0]['orgname'] = $companyLogo['imagename'] = $logoName;
            $logoModel->setData($companyLogo);
        }

        return $logoModel;
    }

    /**
     * Function to get the instance of the CompanyDetails model for a given organization id
     * @param <Number> $id
     * @return Vtiger_CompanyDetails_Model instance
     */
    public static function getInstanceById($id = 1) {
        $companyDetails = Vtiger_Cache::get('vtiger', 'organization');

        if (!$companyDetails) {
        
            $db = PearDatabase::getInstance();
            $sql = 'SELECT * FROM vtiger_organizationdetails INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_organizationdetails.organization_id
                    WHERE isdefault=1 Limit 0, 1';
            $params = array();
        
            $result = $db->pquery($sql, $params);
            $companyDetails = new self();
            if ($result && $db->num_rows($result) > 0) {
                $resultRow = $db->query_result_rowdata($result, 0);
                $companyDetails->setData($resultRow);
            }
            Vtiger_Cache::set('vtiger','organization',$companyDetails);
        }
        return $companyDetails;
    }

}
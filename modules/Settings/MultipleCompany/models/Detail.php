<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_MultipleCompany_Detail_Model extends Settings_Vtiger_Module_Model {

    static $logoSupportedFormats = array('jpeg', 'jpg', 'png', 'gif', 'pjpeg', 'x-png');
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
        'website' => 'text',
	'vatid'=>'text'
    );

    /**
     * Function to get Edit view Url
     * @return <String> Url
     */
    public function getEditViewUrl() {
	$menuItem = $this->getMenuItem();	
        return 'index.php?module=MultipleCompany&parent=Settings&view=Edit&block=' . $menuItem->get('blockid') . '&fieldid=' . $menuItem->get('fieldid');
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
		return 'index.php?module=MultipleCompany&parent=Settings&view=List&block=' . $menuItem->get('blockid') . '&fieldid=' . $menuItem->get('fieldid');
    }	


    /**
     * Function to get fields
     * @return <Array>
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * Function to get Logo path to display
     * @return <String> path
     */
    public function getLogoPath() {
        $logoPath = $this->logoPath;
        $handler = @opendir($logoPath);
        $logoName = $this->get('logoname');
        if ($logoName && $handler) {
            while ($file = readdir($handler)) {
                if ($logoName === $file && in_array(str_replace('.', '', strtolower(substr($file, -4))), self::$logoSupportedFormats) && $file != "." && $file != "..") {
                    closedir($handler);
                    return $logoPath . $logoName;
                }
            }
        }
        return '';
    }

    /**
     * Function to save the logoinfo
     */
    public function saveLogo() {
        $uploadDir = vglobal('root_directory') . '/' . $this->logoPath;
        $logoName = $uploadDir . $_FILES["binFile"]["name"];
        move_uploaded_file($_FILES["binFile"]["tmp_name"], $logoName);
        copy($logoName, $uploadDir . 'application.ico');
    }

    /**
     * Function to save the Company details
     */
    public function save() {
        $db = PearDatabase::getInstance();
        $id = $this->get('id');
        $fieldsList = $this->getFields();
        unset($fieldsList['logo']);
        $tableName = $this->baseTable;

        if ($id) {
            $params = array();

            $query = "UPDATE $tableName SET ";
            foreach ($fieldsList as $fieldName => $fieldType) {
                $query .= " $fieldName = ?, ";
                array_push($params, $this->get($fieldName));
            }
            $query .= " logo = NULL WHERE organization_id = ?";

            array_push($params, $id);
        } else {
            $params = $this->getData();
	    $query = "INSERT INTO $tableName (";
            foreach ($fieldsList as $fieldName => $fieldType) {
                $query .= " $fieldName,";
            }
	    $query .= " organization_id) VALUES (" . generateQuestionMarks($params) . ", ?)";
	    array_push($params, $db->getUniqueID($this->baseTable));
        } 
         $db->pquery($query, $params);
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

	public static function getInstanceId($id) {
        $moduleModel = new self();
        $db = PearDatabase::getInstance();

        $result = $db->pquery("SELECT * FROM vtiger_organizationdetails WHERE organization_id = ?", array($id));
        if ($db->num_rows($result) == 1) {
            $moduleModel->setData($db->query_result_rowdata($result));
            $moduleModel->set('id', $moduleModel->get('organization_id'));
        }

        $moduleModel->getFields();
        return $moduleModel;
    }		

	public static function setId($id) {
		$moduleModel = new self();
        	$db = PearDatabase::getInstance();	
		$moduleModel->set('id',$id);
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

	   /* Function to get the instance of the group by Name
    * @param type $name -- name of the group
    * @return null/group instance
    */
   public static function getInstanceByName($name, $excludedRecordId = array()) {
       $db = PearDatabase::getInstance();
       $sql = 'SELECT * FROM vtiger_organizationdetails WHERE organization_title=?';
       $params = array($name);
	   
       if(!empty($excludedRecordId)){
           $sql.= ' AND organization_id NOT IN ('.generateQuestionMarks($excludedRecordId).')';
           $params = array_merge($params,$excludedRecordId);
       }
	   
       $result = $db->pquery($sql, $params);
       if($db->num_rows($result) > 0) {
		   return self::getInstanceFromQResult($result, 0);
	   }
	   return null;
   }

/**
	 * Function to get the instance of Groups record model from query result
	 * @param <Object> $result
	 * @param <Number> $rowNo
	 * @return Settings_Groups_Record_Model instance
	 */
	public static function getInstanceFromQResult($result, $rowNo) {
		$db = PearDatabase::getInstance();
		$row = $db->query_result_rowdata($result, $rowNo);
		$role = new self();
		return $role->setData($row);
	}	
	
	public function updateCustomNumbering($business,$company, $actionType){
		$db = PearDatabase::getInstance();
				
		//update business in companynumbering  	
		if($actionType == 'Checkbox') {	
			$sSql = "UPDATE  secondcrm_companynumbering SET  business =?";
			$result= $db->pquery($sSql, array($business));		
		}
		if($business == 1 && $actionType != 'Checkbox')
		{
			$sqlPre = "select * from vtiger_modentity_num where organization_id != 1 AND semodule IN ('Quotes','SalesOrder','PurchaseOrder','Invoice') AND organization_id =?";
			$resultPre = $db->pquery($sqlPre, array($company));
			$iNumRow = $db->num_rows($resultPre);
		
			if($iNumRow == 0 )
			{
				$sql2 = "SELECT semodule,prefix FROM vtiger_modentity_num WHERE organization_id = 1 AND active = 1 AND semodule IN ('Quotes','SalesOrder','PurchaseOrder','Invoice')";
				$result2 = $db->pquery($sql2, array());
		
				$aNumberingList = array();
				$iOptionIndex = 0;
				$iMaxNumbering = $db->num_rows($result2);
		
				for($iK=0;$iK<$iMaxNumbering;$iK++)
				{
					$iOptionIndex++;
					$aNumberingList[$iOptionIndex]['semodule'] = $db->query_result($result2,$iK,'semodule');
					$aNumberingList[$iOptionIndex]['prefix'] = $db->query_result($result2,$iK,'prefix');

				}
				$rs_numseq = $db->pquery("SELECT id FROM vtiger_modentity_num_seq",array());
				$num_id = $db->query_result($rs_numseq,0,'id');

					for($iL=1;$iL<=$iMaxNumbering;$iL++)
					{
						$semodule = $aNumberingList[$iL]['semodule'];
						$id = $company;
						$prefix = $aNumberingList[$iL]['prefix'].$id;
						$num_id++;
						$sql3 = "INSERT INTO vtiger_modentity_num (num_id,semodule , prefix, start_id, cur_id, active, organization_id) 
							VALUES ($num_id,'".$semodule."','".$prefix."',1,1,1,$id) ";
						$result3 = $db->pquery($sql3, array());
						$updaters_numid = $db->pquery("UPDATE vtiger_modentity_num_seq SET id =?",array($num_id));
					 }
			}
		
		
		}
		else
		{	
			$sqlDel = "DELETE FROM vtiger_modentity_num WHERE organization_id != 1 AND organization_id =?";
			$result= $db->pquery($sqlDel, array($company));
			
			$rsMaxnum = $db->pquery("SELECT max(num_id) AS num_id FROM vtiger_modentity_num",array());
			$num_id = $db->query_result($rsMaxnum,0,'num_id');
			$updaters_numid = $db->pquery("UPDATE vtiger_modentity_num_seq SET id =?",array($num_id));
			
		}
		/*$response = new Vtiger_Response();
		$response->setResult(array('success',true));
		$response->emit();
        */

	}
	   /**
    * Function for Find getUniqueId for lastinsert Record
    */
    public function getUniqueId() {
        $db = PearDatabase::getInstance();
        $rsId = $db->pquery("SELECT id FROM vtiger_organizationdetails_seq",array());
        $id = $db->query_result($rsId,0,'id');
        return $id;
    }
	
}

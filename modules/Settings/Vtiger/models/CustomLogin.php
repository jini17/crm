<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_Vtiger_CustomLogin_Model extends Settings_Vtiger_Module_Model {

	STATIC $logoSupportedFormats = array('jpeg', 'jpg', 'png', 'gif', 'pjpeg', 'x-png');

	var $baseTable = 'secondcrm_loginpage';
	var $baseIndex = 'id';
	var $listFields = array('linkurl');
	var $nameFields = array('wcmsg');
	var $logoPath = 'test/loginlogo/';

	var $fields = array(
			'id'=>'hidden',
			'linkurl' => 'text',
			'logo' => 'file',
			'wcmsg' => 'textarea',
			'smicon' => 'radio',
			'smdetail' => 'textarea',
			'sessionout'=>'select'
			
	);

	/**
	 * Function to get Edit view Url
	 * @return <String> Url
	 */
	public function getEditViewUrl() {
		return 'index.php?module=Vtiger&parent=Settings&view=CustomLoginEdit';
	}
	
	/**
	 * Function to get CompanyDetails Menu item
	 * @return menu item Model
	 */
	public function getMenuItem() {
		$menuItem = Settings_Vtiger_MenuItem_Model::getInstance('LBL_CUSTOM_LOGIN_PAGE');
		return $menuItem;
	}
	
	/**
	 * Function to get Index view Url
	 * @return <String> URL
	 */
	public function getIndexViewUrl() {
		$menuItem = $this->getMenuItem();
		return 'index.php?module=Vtiger&parent=Settings&view=CustomLogin&block='.$menuItem->get('blockid').'&fieldid='.$menuItem->get('fieldid');
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
		$logoName = $this->get('logo');
		if ($logoName && $handler) {
			while ($file = readdir($handler)) {
				if($logoName === $file && in_array(str_replace('.', '', strtolower(substr($file, -4))), self::$logoSupportedFormats) && $file != "." && $file!= "..") {
					closedir($handler);
					return $logoPath.$logoName;
				}
			}
		}
		return '';
	}

	/**
	 * Function to save the logoinfo
	 */
	public function saveLogo() {
		$uploadDir = vglobal('root_directory'). '/' .$this->logoPath;
		$logoName = $uploadDir.$_FILES["logo"]["name"];
		move_uploaded_file($_FILES["logo"]["tmp_name"], $logoName);
		//copy($logoName, $uploadDir.'application.ico');
	}

	/**
	 * Function to save the Company details
	 */
	public function save() {
		$db = PearDatabase::getInstance();
		$id = $this->get('id');
		$fieldsList = $this->getFields();
		//unset($fieldsList['logo']);
		$tableName = $this->baseTable;

		if ($id) {
			$params = array();

			$query = "UPDATE $tableName SET ";
			foreach ($fieldsList as $fieldName => $fieldType) {
				if($this->get($fieldName) !='' && $fieldName !='id') {
						$query .= " $fieldName = ? , ";
						array_push($params, $this->get($fieldName));
				}
			
			}
			$query .= " id =1 WHERE id = ?";
			array_push($params, $id);
		} else {
			$params = $this->getData();

			$query = "INSERT INTO $tableName (";
			foreach ($fieldsList as $fieldName => $fieldType) {
				$query .= " $fieldName,";
			}
			$query .= " id) VALUES (". generateQuestionMarks($params). ", ?)";

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

		$result = $db->pquery("SELECT * FROM secondcrm_loginpage", array());
		if ($db->num_rows($result) == 1) {
			$moduleModel->setData($db->query_result_rowdata($result));
			$moduleModel->set('id', $moduleModel->get('id'));
		}

		$moduleModel->getFields();
		return $moduleModel;
	}
        
        /** 
        * @var array(string => string) 
        */ 
       private static $settings = array();  

       /** 
        * @param string $fieldname 
        * @return string 
        */ 
       public static function getSetting($fieldname) { 
            global $adb; 
            if (!self::$settings) { 
                    self::$settings = $adb->database->GetRow("SELECT * FROM secondcrm_loginpage"); 
            } 
            return self::$settings[$fieldname]; 
       } 
}

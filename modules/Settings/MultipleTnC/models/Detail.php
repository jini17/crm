<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_MultipleTnC_Detail_Model extends Vtiger_Base_Model{
    
    const tableName = 'vtiger_inventory_tandc';

    var $fields = array(
	'title' => 'text',	
        'tandc' => 'text',
        'type' => 'text'
    );
    public function getText(){
        return $this->get('tandc');
    }
    
    public function setText($text){
        return $this->set('tandc',$text);
    }
    
    public function getType(){
        return $this->get('type');
        //return "Inventory";
    }
    
     public function setType($type){
        return $this->set('type',$type);
        //return "Inventory";
    }
    
    public static function getInstance() {
        $db = PearDatabase::getInstance();
        $query = 'SELECT tandc FROM '.self::tableName;
        $result = $db->pquery($query,array());
        $instance = new self();
        if($db->num_rows($result) > 0) {
            $text = $db->query_result($result,0,'tandc');
            $instance->setText($text);
        }
        return $instance;
    }
    
    public static function getInstances() {
        $db = PearDatabase::getInstance();
        $query = 'SELECT type FROM '.self::tableName;
        $result = $db->pquery($query,array());
        $instances = new self();
        if($db->num_rows($result) > 0) {
            $type = $db->query_result($result,0,'type');
            $instances->setType($type);
        }
        return $instances;
    }
       /**
	 * Function to get the url for default view of the module
	 * @return <string> - url
	 */
	public function getDefaultUrl() {
		return 'index.php?module=MultipleTnC&parent=Settings&view=List';
	}

	//added by zul on jun 11, 2014
	public static function getListTerm(){
		$cnt=0;
		$db = PearDatabase::getInstance();
		$query = 'SELECT * FROM '.self::tableName;
		$result = $db->pquery($query,array());
		$ins = new self();
        	while($temprow = $db->fetch_array($result)){
		        $templatearray=array();
		        $templatearray['id'] = $db->query_result($result, $cnt, 'id');
		        $templatearray['type'] = $db->query_result($result, $cnt, 'type');
		        $templatearray['title'] = $db->query_result($result, $cnt, 'title');
		        $templatearray['tandc'] = decode_html($db->query_result($result, $cnt, 'tandc'));
		        $return_data[$cnt]=$templatearray;
		        $cnt++;
        	}
		return $return_data;
	}
	
	public static function getInstanceId($id) {
		$moduleModel = new self();
		$db = PearDatabase::getInstance();
		$templatearray=array();
		$result = $db->pquery("SELECT * FROM vtiger_inventory_tandc WHERE id = ?", array($id));
		if ($db->num_rows($result) == 1) {
		        $templatearray['id'] = $db->query_result($result, 0, 'id');
		        $templatearray['type'] = $db->query_result($result, 0, 'type');
		        $templatearray['title'] = $db->query_result($result, 0, 'title');
		        $templatearray['tandc'] = $db->query_result($result, 0, 'tandc');
		}

		return $templatearray;
	}	
			
	/**
     	* Function to get fields
     	* @return <Array>
     	*/
	public function getFields() {
        	return $this->fields;
    	}
}

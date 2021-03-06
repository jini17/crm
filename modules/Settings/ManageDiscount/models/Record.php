<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ManageDiscount_Record_Model extends Settings_Vtiger_Record_Model {

	static $STATUS_DISABLED = 0;
    static $STATUS_ENABLED = 1;
    static $STATUS_RUNNING = 2;
	static $STATUS_COMPLETED = 3;

	/**
	 * Function to get Id of this record instance
	 * @return <Integer> id
	 */
	public function getId() {
		return $this->get('id');
	}

	public function getSequence() {
		return $this->get('sequence');
	}
	/**
	 * Function to get Name of this record
	 * @return <String>
	 */
	public function getName() {
		return $this->get('name');
	}

	/**
	 * Function to get module instance of this record
	 * @return <type>
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * Function to set module to this record instance
	 * @param <Settings_ManageDiscount_Module_Model> $moduleModel
	 * @return <Settings_ManageDiscount_Record_Model> record model
	 */
	public function setModule($moduleModel) {
		$this->module = $moduleModel;
		return $this;
	}

    public function isDisabled() {
        if($this->get('status') == self::$STATUS_DISABLED){
            return true;
        }
        return false;
    }
    
    public function isRunning() {
        if($this->get('status') == self::$STATUS_RUNNING){
            return true;
        }
        return false;
    }
    
    public function isCompleted() {
        if($this->get('status') == self::$STATUS_COMPLETED){
            return true;
        }
        return false;
    }
    
    public function isEnabled() {
        if($this->get('status') == self::$STATUS_ENABLED){
            return true;
        }
        return false;
    }
    
    /**
     * Detect if the task was started by never finished.
     */
    function hadTimedout() {
        if($this->get('lastend') === 0 && $this->get('laststart') != 0)
        return intval($this->get('lastend'));
    }
    
    /**
     * Get the user datetimefeild
     */
    function getLastEndDateTime() {
        if($this->get('lastend') != NULL) {
		    $lastScannedTime = Vtiger_Datetime_UIType::getDisplayDateTimeValue(date('Y-m-d H:i:s', $this->get('lastend')));
		    $userModel = Users_Record_Model::getCurrentUserModel();
			$hourFormat = $userModel->get('hour_format');
		    if($hourFormat == '24') {
				return $lastScannedTime;
		    } else {
				$dateTimeList = explode(" ", $lastScannedTime);
                return $dateTimeList[0]." ".date('g:i:sa', strtotime($dateTimeList[1]));
			}
		} else {
			return '';
		}
    }
    
    /**
     * Get Time taken to complete task
     */
    function getTimeDiff() {
        $lastStart = intval($this->get('laststart'));
        $lastEnd   = intval($this->get('lastend'));
        $timeDiff  = $lastEnd - $lastStart;
        return $timeDiff;
    }

	/**
	 * Function to get display value of every field from this record
	 * @param <String> $fieldName
	 * @return <String>
	 */
	public function getDisplayValue($fieldName) {
		$fieldValue = $this->get($fieldName);
		switch ($fieldName) {
			case 'frequency'	: $fieldValue = intval($fieldValue);
								  $hours	= str_pad((int)(($fieldValue/(60*60))),2,0,STR_PAD_LEFT);
								  $minutes	= str_pad((int)(($fieldValue%(60*60))/60),2,0,STR_PAD_LEFT);
								  $fieldValue = $hours.':'.$minutes;
								  break;
			case 'status'		: $fieldValue = intval($fieldValue);
								  $moduleModel = $this->getModule();
								  if ($fieldValue === Settings_ManageDiscount_Record_Model::$STATUS_COMPLETED) {
									  $fieldLabel = 'LBL_COMPLETED';
								  } else if ($fieldValue === Settings_ManageDiscount_Record_Model::$STATUS_RUNNING) {
									  $fieldLabel = 'LBL_RUNNING';
								  } else if ($fieldValue === Settings_ManageDiscount_Record_Model::$STATUS_ENABLED) {
									  $fieldLabel = 'LBL_ACTIVE';
								  } else {
									  $fieldLabel = 'LBL_INACTIVE';
								  }
								  $fieldValue = vtranslate($fieldLabel, $moduleModel->getParentName().':'.$moduleModel->getName());
								  break;
			case 'laststart'	:
			case 'lastend'		: $fieldValue = intval($fieldValue);
								  if ($fieldValue) {
									  $fieldValue = dateDiffAsString($fieldValue, time());
								  } else {
									  $fieldValue = '';
								  }
								  break;
		}
		return $fieldValue;
	}
	
	/*
	 * Function to get Edit view url 
	 */
	public function getEditViewUrl() {
		return 'module=ManageDiscount&parent=Settings&view=EditAjax&record='.$this->getId().'&mode=edit';
	}

	/**
	 * Function to save the record
	 */
	public function save() {
		$db = PearDatabase::getInstance();

		$updateQuery = "UPDATE vtiger_cron_task SET frequency = ?, status = ? WHERE id = ?";
		$params = array($this->get('frequency'), $this->get('status'), $this->getId());
		$db->pquery($updateQuery, $params);
	}

	/**
	 * Function to get record instance by using id and moduleName
	 * @param <Integer> $recordId
	 * @param <String> $qualifiedModuleName
	 * @return <Settings_ManageDiscount_Record_Model> RecordModel
	 */
	static public function getInstanceById($recordId='', $qualifiedModuleName) {
		$db = PearDatabase::getInstance();
		if($recordId=='new'){
			$recordModelClass = Vtiger_Loader::getComponentClassName('Model', 'Record', $qualifiedModuleName);
			$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
			$rowData = Array(
			    'id' => '',
			    'sequence' => '',
			    'title' => 'Add New',
			    'value' => '',
			    'status' => '',
			);
			$recordModel = new $recordModelClass();
			$recordModel->setData($rowData)->setModule($moduleModel);
			//echo "<pre>";print_r($rowData);echo "<pre>";
			return $recordModel;
		}else{
			$result = $db->pquery("SELECT secondcrm_discount2role.*, secondcrm_discount.discount_title, secondcrm_discount.discount_status FROM secondcrm_discount2role INNER JOIN secondcrm_discount ON secondcrm_discount2role.discountid = secondcrm_discount.discountid WHERE secondcrm_discount2role.id = ?", array($recordId));
			if ($db->num_rows($result)) {
				$recordModelClass = Vtiger_Loader::getComponentClassName('Model', 'Record', $qualifiedModuleName);
				$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
				$rowData = $db->query_result_rowdata($result, 0);


				$recordModel = new $recordModelClass();
				$recordModel->setData($rowData)->setModule($moduleModel);
				//echo "<pre>";print_r($rowData);echo "<pre>";
				return $recordModel;
			}
		}

	}
	
    public static function getInstanceByName($name) {
        $db = PearDatabase::getInstance();

		$result = $db->pquery("SELECT * FROM vtiger_cron_task WHERE name = ?", array($name));
		if ($db->num_rows($result)) {
			$moduleModel = new Settings_ManageDiscount_Module_Model();
			$rowData = $db->query_result_rowdata($result, 0);
			$recordModel = new self();
			$recordModel->setData($rowData)->setModule($moduleModel);
			return $recordModel;
		}
		return false;
    }


		/**
	 * Function to get the list view actions for the record
	 * @return <Array> - Associate array of Vtiger_Link_Model instances
	 */
	public function getRecordLinks() {

		$links = array();

		$recordLinks = array(
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_EDIT_RECORD',
				'linkurl' => "javascript:Settings_ManageDiscount_List_Js.triggerEditEvent('".$this->getEditViewUrl()."')",
				'linkicon' => 'icon-pencil'
			)
		);
		foreach($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}

		return $links;
	}
	
	public function getMinimumFrequency() {
		return getMinimumCronFrequency()*60;
	}
	
	public function getAllDiscount($recordId) {
       		 $db = PearDatabase::getInstance();

		 $where = '';
		 if(empty($recordId)) {
			$where = " WHERE secondcrm_discount2role.discount_type = 'V' AND secondcrm_discount.deleted =0";
		 }
		 $sql="SELECT GROUP_CONCAT(secondcrm_discount2role.roles_allow SEPARATOR '::') AS roles_allow,secondcrm_discount2role.id,secondcrm_discount2role.discountid, secondcrm_discount2role.discount_criteria, secondcrm_discount.discount_title, secondcrm_discount.discount_status FROM secondcrm_discount2role
			INNER JOIN secondcrm_discount ON secondcrm_discount2role.discountid = secondcrm_discount.discountid ".$where." GROUP BY secondcrm_discount2role.discountid";
		$result = $db->pquery($sql, array());
		for($i=0;$i<$db->num_rows($result);$i++) {
			$rowData[$i]['id'] = $db->query_result($result, $i, 'id');
			$rowData[$i]['discountid'] = $db->query_result($result, $i, 'discountid');
			$rowData[$i]['title'] = $db->query_result($result, $i, 'discount_title');
			$rowData[$i]['roles'] = $db->query_result($result, $i, 'roles_allow');
			$rowData[$i]['rolestitle'] = self::getRoleTitle($db->query_result($result, $i, 'roles_allow'));	
			$rowData[$i]['criteria'] = $db->query_result($result, $i, 'discount_criteria');	
		}
		return $rowData;
	}
	
	public function getRoleTitle($roles) {

		$db = PearDatabase::getInstance();
		$rolearray = explode('::',$roles);
		$roles = "'" . implode("','", $rolearray) . "'";	
		$query = $db->pquery("SELECT group_concat(rolename SEPARATOR ',') AS roles from vtiger_role WHERE roleid IN ($roles)",array());
		$return  = $db->query_result($query, 0, 'roles');
		return $return;
	}	

	public function getAllUsers() {
		$db = PearDatabase::getInstance();
		$query = "SELECT id, roleid, CONCAT( first_name, ' ', last_name ) AS fullname
				FROM vtiger_users
				INNER JOIN vtiger_user2role ON vtiger_user2role.userid = vtiger_users.id
				WHERE STATUS = 'Active'";
		
		$result = $db->pquery($query,array());
		$users=array();	
		for($i=0;$db->num_rows($result)>$i;$i++){
			$users[$i]['id'] = $db->query_result($result, $i, 'id');
			$users[$i]['fullname'] = $db->query_result($result, $i, 'fullname');
 			$users[$i]['roleid'] = $db->query_result($result, $i, 'roleid');
		}
	return $users;
	}
	public function getAllRoles() {
		$db = PearDatabase::getInstance();
		$query = "SELECT roleid , rolename FROM vtiger_role ";
		
		$result = $db->pquery($query,array());
		$roles=array();	
		for($i=0;$db->num_rows($result)>$i;$i++){
			$roles[$i]['roleid'] = $db->query_result($result, $i, 'roleid');
			$roles[$i]['rolename'] = $db->query_result($result, $i, 'rolename');

		}
	return $roles;
	}


	public function saveDiscount($request) {
		$db = PearDatabase::getInstance();
		$mode = $request->get('mode');
		$roles = $request->get('roles');
		$type = $request->get('type');
		$criteria = $request->get('criteria');
		$discountlevel = $request->get('discountlevel');
		$value = $request->get('value');
		$record = $request->get('record');
		//echo "SXDSXD<pre>";print_r($request);echo "<pre>";
		
		
		//roles manage
		if(is_array($roles)){
			$seproles = implode('::', $roles);
		}else{
			$seproles = $roles;
		}


		if($mode == 'new'){
		//echo "NEW";
		
		$sequence 	= self::getNextsequence();
		if($request->get('title') !='') {
			$discountseqid  = self::getNextdiscountid();
			$sql = "INSERT INTO secondcrm_discount(discountid, discount_title, discount_status, deleted) 
				VALUES (?,?,?,?)";
			$result = $db->pquery($sql, array($discountseqid, $request->get('title'), $request->get('status'), 0) );
		} else {
			$discountseqid  = $request->get('currentdiscount');
		}	
		$sql2 = "INSERT INTO secondcrm_discount2role(discountid, roles_allow, discount_type, discount_value, discount_criteria, discount_level, sequence, created_date, modified_date) 
				VALUES (?,?,?,?,?,?,?, NOW(), NOW())";

		$result2 = $db->pquery($sql2, array($discountseqid, $seproles, $type, $value, $criteria, $discountlevel, $sequence));
		
		self::updatesequence($sequence);
		

		} else if($mode == 'edit'){
		
			$sqlupd = "UPDATE secondcrm_discount2role SET discount_value=?, discount_level=?, modified_date= NOW() WHERE id = ?";
			$resultupd = $db->pquery($sqlupd, array($value, $discountlevel, $record));
			$sqlupd = "UPDATE secondcrm_discount SET discount_status=? WHERE discountid = ?";
			$resultupd = $db->pquery($sqlupd, array($request->get('status'), $request->get('discountid')));
		
		}

	}

	public function getNextdiscountid() {
		$db = PearDatabase::getInstance();
		$query="SELECT id FROM secondcrm_discount_seq";
		$result = $db->pquery($query,array());
		if($db->num_rows($result)==0) {
			$result = $db->pquery("INSERT INTO secondcrm_discount_seq(id) VALUE(1)",array());
			return 1;
		} else {
			return $seq = $db->query_result($result, 0, 'id') + 1;	
		}
	}

	public function getNextsequence() {
		$db = PearDatabase::getInstance();
		$query="SELECT MAX(sequence) AS maxseq FROM secondcrm_discount2role";
		$result = $db->pquery($query,array());
		$max = $db->query_result($result, 0, 'maxseq');
		if($max == null) {
			$max = 1;
		} else {
			$max++;
		}
		return $max;
	}

	public function updatesequence($sequence) {
		$db = PearDatabase::getInstance();
		$query="UPDATE secondcrm_discount_seq SET id=?";
		$result = $db->pquery($query,array($sequence));
	}

	public function deleteDiscount($discounts) {
		$db = PearDatabase::getInstance();

		if(is_array($discounts)){

			foreach($discounts  as $key => $value){
				$query="UPDATE secondcrm_discount SET deleted=1 WHERE discountid=?";
				$result = $db->pquery($query,array($value));
			}

		}else{
			$query="UPDATE secondcrm_discount SET deleted=1 WHERE discountid=?";
			$result = $db->pquery($query,array($discounts));
		}
		

	}

	public function getMainDiscount() {
       		 $db = PearDatabase::getInstance();

		 $sql="SELECT * FROM secondcrm_discount WHERE deleted = 0";
		$result = $db->pquery($sql, array());
		for($i=0;$i<$db->num_rows($result);$i++) {

			$rowData[$i]['discountid'] = $db->query_result($result, $i, 'discountid');
			$rowData[$i]['title'] = $db->query_result($result, $i, 'discount_title');

		}
		return $rowData;
	}

}

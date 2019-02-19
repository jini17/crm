<?php
error_reporting(E_ALL & ~E_NOTICE);
/*+***********************************************************************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
* *************************************************************************************************************************************/
//ALL FUNCTION ARE PORTED OR CREATED BY SAFUAN@SECONDCRM.COM - 06082015
class Settings_ManageTerritory_Record_Model extends Settings_Vtiger_Record_Model {
	/**
	 * Function to get the Id
	 * @return <Number> Region Id
	 */
	public function getId() {
		return $this->get('tree');
	}
	
	/**
	 * Function to get the Region Name
	 * @return <String>
	 */
	public function getName() {

		$regionid = $this->get('regionid');
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery("SELECT region FROM secondcrm_regiontree WHERE regionid=$regionid", array());
		$regionname = $adb->query_result($result, 0, 'region');
		return $regionname;
	}
	
	public function getChildName() {
		return $this->get('region');
	}

	/**
	 * Function to get module of this record instance
	 * @return <Settings_Webforms_Module_Model> $moduleModel
	 */
	public function getModule() {
		return $this->module;
	}
	
	/**
	 * Function to get the Edit View Url for the Region
	 * @return <String>
	 */
	public function getEditViewUrl() {
		return 'index.php?module=ManageTerritory&parent=Settings&view=DeleteAjax&regiontree='.$this->getId().'&regionid='.$this->getRegionid();
	}

	public function getTerritoryList(){
		$regionlist = array();
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery("SELECT * FROM secondcrm_regiontree", array());
		for($i = 0; $i < $adb->num_rows($result); $i++){
			$regionlist[] = $adb->raw_query_result_rowdata($result, $i);
		}
		return $regionlist;
	}


	/**
	 * Function to get the instance of Regions record model from query result
	 * @param <Object> $result
	 * @param <Number> $rowNo
	 * @return Settings_Regions_Record_Model instance
	 */
	public static function getInstanceFromQResult($result, $rowNo) {
		$db = PearDatabase::getInstance();
		$row = $db->raw_query_result_rowdata($result, $rowNo);
		$region = new self();
		return $region->setData($row);
	}


	public static function getdataInstanceById($regionid, $regiontree) {
		$db = PearDatabase::getInstance();

		$sql = 'SELECT * FROM secondcrm_region_data WHERE regionid = ? AND tree = ? ';
		$params = array($regionid, $regiontree);
		$result = $db->pquery($sql, $params);
		if($db->num_rows($result) > 0) {
			return self::getInstanceFromQResult($result, 0);
		}
		return null;
	}

	/**
	 * Function to get the instance of Base Region model
	 * @return Settings_Regions_Record_Model instance, if exists. Null otherwise
	 */
	public static function getBaseRegion($record) {
		$db = PearDatabase::getInstance();

		 $sql = "SELECT * FROM secondcrm_region_data WHERE depth=0 AND regionid=$record LIMIT 1";
		$params = array();
		$result = $db->pquery($sql, $params);
		if($db->num_rows($result) > 0) {
			return self::getInstanceFromQResult($result, 0);
		}
		return null;
	}

	public function getParentRegionString() {
		return $this->get('parenttree');
	}

	public function getCreateChildUrl() {
		return '?module=ManageTerritory&parent=Settings&view=EditRegion&regiontree='.$this->getId().'&regionid='.$this->getRegionid();
	}

	public function getDeleteActionUrl() {
		return '?module=ManageTerritory&parent=Settings&view=DeleteAjax&regiontree='.$this->getId().'&regionid='.$this->getRegionid();
	}
	public function getPopupWindowUrl() {
		return 'module=ManageTerritory&parent=Settings&view=Popup&regiontree='.$this->getId().'&regionid='.$this->getRegionid();
	}
	public function getChildren() {
		$db = PearDatabase::getInstance();
		if(!$this->children) {
			$parentRegionString = $this->getParentRegionString();
			$currentRegionDepth = $this->getDepth();
			$regionid = $this->getRegionid();
			$sql = 'SELECT * FROM secondcrm_region_data WHERE parenttree LIKE ? AND depth = ? AND regionid = ?';
			$params = array($parentRegionString.'::%', $currentRegionDepth+1, $regionid);
			$result = $db->pquery($sql, $params);
			$noOfRegions = $db->num_rows($result);
			$roles = array();
			for ($i=0; $i<$noOfRegions; ++$i) {
				$role = self::getInstanceFromQResult($result, $i);
				$roles[$role->getId()] = $role;
			}
			$this->children = $roles;
		}
		return $this->children;
	}

	public function getDepth() {
		return $this->get('depth');
	}
	public function getRegionid() {
		return $this->get('regionid');
	}
	public function getparenttree() {
		return $this->get('parenttree');
	}


	public static function getAll($regionid, $baseRegion = false) {
		$db = PearDatabase::getInstance();
		$params = array();

		$sql = "SELECT * FROM secondcrm_region_data WHERE regionid = $regionid ";

		if (!$baseRegion) {
			$sql .= ' AND depth != ?';
			$params[] = 0;
		}
		$sql .= ' ORDER BY parentrole';

		$result = $db->pquery($sql, $params);
		$noOfRegions = $db->num_rows($result);

		$roles = array();
		for ($i=0; $i<$noOfRegions; ++$i) {
			$role = self::getInstanceFromQResult($result, $i);
			$roles[$role->getId()] = $role;
		}
		return $roles;
	}

	public function moveTo($newParentRegion) {
		$currentDepth = $this->getDepth();
		$currentParentRegionString = $this->getParentRegionString();
		//echo "Mark";
		$newDepth = $newParentRegion->getDepth() + 1;
		$newParentRegionString = $newParentRegion->getParentRegionString() .'::'. $this->getId();

		$depthDifference = $newDepth - $currentDepth;
		$allChildren = $this->getAllChildren();

		$this->set('depth', $newDepth);
		$this->set('parenttree', $newParentRegionString);
		$this->save();

		foreach($allChildren as $roleId => $roleModel) {
			$oldChildDepth = $roleModel->getDepth();
			$newChildDepth = $oldChildDepth + $depthDifference;

			$oldChildParentRegionString = $roleModel->getParentRegionString();
			$newChildParentRegionString = str_replace($currentParentRegionString, $newParentRegionString, $oldChildParentRegionString);

			$roleModel->set('depth', $newChildDepth);
			$roleModel->set('parenttree', $newChildParentRegionString);
			$roleModel->save();
		}
	}

	public function getAllChildren() {
		$db = PearDatabase::getInstance();

		$parentRegionString = $this->getParentRegionString();
		$regionid = $this->getRegionid();
		$sql = 'SELECT * FROM secondcrm_region_data WHERE parenttree LIKE ? AND regionid=?';
		$params = array($parentRegionString.'::%', $regionid);
		$result = $db->pquery($sql, $params);
		$noOfRegions = $db->num_rows($result);
		$roles = array();
		for ($i=0; $i<$noOfRegions; ++$i) {
			$role = self::getInstanceFromQResult($result, $i);
			$roles[$role->getId()] = $role;
		}
		return $roles;
	}

	public function delete($transferToRegion) {
		$db = PearDatabase::getInstance();
		$regionid = $this->getRegionid();
		$treeId = $this->getId();
		$transferRegionId = $transferToRegion->getId();


		$db->pquery('DELETE FROM secondcrm_region_data WHERE tree LIKE ? AND regionid=?', array($treeId, $regionid));

		$allChildren = $this->getAllChildren();

		$transferParentRegionSequence = $transferToRegion->getParentRegionString();
		$currentParentRegionSequence = $this->getParentRegionString();

		foreach($allChildren as $treeId => $roleModel) {
			$oldChildParentRegionString = $roleModel->getParentRegionString();
			$newChildParentRegionString = str_replace($currentParentRegionSequence, $transferParentRegionSequence, $oldChildParentRegionString);
			$newChildDepth = count(explode('::', $newChildParentRegionString))-1;
			$roleModel->set('depth', $newChildDepth);
			$roleModel->set('parenttree', $newChildParentRegionString);
			$roleModel->save();
		}
                
                if(is_array($array_users)){
                    require_once('modules/Users/CreateUserPrivilegeFile.php');
                    foreach($array_users as $userid){
                        createUserPrivilegesfile($userid);
                        createUserSharingPrivilegesfile($userid);
                    }
                }
	}

	public function save() {
		$db = PearDatabase::getInstance();
		$treeId = $this->getId();
		$regionid = $this->getRegionid();
		$mode = 'edit';

		if($mode == 'edit') {		
			$sql = 'UPDATE secondcrm_region_data SET region=?, parenttree=?, depth=?, label=? WHERE tree=? AND regionid=?';
			$params = array($this->getChildName(), $this->getParentRegionString(), $this->getDepth(), $this->getChildName(), $treeId, $regionid);
			//echo "<pre>";print_r($params);echo "</pre>";
			$db->pquery($sql, $params);
		} 
	}

	public function getParent() {
		 $regionid = $this->getRegionid();
		if(!$this->parent) {
			$parentRegionString = $this->getParentRegionString();
			$parentComponents = explode('::', $parentRegionString);
			echo " <br>NOF " . $noOfRegions = count($parentComponents);
			// $currentRegion = $parentComponents[$noOfRegions-1];
			if($noOfRegions > 1) {
				$this->parent = self::getdataInstanceById($regionid, $parentComponents[$noOfRegions-2]);
			} else {
				$this->parent = null;
			}
		}
		return $this->parent;
	}

	public function getProfiles() {
		if(!$this->profiles) {
			$this->profiles = Settings_Profiles_Record_Model::getAllByRegion($this->getId());
		}
		return $this->profiles;
	}


	public function saveNewRegion($regionname) {
		$db = PearDatabase::getInstance();
		$regionid = (self::getmaxregionid()) + 1 ;
		$sqlmain = "INSERT INTO secondcrm_regiontree(regionid,region,subregion) VALUES (?,?,1)";
		$paramsmain = array($regionid, $regionname);
		$resultm = $db->pquery($sqlmain, $paramsmain);

		
		$sqlsub = "INSERT INTO secondcrm_region_data(regionid, region, tree, parenttree, depth, label) VALUES (?,?,'T1','T1', 0,?)";
		$paramssub = array($regionid, $regionname, $regionname);
		$results = $db->pquery($sqlsub, $paramssub);

		return $regionid;

	}
	
	//Get last number of region id so that we can create new region id by adding to it.
	public function getmaxregionid() {
		$db = PearDatabase::getInstance();
		$sql ="SELECT MAX(regionid) AS maxnum FROM secondcrm_regiontree";
		$params = array();
		$result = $db->pquery($sql, $params);
		$max =  $db->query_result($result, 0, 'maxnum');

		return $max;

	}

	public function saveSubRegion($subregionname, $regiontree, $regionid){
		$db = PearDatabase::getInstance();
		$currenttree = (self::getmaxsubregionnum($regionid) + 1);
		$tree = "T" . $currenttree;
		 $depth = self::getcurrentparentdepth($regionid, $regiontree)+1;
		 $parenttree = self::getcurrentparenttree($regionid, $regiontree) ."::".$tree;
		$sqlsub = "INSERT INTO secondcrm_region_data(regionid, region, tree, parenttree, depth, label) VALUES (?,?,?,?,?,?)";
		$paramssub = array($regionid, $subregionname,$tree, $parenttree, $depth, $subregionname);
		$results = $db->pquery($sqlsub, $paramssub);

		$updatequery = "UPDATE secondcrm_regiontree SET subregion = $currenttree WHERE regionid=$regionid";
		$db->pquery($updatequery, array());
		return true;
	}
	
	//Fetch the subregion to create new tree
	public function getmaxsubregionnum($regionid) {
		$db = PearDatabase::getInstance();
		$sql ="SELECT subregion FROM secondcrm_regiontree WHERE regionid = ?";
		$params = array($regionid);
		$result = $db->pquery($sql, $params);
		$max =  $db->query_result($result, 0, 'subregion');

		return $max;

	}

	public function getcurrentparentdepth($regionid, $regiontree) {
		$db = PearDatabase::getInstance();
		$sql ="SELECT depth FROM  secondcrm_region_data WHERE regionid = ? AND tree=?";
		$params = array($regionid, $regiontree);
		$result = $db->pquery($sql, $params);
		 $depth =  $db->query_result($result, 0, 'depth');

		return $depth;

	}

	public function getcurrentparenttree($regionid, $regiontree) {
		$db = PearDatabase::getInstance();
		$sql ="SELECT parenttree FROM  secondcrm_region_data WHERE regionid = ? AND tree=?";
		$params = array($regionid, $regiontree);
		$result = $db->pquery($sql, $params);
		$parenttree =  $db->query_result($result, 0, 'parenttree');

		return $parenttree;

	}


	public function deleteRegion($regionid) {
		$db = PearDatabase::getInstance();
		$sql ="DELETE FROM secondcrm_region_data WHERE regionid=?";
		$params = array($regionid);
		$result = $db->pquery($sql, $params);

		$sql2 ="DELETE FROM secondcrm_regiontree WHERE regionid=?";
		$params2 = array($regionid);
		$result2 = $db->pquery($sql2, $params2);


		if(!empty($regionid)){
			return true;
		}else{
			return false;
		}
	}

	public function deleteSubRegion($regiontree, $regionid) {
		$db = PearDatabase::getInstance();
		$sql ="DELETE FROM secondcrm_region_data WHERE regionid=? AND tree=?";
		$params = array($regionid, $regiontree);
		$result = $db->pquery($sql, $params);

		if(!empty($regionid)){
			return true;
		}else{
			return false;
		}
	}

}

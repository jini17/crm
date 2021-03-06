<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/*
 * Settings List View Model Class
 */

class Settings_ManageDiscount_ListView_Model extends Settings_Vtiger_ListView_Model {

	/**
	 * Function to get the list view entries
	 * @param Vtiger_Paging_Model $pagingModel
	 * @return <Array> - Associative array of record id mapped to Vtiger_Record_Model instance.
	 */
	public function getListViewEntries($pagingModel) {
		$db = PearDatabase::getInstance();
		//echo "<pre>ZZZZZZ";echo "</pre>";

		$module = $this->getModule();
		$moduleName = $module->getName();
		$parentModuleName = $module->getParentName();
		$qualifiedModuleName = $moduleName;
		if (!empty($parentModuleName)) {
			$qualifiedModuleName = $parentModuleName . ':' . $qualifiedModuleName;
		}
		$recordModelClass = Vtiger_Loader::getComponentClassName('Model', 'Record', $qualifiedModuleName);
		//$listQuery = $this->getBasicListQuery();
        	//echo "<pre>";echo $listQuery."</pre>";


		$listQuery = "SELECT secondcrm_discount2role.*, secondcrm_discount.discount_title, secondcrm_discount.discount_status FROM secondcrm_discount2role
			INNER JOIN secondcrm_discount ON secondcrm_discount2role.discountid = secondcrm_discount.discountid WHERE secondcrm_discount.deleted=0";


		//$listQuery .= " INNER JOIN secondcrm_discount ON secondcrm_discount.id = secondcrm_discount2role.discountid ";
		$startIndex = $pagingModel->getStartIndex();
		$pageLimit = $pagingModel->getPageLimit();

		$orderBy = $this->getForSql('orderby');
		if (!empty($orderBy) && $orderBy === 'smownerid') { 
			$fieldModel = Vtiger_Field_Model::getInstance('assigned_user_id', $moduleModel); 
			if ($fieldModel->getFieldDataType() == 'owner') { 
				$orderBy = 'COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname)'; 
			} 
		}
		if (!empty($orderBy)) {
			$listQuery .= ' ORDER BY ' . $orderBy . ' ' . $this->getForSql('sortorder');
		}
        if($module->isPagingSupported()) {
            $nextListQuery = $listQuery.' LIMIT '.($startIndex+$pageLimit).',1';
            $listQuery .= " LIMIT $startIndex, $pageLimit";
        }
        	//echo "<pre>";echo $listQuery."</pre>";
		$listResult = $db->pquery($listQuery, array());
		$noOfRecords = $db->num_rows($listResult);
        	//echo "<pre>";echo $noOfRecords."</pre>";
		$listViewRecordModels = array();
		for ($i = 0; $i < $noOfRecords; $i++) {
			$row = $db->query_result_rowdata($listResult, $i);
        		//echo "<pre>";print_r($row);echo "</pre>";
			$record = new $recordModelClass();
			$record->setData($row);

			if (method_exists($record, 'getModule') && method_exists($record, 'setModule')) {
				$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
				$record->setModule($moduleModel);
			}
        	//echo "<pre>";print_r($record);echo "</pre>";
        	//echo "<pre>";echo $record->getId()."</pre>";
			$listViewRecordModels[$record->getId()] = $record;
		}
        if($module->isPagingSupported()) {
            $pagingModel->calculatePageRange($listViewRecordModels);
            
            $nextPageResult = $db->pquery($nextListQuery, array());
            $nextPageNumRows = $db->num_rows($nextPageResult);
            
            if($nextPageNumRows <= 0) {
                $pagingModel->set('nextPageExists', false);
            }
        }
        	//echo "<pre>";print_r($listViewRecordModels);echo "</pre>";
		return $listViewRecordModels;
	}
	

}

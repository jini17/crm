<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Performance_Record_Model extends Settings_Vtiger_Record_Model {
 
    public function getId() {
        return $this->get('performanceid');
    }
    
    public function getName() {
        return $this->get('yearly_review');
    }
    
    
    /**
	 * Function to get the list view actions for the record
	 * @return <Array> - Associate array of Vtiger_Link_Model instances
	 */
	public function getRecordLinks() {
		$currentuser = Users_Record_Model::getCurrentUserModel();
		$links = array();
		if($currentuser->get('is_admin')=='on' || $currentuser->get('hradmin')=='1'){
			$recordLinks = array(
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_EDIT',
					'linkurl' => 'index.php?module=Performance&parent=Settings&view=Edit&record='.$this->getId(),
					'linkicon' => 'icon-pencil'
				),
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_DELETE',
					'linkurl' => "javascript:Settings_Performance_List_Js.triggerDelete('".$this->getDeleteActionUrl()."')",
					'linkicon' => 'icon-trash'
				),
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_VIEW',
					'linkurl' => "javascript:Settings_Performance_List_Js.triggerDetailView(".$this->getId().")",
					'linkicon' => 'icon-eye'
				)
			);
		} else {
			
			$recordLinks = array(
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_VIEW',
					'linkurl' => "javascript:Settings_Performance_List_Js.triggerDetailView(".$this->getId().")",
					'linkicon' => 'icon-eye'
				)
			);	
		}	
		foreach ($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}

		return $links;
	}
    
    public function getDeleteActionUrl() {
        return 'index.php?module=Performance&parent=Settings&action=DeleteAjax&mode=remove&record='.$this->getId();
    }
    
    public function getRowInfo() {
        return $this->getData();
    }
}

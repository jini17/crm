<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_Documents_Record_Model extends Settings_Vtiger_Record_Model {
 
    public function getId() {
        return $this->get('notesid');
    }
    
    public function getName() {
        return $this->get('note_no');
    }
    public function getfile(){
    	$db = PearDatabase::getInstance();
    	$query="SELECT `attachmentsid` FROM `vtiger_seattachmentsrel` WHERE `crmid`=?";
    	$result=$db->pquery($query,array($this->getId()));
    	$fileid=$db->query_result($result, 'attachmentsid');
    	return $fileid;

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
					'linkurl' => 'index.php?module=Documents&parent=Settings&view=Edit&record='.$this->getId(),
					'linkicon' => 'icon-pencil'
				),
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_DELETE',
					'linkurl' => "javascript:Settings_Documents_List_Js.triggerDelete('".$this->getDeleteActionUrl()."')",
					'linkicon' => 'icon-trash'
				),
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_VIEW',
					'linkurl' => "javascript:window.location.href='index.php?module=Documents&action=DownloadFile&record=".$this->getId()."&fileid=".$this->getfile()."'",
					'linkicon' => 'icon-eye'
				)
			);
		} else{
			$recordLinks = array(
				array(
					'linktype' => 'LISTVIEWRECORD',
					'linklabel' => 'LBL_VIEW',
					'linkurl' => "javascript:window.location.href='index.php?module=Documents&action=DownloadFile&record=".$this->getId()."&fileid=".$this->getfile()."'",
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
        return 'index.php?module=Documents&parent=Settings&action=DeleteAjax&mode=remove&record='.$this->getId();
    }
   
    
    public function getRowInfo() {
        return $this->getData();
    }
}

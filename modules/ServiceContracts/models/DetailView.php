<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ServiceContracts_DetailView_Model extends Vtiger_DetailView_Model {

	/**
	 * Function to get the detail view links (links and widgets)
	 * @param <array> $linkParams - parameters which will be used to calicaulate the params
	 * @return <array> - array of link models in the format as below
	 *                   array('linktype'=>list of link models);
	 * added by jitu@04082015
	 */
	public function getDetailViewLinks($linkParams) {
		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();

		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();
	
		//Added by jitu@27-04-2015 for ShowHide Restrict Issue 
		$srRestrict = Vtiger_Record_Model::toggleRestrictAction('ServiceContracts','CSR', $recordModel->getId());
		//end here

		$helpdeskModuleModel = Vtiger_Module_Model::getInstance('HelpDesk');
		
		if($currentUserModel->hasModuleActionPermission($helpdeskModuleModel->getId(), 'EditView') && ! $srRestrict) {
			$basicActionLink = array(
				'linktype' => 'DETAILVIEW',
				'linklabel' => vtranslate('LBL_CREATE').' '.vtranslate($helpdeskModuleModel->getSingularLabelKey(), 'HelpDesk'),
				'linkurl' => 'index.php?module=HelpDesk&view=Edit&servicecontractsid='.$recordModel->getId(),
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		}
		
		return $linkModelList;


	}
		
}

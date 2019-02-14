<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Inventory_DetailView_Model extends Vtiger_DetailView_Model {

	/**
	 * Function to get the detail view links (links and widgets)
	 * @param <array> $linkParams - parameters which will be used to calicaulate the params
	 * @return <array> - array of link models in the format as below
	 *					 array('linktype'=>list of link models);
	 */
	public function getDetailViewLinks($linkParams) {
		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();
		$moduleName = $recordModel->getmoduleName();

		if(Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordModel->getId())) {

			if($moduleName=='Invoice' || $moduleName =='Quotes'){

				$detailViewLinks = array(
						'linklabel' => vtranslate('LBL_EXPORT_TO_PDF', $moduleName),
						'linkurl' => $recordModel->getExportPDFURL(),
						'linkicon' => ''
							);
				$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($detailViewLinks);

				$sendEmailLink = array(
	                'linklabel' => vtranslate('LBL_SEND_MAIL_PDF', $moduleName),
	                'linkurl' => 'javascript:Inventory_Detail_Js.sendEmailPDFClickHandler(\''.$recordModel->getSendEmailPDFUrl().'\')',
	                'linkicon' => ''
	            );
	        }    

            //$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($sendEmailLink);

            //Editied by jitu@27-04-2015 for ShowHide Restrict Issue 
			if($moduleName == 'Quotes') {
				$actioncode = 'SQE';
			} else if($moduleName == 'SalesOrder') {
				$actioncode = 'SSE';
			} else if($moduleName == 'Invoice') {
				$actioncode = 'SIE';
			} 
			
			$emailRestrict = Vtiger_Record_Model::toggleRestrictAction($moduleName,$actioncode, $recordModel->getId());		//End here 
          
            $sendEmailLink = array( 
                'linklabel' => vtranslate('LBL_SEND_MAIL_PDF', $moduleName), 
                'linkurl' => 'javascript:Inventory_Detail_Js.sendEmailPDFClickHandler(\''.$recordModel->getSendEmailPDFUrl().'\')', 
                'linkicon' => '' 
            ); 

			//Editied by jitu@27-04-2015 for ShowHide Restrict Issue 
			//if($emailRestrict) {
              //  $linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($sendEmailLink); 	}
			//End here
			
			//Show / Hide Edit Button in detailView
			$modules = array("Invoice"=>"IOR","PurchaseOrder"=>"POR","SalesOrder"=>"SOR", "Quotes"=>"QOR", "DeliveryOrder"=>"DOR");
			$editrestrict = Vtiger_Record_Model::toggleRestrictAction($moduleName,$modules[$moduleName],$recordModel->getId());	
			if($editrestrict)
				unset($linkModelList['DETAILVIEWBASIC'][0]);
			//End here 

		}

		return $linkModelList;
	}

}

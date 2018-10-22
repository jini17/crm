<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk
 *************************************************************************************/

class EmployeeContract_RelatedList_View extends Vtiger_RelatedList_View {

	function process(Vtiger_Request $request) {
		$moduleName 		= $request->getModule();
		$relatedModuleName 	= $request->get('relatedModule');
		$parentId 			= $request->get('record');
		$label 				= $request->get('tab_label'); 
		$currYear			= date('Y');

		$relatedModuleModel = Vtiger_Module_Model::getInstance($relatedModuleName);
		$moduleFields 		= $relatedModuleModel->getFields();

     	$requestedPage 		= $request->get('page');
		if(empty($requestedPage)) {
			$requestedPage = 1;
		}

		$pagingModel 		= new Vtiger_Paging_Model();
		$pagingModel->set('page',$requestedPage);

		$parentRecordModel  = Vtiger_Record_Model::getInstanceById($parentId, $moduleName);
		$relationListView 	= Vtiger_RelationListView_Model::getInstance($parentRecordModel, $relatedModuleName, $label);
        
        
		$relationListView->tab_label 	= $request->get('tab_label');
		$models 						= $relationListView->getEntries($pagingModel);
		$links 							= $relationListView->getLinks();
		$header 						= $relationListView->getHeaders();
		$noOfEntries 					= $pagingModel->get('_relatedlistcount');

		if(!$noOfEntries) {

			$noOfEntries = count($models);

		}

		$relationModel 		= $relationListView->getRelationModel();
		$relatedModuleModel = $relationModel->getRelationModuleModel();
		$relationField 		= $relationModel->getRelationField();
        
       	$viewer 	= $this->getViewer($request);

		$claims 	= Users_ClaimRecords_Model::getClaimForEmployeeContract($parentId, $currYear); 
		$leaves 	= Users_LeavesRecords_Model::getWidgetsMyLeaves($parentRecordModel->get('employee_id'), $currYear, 'leavetype');
		$benefits 	= Vtiger_Module_Model::getRelatedBenefits($parentRecordModel->get('employee_id'), $currYear); 
	
		$viewer->assign('CLAIMDETAILS', $claims);
		$viewer->assign('LEAVEDETAILS', $leaves);
		$viewer->assign('BENEFITDETAILS', $benefits);
		$viewer->assign('TAB_LABEL', $request->get('tab_label'));
        return $viewer->view('RelatedList.tpl', $moduleName, 'true');

	}
}

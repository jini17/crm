<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class MessageBoard_Detail_View extends Vtiger_Detail_View {

		
	public function preProcess(Vtiger_Request $request) {
	
		
	
		$recordId 		= $request->get('record');
		$moduleName 	= $request->getModule();
		$mBViewModel	= Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
		$mBrecordModel	= $mBViewModel->getRecord();
		$mBrecordModel->get('employee_id');
		$detailViewModel = Vtiger_DetailView_Model::getInstance('Users', $mBrecordModel->get('employee_id'));
		$recordModel = $detailViewModel->getRecord();
		$imageDetails = $recordModel->getImageDetails();

		$viewer = $this->getViewer($request);
		$imagepath = $imageDetails[0]['path'].'_'.$imageDetails[0]['orgname'];
		
		if(!file_exists($imagepath)){
			$imagepath = 'layouts/fask/skins/images/DefaultUserIcon.png';
		}
		$viewer->assign('IMAGEPATH', $imagepath);
		
		parent::preProcess($request, true);
	}	
}	
?>

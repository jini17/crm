<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Holiday_HolidayList_Dashboard extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);

		$moduleName = $request->getModule();
		 $type = $request->get('type');
                                                if(empty($type)){
                                                    $type = 'today';
                                                }
                                       
		$monthname = $request->get('month');

		if($monthname == '' || $monthname == null) {
				$monthname = null;
		}

		$holidaymodel = Users_LeavesRecords_Model::getHolidayList(null,$type);
         			
		$page = $request->get('page');
		$linkId = $request->get('linkid');
		
		$widget = Vtiger_Widget_Model::getInstance($linkId, $currentUser->getId());
		$viewer->assign('WIDGET', $widget);
		$viewer->assign('TYPE', $type);
		$viewer->assign('TYPELABEL', $typeLabel);
		
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('MODELS', $holidaymodel);
		$content = $request->get('content');
     

		if(!empty($content)) {
			$viewer->view('dashboards/HolidayContents.tpl', $moduleName);
		} else {
			$viewer->view('dashboards/Holiday.tpl', $moduleName);
		}
	}
}

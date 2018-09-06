<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
// ADDED BY SAFUAN@SECONDCRM.COM- #dashreportchart
class Reports_ReportChart_Dashboard extends Reports_ChartDetail_View {

	public function process(Vtiger_Request $request, $widget=NULL) { 
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();

		$widgetId = $request->get('widgetid');


		$record = self::getreportid($widgetId);
		$reportModel = Reports_Record_Model::getInstanceById($record);
		$reportChartModel = Reports_Chart_Model::getInstanceById($reportModel);
		$widget = Vtiger_Widget_Model::getInstanceWithWidgetId($widgetId, $currentUser->getId());

        $data = $reportChartModel->getData();

		$viewer->assign('DATA', json_encode($data, JSON_HEX_APOS));
		$viewer->assign('CHART_TYPE', $reportChartModel->getChartType());

		$viewer->assign('CLICK_THROUGH', true);

		$viewer->assign('WIDGET', $widget);
		$viewer->assign('MODULE_NAME', $moduleName);




		$content = $request->get('content');
		if(!empty($content)) {
			$viewer->view('dashboards/ReportChartContents.tpl', $moduleName);
		} else {
			$widget->set('title', $data['graph_label']);

			$viewer->view('dashboards/ReportChart.tpl', $moduleName);
		}

	}


	public function getreportid($widgetid) {
		$db = PearDatabase::getInstance();
		$result = $db->pquery("SELECT * FROM vtiger_module_dashboard_widgets WHERE linkid =119 AND id=?", array($widgetid));
		$reportid = $db->query_result($result, 0,'reportid');
		return $reportid;
	}

}

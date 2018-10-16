<?php
//ADDED BY SAFUAN@SECONDCRM.COM- #dashreportchart
class Reports_BringtoDash_Action extends Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		
		$db = PearDatabase::getInstance();
		$userid = $_SESSION['AUTHUSERID'];
		$record = $request->get('record');
		$tabid	= $request->get('dashboardtab');
		$result = $db->pquery("INSERT INTO vtiger_module_dashboard_widgets(linkid, userid, reportid, dashboardtabid) VALUES (119, ?, ?,?) ", array($userid, $record, $tabid));
	}

}
?>

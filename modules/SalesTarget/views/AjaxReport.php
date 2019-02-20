<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class SalesTarget_AjaxReport_View extends Vtiger_Index_View {

	
	public function process(Vtiger_Request $request) {
	
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
		$targetid = $request->get('targetid');
		$groupby = $request->get('groupby');

		$headercolumns = array();
		$duplicateheader = array();
		if($groupby == 'Territory') {
			array_push($headercolumns,"UserGroup");
			array_push($headercolumns,"Product");
			
		} else if($groupby == 'UserGroup') {
			array_push($headercolumns,"Territory");
			array_push($headercolumns,"Product");
		} else {
			array_push($headercolumns,"Territory");
			array_push($headercolumns,"UserGroup");	
		}
		$result = SalesTarget_Record_Model::getSalesTargetDetail($targetid);
		$jq = 1;
		$startmonth = $result[0];
		if($request->get('monthly') !='') {
			$cond['m'] = $request->get('monthly');
			for($i=1;$i<=12;$i++) {
				$month = date('M', strtotime($startmonth));
				array_push($headercolumns,$month);	
				if($i%3==0 && $request->get('quaterly') !='') {
				  $cond['q'] = $request->get('quaterly');
				  array_push($headercolumns,'Q'.$jq);	
				  $jq++;	
				}
				$startmonth = date('M',strtotime("+1 month", strtotime($month)));
			}
			
		} 
		if($request->get('quaterly') !='' && $request->get('monthly') =='') {
			$cond['q'] = $request->get('quaterly');
			array_push($headercolumns,'Q1');
			array_push($headercolumns,'Q2');
			array_push($headercolumns,'Q3');
			array_push($headercolumns,'Q4');	
		}

		if($request->get('annually') !='') {	
			for($i=1;$i<=12;$i++) {
				$month = date('M', strtotime($startmonth));
				array_push($duplicateheader,$month);	
				$startmonth = date('M',strtotime("+1 month", strtotime($month)));
			}
			 $cond['a'] = $request->get('annually');
			 array_push($headercolumns, 'Annual');
		}
			
			
		$viewer = $this->getViewer($request);
		$reports = SalesTarget_Record_Model::viewSalesReport($targetid,$headercolumns,$groupby,$result[1],$cond,$duplicateheader);

		$viewer->assign('MODULE', $moduleName);	
		$viewer->assign('HEADERCOL', $headercolumns);
		$viewer->assign('RESULT_REPORTS',$reports );

		echo $viewer->view('Table1.tpl', 'SalesTarget',true);
		
	}
}

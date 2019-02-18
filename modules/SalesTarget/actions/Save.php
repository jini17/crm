<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class SalesTarget_Save_Action extends Vtiger_Save_Action {

	public function process(Vtiger_Request $request) {
		//Make string to Multiple Territory that input as array

		if(!is_array($request->get('targetterritory'))) {
			$territory = $request->get('targetterritory');
		} else {
			$territory = implode(',',$request->get('targetterritory'));
		}
		
		$request->set('targetterritory', $territory);
		
		//Temporary code for testing after testing remove it. 
		$products = $request->get('linktoproduct');	
		if(!empty($products)) {	
			 $products = implode(',',$products);
		} 
		$request->set('linktoproduct', $products);	
		if($request->get('assigntype') == 'U') {
			
			$assignlist =$request->get('assigneduserid');
		} else {
			$assignlist =$request->get('assignedgroupid');
		}
		if(!is_array($assignlist)) {
			$assignlist = $assignlist;
		} else {
			$assignlist = implode(',',$assignlist);
		}
	
		$request->set('targetuser', $assignlist);

		$sourcemodule = $request->get('sourcemodule');
		//added by jitu@secondcrm.com for extra date column 
		$datecolumn = $request->get('datecolumn');

		$fldname  = $request->get('fldname');
		$fldvalue = $request->get($fldname);
		
		$request->set($fldname, $sourcemodule.','.$fldvalue.','.$datecolumn);
		
		parent::process($request);


		
	}
}

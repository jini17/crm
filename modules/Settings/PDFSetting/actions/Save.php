<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_PDFSetting_Save_Action extends Settings_Vtiger_Index_Action {

	public function process(Vtiger_Request $request) {

		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$displaymodul = $request->get('displaymodul');
		$repeatheader = $request->get('repeatheader') == '' ? 0 : 1;
		$showlogo = $request->get('showlogo') == '' ? 0 : 1;
		$showorgaddress = $request->get('showorgaddress') == '' ? 0 : 1;
		$showsummary = $request->get('showsummary') == '' ? 0 : 1;
		$headerdate = $request->get('headerdate');
		$showperson_name = $request->get('showperson_name') == '' ? 0 : 1;
		$showphone = $request->get('showphone') == '' ? 0 : 1;
		$emptyline = $request->get('emptyline');
		$showfooter = $request->get('showfooter') == '' ? 0 : 1;
		$repeatfooter = $request->get('repeatfooter') == '' ? 0 : 1;
		$customfooter = addslashes($request->get('customfooter'));
		$showshipping = $request->get('showshipping') == '' ? 0 : 1;
		$shippinglabel = $request->get('shippinglabel');
		$showpager = $request->get('showpager') == '' ? 0 : 1;
		$fontfamily = $request->get('fontfamily');
		$showgroupno = $request->get('showgroupno') == '' ? 0 : 1;
		$showgrouporder = $request->get('showgrouporder') == '' ? 0 : 1;
		$showgroupdesc = 1;
		$showgroupsqm = $request->get('showgroupsqm') == '' ? 0 : 1;
		$showgroupunit = $request->get('showgroupunit') == '' ? 0 : 1;
		$showgpricesqm = $request->get('showgpricesqm') == '' ? 0 : 1;
		$showgroupdiscount = $request->get('showgroupdiscount') == '' ? 0 : 1;
		$showgroupamount = $request->get('showgroupamount') == '' ? 0 : 1;
		$showindno = $request->get('showindno') == '' ? 0 : 1;
		$showindorder = $request->get('showindorder') == '' ? 0 : 1;
		$showinddesc = 1;	
		$showindsqm = $request->get('showindsqm') == '' ? 0 : 1;
		$showindunit = $request->get('showindunit') == '' ? 0 : 1;
		$showindpricesqm = $request->get('showindpricesqm') == '' ? 0 : 1;
		$showinddiscount = $request->get('showinddiscount') == '' ? 0 : 1;
		$showindgst = $request->get('showindgst') == '' ? 0 : 1;
		$showindamount = $request->get('showindamount') == '' ? 0 : 1;
		
		$showlineitemdiscountdetails = $request->get('showlineitemdiscountdetails') == '' ? 0 : 1;
		$showoveralldiscountdetails = $request->get('showoveralldiscountdetails') == '' ? 0 : 1;
		
		$paymentRef = $request->get('paymentRef') == '' ? 0 : 1;
		$paymentAmmount = $request->get('paymentAmmount') == '' ? 0 : 1;
		$paymentFor = $request->get('paymentFor') == '' ? 0 : 1;
		$paymentRefNo = $request->get('paymentRefNo') == '' ? 0 : 1;
		$paymentMode = $request->get('paymentMode') == '' ? 0 : 1;
		$paymentBankName = $request->get('paymentBankName') == '' ? 0 : 1;
		$paymentBankAccount = $request->get('paymentBankAccount') == '' ? 0 : 1;

		$result = Settings_PDFSetting_Record_Model::save($displaymodul,$repeatheader,$showlogo,$showorgaddress,$showsummary, $headerdate,$showperson_name,$showphone,$emptyline,$showfooter,$repeatfooter,$customfooter,$showshipping,$shippinglabel, $showpager,$fontfamily,$showgroupno,$showgrouporder,$showgroupdesc,$showgroupsqm,$showgroupunit,$showgpricesqm,$showgroupdiscount,$showgroupamount,$showindno,$showindorder,$showinddesc,$showindsqm,$showindunit,$showindpricesqm,$showinddiscount,$showindgst,$showindamount,$paymentRef,$paymentAmmount,$paymentFor,$paymentRefNo,$paymentMode,$paymentBankName,$paymentBankAccount,$showlineitemdiscountdetails,$showoveralldiscountdetails);


		$responce = new Vtiger_Response();
       		$responce->setResult(array('success'=>true));
       		$responce->emit();
	}
}

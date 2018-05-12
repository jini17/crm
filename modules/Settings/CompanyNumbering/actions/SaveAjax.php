<?php

/* ===================================================================
Created By: Muhammad Afiq Bin Azmi, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 14 / 07 / 2014
Change Reason: Multiple Email Details Feature, File modified
=================================================================== */

/*********************************************************************************
** The contents of this file are subject to the SecondCRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is SecondCRM.
 * Portions created by SecondCRM are Copyright (C) SecondCRM.
 * All Rights Reserved.
* 
 ********************************************************************************/
class Settings_CompanyNumbering_SaveAjax_Action extends Settings_Vtiger_Index_Action {

	private $business; 
		
	function __construct() {
		$this->exposeMethod('saveCompanyNumberingSetting');
    	}	

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		$this->invokeExposedMethod($mode, $request);
	}
    
	public function saveCompanyNumberingSetting(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
		$business = $request->get('business');
			
		//update business in companynumbering  	
		$sSql = "UPDATE  secondcrm_companynumbering SET  business =?";
		$result= $db->pquery($sSql, array($business));		

		if($business == 1)
		{
			$sqlPre = "select * from vtiger_modentity_num where organization_id != 1 AND semodule IN ('Quotes','SalesOrder','PurchaseOrder','Invoice','Payments')";
			$resultPre = $db->pquery($sqlPre, array());
			$iNumRow = $db->num_rows($resultPre);
		
			if($iNumRow == 0 )
			{
				$sql = "select organization_id from vtiger_organizationdetails where organization_id != 1";
				$result = $db->pquery($sql, array());
		
				$aCompanyList = array();
				$iOptionIndex = 0;
				$iMaxCompany = $db->num_rows($result);
		
				for($iK=0;$iK<$iMaxCompany;$iK++)
				{
					$iOptionIndex++;
					$aCompanyList[$iOptionIndex]['id'] = $db->query_result($result,$iK,'organization_id');
				}

				$sql2 = "SELECT semodule,prefix FROM vtiger_modentity_num WHERE organization_id = 1 AND active = 1 AND semodule IN ('Quotes','SalesOrder','PurchaseOrder','Invoice','Payments')";
				$result2 = $db->pquery($sql2, array());
		
				$aNumberingList = array();
				$iOptionIndex = 0;
				$iMaxNumbering = $db->num_rows($result2);
		
				for($iK=0;$iK<$iMaxNumbering;$iK++)
				{
					$iOptionIndex++;
					$aNumberingList[$iOptionIndex]['semodule'] = $db->query_result($result2,$iK,'semodule');
					$aNumberingList[$iOptionIndex]['prefix'] = $db->query_result($result2,$iK,'prefix');

				}
				$rs_numseq = $db->pquery("SELECT id FROM vtiger_modentity_num_seq",array());
				$num_id = $db->query_result($rs_numseq,0,'id');

				for($iK=1;$iK<=$iMaxCompany;$iK++)
				{
					for($iL=1;$iL<=$iMaxNumbering;$iL++)
					{
						$semodule = $aNumberingList[$iL]['semodule'];
						$id = $aCompanyList[$iK]['id'];
						$prefix = $aNumberingList[$iL]['prefix'].$id;
						$num_id++;
						$sql3 = "INSERT INTO vtiger_modentity_num (num_id,semodule , prefix, start_id, cur_id, active, organization_id) 
							VALUES ($num_id,'".$semodule."','".$prefix."',1,1,1,$id) ";
						$result3 = $db->pquery($sql3, array());
						$updaters_numid = $db->pquery("UPDATE vtiger_modentity_num_seq SET id =?",array($num_id));
					 }
				}
		
			}
		
		
		}
		else
		{	
			$sSql = "UPDATE  secondcrm_companynumbering SET  business =  0 ";
			$result= $db->pquery($sSql, array());
		
			$sqlDel = "DELETE FROM vtiger_modentity_num WHERE organization_id != 1";
			$result= $db->pquery($sqlDel, array());
			
			$rsMaxnum = $db->pquery("SELECT max(num_id) AS num_id FROM vtiger_modentity_num",array());
			$num_id = $db->query_result($rsMaxnum,0,'num_id');
			$updaters_numid = $db->pquery("UPDATE vtiger_modentity_num_seq SET id =?",array($num_id));
			
		}
		$response = new Vtiger_Response();
		$response->setResult(array('success',true));
		$response->emit();
	}
}
?>

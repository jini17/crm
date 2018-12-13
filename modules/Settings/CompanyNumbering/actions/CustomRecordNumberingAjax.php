<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_CompanyNumbering_CustomRecordNumberingAjax_Action extends Settings_Vtiger_Index_Action {

	public function __construct() {
		parent::__construct();
		$this->exposeMethod('getModuleCustomNumberingData');
		$this->exposeMethod('saveModuleCustomNumberingData');
		$this->exposeMethod('updateRecordsWithSequenceNumber');
	}

	public function checkPermission(Vtiger_Request $request) {
		parent::checkPermission($request);
		$qualifiedModuleName = $request->getModule(false);
		$sourceModule = $request->get('sourceModule');

		if(!$sourceModule) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $qualifiedModuleName));
		}
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if(!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
	}

	/**
	 * Function to get Module custom numbering data
	 * @param Vtiger_Request $request
	 */
	public function getModuleCustomNumberingData(Vtiger_Request $request) {
		$company      = $request->get('company');	
		$sourceModule = $request->get('sourceModule');
		
		$moduleModel = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getInstance($sourceModule);
		$moduleData = $moduleModel->getModuleCustomNumberingData($company);
		
		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($moduleData);
		$response->emit();
	}

	/**
	 * Function save module custom numbering data
	 * @param Vtiger_Request $request
	 */
	public function saveModuleCustomNumberingData(Vtiger_Request $request) {
		$qualifiedModuleName = $request->getModule(false);
		$sourceModule = $request->get('sourceModule');
		$company      = $request->get('company');

		$moduleModel = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getInstance($sourceModule);
		$moduleModel->set('prefix', $request->get('prefix'));
		$moduleModel->set('sequenceNumber', $request->get('sequenceNumber'));

		$result = $moduleModel->setModuleSequence($company);

		// COMPANY NUMBERING ADDED BY Mabruk
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
		// END

		$response = new Vtiger_Response();
		if ($result['success']) {
			$response->setResult(vtranslate('LBL_SUCCESSFULLY_UPDATED', $qualifiedModuleName));
		} else {
			$message = vtranslate('LBL_PREFIX_IN_USE', $qualifiedModuleName);
			$response->setError($message);
		}
		$response->emit();
	}

	/**
	 * Function to update record with sequence number
	 * @param Vtiger_Request $request
	 */
	public function updateRecordsWithSequenceNumber(Vtiger_Request $request) {
		$company = $request->get('company');	
		$sourceModule = $request->get('sourceModule');

		$moduleModel = Settings_CompanyNumbering_CustomRecordNumberingModule_Model::getInstance($sourceModule);
		$result = $moduleModel->updateRecordsWithSequence($company);

		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            $request->validateWriteAccess(); 
        }
}

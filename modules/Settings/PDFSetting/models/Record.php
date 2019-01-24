<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

require_once 'include/events/include.inc';

/**
 * Roles Record Model Class
 */
class Settings_PDFSetting_Record_Model extends Settings_Vtiger_Record_Model {

	/**
	 * Function to get the Id
	 * @return <Number> Id
	 */
	public function getId() {
		return $this->get('id');
	}

	/**
	 * Function to set the Id
	 * @param <Number> Group Id
	 * @return <Settings_PDFSetting_Reord_Model> instance
	 */
	public function setId($id) {
		return $this->set('id', $id);
	}

	/**
	 * Function to get the PDFSetting By module
	 * @return <String>
	 */
	public function getName() {
		return $this->get('module');
	}

	
	/**
	 * Function to get the Edit View Url for the PDFSetting
	 * @return <String>
	 */
	public function getEditViewUrl() {
		return '?module=PDFSetting&parent=Settings&view=Edit&record='.$this->getId();
	}

	   
    	/**
	 * Function to get the Detail Url for the current PDFSetting
	 * @return <String>
	 */
    	public function getDetailViewUrl() {
        	return '?module=PDFSetting&parent=Settings&view=Detail&record='.$this->getId();
    	}

	/**
	 * Function to save the PDFSetting
	 */

	public function save($displaymodul,$repeatheader,$showlogo,$showorgaddress,$showsummary, $headerdate,$showperson_name,$showphone,$emptyline,$showfooter,$repeatfooter,$customfooter,$showshipping,$shippinglabel, $showpager,$fontfamily,$showgroupno,$showgrouporder,$showgroupdesc,$showgroupsqm,$showgroupunit,$showgpricesqm,$showgroupdiscount,$showgroupamount,$showindno,$showindorder,$showinddesc,$showindsqm,$showindunit,$showindpricesqm,$showinddiscount,$showindgst,$showindamount,$paymentRef,$paymentAmmount,$paymentFor,$paymentRefNo,$paymentMode,$paymentBankName,$paymentBankAccount,$showlineitemdiscountdetails,$showoveralldiscountdetails) {
		$db = PearDatabase::getInstance();
		$sql = "UPDATE secondcrm_pdfsettings SET showlogo=?, repeatheader=?, showorgaddress=?, showsummary=?,  headerdate=?, showperson_name=?, showphone=?, emptyline=?, showfooter=?, repeatfooter=?, customfooter=?,showshipping=?, shippinglabel=?, showpager=?, fontfamily=?, showgroupNo=?, showgrouporder=?, showgroupdesc=?, showgroupsqm=?, showgroupunit=?, showgpricesqm=?, showgroupdiscount=?, showgroupamount=?, showindno=?, showindorder=?, showinddesc=?, 	showindsqm=?, showindunit=?, showindpricesqm =?, showinddiscount=?, showindgst=?, showindamount=?, paymentRef=?, paymentAmmount=?, paymentFor=?, paymentRefNo=?, paymentMode=?, paymentBankName=?, paymentBankAccount=?,   showlineitemdiscountdetails=?, showoveralldiscountdetails=? WHERE module=?";

		$params = array($showlogo,$repeatheader,$showorgaddress,$showsummary, $headerdate,$showperson_name,$showphone,$emptyline,$showfooter,$repeatfooter,$customfooter,$showshipping,$shippinglabel,$showpager,$fontfamily,$showgroupno,$showgrouporder,$showgroupdesc,$showgroupsqm,$showgroupunit,$showgpricesqm,$showgroupdiscount,$showgroupamount,$showindno,$showindorder,$showinddesc,$showindsqm,$showindunit,$showindpricesqm,$showinddiscount,$showindgst,$showindamount,$paymentRef,$paymentAmmount,$paymentFor,$paymentRefNo,$paymentMode,$paymentBankName,$paymentBankAccount,$showlineitemdiscountdetails,$showoveralldiscountdetails, $displaymodul);

		$result = $db->pquery($sql, $params);

	}

	/**
	 * Function to get the list view actions for the record
	 * @return <Array> - Associate array of Vtiger_Link_Model instances
	 */
	public function getRecordLinks() {

		$links = array();
		$recordLinks = array(
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_EDIT_RECORD',
				'linkurl' => $this->getEditViewUrl(),
				'linkicon' => 'icon-pencil'
			),
			array(
				'linktype' => 'LISTVIEWRECORD',
				'linklabel' => 'LBL_DELETE_RECORD',
				'linkurl' => "javascript:Settings_Vtiger_List_Js.triggerDelete(event,'".$this->getDeleteActionUrl()."')",
				'linkicon' => 'icon-trash'
			)
		);
		foreach ($recordLinks as $recordLink) {
			$links[] = Vtiger_Link_Model::getInstanceFromValues($recordLink);
		}

		return $links;
	}

	/**
	 * Function to get the instance of PDFSetting record model from query result
	 * @param <Object> $result
	 * @param <Number> $rowNo
	 * @return Settings_PDFSetting_Record_Model instance
	 */
	public static function getInstanceFromQResult($result, $rowNo) {
		$db = PearDatabase::getInstance();
		$row = $db->query_result_rowdata($result, $rowNo);
		$role = new self();
		return $role->setData($row);
	}

	
	/**
	 * Function to get the instance of PDFSetting model, given id or module name
	 * @param <Object> $value
	 * @return Settings_PDFSetting_Record_Model instance, if exists. Null otherwise
	 */
	public static function getPDFSettings($value) {
		$db = PearDatabase::getInstance();

		$sql = 'SELECT * FROM secondcrm_pdfsettings WHERE module = ?';
		
		$params = array($value);
		$retrows = array();
		$result = $db->pquery($sql, $params);
		if ($db->num_rows($result) > 0) {
			while ($temprow = $db->fetch_array($result)) {
				 	$rows = $temprow;		
			}
			foreach($rows as $key=>$row) {
				$retrows[$key] = stripslashes($row);
			}
			return $retrows;
		}
		
		return null;
	}
}

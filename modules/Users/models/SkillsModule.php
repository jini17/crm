<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Users_SkillsModule_Model extends Vtiger_Base_Model{
    
    const tableLangName    = 'secondcrm_softskill';
    const tableSkillName   = 'secondcrm_skills';

    public function getCreateLanguageUrl() {
	return '?module=Users&view=Editfile&mode=EditLanguage';
    }
 	
    public function getCreateSkillUrl() {
	return '?module=Users&view=Editfile&mode=EditSkill';
    }	
    public static function getLangInstance($id=null) {
        $db = PearDatabase::getInstance();
	$LangRecordModel=array();
	$query = 'SELECT * FROM '.self::tableLangName.' WHERE ss_id=?';
        $result = $db->pquery($query,array($id));
        $LangRecordModel = new self();
        if($db->num_rows($result) > 0) {
            $row = $db->query_result_rowdata($result,0);
            $LangRecordModel->setData($row)->setType();
        }
        return $LangRecordModel;
    }

    public static function getSkillInstance($id=null) {
        $db = PearDatabase::getInstance();
        $SkillRecordModel=array();
        $query = 'SELECT * FROM '.self::tableSkillName.' WHERE skill_id=?';
        $result = $db->pquery($query,array($id));
        $SkillRecordModel = new self();
        
        if($db->num_rows($result) > 0) {
            $row = $db->query_result_rowdata($result,0);
            $SkillRecordModel->setData($row)->setType();
        }
        return $SkillRecordModel;
    }
}

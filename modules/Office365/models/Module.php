<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
class Office365_Module_Model extends Vtiger_Module_Model {
    
    public static function removeSync($module, $id) {
        $db = PearDatabase::getInstance();
        $query = "DELETE FROM vtiger_office365_oauth WHERE service = ? AND userid = ?";
        $db->pquery($query, array($module, $id));
    }
    
    /**
     * Function to delete office365 synchronization completely. Deletes all mapping information stored.
     * @param <string> $module - Module Name
     * @param <integer> $user - User Id
     */
    public function deleteSync($module, $user) {
        $module = str_replace("Office365", '', $module);
        if($module == 'Contacts' || $module == 'Calendar') {
            $name = 'Vtiger_Office365'.$module;
        }
        else {
            return;
        }
        $db = PearDatabase::getInstance();
        $db->pquery("DELETE FROM vtiger_office365_oauth2 WHERE service = ? AND userid = ?", array('Office365'.$module, $user));
        $db->pquery("DELETE FROM vtiger_office365_sync WHERE office365module = ? AND user = ?", array($module, $user));
        
        $result = $db->pquery("SELECT stateencodedvalues FROM vtiger_wsapp_sync_state WHERE name = ? AND userid = ?", array($name, $user));
        $stateValuesJson = $db->query_result($result, 0, 'stateencodedvalues');
        $stateValues = Zend_Json::decode(decode_html($stateValuesJson));
        $appKey = $stateValues['synctrackerid'];
        
        $result = $db->pquery("SELECT appid FROM vtiger_wsapp WHERE appkey = ?", array($appKey));
        $appId = $db->query_result($result, 0, 'appid');
        
        $db->pquery("DELETE FROM vtiger_wsapp_recordmapping WHERE appid = ?", array($appId));
        $db->pquery("DELETE FROM vtiger_wsapp WHERE appid = ?", array($appId));
        $db->pquery("DELETE FROM vtiger_wsapp_sync_state WHERE name = ? AND userid = ?", array($name, $user));
        $db->pquery("DELETE FROM vtiger_office365_sync_settings WHERE user = ? AND module = ?", array($user,$module));
        if($module == 'Contacts') {
            $db->pquery("DELETE FROM vtiger_office365_sync_fieldmapping WHERE user = ?", array($user));
        } elseif($module == 'Calendar') {
            $db->pquery("DELETE FROM vtiger_office365_event_calendar_mapping WHERE user_id = ?", array($user));
        }
        Google_Utils_Helper::errorLog();
        
        return;
    }
    
    /*
     * Function to get supported utility actions for a module
     */
    function getUtilityActionsNames() {
        return array();
    }
}

?>
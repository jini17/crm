<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'modules/Vtiger/CRMEntity.php';

class EmployeeContract extends Vtiger_CRMEntity {
        var $table_name = 'vtiger_employeecontract';
        var $table_index= 'employeecontractid';

        /**
         * Mandatory table for supporting custom fields.
         */
        var $customFieldTable = Array('vtiger_employeecontractcf', 'employeecontractid');

        /**
         * Mandatory for Saving, Include tables related to this module.
         */
        var $tab_name = Array('vtiger_crmentity', 'vtiger_employeecontract', 'vtiger_employeecontractcf');

        /**
         * Mandatory for Saving, Include tablename and tablekey columnname here.
         */
        var $tab_name_index = Array(
                'vtiger_crmentity' => 'crmid',
                'vtiger_employeecontract' => 'employeecontractid',
                'vtiger_employeecontractcf'=>'employeecontractid');

        /**
         * Mandatory for Listing (Related listview)
         */
        var $list_fields = Array (
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Employee No' => Array('employeecontract', 'employeeno'),
                'Assigned To' => Array('crmentity','smownerid')
        );
        var $list_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Employee No' => 'employeeno',
                'Assigned To' => 'assigned_user_id',
        );

        // Make the field link to detail view
        var $list_link_field = 'employeeno';

        // For Popup listview and UI type support
        var $search_fields = Array(
                /* Format: Field Label => Array(tablename, columnname) */
                // tablename should not have prefix 'vtiger_'
                'Employee No' => Array('employeecontract', 'employeeno'),
                'Assigned To' => Array('vtiger_crmentity','assigned_user_id'),
        );
        var $search_fields_name = Array (
                /* Format: Field Label => fieldname */
                'Employee No' => 'employeeno',
                'Assigned To' => 'assigned_user_id',
        );

        // For Popup window record selection
        var $popup_fields = Array ('employeeno');

        // For Alphabetical search
        var $def_basicsearch_col = 'employeeno';

        // Column value to use on detail view record text display
        var $def_detailview_recname = 'employeeno';

        var $column_fields = Array();
        // Used when enabling/disabling the mandatory fields for the module.
        // Refers to vtiger_field.fieldname values.
        var $mandatory_fields = Array('employeeno','assigned_user_id');

        var $default_order_by = 'employeeno';
        var $default_sort_order='ASC';

        function EmployeeContract() {
                $this->log =LoggerManager::getLogger('EmployeeContract');
                $this->db = PearDatabase::getInstance();
                $this->column_fields = getColumnFields('EmployeeContract');
        }
        /**
        * Invoked when special actions are performed on the module.
        * @param String Module name
        * @param String Event Type
        */
        function vtlib_handler($moduleName, $eventType) {
                global $adb;
                if($eventType == 'module.postinstall') {
                        // TODO Handle actions after this module is installed.
                } else if($eventType == 'module.disabled') {
                        // TODO Handle actions before this module is being uninstalled.
                } else if($eventType == 'module.preuninstall') {
                        // TODO Handle actions when this module is about to be deleted.
                } else if($eventType == 'module.preupdate') {
                        // TODO Handle actions before this module is updated.
                } else if($eventType == 'module.postupdate') {
                        // TODO Handle actions after this module is updated.
                }
        }
        function save_module($module) {
                $this->insertIntoAttachment($this->id,$module);

                //update grade of assignto user 
                global $adb;

                $assign = $this->column_fields['employee_id'];
                $grade = $this->column_fields['job_grade'];
                $adb->pquery("UPDATE vtiger_users SET grade_id = ? WHERE id=?", array($grade,$assign));


        }

        function insertIntoAttachment($id,$module)
        {
                global $log, $adb;
                //$adb->setDebug(true);
                $log->debug("Entering into insertIntoAttachment($id,$module) method.");

                $file_saved = false;

                foreach($_FILES as $fileindex => $files)
                {
                        if($files['name'] != '' && $files['size'] > 0)
                        {
                                $files['original_name'] = vtlib_purify($_REQUEST[$fileindex.'_hidden']);
                                //echo $this->column_fields['filelocationtype'];die;
                                $file_saved = $this->uploadAndSaveFile($id,$module,$files,'Attachment');

                                $adb->pquery("UPDATE vtiger_employeecontract SET letter_of_appointment=? WHERE employeecontractid=?",array($files['name'],$this->id));
                        }
                }
                $log->debug("Exiting from insertIntoAttachment($id,$module) method.");
        }

        /** Returns a list of the associated opportunities
         * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
         * All Rights Reserved..
         * Contributor(s): ______________________________________..
        */
        function get_Entitlement_list($id, $cur_tab_id, $rel_tab_id, $actions=false) {


                global $log, $singlepane_view,$currentModule,$adb;

                $log->debug("Entering get_Entitlement_list(".$id.") method ...");
                // /$adb->setDebug(true);
                $this_module = $currentModule;

                                            $related_module = vtlib_getModuleNameById($rel_tab_id);
                require_once("modules/$related_module/$related_module.php");
                $other = new $related_module();
                                           vtlib_setup_modulevars($related_module, $other);
                $singular_modname = vtlib_toSingular($related_module);

                $parenttab = getParentTab();

                $button = '';

                $result = $adb->pquery("SELECT job_grade FROM vtiger_employeecontract WHERE employeecontractid=?", array($id));
                $grade_id = $adb->query_result($result, 0, 'job_grade');
                $year = date('Y');
                $query = "SELECT vtiger_claimtype.claim_type, vtiger_claimtype.claim_status FROM vtiger_claimtype 	
                        LEFT JOIN allocation_claimrel ON allocation_claimrel.claim_id=vtiger_claimtype.claimtypeid
                        LEFT JOIN allocation_list ON allocation_list.allocation_id=allocation_claimrel.allocation_id
                        WHERE allocation_claimrel.grade_id='$grade_id' AND allocation_list.allocation_year='$year' LIMIT 0, 10";

                $return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

                if($return_value == null) $return_value = Array();

                $return_value['CUSTOM_BUTTON'] = $button;

                $log->debug("Exiting from get_Entitlement_list($id) method.");
                return $return_value;
        }
}

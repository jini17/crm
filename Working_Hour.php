<?php
// Turn on debugging level
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Create module instance and save it first
$module = new Vtiger_Module();
$module->name = 'WorkingHours';
$module->save();
// Initialize all the tables required
$module->initWebservice();
$module->initTables();
/**
 * Creates the following table:
 * vtiger_zone (zoneid INTEGER)
 * vtiger_zonecf(zoneid INTEGER PRIMARY KEY)
 * vtiger_zonegrouprel((zoneid INTEGER PRIMARY KEY, groupname VARCHAR(100))
 */
// Add the module to the Menu (entry point from UI)
$menu = Vtiger_Menu::getInstance('Support');
$menu->addModule($module);
// Add the basic module block
$block1 = new Vtiger_Block();
$block1->label = 'Working Hours Information';
$module->addBlock($block1);
// Add custom block (required to support Custom Fields)
$block2 = new Vtiger_Block();
$block2->label = 'Remarks';
$module->addBlock($block2);

$block3 = new Vtiger_Block();
$block3->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($block3);

/** Create required fields and add to the block */
 
$field1 = new Vtiger_Field();
$field1->name = 'day';
$field1->label = 'Day of the Week';
$field1->table = $module->basetable;
$field1->column = 'day';
$field1->columntype = 'VARCHAR(255)';
$field1->uitype = 15;
$field1->typeofdata = 'V~M';
$field1->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
$block1->addField($field1); /** Creates the field and adds to block */
// Set at-least one field to identifier of module record
$module->setEntityIdentifier($field1);

$field2 = new Vtiger_Field();
$field2->name = 'wh_no'; //Sequencial
$field2->label = 'WH ID';
$field2->table = $module->basetable;
$field2->column = 'wh_no';
$field2->columntype = 'VARCHAR(100)';
$field2->uitype = 4;
$field2->typeofdata = 'V~O';
$block1->addField($field2);
// add for configure values..
$entity_tmp = new CRMEntity();
$entity_tmp->setModuleSeqNumber("configure",$module->name,"WH",1);

$field3 = new Vtiger_Field();
$field3->name = 'start_wh';
$field3->label= 'Start Working Hours';
$field3->column = 'start_wh';
$field3->columntype = 'VARCHAR(100)';
$field3->uitype = 14;
$field3->typeofdata = 'T~M';
$block1->addField($field3);

$field7 = new Vtiger_Field();
$field7->name = 'end_wh';
$field7->label= 'End Working Hours';
$field7->column = 'end_wh';
$field7->columntype = 'VARCHAR(100)';
$field7->uitype = 14;
$field7->typeofdata = 'T~M';
$block1->addField($field7);

/** Common fields that should be in every module, linked to vtiger CRM core table
*/
$field4 = new Vtiger_Field();
$field4->name = 'assigned_user_id';
$field4->label = 'Assigned To';
$field4->table = 'vtiger_crmentity';
$field4->column = 'smownerid';
$field4->uitype = 53;
$field4->typeofdata = 'V~M';
$block1->addField($field4);

$field5 = new Vtiger_Field();
$field5->name = 'CreatedTime';
$field5->label= 'Created Date/Time';
$field5->table = 'vtiger_crmentity';
$field5->column = 'createdtime';
$field5->uitype = 70;
$field5->typeofdata = 'T~O';
$field5->displaytype= 2;
$block1->addField($field5);

$field6 = new Vtiger_Field();
$field6->name = 'ModifiedTime';
$field6->label= 'Modified Date/Time';
$field6->table = 'vtiger_crmentity';
$field6->column = 'modifiedtime';
$field6->uitype = 70;
$field6->typeofdata = 'T~O';
$field6->displaytype= 2;
$block1->addField($field6);

/** END */

// Create default custom filter (mandatory)
$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);
// Add fields to the filter created
$filter1->addField($field2)->addField($field1, 1)->addField($field3, 2)->addField($field7, 3);
// Create one more filter
$filter2 = new Vtiger_Filter();
$filter2->name = 'WorkingHours';
$module->addFilter($filter2);
/* // Add fields to the filter
$filter2->addField($field1);
                                                   
$filter2->addField($field3, 1);
// Add rule to the filter field
$filter2->addRule($field2, 'CONTAINS', 'Test'); */
/** Associate other modules to this module */
//$module->setRelatedList(Vtiger_Module::getInstance('Units'), 'Units',
//Array('ADD','SELECT'));
/** Set sharing access of this module */
$module->setDefaultSharing('Public_ReadWriteDelete');
/** Enable and Disable available tools */
$module->enableTools(Array('Import', 'Export'));
$module->disableTools('Merge');
?>

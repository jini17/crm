<?php

/** Create New Vtlib script for module Creation
 * created : 22 Feb 2018
 * Author  : Nirbhay Shah
 */
error_reporting(1);
ini_set('display_erros',1);

register_shutdown_function('handleErrors');
function handleErrors() {

    $last_error = error_get_last();

    if (!is_null($last_error)) { // if there has been an error at some point

        // do something with the error
        print_r($last_error);

    }

}
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Package.php');
include_once 'includes/main/WebUI.php';
include_once 'include/Webservices/Utils.php';

$Vtiger_Utils_Log = true;
global $adb;
$adb->setDebug(true);
$MODULENAME = 'Holiday'; //Give your module name
$PARENT 	= '';  //Give Parent name
$ENTITYNAME = 'holiday_name'; //Give Duplicate check field name
$ENTITYLABEL= 'Holiday Name';

$module = Vtiger_Module::getInstance($MODULENAME);

if($module || file_exists('modules/'.$MODULENAME)) {
    echo $MODULENAME." Module already present - choose a different name.";
    exit;
}

// Create module instance and save it first

$module = new Vtiger_Module();
$module->name = $MODULENAME;
$module->parent= $PARENT;
$module->save();

$module->initTables();

$blockHoliday = new Vtiger_Block();
$blockHoliday->label = 'LBL_'. strtoupper($module->name) . '_INFORMATION';
$module->addBlock($blockHoliday);

/*
$blockcf = new Vtiger_Block();
$blockcf->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($blockcf);
*/


$field1  = new Vtiger_Field();
$field1->name = $ENTITYNAME;
$field1->label= $ENTITYLABEL;
$field1->uitype= 2;
$field1->column = $field1->name;
$field1->columntype = 'VARCHAR(255)';
$field1->typeofdata = 'V~M';
$field1->iscustom	= 0;
$blockHoliday->addField($field1);

$module->setEntityIdentifier($field1); //make primary key for module

/**
ADD YOUR FIELDS HERE
 **/

$field2 = new Vtiger_Field();
$field2->name = 'start_date';
$field2->label = 'Start Date';
$field2->table = $module->basetable;
$field2->column = 'start_date';
$field2->columntype = 'DATE';
$field2->uitype = 5;
$field2->typeofdata = 'D~O'; // date~Mandatory
$field2->iscustom	= 0;
$blockHoliday->addField($field2); /** table and column are automatically set */


$field3 = new Vtiger_Field();
$field3->name = 'end_date';
$field3->label = 'End Date';
$field3->table = $module->basetable;
$field3->column = 'end_date';
$field3->columntype = 'DATE';
$field3->uitype = 5;
$field3->typeofdata = 'D~O'; // date~Mandatory
$field3->iscustom	= 0;
$blockHoliday->addField($field3); /** table and column are automatically set */

/*
$blockcf = new Vtiger_Block();
$blockcf->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($blockcf);
*/


$field4  = new Vtiger_Field();
$field4->name = 'location';
$field4->label= 'Location';
$field4->uitype= 2;
$field4->column = $field1->name;
$field4->columntype = 'VARCHAR(255)';
$field4->typeofdata = 'V~O';
$field4->iscustom	= 0;
$blockHoliday->addField($field4);



$field5  = new Vtiger_Field();
$field5->name = 'holiday_id';
$field5->label= 'Holiday Id';
$field5->uitype= 4;
$field5->column = $field5->name;
$field5->columntype = 'VARCHAR(255)';
$field5->typeofdata = 'V~O';
$field5->iscustom	= 0;
$blockHoliday->addField($field5);






/** Common fields that should be in every module, linked to vtiger CRM core table */
$field9 = new Vtiger_Field();
$field9->name = 'assigned_user_id';
$field9->label = 'Assigned To';
$field9->table = 'vtiger_crmentity';
$field9->column = 'smownerid';
$field9->uitype = 53;
$field9->typeofdata = 'V~M';
$field9->iscustom	= 0;
$blockHoliday->addField($field9);

$field10 = new Vtiger_Field();
$field10->name = 'createdtime';
$field10->label= 'Created Time';
$field10->table = 'vtiger_crmentity';
$field10->column = 'createdtime';
$field10->uitype = 70;
$field10->typeofdata = 'T~O';
$field10->displaytype= 2;
$field10->iscustom	= 0;
$blockHoliday->addField($field10);

$field11 = new Vtiger_Field();
$field11->name = 'modifiedtime';
$field11->label= 'Modified Time';
$field11->table = 'vtiger_crmentity';
$field11->column = 'modifiedtime';
$field11->uitype = 70;
$field11->typeofdata = 'T~O';
$field11->displaytype= 2;
$field11->iscustom	= 0;
$blockHoliday->addField($field11);


// Create default custom filter (mandatory)
$filter1 = new Vtiger_Filter();
$filter1->name = 'All';
$filter1->isdefault = true;
$module->addFilter($filter1);
// Add fields to the filter created
$filter1->addField($field1)->addField($field2, 1)->addField($field3, 2);

// Set sharing access of this module
$module->setDefaultSharing();

// Enable and Disable available tools
$module->enableTools(Array('Import', 'Export', 'Merge'));

// Initialize Webservice support
$module->initWebservice();

// Create files
createFiles($module, $field1);

// Link to menu
Settings_MenuEditor_Module_Model::addModuleToApp($module->name, $module->parent);

echo "Module is created";


function createFiles(Vtiger_Module $module, Vtiger_Field $entityField) {

    $targetpath = 'modules/' . $module->name;

    if (!is_file($targetpath)) {
        mkdir($targetpath);
        mkdir($targetpath . '/language');

        $templatepath = 'vtlib/ModuleDir/6.0.0';

        $moduleFileContents = file_get_contents($templatepath . '/ModuleName.php');
        $replacevars = array(
            'ModuleName'   => $module->name,
            '<modulename>' => strtolower($module->name),
            '<entityfieldlabel>' => $entityField->label,
            '<entitycolumn>' => $entityField->column,
            '<entityfieldname>' => $entityField->name,
        );

        foreach ($replacevars as $key => $value) {
            $moduleFileContents = str_replace($key, $value, $moduleFileContents);
        }
        file_put_contents($targetpath.'/'.$module->name.'.php', $moduleFileContents);
    }
}


?>
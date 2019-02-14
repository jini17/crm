<?php

/** Create New Vtlib script for module Creation
 * created : 14 May 2018
 * Author  : Nirbhay Shah
 */
//error_reporting(1);
//ini_set('display_erros',1);
//
//register_shutdown_function('handleErrors');
//function handleErrors() {
//
//    $last_error = error_get_last();
//
//    if (!is_null($last_error)) { // if there has been an error at some point
//
//        // do something with the error
//        print_r($last_error);
//
//    }
//
//}
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Package.php');
include_once 'includes/main/WebUI.php';
include_once 'include/Webservices/Utils.php';

$Vtiger_Utils_Log = true;

$MODULENAME = 'EmergencyContact'; //Give your module name
$PARENT 	= 'SUPPORT';  //Give Parent name
$ENTITYNAME = 'contact_name'; //Give Duplicate check field name
$ENTITYLABEL= 'Contact Name';

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

$block = new Vtiger_Block();
$block->label = 'LBL_'. strtoupper($module->name) . '_INFORMATION';
$module->addBlock($block);

$blockcf = new Vtiger_Block();
$blockcf->label = 'Information';
$module->addBlock($blockcf);

$field1  = new Vtiger_Field();
$field1->name = 'home_phone';
$field1->label= 'Home Phone';
$field1->uitype= 11;
$field1->column = $field2->name;
$field1->columntype = 'VARCHAR(15)';
$field1->typeofdata = 'V~O';
$block->addField($field1);


$field2  = new Vtiger_Field();
$field2->name = $ENTITYNAME;
$field2->label= $ENTITYLABEL;
$field2->uitype= 2;
$field2->column = $field2->name;
$field2->columntype = 'VARCHAR(255)';
$field2->typeofdata = 'V~M';
$block->addField($field2);
$module->setEntityIdentifier($field2); //make primary key for module

$field3  = new Vtiger_Field();
$field3->name = 'office_phone';
$field3->label= 'Office Phone';
$field3->uitype= 11;
$field3->column = $field3->name;
$field3->columntype = 'VARCHAR(15)';
$field3->typeofdata = 'V~O';
$block->addField($field3);


$field4  = new Vtiger_Field();
$field4->name = 'mobile';
$field4->label= 'Mobile';
$field4->uitype= 11;
$field4->column = $field4->name;
$field4->columntype = 'VARCHAR(15)';
$field4->typeofdata = 'V~O';
$block->addField($field4);

/** Create required fields and add to the block */
$field8 = new Vtiger_Field();
$field8->name = 'relationship';
$field8->label = 'Relationship';
$field8->table = $module->basetable;
$field8->column = 'relationship';
$field8->columntype = 'VARCHAR(100)';
$field8->uitype = 15;
$field8->typeofdata = 'V~O';
$field8->setPicklistValues( Array ('Father', 'Mother','Brother','Sister','Others') );
$block->addField($field8); /** Creates the field and adds to block */


/**
ADD YOUR FIELDS HERE
 */

/** Common fields that should be in every module, linked to vtiger CRM core table */
$field2 = new Vtiger_Field();
$field2->name = 'assigned_user_id';
$field2->label = 'Assigned To';
$field2->table = 'vtiger_crmentity';
$field2->column = 'smownerid';
$field2->uitype = 53;
$field2->typeofdata = 'V~M';
$block->addField($field2);

$field3 = new Vtiger_Field();
$field3->name = 'createdtime';
$field3->label= 'Created Time';
$field3->table = 'vtiger_crmentity';
$field3->column = 'createdtime';
$field3->uitype = 70;
$field3->typeofdata = 'T~O';
$field3->displaytype= 2;
$block->addField($field3);

$field4 = new Vtiger_Field();
$field4->name = 'modifiedtime';
$field4->label= 'Modified Time';
$field4->table = 'vtiger_crmentity';
$field4->column = 'modifiedtime';
$field4->uitype = 70;
$field4->typeofdata = 'T~O';
$field4->displaytype= 2;
$block->addField($field4);


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

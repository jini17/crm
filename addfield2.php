<?php


ini_set('display_errors',1);
error_reporting(E_ALL);
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

include('config.inc.php');
global $adb;
$adb->setDebug(true);

$module = new Vtiger_Module();
$module->name = 'Contacts';
$module = $module->getInstance('Contacts');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_CONTACT_INFORMATION';

$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();

$field1->name = 'company_name';
$field1->table = $module->basetable;
$field1->label = 'Company Title';
$field1->column = 'company_name';
$field1->columntype = 'VARCHAR(150)';
$field1->uitype = 2;
$field1->typeofdata = 'V~O';
$block1->addField($field1);
echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

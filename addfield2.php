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
$module->name = 'Education';
$module = $module->getInstance('Education');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_EDUCATION_INFORMATION';

$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();

$field1->name = 'education_type';
$field1->table = $module->basetable;
$field1->label = 'Education Type';
$field1->column = 'education_type';
$field1->columntype = 'VARCHAR(5)';
$field1->uitype = 15;
$field1->typeofdata = 'V~O';
$field1->setPicklistValues( Array ('Part-Time', 'Full-Time') );
$block1->addField($field1);


$field2 = new Vtiger_Field();

$field2->name = 'education_location';
$field2->table = $module->basetable;
$field2->label = 'Education Type';
$field2->column = 'education_type';
$field2->columntype = 'VARCHAR(5)';
$field2->uitype = 2;
$field2->typeofdata = 'V~O';
$block1->addField($field2);
echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

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
$module->name = 'Users';
$module = $module->getInstance('Users');

// Create Block instance

$block = new Vtiger_Block();
$block->label = 'LBL_EMPLOYEE_LOCATION_INFORMATION';
$module->addBlock($block);


$field1 = new Vtiger_Field();
$field1->name = 'user_company';
$field1->label = 'Select Company';
$field1->table = $module->basetable;
$field1->column = 'user_company';
$field1->columntype = 'varchar(10)';
$field1->uitype = 399;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O'; // varchar~Mandatory
$block->addField($field1); /** table and column are automatically set */


$field1 = new Vtiger_Field();
$field1->name = 'user_location';
$field1->label = 'Select Location';
$field1->table = $module->basetable;
$field1->column = 'user_location';
$field1->columntype = 'varchar(10)';
$field1->uitype = 3996;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O'; // varchar~Mandatory
$block->addField($field1); /** table and column are automatically set */

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

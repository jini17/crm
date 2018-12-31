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
$module->name = 'OrganizationDetails';
$module = $module->getInstance('OrganizationDetails');

// Create Block instance

$block = new Vtiger_Block();
$block->label = 'LBL_ORGANIZATIONDETAILS_INFORMATION';
$block = $block->getInstance($block->label,$module);


$field1 = new Vtiger_Field();
$field1->name = 'isdefault';
$field1->label = 'Default Company';
$field1->table = $module->basetable;
$field1->column = 'isdefault';
$field1->columntype = 'varchar(1)';
$field1->uitype = 56;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O'; // varchar~Mandatory
$block->addField($field1); /** table and column are automatically set */

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

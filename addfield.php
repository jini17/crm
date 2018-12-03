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
$module->name = 'Documents';
$module = $module->getInstance('Documents');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_NOTE_INFORMATION';

$block1 = $block1->getInstance($block1->label,$module);


$field1 = new Vtiger_Field();
	$field1->name = 'visibility_identifier';
	$field1->label = 'LBL_PERMISSION';
	$field1->table = $module->basetable;
	$field1->column = 'visibility_identifier';
	$field1->columntype = 'varchar(10)';
	$field1->uitype = 16;
	$field1->displaytype = 1;
	$field1->typeofdata = 'V~O'; // varchar~Mandatory
	$field1->setPicklistValues( Array ('Public', 'Private','Protected') );
	$block1->addField($field1); /** table and column are automatically set */

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

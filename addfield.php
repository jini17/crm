<?php

echo md5('123456');die;
ini_set('display_errors',1);
error_reporting(E_ALL);
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

include('config.inc.php');
global $adb;
$adb->setDebug(true);

$module = new Vtiger_Module();
$module->name = 'Claim';
$module = $module->getInstance('Claim');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'Expense Information';

$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();

$field1->name = 'user_type';
$field1->table = $module->basetable;
$field1->label = 'User Type';
$field1->column = 'user_type';
$field1->columntype = 'varchar(10)';
$field1->uitype = 1;
$field1->typeofdata = 'V~O';
$block2->addField($field1);

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>
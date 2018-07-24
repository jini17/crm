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
$module->name = 'Claim';
$module = $module->getInstance('Claim');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'Expense Information';
$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();
$field1->name = 'resonforreject';
$field1->table = $module->basetable;
$field1->label = 'Reason for Reject';
$field1->column = 'resonforreject';
$field1->columntype = 'varchar(255)';
$field1->uitype = 19;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O';
$block1->addField($field1);

echo "NBBB";
?>



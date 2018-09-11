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
$module->name = 'Performance';
$module = $module->getInstance('Performance');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_PERFORMANCE_REVIEW';

$block1 = $block1->getInstance($block1->label,$module);


$field1 = new Vtiger_Field();

$field1->name = 'nextreviewdate';
$field1->table = $module->basetable;
$field1->label = 'Next Review Date';
$field1->column = 'nextreviewdate';
$field1->columntype = 'DATE';
$field1->uitype = 5;
$field1->typeofdata = 'D~O';
$block1->addField($field1);

echo "NBBB";

?>

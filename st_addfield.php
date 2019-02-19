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


$module->name = 'SalesTarget';
$module = $module->getInstance('SalesTarget');


// Create Block instance

$block1 = new Vtiger_Block();
$block1->label = 'LBL_DESCRIPTION_SCOPE';
$block1 = $block1->getInstance($block1->label,$module);


$field10 = new Vtiger_Field();
$field10->name = 'targetterritory';
$field10->label = 'Territory';
$field10->table = $module->basetable;
$field10->column = 'targetterritory';
$field10->columntype = 'VARCHAR(255)';
$field10->uitype = 2002;
$field10->typeofdata = 'V~O'; // Varchar~Optional
$block1->addField($field10); /** table and column are automatically set */


echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

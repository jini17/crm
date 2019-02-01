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


$module->name = 'Notifications';
$module = $module->getInstance('Notifications');


// Create Block instance

$block = new Vtiger_Block();
$block->label = 'LBL_NOTIFICATIONS_INFORMATION';
$block = $block->getInstance($block->label,$module);




$field = new Vtiger_Field();
$field->name = 'starred';
$field->label = 'Starred';
$field->table = 'vtiger_crmentity_user_field';
$field->column = 'starred';
$field->columntype = 'varchar(100)';
$field->uitype = 56;
$field->displaytype = 6;
$field->typeofdata = 'C~O'; // varchar~Mandatory
$block->addField($field); /** table and column are automatically set */


echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

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
$module->name = 'EmployeeContract';
$module = $module->getInstance('EmployeeContract');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_Employment_Contract_Information';

$block1 = $block1->getInstance($block1->label,$module);


$field2 = new vtiger_field();
$field2->name = 'gender';
$field2->label = 'Gender';
$field2->columntype = 'varchar(100)';
$field2->uitype = 15;
$field2->typeofdata = 'v~o';// varchar~optional
$block1->addfield($field2); /** table and column are automatically set */
$field2->setpicklistvalues( array ('Male', 'Female') );

$field3 = new vtiger_field();
$field3->name = 'age_group';
$field3->label = 'Age Group';
$field3->columntype = 'varchar(100)';
$field3->uitype = 15;
$field3->typeofdata = 'v~o';// varchar~optional
$block1->addfield($field3); /** table and column are automatically set */
$field3->setpicklistvalues( array ('Gen X', 'Xennials', 'Millennials', 'Gen Z'));
//Then insert the field Id, module, and related module name. 
echo 'Done'; 
?>

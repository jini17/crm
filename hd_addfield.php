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

$module->name = 'HelpDesk';
$module = $module->getInstance('HelpDesk');

$block1 = new Vtiger_Block();
$block1->label = 'LBL_TICKET_INFORMATION';
$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();
$field1->name = 'sc_related_to';
$field1->label = 'ServiceContract Name';
$field1->table = $module->basetable;
$field1->column = 'sc_related_to';
$field1->columntype = 'int(11)';
$field1->uitype = 10;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O'; // varchar~Mandatory
$block1->addField($field1); /** table and column are automatically set */
$field1->setRelatedModules(Array('ServiceContracts'));

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

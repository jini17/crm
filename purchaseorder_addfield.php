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
$module->name = 'PurchaseOrder';
$module = $module->getInstance('PurchaseOrder');


// Create Block instance

$block = new Vtiger_Block();
$block->label = 'LBL_TERMSCONDITION';
$module->addBlock($block);

$field1 = new Vtiger_Field();
$field1->name = 'company_details';
$field1->label = 'Company Details';
$field1->table = $module->basetable;
$field1->column = 'company_details';
$field1->columntype = 'int(11)';
$field1->uitype = 3993;
$field1->displaytype = 1;
$field1->typeofdata = 'I~M'; // varchar~Mandatory
$block->addField($field1); /** table and column are automatically set */

$field2 = new Vtiger_Field();
$field2->name = 'terms_condition';
$field2->label = 'Terms Conditions';
$field2->table = $module->basetable;
$field2->column = 'terms_condition';
$field2->columntype = 'int(11)';
$field2->uitype = 3994;
$field2->displaytype = 1;
$field2->typeofdata = 'I~M'; // varchar~Mandatory
$block->addField($field2); /** table and column are automatically set */


echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

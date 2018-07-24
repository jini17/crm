<?php

echo md5('123456');die;
ini_set('display_errors',1);
error_reporting(E_ALL);
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
//include('include/utils/utils.php');
//include('config.inc.php');
global $adb;
$adb->setDebug(true);

//(module name without space)
$module = new Vtiger_Module();

$module->name = 'Users';
$module = $module->getInstance('Users');

// Create Block instance
/*$block1 = new Vtiger_Block();
$block1->label = 'LBL_SURVEY_INFORMATION';
$block1 = $block1->getInstance($block1->label,$module);

$field0 = new Vtiger_Field();
$field0->name = 'usertype';
$field0->table = $module->basetable;
$field0->label = 'Participant Type';
$field0->column = 'usertype';
$field0->columntype = 'varchar(50)';
$field0->uitype = 15;
$field0->typeofdata = 'V~M';
$field0->setPicklistValues( Array ('Accounts', 'Contacts', 'Leads', 'Vendors', 'Users') );
$block1->addField($field0);
*/
$block2 = new Vtiger_Block();
$block2->label = 'LBL_MORE_INFORMATION';
$block2 = $block2->getInstance($block2->label,$module);
$module->addBlock($block2);

$field1 = new Vtiger_Field();
$field1->name = 'user_type';
$field1->table = $module->basetable;
$field1->label = 'User Type';
$field1->column = 'user_type';
$field1->columntype = 'varchar(10)';
$field1->uitype = 1;
$field1->typeofdata = 'V~O';
$block2->addField($field1);

//$module->setDefaultSharing();
echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>



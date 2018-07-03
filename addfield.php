<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
$Vtiger_Utils_Log = true;
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');

include('config.inc.php');dasfav z
global $adb;
$adb->setDebug(true);

$module = new Vtiger_Moasdvfasdule();
$module->name = 'Claim';
$module = $module->getInstance('Claim');dasfasv xc

// Create Block instance
$block1 = new Vtiger_Block();dscvfdv dsdsdsdsdsdsdasdasddsds
$block1->label = 'Expense Information';
$block1 = $block1->getInstance($block1->label,$module);

$field1 = new Vtiger_Field();
$field1->name = 'approved_by';
$field1->table = $module->basetable;
$field1->label = 'Approved By';
$field1->column = 'approved_by';
$field1->columntype = 'varchar(150)';
$field1->uitype = 53;
$field1->displaytype = 1;
$field1->typeofdata = 'V~M';
$block1->addField($field1);

/*$field2 = new Vtiger_Field();
$field2->name = 'lastname';
$field2->table = $module->basetable;
$field2->label = 'Last Name';
$field2->column = 'lastname';
$field2->columntype = 'varchar(100)';
$field2->uitype = 2;
$field2->typeofdata = 'V~O';
$block1->addField($field2);

$field3 = new Vtiger_Field();
$field3->name = 'phone';
$field3->table = $module->basetable;
$field3->label = 'Phone';
$field3->column = 'phone';
$field3->columntype = 'varchar(100)';
$field3->uitype = 11;
$field3->typeofdata = 'V~O';
$block1->addField($field3);

$field4 = new Vtiger_Field();
$field4->name = 'email';
$field4->table = $module->basetable;
$field4->label = 'Email';
$field4->column = 'email';
$field4->columntype = 'varchar(100)';
$field4->uitype = 13;
$field4->typeofdata = 'V~O';
$block1->addField($field4);

$field5 = new Vtiger_Field();
$field5->name = 'address';
$field5->table = $module->basetable;
$field5->label = 'Contact Address';
$field5->column = 'address';
$field5->columntype = 'text';
$field5->uitype = 19;
$field5->typeofdata = 'V~O';
$block1->addField($field5);*/
echo "NBBB";
?>



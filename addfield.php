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
$module->name = 'Users';
$module = $module->getInstance('Users');

// Create Block instance
$block1 = new Vtiger_Block();
$block1->label = 'LBL_MORE_INFORMATION';
$block1 = $block1->getInstance($block1->label,$module);

// Create Block instance
$block2 = new Vtiger_Block();
$block2->label = 'Social Media';
$block2 = $block2->getInstance($block2->label,$module);

// Create Block instance
$block3 = new Vtiger_Block();
$block3->label = 'Permanent Address';
$block3 = $block3->getInstance($block3->label,$module);

$field1 = new Vtiger_Field();
$field1->name = 'nationality';
$field1->table = $module->basetable;
$field1->label = 'Nationality';
$field1->column = 'nationality';
$field1->columntype = 'VARCHAR(150)';
$field1->uitype = 3995;
$field1->typeofdata = 'V~O';
$block1->addField($field1);

$field2 = new Vtiger_Field();
$field2->name = 'marital_status';
$field2->table = $module->basetable;
$field2->label = 'Marital Status';
$field2->column = 'marital_status';
$field2->columntype = 'VARCHAR(30)';
$field2->uitype = 15;
$field2->typeofdata = 'V~O';
$field2->setPicklistValues(array('Single','Married', 'Divorced' , 'Widow'));
$block1->addField($field2);


$field3 = new Vtiger_Field();
$field3->name = 'linkedin';
$field3->table = $module->basetable;
$field3->label = 'LinkedIn';
$field3->column = 'linkedin';
$field3->columntype = 'VARCHAR(30)';
$field3->uitype = 17;
$field3->typeofdata = 'V~O';
$block2->addField($field3);

$field4 = new Vtiger_Field();
$field4->name = 'facebook';
$field4->table = $module->basetable;
$field4->label = 'Facebook';
$field4->column = 'facebook';
$field4->columntype = 'VARCHAR(30)';
$field4->uitype = 17;
$field4->typeofdata = 'V~O';
$block2->addField($field4);

$field5 = new Vtiger_Field();
$field5->name = 'twitter';
$field5->table = $module->basetable;
$field5->label = 'Twitter';
$field5->column = 'twitter';
$field5->columntype = 'VARCHAR(30)';
$field5->uitype = 17;
$field5->typeofdata = 'V~O';
$block2->addField($field5);

$field6 = new Vtiger_Field();
$field6->name = 'instagram';
$field6->table = $module->basetable;
$field6->label = 'Instagram';
$field6->column = 'instagram';
$field6->columntype = 'VARCHAR(30)';
$field6->uitype = 17;
$field6->typeofdata = 'V~O';
$block2->addField($field6);

$field12 = new Vtiger_Field();
$field12->name = 'sameaddresscheck';
$field12->table = $module->basetable;
$field12->label = 'Same as Correspondence Address';
$field12->column = 'sameaddresscheck';
$field12->columntype = 'tinyint(1)';
$field12->uitype = 56;
$field12->typeofdata = 'V~O';
$block3->addField($field12);

$field7 = new Vtiger_Field();
$field7->name = 'paddress_street';
$field7->table = $module->basetable;
$field7->label = 'Street Address';
$field7->column = 'paddress_street';
$field7->columntype = 'VARCHAR(150)';
$field7->uitype = 21;
$field7->typeofdata = 'V~O';
$block3->addField($field7);

$field8 = new Vtiger_Field();
$field8->name = 'paddress_city';
$field8->table = $module->basetable;
$field8->label = 'City';
$field8->column = 'paddress_city';
$field8->columntype = 'VARCHAR(100)';
$field8->uitype = 1;
$field8->typeofdata = 'V~O';
$block3->addField($field8);

$field9 = new Vtiger_Field();
$field9->name = 'paddress_state';
$field9->table = $module->basetable;
$field9->label = 'State';
$field9->column = 'paddress_state';
$field9->columntype = 'VARCHAR(100)';
$field9->uitype = 1;
$field9->typeofdata = 'V~O';
$block3->addField($field9);

$field10 = new Vtiger_Field();
$field10->name = 'paddress_postalcode';
$field10->table = $module->basetable;
$field10->label = 'Postal Code';
$field10->column = 'paddress_postalcode';
$field10->columntype = 'VARCHAR(30)';
$field10->uitype = 1;
$field10->typeofdata = 'V~O';
$block3->addField($field10);

$field11 = new Vtiger_Field();
$field11->name = 'paddress_country';
$field11->table = $module->basetable;
$field11->label = 'Country';
$field11->column = 'paddress_country';
$field11->columntype = 'VARCHAR(100)';
$field11->uitype = 3995;
$field11->typeofdata = 'V~O';
$block3->addField($field11);


echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

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


$module->name = 'ServiceContracts';
$module = $module->getInstance('ServiceContracts');


// Create Block instance

$block = new Vtiger_Block();
$block->label = 'LBL_Product_Service Information';
$module->addBlock($block);

$blockcf = new Vtiger_Block();
$blockcf->label = 'LBL_CUSTOM_INFORMATION';
$module->addBlock($blockcf);


$field1 = new Vtiger_Field();
$field1->name = 'ps_related_to';
$field1->label = 'Product/Service Name';
$field1->table = $module->basetable;
$field1->column = 'ps_related_to';
$field1->columntype = 'int(11)';
$field1->uitype = 10;
$field1->displaytype = 1;
$field1->typeofdata = 'V~O'; // varchar~Mandatory
$block->addField($field1); /** table and column are automatically set */
$field1->setRelatedModules(Array('Products','Services'));

$field2 = new Vtiger_Field();
$field2->name = 'serialno';
$field2->label = 'Serial No';
$field2->table = $module->basetable;
$field2->column = 'serialno';
$field2->columntype = 'varchar(100)';
$field2->uitype = 1;
$field2->displaytype = 1;
$field2->typeofdata = 'V~O'; // varchar~Mandatory
$block->addField($field2); /** table and column are automatically set */


$field3-> = new Vtiger_Field();
$field3->->name = 'reg_date';
$field3->->label = 'Registration date';
$field3->->table = $module->basetable;
$field3->->column = 'reg_date';
$field3->->columntype = 'DATE';
$field3->->uitype = 5;
$field3->->displaytype = 1;
$field3->->typeofdata = 'D~O'; // varchar~Mandatory
$block->addField($field3); /** table and column are automatically set */


$field4 = new Vtiger_Field();
$field4->name = 'ps_status';
$field4->label = 'Product/Service Status';
$field4->table = $module->basetable;
$field4->column = 'ps_status';
$field4->columntype = 'varchar(100)';
$field4->uitype = 1;
$field4->displaytype = 1;
$field4->typeofdata = 'V~O'; // varchar~Mandatory
$field4->setPicklistValues( Array ('Registered', 'Unregistered', 'On-hold', 'On-registered', 'In Active') );
$block->addField($field4); /** table and column are automatically set */


$field5 = new Vtiger_Field();
$field5->name = 'purchase_date';
$field5->label = 'Purchase Date';
$field5->table = $module->basetable;
$field5->column = 'purchase_date';
$field5->columntype = 'DATE';
$field5->uitype = 5;
$field5->displaytype = 1;
$field5->typeofdata = 'D~O'; // varchar~Mandatory
$block->addField($field5); /** table and column are automatically set */

$field6 = new Vtiger_Field();
$field6->name = 'sc_description';
$field6->label = 'Description';
$field6->table = $module->basetable;
$field6->column = 'sc_description';
$field6->columntype = 'TEXT';
$field6->uitype = 19;
$field6->displaytype = 1;
$field6->typeofdata = 'V~O'; // varchar~Mandatory
$blockcf->addField($field6); /** table and column are automatically set */

echo "NBBB";
//after field is created, go to vtiger_field and find the field ID.
//Then insert the field Id, module, and related module name. 

?>

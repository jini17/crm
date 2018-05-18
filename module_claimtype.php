<?php

/** Create New Vtlib script for module Creation
  * created : 22 Feb 2018
  * Author  : Jitendra Gupta <jitendraknp2004@gmail.com>
  */
error_reporting(1);
		ini_set('display_erros',1);
		 
		  register_shutdown_function('handleErrors');       
		    function handleErrors() { 
			 
		       $last_error = error_get_last(); 
		     	
		       if (!is_null($last_error)) { // if there has been an error at some point 
		     
			  // do something with the error 
			  print_r($last_error); 
		     
		       } 
		     
		    }
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Package.php');
include_once 'includes/main/WebUI.php';
include_once 'include/Webservices/Utils.php';
global $adb;
$adb->setDebug(true);
	$Vtiger_Utils_Log = true;

	$MODULENAME = 'ClaimType'; //Give your module name
	$PARENT 	= 'Sales';  //Give Parent name
	$ENTITYNAME = 'claim_type'; //Give Duplicate check field name
	$ENTITYLABEL= 'Title';

	$module = Vtiger_Module::getInstance($MODULENAME);
	
	if($module || file_exists('modules/'.$MODULENAME)) {
        echo $MODULENAME." Module already present - choose a different name.";
        exit;
    }   
		
	// Create module instance and save it first
	
	$module = new Vtiger_Module();
    $module->name = $MODULENAME;
    $module->parent= $PARENT;
    $module->save();

    $module->initTables();

	$block = new Vtiger_Block();
	$block->label = 'LBL_'. strtoupper($module->name) . '_INFORMATION';
	$module->addBlock($block);

	$blockcf = new Vtiger_Block();
	$blockcf->label = 'LBL_CUSTOM_INFORMATION';
	$module->addBlock($blockcf);

	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 2;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$block->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'claim_no';
	$field5->label = 'Claim Type No';
	$field5->table = $module->basetable;
	$field5->column = 'claim_no';
	$field5->columntype = 'VARCHAR(150)';
	$field5->uitype = 4;
	$field5->displaytype = 1;
	$field5->typeofdata = 'V~M'; // varchar~Mandatory
	$block->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'claim_code';
	$field51->label = 'Claim Code';
	$field51->table = $module->basetable;
	$field51->column = 'claim_code';
	$field51->columntype = 'VARCHAR(150)';
	$field51->uitype = 1;
	$field51->displaytype = 1;
	$field51->typeofdata = 'V~M'; // varchar~Mandatory
	$block->addField($field51); /** table and column are automatically set */

	$field6 = new Vtiger_Field();
	$field6->name   =  'color_code';
	$field6->label  = 'Color Code';
	$field6->table  =  $module->basetable;
	$field6->column = 'color_code';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype	= 2;
	$field6->typeofdata = 'V~M'; // varchar~Mandatory
	$block->addField($field6); /** table, column, label, set to default values */
	
	$field7 = new Vtiger_Field();
	$field7->name   =  'claim_status';
	$field7->label  = 'Claim Status';
	$field7->table  =  $module->basetable;
	$field7->column = 'claim_status';
	$field7->columntype = 'VARCHAR(50)';
	$field7->uitype	= 56;
	$field7->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field7); /** table, column, label, set to default values */


	$field9 = new Vtiger_Field();
	$field9->name   =  'claim_description';
	$field9->label  = 'Description';
	$field9->table  =  $module->basetable;
	$field9->column = 'claim_description';
	$field9->columntype = 'TEXT';
	$field9->uitype	= 19;
	$field9->typeofdata = 'V~O'; // varchar~Mandatory
	$blockcf->addField($field9); /** table, column, label, set to default values */

	/**
		ADD YOUR FIELDS HERE
	*/


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$block->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$block->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$block->addField($field4);


	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
	$module->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field2, 1)->addField($field3, 2);

	// Set sharing access of this module
	$module->setDefaultSharing();

	// Enable and Disable available tools
	$module->enableTools(Array('Import', 'Export', 'Merge'));

	// Initialize Webservice support
	$module->initWebservice();

	// Create files
	createFiles($module, $field1);

	// Link to menu
	Settings_MenuEditor_Module_Model::addModuleToApp($module->name, $module->parent);

	echo "Module is created";


	function createFiles(Vtiger_Module $module, Vtiger_Field $entityField) {

		$targetpath = 'modules/' . $module->name;

		if (!is_file($targetpath)) {
			mkdir($targetpath);
			mkdir($targetpath . '/language');

			$templatepath = 'vtlib/ModuleDir/6.0.0';

			$moduleFileContents = file_get_contents($templatepath . '/ModuleName.php');
			$replacevars = array(
				'ModuleName'   => $module->name,
				'<modulename>' => strtolower($module->name),
				'<entityfieldlabel>' => $entityField->label,
				'<entitycolumn>' => $entityField->column,
				'<entityfieldname>' => $entityField->name,
			);

			foreach ($replacevars as $key => $value) {
				$moduleFileContents = str_replace($key, $value, $moduleFileContents);
			}
			file_put_contents($targetpath.'/'.$module->name.'.php', $moduleFileContents);
		}
	}

	
?>
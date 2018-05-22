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
//$adb->setDebug(true);
	$Vtiger_Utils_Log = true;

	$MODULENAME = 'LeaveType'; //Give your module name
	$PARENT 	= 'Sales';  //Give Parent name
	$ENTITYNAME = 'leavetypetitle'; //Give Duplicate check field name
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

	// Add the basic module block
	$leaveTypeInformation = new Vtiger_Block();
	$leaveTypeInformation->label = 'Leave Type Information';
	$module->addBlock($leaveTypeInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$module->addBlock($description);

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'title';
	$field1->label = 'Title';
	$field1->table = $module->basetable;
	$field1->column = 'title';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$leaveTypeInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$module->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'leavecode';
	$field2->label = 'Leave Code';
	$field2->table = $module->basetable;
	$field2->column = 'leavecode';
	$field2->columntype = 'VARCHAR(255)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'description';
	$field3->label = 'Description';
	$field3->table = $module->basetable;
	$field3->column = 'description';
	$field3->columntype = 'TEXT';
	$field3->uitype = 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'midyearallocation';
	$field4->label = 'Mid Year Allocation';
	$field4->table = $module->basetable;
	$field4->column = 'midyearallocation';
	$field4->columntype = 'VARCHAR(50)';
	$field4->uitype = 15;
	$field4->typeofdata = 'V~O'; 
	$field4->setPicklistValues( Array ('Full Allocation', 'Pro Rate Allocation'));
	$leaveTypeInformation->addField($field4); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
/*	$field5 = new Vtiger_Field();
	$field5->name = 'assignedto';
	$field5->label = 'Assigned To';
	$field5->table = $module->basetable;
	$field5->column = 'assignedto';
	$field5->columntype = 'VARCHAR(50)';
	$field5->uitype = 15;
	$field5->typeofdata = 'V~O'; 
	$field5->setPicklistValues( Array ('Users', 'Groups'));
	$leaveTypeInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'leavefrequency';
	$field6->label = 'Leave Frequency';
	$field6->table = $module->basetable;
	$field6->column = 'leavefrequency';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('One Time', 'Per Year'));
	$leaveTypeInformation->addField($field6); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'leaveType_status';
	$field7->label = 'Status';
	$field7->table = $module->basetable;
	$field7->column = 'leaveType_status';
	$field7->columntype = 'VARCHAR(3)';
	$field7->uitype = 56;
	$field7->typeofdata = 'C~M'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'carryforward';
	$field8->label = 'Carry Forward';
	$field8->table = $module->basetable;
	$field8->column = 'carryforward';
	$field8->columntype = 'VARCHAR(3)';
	$field8->uitype = 56;
	$field8->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'halfdayallowed';
	$field9->label = 'Half Day Allowed';
	$field9->table = $module->basetable;
	$field9->column = 'halfdayallowed';
	$field9->columntype = 'VARCHAR(3)';
	$field9->uitype = 56;
	$field9->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field9); /** Creates the field and adds to block */


	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'leavetypeno';
	$field10->label = 'Leave Type No';
	$field10->table = $module->basetable;
	$field10->column = 'leavetypeno';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 4;
	$field10->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'colorcode';
	$field11->label = 'Color Code';
	$field11->table = $module->basetable;
	$field11->column = 'colorcode';
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field11); /** Creates the field and adds to block */

	/**
		ADD YOUR FIELDS HERE
	*/


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field12 = new Vtiger_Field();
	$field12->name = 'assigned_user_id';
	$field12->label = 'Assigned To';
	$field12->table = 'vtiger_crmentity';
	$field12->column = 'smownerid';
	$field12->uitype = 53;
	$field12->typeofdata = 'V~M';
	$leaveTypeInformation->addField($field12);

	$field13 = new Vtiger_Field();
	$field13->name = 'createdtime';
	$field13->label= 'Created Time';
	$field13->table = 'vtiger_crmentity';
	$field13->column = 'createdtime';
	$field13->uitype = 70;
	$field13->typeofdata = 'T~O';
	$field13->displaytype= 2;
	$leaveTypeInformation->addField($field13);

	$field14 = new Vtiger_Field();
	$field14->name = 'modifiedtime';
	$field14->label= 'Modified Time';
	$field14->table = 'vtiger_crmentity';
	$field14->column = 'modifiedtime';
	$field14->uitype = 70;
	$field14->typeofdata = 'T~O';
	$field14->displaytype= 2;
	$leaveTypeInformation->addField($field14);


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
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

	$MODULENAME = 'Timesheet'; //Give your module name
	$PARENT 	= 'Support';  //Give Parent name
	$ENTITYNAME = 'tsno'; //Give Duplicate check field name
	$ENTITYLABEL= 'TimeSheet No';

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
	$timesheetInformation = new Vtiger_Block();
	$timesheetInformation->label = 'Timesheet Information';
	$module->addBlock($timesheetInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$module->addBlock($description);

	
	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 2;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$timesheetInformation->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	
	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'date';
	$field2->label = 'Date';
	$field2->table = $module->basetable;
	$field2->column = 'date';
	$field2->columntype = 'DATE';
	$field2->uitype = 5;
	$field2->typeofdata = 'D~O'; // varchar~Mandatory	
	$timesheetInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'description';
	$field3->label = 'Description';
	$field3->table = $module->basetable;
	$field3->column = 'description';
	$field3->columntype = 'TEXT';
	$field3->uitype = 19;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field3); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'timestart';
	$field4->label = 'Time Start';
	$field4->table = $module->basetable;
	$field4->column = 'timestart';
	$field4->columntype = 'DATE';
	$field4->uitype = 6;
	$field4->typeofdata = 'DT~M~time_start'; // varchar~Mandatory	
	$timesheetInformation->addField($field4); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'timeend';
	$field5->label = 'Time End';
	$field5->table = $module->basetable;
	$field5->column = 'timeend';
	$field5->columntype = 'DATE';
	$field5->uitype = 6;
	$field5->typeofdata = 'DT~M~time_start'; // varchar~Mandatory	
	$timesheetInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'total';
	$field6->label = 'Total';
	$field6->table = $module->basetable;
	$field6->column = 'total';
	$field6->columntype = 'DECIMAL(62,2)';
	$field6->uitype = 71;
	$field6->displaytype = 1;
	$field6->typeofdata = 'NN~M'; // varchar~Mandatory	
	$timesheetInformation->addField($field6); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'relatedto';
	$field7->label = 'Related To';
	$field7->table = $module->basetable;
	$field7->column = 'relatedto';
	$field7->columntype = 'VARCHAR(100)';
	$field7->uitype = 10;
	$field7->typeofdata = 'V~M';
	$timesheetInformation->addField($field7); /** Creates the field and adds to block */
	$field7->setRelatedModules(Array('Users'));

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'assignedto';
	$field8->label = 'Assigned To';
	$field8->table = $module->basetable;
	$field8->column = 'assignedto';
	$field8->columntype = 'VARCHAR(50)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O'; 
	$field8->setPicklistValues( Array ('Users', 'Groups'));
	$timesheetInformation->addField($field8); /** Creates the field and adds to block */

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
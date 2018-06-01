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
	$field1->uitype= 4;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$timesheetInformation->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'date';
	$field5->label = 'Day';
	$field5->table = $module->basetable;
	$field5->column = 'date';
	$field5->columntype = 'DATE';
	$field5->uitype = 5;
	$field5->typeofdata = 'D~O'; // varchar~Mandatory	
	$timesheetInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'description';
	$field6->label = 'Description';
	$field6->table = $module->basetable;
	$field6->column = 'description';
	$field6->columntype = 'TEXT';
	$field6->uitype = 19;
	$field6->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field6); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'timestart';
	$field7->label = 'In Time';
	$field7->table = $module->basetable;
	$field7->column = 'timestart';
	$field7->columntype = 'VARCHAR(50)';
	$field7->uitype = 2;
	$field7->typeofdata = 'T~M'; // varchar~Mandatory	
	$timesheetInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'timeend';
	$field8->label = 'Out Time';
	$field8->table = $module->basetable;
	$field8->column = 'timeend';
	$field8->columntype = 'VARCHAR(50)';
	$field8->uitype = 2;
	$field8->typeofdata = 'T~M'; // varchar~Mandatory	
	$timesheetInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'worked';
	$field9->label = 'Worked';
	$field9->table = $module->basetable;
	$field9->column = 'worked';
	$field9->columntype = 'DECIMAL(62,2)';
	$field9->uitype = 2;
	$field9->displaytype = 1;
	$field9->typeofdata = 'NN~O'; // varchar~Mandatory	
	$timesheetInformation->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'relatedto';
	$field10->label = 'Related To';
	$field10->table = $module->basetable;
	$field10->column = 'relatedto';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 10;
	$field10->typeofdata = 'V~O';
	$timesheetInformation->addField($field10); /** Creates the field and adds to block */
	$field10->setRelatedModules(Array('Contacts', 'Accounts','Leads', 'HelpDesk'));

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'total';
	$field11->label = 'Total';
	$field11->table = $module->basetable;
	$field11->column = 'total';
	$field11->columntype = 'DECIMAL(62,2)';
	$field11->uitype = 2;
	$field11->displaytype = 1;
	$field11->typeofdata = 'NN~O'; // varchar~Mandatory	
	$timesheetInformation->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'lock';
	$field12->label = 'Lock';
	$field12->table = $module->basetable;
	$field12->column = 'lock';
	$field12->columntype = 'varchar(1)';
	$field12->uitype = 56;
	$field12->displaytype = 1;
	$field12->typeofdata = 'NN~O'; // varchar~Mandatory	
	$timesheetInformation->addField($field12); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'tstype';
	$field13->label = 'Type';
	$field13->table = $module->basetable;
	$field13->column = 'tstype';
	$field13->columntype = 'varchar(50)';
	$field13->uitype = 15;
	$field13->displaytype = 1;
	$field13->typeofdata = 'V~M'; // varchar~Mandatory	
	$timesheetInformation->addField($field13); /** Creates the field and adds to block */
	$field13->setPicklistValues( Array ('Regular', 'Billable','Non-Billable', 'Overtime','Sick'));
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
	$timesheetInformation->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$timesheetInformation->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$timesheetInformation->addField($field4);


	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
	$module->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field5, 1)->addField($field6, 2)->addField($field7, 3);

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
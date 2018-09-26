<?php

/** Create New Vtlib script for module Creation
  * created : 22 Feb 2018
  * Author  : Jitendra Gupta <jitendraknp2004@gmail.com>
  */
/*error_reporting(1);
		ini_set('display_erros',1);
		 
		  register_shutdown_function('handleErrors');       
		    function handleErrors() { 
			 
		       $last_error = error_get_last(); 
		     	
		       if (!is_null($last_error)) { // if there has been an error at some point 
		     
			  // do something with the error 
			  print_r($last_error); 
		     
		       } 
		     
		    }*/
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
include_once('vtlib/Vtiger/Package.php');
include_once 'includes/main/WebUI.php';
include_once 'include/Webservices/Utils.php';

	$Vtiger_Utils_Log = true;
	global $adb;
	$adb->setDebug(true);



	$MODULENAME = 'Training'; //Give your module name
	$PARENT 	= 'Support';  //Give Parent name
	$ENTITYNAME = 'trainingno'; //Give Duplicate check field name
	$ENTITYLABEL= 'Training ID';

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
	$block->label = 'LBL_Attendance_Information';
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

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'attendanceday';
	$field2->label = 'Day';
	$field2->table = $module->basetable;
	$field2->column = 'attendanceday';	
	$field2->uitype = 15;
	$field2->typeofdata = 'V~M';
	$field2->setPicklistValues( Array ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
	$field2->iscustom	= 0;
	$block->addField($field2); /** Creates the field and adds to block */

	$field3 = new Vtiger_Field();
	$field3->name   =  'attendancedate';
	$field3->label  = 'Date';
	$field3->table  =  $module->basetable;
	$field3->column = 'attendancedate';
	$field3->columntype = 'DATE';
	$field3->uitype	= 5;
	$field3->typeofdata = 'D~M'; // varchar~Mandatory
	$block->addField($field3); /** table, column, label, set to default values */
	
	$field4 = new vtiger_field();
	$field4->label = 'Employee Name';
	$field4->name = 'relatedemployee';
	$field4->table = $module->basetable;
	$field4->column = 'relatedemployee';
	$field4->columntype = 'varchar(100)';
	$field4->uitype = 10;
	$field4->typeofdata = 'v~o';

	$block->addfield($field4);
	$field4->setrelatedmodules(array('Users')); 

	$field5 = new Vtiger_Field();
	$field5->name = 'timein';
	$field5->label = 'Time In';
	$field5->table = $module->basetable;
	$field5->column = 'timein';
	$field5->uitype = 2;
	$field5->typeofdata = 'T~M';
	$block->addField($field5);

	$field6 = new Vtiger_Field();
	$field6->name = 'timeout';
	$field6->label = 'Time Out';
	$field6->table = $module->basetable;
	$field6->column = 'timeout';
	$field6->uitype = 2;
	$field6->typeofdata = 'T~M';
	$block->addField($field6);

	$field7 = new Vtiger_Field();
	$field7->name = 'totalhours';
	$field7->label = 'Total Hours';
	$field7->table = $module->basetable;
	$field7->column = 'totalhours';
	$field7->uitype = 7;
	$field7->typeofdata = 'I~O';
	$block->addField($field7);	

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'description';
	$field8->label = 'Description';
	$field8->table = $module->basetable;
	$field8->column = 'description';
	$field8->columntype = 'VARCHAR(500)';
	$field8->uitype = 19;
	$field8->typeofdata = 'V~O';
	$field8->iscustom	= 0;
	$blockcf->addField($field8); /** Creates the field and adds to block */

	/**
		ADD YOUR FIELDS HERE
	*/

	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field21 = new Vtiger_Field();
	$field21->name = 'assigned_user_id';
	$field21->label = 'Assigned To';
	$field21->table = 'vtiger_crmentity';
	$field21->column = 'smownerid';
	$field21->uitype = 53;
	$field21->typeofdata = 'V~M';
	$block->addField($field21);

	$field31 = new Vtiger_Field();
	$field31->name = 'createdtime';
	$field31->label= 'Created Time';
	$field31->table = 'vtiger_crmentity';
	$field31->column = 'createdtime';
	$field31->uitype = 70;
	$field31->typeofdata = 'T~O';
	$field31->displaytype= 2;
	$block->addField($field31);

	$field41 = new Vtiger_Field();
	$field41->name = 'modifiedtime';
	$field41->label= 'Modified Time';
	$field41->table = 'vtiger_crmentity';
	$field41->column = 'modifiedtime';
	$field41->uitype = 70;
	$field41->typeofdata = 'T~O';
	$field41->displaytype= 2;
	$block->addField($field41);


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

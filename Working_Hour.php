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

	$MODULENAME = 'WorkingHours'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'whtitle'; //Give Duplicate check field name
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
	$blockworking = new Vtiger_Block();
	$blockworking->label = 'LBL_'.strtoupper($module->name).'_INFORMATION';
	$module->addBlock($blockworking);
	
	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 2;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$blockworking->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'day1';
	$field5->label = 'Day of the Week';
	$field5->table = $module->basetable;
	$field5->column = 'day1';
	$field5->columntype = 'VARCHAR(50)';
	$field5->uitype = 15;
	$field5->displaytype = 1;
	$field5->typeofdata = 'V~O'; // varchar~Mandatory
	$field5->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
	$blockworking->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'day2';
	$field51->label = 'Day of the Week';
	$field51->table = $module->basetable;
	$field51->column = 'day2';
	$field51->columntype = 'VARCHAR(50)';
	$field51->uitype = 15;
	$field51->displaytype = 1;
	$field51->typeofdata = 'V~O'; // varchar~Mandatory
	$field51->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field51); /** table and column are automatically set */

	

	
	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'whno';
	$field7->label = 'WH No';
	$field7->table = $module->basetable;
	$field7->column = 'whno';
	$field7->columntype = 'VARCHAR(100)';
	$field7->uitype = 4;
	$field7->typeofdata = 'V~M';
	$blockworking->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'day3';
	$field8->label = 'Day of the Week';
	$field8->table = $module->basetable;
	$field8->column = 'day3';
	$field8->columntype = 'VARCHAR(50)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->displaytype = 1;
	$field8->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'day4';
	$field9->label = 'Day of the Week';
	$field9->table = $module->basetable;
	$field9->column = 'day4';
	$field9->columntype = 'VARCHAR(50)';
	$field9->uitype = 15;
	$field9->displaytype = 1;
	$field9->typeofdata = 'V~O';
	$field9->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'day5';
	$field10->label = 'Day of the Week';
	$field10->table = $module->basetable;
	$field10->column = 'day5';
	$field10->columntype = 'VARCHAR(50)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O';
	$field10->displaytype = 1;
	$field10->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field10); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'day6';
	$field11->label = 'Day of the Week';
	$field11->table = $module->basetable;
	$field11->column = 'day6';
	$field11->columntype = 'VARCHAR(50)';
	$field11->uitype = 15;
	$field11->typeofdata = 'V~O';
	$field11->displaytype = 1;
	$field11->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'day7';
	$field12->label = 'Day of the Week';
	$field12->table = $module->basetable;
	$field12->column = 'day7';
	$field12->columntype = 'VARCHAR(50)';
	$field12->uitype = 15;
	$field12->typeofdata = 'V~O';
	$field12->displaytype = 1;
	$field12->setPicklistValues(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday','Saturday','Sunday'));
	$blockworking->addField($field12); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'wh_status';
	$field13->label = 'Status';
	$field13->table = $module->basetable;
	$field13->column = 'wh_status';
	$field13->columntype = 'CHAR(1)';
	$field13->uitype = 56;
	$field13->typeofdata = 'V~M';
	$field13->displaytype = 1;
	$blockworking->addField($field13); /** Creates the field and adds to block */

        	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'relatedrole';
	$field14->label = 'Related To';
	$field14->table = $module->basetable;
	$field14->column = 'relatedrole';
	$field14->columntype = 'VARCHAR(255)';
	$field14->uitype = 98;
	$field14->typeofdata = 'V~M';
	$blockworking->addField($field14); /** Creates the field and adds to block */



	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$blockworking->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$blockworking->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$blockworking->addField($field4);


	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
	$module->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field7, 1)->addField($field2, 2);

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
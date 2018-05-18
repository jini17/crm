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

	$MODULENAME = 'EmployeeContract'; //Give your module name
	$PARENT 	= 'Support';  //Give Parent name
	$ENTITYNAME = 'employeeno'; //Give Duplicate check field name
	$ENTITYLABEL= 'Employee No';

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
	$block->label = 'LBL_Employment_Contract_Information';
	$module->addBlock($block);

	$blockcf = new Vtiger_Block();
	$blockcf->label = 'LBL_Salary_Tracking';
	$module->addBlock($blockcf);

	$blockbf = new Vtiger_Block();
	$blockbf->label = 'LBL_Benefits';
	$module->addBlock($blockbf);


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
	$field5->name = 'interview_date';
	$field5->label = 'Date Interviewed';
	$field5->table = $module->basetable;
	$field5->column = 'interview_date';
	$field5->columntype = 'DATE';
	$field5->uitype = 5;
	$field5->displaytype = 1;
	$field5->typeofdata = 'D~O'; // varchar~Mandatory
	$block->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'date_joined';
	$field51->label = 'Date Joined';
	$field51->table = $module->basetable;
	$field51->column = 'date_joined';
	$field51->columntype = 'DATE';
	$field51->uitype = 5;
	$field51->displaytype = 1;
	$field51->typeofdata = 'D~O'; // varchar~Mandatory
	$block->addField($field51); /** table and column are automatically set */

	$field6 = new Vtiger_Field();
	$field6->name   =  'designation';
	$field6->label  = 'Designation';
	$field6->table  =  $module->basetable;
	$field6->column = 'designation';
	$field6->columntype = 'VARCHAR(100)';
	$field6->uitype	= 1;
	$field6->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field6); /** table, column, label, set to default values */
	
	$field7 = new Vtiger_Field();
	$field7->name   =  'job_grade';
	$field7->label  = 'Job Grade';
	$field7->table  =  $module->basetable;
	$field7->column = 'job_grade';
	$field7->columntype = 'VARCHAR(50)';
	$field7->uitype	= 2;
	$field7->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field7); /** table, column, label, set to default values */

	$field8 = new Vtiger_Field();
	$field8->name   =  'starting_sal';
	$field8->label  = 'Starting Salary';
	$field8->table  =  $module->basetable;
	$field8->column = 'starting_sal';
	$field8->columntype = 'VARCHAR(50)';
	$field8->uitype	= 2;
	$field8->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field8); /** table, column, label, set to default values */
	
	$field9 = new Vtiger_Field();
	$field9->name   =  'letter_of_appointment';
	$field9->label  = 'Letter of Appointment (upload)';
	$field9->table  =  $module->basetable;
	$field9->column = 'letter_of_appointment';
	$field9->columntype = 'varchar(255)';
	$field9->uitype	= 69;
	$field9->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field9); /** table, column, label, set to default values */

	$field10 = new Vtiger_Field();
	$field10->name   =  'reports_to';
	$field10->label  = 'Reports To';
	$field10->table  =  $module->basetable;
	$field10->column = 'reports_to';
	$field10->columntype = 'varchar(100)';
	$field10->uitype	= 101;
	$field10->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field10); /** table, column, label, set to default values */


	$field11 = new Vtiger_Field();
	$field11->name   =  'job_location';
	$field11->label  = 'Location';
	$field11->table  =  $module->basetable;
	$field11->column = 'job_location';
	$field11->columntype = 'varchar(100)';
	$field11->uitype	= 15;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory
	$field11->setPicklistValues( Array ('Surat', 'Vadodara','Jaipur'));
	$block->addField($field11); /** table, column, label, set to default values */

	$field12 = new Vtiger_Field();
	$field12->name   =  'department';
	$field12->label  = 'Department';
	$field12->table  =  $module->basetable;
	$field12->column = 'department';
	$field12->columntype = 'VARCHAR(150)';
	$field12->uitype	= 1;
	$field12->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field12); /** table, column, label, set to default values */


	$field14 = new Vtiger_Field();
	$field14->name   =  'review_date';
	$field14->label  = 'Date Join / Review';
	$field14->table  =  $module->basetable;
	$field14->column = 'review_date';
	$field14->columntype = 'DATE';
	$field14->uitype	= 5;
	$field14->typeofdata = 'D~O'; // varchar~Mandatory
	$blockcf->addField($field14); /** table, column, label, set to default values */

	$field15 = new Vtiger_Field();
	$field15->name   =  'amount_approved';
	$field15->label  = 'Amount Approved';
	$field15->table  =  $module->basetable;
	$field15->column = 'amount_approved';
	$field15->columntype = 'Decimal(25,2)';
	$field15->uitype	= 71;
	$field15->typeofdata = 'V~O'; // varchar~Mandatory
	$blockcf->addField($field15); /** table, column, label, set to default values */

	$field16 = new Vtiger_Field();
	$field16->name   =  'next_review_date';
	$field16->label  = 'Next Date Salary Adjustment';
	$field16->table  =  $module->basetable;
	$field16->column = 'next_review_date';
	$field16->columntype = 'DATE';
	$field16->uitype	= 5;
	$field16->typeofdata = 'D~O'; // varchar~Mandatory
	$blockcf->addField($field16); /** table, column, label, set to default values */


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
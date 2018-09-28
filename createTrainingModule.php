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

	$blockTraining = new Vtiger_Block();
	$blockTraining->label = 'LBL_'. strtoupper($module->name) . '_INFORMATION';
	$module->addBlock($blockTraining);

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
	$field1->iscustom	= 0;
	$blockTraining->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	/**
		ADD YOUR FIELDS HERE
	**/
	
	$field2 = new Vtiger_Field();
	$field2->name = 'start_date';
	$field2->label = 'Start Date';
	$field2->table = $module->basetable;
	$field2->column = 'start_date';
	$field2->columntype = 'DATE';
	$field2->uitype = 5;
	$field2->typeofdata = 'D~M'; // date~Mandatory
	$field2->iscustom	= 0;
	$blockTraining->addField($field2); /** table and column are automatically set */

	$field25 = new Vtiger_Field();
	$field25->name = 'trainingname';
	$field25->label = 'Training Name';
	$field25->table = $module->basetable;
	$field25->column = 'trainingname';
	$field25->columntype = 'VARCHAR(255)';
	$field25->uitype = 2;
	$field25->typeofdata = 'V~M'; // date~Mandatory
	$field25->iscustom	= 0;
	$blockTraining->addField($field25); /** table and column are automatically set */

	$field3 = new Vtiger_Field();
	$field3->name   =  'location';
	$field3->label  = 'Location';
	$field3->table  =  $module->basetable;
	$field3->column = 'location';
	$field3->columntype = 'VARCHAR(255)';
	$field3->uitype	= 2;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory
	$field3->iscustom	= 0;
	$blockTraining->addField($field3); /** table, column, label, set to default values */
	
	/** Common fields that should be in every module,
	 	linked to vtiger CRM core table
	*/
	$field4 = new Vtiger_Field();
	$field4->name = 'end_date';
	$field4->label = 'End Date';
	$field4->table = $module->basetable;
	$field4->column = 'end_date';
	$field4->columntype = 'DATE';
	$field4->uitype = 5;
	$field4->typeofdata = 'D~M'; // date~Mandatory
	$field4->iscustom	= 0;
	$blockTraining->addField($field4);

	$field5 = new Vtiger_Field();
	$field5->name = 'instructor';
	$field5->label= 'Instructor';
	$field5->table = $module->basetable;
	$field5->column = 'instructor';
	$field5->uitype = 2;
	$field5->typeofdata = 'V~O';	
	$field5->iscustom	= 0;
	$blockTraining->addField($field5);


	$field6 = new Vtiger_Field();
	$field6->name = 'trainingstatus';
	$field6->label= 'Status';
	$field6->table = $module->basetable;
	$field6->column = 'trainingstatus';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O';
	$field6->iscustom	= 0;
	$field6->setPicklistValues( Array ('Planned', 'Active', 'Held', 'Cancelled'));
	$blockTraining->addField($field6);

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'description';
	$field7->label = 'Description';
	$field7->table = $module->basetable;
	$field7->column = 'description';
	$field7->columntype = 'VARCHAR(500)';
	$field7->uitype = 19;
	$field7->typeofdata = 'V~O';
	$field7->iscustom	= 0;
	$blockcf->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'trainingtype';
	$field8->label = 'Training Type';
	$field8->table = $module->basetable;
	$field8->column = 'trainingtype';	
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->setPicklistValues( Array ('JPJ Training', 'Local Training', 'International training'));
	$field8->iscustom	= 0;
	$blockTraining->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field81 = new Vtiger_Field();
	$field81->name = 'modeoftraining';
	$field81->label = 'Mode of Training';
	$field81->table = $module->basetable;
	$field81->column = 'modeoftraining';	
	$field81->uitype = 15;
	$field81->typeofdata = 'V~O';
	$field81->setPicklistValues( Array ('Live Classes', 'Individual Classes'));
	$field81->iscustom	= 0;
	$blockTraining->addField($field81); /** Creates the field and adds to block */



	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field9 = new Vtiger_Field();
	$field9->name = 'assigned_user_id';
	$field9->label = 'Assigned To';
	$field9->table = 'vtiger_crmentity';
	$field9->column = 'smownerid';
	$field9->uitype = 53;
	$field9->typeofdata = 'V~M';
	$field9->iscustom	= 0;
	$blockTraining->addField($field9);

	$field10 = new Vtiger_Field();
	$field10->name = 'createdtime';
	$field10->label= 'Created Time';
	$field10->table = 'vtiger_crmentity';
	$field10->column = 'createdtime';
	$field10->uitype = 70;
	$field10->typeofdata = 'T~O';
	$field10->displaytype= 2;
	$field10->iscustom	= 0;
	$blockTraining->addField($field10);

	$field11 = new Vtiger_Field();
	$field11->name = 'modifiedtime';
	$field11->label= 'Modified Time';
	$field11->table = 'vtiger_crmentity';
	$field11->column = 'modifiedtime';
	$field11->uitype = 70;
	$field11->typeofdata = 'T~O';
	$field11->displaytype= 2;
	$field11->iscustom	= 0;
	$blockTraining->addField($field11);


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
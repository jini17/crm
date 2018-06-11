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

	$MODULENAME = 'Performance'; //Give your module name
	$PARENT 	= 'Support';  //Give Parent name
	
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
	$block->label = 'LBL_PERFORMANCE_REVIEW';
	$module->addBlock($block);

	$blockcf = new Vtiger_Block();
	$blockcf->label = 'LBL_SKILLS_EVALUATED';
	$module->addBlock($blockcf);

	$blockbf = new Vtiger_Block();
	$blockbf->label = 'LBL_TOTAL_PERFORMANCE_RATING';
	$module->addBlock($blockbf);


	$field1 = new Vtiger_Field();
	$field1->name = 'yearly_review';
	$field1->label = 'Yearly Review';
	$field1->table = $module->basetable;
	$field1->column = 'yearly_review';
	$field1->columntype = 'text';
	$field1->uitype = 21;
	$field1->typeofdata = 'V~O';
	$block->addField($field1);

	
	$field2 = new Vtiger_Field();
	$field2->name = 'quarterly_review';
	$field2->label = 'Quarterly Review';
	$field2->table = $module->basetable;
	$field2->column = 'quarterly_review';
	$field2->columntype = 'text';
	$field2->uitype = 21;
	$field2->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field2); /** table and column are automatically set */

	$field3 = new Vtiger_Field();
	$field3->name   =  'upgrading_review';
	$field3->label  = 'Upgrading Review';
	$field3->table  =  $module->basetable;
	$field3->column = 'upgrading_review';
	$field3->columntype = 'text';
	$field3->uitype	= 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory
	$block->addField($field3); /** table and column are automatically set */

	$field4 = new Vtiger_Field();
	$field4->name = 'merit_review';
	$field4->label = 'Merit Review';
	$field4->table = $module->basetable;
	$field4->column = 'merit_review';
	$field4->uitype = 21;
	$field4->typeofdata = 'V~O';
	$block->addField($field4); /** table, column, label, set to default values */
	
	$field7 = new Vtiger_Field();
	$field7->name = 'work_competency';
	$field7->label = 'Work Competency';
	$field7->table = $module->basetable;
	$field7->column = 'work_competency';
	$field7->columntype = 'VARCHAR(255)';
	$field7->uitype = 15;
	$field7->typeofdata = 'V~O';
	$field7->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockcf->addField($field7); /** Creates the field and adds to block */

	$field8 = new Vtiger_Field();
	$field8->name = 'communication';
	$field8->label = 'Communication';
	$field8->table = $module->basetable;
	$field8->column = 'communication';
	$field8->columntype = 'VARCHAR(255)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockcf->addField($field8); /** table, column, label, set to default values */
	
	$field9 = new Vtiger_Field();
	$field9->name = 'responsibility';
	$field9->label = 'Responsibility';
	$field9->table = $module->basetable;
	$field9->column = 'responsibility';
	$field9->columntype = 'VARCHAR(255)';
	$field9->uitype = 15;
	$field9->typeofdata = 'V~O';
	$field9->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockcf->addField($field9); /** table, column, label, set to default values */

	$field10 = new Vtiger_Field();
	$field10->name = 'attitude';
	$field10->label = 'Attitude';
	$field10->table = $module->basetable;
	$field10->column = 'attitude';
	$field10->columntype = 'VARCHAR(255)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O';
	$field10->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockcf->addField($field10); /** table, column, label, set to default values */


	$field11 = new Vtiger_Field();
	$field11->name = 'teamwork';
	$field11->label = 'Team Work';
	$field11->table = $module->basetable;
	$field11->column = 'teamwork';
	$field11->columntype = 'VARCHAR(255)';
	$field11->uitype = 15;
	$field11->typeofdata = 'V~O';
	$field10->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockcf->addField($field10); /** table, column, label, set to default values */

	$field13 = new Vtiger_Field();
	$field13->name = 'employee_remarks';
	$field13->label = 'Employee Remarks:';
	$field13->table = $module->basetable;
	$field13->column = 'employee_remarks';
	$field13->columntype = 'text';
	$field13->uitype =  	21;
	$field13->typeofdata = 'V~O';
	$blockbf->addField($field13); /** table, column, label, set to default values */


	$field14 = new Vtiger_Field();
	$field14->name = 'superior_remarks';
	$field14->label = 'Superior Remarks:';
	$field14->table = $module->basetable;
	$field14->column = 'superior_remarks';
	$field14->columntype = 'text';
	$field14->uitype = 21;
	$field14->typeofdata = 'V~O';
	$blockbf->addField($field14); /** table, column, label, set to default values */

	$field15 = new Vtiger_Field();
	$field15->name = 'date_reviewed';
	$field15->label = 'Date Reviewed :';
	$field15->table = $module->basetable;
	$field15->column = 'date_reviewed';
	$field15->columntype = 'DATE';
	$field15->uitype = 5;
	$field15->typeofdata = 'D~O';
	$blockbf->addField($field15); /** table, column, label, set to default values */



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
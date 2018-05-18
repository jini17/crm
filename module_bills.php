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

	$MODULENAME = 'Bills'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'billtitle'; //Give Duplicate check field name
	$ENTITYLABEL= 'Bill Title';

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
	$blockBills = new Vtiger_Block();
	$blockBills->label = 'LBL_'.strtoupper($moduleInstance->name).'_INFORMATION';
	$module->addBlock($blockBills);
	
	$blockReminderDetails = new Vtiger_Block();
	$blockReminderDetails->label = 'Reminder Details';
	$module->addBlock($blockReminderDetails);
	
	$blockRemarksInformation = new Vtiger_Block();
	$blockRemarksInformation->label = 'Remarks Information';
	$module->addBlock($blockRemarksInformation);

	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 2;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$blockBills->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'amount';
	$field5->label = 'Estimated Amount(RM)';
	$field5->table = $module->basetable;
	$field5->column = 'amount';
	$field5->columntype = 'DECIMAL(62,2)';
	$field5->uitype = 1;
	$field5->displaytype = 1;
	$field5->typeofdata = 'NN~M'; // varchar~Mandatory
	$blockBills->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'bill_type';
	$field51->label = 'Bill Type';
	$field51->table = $module->basetable;
	$field51->column = 'bill_type';
	$field51->columntype = 'VARCHAR(100)';
	$field51->uitype = 15;
	$field51->displaytype = 1;
	$field51->typeofdata = 'V~M'; // varchar~Mandatory
	$field51->setPicklistValues( Array ('Electricity', 'Primary Phone','Internet','Water','Utilities') );
	$blockBills->addField($field51); /** table and column are automatically set */

	

	
	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'billno';
	$field7->label = 'Bill No';
	$field7->table = $module->basetable;
	$field7->column = 'billno';
	$field7->columntype = 'VARCHAR(100)';
	$field7->uitype = 4;
	$field7->typeofdata = 'V~M';
	$blockBills->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'billaccountno';
	$field8->label = 'Bill Account Number';
	$field8->table = $module->basetable;
	$field8->column = 'billaccountno';
	$field8->columntype = 'VARCHAR(100)';
	$field8->uitype = 2;
	$field8->typeofdata = 'V~O';
	$blockBills->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'billrefno';
	$field9->label = 'Bill Reference Number';
	$field9->table = $module->basetable;
	$field9->column = 'billrefno';
	$field9->columntype = 'VARCHAR(100)';
	$field9->uitype = 2;
	$field9->typeofdata = 'V~O';
	$blockBills->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	/*$field10 = new Vtiger_Field();
	$field10->name = 'company_details';
	$field10->label = 'Company Details';
	$field10->table = $module->basetable;
	$field10->column = 'company_details';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 3993;
	$field10->typeofdata = 'V~O';
	$blockBills->addField($field10); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'billstatus';
	$field11->label = 'Bill Status';
	$field11->table = $module->basetable;
	$field11->column = 'billstatus';
	$field11->columntype = 'VARCHAR(255)';
	$field11->uitype = 15;
	$field11->typeofdata = 'V~O';
	$field11->setPicklistValues( Array ('Active', 'Inactive') );
	$blockBills->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'duedate';
	$field12->label = 'Due Date';
	$field12->table = $module->basetable;
	$field12->column = 'duedate';
	$field12->columntype = 'DATE';
	$field12->uitype = 5;
	$field12->typeofdata = 'D~O';
	$blockReminderDetails->addField($field12); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'autocreatepayment';
	$field13->label = 'Want Auto Create Payment Record?';
	$field13->table = $module->basetable;
	$field13->column = 'autocreatepayment';
	$field13->columntype = 'CHAR(1)';
	$field13->uitype = 56;
	$field13->typeofdata = 'V~O';
	$blockReminderDetails->addField($field13); /** Creates the field and adds to block */

        	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'billreminderbefore';
	$field14->label = 'Reminder (before due date)';
	$field14->table = $module->basetable;
	$field14->column = 'billreminderbefore';
	$field14->columntype = 'VARCHAR(50)';
	$field14->uitype = 15;
	$field14->typeofdata = 'V~O';
	$field14->setPicklistValues( Array ('1 week', '2 weeks', '1 month') );
	$blockReminderDetails->addField($field14); /** Creates the field and adds to block */

        /** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'remarks';
	$field15->label = 'Remarks';
	$field15->table = $module->basetable;
	$field15->column = 'remarks';
	$field15->columntype = 'VARCHAR(255)';
	$field15->uitype = 19;
	$field15->typeofdata = 'V~O';
	$blockRemarksInformation->addField($field15); /** Creates the field and adds to block */
	


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$blockBills->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$blockBills->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$blockBills->addField($field4);


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
	$accList = Vtiger_Module::getInstance('Bills');
	$accList->setRelatedList(Vtiger_Module::getInstance('Payments'), 'Payments',Array('ADD'),'get_dependents_list');

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
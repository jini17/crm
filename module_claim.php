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

	$MODULENAME = 'Claim'; //Give your module name
	$PARENT 	= 'Sales';  //Give Parent name
	$ENTITYNAME = 'claimtitle'; //Give Duplicate check field name
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
	$expenseInformation = new Vtiger_Block();
	$expenseInformation->label = 'Expense Information';
	$module->addBlock($expenseInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$module->addBlock($description);

	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'claimno';
	$field1->label = 'Claim No ';
	$field1->table = $module->basetable;
	$field1->column = 'claimno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 4;
	$field1->typeofdata = 'V~M';
	$expenseInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$module->setEntityIdentifier($field1);


	
	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'category';
	$field2->label = 'Category';
	$field2->table = $module->basetable;
	$field2->column = 'category';
	$field2->columntype = 'VARCHAR(50)';
	$field2->uitype = 10;
	$field2->typeofdata = 'V~M';
	$expenseInformation->addField($field2); /** Creates the field and adds to block */
	$field2->setRelatedModules(Array('ClaimType'));

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'transactiondate';
	$field3->label = 'Transaction Date';
	$field3->table = $module->basetable;
	$field3->column = 'transactiondate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$expenseInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'description';
	$field4->label = 'Description';
	$field4->table = $module->basetable;
	$field4->column = 'description';
	$field4->columntype = 'TEXT';
	$field4->uitype = 19;
	$field4->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field4); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'totalamount';
	$field5->label = 'Total Amount';
	$field5->table = $module->basetable;
	$field5->column = 'totalamount';
	$field5->columntype = 'DECIMAL(62,2)';
	$field5->uitype = 71;
	$field5->displaytype = 1;
	$field5->typeofdata = 'NN~M'; // varchar~Mandatory	
	$expenseInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'claim_status';
	$field6->label = 'Status';
	$field6->table = $module->basetable;
	$field6->column = 'claim_status';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('Apply', 'Approved', 'Rejected'));
	$expenseInformation->addField($field6); /** Creates the field and adds to block */



	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'taxinvoice';
	$field7->label = 'Tax Invoice / Receipt No';

	$field7->table = $module->basetable;
	$field7->column = 'taxinvoice';
	$field7->columntype = 'VARCHAR(70)';
	$field7->uitype = 1;
	$field7->typeofdata = 'V~O';
	$expenseInformation->addField($field7); 
	/** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'attachment';
	$field8->label = 'Attachments';
	$field8->table = $module->basetable;
	$field8->column = 'attachment';
	$field8->columntype = 'VARCHAR(200)';
	$field8->uitype = 28;
	$field8->typeofdata = 'V~O';
	$expenseInformation->addField($field8); 
	/** Creates the field and adds to block */

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
	$expenseInformation->addField($field21);

	$field31 = new Vtiger_Field();
	$field31->name = 'createdtime';
	$field31->label= 'Created Time';
	$field31->table = 'vtiger_crmentity';
	$field31->column = 'createdtime';
	$field31->uitype = 70;
	$field31->typeofdata = 'T~O';
	$field31->displaytype= 2;
	$expenseInformation->addField($field31);

	$field41 = new Vtiger_Field();
	$field41->name = 'modifiedtime';
	$field41->label= 'Modified Time';
	$field41->table = 'vtiger_crmentity';
	$field41->column = 'modifiedtime';
	$field41->uitype = 70;
	$field41->typeofdata = 'T~O';
	$field41->displaytype= 2;
	$expenseInformation->addField($field41);


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
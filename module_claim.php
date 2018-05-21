<?php
<<<<<<< HEAD
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Claim';

// Create module instance and save it first
$moduleInstance = Vtiger_Module::getInstance($MODULENAME);
/*if ($moduleInstance || file_exists('modules/'.$MODULENAME)) {
        echo $MODULENAME." Module already present - choose a different name.";
} else {*/
        $moduleInstance = new Vtiger_Module();
        $moduleInstance->name = $MODULENAME;
        $moduleInstance->parent= 'Sales';
        $moduleInstance->save();

	// Webservice Setup
	$moduleInstance->initWebservice();
	
	// Schema Setup
    $moduleInstance->initTables();
=======

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
>>>>>>> Development

	// Add the basic module block
	$expenseInformation = new Vtiger_Block();
	$expenseInformation->label = 'Expense Information';
<<<<<<< HEAD
	$moduleInstance->addBlock($expenseInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$moduleInstance->addBlock($description);
=======
	$module->addBlock($expenseInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$module->addBlock($description);
>>>>>>> Development

	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'claimno';
	$field1->label = 'Claim No ';
<<<<<<< HEAD
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'claimno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
=======
	$field1->table = $module->basetable;
	$field1->column = 'claimno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 4;
>>>>>>> Development
	$field1->typeofdata = 'V~M';
	$expenseInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
<<<<<<< HEAD
	$moduleInstance->setEntityIdentifier($field1);
=======
	$module->setEntityIdentifier($field1);
>>>>>>> Development

	
	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'category';
	$field2->label = 'Category';
<<<<<<< HEAD
	$field2->table = $moduleInstance->basetable;
=======
	$field2->table = $module->basetable;
>>>>>>> Development
	$field2->column = 'category';
	$field2->columntype = 'VARCHAR(50)';
	$field2->uitype = 15;
	$field2->typeofdata = 'V~M';
	$field2->setPicklistValues( Array ('Option 1', 'Option 2'));
	$expenseInformation->addField($field2); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'transactiondate';
	$field3->label = 'Transaction Date';
<<<<<<< HEAD
	$field3->table = $moduleInstance->basetable;
=======
	$field3->table = $module->basetable;
>>>>>>> Development
	$field3->column = 'transactiondate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$expenseInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'description';
	$field4->label = 'Description';
<<<<<<< HEAD
	$field4->table = $moduleInstance->basetable;
=======
	$field4->table = $module->basetable;
>>>>>>> Development
	$field4->column = 'description';
	$field4->columntype = 'TEXT';
	$field4->uitype = 21;
	$field4->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field4); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'totalamount';
	$field5->label = 'Total Amount';
<<<<<<< HEAD
	$field5->table = $moduleInstance->basetable;
=======
	$field5->table = $module->basetable;
>>>>>>> Development
	$field5->column = 'totalamount';
	$field5->columntype = 'DECIMAL(62,2)';
	$field5->uitype = 1;
	$field5->displaytype = 1;
	$field5->typeofdata = 'NN~M'; // varchar~Mandatory	
	$expenseInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
<<<<<<< HEAD
	$field6->name = 'status';
	$field6->label = 'Status';
	$field6->table = $moduleInstance->basetable;
	$field6->column = 'status';
=======
	$field6->name = 'claim_status';
	$field6->label = 'Status';
	$field6->table = $module->basetable;
	$field6->column = 'claim_status';
>>>>>>> Development
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('Apply', 'Approved', 'Rejected'));
	$expenseInformation->addField($field6); /** Creates the field and adds to block */

<<<<<<< HEAD
=======
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


>>>>>>> Development
	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
<<<<<<< HEAD
	$moduleInstance->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field2, 1)->addField($field3, 2);
	
	// Create one more filter
	$filter2 = new Vtiger_Filter();
	$filter2->name = 'All2';
	$moduleInstance->addFilter($filter2);

	// Add fields to the filter
	$filter2->addField($field1);
	$filter2->addField($field2, 1);
	// Add rule to the filter field
	$filter2->addRule($field1, 'CONTAINS', 'Test');

	/** Enable and Disable available tools */
	$moduleInstance->enableTools(Array('Import', 'Export'));
	$moduleInstance->disableTools('Merge');
	
	//$moduleInstance->addLink('DETAILVIEWBASIC', 'LBL_SURVEY_REPORT', 'index.php?module=Survey&view=result&record=$RECORD$');

	$moduleInstance->setDefaultSharing();
	//mkdir('modules/'.$MODULENAME);
	//chmod('modules/'.$MODULENAME,0777);
        echo "OK\n";
	//$moduleInstance=null;
//}
=======
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

	
>>>>>>> Development
?>
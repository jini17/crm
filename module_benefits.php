u<?php
<<<<<<< HEAD
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Benefits';

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

	$MODULENAME = 'Benefits'; //Give your module name
	$PARENT 	= 'Sales';  //Give Parent name
	$ENTITYNAME = 'benefitstitle'; //Give Duplicate check field name
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
	$benefitsInformation = new Vtiger_Block();
	$benefitsInformation->label = 'Benefits Information';
<<<<<<< HEAD
	$moduleInstance->addBlock($benefitsInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$moduleInstance->addBlock($description);

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'benefits';
	$field1->label = 'Benefits';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'benefits';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
=======
	$module->addBlock($benefitsInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$module->addBlock($description);


	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'benefitsno';
	$field1->label = 'Benefits No';
	$field1->table = $module->basetable;
	$field1->column = 'benefitsno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 4;
>>>>>>> Development
	$field1->typeofdata = 'V~M';
	$benefitsInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
<<<<<<< HEAD
	$moduleInstance->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'status';
	$field2->label = 'Status';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'status';
	$field2->columntype = 'VARCHAR(3)';
	$field2->uitype = 56;
	$field2->typeofdata = 'C~M'; // varchar~Mandatory	
=======
	$module->setEntityIdentifier($field1);
	
	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'benefits';
	$field2->label = 'Benefits';
	$field2->table = $module->basetable;
	$field2->column = 'benefits';
	$field2->columntype = 'VARCHAR(255)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M';
>>>>>>> Development
	$benefitsInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
<<<<<<< HEAD
	$field3->name = 'description';
	$field3->label = 'Description';
	$field3->table = $moduleInstance->basetable;
	$field3->column = 'description';
	$field3->columntype = 'TEXT';
	$field3->uitype = 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field3); /** Creates the field and adds to block */
=======
	$field3->name = 'benefits_status';
	$field3->label = 'Status';
	$field3->table = $module->basetable;
	$field3->column = 'benefits_status';
	$field3->columntype = 'VARCHAR(3)';
	$field3->uitype = 56;
	$field3->typeofdata = 'C~M'; // varchar~Mandatory	
	$benefitsInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'description';
	$field4->label = 'Description';
	$field4->table = $module->basetable;
	$field4->column = 'description';
	$field4->columntype = 'TEXT';
	$field4->uitype = 21;
	$field4->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field4); /** Creates the field and adds to block */


	/**
		ADD YOUR FIELDS HERE
	*/


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field5 = new Vtiger_Field();
	$field5->name = 'assigned_user_id';
	$field5->label = 'Assigned To';
	$field5->table = 'vtiger_crmentity';
	$field5->column = 'smownerid';
	$field5->uitype = 53;
	$field5->typeofdata = 'V~M';
	$benefitsInformation->addField($field5);

	$field6 = new Vtiger_Field();
	$field6->name = 'createdtime';
	$field6->label= 'Created Time';
	$field6->table = 'vtiger_crmentity';
	$field6->column = 'createdtime';
	$field6->uitype = 70;
	$field6->typeofdata = 'T~O';
	$field6->displaytype= 2;
	$benefitsInformation->addField($field6);

	$field7 = new Vtiger_Field();
	$field7->name = 'modifiedtime';
	$field7->label= 'Modified Time';
	$field7->table = 'vtiger_crmentity';
	$field7->column = 'modifiedtime';
	$field7->uitype = 70;
	$field7->typeofdata = 'T~O';
	$field7->displaytype= 2;
	$benefitsInformation->addField($field7);
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
?>
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

	
?>
>>>>>>> Development

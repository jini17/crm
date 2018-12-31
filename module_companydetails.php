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

	$MODULENAME = 'OrganizationDetails'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'organization_no'; //Give Duplicate check field name
	$ENTITYLABEL= 'Organization No';

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
	$block1 = new Vtiger_Block();
	$block1->label = 'LBL_'.strtoupper($module->name).'_INFORMATION';
	$module->addBlock($block1);
	
	// Add the basic module block
	$block2 = new Vtiger_Block();
	$block2->label = 'LBL_IMAGE_INFORMATION';
	$module->addBlock($block2);
	
	
	
	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 4;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$block1->addField($field1);
	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'organization_title';
	$field5->label = 'Company Title';
	$field5->table = $module->basetable;
	$field5->column = 'organization_title';
	$field5->columntype = 'varchar(255)';
	$field5->uitype = 2;
	$field5->displaytype = 1;
	$field5->typeofdata = 'V~M'; // varchar~Mandatory
	$block1->addField($field5); /** table and column are automatically set */

	

	$field51 = new Vtiger_Field();
	$field51->name = 'organizationname';
	$field51->label = 'Company Name';
	$field51->table = $module->basetable;
	$field51->column = 'organizationname';
	$field51->columntype = 'varchar(60)';
	$field51->uitype = 1;
	$field51->displaytype = 1;
	$field51->typeofdata = 'V~M'; // varchar~Mandatory
	$block1->addField($field51); /** table and column are automatically set */
	
	
	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'address';
	$field7->label = 'Company Address';
	$field7->table = $module->basetable;
	$field7->column = 'address';
	$field7->columntype = 'VARCHAR(150)';
	$field7->uitype = 21;
	$field7->typeofdata = 'V~O';
	$block1->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'city';
	$field8->label = 'City';
	$field8->table = $module->basetable;
	$field8->column = 'city';
	$field8->columntype = 'VARCHAR(100)';
	$field8->uitype = 1;
	$field8->typeofdata = 'V~O';
	$block1->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'state';
	$field9->label = 'State';
	$field9->table = $module->basetable;
	$field9->column = 'state';
	$field9->columntype = 'VARCHAR(100)';
	$field9->uitype = 1;
	$field9->typeofdata = 'V~O';
	$block1->addField($field9); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'country';
	$field10->label = 'Country';
	$field10->table = $module->basetable;
	$field10->column = 'country';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 1;
	$field10->typeofdata = 'V~O';
	$block1->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'code';
	$field11->label = 'Postal Code';
	$field11->table = $module->basetable;
	$field11->column = 'code';
	$field11->columntype = 'VARCHAR(30)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O';
	$block1->addField($field11); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'phone';
	$field12->label = 'Contact No';
	$field12->table = $module->basetable;
	$field12->column = 'phone';
	$field12->columntype = 'VARCHAR(30)';
	$field12->uitype = 11;
	$field12->typeofdata = 'V~O';
	$block1->addField($field12); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'fax';
	$field13->label = 'Fax No';
	$field13->table = $module->basetable;
	$field13->column = 'fax';
	$field13->columntype = 'VARCHAR(30)';
	$field13->uitype = 11;
	$field13->typeofdata = 'V~O';
	$block1->addField($field13); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'website';
	$field14->label = 'Website';
	$field14->table = $module->basetable;
	$field14->column = 'website';
	$field14->columntype = 'VARCHAR(100)';
	$field14->uitype = 17;
	$field14->typeofdata = 'V~O';
	$block1->addField($field14); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'vatid';
	$field15->label = 'Vat/Tin No';
	$field15->table = $module->basetable;
	$field15->column = 'vatid';
	$field15->columntype = 'VARCHAR(100)';
	$field15->uitype = 	1;
	$field15->typeofdata = 'V~O';
	$block1->addField($field15); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field16 = new Vtiger_Field();
	$field16->name = 'logoname';
	$field16->label = 'Logo';
	$field16->table = $module->basetable;
	$field16->column = 'logoname';
	$field16->columntype = 'VARCHAR(100)';
	$field16->uitype = 	69;
	$field16->typeofdata = 'V~O';
	$block2->addField($field16); /** Creates the field and adds to block */

	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$block1->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Date';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$block1->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$field4->iscustom	= 0;
	$block1->addField($field4);

	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
	$module->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field5, 1)->addField($field51, 2)->addField($field7, 2)->addField($field8, 2)->addField($field9, 2);

	// Set sharing access of this module
	$module->setDefaultSharing();

	// Enable and Disable available tools
	$module->enableTools(Array('Export'));

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
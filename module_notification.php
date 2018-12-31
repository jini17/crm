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

	$MODULENAME = 'Notifications'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'notifyno'; //Give Duplicate check field name
	$ENTITYLABEL= 'Notification No';

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
	$blockNotification = new Vtiger_Block();
	$blockNotification->label = 'LBL_'.strtoupper($module->name).'_INFORMATION';
	$module->addBlock($blockNotification);
	
	
	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 4;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$blockNotification->addField($field1);
	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'notifyto';
	$field5->label = 'Notify To';
	$field5->table = $module->basetable;
	$field5->column = 'notifyto';
	$field5->columntype = 'int(11)';
	$field5->uitype = 101;
	$field5->displaytype = 3;
	$field5->typeofdata = 'NN~M'; // varchar~Mandatory
	$blockNotification->addField($field5); /** table and column are automatically set */

	

	/*$field51 = new Vtiger_Field();
	$field51->name = 'notifyby';
	$field51->label = 'Notify By';
	$field51->table = $module->basetable;
	$field51->column = 'notifyby';
	$field51->columntype = 'int(11)';
	$field51->uitype = 101;
	$field51->displaytype = 3;
	$field51->typeofdata = 'NN~M'; // varchar~Mandatory
	$blockNotification->addField($field51); /** table and column are automatically set */
	
	
	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'isview';
	$field7->label = 'Is Viewed';
	$field7->table = $module->basetable;
	$field7->column = 'isview';
	$field7->columntype = 'VARCHAR(1)';
	$field7->uitype = 56;
	$field7->typeofdata = 'V~O';
	$blockNotification->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'actionperform';
	$field8->label = 'Action Performed';
	$field8->table = $module->basetable;
	$field8->column = 'actionperform';
	$field8->columntype = 'VARCHAR(150)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->setPicklistValues( Array ('Applied', 'Approved','Rejected', 'Updated','Assigned', 'Completed', 'Posted', 'Commented', 'Download'));
	$blockNotification->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'relatedto';
	$field9->label = 'Related To';
	$field9->table = $module->basetable;
	$field9->column = 'relatedto';
	$field9->columntype = 'VARCHAR(100)';
	$field9->uitype = 10;
	$field9->typeofdata = 'V~O';
	$blockNotification->addField($field9); /** Creates the field and adds to block */
	$field9->setRelatedModules(Array('Claim','Leave','Message', 'Calendar', 'WorkingHours', 'ModComments', 'Payslip'));


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$blockNotification->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Notification Date';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$blockNotification->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$field4->iscustom	= 0;
	$blockNotification->addField($field4);

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
<?php
<<<<<<< HEAD
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Leave';

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

	$MODULENAME = 'Leave'; //Give your module name
	$PARENT 	= 'Sales';  //Give Parent name
	$ENTITYNAME = 'leavetitle'; //Give Duplicate check field name
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
	$leaveInformation = new Vtiger_Block();
	$leaveInformation->label = 'Leave Information';
<<<<<<< HEAD
	$moduleInstance->addBlock($leaveInformation);
	
	$approvalInformation = new Vtiger_Block();
	$approvalInformation->label = 'Approval Information';
	$moduleInstance->addBlock($approvalInformation);

	
=======
	$module->addBlock($leaveInformation);
	
	$approvalInformation = new Vtiger_Block();
	$approvalInformation->label = 'Approval Information';
	$module->addBlock($approvalInformation);

>>>>>>> Development
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'leaveno';
	$field1->label = 'Leave No';
<<<<<<< HEAD
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'leaveno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
=======
	$field1->table = $module->basetable;
	$field1->column = 'leaveno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 4;
>>>>>>> Development
	$field1->typeofdata = 'V~M';
	$leaveInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
<<<<<<< HEAD
	$moduleInstance->setEntityIdentifier($field1);
=======
	$module->setEntityIdentifier($field1);
>>>>>>> Development

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'leavetype';
	$field2->label = 'Leave Type';
<<<<<<< HEAD
	$field2->table = $moduleInstance->basetable;
=======
	$field2->table = $module->basetable;
>>>>>>> Development
	$field2->column = 'leavetype';
	$field2->columntype = 'VARCHAR(255)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'fromdate';
	$field3->label = 'From Date';
<<<<<<< HEAD
	$field3->table = $moduleInstance->basetable;
=======
	$field3->table = $module->basetable;
>>>>>>> Development
	$field3->column = 'fromdate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'todate';
	$field4->label = 'To Date';
<<<<<<< HEAD
	$field4->table = $moduleInstance->basetable;
=======
	$field4->table = $module->basetable;
>>>>>>> Development
	$field4->column = 'todate';
	$field4->columntype = 'DATE';
	$field4->uitype = 5;
	$field4->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field4); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
<<<<<<< HEAD
	$field5 = new Vtiger_Field();
	$field5->name = 'assignedto';
	$field5->label = 'Assigned To';
	$field5->table = $moduleInstance->basetable;
=======
/*	$field5 = new Vtiger_Field();
	$field5->name = 'assignedto';
	$field5->label = 'Assigned To';
	$field5->table = $module->basetable;
>>>>>>> Development
	$field5->column = 'assignedto';
	$field5->columntype = 'VARCHAR(50)';
	$field5->uitype = 15;
	$field5->typeofdata = 'V~O'; 
	$field5->setPicklistValues( Array ('Users', 'Groups'));
	$leaveInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'dutiestakenoverby';
	$field6->label = 'Duties Taken Over By';
<<<<<<< HEAD
	$field6->table = $moduleInstance->basetable;
=======
	$field6->table = $module->basetable;
>>>>>>> Development
	$field6->column = 'dutiestakenoverby';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('Users', 'Groups'));
	$leaveInformation->addField($field6); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'starthalfday';
	$field7->label = 'Start Half Day';
<<<<<<< HEAD
	$field7->table = $moduleInstance->basetable;
=======
	$field7->table = $module->basetable;
>>>>>>> Development
	$field7->column = 'starthalfday';
	$field7->columntype = 'VARCHAR(3)';
	$field7->uitype = 56;
	$field7->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'endhalfday';
	$field8->label = 'End Half Day';
<<<<<<< HEAD
	$field8->table = $moduleInstance->basetable;
=======
	$field8->table = $module->basetable;
>>>>>>> Development
	$field8->column = 'endhalfday';
	$field8->columntype = 'VARCHAR(3)';
	$field8->uitype = 56;
	$field8->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'reasonofleave';
	$field9->label = 'Reason of Leave';
<<<<<<< HEAD
	$field9->table = $moduleInstance->basetable;
=======
	$field9->table = $module->basetable;
>>>>>>> Development
	$field9->column = 'reasonofleave';
	$field9->columntype = 'TEXT';
	$field9->uitype = 21;
	$field9->typeofdata = 'V~O'; // varchar~Mandatory 
	$leaveInformation->addField($field9); /** Creates the field and adds to block */


	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
<<<<<<< HEAD
	$field10->name = 'status';
	$field10->label = 'Status';
	$field10->table = $moduleInstance->basetable;
	$field10->column = 'status';
=======
	$field10->name = 'leave_status';
	$field10->label = 'Status';
	$field10->table = $module->basetable;
	$field10->column = 'leave_status';
>>>>>>> Development
	$field10->columntype = 'VARCHAR(50)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O'; 
	$field10->setPicklistValues( Array ('Apply', 'Approved', 'Rejected'));
	$leaveInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'totalleavetaken';
	$field11->label = 'Total Leave Taken';
<<<<<<< HEAD
	$field11->table = $moduleInstance->basetable;
=======
	$field11->table = $module->basetable;
>>>>>>> Development
	$field11->column = 'totalleavetaken';
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveInformation->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'approvedate';
	$field12->label = 'Approve Date';
<<<<<<< HEAD
	$field12->table = $moduleInstance->basetable;
=======
	$field12->table = $module->basetable;
>>>>>>> Development
	$field12->column = 'approvedate';
	$field12->columntype = 'DATE';
	$field12->uitype = 5;
	$field12->typeofdata = 'D~O'; // varchar~Mandatory	
	$approvalInformation->addField($field12); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'reasonforrejection';
	$field13->label = 'Reason For Rejection';
<<<<<<< HEAD
	$field13->table = $moduleInstance->basetable;
=======
	$field13->table = $module->basetable;
>>>>>>> Development
	$field13->column = 'reasonforrejection';
	$field13->columntype = 'VARCHAR(100)';
	$field13->uitype = 1;
	$field13->typeofdata = 'V~O'; // varchar~Mandatory	
	$approvalInformation->addField($field13); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'approveby';
	$field14->label = 'Approve By';
<<<<<<< HEAD
	$field14->table = $moduleInstance->basetable;
=======
	$field14->table = $module->basetable;
>>>>>>> Development
	$field14->column = 'approveby';
	$field14->columntype = 'VARCHAR(50)';
	$field14->uitype = 15;
	$field14->typeofdata = 'V~O'; 
	$field14->setPicklistValues( Array ('Users', 'Groups'));
	$approvalInformation->addField($field14); /** Creates the field and adds to block */

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
	$leaveInformation->addField($field21);

	$field31 = new Vtiger_Field();
	$field31->name = 'createdtime';
	$field31->label= 'Created Time';
	$field31->table = 'vtiger_crmentity';
	$field31->column = 'createdtime';
	$field31->uitype = 70;
	$field31->typeofdata = 'T~O';
	$field31->displaytype= 2;
	$leaveInformation->addField($field31);

	$field41 = new Vtiger_Field();
	$field41->name = 'modifiedtime';
	$field41->label= 'Modified Time';
	$field41->table = 'vtiger_crmentity';
	$field41->column = 'modifiedtime';
	$field41->uitype = 70;
	$field41->typeofdata = 'T~O';
	$field41->displaytype= 2;
	$leaveInformation->addField($field41);

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
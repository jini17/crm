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

	// Add the basic module block
	$leaveInformation = new Vtiger_Block();
	$leaveInformation->label = 'Leave Information';
	$module->addBlock($leaveInformation);
	
	$approvalInformation = new Vtiger_Block();
	$approvalInformation->label = 'Approval Information';
	$module->addBlock($approvalInformation);

	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'leaveno';
	$field1->label = 'Leave No';
	$field1->table = $module->basetable;
	$field1->column = 'leaveno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 4;
	$field1->typeofdata = 'V~M';
	$leaveInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$module->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'leavetype';
	$field2->label = 'Leave Type';
	$field2->table = $module->basetable;
	$field2->column = 'leavetype';
	$field2->columntype = 'VARCHAR(255)';
<<<<<<< HEAD
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveInformation->addField($field2); /** Creates the field and adds to block */
=======
	$field2->uitype = 10;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveInformation->addField($field2); /** Creates the field and adds to block */
	$field2->setRelatedModules(Array('LeaveType'));
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'fromdate';
	$field3->label = 'From Date';
	$field3->table = $module->basetable;
	$field3->column = 'fromdate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'todate';
	$field4->label = 'To Date';
	$field4->table = $module->basetable;
	$field4->column = 'todate';
	$field4->columntype = 'DATE';
	$field4->uitype = 5;
	$field4->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field4); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
/*	$field5 = new Vtiger_Field();
	$field5->name = 'assignedto';
	$field5->label = 'Assigned To';
	$field5->table = $module->basetable;
	$field5->column = 'assignedto';
	$field5->columntype = 'VARCHAR(50)';
	$field5->uitype = 15;
	$field5->typeofdata = 'V~O'; 
	$field5->setPicklistValues( Array ('Users', 'Groups'));
	$leaveInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
<<<<<<< HEAD
	$field6->name = 'dutiestakenoverby';
	$field6->label = 'Duties Taken Over By';
	$field6->table = $module->basetable;
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
	$field7->table = $module->basetable;
	$field7->column = 'starthalfday';
=======
	$field6->name = 'replaceuser_id';
	$field6->label = 'Duties Taken Over By';
	$field6->table = $module->basetable;
	$field6->column = 'replaceuser_id';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 10;
	$field6->typeofdata = 'V~O'; 
	$leaveInformation->addField($field6); /** Creates the field and adds to block */
	$field6->setRelatedModules(Array('Users'));

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'starthalf';
	$field7->label = 'Start Half Day';
	$field7->table = $module->basetable;
	$field7->column = 'starthalf';
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field7->columntype = 'VARCHAR(3)';
	$field7->uitype = 56;
	$field7->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
<<<<<<< HEAD
	$field8->name = 'endhalfday';
	$field8->label = 'End Half Day';
	$field8->table = $module->basetable;
	$field8->column = 'endhalfday';
=======
	$field8->name = 'endhalf';
	$field8->label = 'End Half Day';
	$field8->table = $module->basetable;
	$field8->column = 'endhalf';
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field8->columntype = 'VARCHAR(3)';
	$field8->uitype = 56;
	$field8->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'reasonofleave';
	$field9->label = 'Reason of Leave';
	$field9->table = $module->basetable;
	$field9->column = 'reasonofleave';
	$field9->columntype = 'TEXT';
<<<<<<< HEAD
	$field9->uitype = 21;
=======
	$field9->uitype = 19;
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field9->typeofdata = 'V~O'; // varchar~Mandatory 
	$leaveInformation->addField($field9); /** Creates the field and adds to block */


	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
<<<<<<< HEAD
	$field10->name = 'leave_status';
	$field10->label = 'Status';
	$field10->table = $module->basetable;
	$field10->column = 'leave_status';
=======
	$field10->name = 'leavestatus';
	$field10->label = 'Status';
	$field10->table = $module->basetable;
	$field10->column = 'leavestatus';
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field10->columntype = 'VARCHAR(50)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O'; 
	$field10->setPicklistValues( Array ('Apply', 'Approved', 'Rejected'));
	$leaveInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
<<<<<<< HEAD
	$field11->name = 'totalleavetaken';
	$field11->label = 'Total Leave Taken';
	$field11->table = $module->basetable;
	$field11->column = 'totalleavetaken';
=======
	$field11->name = 'total_taken';
	$field11->label = 'Total Leave Taken';
	$field11->table = $module->basetable;
	$field11->column = 'total_taken';
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveInformation->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'approvedate';
	$field12->label = 'Approve Date';
	$field12->table = $module->basetable;
	$field12->column = 'approvedate';
	$field12->columntype = 'DATE';
	$field12->uitype = 5;
	$field12->typeofdata = 'D~O'; // varchar~Mandatory	
	$approvalInformation->addField($field12); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
<<<<<<< HEAD
	$field13->name = 'reasonforrejection';
	$field13->label = 'Reason For Rejection';
	$field13->table = $module->basetable;
	$field13->column = 'reasonforrejection';
	$field13->columntype = 'VARCHAR(100)';
	$field13->uitype = 1;
=======
	$field13->name = 'reasonnotapprove';
	$field13->label = 'Reason For Rejection';
	$field13->table = $module->basetable;
	$field13->column = 'reasonnotapprove';
	$field13->columntype = 'VARCHAR(100)';
	$field13->uitype = 19;
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51
	$field13->typeofdata = 'V~O'; // varchar~Mandatory	
	$approvalInformation->addField($field13); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'approveby';
	$field14->label = 'Approve By';
	$field14->table = $module->basetable;
	$field14->column = 'approveby';
	$field14->columntype = 'VARCHAR(50)';
<<<<<<< HEAD
	$field14->uitype = 15;
	$field14->typeofdata = 'V~O'; 
	$field14->setPicklistValues( Array ('Users', 'Groups'));
	$approvalInformation->addField($field14); /** Creates the field and adds to block */
=======
	$field14->uitype = 10;
	$field14->typeofdata = 'V~O'; 
	$approvalInformation->addField($field14); /** Creates the field and adds to block */
	$field14->setRelatedModules(Array('Users'));
	/** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'attachment';
	$field15->label = 'Documents (If any)';
	$field15->table = $module->basetable;
	$field15->column = 'attachment';
	$field15->columntype = 'VARCHAR(50)';
	$field15->uitype = 28;
	$field15->typeofdata = 'V~O'; 
	$approvalInformation->addField($field15); /** Creates the field and adds to block */
>>>>>>> 0b3d5add69adde6c623e874428b267f62dcbcf51

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

<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Leave Type';

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

	// Add the basic module block
	$leaveTypeInformation = new Vtiger_Block();
	$leaveTypeInformation->label = 'Leave Type Information';
	$moduleInstance->addBlock($leaveTypeInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$moduleInstance->addBlock($description);

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'title';
	$field1->label = 'Title';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'title';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$leaveTypeInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'leavecode';
	$field2->label = 'Leave Code';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'leavecode';
	$field2->columntype = 'VARCHAR(255)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'description';
	$field3->label = 'Description';
	$field3->table = $moduleInstance->basetable;
	$field3->column = 'description';
	$field3->columntype = 'TEXT';
	$field3->uitype = 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'midyearallocation';
	$field4->label = 'Mid Year Allocation';
	$field4->table = $moduleInstance->basetable;
	$field4->column = 'midyearallocation';
	$field4->columntype = 'VARCHAR(50)';
	$field4->uitype = 15;
	$field4->typeofdata = 'V~O'; 
	$field4->setPicklistValues( Array ('Full Allocation', 'Pro Rate Allocation'));
	$leaveTypeInformation->addField($field4); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'assignedto';
	$field5->label = 'Assigned To';
	$field5->table = $moduleInstance->basetable;
	$field5->column = 'assignedto';
	$field5->columntype = 'VARCHAR(50)';
	$field5->uitype = 15;
	$field5->typeofdata = 'V~O'; 
	$field5->setPicklistValues( Array ('Users', 'Groups'));
	$leaveTypeInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'leavefrequency';
	$field6->label = 'Leave Frequency';
	$field6->table = $moduleInstance->basetable;
	$field6->column = 'leavefrequency';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('One Time', 'Per Year'));
	$leaveTypeInformation->addField($field6); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'status';
	$field7->label = 'Status';
	$field7->table = $moduleInstance->basetable;
	$field7->column = 'status';
	$field7->columntype = 'VARCHAR(3)';
	$field7->uitype = 56;
	$field7->typeofdata = 'C~M'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'carryforward';
	$field8->label = 'Carry Forward';
	$field8->table = $moduleInstance->basetable;
	$field8->column = 'carryforward';
	$field8->columntype = 'VARCHAR(3)';
	$field8->uitype = 56;
	$field8->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'halfdayallowed';
	$field9->label = 'Half Day Allowed';
	$field9->table = $moduleInstance->basetable;
	$field9->column = 'halfdayallowed';
	$field9->columntype = 'VARCHAR(3)';
	$field9->uitype = 56;
	$field9->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveTypeInformation->addField($field9); /** Creates the field and adds to block */


	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'leavetypeno';
	$field10->label = 'Leave Type No';
	$field10->table = $moduleInstance->basetable;
	$field10->column = 'leavetypeno';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 1;
	$field10->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'colorcode';
	$field11->label = 'Color Code';
	$field11->table = $moduleInstance->basetable;
	$field11->column = 'colorcode';
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveTypeInformation->addField($field11); /** Creates the field and adds to block */


	// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
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
<?php
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

	// Add the basic module block
	$leaveInformation = new Vtiger_Block();
	$leaveInformation->label = 'Leave Information';
	$moduleInstance->addBlock($leaveInformation);
	
	$approvalInformation = new Vtiger_Block();
	$approvalInformation->label = 'Approval Information';
	$moduleInstance->addBlock($approvalInformation);

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'leaveno';
	$field1->label = 'Leave No';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'leaveno';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$leaveInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'leavetype';
	$field2->label = 'Leave Type';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'leavetype';
	$field2->columntype = 'VARCHAR(255)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory	
	$leaveInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'fromdate';
	$field3->label = 'From Date';
	$field3->table = $moduleInstance->basetable;
	$field3->column = 'fromdate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'todate';
	$field4->label = 'To Date';
	$field4->table = $moduleInstance->basetable;
	$field4->column = 'todate';
	$field4->columntype = 'DATE';
	$field4->uitype = 5;
	$field4->typeofdata = 'D~O'; // varchar~Mandatory	
	$leaveInformation->addField($field4); /** Creates the field and adds to block */

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
	$leaveInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'dutiestakenoverby';
	$field6->label = 'Duties Taken Over By';
	$field6->table = $moduleInstance->basetable;
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
	$field7->table = $moduleInstance->basetable;
	$field7->column = 'starthalfday';
	$field7->columntype = 'VARCHAR(3)';
	$field7->uitype = 56;
	$field7->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'endhalfday';
	$field8->label = 'End Half Day';
	$field8->table = $moduleInstance->basetable;
	$field8->column = 'endhalfday';
	$field8->columntype = 'VARCHAR(3)';
	$field8->uitype = 56;
	$field8->typeofdata = 'C~O'; // varchar~Mandatory 
	$leaveInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'reasonofleave';
	$field9->label = 'Reason of Leave';
	$field9->table = $moduleInstance->basetable;
	$field9->column = 'reasonofleave';
	$field9->columntype = 'TEXT';
	$field9->uitype = 21;
	$field9->typeofdata = 'V~O'; // varchar~Mandatory 
	$leaveInformation->addField($field9); /** Creates the field and adds to block */


	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'status';
	$field10->label = 'Status';
	$field10->table = $moduleInstance->basetable;
	$field10->column = 'status';
	$field10->columntype = 'VARCHAR(50)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O'; 
	$field10->setPicklistValues( Array ('Apply', 'Approved', 'Rejected'));
	$leaveInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'totalleavetaken';
	$field11->label = 'Total Leave Taken';
	$field11->table = $moduleInstance->basetable;
	$field11->column = 'totalleavetaken';
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O'; // varchar~Mandatory	
	$leaveInformation->addField($field11); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'approvedate';
	$field12->label = 'Approve Date';
	$field12->table = $moduleInstance->basetable;
	$field12->column = 'approvedate';
	$field12->columntype = 'DATE';
	$field12->uitype = 5;
	$field12->typeofdata = 'D~O'; // varchar~Mandatory	
	$approvalInformation->addField($field12); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'reasonforrejection';
	$field13->label = 'Reason For Rejection';
	$field13->table = $moduleInstance->basetable;
	$field13->column = 'reasonforrejection';
	$field13->columntype = 'VARCHAR(100)';
	$field13->uitype = 1;
	$field13->typeofdata = 'V~O'; // varchar~Mandatory	
	$approvalInformation->addField($field13); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'approveby';
	$field14->label = 'Approve By';
	$field14->table = $moduleInstance->basetable;
	$field14->column = 'approveby';
	$field14->columntype = 'VARCHAR(50)';
	$field14->uitype = 15;
	$field14->typeofdata = 'V~O'; 
	$field14->setPicklistValues( Array ('Users', 'Groups'));
	$approvalInformation->addField($field14); /** Creates the field and adds to block */


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
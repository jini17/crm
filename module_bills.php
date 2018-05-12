<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Bills';

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
	$blockBills = new Vtiger_Block();
	$blockBills->label = 'LBL_'.strtoupper($moduleInstance->name).'_INFORMATION';
	$moduleInstance->addBlock($blockBills);
	
	$blockReminderDetails = new Vtiger_Block();
	$blockReminderDetails->label = 'Reminder Details';
	$moduleInstance->addBlock($blockReminderDetails);
	
	$blockRemarksInformation = new Vtiger_Block();
	$blockRemarksInformation->label = 'Remarks Information';
	$moduleInstance->addBlock($blockRemarksInformation);
	
	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'billtitle';
	$field1->label = 'Bill Title';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'billtitle';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$blockBills->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	$field2 = new Vtiger_Field();
	$field2->name = 'amount';
	$field2->label = 'Estimated Amount(RM)';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'amount';
	$field2->columntype = 'DECIMAL(62,2)';
	$field2->uitype = 1;
	$field2->displaytype = 1;
	$field2->typeofdata = 'NN~M'; // varchar~Mandatory
	
	$blockBills->addField($field2); /** table and column are automatically set */

	$field3 = new Vtiger_Field();
	$field3->name   =  'bill_type';
	$field3->label  = 'Bill Type';
	$field3->table  =  $moduleInstance->basetable;
	$field3->column = 'bill_type';
	$field3->columntype = 'VARCHAR(100)';
	$field3->uitype	= 15;
	$field3->typeofdata = 'V~M'; // varchar~Mandatory
	$field3->setPicklistValues( Array ('Electricity', 'Primary Phone','Internet','Water','Utilities') );
	$blockBills->addField($field3); /** table, column, label, set to default values */
	
	/** Common fields that should be in every module,
	 	linked to vtiger CRM core table
	*/
	$field4 = new Vtiger_Field();
	$field4->name = 'assigned_user_id';
	$field4->label = 'Assigned To';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'smownerid';
	$field4->uitype = 53;
	$field4->typeofdata = 'V~M';
	$blockBills->addField($field4);

	$field5 = new Vtiger_Field();
	$field5->name = 'CreatedTime';
	$field5->label= 'Created Time';
	$field5->table = 'vtiger_crmentity';
	$field5->column = 'createdtime';
	$field5->uitype = 70;
	$field5->typeofdata = 'T~O';
	$field5->displaytype= 2;
	$blockBills->addField($field5);

	$field6 = new Vtiger_Field();
	$field6->name = 'ModifiedTime';
	$field6->label= 'Modified Time';
	$field6->table = 'vtiger_crmentity';
	$field6->column = 'modifiedtime';
	$field6->uitype = 70;
	$field6->typeofdata = 'T~O';
	$field6->displaytype= 2;
	$blockBills->addField($field6);

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


/** END */

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

	//Dependent Module	
	$accList = Vtiger_Module::getInstance('Bills');
	$accList->setRelatedList(Vtiger_Module::getInstance('Payments'), 'Payments',Array('ADD'),'get_dependents_list');
	
	//$moduleInstance->addLink('DETAILVIEWBASIC', 'LBL_SURVEY_REPORT', 'index.php?module=Survey&view=result&record=$RECORD$');

	$moduleInstance->setDefaultSharing();
	//mkdir('modules/'.$MODULENAME);
	//chmod('modules/'.$MODULENAME,0777);
        echo "OK\n";
	//$moduleInstance=null;
//}
?>

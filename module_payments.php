<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Payments';

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
	$blockPayments = new Vtiger_Block();
	$blockPayments->label = 'LBL_'.strtoupper($moduleInstance->name).'_INFORMATION';
	$moduleInstance->addBlock($blockPayments);
	
	$blockBillingInformation = new Vtiger_Block();
	$blockBillingInformation->label = 'Billing Information';
	$moduleInstance->addBlock($blockBillingInformation);
	
	$blockRemarksInformation = new Vtiger_Block();
	$blockRemarksInformation->label = 'Remark Information';
	$moduleInstance->addBlock($blockRemarksInformation);
	
	
	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'paymentref';
	$field1->label = 'Payment Ref';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'paymentref';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$blockBillingInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	$field2 = new Vtiger_Field();
	$field2->name = 'amount';
	$field2->label = 'Amount';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'amount';
	$field2->columntype = 'DECIMAL(62,2)';
	$field2->uitype = 1;
	$field2->displaytype = 1;
	$field2->typeofdata = 'NN~M'; // varchar~Mandatory
	
	$blockPayments->addField($field2); /** table and column are automatically set */

	$field3 = new Vtiger_Field();
	$field3->name   =  'currency_id';
	$field3->label  = 'Currency';
	$field3->table  =  $moduleInstance->basetable;
	$field3->column = 'currency_id';
	$field3->columntype = 'INT(19)';
	$field3->uitype	= 117;
	$field3->typeofdata = 'I~O'; // varchar~Mandatory
	$blockPayments->addField($field3); /** table, column, label, set to default values */
	
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
	$blockPayments->addField($field4);

	$field5 = new Vtiger_Field();
	$field5->name = 'CreatedTime';
	$field5->label= 'Created Time';
	$field5->table = 'vtiger_crmentity';
	$field5->column = 'createdtime';
	$field5->uitype = 70;
	$field5->typeofdata = 'T~O';
	$field5->displaytype= 2;
	$blockPayments->addField($field5);

	$field6 = new Vtiger_Field();
	$field6->name = 'ModifiedTime';
	$field6->label= 'Modified Time';
	$field6->table = 'vtiger_crmentity';
	$field6->column = 'modifiedtime';
	$field6->uitype = 70;
	$field6->typeofdata = 'T~O';
	$field6->displaytype= 2;
	$blockPayments->addField($field6);

	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'paymentno';
	$field7->label = 'Payment No';
	$field7->table = $module->basetable;
	$field7->column = 'paymentno';
	$field7->columntype = 'VARCHAR(100)';
	$field7->uitype = 4;
	$field7->typeofdata = 'V~M';
	$blockPayments->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'payment_type';
	$field8->label = 'Payment Type';
	$field8->table = $module->basetable;
	$field8->column = 'payment_type';
	$field8->columntype = 'VARCHAR(100)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->setPicklistValues( Array ('Income', 'Payment Out','Expense','Others') );
	$blockPayments->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'duedate';
	$field9->label = 'Due Date';
	$field9->table = $module->basetable;
	$field9->column = 'duedate';
	$field9->columntype = 'DATE';
	$field9->uitype = 5;
	$field9->typeofdata = 'D~O';
	$blockPayments->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'payment_subtype';
	$field10->label = 'Payment Sub Type';
	$field10->table = $module->basetable;
	$field10->column = 'payment_subtype';
	$field10->columntype = 'VARCHAR(150)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O';
	$field10->setPicklistValues( Array ('Subscription Income','Professional Services Income','Other Income','Partner Payment','Salary','Stipend','Commission & Incentive','Staff Claim','EPF','SOCSO','Corporate Tax','Staff Tax','Office Rental','Office Utilities','Purchase Hardware','Purchase Software','Purchase Goods','Purchase Services','Renovation & Repair','Other Expense','Staff Benefit','Car Purchase','Car Maintenance','Office Purchase','Car Loan Payment','Office Loan Payment','Advertising') );
	$blockPayments->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'relatedto';
	$field11->label = 'Related To';
	$field11->table = $module->basetable;
	$field11->column = 'relatedto';
	$field11->columntype = 'VARCHAR(100)';
	$field11->uitype = 10;
	$field11->typeofdata = 'V~M';
	$blockPayments->addField($field11); /** Creates the field and adds to block */
	$field11->setRelatedModules(Array('Accounts','Contacts'));

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'payment_status';
	$field12->label = 'Payment Status';
	$field12->table = $module->basetable;
	$field12->column = 'payment_status';
	$field12->columntype = 'VARCHAR(50)';
	$field12->uitype = 15;
	$field12->typeofdata = 'V~O';
	$field12->setPicklistValues( Array ('Created', 'Paid','Cancel') );
	$blockPayments->addField($field12); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'paymentfor';
	$field13->label = 'Payment For';
	$field13->table = $module->basetable;
	$field13->column = 'paymentfor';
	$field13->columntype = 'VARCHAR(255)';
	$field13->uitype = 19;
	$field13->typeofdata = 'V~O';
	$blockPayments->addField($field13); /** Creates the field and adds to block */

        	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'linktomodule';
	$field14->label = 'Invoice/Purchase Order';
	$field14->table = $module->basetable;
	$field14->column = 'linktomodule';
	$field14->columntype = 'VARCHAR(100)';
	$field14->uitype = 10;
	$field14->typeofdata = 'V~O';
	$blockPayments->addField($field14); /** Creates the field and adds to block */
	$field14->setRelatedModules(Array('Invoice','PurchaseOrder'));

        /** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'billid';
	$field15->label = 'Select Bill';
	$field15->table = $module->basetable;
	$field15->column = 'billid';
	$field15->columntype = 'VARCHAR(100)';
	$field15->uitype = 10;
	$field15->typeofdata = 'V~O';
	$blockPayments->addField($field15); /** Creates the field and adds to block */
	$field15->setRelatedModules(Array('Bills'));
		
	
	 /** Create required fields and add to the block */
/*	$field16 = new Vtiger_Field();
	$field16->name = 'company_details';
	$field16->label = 'Company Details';
	$field16->table = $module->basetable;
	$field16->column = 'company_details';
	$field16->columntype = 'VARCHAR(100)';
	$field16->uitype = 3993;
	$field16->typeofdata = 'V~M~LE~255';
	$blockPayments->addField($field16); /** Creates the field and adds to block */
	
	 /** Create required fields and add to the block */
/*	$field17 = new Vtiger_Field();
	$field17->name = 'terms_conditions';
	$field17->label = 'Terms & Condition';
	$field17->table = $module->basetable;
	$field17->column = 'terms_conditions';
	$field17->columntype = 'VARCHAR(100)';
	$field17->uitype = 3994;
	$field17->typeofdata = 'V~M~LE~255';
	$blockPayments->addField($field17); /** Creates the field and adds to block */
	

         /** Create required fields and add to the block */
	/*$field18 = new Vtiger_Field();
	$field18->name = 'region';
	$field18->label = 'Territory';
	$field18->table = $module->basetable;
	$field18->column = 'region';
	$field18->columntype = 'VARCHAR(255)';
	$field18->uitype = 2002;
	$field18->typeofdata = 'V~O';
	$blockPayments->addField($field18); /** Creates the field and adds to block */
	
	    /** Create required fields and add to the block */
	$field19 = new Vtiger_Field();
	$field19->name = 'paymentdate';
	$field19->label = 'Payment Date';
	$field19->table = $module->basetable;
	$field19->column = 'paymentdate';
	$field19->columntype = 'DATE';
	$field19->uitype = 5;
	$field19->typeofdata = 'D~O';
	$blockBillingInformation->addField($field19); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field20 = new Vtiger_Field();
	$field20->name = 'actual_amount';
	$field20->label = 'Actual Amount(RM)';
	$field20->table = $module->basetable;
	$field20->column = 'actual_amount';
	$field20->columntype = 'DECIMAL(25,2)';
	$field20->uitype = 1;
	$field20->typeofdata = 'NN~O';
	$blockBillingInformation->addField($field20); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field21 = new Vtiger_Field();
	$field21->name = 'bankname';
	$field21->label = 'Bank Name';
	$field21->table = $module->basetable;
	$field21->column = 'bankname';
	$field21->columntype = 'VARCHAR(150)';
	$field21->uitype = 2;
	$field21->typeofdata = 'V~O';
	$blockBillingInformation->addField($field21); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field22 = new Vtiger_Field();
	$field22->name = 'bankaccountname';
	$field22->label = 'Bank Account Name';
	$field22->table = $module->basetable;
	$field22->column = 'bankaccountname';
	$field22->columntype = 'VARCHAR(150)';
	$field22->uitype = 2;
	$field22->typeofdata = 'V~O';
	$blockBillingInformation->addField($field22); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field221 = new Vtiger_Field();
	$field221->name = 'paymentmode';
	$field221->label = 'Payment Mode';
	$field221->table = $module->basetable;
	$field221->column = 'paymentmode';
	$field221->columntype = 'VARCHAR(50)';
	$field221->uitype = 15;
	$field221->typeofdata = 'V~O';
	$field221->setPicklistValues( Array ('Cash', 'Cheque','Credit Card','Online Transfer','Wire Transfer','Others') );
	$blockBillingInformation->addField($field221); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field23 = new Vtiger_Field();
	$field23->name = 'refno';
	$field23->label = 'Ref No(CC No|A/C No|Cheque No)';
	$field23->table = $module->basetable;
	$field23->column = 'refno';
	$field23->columntype = 'VARCHAR(100)';
	$field23->uitype = 2;
	$field23->typeofdata = 'V~O';
	$blockBillingInformation->addField($field23); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field24 = new Vtiger_Field();
	$field24->name = 'discount_reason';
	$field24->label = 'Discount Reason';
	$field24->table = $module->basetable;
	$field24->column = 'discount_reason';
	$field24->columntype = 'VARCHAR(255)';
	$field24->uitype = 19;
	$field24->typeofdata = 'V~O';
	$blockBillingInformation->addField($field24); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field25 = new Vtiger_Field();
	$field25->name = 'discount';
	$field25->label = 'Discount';
	$field25->table = $module->basetable;
	$field25->column = 'discount';
	$field25->columntype = 'DECIMAL(25,2)';
	$field25->uitype = 1;
	$field25->typeofdata = 'NN~O';
	$blockBillingInformation->addField($field25); /** Creates the field and adds to block */


        	/** Create required fields and add to the block */
	$field26 = new Vtiger_Field();
	$field26->name = 'remarks';
	$field26->label = 'Remarks';
	$field26->table = $module->basetable;
	$field26->column = 'remarks';
	$field26->columntype = 'VARCHAR(255)';
	$field26->uitype = 19;
	$field26->typeofdata = 'V~O';
	$blockRemarksInformation->addField($field26); /** Creates the field and adds to block */

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
	$accList = Vtiger_Module::getInstance('Payments');
	$accList->setRelatedList(Vtiger_Module::getInstance('Bills'), 'Bills',Array('ADD'),'get_dependents_list');
	
	//$moduleInstance->addLink('DETAILVIEWBASIC', 'LBL_SURVEY_REPORT', 'index.php?module=Survey&view=result&record=$RECORD$');

	$moduleInstance->setDefaultSharing();
	//mkdir('modules/'.$MODULENAME);
	//chmod('modules/'.$MODULENAME,0777);
        echo "OK\n";
	//$moduleInstance=null;
//}
?>

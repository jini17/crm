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

	$MODULENAME = 'Payments'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'paymentref'; //Give Duplicate check field name
	$ENTITYLABEL= 'Payment Ref';

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
	$blockPayments = new Vtiger_Block();
	$blockPayments->label = 'LBL_'.strtoupper($moduleInstance->name).'_INFORMATION';
	$module->addBlock($blockPayments);
	
	$blockBillingInformation = new Vtiger_Block();
	$blockBillingInformation->label = 'Billing Information';
	$module->addBlock($blockBillingInformation);
	
	$blockRemarksInformation = new Vtiger_Block();
	$blockRemarksInformation->label = 'Remark Information';
	$module->addBlock($blockRemarksInformation);


	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 2;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$blockPayments->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'paymentno';
	$field5->label = 'Payment No';
	$field5->table = $module->basetable;
	$field5->column = 'paymentno';
	$field5->columntype = 'VARCHAR(100)';
	$field5->uitype = 4;
	$field5->displaytype = 1;
	$field5->typeofdata = 'V~M'; // varchar~Mandatory
	$blockPayments->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'currency_id';
	$field51->label = 'Currency';
	$field51->table = $module->basetable;
	$field51->column = 'currency_id';
	$field51->columntype = 'INT(19)';
	$field51->uitype = 117;
	$field51->displaytype = 1;
	$field51->typeofdata = 'I~O'; // varchar~Mandatory
	$blockPayments->addField($field51); /** table and column are automatically set */

	
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
	$field16 = new Vtiger_Field();
	$field16->name = 'company_details';
	$field16->label = 'Company Details';
	$field16->table = $module->basetable;
	$field16->column = 'company_details';
	$field16->columntype = 'VARCHAR(100)';
	$field16->uitype = 3993;
	$field16->typeofdata = 'V~M~LE~255';
	$blockPayments->addField($field16); /** Creates the field and adds to block */
	
	 /** Create required fields and add to the block */
	$field17 = new Vtiger_Field();
	$field17->name = 'terms_conditions';
	$field17->label = 'Terms & Condition';
	$field17->table = $module->basetable;
	$field17->column = 'terms_conditions';
	$field17->columntype = 'VARCHAR(100)';
	$field17->uitype = 3994;
	$field17->typeofdata = 'V~M~LE~255';
	$blockPayments->addField($field17); /** Creates the field and adds to block */
	

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
	


	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$blockPayments->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$blockPayments->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$blockPayments->addField($field4);


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
	//Dependent Module	
	$accList = Vtiger_Module::getInstance('Payments');
	$accList->setRelatedList(Vtiger_Module::getInstance('Bills'), 'Bills',Array('ADD'),'get_dependents_list');

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
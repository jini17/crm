<?php

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
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Performance';


global $adb;
$adb->setDebug(true);

// Create module instance and save it first
$moduleInstance = Vtiger_Module::getInstance($MODULENAME);
/*if ($moduleInstance || file_exists('modules/'.$MODULENAME)) {
        echo $MODULENAME." Module already present - choose a different name.";
} else {*/
        $moduleInstance = new Vtiger_Module();
        $moduleInstance->name = $MODULENAME;
        $moduleInstance->parent= 'Support';
        $moduleInstance->save();

	// Webservice Setup
	$moduleInstance->initWebservice();
	
	// Schema Setup
        $moduleInstance->initTables();
/*****************BLOCK CREATE HERE****************************/
	// Add the basic module block
	$blockPayments = new Vtiger_Block();
	$blockPayments->label = 'LBL_'.strtoupper($moduleInstance->name).'_INFORMATION';
	$moduleInstance->addBlock($blockPayments);
	
	$blockBillingInformation = new Vtiger_Block();
	$blockBillingInformation->label = 'PERFORMANCE REVIEW REPORT';
	$moduleInstance->addBlock($blockBillingInformation);

	$blockRemarksInformation = new Vtiger_Block();
	$blockRemarksInformation->label = 'SKILLS EVALUATED';
	$moduleInstance->addBlock($blockRemarksInformation);

	$blockperformancerating =new Vtiger_Block();
	$blockperformancerating->label="TOTAL PERFORMANCE RATING";
	$moduleInstance->addBlock($blockperformancerating);
/********************END BLOCK CREATE****************************/
	
/************************START PERFORMANCE REVIEW REPORT*****************************/
// $blockBillingInformation
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'yearly_review';
	$field1->label = 'Yearly Review';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'yearly_review';
	$field1->columntype = 'text';
	$field1->uitype = 21;
	$field1->typeofdata = 'V~O';
	$blockBillingInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	//$moduleInstance->setEntityIdentifier($field1);

	$field2 = new Vtiger_Field();
	$field2->name = 'quarterly_review';
	$field2->label = 'Quarterly Review';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'quarterly_review';
	$field2->columntype = 'text';
	$field2->uitype = 21;
	$field2->typeofdata = 'V~O'; // varchar~Mandatory
	$blockBillingInformation->addField($field2); /** table and column are automatically set */

	$field3 = new Vtiger_Field();
	$field3->name   =  'upgrading_review';
	$field3->label  = 'Upgrading Review';
	$field3->table  =  $moduleInstance->basetable;
	$field3->column = 'upgrading_review';
	$field3->columntype = 'text';
	$field3->uitype	= 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory
	$blockBillingInformation->addField($field3); /** table, column, label, set to default values */
	
	/** Common fields that should be in every module,
	 	linked to vtiger CRM core table
	*/
	$field4 = new Vtiger_Field();
	$field4->name = 'merit_review';
	$field4->label = 'Merit Review';
	$field4->table = $moduleInstance->basetable;
	$field4->column = 'merit_review';
	$field4->uitype = 21;
	$field4->typeofdata = 'V~O';
	$blockBillingInformation->addField($field4);
	/*********************END FOR PERFORMANCE REVIEW REPORT BLOCK***********************/


	/*$field4 = new Vtiger_Field();
	$field4->name = 'Assigned To';
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
	$blockPayments->addField($field6);*/
/***********************************START FOR SKILLS EVALUATED BLOCK**********************************/
//$blockRemarksInformation
	/** Create required fields and add to the block */
	$field7 = new Vtiger_Field();
	$field7->name = 'work_competency';
	$field7->label = 'Work Competency';
	$field7->table = $moduleInstance->basetable;
	$field7->column = 'work_competency';
	$field7->columntype = 'VARCHAR(255)';
	$field7->uitype = 15;
	$field7->typeofdata = 'V~O';
	$field7->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockRemarksInformation->addField($field7); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'communication';
	$field8->label = 'Communication';
	$field8->table = $moduleInstance->basetable;
	$field8->column = 'communication';
	$field8->columntype = 'VARCHAR(255)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~O';
	$field8->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockRemarksInformation->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'responsibility';
	$field9->label = 'Responsibility';
	$field9->table = $moduleInstance->basetable;
	$field9->column = 'responsibility';
	$field9->columntype = 'VARCHAR(255)';
	$field9->uitype = 15;
	$field9->typeofdata = 'V~O';
	$field9->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockRemarksInformation->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'attitude';
	$field10->label = 'Attitude';
	$field10->table = $moduleInstance->basetable;
	$field10->column = 'attitude';
	$field10->columntype = 'VARCHAR(255)';
	$field10->uitype = 15;
	$field10->typeofdata = 'V~O';
	$field10->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockRemarksInformation->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'teamwork';
	$field11->label = 'Team Work';
	$field11->table = $moduleInstance->basetable;
	$field11->column = 'teamwork';
	$field11->columntype = 'VARCHAR(255)';
	$field11->uitype = 15;
	$field11->typeofdata = 'V~O';
	$field10->setPicklistValues( Array ('1', '2','3','3','4','5','6','7','8','9','10') );
	$blockRemarksInformation->addField($field11); /** Creates the field and adds to block */
/********************************************END FOR SECOND BLOCK************************************/

/******************START FOR TOTAL PERFORMANCE RATING*************************************************/
//$blockperformancerating use this to add new fields
	/** Create required fields and add to the block */
			$field4 = new Vtiger_Field();
			$field4->name = 'Assigned To';
			$field4->label = 'Assigned To';
			$field4->table = 'vtiger_crmentity';
			$field4->column = 'smownerid';
			$field4->uitype = 53;
			$field4->typeofdata = 'V~O';
			$blockperformancerating->addField($field4);

			

    /** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'employee_remarks';
	$field13->label = 'Employee Remarks:';
	$field13->table = $moduleInstance->basetable;
	$field13->column = 'employee_remarks';
	$field13->columntype = 'text';
	$field13->uitype =  	21;
	$field13->typeofdata = 'V~O';
	$blockperformancerating->addField($field13); /** Creates the field and adds to block */

        	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'superior_remarks';
	$field14->label = 'Superior Remarks:';
	$field14->table = $moduleInstance->basetable;
	$field14->column = 'superior_remarks';
	$field14->columntype = 'text';
	$field14->uitype = 21;
	$field14->typeofdata = 'V~O';
	$blockperformancerating->addField($field14); /** Creates the field and adds to block */


        /** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'date_reviewed';
	$field15->label = 'Date Reviewed :';
	$field15->table = $moduleInstance->basetable;
	$field15->column = 'date_reviewed';
	$field15->columntype = 'DATE';
	$field15->uitype = 5;
	$field15->typeofdata = 'D~O';
	$blockperformancerating->addField($field15); /** Creates the field and adds to block */

		
/**********************************END FOR TOTAL PERFORMANCE RATING***********************/
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
	/*$field19 = new Vtiger_Field();
	$field19->name = 'paymentdate';
	$field19->label = 'Payment Date';
	$field19->table = $module->basetable;
	$field19->column = 'paymentdate';
	$field19->columntype = 'DATE';
	$field19->uitype = 5;
	$field19->typeofdata = 'D~O';
	$blockBillingInformation->addField($field19); /** Creates the field and adds to block */

	
	/** Create required fields and add to the block */
	/*$field20 = new Vtiger_Field();
	$field20->name = 'actual_amount';
	$field20->label = 'Actual Amount(RM)';
	$field20->table = $module->basetable;
	$field20->column = 'actual_amount';
	$field20->columntype = 'DECIMAL(25,2)';
	$field20->uitype = 1;
	$field20->typeofdata = 'NN~O';
	$blockBillingInformation->addField($field20); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	/*$field21 = new Vtiger_Field();
	$field21->name = 'bankname';
	$field21->label = 'Bank Name';
	$field21->table = $module->basetable;
	$field21->column = 'bankname';
	$field21->columntype = 'VARCHAR(150)';
	$field21->uitype = 2;
	$field21->typeofdata = 'V~O';
	$blockBillingInformation->addField($field21); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	/*$field22 = new Vtiger_Field();
	$field22->name = 'bankaccountname';
	$field22->label = 'Bank Account Name';
	$field22->table = $module->basetable;
	$field22->column = 'bankaccountname';
	$field22->columntype = 'VARCHAR(150)';
	$field22->uitype = 2;
	$field22->typeofdata = 'V~O';
	$blockBillingInformation->addField($field22); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	/*$field221 = new Vtiger_Field();
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
	/*$field23 = new Vtiger_Field();
	$field23->name = 'refno';
	$field23->label = 'Ref No(CC No|A/C No|Cheque No)';
	$field23->table = $module->basetable;
	$field23->column = 'refno';
	$field23->columntype = 'VARCHAR(100)';
	$field23->uitype = 2;
	$field23->typeofdata = 'V~O';
	$blockBillingInformation->addField($field23); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	/*$field24 = new Vtiger_Field();
	$field24->name = 'discount_reason';
	$field24->label = 'Discount Reason';
	$field24->table = $module->basetable;
	$field24->column = 'discount_reason';
	$field24->columntype = 'VARCHAR(255)';
	$field24->uitype = 19;
	$field24->typeofdata = 'V~O';
	$blockBillingInformation->addField($field24); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	/*$field25 = new Vtiger_Field();
	$field25->name = 'discount';
	$field25->label = 'Discount';
	$field25->table = $module->basetable;
	$field25->column = 'discount';
	$field25->columntype = 'DECIMAL(25,2)';
	$field25->uitype = 1;
	$field25->typeofdata = 'NN~O';
	$blockBillingInformation->addField($field25); /** Creates the field and adds to block */


        	/** Create required fields and add to the block */
	/*$field26 = new Vtiger_Field();
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
	
	$moduleInstance->setDefaultSharing();

	// Enable and Disable available tools
	$moduleInstance->enableTools(Array('Import', 'Export', 'Merge'));

	// Initialize Webservice support
	$moduleInstance->initWebservice();

	// Create files
	createFiles($moduleInstance, $field1);

	// Link to menu
	Settings_MenuEditor_Module_Model::addModuleToApp($moduleInstance->name, $moduleInstance->parent);

	echo "Module is created";



	/*// Add fields to the filter
	$filter2->addField($field1);
	$filter2->addField($field2, 1);
	// Add rule to the filter field
	$filter2->addRule($field1, 'CONTAINS', 'Test');
*/
	/** Enable and Disable available tools */
	
	/*//Dependent Module
	$accList = Vtiger_Module::getInstance('SUPPORT');
	$accList->setRelatedList(Vtiger_Module::getInstance('Bills'), 'Bills',Array('ADD'),'get_dependents_list');
	*/
	//$moduleInstance->addLink('DETAILVIEWBASIC', 'LBL_SURVEY_REPORT', 'index.php?module=Survey&view=result&record=$RECORD$');

	
	//mkdir('modules/'.$MODULENAME);
	//chmod('modules/'.$MODULENAME,0777);
        echo "OK\n";
	//$moduleInstance=null;

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



//}
?>

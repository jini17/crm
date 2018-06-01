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

	$MODULENAME = 'Payslip'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'payslipno'; //Give Duplicate check field name
	$ENTITYLABEL= 'Payslip No';

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
	$blockEmployeeInfo = new Vtiger_Block();
	$blockEmployeeInfo->label = 'LBL_EMPLOYEE_INFORMATION';
	$module->addBlock($blockEmployeeInfo);
	
	$blockEarningInformation = new Vtiger_Block();
	$blockEarningInformation->label = 'LBL_EMOULUMENT_INFORMATION';
	$module->addBlock($blockEarningInformation);
	
	$blockDeductionInformation = new Vtiger_Block();
	$blockDeductionInformation->label = 'LBL_DEDUCTION_INFORMATION';
	$module->addBlock($blockDeductionInformation);


	$blockContributionInformation = new Vtiger_Block();
	$blockContributionInformation->label = 'LBL_COMPANY_CONTRIBUTION';
	$module->addBlock($blockContributionInformation);


	$field1  = new Vtiger_Field();
	$field1->name = $ENTITYNAME;
	$field1->label= $ENTITYLABEL;
	$field1->uitype= 4;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$blockEmployeeInfo->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field5 = new Vtiger_Field();
	$field5->name = 'emp_name';
	$field5->label = 'Employee Name';
	$field5->table = $module->basetable;
	$field5->column = 'emp_name';
	$field5->columntype = 'int(11)';
	$field5->uitype = 10;
	$field5->displaytype = 1;
	$field5->typeofdata = 'V~M'; // varchar~Mandatory
	$blockEmployeeInfo->addField($field5); /** table and column are automatically set */

	$field51 = new Vtiger_Field();
	$field51->name = 'ic_passport';
	$field51->label = 'IC Passport No';
	$field51->table = $module->basetable;
	$field51->column = 'ic_passport';
	$field51->columntype = 'varchar(100)';
	$field51->uitype = 1;
	$field51->displaytype = 1;
	$field51->typeofdata = 'V~O'; // varchar~Mandatory
	$blockEmployeeInfo->addField($field51); /** table and column are automatically set */

	
	/** Create required fields and add to the block */
	$field8 = new Vtiger_Field();
	$field8->name = 'epf_no';
	$field8->label = 'EPF No';
	$field8->table = $module->basetable;
	$field8->column = 'epf_no';
	$field8->columntype = 'VARCHAR(100)';
	$field8->uitype = 1;
	$field8->typeofdata = 'V~O';
	$blockEmployeeInfo->addField($field8); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field9 = new Vtiger_Field();
	$field9->name = 'socso_no';
	$field9->label = 'Socso No';
	$field9->table = $module->basetable;
	$field9->column = 'socso_no';
	$field9->columntype = 'VARCHAR(50)';
	$field9->uitype = 1;
	$field9->typeofdata = 'V~O';
	$blockEmployeeInfo->addField($field9); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field10 = new Vtiger_Field();
	$field10->name = 'tax_no';
	$field10->label = 'Tax No';
	$field10->table = $module->basetable;
	$field10->column = 'tax_no';
	$field10->columntype = 'VARCHAR(100)';
	$field10->uitype = 1;
	$field10->typeofdata = 'V~O';
	$blockEmployeeInfo->addField($field10); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field11 = new Vtiger_Field();
	$field11->name = 'designation';
	$field11->label = 'Designation';
	$field11->table = $module->basetable;
	$field11->column = 'designation';
	$field11->columntype = 'VARCHAR(150)';
	$field11->uitype = 1;
	$field11->typeofdata = 'V~O';
	$blockEmployeeInfo->addField($field11); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field12 = new Vtiger_Field();
	$field12->name = 'pay_month';
	$field12->label = 'Month';
	$field12->table = $module->basetable;
	$field12->column = 'pay_month';
	$field12->columntype = 'VARCHAR(100)';
	$field12->uitype = 15;
	$field12->typeofdata = 'V~O';
	$field12->setPicklistValues( Array ('Jan', 'Feb','Mar','Apr', 'May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'));
	$blockEmployeeInfo->addField($field12); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field13 = new Vtiger_Field();
	$field13->name = 'pay_year';
	$field13->label = 'Year';
	$field13->table = $module->basetable;
	$field13->column = 'pay_year';
	$field13->columntype = 'VARCHAR(255)';
	$field13->uitype = 1;
	$field13->typeofdata = 'V~O';
	$blockEmployeeInfo->addField($field13); /** Creates the field and adds to block */

        	/** Create required fields and add to the block */
	$field14 = new Vtiger_Field();
	$field14->name = 'company_details';
	$field14->label = 'Company details';
	$field14->table = $module->basetable;
	$field14->column = 'company_details';
	$field14->columntype = 'VARCHAR(100)';
	$field14->uitype = 3993;
	$field14->typeofdata = 'V~M~LE~255';
	$blockEmployeeInfo->addField($field14); /** Creates the field and adds to block */

        /** Create required fields and add to the block */
	$field15 = new Vtiger_Field();
	$field15->name = 'basic_sal';
	$field15->label = 'Basic Salary';
	$field15->table = $module->basetable;
	$field15->column = 'basic_sal';
	$field15->columntype = 'DECIMAL(25,2)';
	$field15->uitype = 2;
	$field15->typeofdata = 'N~O';
	$blockEarningInformation->addField($field15); /** Creates the field and adds to block */
		
	
	 /** Create required fields and add to the block */
	$field16 = new Vtiger_Field();
	$field16->name = 'transport_allowance';
	$field16->label = 'Transport Allowance';
	$field16->table = $module->basetable;
	$field16->column = 'transport_allowance';
	$field16->columntype = 'DECIMAL(25,2)';
	$field16->uitype = 2;
	$field16->typeofdata = 'N~O';
	$blockEarningInformation->addField($field16); /** Creates the field and adds to block */
	
	 /** Create required fields and add to the block */
	$field17 = new Vtiger_Field();
	$field17->name = 'ph_allowance';
	$field17->label = 'Phone Allowance';
	$field17->table = $module->basetable;
	$field17->column = 'ph_allowance';
	$field17->columntype = 'DECIMAL(25,2)';
	$field17->uitype = 2;
	$field17->typeofdata = 'N~O';
	$blockEarningInformation->addField($field17); /** Creates the field and adds to block */
	

    /** Create required fields and add to the block */
	$field19 = new Vtiger_Field();
	$field19->name = 'parking_allowance';
	$field19->label = 'Parking Allowance';
	$field19->table = $module->basetable;
	$field19->column = 'parking_allowance';
	$field19->columntype = 'DECIMAL(25,2)';
	$field19->uitype = 2;
	$field19->typeofdata = 'N~O';
	$blockEarningInformation->addField($field19); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field20 = new Vtiger_Field();
	$field20->name = 'ot_meal_allowance';
	$field20->label = 'Overtime Meal Allowance';
	$field20->table = $module->basetable;
	$field20->column = 'ot_meal_allowance';
	$field20->columntype = 'DECIMAL(25,2)';
	$field20->uitype = 2;
	$field20->typeofdata = 'N~O';
	$blockEarningInformation->addField($field20); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field21 = new Vtiger_Field();
	$field21->name = 'oth_allowance';
	$field21->label = 'Other Allowance';
	$field21->table = $module->basetable;
	$field21->column = 'oth_allowance';
	$field21->columntype = 'DECIMAL(25,2)';
	$field21->uitype = 2;
	$field21->typeofdata = 'N~O';
	$blockEarningInformation->addField($field21); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field22 = new Vtiger_Field();
	$field22->name = 'gross_pay';
	$field22->label = 'Gross Pay';
	$field22->table = $module->basetable;
	$field22->column = 'gross_pay';
	$field22->columntype = 'DECIMAL(25,2)';
	$field22->uitype = 2;
	$field22->typeofdata = 'N~O';
	$blockEarningInformation->addField($field22); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field221 = new Vtiger_Field();
	$field221->name = 'net_pay';
	$field221->label = 'Net Pay';
	$field221->table = $module->basetable;
	$field221->column = 'net_pay';
	$field221->columntype = 'DECIMAL(25,2)';
	$field221->uitype = 2;
	$field221->typeofdata = 'N~O';
	$blockEarningInformation->addField($field221); /** Creates the field and adds to block */
	
	
	/** Create required fields and add to the block */
	$field23 = new Vtiger_Field();
	$field23->name = 'emp_epf';
	$field23->label = 'Employee EPF';
	$field23->table = $module->basetable;
	$field23->column = 'emp_epf';
	$field23->columntype = 'DECIMAL(25,2)';
	$field23->uitype = 2;
	$field23->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field23); /** Creates the field and adds to block */
	
	/** Create required fields and add to the block */
	$field24 = new Vtiger_Field();
	$field24->name = 'emp_socso';
	$field24->label = 'Employee SOCSO';
	$field24->table = $module->basetable;
	$field24->column = 'emp_socso';
	$field24->columntype = 'DECIMAL(25,2)';
	$field24->uitype = 2;
	$field24->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field24); /** Creates the field and adds to block */
	
		/** Create required fields and add to the block */
	$field25 = new Vtiger_Field();
	$field25->name = 'lhdn';
	$field25->label = 'LHDN';
	$field25->table = $module->basetable;
	$field25->column = 'lhdn';
	$field25->columntype = 'DECIMAL(25,2)';
	$field25->uitype = 1;
	$field25->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field25); /** Creates the field and adds to block */


    /** Create required fields and add to the block */
	$field26 = new Vtiger_Field();
	$field26->name = 'zakat';
	$field26->label = 'Zakat';
	$field26->table = $module->basetable;
	$field26->column = 'zakat';
	$field26->columntype = 'DECIMAL(25,2)';
	$field26->uitype = 2;
	$field26->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field26); /** Creates the field and adds to block */
	
	$field27 = new Vtiger_Field();
	$field27->name = 'other_deduction';
	$field27->label = 'Others';
	$field27->table = $module->basetable;
	$field27->column = 'other_deduction';
	$field27->columntype = 'DECIMAL(25,2)';
	$field27->uitype = 2;
	$field27->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field27); /** Creates the field and adds to block */

	$field28 = new Vtiger_Field();
	$field28->name = 'total_deduction';
	$field28->label = 'Total Deduction';
	$field28->table = $module->basetable;
	$field28->column = 'total_deduction';
	$field28->columntype = 'DECIMAL(25,2)';
	$field28->uitype = 2;
	$field28->typeofdata = 'N~O';
	$blockDeductionInformation->addField($field28); /** Creates the field and adds to block */

	$field29 = new Vtiger_Field();
	$field29->name = 'employer_epf';
	$field29->label = 'Employer EPF';
	$field29->table = $module->basetable;
	$field29->column = 'employer_epf';
	$field29->columntype = 'DECIMAL(25,2)';
	$field29->uitype = 2;
	$field29->typeofdata = 'N~O';
	$blockContributionInformation->addField($field29); /** Creates the field and adds to block */

	$field30 = new Vtiger_Field();
	$field30->name = 'employer_socso';
	$field30->label = 'Employer Socso';
	$field30->table = $module->basetable;
	$field30->column = 'employer_socso';
	$field30->columntype = 'DECIMAL(25,2)';
	$field30->uitype = 2;
	$field30->typeofdata = 'N~O';
	$blockContributionInformation->addField($field30); /** Creates the field and adds to block */

	$field31 = new Vtiger_Field();
	$field31->name = 'employer_eis';
	$field31->label = 'Employer Socso';
	$field31->table = $module->basetable;
	$field31->column = 'employer_eis';
	$field31->columntype = 'DECIMAL(25,2)';
	$field31->uitype = 2;
	$field31->typeofdata = 'N~O';
	$blockContributionInformation->addField($field31); /** Creates the field and adds to block */

	$field32 = new Vtiger_Field();
	$field32->name = 'hrdf';
	$field32->label = 'HRDF';
	$field32->table = $module->basetable;
	$field32->column = 'hrdf';
	$field32->columntype = 'DECIMAL(25,2)';
	$field32->uitype = 2;
	$field32->typeofdata = 'N~O';
	$blockContributionInformation->addField($field32); /** Creates the field and adds to block */

	$field33 = new Vtiger_Field();
	$field33->name = 'total_comp_contribution';
	$field33->label = 'Total  Company Contribution';
	$field33->table = $module->basetable;
	$field33->column = 'total_comp_contribution';
	$field33->columntype = 'DECIMAL(25,2)';
	$field33->uitype = 2;
	$field33->typeofdata = 'N~O';
	$blockContributionInformation->addField($field33); /** Creates the field and adds to block */

	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$blockEmployeeInfo->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$blockEmployeeInfo->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$blockEmployeeInfo->addField($field4);


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
	$adb->pquery("INSERT INTO `secondcrm_planpermission` (`planid`, `module`, `visible`) VALUES (?, ?, ?)",array(1,$MODULENAME, 1));
	
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
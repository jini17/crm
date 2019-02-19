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

	$MODULENAME = 'SalesTarget'; //Give your module name
	$PARENT 	= 'SALES';  //Give Parent name
	$ENTITYNAME = 'targetno'; //Give Duplicate check field name
	$ENTITYLABEL= 'Target No';

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

	$block1 = new Vtiger_Block();
	$block1->label = 'LBL_TARGET_INFORMATION';
	$module->addBlock($block1);

	// Add custom block (required to support Custom Fields)
	$block2 = new Vtiger_Block();
	$block2->label = 'LBL_DESCRIPTION_SCOPE';
	$module->addBlock($block2);

	$block3 = new Vtiger_Block();
	$block3->label = 'LBL_MONTHLY_TARGET';
	$module->addBlock($block3);
	
	$block4 = new Vtiger_Block();
	$block4->label = 'LBL_QUARTERLY_TARGET';
	$module->addBlock($block4);
	
	$block5 = new Vtiger_Block();
	$block5->label = 'LBL_ANNUAL_TARGET';
	$module->addBlock($block5);


	$field1  		= new Vtiger_Field();
	$field1->name 	= $ENTITYNAME;
	$field1->label 	= $ENTITYLABEL;
	$field1->uitype	= 4;
	$field1->column = $field1->name;
	$field1->columntype = 'VARCHAR(255)';
	$field1->typeofdata = 'V~M';
	$block1->addField($field1);

	$module->setEntityIdentifier($field1); //make primary key for module

	$field2 = new Vtiger_Field();
	$field2->name = 'target_title';
	$field2->label = 'Target Title';
	$field2->table = $module->basetable;
	$field2->column = 'target_title';
	$field2->columntype = 'VARCHAR(100)';
	$field2->uitype = 2;
	$field2->typeofdata = 'V~M'; // Varchar~Mandatory
	$block1->addField($field2); /** table and column are automatically set */
	// Set at-least one field to identifier of module record
	
	$field3 = new Vtiger_Field();
	$field3->name = 'targetyear';
	$field3->label = 'Target Year';
	$field3->table = $module->basetable;
	$field3->column = 'targetyear';
	$field3->columntype = 'VARCHAR(100)';
	$field3->uitype = 15;
	$field3->typeofdata = 'V~M'; // Varchar~Mandatory
	$field3->setPicklistValues( Array ('2015', '2016','2017','2018','2019','2020') );
	$block1->addField($field3); /** table and column are automatically set */
	
	$field4 = new Vtiger_Field();
	$field4->name = 'startingmonth';
	$field4->label = 'Starting Month';
	$field4->table = $module->basetable;
	$field4->column = 'startingmonth';
	$field4->columntype = 'VARCHAR(100)';
	$field4->uitype = 15;
	$field4->typeofdata = 'V~M'; // Varchar~Mandatory
	$field4->setPicklistValues( Array ('January', 'April') );
	$block1->addField($field4); /** table and column are automatically set */


	$field5 = new Vtiger_Field();
	$field5->name = 'targetstatus';
	$field5->label = 'Status';
	$field5->table = $module->basetable;
	$field5->column = 'targetstatus';
	$field5->columntype = 'VARCHAR(100)';
	$field5->uitype = 15;
	$field5->typeofdata = 'V~O'; // Varchar~Optional
	$field5->setPicklistValues( Array ('Active','InActive') );
	$block1->addField($field5); /** table and column are automatically set */
	

	$field7 = new Vtiger_Field();
	$field7->name = 'linktoproduct';
	$field7->label= 'Product';
	$field7->table = $module->basetable;
	$field7->column = 'linktoproduct';
	$field7->columntype = 'VARCHAR(2000)';
	$field7->uitype = 2001;
	$field7->typeofdata = 'V~O';
	$field7->helpinfo = 'Choose Single / Multiple Product';
	$block2->addField($field7);

	$field12 = new Vtiger_Field();
	$field12->name = 'targetuser';
	$field12->label = 'User/Group';
	$field12->table = $module->basetable;
	$field12->column = 'targetuser';
	$field12->columntype = 'VARCHAR(500)';
	$field12->uitype = 2003;//new uitype create same as ui Assigned to with some modification[see EditViewUI.tpl in smarty folder,search 999]
	$field12->typeofdata = 'V~O'; // Varchar~Optional
	$block2->addField($field12); /** table and column are automatically set */

	$field9 = new Vtiger_Field();
	$field9->name = 'combineproduct';
	$field9->label = 'Combine Product';
	$field9->table = $module->basetable;
	$field9->column = 'combineproduct';
	$field9->columntype = 'VARCHAR(2)';
	$field9->uitype = 56;
	$field9->typeofdata = 'V~O';
	$block2->addField($field9);
	
	$field11 = new Vtiger_Field();
	$field11->name = 'combineterritory';
	$field11->label = 'Combine Territory';
	$field11->table = $module->basetable;
	$field11->column = 'combineterritory';
	$field11->columntype = 'VARCHAR(2)';
	$field11->uitype = 56;
	$field11->typeofdata = 'V~O';
	$block2->addField($field11);
	
	
	$field8 = new Vtiger_Field();
	$field8->name = 'targettype';
	$field8->label= 'Target Type';
	$field8->table = $module->basetable;
	$field8->column = 'targettype';
	$field8->columntype = 'VARCHAR(100)';
	$field8->uitype = 15;
	$field8->typeofdata = 'V~M';
	$block2->addField($field8);
	$field8->setPicklistValues( Array ('Count','Amount') );

	
	$field13 = new Vtiger_Field();
	$field13->name = 'targetmodule';
	$field13->label = 'Target Module / Status';
	$field13->table = $module->basetable;
	$field13->column = 'targetmodule';
	$field13->columntype = 'VARCHAR(100)';
	$field13->uitype = 2004;
	$field13->typeofdata = 'V~M'; // Varchar~Mandatory
	$block2->addField($field13); /** table and column are automatically set */
	
	
	$field15 = new Vtiger_Field();
	$field15->name = 'jantarget';
	$field15->label = 'Jan Target';
	$field15->table = $module->basetable;
	$field15->column = 'jantarget';
	$field15->columntype = 'VARCHAR(255)';
	$field15->uitype = 7;
	$field15->typeofdata = 'V~O';
	$block3->addField($field15);
	
	$field16 = new Vtiger_Field();
	$field16->name = 'febtarget';
	$field16->label = 'Feb Target';
	$field16->table = $module->basetable;
	$field16->column = 'febtarget';
	$field16->columntype = 'VARCHAR(255)';
	$field16->uitype = 7;
	$field16->typeofdata = 'V~O';
	$block3->addField($field16);
	
	$field17 = new Vtiger_Field();
	$field17->name = 'marchtarget';
	$field17->label = 'March Target';
	$field17->table = $module->basetable;
	$field17->column = 'marchtarget';
	$field17->columntype = 'VARCHAR(255)';
	$field17->uitype = 7;
	$field17->typeofdata = 'V~O';
	$block3->addField($field17);

	$field18 = new Vtiger_Field();
	$field18->name = 'aprtarget';
	$field18->label = 'April Target';
	$field18->table = $module->basetable;
	$field18->column = 'aprtarget';
	$field18->columntype = 'VARCHAR(255)';
	$field18->uitype = 7;
	$field18->typeofdata = 'V~O';
	$block3->addField($field18);

	$field19 = new Vtiger_Field();
	$field19->name = 'maytarget';
	$field19->label = 'May Target';
	$field19->table = $module->basetable;
	$field19->column = 'maytarget';
	$field19->columntype = 'VARCHAR(255)';
	$field19->uitype = 7;
	$field19->typeofdata = 'V~O';
	$block3->addField($field19);

	$field20 = new Vtiger_Field();
	$field20->name = 'juntarget';
	$field20->label = 'Jun Target';
	$field20->table = $module->basetable;
	$field20->column = 'juntarget';
	$field20->columntype = 'VARCHAR(255)';
	$field20->uitype = 7;
	$field20->typeofdata = 'V~O';
	$block3->addField($field20);

	$field21 = new Vtiger_Field();
	$field21->name = 'julytarget';
	$field21->label = 'July Target';
	$field21->table = $module->basetable;
	$field21->column = 'julytarget';
	$field21->columntype = 'VARCHAR(255)';
	$field21->uitype = 7;
	$field21->typeofdata = 'V~O';
	$block3->addField($field21);

	$field22 = new Vtiger_Field();
	$field22->name = 'augtarget';
	$field22->label = 'August Target';
	$field22->table = $module->basetable;
	$field22->column = 'augtarget';
	$field22->columntype = 'VARCHAR(255)';
	$field22->uitype = 7;
	$field22->typeofdata = 'V~O';
	$block3->addField($field22);

	$field23 = new Vtiger_Field();
	$field23->name = 'septarget';
	$field23->label = 'September Target';
	$field23->table = $module->basetable;
	$field23->column = 'septarget';
	$field23->columntype = 'VARCHAR(255)';
	$field23->uitype = 7;
	$field23->typeofdata = 'V~O';
	$block3->addField($field23);

	$field24 = new Vtiger_Field();
	$field24->name = 'octtarget';
	$field24->label = 'October Target';
	$field24->table = $module->basetable;
	$field24->column = 'octtarget';
	$field24->columntype = 'VARCHAR(255)';
	$field24->uitype = 7;
	$field24->typeofdata = 'V~O';
	$block3->addField($field24);

	$field25 = new Vtiger_Field();
	$field25->name = 'novtarget';
	$field25->label = 'November Target';
	$field25->table = $module->basetable;
	$field25->column = 'novtarget';
	$field25->columntype = 'VARCHAR(255)';
	$field25->uitype = 7;
	$field25->typeofdata = 'V~O';
	$block3->addField($field25);

	$field26 = new Vtiger_Field();
	$field26->name = 'dectarget';
	$field26->label = 'December Target';
	$field26->table = $module->basetable;
	$field26->column = 'dectarget';
	$field26->columntype = 'VARCHAR(255)';
	$field26->uitype = 7;
	$field26->typeofdata = 'V~O';
	$block3->addField($field26);

	$field27 = new Vtiger_Field();
	$field27->name = 'q1target';
	$field27->label = 'Q1 Target';
	$field27->table = $module->basetable;
	$field27->column = 'q1target';
	$field27->columntype = 'VARCHAR(255)';
	$field27->uitype = 7;
	$field27->typeofdata = 'V~O';
	$block4->addField($field27);

	$field28 = new Vtiger_Field();
	$field28->name = 'q2target';
	$field28->label = 'Q2 Target';
	$field28->table = $module->basetable;
	$field28->column = 'q2target';
	$field28->columntype = 'VARCHAR(255)';
	$field28->uitype = 7;
	$field28->typeofdata = 'V~O';
	$block4->addField($field28);

	$field29 = new Vtiger_Field();
	$field29->name = 'q3target';
	$field29->label = 'Q3 Target';
	$field29->table = $module->basetable;
	$field29->column = 'q3target';
	$field29->columntype = 'VARCHAR(255)';
	$field29->uitype = 7;
	$field29->typeofdata = 'V~O';
	$block4->addField($field29);

	$field30 = new Vtiger_Field();
	$field30->name = 'q4target';
	$field30->label = 'Q4 Target';
	$field30->table = $module->basetable;
	$field30->column = 'q4target';
	$field30->columntype = 'VARCHAR(255)';
	$field30->uitype = 7;
	$field30->typeofdata = 'V~O';
	$block4->addField($field30);

	$field31 = new Vtiger_Field();
	$field31->name = 'annualtarget';
	$field31->label = 'Annual Target';
	$field31->table = $module->basetable;
	$field31->column = 'annualtarget';
	$field31->columntype = 'VARCHAR(255)';
	$field31->uitype = 7;
	$field31->typeofdata = 'V~O';
	$block5->addField($field31);


/** Common fields that should be in every module, linked to vtiger CRM core table
*/
	$field32 = new Vtiger_Field();
	$field32->name = 'assigned_user_id';
	$field32->label = 'Assigned To';
	$field32->table = 'vtiger_crmentity';
	$field32->column = 'smownerid';
	$field32->uitype = 53;
	$field32->typeofdata = 'V~M';
	$block1->addField($field32);

	$field33 = new Vtiger_Field();
	$field33->name = 'CreatedTime';
	$field33->label= 'Created Time';
	$field33->table = 'vtiger_crmentity';
	$field33->column = 'createdtime';
	$field33->uitype = 70;
	$field33->typeofdata = 'T~O';
	$field33->displaytype= 2;
	$block1->addField($field33);
	
	$field34 = new Vtiger_Field();
	$field34->name = 'ModifiedTime';
	$field34->label= 'Modified Time';
	$field34->table = 'vtiger_crmentity';
	$field34->column = 'modifiedtime';
	$field34->uitype = 70;
	$field34->typeofdata = 'T~O';
	$field34->displaytype= 2;
	$block1->addField($field34);


// Create default custom filter (mandatory)
	$filter1 = new Vtiger_Filter();
	$filter1->name = 'All';
	$filter1->isdefault = true;
	$module->addFilter($filter1);
	// Add fields to the filter created
	$filter1->addField($field1)->addField($field2, 1)->addField($field3, 2)->addField($field12, 3);
	
	/** Set sharing access of this module */
	
	/** Enable and Disable available tools */
	$module->enableTools(Array('Import', 'Export'));
	$module->disableTools('Merge');

	$module->addLink("LISTVIEW", "LBL_TARGET_GENERATE", "SalesTarget_Target_Js.GenerateTarget('index.php?module=SalesTarget&view=GenerateTarget')");
	$module->addLink('LISTVIEW', 'LBL_TARGET_REPORT', "index.php?module=SalesTarget&view=ReportTarget&record=$RECORD$");

	// Sharing Access Setup
	$module->setDefaultSharing();

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
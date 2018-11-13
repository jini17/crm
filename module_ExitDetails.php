<?php

/** Create New Vtlib script for module Creation
  * created : 22 Feb 2018
  * Author  : Jitendra Gupta <jitendraknp2004@gmail.com>
  * For enable Related list go line no 181 and uncomment / modify as per your requirement
  */

/*error_reporting(1);
		ini_set('display_erros',1);
		 
		  register_shutdown_function('handleErrors');       
		    function handleErrors() { 
			 
		       $last_error = error_get_last(); 
		     	
		       if (!is_null($last_error)) { // if there has been an error at some point 
		     
			  // do something with the error 
			  print_r($last_error); 
		     
		       } 
		     
		    }*/

	include_once('vtlib/Vtiger/Menu.php');
	include_once('vtlib/Vtiger/Module.php');
	include_once('vtlib/Vtiger/Package.php');
	include_once 'includes/main/WebUI.php';
	include_once 'include/Webservices/Utils.php';

	global $adb;

	$adb->setDebug(true);
	$Vtiger_Utils_Log = true;

	$MODULENAME = 'ExitDetails'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'title'; //Give Duplicate check field name
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

	$block = new Vtiger_Block();
	$block->label = 'LBL_EXITDETAILS_INFORMATION';
	$module->addBlock($block);	
        
        
	$field1  = new Vtiger_Field();
	$field1->name = "resignation";
	$field1->label= "LBL_RESIGNATION";
	$field1->uitype= 56;
	$field1->column = $field1->name;
	$field1->columntype = 'INT';
	$field1->typeofdata = 'I';
	$block->addField($field1);

                    $field2  = new Vtiger_Field();
                    $field2->name = "retirement";
                    $field2->label=  "LBL_RETIREMENT";
                    $field2->uitype= 56;
                    $field2->column = $field2->name;
                    $field2->columntype = 'INT';
                    $field2->typeofdata = 'I';
                    $block->addField($field2);
	      
                    $field3  = new Vtiger_Field();
                    $field3->name = "reason" ;
                    $field3->label= "LBL_REGSIGNATION_REASON";
                    $field3->uitype= 19;
                    $field3->column = $field3->name;
                    $field3->columntype = 'TEXT';
                    $field3->typeofdata = 'V~M';
                    $field3->displaytype = 5;
                    $block->addField($field3);                                                       
                    
                      /* END BLOCK*/
                    
                     $block1 = new Vtiger_Block();
	$block1->label = 'LBL_PERSONAL_DETAILS';
                    $module->addBlock($block1);	
                    
                    $field5  = new Vtiger_Field();
                    $field5->name = "first_name";
                    $field5->label= "LBL_FIRST_NAME";
                    $field5->uitype= 2;
                    $field5->column = $field5->name;
                    $field5->columntype = 'VARCHAR (30)';
                    $field5->typeofdata = 'V~M';              
                    $block1->addField($field5);                    
                    
                    $field6  = new Vtiger_Field();
                    $field6->name = "last_name";
                    $field6->label= "LBL_LAST_NAME";
                    $field6->uitype= 2;
                    $field6->column = $field6->name;
                    $field6->columntype = 'VARCHAR (30)';
                    $field6->typeofdata = 'V~M';              
                    $block1->addField($field6);                         
                    
                    $field14  = new Vtiger_Field();
                    $field14->name = "home_address";
                    $field14->label= "LBL_HOME ADDRESS";
                    $field14->uitype= 2;
                    $field14->column = $field14->name;
                    $field14->columntype = 'VARCHAR (100)';
                    $field14->typeofdata = 'V~M';              
                    $block1->addField($field14);    
                                    
                    $field16  = new Vtiger_Field();
                    $field16->name = "email_address";
                    $field16->label= "LBL_EMAIL ADDRESS";
                    $field16->uitype= 2;
                    $field16->column = $field16->name;
                    $field16->columntype = 'VARCHAR (100)';
                    $field16->typeofdata = 'V~M';              
                    $block1->addField($field16);    
                                     
                    $field15  = new Vtiger_Field();
                    $field15->name = "contact_number";
                    $field15->label= "LBL_CONTACT_NUMBER";
                    $field15->uitype= 2;
                    $field15->column = $field4->name;
                    $field15->columntype = 'I';
                    $field15->typeofdata = 'I~M';              
                    $block1->addField($field15);       
         
                    $field6  = new Vtiger_Field();
                    $field6->name = "employee_no";
                    $field6->label= "LBL_EMPLOYEE_NO";
                    $field6->uitype= 56;
                    $field6->column = $field4->name;
                    $field6->columntype = 'VARCHAR (20)';
                    $field6->typeofdata = 'V~M';              
                    $block1->addField($field6);                
                    
                    $field7 = new Vtiger_Field();
                    $field7->name = "department";
                    $field7->label= 'LBL_DEPARTMENT';
                    $field7->table = 'vtiger_department';
                    $field7->column = 'department';
                    $field7->columntype = 'VARCHAR(100)';
                    $field7->uitype = 15;
                    $field7->typeofdata = 'V~O';
                    $block1->addField($field7);    
                    

                    $field8 = new Vtiger_Field();
                    $field8->name = "grade";
                    $field8->label= 'LBL_GRADE';
                    $field8->table = 'vtiger_grade';
                    $field8->column = 'grade';
                    $field8->columntype = 'VARCHAR(100)';
                    $field8->uitype = 15;
                    $field8->typeofdata = 'V~O';
                    $block1->addField($field8);                      
                    
                    $field9 = new Vtiger_Field();
                    $field9->name = 'reporting_manager';
                    $field9->table = $module->basetable;
                    $field9->label = 'LBL_REPORTING_MANAGER';
                    $field9->column = 'reports_to';
                    $field9->columntype = 'int(11)';
                    $field9->uitype = 101;
                    $field9->typeofdata = 'I~M';
                    $block1->addField($field9);                   

                     $field10  = new Vtiger_Field();
                    $field10->name = "office_address";
                    $field10->label= "LBL_OFFICE_ADDRESS";
                    $field10->uitype= 2;
                    $field10->column = $field10->name;
                    $field10->columntype = 'VARCHAR (100)';
                    $field10->typeofdata = 'V~M';              
                    $block1->addField($field10);    
                    
                    $field11 = new Vtiger_Field();
	$field11->name = 'personal_email';
	$field11->label = 'LBL_PERSONAL_EMAIL';	
	$field11->column =  $field10->name;
	$field11->uitype = 2;
	$field11->typeofdata = 'V~M';
	$block1->addField($field11);
        
                     $field12 = new Vtiger_Field();
	$field12->name = 'contact_number';
	$field12->label = 'LBL_CONTACT_NUMBER';	
	$field12->column =  $field12->name;
	$field12->uitype = 2;
	$field12->typeofdata = 'I~M';
	$block1->addField($field12);
        
                    $field13 = new Vtiger_Field();
                    $field13->name = 'job_type';
                    $field13->label= 'LBL_JOB_TYPE';
                    $field13->table = 'vtiger_job_type';
                    $field13->column = $field13->name ;
                    $field13->columntype = 'VARCHAR(20)';
                    $field13->uitype = 15;
                    $field13->typeofdata = 'V~O';
                    $block1->addField($field13);                                          
                   

                     $field17  = new Vtiger_Field();
                    $field17->name = "description" ;
                    $field17->label= "LBL_DESCRIPTION";
                    $field17->uitype= 19;
                    $field17->column = $field13->name;
                    $field17->columntype = 'TEXT';
                    $field17->typeofdata = 'V~M';
                    $field17->displaytype = 5;                    
                    $block1->addField($field17);
                    
                    $field14  = new Vtiger_Field();
                    $field14->name = "submit_date" ;
                    $field14->label= "LBL_SUBMIT_DATE";
                    $field14->uitype= 2;
                    $field14->column = $field14->name;
                    $field14->columntype = 'DATE';
                    $field14->typeofdata = 'D~M';
                    $block1->addField($field14);
                    
                    $field30  = new Vtiger_Field();
                    $field30->name = "review_date" ;
                    $field30->label= "LBL_SUBMIT_DATE";
                    $field30->uitype= 2;
                    $field30->column = $field14->name;
                    $field30->columntype = 'DATE';
                    $field30->typeofdata = 'D~M';
                    $block1->addField($field30);
             
                    
                  
                    
	/**
		ADD YOUR FIELDS HERE
	*/

	

	// Create default custom filter (mandatory)
	$filter = new Vtiger_Filter();
	$filter->name = 'All';
	$filter->isdefault = true;

	$module->addFilter($filter);
	// Add fields to the filter created
	$filter->addField($field1)->addField($field5, 1)->addField($field6, 2)->addField($field7, 3)->addField($field2, 4);

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

	//Enable Comment module
	require_once 'modules/ModComments/ModComments.php';
	$commentsmodule = vtiger_module::getinstance( 'ModComments' );
	$fieldinstance = vtiger_field::getinstance( 'related_to', $commentsmodule );
	$fieldinstance->setrelatedmodules( array($MODULENAME) );
	$detailviewblock = modcomments::addwidgetto( $MODULENAME );

	echo "comment widget for module $modulename has been created";
	//end here

	//Tracking History
	ModTracker::disableTrackingForModule($module->id);
	ModTracker::enableTrackingForModule($module->id);
	echo "History Enabled";
	//end here

	//Add your related module name & custom function (get_payslip) & CUSTOM_LABEL (Display name in related module tab of detailview)
	//$relatedmodule = 'Payslip';
	//$module->setRelatedList(Vtiger_Module::getInstance($relatedmodule ), 'CUSTOM_LABEL', array('ADD','SELECT'), 'get_payslip');
	//end here

	function createFiles(Vtiger_Module $module, Vtiger_Field $entityField) {

		$targetpath = 'modules/' . $module->name;
		$targetSummaryTemplate = 'layouts/fask/modules/' . $module->name;


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

			if(!copy($templatepath.'/DetailViewSummaryContents.tpl', $targetSummaryTemplate.'/DetailViewSummaryContents.tpl')){
				echo "failed to copy DetailViewSummaryContents.tpl ...\n";
			}
			if(!copy($templatepath.'/ModuleSummaryView.tpl', $targetSummaryTemplate.'/ModuleSummaryView.tpl')){
				echo "failed to copy ModuleSummaryView.tpl ...\n";
			}
			if(!copy($templatepath.'/SummaryViewWidgets.tpl', $targetSummaryTemplate.'/SummaryViewWidgets.tpl')){
				echo "failed to copy SummaryViewWidgets.tpl ...\n";
			}

		}
	}

	
?>

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

	$MODULENAME = 'ExitInterView'; //Give your module name
	$PARENT 	= 'Admin';  //Give Parent name
	$ENTITYNAME = 'Employeeid'; //Give Duplicate check field name
	$ENTITYLABEL= 'Employeeid';

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
	$block->label = 'LBL_EXITINTERVIEW_Information';
	$module->addBlock($block);

	      
                    $field1 = new Vtiger_Field();
                    $field1->name = 'employee';
                    $field1->table = $module->basetable;
                    $field1->label = 'LBL_EMPLOYEE';
                    $field1->column = 'employee_id';
                    $field1->columntype = 'int(11)';
                    $field1->uitype = 101;
                    $field1->typeofdata = 'I~M';
                    $block->addField($field1); 
                    $module->setEntityIdentifier($field1); //make primary key for module

                      $field2 = new Vtiger_Field();
	$field2->name = 'interviewer';
	$field2->label = 'Interviewer';
	$field2->table = $module->basetable;
	$field2->column = 'interviewer';
	$field2->columntype = 'INT(11)';
	$field2->uitype = 101;
	$field2->displaytype = 5;
	$field2->typeofdata = 'V~M'; // varchar~Mandatory
	$block->addField($field2); /** table and column are automatically set */
        
                     $field3 = new Vtiger_Field();
	$field3->name = 'notice_period';
	$field3->label = 'LBL_NOTICE_PERIOD';	
	$field3->column =  $field3->name;
	$field3->uitype = 2;
	$field3->typeofdata = 'I~M';
	$block->addField($field3);

                     $field4 = new Vtiger_Field();
	$field4->name = 'notice_period';
	$field4->label = 'LBL_NOTICE_PERIOD';	
	$field4->column =  $field4->name;
	$field4->uitype = 2;
	$field4->typeofdata = 'I~M';
	$block->addField($field4);
        
                     $field5  = new Vtiger_Field();
	$field5->name = "served_notice_period";
	$field5->label= "LBL_SERVED_NOTICE_PEROID";
	$field5->uitype= 56;
	$field5->column = $field5->name;
	$field5->columntype = 'INT';
	$field5->typeofdata = 'I';
	$block->addField($field5);
        
                    $field6  = new Vtiger_Field();
                    $field6->name = "date_of_leaving" ;
                    $field6->label= "LBL_LEAVING_DATE";
                    $field6->uitype= 2;
                    $field6->column = $field6->name;
                    $field6->columntype = 'DATE';
                    $field6->typeofdata = 'D~M';
                    $block->addField($field6);

              
                    
                     $field7  = new Vtiger_Field();
                    $field7->name = "reason" ;
                    $field7->label= "LBL_REASON";
                    $field7->uitype= 19;
                    $field7->column = $field7->name;
                    $field7->columntype = 'TEXT';
                    $field7->typeofdata = 'V~M';
                    $field7->displaytype = 5;                    
                    $block->addField($field7);
                    
                     $block1 = new Vtiger_Block();
	$block1->label = 'LBL_QUESTIONNARIE';
                    $module->addBlock($block1);	
                    
                    $field8 = new vtiger_field();
                    $field8->name = 'q1';
                    $field8->label = 'Will the employee work for this organization again?';
                    $field8->columntype = 'varchar(100)';
                    $field8->uitype = 15;
                    $field8->typeofdata = 'V~O';// varchar~optional
                    $block1->addfield($field8); /** table and column are automatically set */
                    $field8->setpicklistvalues( array ('Interested', 'Not interested', 'Not interested','Not sure') );      
                    
                    $field9  = new Vtiger_Field();
                    $field9->name = "q2" ;
                    $field9->label= "What did you like most of the organization?";
                    $field9->uitype= 19;
                    $field9->column = $field9->name;
                    $field9->columntype = 'TEXT';
                    $field9->typeofdata = 'V~M';
                    $field9->displaytype = 5;                    
                    $block1->addField($field9);
                    
                     $field10  = new Vtiger_Field();
                    $field10->name = "q3" ;
                    $field10->label= "Think the organization do to improve staff welfare?";
                    $field10->uitype= 19;
                    $field10->column = $field10->name;
                    $field10->columntype = 'TEXT';
                    $field10->typeofdata = 'V~M';
                    $field10->displaytype = 5;                    
                    $block1->addField($field10);
                    
                    $field11  = new Vtiger_Field();
                    $field11->name = "q4" ;
                    $field11->label= "Anything you wish to share with us?";
                    $field11->uitype= 19;
                    $field11->column = $field11->name;
                    $field11->columntype = 'TEXT';
                    $field11->typeofdata = 'V~M';
                    $field11->displaytype = 5;                    
                    $block1->addField($field11);
                    
                    $field12  = new Vtiger_Field();
                    $field12->name = "q4" ;
                    $field12->label= "Think the organization do to improve staff welfare?";
                    $field12->uitype= 19;
                    $field12->column = $field12->name;
                    $field12->columntype = 'TEXT';
                    $field12->typeofdata = 'V~M';
                    $field12->displaytype = 5;                    
                    $block1->addField($field12);
                    
                    $block2 = new Vtiger_Block();
                    $block2->label = 'LBL_EXIT_CHECKLIST';
                    $module->addBlock($block2);
                    
                    $field13  = new Vtiger_Field();
                    $field13->name = "vehicle_handed";
                    $field13->label= "LBL_VEHICLE_HANDED";
                    $field13->uitype= 56;
                    $field13->column = $field13->name;
                    $field13->columntype = 'VARCHAR (20)';
                    $field13->typeofdata = 'V~M';              
                    $block2->addField($field13);          
                    
                    $field14  = new Vtiger_Field();
                    $field14->name = "office_metarials";
                    $field14->label= "LBL_OFFICE_METARIALS";
                    $field14->uitype= 56;
                    $field14->column = $field14->name;
                    $field14->columntype = 'VARCHAR (20)';
                    $field14->typeofdata = 'V~M';              
                    $block2->addField($field14);    
                    
                    $field15  = new Vtiger_Field();
                    $field15->name = "exit_interview_conducted";
                    $field15->label= "LBL_EXIT_INTERVIEW_CONDUCTED";
                    $field15->uitype= 56;
                    $field15->column = $field15->name;
                    $field15->columntype = 'VARCHAR (20)';
                    $field15->typeofdata = 'V~M';              
                    $block2->addField($field15);    
                    
                    $field16  = new Vtiger_Field();
                    $field16->name = "equipment_handed";
                    $field16->label= "LBL_EQUIPMENT_HANDED";
                    $field16->uitype= 56;
                    $field16->column = $field16->name;
                    $field16->columntype = 'VARCHAR (20)';
                    $field16->typeofdata = 'V~M';          
                    
                    $block2->addField($field16);    
                    
                     $field17  = new Vtiger_Field();
                    $field17->name = "access_id_submitted";
                    $field17->label= "LBL_ACCESSID_SUBMITTED";
                    $field17->uitype= 56;
                    $field17->column = $field17->name;
                    $field17->columntype = 'VARCHAR (20)';
                    $field17->typeofdata = 'V~M';          
                    
                    $block2->addField($field17);  
                    
                    $field18  = new Vtiger_Field();
                    $field18->name = "laptop_mobile_handed";
                    $field18->label= "LBL_LAPTOP_MOBILE_SUBMITTED";
                    $field18->uitype= 56;
                    $field18->column = $field18->name;
                    $field18->columntype = 'VARCHAR (20)';
                    $field18->typeofdata = 'V~M';          
                    
                    $block2->addField($field18);  
                    
                      
                    $field19  = new Vtiger_Field();
                    $field19->name = "manager_supervisor_clearance";
                    $field19->label= "LBL_MANAGER_SUPERVISOR_CLEARANCE";
                    $field19->uitype= 56;
                    $field19->column = $field19->name;
                    $field19->columntype = 'VARCHAR (20)';
                    $field19->typeofdata = 'V~M';          
                    
                    $block2->addField($field19);  
                    
                       
                    $block3 = new Vtiger_Block();
                    $block3->label = 'LBL_KNOWLEDGE_TRANSFER_SESSION';
                    $module->addBlock($block3);
                    
                    $field20  = new Vtiger_Field();
                    $field20->name = "knowledge_transfer_session";
                    $field20->label= "LBL_KNOWLEDGE_TRANSFER_SESSION";
                    $field20->uitype= 56;
                    $field20->column = $field20->name;
                    $field20->columntype = 'VARCHAR (20)';
                    $field20->typeofdata = 'V~M';    
                     $block3->addField($field20);  
                     
                    $field21 = new Vtiger_Field();
                    $field21->name = 'kt_session_details';
                    $field21->table = $module->basetable;
                    $field21->label = 'LBL_KT_SESSION_DETAILS';
                    $field21->column = 'reports_to';
                    $field21->columntype = 'int(11)';
                    $field21->uitype = 101;
                    $field21->typeofdata = 'I~M';
                    $block3->addField($field21);       
                    
	/**
		ADD YOUR FIELDS HERE
	*/

	/** Common fields that should be in every module, linked to vtiger CRM core table */
	$field2 = new Vtiger_Field();
	$field2->name = 'assigned_user_id';
	$field2->label = 'Assigned To';
	$field2->table = 'vtiger_crmentity';
	$field2->column = 'smownerid';
	$field2->uitype = 53;
	$field2->typeofdata = 'V~M';
	$block->addField($field2);

	$field3 = new Vtiger_Field();
	$field3->name = 'createdtime';
	$field3->label= 'Created Time';
	$field3->table = 'vtiger_crmentity';
	$field3->column = 'createdtime';
	$field3->uitype = 70;
	$field3->typeofdata = 'T~O';
	$field3->displaytype= 2;
	$block->addField($field3);

	$field4 = new Vtiger_Field();
	$field4->name = 'modifiedtime';
	$field4->label= 'Modified Time';
	$field4->table = 'vtiger_crmentity';
	$field4->column = 'modifiedtime';
	$field4->uitype = 70;
	$field4->typeofdata = 'T~O';
	$field4->displaytype= 2;
	$block->addField($field4);


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

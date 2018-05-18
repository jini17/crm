<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Holidays';

// Create module instance and save it first
$moduleInstance = Vtiger_Module::getInstance($MODULENAME);
/*if ($moduleInstance || file_exists('modules/'.$MODULENAME)) {
        echo $MODULENAME." Module already present - choose a different name.";
} else {*/
        $moduleInstance = new Vtiger_Module();
        $moduleInstance->name = $MODULENAME;
        $moduleInstance->parent = 'Sales';
        $moduleInstance->save();

	// Webservice Setup
	$moduleInstance->initWebservice();
	
	// Schema Setup
    $moduleInstance->initTables();

	// Add the basic module block
	$holidayInformation = new Vtiger_Block();
	$holidayInformation->label = 'Holiday Information';
	$moduleInstance->addBlock($holidayInformation);	

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'holidayname';
	$field1->label = 'Holiday Name';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'holidayname';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$holidayInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'startdate';
	$field2->label = 'Start Date';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'startdate';
	$field2->columntype = 'DATE';
	$field2->uitype = 5;
	$field2->typeofdata = 'D~O'; // varchar~Mandatory	
	$holidayInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'enddate';
	$field3->label = 'End Date';
	$field3->table = $moduleInstance->basetable;
	$field3->column = 'enddate';
	$field3->columntype = 'DATE';
	$field3->uitype = 5;
	$field3->typeofdata = 'D~O'; // varchar~Mandatory	
	$holidayInformation->addField($field3); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field4 = new Vtiger_Field();
	$field4->name = 'location';
	$field4->label = 'Location';
	$field4->table = $moduleInstance->basetable;
	$field4->column = 'location';
	$field4->columntype = 'VARCHAR(255)';
	$field4->uitype = 1;
	$field4->typeofdata = 'V~O'; // varchar~Mandatory	
	$holidayInformation->addField($field4); /** Creates the field and adds to block */
	

	/** Create required fields and add to the block */
	$field5 = new Vtiger_Field();
	$field5->name = 'holidayid';
	$field5->label = 'Holiday ID';
	$field5->table = $module->basetable;
	$field5->column = 'holidayid';
	$field5->columntype = 'VARCHAR(100)';
	$field5->uitype = 4;
	$field5->typeofdata = 'V~M';
	$holidayInformation->addField($field5); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field6 = new Vtiger_Field();
	$field6->name = 'assignedto';
	$field6->label = 'Assigned To';
	$field6->table = $moduleInstance->basetable;
	$field6->column = 'assignedto';
	$field6->columntype = 'VARCHAR(50)';
	$field6->uitype = 15;
	$field6->typeofdata = 'V~O'; 
	$field6->setPicklistValues( Array ('Users', 'Groups'));
	$holidayInformation->addField($field6); /** Creates the field and adds to block */
	

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
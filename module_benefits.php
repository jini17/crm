<?php
include_once('vtlib/Vtiger/Menu.php');
include_once('vtlib/Vtiger/Module.php');
// Turn on debugging level
$Vtiger_Utils_Log = true;

$MODULENAME = 'Benefits';

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
	$benefitsInformation = new Vtiger_Block();
	$benefitsInformation->label = 'Benefits Information';
	$moduleInstance->addBlock($benefitsInformation);
	
	$description = new Vtiger_Block();
	$description->label = 'Description';
	$moduleInstance->addBlock($description);

	
	/** Create required fields and add to the block */
	$field1 = new Vtiger_Field();
	$field1->name = 'benefits';
	$field1->label = 'Benefits';
	$field1->table = $moduleInstance->basetable;
	$field1->column = 'benefits';
	$field1->columntype = 'VARCHAR(255)';
	$field1->uitype = 2;
	$field1->typeofdata = 'V~M';
	$benefitsInformation->addField($field1); /** Creates the field and adds to block */

	// Set at-least one field to identifier of module record
	$moduleInstance->setEntityIdentifier($field1);

	/** Create required fields and add to the block */
	$field2 = new Vtiger_Field();
	$field2->name = 'status';
	$field2->label = 'Status';
	$field2->table = $moduleInstance->basetable;
	$field2->column = 'status';
	$field2->columntype = 'VARCHAR(3)';
	$field2->uitype = 56;
	$field2->typeofdata = 'C~M'; // varchar~Mandatory	
	$benefitsInformation->addField($field2); /** Creates the field and adds to block */

	/** Create required fields and add to the block */
	$field3 = new Vtiger_Field();
	$field3->name = 'description';
	$field3->label = 'Description';
	$field3->table = $moduleInstance->basetable;
	$field3->column = 'description';
	$field3->columntype = 'TEXT';
	$field3->uitype = 21;
	$field3->typeofdata = 'V~O'; // varchar~Mandatory	
	$description->addField($field3); /** Creates the field and adds to block */


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
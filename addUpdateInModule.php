<?php

//Added By Mabruk
include_once('vtlib/Vtiger/Module.php');
require_once('modules/ModTracker/ModTracker.php');
$Vtiger_Utils_Log = true;
$module = Vtiger_Module::getInstance('Training');
ModTracker::disableTrackingForModule($module->id);
ModTracker::enableTrackingForModule($module->id);

?>

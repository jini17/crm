<?php

require_once 'vtlib/Vtiger/Module.php';
$vtiger_utils_log = true;

$modulename = 'Leave';
$moduleinstance = vtiger_module::getinstance($modulename);

require_once 'modules/ModComments/ModComments.php';
$commentsmodule = vtiger_module::getinstance( 'ModComments' );
$fieldinstance = vtiger_field::getinstance( 'related_to', $commentsmodule );
$fieldinstance->setrelatedmodules( array($modulename) );
$detailviewblock = modcomments::addwidgetto( $modulename );
echo "comment widget for module $modulename has been created";

?>

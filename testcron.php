<?php
/*+*******************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

/**
 * Start the cron services configured.
 */
/*
error_reporting(1);
		ini_set('display_erros',1);

		  register_shutdown_function('handleErrors');
		    function handleErrors() {

		       $last_error = error_get_last();

		       if (!is_null($last_error)) { // if there has been an error at some point

			  // do something with the error
			  print_r($last_error);

		       }

		    }*/
include_once 'vtlib/Vtiger/Cron.php';
require_once 'config.inc.php';
require_once('modules/Emails/mail.php');

if (file_exists('config_override.php')) {
	include_once 'config_override.php';
}

// Extended inclusions
require_once 'includes/Loader.php';
vimport ('includes.runtime.EntryPoint');

$site_URLArray = explode('/',$site_URL);

$version = explode('.', phpversion());

$php = ($version[0] * 10000 + $version[1] * 100 + $version[2]);
if($php <  50300){
	$hostName = php_uname('n');
} else {
	$hostName = gethostname();
}

$mailbody ="Instance dir : $root_directory <br/> Site Url : $site_URL <br/> Host Name : $hostName<br/>";
$mailSubject = "[Alert] ";



require_once('cron/modules/com_vtiger_workflow/com_vtiger_workflow.service');




?>

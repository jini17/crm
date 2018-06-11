<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * modified by: crm-now, www.crm-now.de
 ********************************************************************************/
// conditions for customer portal
require_once('modules/Payslip/pdfcreator.php');
global $adb,$app_strings,$focus,$current_user;
// Request from Customer Portal for downloading the file.

createpdffile($_REQUEST[record],'print');

?>
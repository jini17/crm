<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ***********************************************************************************/

Class Office365_Config_Connector {
	static $clientId = 'e30075a9-6802-4e9e-b9b1-f089d606adb4';
	static $clientSecret = 'mbfenTH5{;ntKXAJX9529}+';

	static function getRedirectUrl() {

		global $site_URL;
		return $site_URL.'modules/Office365/authorize.php';
	}
}

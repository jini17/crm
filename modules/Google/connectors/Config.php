<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ***********************************************************************************/

Class Google_Config_Connector {
	static $clientId = '758332481783-7pqj0u7hm76d7vjleqf6rk0a80f47pfg.apps.googleusercontent.com';
	static $clientSecret = 'WT0XsugRfeudZOGyVepX1tME';
//	static $clientSecretFile = 'dwwwwwwww';
	//static $accessKey = '';

	static function getRedirectUrl() {
		global $site_URL;
		return $site_URL.'index.php?module=Google&view=Authenticate&service=Google';
	}
}

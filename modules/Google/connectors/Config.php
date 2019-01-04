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


	static $clientId = '822496829912-bvnhe5embvssrk0f8ugviq4jeajh6j4f.apps.googleusercontent.com';
	static $clientSecret = 'Xi-8PBCq2gmCKmnRacGaHjob';



	static function getRedirectUrl() {
		global $site_URL;
		return $site_URL.'index.php?module=Google&view=Authenticate&service=Google';
	}
}

<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ***********************************************************************************/

Class Outlook_Config_Connector {
	static $clientId = 'bf79087b-97d6-4659-a2be-7095cb6be576';
	static $clientSecret = 'mgnYXB80+!?nhmaQGEM781|';

	static function getRedirectUrl() {
		global $site_URL;
		return $site_URL.'index.php?module=Office365&view=Authenticate&service=Office365';
	}
}

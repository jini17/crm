<?php
require('config.inc.php');
require_once('include/utils/utils.php');
global $adb;

$query = $adb->pquery("SELECT access_token FROM `vtiger_office365_oauth2`",array());
$result = $adb->query_result($query,0,'access_token');
$result2 = $adb->query_result($query,1,'access_token');

$result = html_entity_decode($result);
print_r(json_decode($result));die;

?>
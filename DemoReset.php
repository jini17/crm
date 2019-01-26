<?php
	
	include_once 'config.inc.php';
	$resetsamplesqlpath = "/home/centos/demo.sql";

	include('truncatedata.php');
		
	$password = $dbconfig['db_password'];
	exec("mysql -h ".$dbconfig['db_server']." -P 33060 -u ".$dbconfig['db_username']." -p'$password' ". $dbconfig['db_name']. " < ".$resetsamplesqlpath);
?>
<?php
/**********************
to fetch data office365
**********************/

	$redirect_uri="http://localhost/vtigercrm/index.php?module=Office365&view=Authenticate&service=Office365";
	session_start();
	$_SESSION['code']=$_GET['code'];



	header('Location: '. $redirect_uri);
	



?>
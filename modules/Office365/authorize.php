<?php
/**********************
to fetch data office365
**********************/

	$redirect_uri="http://localhost/officeintegration/index.php?module=Office365&view=Authenticate&service=Office365";
	session_start();
	$_SESSION['code']=$_GET['code'];
    //echo "<pre>"; print_r($redirect_uri); die;


	header('Location: '. $redirect_uri);
	



?>
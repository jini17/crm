<?php
/**********************
to fetch data office365
**********************/
	global $site_URL;
	$redirect_uri=$site_URL."/index.php?module=Office365&view=Authenticate&service=Office365";
	session_start();
	$_SESSION['code']=$_GET['code'];
    //echo "<pre>"; print_r($redirect_uri); die;


	header('Location: '. $redirect_uri);
	



?>
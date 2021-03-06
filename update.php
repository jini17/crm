<?php


$URL = 'http://192.168.2.68/secondcrm/webservice.php';
$CRM_UserName = 'admin';
$CRM_UserAccessKey = 'npGCtIUqv6BsH1OW';

$CHALLENGEURL = $URL."?operation=getchallenge&username=".$CRM_UserName;

$curl = curl_init($CHALLENGEURL);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
$TOKENDATA = json_decode($result);

$CRM_TOKEN = $TOKENDATA->result->token;


$curl = curl_init($URL);
$curl_post_data = array(
			'operation' => 'login',
			'username' => $CRM_UserName,
			'accessKey' => md5($CRM_TOKEN.$CRM_UserAccessKey),
			);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$response = json_decode(curl_exec($curl));

	if(!$response->success){
		echo "ERROR " . $response->error->message . "<br>\n";die;
	}

$sessionID = $response->result->sessionName;
$userId=$response->result->userId;



// Obtained from account creation example
$accountId='10x13493';

//fill in the details of the accounts.userId is obtained from loginResult.
$accountData['firstname'] = 'Vijay';
$accountData['lastname'] = 'Chikane';
$accountData['assigned_user_id'] = $userId;
$accountData['id'] = $accountId;

//encode the object in JSON format to communicate with the server.
$objectJson = json_encode($accountData);

//name of the module for which the entry has to be updated.
$moduleName = 'Leads';

//sessionId is obtained from loginResult.
$params = array("sessionName"=>$sessionID, 
		"operation"=>'update', 
		"element"=>$objectJson, 
		"elementType"=>$moduleName
		);

//Create must be POST Request.
$curl = curl_init($URL);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
$response = json_decode(curl_exec($curl));
	if(!$response->success){
		echo "[ERROR CODE] " . $response->error->code . "<br>\n";
		echo "[ERROR MESSAGE] " . $response->error->message . "<br>\n";die;
	}elseif( $response->success == 1 ){
		echo $moduleName." Updated. <br>\n";
	}
//echo "<pre>";print_r($response);



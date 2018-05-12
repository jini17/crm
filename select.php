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
$res= curl_exec($curl);
$response = json_decode($res);

	if(!$response->success){
		echo "ERROR " . $response->error->message . "<br>\n";die;
	}

 $sessionID = $response->result->sessionName;
 $userId=$response->result->userId;


//query to select data from the server.
$query = "select * from Accounts;";
//urlencode to as its sent over http.
$queryParam = urlencode($query);
//sessionId is obtained from login result.
$params = "sessionName=$sessionID&operation=query&query=$queryParam";
//query must be GET Request.
$url = "$URL?$params";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl);
$response = json_decode($result, true);

	if (count($response['result'])>0) {
		echo "<table border='1' style='width:100%'><tr>";
		foreach ($response['result'][0] as $key=>$value) {
			echo "<th>$key</th>";
		}
		echo "</tr>";
		foreach ($response['result'] as $record) {
			echo "<tr>";
			foreach ($record as $value) {
				echo "<td>$value</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	} else {
		echo "No records found!";
	}


?>
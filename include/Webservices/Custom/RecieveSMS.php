<?php

	function vtws_incoming_sms($element){

		$clickatelUrl = "https://platform.clickatell.com/messages/http/send?apiKey=".$key."&to=60142955049&content=Loveyou";	
		$curl = curl_init($clickatelUrl);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		$reponse = json_decode($result);
		print_r($reponse);die;

		$smsObj = new SMSNotifier();


		$smsObj->column_fields['message'] = $element['message'];
		$smsObj->column_fields['status'] = $element['status'];
		
		try {
		    $response = $smsObj->save('SMSNotifier');	
		    return array("SMS recieved & create record with ID ".$response->id);
		} catch (Exception $e) {
			return array($e->getMessage());
		}
	}

?>
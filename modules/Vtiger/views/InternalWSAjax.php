<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_InternalWSAjax_View extends Vtiger_Index_View {

	function checkPermission(Vtiger_Request $request) {
		return true;
	}
	
	function __construct() {

		global $ssgurl, $ssguser, $ssgaccesskey;
		
		$ssgurl .='/webservice.php'; 
		$this->sessionid = '';
		$this->userid = '';
		$this->ssgurl = $ssgurl;
		$this->ssguser = $ssguser;
		$this->ssgaccesskey = $ssgaccesskey;
		$this->exposeMethod('getUserManualData');		
	}
	
	public  function process(Vtiger_Request $request) {
				
		$CHALLENGEURL = $this->ssgurl ."?operation=getchallenge&username=".$this->ssguser;
		$curl = curl_init($CHALLENGEURL);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		$TOKENDATA = json_decode($result);
	 	$CRM_TOKEN = $TOKENDATA->result->token;
	
		$curl = curl_init($this->ssgurl);
		$curl_post_data = array(
			'operation' => 'login',
			'username' => $this->ssguser,
			'accessKey' => md5($CRM_TOKEN.$this->ssgaccesskey ),
			);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		$res= curl_exec($curl);
		$response = json_decode($res);

		if(!$response->success){
			echo "ERROR " . $response->error->message . "<br>\n";die;
		}

		$this->sessionid 	= $response->result->sessionName;
	 	$this->userid	= $response->result->userId;

		$func	= $request->get('func');

		if(!empty($func)) {
			$this->invokeExposedMethod($func, $request);
			return;
		}	
	}
	
	public function getUserManualData($request) {
	
	 	 $moduleName = $request->getModule();	
		
		 $mode	= $request->get('mode');
		
		 $relatedmodule = $request->get('relatedModule');	
		$view	= $request->get('type');
		
		$ctype	= 'U';
		$lang	= 'English Us';
		$showtype = $view;
		if($view == 'Import' || $view =='Export' || $view == 'Filter' || $view =='List') {
			$moduleName = 'Common';
			$mode = 'Null';	
		} else {
			if($mode=='' ||  $mode=='showDetailViewByMode') {
				$mode = 'Base';
			} else {
				$mode = 'Related 1';
			}
			
			if($moduleName=='Survey') {
				if($relatedmodule=='Question') {
					$view = 'Survey Detail';
					$mode = 'Related 1';
				} else if($relatedmodule=='SurveyResponse') {
					$view = 'Survey Detail';
					$mode = 'Related 3';
				} else {
					$view = 'Detail';
					$mode = 'Base';
				}
			} 
			if($moduleName=='Question') {
				$moduleName = 'Survey';
				if($relatedmodule=='QuestionResponse') {
					$view = 'Survey Detail';
					$mode = 'Related 2';
				} else if($relatedmodule=='SurveyResponse') {
					$view = 'Survey Detail';
					$mode = 'Related 3';
				}
				else {
					$view = 'Survey Detail';
					$mode = 'Related 1';
				}
			}
			if($moduleName=='SurveyResponse') {
				$moduleName = 'Survey';
				$view = 'Survey Detail';
				$mode = 'Related 3';

			}

			if($moduleName=='QuestionResponse') { 
				$moduleName = 'Survey';
				$view = 'Survey Detail';
				$mode = 'Related 2';

			}
		}
		if($moduleName=='Documents') {
			$modulewhere = " cf_1332='Content Library'";	
		} else {
			$modulewhere = " cf_1332='$moduleName'";
		}
	
		//query to select data from the server.
		$query = "select * from Faq WHERE $modulewhere AND  cf_1326 LIKE '%$view%' AND cf_1328='$mode' AND cf_1268='$lang'
			 AND cf_1270 LIKE '$ctype%';";

		//urlencode to as its sent over http.
		$queryParam = urlencode($query);
		//sessionId is obtained from login result.
		$params = "sessionName=$this->sessionid&operation=query&query=$queryParam";
		//query must be GET Request.
		$url = "$this->ssgurl?$params";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($curl);
		$returndata = json_decode($result, true);
		//echo "<pre>";print_r($returndata);die;
		$returndata['result'][0]['module'] = $request->getModule();
		$viewer = $this->getViewer($request);
		
		if($returndata['success']==1) {
			$viewer->assign('DATA', $returndata['result'][0]);
		}	
			global $mtf_url;	//added by jitu@salespeer
			 $viewer->assign('REF_URL', $mtf_url);	//added by jitu@salespeer
			 $viewer->assign('VIEW', $view);	//added by jitu@salespeer
		echo $viewer->view('ContextHelp.tpl',$moduleName, true);
		
	}	
	

}

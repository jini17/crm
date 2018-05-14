<?php
/**
 * Created by PhpStorm.
 * User: Nirbhay Shah and Mabruk Shah
 * Date: 4/20/18
 * Time: 6:21 PM
 */

class Settings_Vtiger_AddOutGoingServer_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('LoadRules');
        $this->exposeMethod('AddServer');
        $this->exposeMethod('LoadFromAddress');
    }

    public function process(Vtiger_Request $request) {
        // echo "<pre>"; print_r("hERE"); die;
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    /**
     * Function to Load Add Outgoing Server Form
     */

    public function LoadRules($request){
        $qualifiedModuleName = $request->getModule(false);

        $viewer = $this->getViewer($request);
        $viewer->view('AddOutgoingServer.tpl', $qualifiedModuleName);
    }

    /**
     * Function to Load From Email Address List
     */

    public function LoadFromAddress($request){
        global $adb;
        // $adb->setDebug(true);
        $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(false);

        $result = $adb->pquery("SELECT * FROM vtiger_multiplefromaddress WHERE serverid = ?",array($request->get('serverid')));

        $count = $adb->num_rows($result);
        $data = array();
        for($i=0;$i<$count;$i++){

            $data[$i]['id'] = $adb->query_result($result,$i,'id');
            $data[$i]['name'] = $adb->query_result($result,$i,'name');
            $data[$i]['email'] = $adb->query_result($result,$i,'email');

        }


        $viewer->assign('DATA',$data);

        $viewer->view('FromAddressList.tpl',$qualifiedName);
    }

    /**
     * @param $request
     */
    public function AddServer($request){
        global $adb;
        //$adb->setDebug(true);
        //echo "<pre>"; print_r($request); die;
        $insertArray = $request->get('form');

        if($insertArray[5]['value'] == 'on'){
            $requireAuthentication = true;
        }
        else{
            $requireAuthentication = false;
        }

        if($insertArray[6]['value'] == 'on'){
            $isdefault = true;
        }
        else{
            $isdefault = false;
        }

        if($isdefault){
            $result3 = $adb->pquery("UPDATE vtiger_systems SET isdefault = 0 WHERE isdefault = 1",array());
        }

        $query = "INSERT INTO `vtiger_systems` (`server`,`server_username`, `server_password`, `smtp_auth`, `isdefault`) VALUES (?, ?, ?, ?, ?)";
        $result = $adb->pquery($query,array($insertArray[2]['value'],$insertArray[3]['value'],$insertArray[4]['value'], $requireAuthentication, $isdefault));



        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
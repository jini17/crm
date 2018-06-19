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
        $this->exposeMethod('FromAddressFunction');
        $this->exposeMethod('editForm');
    }

    public function process(Vtiger_Request $request) {
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
     * Function to Load Edit Outgoing Server Form
     */

    public function editForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);
        $id = $request->get('id');
        $data = array();

        $result = $adb->pquery("SELECT * FROM vtiger_systems WHERE id = ?",array($id));
        $data['server'] = $adb->query_result($result,0,"server");
        $data['server_username'] = $adb->query_result($result,0,"server_username");
        $data['server_password'] = $adb->query_result($result,0,"server_password");    
        $data['smtp_auth'] = $adb->query_result($result,0,"smtp_auth");
        $data['isdefault'] = $adb->query_result($result,0,"isdefault");

        $viewer = $this->getViewer($request);
        $viewer->assign('DATA',$data); 
        $viewer->view('EditOutgoingServer.tpl', $qualifiedModuleName);
    }

    /**
     * Function Responsible for FromAddress Functions
     */

    public function FromAddressFunction($request){
        global $adb;
        // $adb->setDebug(true);
        $viewer = $this->getViewer($request);
        $qualifiedName = $request->getModule(false);        

        if ($request->get('task') == 'add'){
            $insertArray = $request->get('form');
            $data = array();

            foreach ($insertArray as $key => $value) {
                $data[$value['name']] = $value['value'];
            }

            $result = $adb->pquery("INSERT INTO vtiger_multiplefromaddress (name, email, serverid) VALUES (?,?,?)",array($data['name'], $data['email'],$request->get('serverid')));
        }

        else if ($request->get('task') == 'delete'){
            $seperatedValues = explode(',', $request->get('checkedData'));
            $checkedData ='';
            for ($i = 0; $i < count($seperatedValues); $i++) {
                if( $i != (count($seperatedValues) - 1))
                    $checkedData .= "'" . $seperatedValues[$i] . "',";
                else
                    $checkedData .= "'" . $seperatedValues[$i] . "'";
            }
            $result = $adb->pquery("DELETE FROM vtiger_multiplefromaddress WHERE id IN ($checkedData)",array());
        }
        
        $result = $adb->pquery("SELECT * FROM vtiger_multiplefromaddress WHERE serverid = ?",array($request->get('serverid')));
        $count = $adb->num_rows($result);
        $data = array();
        for ($i = 0; $i < $count; $i++){

            $data[$i]['id'] = $adb->query_result($result,$i,'id');
            $data[$i]['name'] = $adb->query_result($result,$i,'name');
            $data[$i]['email'] = $adb->query_result($result,$i,'email');

        }

        $viewer->assign('DATA',$data);

        if ($request->get('task') == 'add' || $request->get('task') == 'delete')
            $viewer->view('fromEmailAddressList.tpl',$qualifiedName);
        else
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

        $data = array();

        foreach ($insertArray as $key => $value) {
            $data[$value['name']] = $value['value'];
        }

        if($data['requireAuthentication'] == 'on'){
            $requireAuthentication = true;
        }
        else{
            $requireAuthentication = false;
        }

        if($data['isDefault'] == 'on'){
            $isdefault = true;
        }
        else{
            $isdefault = false;
        }

        if($isdefault){
            $result3 = $adb->pquery("UPDATE vtiger_systems SET isdefault = 0 WHERE isdefault = 1",array());
        }

        if ($request->get('type') == 'edit') {
            $query = "UPDATE vtiger_systems SET server = ?, server_username = ?, server_password = ?, smtp_auth = ?, isdefault = ? WHERE id = ?";
            $result = $adb->pquery($query,array($data['Host'], $data['Username'], $data['Password'], $requireAuthentication, $isdefault,$request->get('id')));
        }
        else {
            $query = "INSERT INTO vtiger_systems (server,server_username, server_password, smtp_auth, isdefault) VALUES (?, ?, ?, ?, ?)";
            $result = $adb->pquery($query,array($data['Host'], $data['Username'], $data['Password'], $requireAuthentication, $isdefault));
        }

        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;
    }

}
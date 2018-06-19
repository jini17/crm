<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */



class Settings_Vtiger_AllowedIPTools_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('EditAllowedIPForm');
        $this->exposeMethod('DefaultToggle');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function EditAllowedIPForm($request){
        global $adb;
        // $adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `allowed_ip` WHERE ip_id = ?";
        $result = $adb->pquery($query,array($values[0]));
        $count = $adb->num_rows($result);
        $edit_allocation = array();

        if($count>0){
            $edit_allocation['ip_id'] = $adb->query_result($result, 0,'ip_id');
            $edit_allocation['ip'] = $adb->query_result($result, 0,'ip');
            $edit_allocation['type'] = $adb->query_result($result, 0,'type');
            $edit_allocation['user_name'] = $adb->query_result($result, 0,'user_name');
            $edit_allocation['iprestriction_type'] = $adb->query_result($result, 0,'iprestriction_type');


        }

        $qualifiedModuleName = $request->getModule(false);



        $viewer = $this->getViewer($request);
        $viewer->assign("VALUES",$edit_allocation);
        $viewer->view('EditAllowedIP.tpl', $qualifiedModuleName);
    }

    /**
     * @param $request
     * VALUE =0 MEANS NOT ALLOOWED
     * value=1 means allowed
     */

    public function DefaultToggle($request){
        global $adb;

        $defaultvalue = $request->get('values');

        if($defaultvalue == 0){
            $result = $adb->pquery("UPDATE allowed_ip_default SET defaultvalue = 'notallowed'",array());
            $response = "success";
        }else if($defaultvalue == 1){
            $result = $adb->pquery("UPDATE allowed_ip_default SET defaultvalue = 'allowed'",array());
            $response = "success";
        }else{
            $response = 'failed';
        }

        echo $response;

    }

}
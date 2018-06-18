<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */

class Settings_Vtiger_AddRule_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('LoadRules');
        $this->exposeMethod('AddRule');
        $this->exposeMethod('UpdateRule');
    }

    public function process(Vtiger_Request $request) {
       // echo "<pre>"; print_r("hERE"); die;
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function LoadRules($request){
        global $adb;
        $query = "SELECT * FROM `vtiger_users` WHERE status = 'Active' and deleted=0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);
        $users = array();

        if($count>0){
            for($i=0;$i<$count;$i++){
                $users[] = $adb->query_result($result, $i,'user_name');
            }
        }

        $qualifiedModuleName = $request->getModule(false);

        $viewer = $this->getViewer($request);
        $viewer->assign('USERS', $users);
        $viewer->view('AddRule.tpl', $qualifiedModuleName);
    }

    /**
     * @param $request
     */
    public function AddRule($request){
        global $adb;
        $insertArray = $request->get('form');
        $selectedusers = '';
        for($i=0;$i<count($insertArray);$i++){
            if($insertArray[$i]['name']=='selectUser[]') {
                $selectedusers .= $insertArray[$i]['value'].',';
            }else{
                $values[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        $selectedusers = substr($selectedusers, 0, -1);;


        if(!isset($values['isactive'])){
            $values['isactive']= 0;
        }else{
            $values['isactive']= 1;
        }

        $query = "INSERT INTO `allowed_ip` (`ip`, `type`, `user_name`,`iprestriction_type`,`isactive`) VALUES (?, ?, ?, ?, ?)";
        $result = $adb->pquery($query,array($values['ipval'],$values['TypeOfRule'],$selectedusers,$values['iprestriction_type'], $values['isactive']));

        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    /**
     * @param $request
     */
    public function UpdateRule($request){
        global $adb;
        $insertArray = $request->get('form');
        $selectedusers = '';
        for($i=0;$i<count($insertArray);$i++){
            if($insertArray[$i]['name']=='selectUser[]') {
                $selectedusers .= $insertArray[$i]['value'].',';
            }else{
                $values[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        $selectedusers = substr($selectedusers, 0, -1);;


        if(!isset($values['isactive'])){
            $values['isactive']= 0;
        }else{
            $values['isactive']= 1;
        }

        $query = "UPDATE `allowed_ip` SET `ip`=?, `type`=?, `user_name`=?,`iprestriction_type`=?,`isactive`=? WHERE ip_id = ?";
        $result = $adb->pquery($query,array($values['ipval'],$values['TypeOfRule'],$selectedusers,$values['iprestriction_type'], $values['isactive'],$values['ip_id']));

        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
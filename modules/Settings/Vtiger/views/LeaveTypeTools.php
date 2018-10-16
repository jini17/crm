<?php
/**
 * Created by NirBhay RaJu ShAh PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */

class Settings_Vtiger_LeaveTypeTools_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('AddLeaveTypeForm');
        $this->exposeMethod('AddLeaveType');
        $this->exposeMethod('DeleteLeaveType');
        $this->exposeMethod('EditLeaveTypeForm');
        $this->exposeMethod('UpdateLeaveType');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function AddLeaveTypeForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);

        $viewer = $this->getViewer($request);
        $viewer->view('AddLeaveType.tpl', $qualifiedModuleName);
    }


    public function EditLeaveTypeForm($request){
        //echo "<pre>"; print_r($request); die;
        global $adb;
        //$adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `vtiger_leavetype` WHERE leavetypeid = ?";
        $result = $adb->pquery($query,array($values[0]));
        $count = $adb->num_rows($result);
        //echo "Nirbhay".$count;die;
        $leave_type = array();

        if($count>0){

            $leave_type['leave_type_title'] = $adb->query_result($result, 0,'title');
            $leave_type['leave_type_leavecode'] = $adb->query_result($result, 0,'leavecode');
            $leave_type['leave_type_description'] = $adb->query_result($result, 0,'description');
            $leave_type['leave_type_midyearallocation'] = $adb->query_result($result, 0,'midyearallocation');
            $leave_type['leave_type_leavefrequency'] = $adb->query_result($result, 0,'leavefrequency');
            $leave_type['leave_type_status'] = $adb->query_result($result, 0,'leavetype_status');
            $leave_type['leave_type_carryforward'] = $adb->query_result($result, 0,'carryforward');
            $leave_type['leave_type_halfdayallowed'] = $adb->query_result($result, 0,'halfdayallowed');
            $leave_type['leave_type_id'] = $adb->query_result($result, 0,'leavetypeid');


        }

        $qualifiedModuleName = $request->getModule(false);



        $viewer = $this->getViewer($request);
        $viewer->assign("VALUES",$leave_type);
        $viewer->view('EditLeaveType.tpl', $qualifiedModuleName);
    }

    public function DeleteLeaveType($request){
        global $adb;
        $adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $stringVal ='';
        $query = "UPDATE vtiger_crmentity SET deleted = 1 WHERE crmid IN ( ";

        for($i=0;$i<count($SeperatedValues);$i++){
            if($i!=(count($SeperatedValues)-1))
                $query .= $SeperatedValues[$i].",";
            else
                $query .= $SeperatedValues[$i];
        }

        $query.= ")";
        $result = $adb->pquery($query,array());

        $responses = [true];

        $responses->emit;
    }

    public function AddLeaveType($request){
        global $adb;
        $insertArray = $request->get('form');
        $leavetype = array();


        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $leavetype[$name] = $insertArray[$i]['value'];

        }

        if(!isset($leavetype['status'])){
            $leavetype['status']= 'off';
        }

        if(!isset($leavetype['LeaveType_HalfdayAllowed'])){
            $leavetype['LeaveType_HalfdayAllowed']= 'off';
        }

        if(!isset($leavetype['LeaveType_CarryForward'])){
            $leavetype['LeaveType_CarryForward']= 'off';
        }



        $leavetypeid = $adb->getUniqueID('vtiger_crmentity');

        $crmentityinsertquery = "INSERT INTO vtiger_crmentity (crmid, smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime, viewedtime, status, version, presence, deleted, smgroupid, source, label) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,?,?,?,?,?,?,?)";

        $params = array($leavetypeid,1,1,1,"Leave Type",'','',1,1,0,'','','');

        $crmentityinsertresult = $adb->pquery($crmentityinsertquery,array($params));

        if($crmentityinsertresult){
            $query = "INSERT INTO `vtiger_leavetype` (`leavetypeid`, `title`, `leavecode`,`leaveType_status`,`description`,`midyearallocation`,`halfdayallowed`,`carryforward`,`leavefrequency`) VALUES (?,?,?,?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($leavetypeid,$leavetype['LeaveTypeTitle'],$leavetype['LeaveTypeCode'],$leavetype['status'],$leavetype['LeaveType_Desc
'],$leavetype['LeaveType_MidYearAllcoation'],$leavetype['LeaveType_HalfdayAllowed'],$leavetype['LeaveType_CarryForward'],$leavetype['LeaveType_LeaveFrequency']));

        }
        if($result){
            $query = "INSERT INTO vtiger_leavetypecf (leavetypeid) VALUES (?)";
            $claimtypetables_result = $adb->pquery($query,array($leavetypeid));
        }


        if($claimtypetables_result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateLeaveType($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        //echo "<pre>"; print_r($insertArray); die;
        $leavetype = array();



        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $leavetype[$name] = $insertArray[$i]['value'];

        }

        if(!isset($leavetype['status'])){
            $leavetype['status']= 'off';
        }

        if(!isset($leavetype['LeaveType_HalfdayAllowed'])){
            $leavetype['LeaveType_HalfdayAllowed']= 'off';
        }

        if(!isset($leavetype['LeaveType_CarryForward'])){
            $leavetype['LeaveType_CarryForward']= 'off';
        }

        $query = "UPDATE `vtiger_leavetype` SET `title`=?, `leavecode`=?, `leaveType_status`=?, `description`=?, `midyearallocation`=?, halfdayallowed=?,`carryforward`=?, `leavefrequency`=? WHERE leavetypeid=?";
        $result = $adb->pquery($query,array($leavetype['LeaveTypeTitle'],$leavetype['LeaveTypeCode'],$leavetype['status'],$leavetype['LeaveType_Desc
'],$leavetype['LeaveType_MidYearAllcoation'],$leavetype['LeaveType_HalfdayAllowed'],$leavetype['LeaveType_CarryForward'],$leavetype['LeaveType_LeaveFrequency'],$leavetype['LeaveTypeId']));





        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}

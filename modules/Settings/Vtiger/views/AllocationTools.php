<?php
/**
 * Created by NirBhay RaJu ShAh PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */

class Settings_Vtiger_AllocationTools_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('AddAllocationForm');
        $this->exposeMethod('AddAllocation');
        $this->exposeMethod('DeleteAllocation');
        $this->exposeMethod('EditAllocationForm');
        $this->exposeMethod('UpdateAllocation');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function AddAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);


        $query = "SELECT * FROM vtiger_grade INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_grade.gradeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $grade[$i]['id'] = $adb->query_result($result,$i, 'gradeid');
            $grade[$i]['grade'] = $adb->query_result($result,$i, 'grade');
        }



        $query = "SELECT * FROM vtiger_leavetype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leavetype.leavetypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $leavetype[$i]['id'] = $adb->query_result($result,$i, 'leavetypeid');
            $leavetype[$i]['title'] = $adb->query_result($result,$i, 'title');
        }



        $query = "SELECT * FROM vtiger_claimtype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_claimtype.claimtypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $claimtype[$i]['id'] = $adb->query_result($result,$i, 'claimtypeid');
            $claimtype[$i]['claimtype'] = $adb->query_result($result,$i, 'claim_type');
        }


        /* Add Benefit using this template
        $query = "SELECT * FROM vtiger_grade INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_grade.gradeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $leavetype[$i]['id'] = $adb->query_result($result,$i, 'leavetypeid');
            $leavetype[$i]['title'] = $adb->query_result($result,$i, 'title');
        }*/

        //echo "<pre>"; print_r($leavetype); die;

        $viewer = $this->getViewer($request);
        $viewer->assign("LEAVETYPE",$leavetype);
        $viewer->assign("CLAIMTYPE",$claimtype);
        $viewer->assign("GRADE",$grade);
        $viewer->view('AddAllocation.tpl', $qualifiedModuleName);
    }


    public function EditAllocationForm($request){
        //echo "<pre>"; print_r($request); die;
        global $adb;
        $adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `vtiger_Allocation` WHERE Allocationid = ?";
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
            $leave_type['leave_type_status'] = $adb->query_result($result, 0,'Allocation_status');
            $leave_type['leave_type_carryforward'] = $adb->query_result($result, 0,'carryforward');
            $leave_type['leave_type_halfdayallowed'] = $adb->query_result($result, 0,'halfdayallowed');
            $leave_type['leave_type_id'] = $adb->query_result($result, 0,'Allocationid');


        }

        $qualifiedModuleName = $request->getModule(false);



        $viewer = $this->getViewer($request);
        $viewer->assign("VALUES",$leave_type);
        $viewer->view('EditAllocation.tpl', $qualifiedModuleName);
    }

    public function DeleteAllocation($request){
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

    public function AddAllocation($request){
        global $adb;
        $insertArray = $request->get('form');
        $Allocation = array();


        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $Allocation[$name] = $insertArray[$i]['value'];

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }





        $Allocationid = $adb->getUniqueID('Allocation_list');


        $crmentityinsertquery = "INSERT INTO vtiger_crmentity (crmid, smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime, viewedtime, status, version, presence, deleted, smgroupid, source, label) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,?,?,?,?,?,?,?)";

        $params = array($Allocationid,1,1,1,"Leave Type",'','',1,1,0,'','','');

        $crmentityinsertresult = $adb->pquery($crmentityinsertquery,array($params));

        if($crmentityinsertresult){
            $query = "INSERT INTO `vtiger_Allocation` (`Allocationid`, `title`, `leavecode`,`Allocation_status`,`description`,`midyearallocation`,`halfdayallowed`,`carryforward`,`leavefrequency`) VALUES (?,?,?,?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
'],$Allocation['Allocation_MidYearAllcoation'],$Allocation['Allocation_HalfdayAllowed'],$Allocation['Allocation_CarryForward'],$Allocation['Allocation_LeaveFrequency']));

        }
        if($result){
            $query = "INSERT INTO vtiger_Allocationcf (Allocationid) VALUES (?)";
            $claimtypetables_result = $adb->pquery($query,array($Allocationid));
        }


        if($claimtypetables_result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateAllocation($request){
        global $adb;

        $insertArray = $request->get('form');
        // echo "<pre>"; print_r($insertArray); die;
        $Allocation = array();



        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $Allocation[$name] = $insertArray[$i]['value'];

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }

        if(!isset($Allocation['Allocation_HalfdayAllowed'])){
            $Allocation['Allocation_HalfdayAllowed']= 'off';
        }

        if(!isset($Allocation['Allocation_CarryForward'])){
            $Allocation['Allocation_CarryForward']= 'off';
        }

        $query = "UPDATE `vtiger_Allocation` SET `title`=?, `leavecode`=?, `Allocation_status`=?, `description`=?, `midyearallocation`=?, halfdayallowed=?,`carryforward`=?, `leavefrequency`=? WHERE Allocationid=?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
'],$Allocation['Allocation_MidYearAllcoation'],$Allocation['Allocation_HalfdayAllowed'],$Allocation['Allocation_CarryForward'],$Allocation['Allocation_LeaveFrequency'],$Allocation['leave_type_id']));





        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
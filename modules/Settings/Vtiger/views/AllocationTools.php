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
        global $adb;
      //  $adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `Allocation_list` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($values[0]));
        $count = $adb->num_rows($result);
        //echo "Nirbhay".$count;die;
        $allocation = array();

        if($count>0){

            $allocation['allocation_id'] = $adb->query_result($result, 0,'allocation_id');
            $allocation['leavetype_id'] = $adb->query_result($result, 0,'leavetype_id');
            $allocation['grade_id'] = $adb->query_result($result, 0,'grade_id');
            $allocation['benifittype_id'] = $adb->query_result($result, 0,'benifittype_id');
            $allocation['claimtype_id'] = $adb->query_result($result, 0,'claimtype_id');
            $allocation['status'] = $adb->query_result($result, 0,'status');
            $allocation['allocation_code'] = $adb->query_result($result, 0,'allocation_code');
            $allocation['allocation_desc'] = $adb->query_result($result, 0,'allocation_desc');
            $allocation['age_leave'] = $adb->query_result($result, 0,'age_leave');
            $allocation['age_claim'] = $adb->query_result($result, 0,'age_claim');
            $allocation['numberofleavesless'] = $adb->query_result($result, 0,'numberofleavesless');
            $allocation['numberofleavesmore'] = $adb->query_result($result, 0,'numberofleavesmore');
            $allocation['claimamountless'] = $adb->query_result($result, 0,'claimamountless');
            $allocation['claimamountmore'] = $adb->query_result($result, 0,'claimamountmore');
            $allocation['allocationtitle'] = $adb->query_result($result, 0,'allocation_title');


        }


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




        $qualifiedModuleName = $request->getModule(false);

      //  echo "<pre>"; print_r($allocation); die;

        $viewer = $this->getViewer($request);
        $viewer->assign("LEAVETYPE",$leavetype);
        $viewer->assign("CLAIMTYPE",$claimtype);
        $viewer->assign("GRADE",$grade);
        $viewer->assign("VALUES",$allocation);
        $viewer->view('AllocationEditView.tpl', $qualifiedModuleName);
    }

    public function DeleteAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $stringVal ='';
        $query = "DELETE FROM Allocation_list WHERE Allocation_list.allocation_id IN ( ";

        for($i=0;$i<count($SeperatedValues);$i++){
            if($i!=(count($SeperatedValues)-1))
                $query .= $SeperatedValues[$i].",";
            else
                $query .= $SeperatedValues[$i];
        }

        $query.= ")";
        $result = $adb->pquery($query,array());

        $responses = [true];
        //die;
        $responses->emit;
    }

    public function AddAllocation($request){
        //echo "Here";die;
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        $Allocation = array();
       // echo "<pre>"; print_r($insertArray); die;
        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $Allocation[$name] = $insertArray[$i]['value'];

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }





        $Allocationid = $adb->getUniqueID('Allocation_list');




            $query = "INSERT INTO `Allocation_list` (`allocation_id`,`allocation_title`,`allocation_code`, `status`,`allocation_desc`, `grade_id`,`leavetype_id`,`age_leave`,`numberofleavesless`,`numberofleavesmore`,`claimtype_id`,`age_claim`,`claimamountless`,`claimamountmore`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
'],$Allocation['Allocation_grade'],$Allocation['Allocation_leavetype'],$Allocation['ageleave'],$Allocation['numberofleavesless'],$Allocation['numberofleavesmore'],$Allocation['Allocation_claimtype'],$Allocation['ageclaim'],$Allocation['amountclaimless'],$Allocation['amountclaimmore']));



       // die;

        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateAllocation($request){
        global $adb;
        $adb->setDebug(true);
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


        $query = "UPDATE `Allocation_list` SET `allocation_title`=? ,`allocation_code`=? , `status`=? ,`allocation_desc`=? , `grade_id`=? ,`leavetype_id`=? ,`age_leave`=? ,`numberofleavesless`=? ,`numberofleavesmore`=? ,`claimtype_id`=? ,`age_claim`=? ,`claimamountless` =? ,`claimamountmore`=? WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
'],$Allocation['Allocation_grade'],$Allocation['Allocation_leavetype'],$Allocation['ageleave'],$Allocation['numberofleavesless'],$Allocation['numberofleavesmore'],$Allocation['Allocation_claimtype'],$Allocation['ageclaim'],$Allocation['amountclaimless'],$Allocation['amountclaimmore'],$Allocation['allocation_id']));





        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
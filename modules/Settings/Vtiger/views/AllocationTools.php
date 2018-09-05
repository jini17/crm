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
        $viewer->assign("LEAVETYPE",json_encode($leavetype));
        $viewer->assign("CLAIMTYPE",$claimtype);
        $viewer->assign("GRADE",$grade);
        $viewer->view('AddAllocation.tpl', $qualifiedModuleName);
    }


    public function EditAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `allocation_list` WHERE allocation_id = ?";

        $resultallocation = $adb->pquery($query,array($values[0]));

        $queryleavetypes = "SELECT * FROM `allocation_list_details` WHERE allocation_id=?";
        $resultleavetypes = $adb->pquery($queryleavetypes,array($values[0]));

        $count = $adb->num_rows($resultallocation);
        $allocation = array();

        if($count>0){

            $allocation['allocation_id'] = $adb->query_result($resultallocation, 0,'allocation_id');
            $allocation['grade_id'] = $adb->query_result($resultallocation, 0,'grade_id');
            $allocation['benifittype_id'] = $adb->query_result($resultallocation, 0,'benifittype_id');
            $allocation['claimtype_id'] = $adb->query_result($resultallocation, 0,'claimtype_id');
            $allocation['status'] = $adb->query_result($resultallocation, 0,'status');
            $allocation['allocation_code'] = $adb->query_result($resultallocation, 0,'allocation_code');
            $allocation['allocation_desc'] = $adb->query_result($resultallocation, 0,'allocation_desc');
            $allocation['allocationtitle'] = $adb->query_result($resultallocation, 0,'allocation_title');

            for($i=0;$i<$adb->num_rows($resultleavetypes);$i++){
                $allocation['leavedetails'][$i]['leavetype_id'] = $adb->query_result($resultleavetypes, $i,'leavetype_id');
                $allocation['leavedetails'][$i]['ageleave'] = $adb->query_result($resultleavetypes, $i,'ageleave');
                $allocation['leavedetails'][$i]['numberofleavesmore'] = $adb->query_result($resultleavetypes, $i,'numberofleavesmore');
                $allocation['leavedetails'][$i]['numberofleavesless'] = $adb->query_result($resultleavetypes, $i,'numberofleavesless');

            }


        }

        
        
        //die;
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
        $viewer->assign("LEAVETYPE",json_encode($leavetype));
        $viewer->assign("CLAIMTYPE",$claimtype);
        $viewer->assign("GRADE",$grade);
        $viewer->assign("VALUES",$allocation);
        $viewer->assign("LEAVETYPEVALUES",json_encode($allocation['leavedetails']));
        $viewer->view('AllocationEditView.tpl', $qualifiedModuleName);
    }

    public function DeleteAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $qstnmark ='';
        /*$query = "DELETE allocation_list, allocation_list_details FROM allocation_list INNER JOIN allocation_list_details ON allocation_list.allocation_id = allocation_list_details.allocation_id WHERE allocation_list.allocation_id IN ( ";*/
        

        for ($i = 0; $i < count($SeperatedValues); $i++) {

            $adb->pquery("DELETE FROM allocation_list WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_list_details WHERE allocation_id = ?",array($SeperatedValues[$i]));

        }    

        /*for($i=0;$i<count($SeperatedValues);$i++){
            if($i!=(count($SeperatedValues)-1))
                $query .= $SeperatedValues[$i].",";
            else
                $query .= $SeperatedValues[$i];
        }

        $query.= ")";
        $result = $adb->pquery($query,array());*/

        $responses = [true];
       
        $responses->emit;
    }

    public function AddAllocation($request){
        //echo "Here";die;
        global $adb;
      // $adb->setDebug(true);
        $insertArray = $request->get('form');
        $Allocation = array();
        $leavetype= array();
        $selectedgrades = '';
        //echo "<pre>"; print_r($insertArray); die;
        $leavetypecounter = -1;
        for($i=0;$i<count($insertArray);$i++) {

            if($insertArray[$i]['name']=='selectUser[]') {
                $selectedgrades .= $insertArray[$i]['value'].',';
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_leavetype')>-1){
                $leavetypecounter++;
                $leavetype[$leavetypecounter]['Allocation_leavetype'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'ageleave')>-1){
                $leavetype[$leavetypecounter]['ageleave'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'numberofleavesless')>-1){
                $leavetype[$leavetypecounter]['numberofleavesless'] = $insertArray[$i]['value'];

            }
            else if(stripos($insertArray[$i]['name'],'numberofleavesmore')>-1){
                $leavetype[$leavetypecounter]['numberofleavesmore'] = $insertArray[$i]['value'];

            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }

       $Allocationid = $adb->getUniqueID('allocation_list');




            $query = "INSERT INTO `allocation_list` (`allocation_id`,`allocation_title`,`allocation_code`, `status`,`allocation_desc`, `grade_id`,`claimtype_id`) VALUES (?,?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
'],$selectedgrades,$Allocation['Allocation_claimtype']));

            for($i=0;$i<count($leavetype);$i++){
                $query = "INSERT INTO `allocation_list_details` (`allocation_id`,`leavetype_id`,`ageleave`,`numberofleavesmore`,`numberofleavesless`) VALUES(?,?,?,?,?)";
                $result = $adb->pquery($query,array($Allocationid,$leavetype[$i]['Allocation_leavetype'], $leavetype[$i]['ageleave'], $leavetype[$i]['numberofleavesmore'], $leavetype[$i]['numberofleavesless'] ));
            }


        //die;

        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        // echo "<pre>"; print_r($insertArray); die;
        $Allocation = array();
        $leavetype= array();
        $leavetypecounter = -1;

        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            if(stripos($insertArray[$i]['name'],'Allocation_leavetype')>-1){
                $leavetypecounter++;
                $leavetype[$leavetypecounter]['Allocation_leavetype'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'ageleave')>-1){
                $leavetype[$leavetypecounter]['ageleave'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'numberofleavesless')>-1){
                $leavetype[$leavetypecounter]['numberofleavesless'] = $insertArray[$i]['value'];

            }
            else if(stripos($insertArray[$i]['name'],'numberofleavesmore')>-1){
                $leavetype[$leavetypecounter]['numberofleavesmore'] = $insertArray[$i]['value'];

            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }


        $query = "UPDATE `allocation_list` SET `allocation_title`=? ,`allocation_code`=? , `status`=? ,`allocation_desc`=? , `grade_id`=? WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc
            '],$Allocation['Allocation_grade'],$Allocation['allocation_id']));

        $query = "DELETE FROM `allocation_list_details` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));


        for($i=0;$i<count($leavetype);$i++){

            $query = "INSERT INTO `allocation_list_details` (`allocation_id`,`leavetype_id`,`ageleave`,`numberofleavesmore`,`numberofleavesless`) VALUES(?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocation['allocation_id'], $leavetype[$i]['Allocation_leavetype'], $leavetype[$i]['ageleave'], $leavetype[$i]['numberofleavesmore'], $leavetype[$i]['numberofleavesless'] ));
        }


        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
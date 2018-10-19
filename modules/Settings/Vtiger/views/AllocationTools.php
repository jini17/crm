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
        $this->exposeMethod('AddClaimAllocationForm');
        $this->exposeMethod('AddBenefitAllocationForm');
        $this->exposeMethod('AddAllocation');
        $this->exposeMethod('AddClaimAllocation');
        $this->exposeMethod('AddBenefitAllocation');
        $this->exposeMethod('DeleteAllocation');
        $this->exposeMethod('DeleteClaimAllocation');
        $this->exposeMethod('DeleteBenefitAllocation');
        $this->exposeMethod('EditAllocationForm');
        $this->exposeMethod('EditClaimAllocationForm');
        $this->exposeMethod('EditBenefitAllocationForm');
        $this->exposeMethod('UpdateAllocation');
        $this->exposeMethod('UpdateClaimAllocation');
        $this->exposeMethod('UpdateBenefitAllocation');
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

    public function AddBenefitAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);


        $query = "SELECT * FROM vtiger_grade INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_grade.gradeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $grade[$i]['id'] = $adb->query_result($result,$i, 'gradeid');
            $grade[$i]['grade'] = $adb->query_result($result,$i, 'grade');
        }



        $query = "SELECT * FROM vtiger_benefittype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_benefittype.benefittypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $benefittype[$i]['id'] = $adb->query_result($result,$i, 'benefittypeid');
            $benefittype[$i]['benefittype'] = $adb->query_result($result,$i, 'benefit_type');
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
        $viewer->assign("BENEFITTYPE",json_encode($benefittype));
        $viewer->assign("GRADE",$grade);
        $viewer->view('AddBenefitAllocation.tpl', $qualifiedModuleName);
    }

    public function AddClaimAllocationForm($request){
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
        $viewer->assign("CLAIMTYPE",json_encode($claimtype));
        $viewer->assign("GRADE",$grade);
        $viewer->view('AddClaimAllocation.tpl', $qualifiedModuleName);
    }


    public function EditAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $alloctaionId = $values[0];

        $query = "SELECT * FROM `allocation_list` WHERE allocation_id = ?";

        $resultallocation = $adb->pquery($query,array($alloctaionId));

        $queryleavetypes = "SELECT * FROM `allocation_leaverel` WHERE allocation_id=?";
        $resultleavetypes = $adb->pquery($queryleavetypes,array($alloctaionId));

        $count = $adb->num_rows($resultallocation);
        $allocation = array();

        if($count>0){

            $allocation['allocation_id'] = $adb->query_result($resultallocation, 0,'allocation_id');            
            $allocation['benifittype_id'] = $adb->query_result($resultallocation, 0,'benifittype_id');            
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


        $query = "SELECT GROUP_CONCAT(gradeid) AS gradeid FROM vtiger_grade INNER JOIN allocation_graderel ON allocation_graderel.grade_id = vtiger_grade.gradeid WHERE allocation_graderel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $preValues['grade_id'] = $adb->query_result($result, 0, 'gradeid');

        $preValues['grade_id'] = explode(",",$preValues['grade_id']); 


        $query = "SELECT GROUP_CONCAT(claimtypeid) AS claimtypeid FROM vtiger_claimtype INNER JOIN allocation_claimrel ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid WHERE allocation_claimrel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $count = $adb->num_rows($result);
        $preValues['claim_id'] = $adb->query_result($result, 0, 'claimtypeid');

        $preValues['claim_id'] = explode(",",$preValues['claim_id']); 

        $qualifiedModuleName = $request->getModule(false);

      //  echo "<pre>"; print_r($allocation); die;

        $viewer = $this->getViewer($request);
        $viewer->assign("LEAVETYPE",json_encode($leavetype));
        $viewer->assign("CLAIMTYPE",$claimtype);
        $viewer->assign("GRADE",$grade);
        $viewer->assign("VALUES",$allocation);
        $viewer->assign("PREVALUES",$preValues);
        $viewer->assign("LEAVETYPEVALUES",json_encode($allocation['leavedetails']));
        $viewer->view('AllocationEditView.tpl', $qualifiedModuleName);
    }

    public function EditClaimAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $alloctaionId = $values[0];

        $query = "SELECT * FROM `allocation_list` WHERE allocation_id = ?";

        $resultallocation = $adb->pquery($query,array($alloctaionId));

        $queryclaimtypes = "SELECT * FROM `allocation_claimrel` WHERE allocation_id=?";
        $resultclaimtypes = $adb->pquery($queryclaimtypes,array($alloctaionId));

        $count = $adb->num_rows($resultallocation);
        $allocation = array();

        if($count>0){

            $allocation['allocation_id'] = $adb->query_result($resultallocation, 0,'allocation_id');            
            $allocation['benifittype_id'] = $adb->query_result($resultallocation, 0,'benifittype_id');            
            $allocation['status'] = $adb->query_result($resultallocation, 0,'status');
            $allocation['allocation_code'] = $adb->query_result($resultallocation, 0,'allocation_code');
            $allocation['allocation_desc'] = $adb->query_result($resultallocation, 0,'allocation_desc');
            $allocation['allocationtitle'] = $adb->query_result($resultallocation, 0,'allocation_title');

            for($i=0;$i<$adb->num_rows($resultclaimtypes);$i++){

                $allocation['claimdetails'][$i]['claim_id'] = $adb->query_result($resultclaimtypes, $i,'claim_id');
                $allocation['claimdetails'][$i]['monthly_limit'] = $adb->query_result($resultclaimtypes, $i,'monthly_limit');
                $allocation['claimdetails'][$i]['yearly_limit'] = $adb->query_result($resultclaimtypes, $i,'yearly_limit');
                $allocation['claimdetails'][$i]['transaction_limit'] = $adb->query_result($resultclaimtypes, $i,'transaction_limit');

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



        $query = "SELECT * FROM vtiger_claimtype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_claimtype.claimtypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $claimtype[$i]['id'] = $adb->query_result($result,$i, 'claimtypeid');
            $claimtype[$i]['claimtype'] = $adb->query_result($result,$i, 'claim_type');
        }


        $query = "SELECT GROUP_CONCAT(gradeid) AS gradeid FROM vtiger_grade INNER JOIN allocation_graderel ON allocation_graderel.grade_id = vtiger_grade.gradeid WHERE allocation_graderel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $preValues['grade_id'] = $adb->query_result($result, 0, 'gradeid');

        $preValues['grade_id'] = explode(",",$preValues['grade_id']); 


        $query = "SELECT GROUP_CONCAT(claimtypeid) AS claimtypeid FROM vtiger_claimtype INNER JOIN allocation_claimrel ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid WHERE allocation_claimrel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $count = $adb->num_rows($result);
        $preValues['claim_id'] = $adb->query_result($result, 0, 'claimtypeid');

        $preValues['claim_id'] = explode(",",$preValues['claim_id']); 

        $qualifiedModuleName = $request->getModule(false);

      //  echo "<pre>"; print_r($allocation); die;

        $viewer = $this->getViewer($request);
        $viewer->assign("LEAVETYPE",$leavetype);
        $viewer->assign("CLAIMTYPE",json_encode($claimtype));
        $viewer->assign("GRADE",$grade);
        $viewer->assign("VALUES",$allocation);
        $viewer->assign("PREVALUES",$preValues);
        $viewer->assign("CLAIMTYPEVALUES",json_encode($allocation['claimdetails']));
        $viewer->view('AllocationClaimEditView.tpl', $qualifiedModuleName);
    }

    public function EditBenefitAllocationForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $alloctaionId = $values[0];

        $query = "SELECT * FROM `allocation_list` WHERE allocation_id = ?";

        $resultallocation = $adb->pquery($query,array($alloctaionId));

        $querybenefittypes = "SELECT * FROM `allocation_benefitrel` WHERE allocation_id=?";
        $resultbenefittypes = $adb->pquery($querybenefittypes,array($alloctaionId));

        $count = $adb->num_rows($resultallocation);
        $allocation = array();

        if($count>0){

            $allocation['allocation_id'] = $adb->query_result($resultallocation, 0,'allocation_id');            
            $allocation['benifittype_id'] = $adb->query_result($resultallocation, 0,'benifittype_id');            
            $allocation['status'] = $adb->query_result($resultallocation, 0,'status');
            $allocation['allocation_code'] = $adb->query_result($resultallocation, 0,'allocation_code');
            $allocation['allocation_desc'] = $adb->query_result($resultallocation, 0,'allocation_desc');
            $allocation['allocationtitle'] = $adb->query_result($resultallocation, 0,'allocation_title');

            for($i=0;$i<$adb->num_rows($resultbenefittypes);$i++){

                $allocation['benefitdetails'][$i]['benefit_type'] = $adb->query_result($resultbenefittypes, $i,'benefit_type');

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



        $query = "SELECT * FROM vtiger_benefittype INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_benefittype.benefittypeid WHERE deleted = 0";
        $result = $adb->pquery($query,array());
        $count = $adb->num_rows($result);

        for($i=0;$i<$count;$i++){
            $benefittype[$i]['id'] = $adb->query_result($result,$i, 'benefittypeid');
            $benefittype[$i]['title'] = $adb->query_result($result,$i, 'title');
        }


        $query = "SELECT GROUP_CONCAT(gradeid) AS gradeid FROM vtiger_grade INNER JOIN allocation_graderel ON allocation_graderel.grade_id = vtiger_grade.gradeid WHERE allocation_graderel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $preValues['grade_id'] = $adb->query_result($result, 0, 'gradeid');

        $preValues['grade_id'] = explode(",",$preValues['grade_id']); 


        $query = "SELECT GROUP_CONCAT(benefittypeid) AS benefittypeid FROM vtiger_benefittype INNER JOIN allocation_benefitrel ON allocation_benefitrel.benefit_type = vtiger_benefittype.benefittypeid WHERE allocation_benefitrel.allocation_id = ?";
        $result = $adb->pquery($query,array($alloctaionId));
        $count = $adb->num_rows($result);
        $preValues['benefit_id'] = $adb->query_result($result, 0, 'benefittypeid');

        $preValues['benefit_id'] = explode(",",$preValues['benefit_id']); 

        $qualifiedModuleName = $request->getModule(false);

      //  echo "<pre>"; print_r($allocation); die;

        $viewer = $this->getViewer($request);
        $viewer->assign("BENEFITTYPE",json_encode($benefittype));
        $viewer->assign("GRADE",$grade);
        $viewer->assign("VALUES",$allocation);
        $viewer->assign("PREVALUES",$preValues);
        $viewer->assign("BENEFITTYPEVALUES",json_encode($allocation['benefitdetails']));
        $viewer->view('AllocationBenefitEditView.tpl', $qualifiedModuleName);
    }

    public function DeleteAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $qstnmark ='';
        /*$query = "DELETE allocation_list, allocation_leaverel FROM allocation_list INNER JOIN allocation_leaverel ON allocation_list.allocation_id = allocation_leaverel.allocation_id WHERE allocation_list.allocation_id IN ( ";*/
        

        for ($i = 0; $i < count($SeperatedValues); $i++) {

            $adb->pquery("DELETE FROM allocation_list WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_leaverel WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_claimrel WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_graderel WHERE allocation_id = ?",array($SeperatedValues[$i]));            

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

    public function DeleteClaimAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $qstnmark ='';
        /*$query = "DELETE allocation_list, allocation_leaverel FROM allocation_list INNER JOIN allocation_leaverel ON allocation_list.allocation_id = allocation_leaverel.allocation_id WHERE allocation_list.allocation_id IN ( ";*/
        

        for ($i = 0; $i < count($SeperatedValues); $i++) {

            $adb->pquery("DELETE FROM allocation_list WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_claimrel WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_graderel WHERE allocation_id = ?",array($SeperatedValues[$i]));            

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

    public function DeleteBenefitAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $SeperatedValues = explode(',', $request->get('values'));
        $qstnmark ='';
        /*$query = "DELETE allocation_list, allocation_leaverel FROM allocation_list INNER JOIN allocation_leaverel ON allocation_list.allocation_id = allocation_leaverel.allocation_id WHERE allocation_list.allocation_id IN ( ";*/
        

        for ($i = 0; $i < count($SeperatedValues); $i++) {

            $adb->pquery("DELETE FROM allocation_list WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_benefitrel WHERE allocation_id = ?",array($SeperatedValues[$i]));
            $adb->pquery("DELETE FROM allocation_graderel WHERE allocation_id = ?",array($SeperatedValues[$i]));            

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
       //$adb->setDebug(true);
        $insertArray = $request->get('form'); 
        $Allocation = array();
        $leavetype = array();
        $selectedgrades = array();
        //echo "<pre>"; print_r($insertArray); die;
        $leavetypecounter = -1;
        $claimTypeCounter = 0;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade[]') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_leavetype')>-1){
                $leavetypecounter++;
                $leaveTypeId[$leavetypecounter] = $leavetype[$leavetypecounter]['Allocation_leavetype'] = $insertArray[$i]['value'];
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
            else  if($insertArray[$i]['name']=='Allocation_claimtype') {
                $selectedclaims[$claimTypeCounter] = $insertArray[$i]['value'];
                $claimTypeCounter++;
            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        } 

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }
        //$adb->setDebug(true);
        // Validation By Mabruk

        $stringClaims = implode(",",$selectedclaims);
        $stringLeaveTypes = implode(",",$leaveTypeId);

        $validationResponse = array();        

        // Check ClaimTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringClaims == '' || $stringClaims == null)
                $stringClaims = 0;
            $result = $adb->pquery("SELECT grade,claim_type
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_claimrel 
                                    ON allocation_claimrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_claimtype
                                    ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_claimrel.claim_id IN ($stringClaims)", array($selectedgrades[$i])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'claim_type');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["claims"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringLeaveTypes == '' || $stringLeaveTypes == null)
                $stringLeaveTypes = 0;
            $result = $adb->pquery("SELECT grade,title
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_leaverel 
                                    ON allocation_leaverel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_leavetype
                                    ON allocation_leaverel.leavetype_id = vtiger_leavetype.leavetypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_leaverel.leavetype_id IN ($stringLeaveTypes)", array($selectedgrades[$i])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'title');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["leaveTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["claims"]))
            $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);
        else
            $validationResponse["claims"] = "";

        if (!empty($validationResponse["leaveTypes"]))
            $validationResponse["leaveTypes"] = implode("<br><br>",$validationResponse["leaveTypes"]);
        else
            $validationResponse["leaveTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["leaveTypes"] != "" || $validationResponse["claims"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End
        
        $Allocationid = $adb->getUniqueID('allocation_list');

        $query = "INSERT INTO `allocation_list` (`allocation_id`,`allocation_title`,`allocation_code`, `status`,`allocation_desc`) VALUES (?,?,?,?,?)";
        $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'], $Allocation['Allocation_Desc']));

//print_r($selectedclaims);die;
        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocationid, $selectedgrades[$i]));

        }

        for($i=0;$i<count($selectedclaims);$i++){            

            $query = "INSERT INTO `allocation_claimrel` (`allocation_id`,`claim_id`) VALUES(?,?)";
            $result = $adb->pquery($query,array($Allocationid, $selectedclaims[$i]));

        }

        for($i=0;$i<count($leavetype);$i++){

          $query = "INSERT INTO `allocation_leaverel` (`allocation_id`,`leavetype_id`,`ageleave`,`numberofleavesmore`,`numberofleavesless`) VALUES(?,?,?,?,?)";
          $result = $adb->pquery($query,array($Allocationid,$leavetype[$i]['Allocation_leavetype'], $leavetype[$i]['ageleave'], $leavetype[$i]['numberofleavesmore'], $leavetype[$i]['numberofleavesless']));

        }        

        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

    public function AddClaimAllocation($request){
        //echo "Here";die;
        global $adb;
       //$adb->setDebug(true);
        $insertArray = $request->get('form'); 
        $Allocation = array();
        $claimtype = array();
        $selectedgrades = array();
        //echo "<pre>"; print_r($insertArray); die;
        $claimtypecounter = -1;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade[]') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_claimtype')>-1){
                $claimtypecounter++;
                $claimTypeId[$claimtypecounter] = $claimtype[$claimtypecounter]['Allocation_claimtype'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'trans_limit')>-1){
                $claimtype[$claimtypecounter]['trans_limit'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'monthly_limit')>-1){
                $claimtype[$claimtypecounter]['monthly_limit'] = $insertArray[$i]['value'];

            }
            else if(stripos($insertArray[$i]['name'],'yearly_limit')>-1){
                $claimtype[$claimtypecounter]['yearly_limit'] = $insertArray[$i]['value'];

            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        } 

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }
        //$adb->setDebug(true);
        // Validation By Mabruk

        $stringClaimTypes = implode(",",$claimTypeId);

        $validationResponse = array();        

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringClaimTypes == '' || $stringClaimTypes == null)
                $stringClaimTypes = 0;
            $result = $adb->pquery("SELECT grade,claim_type
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_claimrel
                                    ON allocation_claimrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_claimtype
                                    ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_claimrel.claim_id IN ($stringClaimTypes)", array($selectedgrades[$i]));

            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'claim_type');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["claimTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["claimTypes"]))
            $validationResponse["claimTypes"] = implode("<br><br>",$validationResponse["claimTypes"]);
        else
            $validationResponse["claimTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["claimTypes"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End
        
        $Allocationid = $adb->getUniqueID('allocation_list');

        $query = "INSERT INTO `allocation_list` (`allocation_id`,`allocation_title`,`allocation_code`, `status`,`allocation_desc`) VALUES (?,?,?,?,?)";
        $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'], $Allocation['Allocation_Desc']));

//print_r($selectedclaims);die;
        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocationid, $selectedgrades[$i]));

        }

        for($i=0;$i<count($claimtype);$i++){

            $query = "INSERT INTO `allocation_claimrel` (`allocation_id`,`claim_id`,`grade_id`,`monthly_limit`,`yearly_limit`,`transaction_limit`) VALUES(?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocationid,$claimtype[$i]['Allocation_claimtype'], 0, $claimtype[$i]['monthly_limit'], $claimtype[$i]['yearly_limit'], $claimtype[$i]['trans_limit']));   
        }        

        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

    public function AddBenefitAllocation($request){
        //echo "Here";die;
        global $adb;
       //$adb->setDebug(true);
        $insertArray = $request->get('form'); 
        $Allocation = array();
        $benefittype = array();
        $selectedgrades = array();
        //echo "<pre>"; print_r($insertArray); die;
        $benefittypecounter = -1;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade[]') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_benefittype')>-1){
                $benefittypecounter++;
                $benefitTypeId[$benefittypecounter] = $benefittype[$benefittypecounter]['Allocation_benefittype'] = $insertArray[$i]['value'];
            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        } 

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }
        //$adb->setDebug(true);
        // Validation By Mabruk

        $stringBenefitTypes = implode(",",$benefitTypeId);

        $validationResponse = array();

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringBenefitTypes == '' || $stringBenefitTypes == null)
                $stringBenefitTypes = 0;
            $result = $adb->pquery("SELECT grade,title
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_benefitrel
                                    ON allocation_claimrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_benefittype
                                    ON allocation_benefitrel.benefit_type = vtiger_benefittype.benefittypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_benefitrel.benefit_type IN ($stringBenefitTypes)", array($selectedgrades[$i]));

            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'title');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["benefitTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["benefitTypes"]))
            $validationResponse["benefitTypes"] = implode("<br><br>",$validationResponse["benefitTypes"]);
        else
            $validationResponse["benefitTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["benefitTypes"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End
        
        $Allocationid = $adb->getUniqueID('allocation_list');

        $query = "INSERT INTO `allocation_list` (`allocation_id`,`allocation_title`,`allocation_code`, `status`,`allocation_desc`) VALUES (?,?,?,?,?)";
        $result = $adb->pquery($query,array($Allocationid,$Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'], $Allocation['Allocation_Desc']));

//print_r($selectedclaims);die;
        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocationid, $selectedgrades[$i]));

        }

        for($i=0;$i<count($benefittype);$i++){

            $query = "INSERT INTO `allocation_benefitrel` (`allocation_id`,`benefit_type`,`grade_id`) VALUES(?,?,?)";
            $result = $adb->pquery($query,array($Allocationid,$benefittype[$i]['Allocation_benefittype'], 0));   
        }        

        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

    public function UpdateAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        // echo "<pre>"; print_r($insertArray); die;
        $Allocation = array();
        $leavetype= array();
        $leavetypecounter = -1;
        $claimTypeCounter = 0;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_leavetype')>-1){
                $leavetypecounter++;
                $leaveTypeId[$leavetypecounter] = $leavetype[$leavetypecounter]['Allocation_leavetype'] = $insertArray[$i]['value'];
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
            else  if($insertArray[$i]['name']=='Allocation_claimtype') {
                $selectedclaims[$claimTypeCounter] = $insertArray[$i]['value'];
                $claimTypeCounter++;
            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }

        // Validation By Mabruk

        $stringClaims = implode(",",$selectedclaims);
        $stringLeaveTypes = implode(",",$leaveTypeId);

        $validationResponse = array();        

        // Check ClaimTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringClaims == '' || $stringClaims == null)
                $stringClaims = 0;
            $result = $adb->pquery("SELECT grade,claim_type
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_claimrel 
                                    ON allocation_claimrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_claimtype
                                    ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_claimrel.claim_id IN ($stringClaims)
                                    AND allocation_claimrel.allocation_id <> ?", array($selectedgrades[$i],$Allocation['allocation_id'])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'claim_type');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["claims"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringLeaveTypes == '' || $stringLeaveTypes == null)
                $stringLeaveTypes = 0;
            $result = $adb->pquery("SELECT grade,title
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_leaverel 
                                    ON allocation_leaverel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_leavetype
                                    ON allocation_leaverel.leavetype_id = vtiger_leavetype.leavetypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_leaverel.leavetype_id IN ($stringLeaveTypes)
                                    AND allocation_leaverel.allocation_id <> ?", array($selectedgrades[$i],$Allocation['allocation_id'])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'title');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["leaveTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["claims"]))
            $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);
        else
            $validationResponse["claims"] = "";

        if (!empty($validationResponse["leaveTypes"]))
            $validationResponse["leaveTypes"] = implode("<br><br>",$validationResponse["leaveTypes"]);
        else
            $validationResponse["leaveTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["leaveTypes"] != "" || $validationResponse["claims"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End

        $query = "UPDATE `allocation_list` SET `allocation_title`=? ,`allocation_code`=? , `status`=? ,`allocation_desc`=?  WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc'], $Allocation['allocation_id']));

        $query = "DELETE FROM `allocation_leaverel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));


        for($i=0;$i<count($leavetype);$i++){

            $query = "INSERT INTO `allocation_leaverel` (`allocation_id`,`leavetype_id`,`ageleave`,`numberofleavesmore`,`numberofleavesless`) VALUES(?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocation['allocation_id'], $leavetype[$i]['Allocation_leavetype'], $leavetype[$i]['ageleave'], $leavetype[$i]['numberofleavesmore'], $leavetype[$i]['numberofleavesless'] ));
        }

        $query = "DELETE FROM `allocation_claimrel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($selectedclaims);$i++){            

            $query = "INSERT INTO `allocation_claimrel` (`allocation_id`,`claim_id`) VALUES(?,?)";
            $result = $adb->pquery($query,array($Allocation['allocation_id'], $selectedclaims[$i]));

        }


        $query = "DELETE FROM `allocation_graderel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocation['allocation_id'], $selectedgrades[$i]));

        }


        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

    public function UpdateClaimAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        // echo "<pre>"; print_r($insertArray); die;
        $Allocation = array();
        $claimtype= array();
        $claimtypecounter = -1;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_claimtype')>-1){
                $claimtypecounter++;
                $claimTypeId[$claimtypecounter] = $claimtype[$claimtypecounter]['Allocation_claimtype'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'trans_limit')>-1){
                $claimtype[$claimtypecounter]['trans_limit'] = $insertArray[$i]['value'];
            }
            else if(stripos($insertArray[$i]['name'],'monthly_limit')>-1){
                $claimtype[$claimtypecounter]['monthly_limit'] = $insertArray[$i]['value'];

            }
            else if(stripos($insertArray[$i]['name'],'yearly_limit')>-1){
                $claimtype[$claimtypecounter]['yearly_limit'] = $insertArray[$i]['value'];

            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }

        // Validation By Mabruk

        $stringClaims = implode(",",$selectedclaims);
        $stringClaimTypes = implode(",",$claimTypeId);

        $validationResponse = array();        

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringClaimTypes == '' || $stringClaimTypes == null)
                $stringClaimTypes = 0;
            $result = $adb->pquery("SELECT grade,claim_type
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_claimrel 
                                    ON allocation_claimrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_claimtype
                                    ON allocation_claimrel.claim_id = vtiger_claimtype.claimtypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_claimrel.claim_id IN ($stringClaimTypes)
                                    AND allocation_claimrel.allocation_id <> ?", array($selectedgrades[$i],$Allocation['allocation_id'])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'claim_type');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["claimTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["claims"]))
            $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);
        else
            $validationResponse["claims"] = "";

        if (!empty($validationResponse["claimTypes"]))
            $validationResponse["claimTypes"] = implode("<br><br>",$validationResponse["claimTypes"]);
        else
            $validationResponse["claimTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["claimTypes"] != "" || $validationResponse["claims"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End

        $query = "UPDATE `allocation_list` SET `allocation_title`=? ,`allocation_code`=? , `status`=? ,`allocation_desc`=?  WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc'], $Allocation['allocation_id']));

        $query = "DELETE FROM `allocation_claimrel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($claimtype);$i++){

            $query = "INSERT INTO `allocation_claimrel` (`allocation_id`,`claim_id`,`grade_id`,`monthly_limit`,`yearly_limit`,`transaction_limit`) VALUES(?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($Allocation['allocation_id'],$claimtype[$i]['Allocation_claimtype'], 0, $claimtype[$i]['monthly_limit'], $claimtype[$i]['yearly_limit'], $claimtype[$i]['trans_limit']));
        }
        
        

        $query = "DELETE FROM `allocation_graderel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocation['allocation_id'], $selectedgrades[$i]));

        }


        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

    public function UpdateBenefitAllocation($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');
        // echo "<pre>"; print_r($insertArray); die;
        $Allocation = array();
        $benefittype= array();
        $benefittypecounter = -1;
        $gradeCounter = 0;

        for($i = 0; $i < count($insertArray); $i++) { 

            if($insertArray[$i]['name']=='Allocation_grade') {  
                $selectedgrades[$gradeCounter] = $insertArray[$i]['value'];
                $gradeCounter++;
            }
            else if(stripos($insertArray[$i]['name'],'Allocation_benefittype')>-1){
                $benefittypecounter++;
                $benefitTypeId[$benefittypecounter] = $benefittype[$benefittypecounter]['Allocation_benefittype'] = $insertArray[$i]['value'];
            }
            else{
                $Allocation[$insertArray[$i]['name']] = $insertArray[$i]['value'];
            }
        }

        // Mabruk
        $fields = "";                    

        if ($Allocation['AllocationTitle'] == "" || $Allocation['AllocationTitle'] == null)
            $fields .= "{Field: Allocation Title}<br>"; 

        if ($gradeCounter == 0) 
            $fields .= "{Field: Grade}<br> ";       

        $fields = trim($fields);
        
        if ($fields != "") {

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Missing", "data" => $fields));
            $response->emit();
            exit;

        }

        if(!isset($Allocation['status'])){
            $Allocation['status']= 'off';
        }

        // Validation By Mabruk

        $stringBenefitTypes = implode(",",$benefitTypeId);

        $validationResponse = array();        

        //$validationResponse['claim'] = implode("<br>", )

        //if (!empty($validationResponse["claims"]))
         //   $validationResponse["claims"] = implode("<br><br>",$validationResponse["claims"]);

        // Check LeaveTypes
        for($i=0;$i<count($selectedgrades);$i++){
        //$adb->setDebug(true);
            if ($stringBenefitTypes == '' || $stringBenefitTypes == null)
                $stringBenefitTypes = 0;
            $result = $adb->pquery("SELECT grade,claim_type
                                    FROM allocation_graderel 
                                    INNER JOIN vtiger_grade 
                                    ON allocation_graderel.grade_id = vtiger_grade.gradeid
                                    INNER JOIN allocation_benefitrel 
                                    ON allocation_benefitrel.allocation_id =  allocation_graderel.allocation_id
                                    INNER JOIN vtiger_benefittype
                                    ON allocation_benefitrel.benefit_type = vtiger_benefittype.benefittypeid 
                                    WHERE allocation_graderel.grade_id = ?
                                    AND allocation_benefitrel.benefit_type IN ($stringBenefitTypes)
                                    AND allocation_benefitrel.allocation_id <> ?", array($selectedgrades[$i],$Allocation['allocation_id'])); 
            $rows = $adb->num_rows($result);

            if ($rows == 0)
                continue;

            $checkTitle = array();

            for ($j = 0; $j < $rows; $j++) {

                $checkTitle[$j] = $adb->query_result($result, $j, 'title');

            }

            if (count($checkTitle) > 1)
                $verb = "are";
            else
                $verb = "is";

            $checkTitle = implode(",", $checkTitle);

            $checkGrade = $adb->query_result($result, 0, 'grade');

            if (!empty($checkGrade) && !empty($checkTitle)) {

                $validationResponse["benefitTypes"][$i] = "$checkTitle $verb already assigned to $checkGrade";
                
            }           
        
        }

        //$validationResponse['claim'] = implode("<br>", )

        if (!empty($validationResponse["benefits"]))
            $validationResponse["benefits"] = implode("<br><br>",$validationResponse["benefits"]);
        else
            $validationResponse["benefits"] = "";

        if (!empty($validationResponse["benefitTypes"]))
            $validationResponse["benefitTypes"] = implode("<br><br>",$validationResponse["benefitTypes"]);
        else
            $validationResponse["benefitTypes"] = "";
        /*/ Check ClaimTypes
        for($i=0;$i<count($selectedclaims);$i++){
        
            $result = $adb->pquery("SELECT claimtype FROM allocation_claimrel INNER JOIN vtiger_claimtype ON allocation_claimrel.claim_id = vtiger_claimtype.claimid WHERE allocation_claimrel.claim_id = ?", array($selectedclaims[$i]));
            $checkClaim = $adb->query_result($result, $i, 'claimtype');

            if ($checkClaim != '' && $checkClaim != null){

                $validationResponse["claims"] = $checkClaim;
                
            }           
        
        } */

        if ($validationResponse["benefitTypes"] != "" || $validationResponse["benefits"] != "") {
            
            /*if (!empty($validationResponse['grades']))
                $validationResponse['grades'] = implode(",",$validationResponse['grades']);

            else if (!empty($validationResponse['claims']))
                $validationResponse['claims'] = implode(",",$validationResponse['claims']); */ 

            //print_r($validationResponse);

            $response = new Vtiger_Response();
            $response->setResult(array("result" => "Not Allowed", "data" => $validationResponse));
            $response->emit();

            exit;                 

        }


        // Validation End

        $query = "UPDATE `allocation_list` SET `allocation_title`=? ,`allocation_code`=? , `status`=? ,`allocation_desc`=?  WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['AllocationTitle'],$Allocation['AllocationCode'],$Allocation['status'],$Allocation['Allocation_Desc'], $Allocation['allocation_id']));

        $query = "DELETE FROM `allocation_benefitrel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($benefittype);$i++){

            $query = "INSERT INTO `allocation_benefitrel` (`allocation_id`,`benefit_type`,`grade_id`) VALUES(?,?,?)";
            $result = $adb->pquery($query,array($Allocation['allocation_id'],$benefittype[$i]['Allocation_benefittype'], 0));
        }
        
        

        $query = "DELETE FROM `allocation_graderel` WHERE allocation_id = ?";
        $result = $adb->pquery($query,array($Allocation['allocation_id']));

        for($i=0;$i<count($selectedgrades);$i++){

          $query = "INSERT INTO `allocation_graderel` (`allocation_id`,`grade_id`) VALUES(?,?)";
          $result = $adb->pquery($query,array($Allocation['allocation_id'], $selectedgrades[$i]));

        }


        if($result){
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "success"));
            $response->emit();
        }else{
            $response = new Vtiger_Response();
            $response->setResult(array("result" => "failed"));
            $response->emit();
        }

        //echo $response;

    }

}

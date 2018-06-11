<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */

include("modules/BenefitType/BenefitType.php");


class Settings_Vtiger_BenefitTypeTools_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('AddBenefitTypeForm');
        $this->exposeMethod('AddBenefitType');
        $this->exposeMethod('DeleteBenefitType');
        $this->exposeMethod('EditBenefitTypeForm');
        $this->exposeMethod('UpdateBenefitType');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function AddBenefitTypeForm($request){
        global $adb;
        $qualifiedModuleName = $request->getModule(false);

        $viewer = $this->getViewer($request);
        $viewer->view('AddBenefitType.tpl', $qualifiedModuleName);
    }


    public function EditBenefitTypeForm($request){
         global $adb;
       // $adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `vtiger_benefittype` WHERE benefittypeid = ?";
        $result = $adb->pquery($query,array($values[0]));
        $count = $adb->num_rows($result);
        $benefit_type = array();

        if($count>0){

            $benefit_type['benefit_type'] = $adb->query_result($result, 0,'benefit_type');
            $benefit_type['benefit_code'] = $adb->query_result($result, 0,'benefit_code');
            $benefit_type['status'] = $adb->query_result($result, 0,'status');
            $benefit_type['benefit_desc'] = $adb->query_result($result, 0,'benefit_desc');
            $benefit_type['title'] = $adb->query_result($result, 0,'title');
            $benefit_type['benefittypeid'] = $adb->query_result($result, 0,'benefittypeid');


        }

        $qualifiedModuleName = $request->getModule(false);



        $viewer = $this->getViewer($request);
        $viewer->assign("VALUES",$benefit_type);
        $viewer->view('EditBenefitType.tpl', $qualifiedModuleName);
    }

    public function DeleteBenefitType($request){
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

    public function AddBenefitType($request){
        global $adb;
       // $adb->setDebug(true);
        $insertArray = $request->get('form');
        //echo "<pre>"; print_r($insertArray); die;

        $benefittype = array();

        for($i=0;$i<count($insertArray);$i++) {
            $name = $insertArray[$i]['name'];
            $benefittype[$name] = $insertArray[$i]['value'];

        }

        if(!isset($leavetype['status'])){
            $leavetype['status']= 'off';
        }

        $benefittypeid = $adb->getUniqueID('vtiger_crmentity');

        $crmentityinsertquery = "INSERT INTO vtiger_crmentity (crmid, smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime, viewedtime, status, version, presence, deleted, smgroupid, source, label) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,?,?,?,?,?,?,?)";

        $params = array($benefittypeid,1,1,1,"Benefit Type",'','',1,1,0,'','','');

        $crmentityinsertresult = $adb->pquery($crmentityinsertquery,array($params));

        if($crmentityinsertresult){
            $query = "INSERT INTO `vtiger_benefittype` (`benefittypeid`, `benefit_type`, `benefit_desc`,`status`,`title`,`benefit_code`) VALUES (?,?,?,?,?,?)";
            $result = $adb->pquery($query,array($benefittypeid,$benefittype['BenefitType'],$benefittype['BenefitType_Desc'],$benefittype['status'],$benefittype['BenefitTypeTitle'],$benefittype['BenefitCode']));

        }
        if($result){
            $query = "INSERT INTO vtiger_benefittypecf (benefittypeid) VALUES (?)";
            $claimtypetables_result = $adb->pquery($query,array($benefittypeid));
        }

       // die;
        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateBenefitType($request){
        global $adb;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');

        $benefittype = array();



        for($i=0;$i<count($insertArray);$i++) {
            $test = $insertArray[$i]['name'];
            $benefittype[$test] = $insertArray[$i]['value'];

        }
        if(!isset($benefittype['status'])){
            $benefittype['status']= 'off';
        }


        $query = "UPDATE `vtiger_benefittype` SET `benefit_type`=?, `benefit_desc`=?,`status`=?,`title`=?,`benefit_code`=? WHERE `benefittypeid`=?";
        $result = $adb->pquery($query,array($benefittype['BenefitType'],$benefittype['BenefitType_Desc'],$benefittype['status'],$benefittype['BenefitTypeTitle'],$benefittype['BenefitCode'],$benefittype['benefittypeid']));




        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
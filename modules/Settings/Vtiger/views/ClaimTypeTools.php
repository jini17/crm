<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/20/18
 * Time: 6:21 PM
 */

class Settings_Vtiger_ClaimTypeTools_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('AddClaimTypeForm');
        $this->exposeMethod('AddClaimType');
        $this->exposeMethod('DeleteClaimType');
        $this->exposeMethod('EditClaimTypeForm');
        $this->exposeMethod('UpdateClaimType');
    }

    public function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }



    }

    public function AddClaimTypeForm($request){
       global $adb;
       $qualifiedModuleName = $request->getModule(false);

        $viewer = $this->getViewer($request);
        $viewer->view('AddClaimType.tpl', $qualifiedModuleName);
    }


    public function EditClaimTypeForm($request){
        //echo "<pre>"; print_r($request); die;
        global $adb;
        $adb->setDebug(true);
        $qualifiedModuleName = $request->getModule(false);
        $values = explode(',', $request->get('values'));

        if($values.length > 0){
            return false;
        }

        $query = "SELECT * FROM `vtiger_claimtype` WHERE claimtypeid = ?";
        $result = $adb->pquery($query,array($values[0]));
        $count = $adb->num_rows($result);
        //echo "Nirbhay".$count;die;
        $claim_type = array();

        if($count>0){

                $claim_type['claim_type'] = $adb->query_result($result, 0,'claim_type');
                $claim_type['claim_code'] = $adb->query_result($result, 0,'claim_code');
                $claim_type['claim_status'] = $adb->query_result($result, 0,'claim_status');
                $claim_type['claim_description'] = $adb->query_result($result, 0,'claim_description');
                $claim_type['claim_type_id'] = $adb->query_result($result, 0,'claimtypeid');


        }

        $qualifiedModuleName = $request->getModule(false);



        $viewer = $this->getViewer($request);
        $viewer->assign("VALUES",$claim_type);
        $viewer->view('EditClaimType.tpl', $qualifiedModuleName);
    }

    public function DeleteClaimType($request){
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

    public function AddClaimType($request){
        global $adb;
        $insertArray = $request->get('form');
        echo "<pre>";print_r($insertArray);die;
        $claims =  array();
        for($i=0;$i<count($insertArray);$i++) {
            $test = $insertArray[$i]['name'];
            $claims[$test] = $insertArray[$i]['value'];

        }

        if(!isset($claims['status'])){
            $claims['status']= 'off';
        }

        if(!isset($claims['transactionlimitcheck'])){
            $claims['transactionlimit']= '-1';
        }

        if(!isset($claims['monthlylimitcheck'])){
            $claims['monthlylimit']= '-1';
        }

        if(!isset($claims['yearlylimitcheck'])){
            $claims['yearlylimit']= '-1';
        }



        $claimtypeid = $adb->getUniqueID('vtiger_crmentity');

        $crmentityinsertquery = "INSERT INTO vtiger_crmentity (crmid, smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime, viewedtime, status, version, presence, deleted, smgroupid, source, label) VALUES(?,?,?,?,?,?,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,?,?,?,?,?,?,?)";

        $params = array($claimtypeid,1,1,1,"ClaimType",'','',1,1,0,'','','');

        $crmentityinsertresult = $adb->pquery($crmentityinsertquery,array($params));

        if($crmentityinsertresult){
            $query = "INSERT INTO `vtiger_claimtype` (`claimtypeid`, `claim_type`, `claim_code`,`claim_status`,`claim_description`,`transactionlimit`,`monthlylimit`,`yearlylimit`) VALUES (?,?,?,?,?)";
            $result = $adb->pquery($query,array($claimtypeid,$claims['ClaimTypeTitle'],$claims['ClaimCode'],$claims['status'],$claims['ClaimType_Desc'],$claims['ClaimTypeId'],$claims['transactionlimit'], $claims['monthlylimit'], $claims['yearlylimit']));

        }
        if($result){
            $query = "INSERT INTO vtiger_claimtypecf (claimtypeid) VALUES (?)";
            $claimtypetables_result = $adb->pquery($query,array($claimtypeid));
        }


        if($claimtypetables_result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

    public function UpdateClaimType($request){
        global $adb;
        //echo "<pre>"; print_r($request); die;
        //$adb->setDebug(true);
        $insertArray = $request->get('form');

        $claims = array();

        //echo "Nirbhay";


        for($i=0;$i<count($insertArray);$i++) {
            //echo "NNN";
           $test = $insertArray[$i]['name'];
           $claims[$test] = $insertArray[$i]['value'];

        }
       // echo "Nirbhay111";
        if(!isset($claims['status'])){
           $claims['status']= 'off';
        }

       // echo "NirbhayNiorbhay<pre>"; print_r($claims); die;

        $query = "UPDATE `vtiger_claimtype` SET `claim_type`=?, `claim_code`=?, `claim_status`=?, `claim_description`=? WHERE claimtypeid=?";
        $result = $adb->pquery($query,array($claims['ClaimTypeTitle'],$claims['ClaimCode'],$claims['status'],$claims['ClaimType_Desc'],$claims['ClaimTypeId']));





        if($result){
            $response = "success";
        }else{
            $response = "failed";
        }

        echo $response;

    }

}
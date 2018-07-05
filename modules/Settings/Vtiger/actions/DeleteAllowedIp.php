<?php
/**
 * Created by Nirbhay.
 * User: root
 * Date: 4/17/18
 * Time: 6:24 PM
 */


class Settings_Vtiger_DeleteAllowedIp_Action extends Settings_Vtiger_Basic_Action {

    public function process(Vtiger_Request $request) {
        global $adb;
        $SeperatedValues = explode(',', $request->get('values'));
        //echo "Nirbhay";echo count($SeperatedValues);
        $stringVal ='';
        for($i=0;$i<count($SeperatedValues);$i++){
            if($i!=(count($SeperatedValues)-1))
                $stringVal .= "'".$SeperatedValues[$i]."',";
            else
                $stringVal .= "'".$SeperatedValues[$i]."'";
        }
        $result = $adb->pquery("delete FROM allowed_ip WHERE ip_id in ($stringVal)",array());

        $responses = [true];

        $responses->emit;
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateWriteAccess();
    }
}

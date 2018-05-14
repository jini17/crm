<?php
/**
 * Created by Nirbhay and Mabruk.
 * For Multiple Outgoing Server Implementation
 * Date: 8/5/2018
 */


class Settings_Vtiger_DeleteOutgoingServers_Action extends Settings_Vtiger_Basic_Action {

    public function process(Vtiger_Request $request) {
        global $adb;
        $SeperatedValues = explode(',', $request->get('values'));
        $stringVal ='';
        for($i=0;$i<count($SeperatedValues);$i++){
            if($i!=(count($SeperatedValues)-1))
                $stringVal .= "'".$SeperatedValues[$i]."',";
            else
                $stringVal .= "'".$SeperatedValues[$i]."'";
        }
        $result = $adb->pquery("delete FROM vtiger_systems WHERE id in ($stringVal)",array());

        $responses = [true];

        $responses->emit;
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateWriteAccess();
    }
}

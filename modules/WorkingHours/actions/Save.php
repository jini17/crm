<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class WorkingHours_Save_Action extends Vtiger_Save_Action {

        public function process(Vtiger_Request $request) {

                $array = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
                global $adb;
                $adb->setDebug(true);
                foreach($array as $key=>$val) {

                        $from = $request->get($val.'_from');			//modify by jitu@5Jan2017	
                        $to = $request->get($val.'_to');				//modify by jitu@5Jan2017	
                        $request->set($val, $from.'##'.$to);		//modify by jitu@5Jan2017		

                }
                 parent::process($request); 
        }
}

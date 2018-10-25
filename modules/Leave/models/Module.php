<?php

/**
 * Vtiger Module Model Class
 */
class Leave_Module_Model extends Vtiger_Module_Model {

	 /**
         * Function to check whether the module is enabled for quick create
         * @return <Boolean> - true/false
         */
        public function isQuickCreateSupported() {
                return true;
        }

}

?>	
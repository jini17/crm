<?php
/* ===================================================================
Modified By: Jitu, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 19 / 09 / 2014
Change Reason: Multiple Company Details , New file created
=================================================================== */

class Vtiger_CompanyDetails_UIType extends Vtiger_Base_UIType {
    
	public function getTemplateName() {
		return 'uitypes/CompanyDetails.tpl';
	}
        
   	public function getDetailViewTemplateName() {
            return 'uitypes/StringDetailView.tpl';
   	}
       
}

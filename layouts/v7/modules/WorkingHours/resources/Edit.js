/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("WorkingHours_Edit_Js",{
   
},{
   
	
	/**
	 * Function which will map the address details of the selected record
	 */
	registerEventForCopyDuration : function(addressDetails, result, container) {
		for(var key in addressDetails) {
			// While Quick Creat we don't have address fields, we should  add
            if(container.find('[name="'+key+'"]').length == 0) { 
                   container.append("<input type='hidden' name='"+key+"'>"); 
            } 
			container.find('[name="'+key+'"]').val(result[addressDetails[key]]);
			container.find('[name="'+key+'"]').trigger('change');
			container.find('[name="'+addressDetails[key]+'"]').val(result[addressDetails[key]]);
			container.find('[name="'+addressDetails[key]+'"]').trigger('change');
		}
	},
	
	/**
	 * Function which will register basic events which will be used in quick create as well
	 *
	 */
	registerBasicEvents : function(container) {
		this._super(container);
		this.registerEventForCopyDuration(container);
	}
});
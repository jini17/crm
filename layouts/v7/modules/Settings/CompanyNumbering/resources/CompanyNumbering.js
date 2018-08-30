/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created by afiq@secondcrm.com for Multiple Company Numbering
 *************************************************************************************/

var Settings_CompanyNumbering_Js = {

	registerOnChangeEventOfCompanyNumbering :function(){ 
		$("#business").on('click', function(e) {
		  jQuery('#saveNumbering').removeAttr('disabled');	
		   if($("#business").is(':checked')) {
			$("#business").attr('checked','checked');	
			$("#hidBusiness").val('1');
			
		   } else {
			if(confirm(app.vtranslate('JS_WARNING_MSG_ON_UNCHECKBOX_NUMBERING'))){
				$("#hidBusiness").val('0');
			} else {
				$("#business").attr('checked','');
			}	
	
		   }			
		});
	},

	/**
	* Function to register event for saving module custom numbering
	*/
	saveModuleCustomNumbering : function(){ 
		jQuery('#saveNumbering').on('click',function(e) { 
		var params = {}
		
		params = {
			 module  : app.getModuleName(),
			 parent  : app.getParentModuleName(),
			 action  : "SaveAjax",
			 mode	 : "saveCompanyNumberingSetting", 	
			 business: jQuery("#hidBusiness").val()
		}
		
		AppConnector.request(params).then(
			function(data){
				var params;
				var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_UPDATED_SUCCESSFULLY');
				if(data.success == true){
					jQuery(e.currentTarget).attr('disabled','disabled');
					params = {
						text: successfullSaveMessage
					};
					Settings_Vtiger_Index_Js.showMessage(params);
				}else{
					var errorMessage = app.vtranslate(data.error.message);
					params = {
						text: errorMessage,
						type: 'error'
					};
					Settings_Vtiger_Index_Js.showMessage(params);
				}
			});
	        });
	},
	
	registerEvents : function(){
		this.registerOnChangeEventOfCompanyNumbering();
		this.saveModuleCustomNumbering();
	}
}

jQuery(document).ready(function() {
	Settings_CompanyNumbering_Js.registerEvents();
	//Added By Mabruk
	var vtigerSettings = new Settings_Vtiger_Index_Js();
	vtigerSettings.registerAccordionClickEvent();
});

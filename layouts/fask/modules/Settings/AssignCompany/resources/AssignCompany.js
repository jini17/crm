/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
var Settings_AssignCompany_Js = {

	registerEnableAssignListValueClickEvent : function() {
		jQuery('#listViewContents').on('click','.assignToUserCompanyListValue',function(e) {
			jQuery('#saveOrder').removeAttr('disabled');

			var AssignListVaue = jQuery(e.currentTarget)
			if(AssignListVaue.hasClass('selectedCell')) {
				AssignListVaue.removeClass('selectedCell').addClass('unselectedCell');
				AssignListVaue.find('.fa-check').remove();
			} else {
				AssignListVaue.removeClass('unselectedCell').addClass('selectedCell');
				AssignListVaue.prepend('<i class="fa fa-check pull-left"></i>');
			}
		});
	},

	registerenableOrDisableListSaveEvent : function() { 
		jQuery('#saveOrder').on('click',function(e) { 
			var companyListValues = jQuery('.assignToUserCompanyListValue');
			var disabledValues = [];
			var enabledValues = [];
			jQuery.each(companyListValues,function(i,element) {
				var currentValue = jQuery(element);
				
				if(currentValue.hasClass('selectedCell')){
					enabledValues.push(currentValue.data('id'));
				} 
			});
			
			var params = {
				module : app.getModuleName(),
				parent : app.getParentModuleName(),
				action : 'SaveAjax',
				mode : 'enableOrDisable',
				enabled_values : enabledValues,
				userSelected : jQuery('#selUserlist').val()
			}
			AppConnector.request(params).then(function(data) {
				if(typeof data.result != 'undefined') {
					jQuery(e.currentTarget).attr('disabled','disabled');
					Settings_Vtiger_Index_Js.showMessage({text:app.vtranslate('JS_LIST_UPDATED_SUCCESSFULLY'),type : 'success'})
				}
			});
		});
	},

	registerChangeUserEvent : function() {
		jQuery('#selUserlist').on('change',function(e) { 
     		var aDeferred = jQuery.Deferred();
			var userList = jQuery(e.currentTarget);

			var params = {
				module : app.getModuleName(),
				parent : app.getParentModuleName(),
				view : 'IndexAjax',
				mode : 'getCompanyListValueByUser',
				userSelected : userList.val(),
			}
			app.request.post({data:params}).then(function(err,data) {
		
			 if(err == null){
                   jQuery('#assignToRolepickListValuesTable').html(data);
			    aDeferred.reject(data);
			 } else {
			    aDeferred.resolve(data);
				     }
               });
		return aDeferred.promise();
		})
	},

	registerEvents : function() {
		Settings_AssignCompany_Js.registerChangeUserEvent();
		Settings_AssignCompany_Js.registerenableOrDisableListSaveEvent();	
		Settings_AssignCompany_Js.registerEnableAssignListValueClickEvent();
	}
}

jQuery(document).ready(function(){
	Settings_AssignCompany_Js.registerEvents();
})

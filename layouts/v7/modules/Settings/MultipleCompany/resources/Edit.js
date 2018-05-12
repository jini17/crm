/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Settings_Vtiger_Edit_Js('Settings_MultipleCompany_Edit_Js', {}, {
	/**
	 * Function to register form for validation
	 */
	
	registerFormForValidation : function(){
		var editViewForm = this.getForm();
		editViewForm.validationEngine({
				'custom_error_messages' : {                                
                            '#organization_title':{
                                'required':{
                                    'message':app.vtranslate('JS_LBL_COMPANY_TITLE_CANT_BLNK')
				}
			  },		
			  '#organizationname':{
                                'required':{
                                    'message':app.vtranslate('JS_LBL_COMPANY_NAME_CANT_BLNK')
								}		
                         }
		    }
			//app.getvalidationEngineOptions(true)
		});
	},
	
	/**
	 * Function to register the submit event of form
	 */
	registerSubmitEvent : function() {
		var thisInstance = this;
		var form = jQuery('#EditView');
		form.on('submit',function(e) {
			if(form.data('submit') == 'true' && form.data('performCheck') == 'true') {
				return true;
			} else {
				if(form.data('jqv').InvalidFields.length <= 0) {
					var formData = form.serializeFormData();
					thisInstance.checkDuplicateName({
						'companyname' : formData.organization_title,
						'record' : formData.organization_id
					}).then(
						function(data){
							form.data('submit', 'true');
							form.data('performCheck', 'true');
							form.submit();
						},
						function(data, err){
							var params = {};
							params['text'] = data['message'];
							params['type'] = 'error';
							Settings_Vtiger_Index_Js.showMessage(params);
							return false;
						}
					);
				} else {
					//If validation fails, form should submit again
					form.removeData('submit');
					// to avoid hiding of error message under the fixed nav bar
					app.formAlignmentAfterValidation(form);
				}
				e.preventDefault();
			}
		});
	},
	
	/*
	 * Function to check Duplication of Group Names
	 * returns boolean true or false
	 */
	checkDuplicateName : function(details) {
		var aDeferred = jQuery.Deferred();
		
		var params = {
		'module' : app.getModuleName(),
		'parent' : app.getParentModuleName(),
		'action' : 'EditAjax',
		'mode'   : 'checkDuplicate',
		'companyname' : details.companyname,
		'record' : details.record
		}
		
		AppConnector.request(params).then(
			function(data) {
				var response = data['result'];
				var result = response['success'];
				if(result == true) {
					aDeferred.reject(response);
				} else {
					aDeferred.resolve(response);
				}
			},
			function(error,err){
				aDeferred.reject();
			}
		);
		return aDeferred.promise();
	},
	
	/**
	 * Function which will handle the registrations for the elements 
	 */
	registerEvents : function() {
		this._super();
		this.registerSubmitEvent();
	}
});

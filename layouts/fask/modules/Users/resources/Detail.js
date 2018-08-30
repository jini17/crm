/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Detail_Js("Users_Detail_Js",{
	
	triggerChangePassword : function (url, module){
		app.request.get({'url' :url}).then(
			function(err, data) {
				if(err === null) {
					app.helper.showModal(data);
					var form = jQuery('#changePassword');
					
					form.on('submit',function(e){
						e.preventDefault();
					});
					
					var params = {
						submitHandler: function(form) {
							form = jQuery(form);
							var new_password  = form.find('[name="new_password"]');
							var confirm_password = form.find('[name="confirm_password"]');
							var old_password  = form.find('[name="old_password"]');
							var userid = form.find('[name="userid"]').val();

							if(new_password.val() === confirm_password.val()){
								var params = {
									'data' : {
										'module': app.getModuleName(),
										'action' : "SaveAjax",
										'mode' : 'savePassword',
										'old_password' : old_password.val(),
										'new_password' : new_password.val(),
										'userid' : userid
									}
								};

								app.request.post(params).then(
									function(err, data) {
										if(err == null){
											app.helper.hideModal();
											var successMessage = app.vtranslate(data.message);
											app.helper.showSuccessNotification({"message":successMessage});
										}else{
											app.helper.showErrorNotification({"message":err});	
											return false;
										}
									}
								);
							} else {
								var errorMessage = app.vtranslate('JS_PASSWORD_MISMATCH_ERROR');
								app.helper.showErrorNotification({"message":errorMessage});
								return false;
							}
						}
					};
					form.vtValidate(params);
				}else {
					app.helper.showErrorNotification({'message': err.message});
				}
			}
		);
	},

	triggerChangeAccessKey: function (url) {
		var title = app.vtranslate('JS_NEW_ACCESS_KEY_REQUESTED');
		var message = app.vtranslate('JS_CHANGE_ACCESS_KEY_CONFIRMATION');
		app.helper.showConfirmationBox({'title': title,'message': message}).then(function (data) {
			app.helper.showProgress(app.vtranslate('JS_PLEASE_WAIT'));
			app.request.post({'url': url}).then(function (err, data) {
				app.helper.hideProgress();
				if (err === null) {
					app.helper.showSuccessNotification({'message': data.message});
					var accessKeyEle = jQuery('#Users_detailView_fieldValue_accesskey');
					if (accessKeyEle.length) {
						accessKeyEle.find('.value').html(data.accessKey);
					}
				} else {
					app.helper.showErrorNotification({'message': err.message});
				}
			});
		});
	},

	/*
	 * function to trigger delete record action
	 * @params: delete record url.
	 */
	triggerDeleteUser : function(deleteUserUrl) {
		var message = app.vtranslate('LBL_DELETE_USER_CONFIRMATION');
		app.helper.showConfirmationBox({'message' : message}).then(function(data) {
				app.request.post({'url':deleteUserUrl}).then(
				function(err, data){
					if(err === null){
						app.helper.showModal(data);
						var form = jQuery("#deleteUser");
						form.on('submit', function(e){
							e.preventDefault();
							Users_Detail_Js.deleteUser(form);
						});
					}else {
						app.helper.showErrorNotification({'message': err.message});
					}
				});
			}
		);
	},
	
	deleteUser: function (form){
		var userid = form.find('[name="userid"]').val();
		var transferUserId = form.find('[name="tranfer_owner_id"]').val();
		app.helper.showProgress();
		
		var params = {
			'data' : {
				'module': app.getModuleName(),
				'action' : "DeleteAjax",
				'transfer_user_id' : transferUserId,
				'userid' : userid,
				'mode' : 'deleteUserFromDetailView',
				'permanent' : jQuery('[name="deleteUserPermanent"]:checked', form).val()
			}
		};
		
		app.request.post(params).then(
			function(err, data) {
				if(err === null){
					app.helper.hideProgress();
					app.helper.showSuccessNotification({'message': data.message});
					app.helper.hideModal();
					var url = data.listViewUrl;
					window.location.href=url;
				}else {
					app.helper.showErrorNotification({'message': err.message});
				}
			}
		);
	},
	
	triggerChangeUsername: function (url) {
		app.helper.showProgress(app.vtranslate('JS_PLEASE_WAIT'));

		app.request.post({'url' : url}).then(function (err, data) {
			app.helper.hideProgress();
			if(err === null) {
				var callback = function (data) {
					var form = data.find('#changeUsername');
					
					var params = {
						submitHandler : function(form) {
							var form = jQuery(form);
							var new_password = form.find('[name="new_password"]');
							var confirm_password = form.find('[name="confirm_password"]');
							if (new_password.val() !== confirm_password.val()) {
								
								var params = {
									position: {
										my: 'bottom left',
										at: 'top left',
										container : form
									},
								};
								vtUtils.showValidationMessage(new_password, app.vtranslate('JS_REENTER_PASSWORDS'), params);
								vtUtils.showValidationMessage(confirm_password, app.vtranslate('JS_REENTER_PASSWORDS'), params);
								return false;
							}else {
								vtUtils.hideValidationMessage(new_password);
								vtUtils.hideValidationMessage(confirm_password);
							}
							
							Users_Detail_Js.changeUserName(form);
						}
					};
					
					form.vtValidate(params);
				};
				var params = {
					cb : callback
				};
				app.helper.showModal(data, params);
			}
		});
	},
	
	changeUserName: function (form) {
		var newUsername = form.find('[name="new_username"]');
		var new_password = form.find('[name="new_password"]');
		var confirm_password = form.find('[name="confirm_password"]');
		var userid = form.find('[name="userid"]');

		app.helper.showProgress(app.vtranslate('JS_PLEASE_WAIT'));
		
		var params = {
			module: app.getModuleName(),
			action: 'SaveAjax',
			mode: 'changeUsername',
			newUsername: newUsername.val(),
			newPassword: new_password.val(),
			confirmPassword: confirm_password.val(),
			userid: userid.val()
		};
		vtUtils.hideValidationMessage(newUsername);
		
		app.request.post({'data' : params}).then(function (err, data) {
			app.helper.hideProgress();
			
			if(err === null) {
				app.helper.showSuccessNotification({'message' : app.vtranslate(data)});
				app.helper.hideModal();
				location.reload();
			}else {
				var params = {
					position: {
						my: 'bottom left',
						at: 'top left',
						container : form
					},
				};
				vtUtils.showValidationMessage(newUsername, app.vtranslate(err.message), params);
				return false;
			}
		});
	},
	
},{
	registerAjaxPreSaveEvent: function () {
		var self = this;
		app.event.on(Vtiger_Detail_Js.PreAjaxSaveEvent, function (e, params) {
			self.validateDigitSeparators(e, params);
		});
	},
	validateDigitSeparators: function (e, params) {
		var fieldNamesToValidate = ['currency_decimal_separator', 'currency_grouping_separator'];
		var fieldInfo = params.triggeredFieldInfo;

		if (jQuery.inArray(fieldInfo.field, fieldNamesToValidate) === -1) {
			return true;
		}
		var sourceField = fieldInfo.field;
		var targetField = '';
		if (sourceField === 'currency_decimal_separator') {
			targetField = 'currency_grouping_separator';
		} else if (sourceField === 'currency_grouping_separator') {
			targetField = 'currency_decimal_separator';
		}

		var form = params.form;
		var sourceFieldValue = fieldInfo.value;
		var targetFieldValue = form.find('input[data-name="' + targetField + '"]').data('value');
		//for decoding space(&nbsp) and single quote as they are coming as encoded values
		sourceFieldValue = jQuery('<div/>').html(sourceFieldValue).text();
		targetFieldValue = jQuery('<div/>').html(targetFieldValue).text();
		if (targetFieldValue.length > 0 && (sourceFieldValue === targetFieldValue)) {
			app.helper.showErrorNotification({message: app.vtranslate('JS_DECIMAL_SEPARATOR_AND_GROUPING_SEPARATOR_CANT_BE_SAME')});
			e.preventDefault();
		}
	},
	
	//Added By jitu@secondcrm.com on 29-10-2014
	registerDisplayDetailTabClickEvent : function(form) { 
		var userid = jQuery('#recordId').val();
		jQuery('li.relatedListTab').on('click',function(e) {
			var tabIndx = $(this).index();
			var container = $('a', this).attr('href');
			    container = container.replace('#','');
               if(container=='preference'){
                    window.location.href="?module=Users&view=PreferenceDetail&parent=Settings&record="+userid
     		}

			if(tabIndx !=0 && container !='') {
			     var params = {
					     'data' : {
						     'module': app.getModuleName(),
						     'view' : "ListViewAjax",
						     'record' : userid,
						     'mode' : 'getUser'+container.substr(0, 1).toUpperCase() + container.substr(1),
						}
				    };
				
				app.helper.showProgress(app.vtranslate('JS_PLEASE_WAIT'));
				app.request.post(params).then(function (err, data) { 
				if (err === null) {
     				app.helper.hideProgress();
     				//app.helper.showSuccessNotification({'message': data.message});
					jQuery('.tab-pane').hide();
					jQuery('#'+container).show();
					jQuery('#'+container).html(data);
				} else {
					
					//app.helper.showErrorNotification({'message': err.message});
				}
			});
				
			} 
		});
	}, 
	/**
	 * Function to register Quick Create Event
	 * @returns {undefined}
	 */
	registerQuickCreateEvent : function (){
		var thisInstance = this;
		jQuery(".quickCreateModule").on("click",function(e){
			/*var quickCreateElem = jQuery(e.currentTarget);
			var quickCreateUrl = quickCreateElem.data('url');
			var quickCreateModuleName = quickCreateElem.data('name');
			if (typeof params === 'undefined') {
				params = {};
			}
			if (typeof params.callbackFunction === 'undefined') {
				params.callbackFunction = function(data, err) {
					//fix for Refresh list view after Quick create
					var parentModule=app.getModuleName();
					var viewname=app.view();
					if((quickCreateModuleName == parentModule) && (viewname=="List")){
							var listinstance = app.controller();
							listinstance.loadListViewRecords(); 
					}
				};
			}
			app.helper.showProgress();
			thisInstance.getQuickCreateForm(quickCreateUrl,quickCreateModuleName,params).then(function(data){
				app.helper.hideProgress();
				var callbackparams = {
					'cb' : function (container){
						thisInstance.registerPostReferenceEvent(container);
						app.event.trigger('post.QuickCreateForm.show',form);
						app.helper.registerLeavePageWithoutSubmit(form);
						app.helper.registerModalDismissWithoutSubmit(form);
					},
					backdrop : 'static',
					keyboard : false
					}

				app.helper.showModal(data, callbackparams);
				var form = jQuery('form[name="QuickCreate"]');
				var moduleName = form.find('[name="module"]').val();
				app.helper.showVerticalScroll(jQuery('form[name="QuickCreate"] .modal-body'), {'autoHideScrollbar': true});

				var targetInstance = thisInstance;
				var moduleInstance = Vtiger_Edit_Js.getInstanceByModuleName(moduleName);
				if(typeof(moduleInstance.quickCreateSave) === 'function'){
					targetInstance = moduleInstance;
					targetInstance.registerBasicEvents(form);
				}

				vtUtils.applyFieldElementsView(form);
				targetInstance.quickCreateSave(form,params);
			});*/
		});
	},

	registerEvents: function () {
		this._super();
		var form = this.getForm();
		this.registerAjaxPreSaveEvent();
		this.registerDisplayDetailTabClickEvent(form);	//added by jitu@secondcrm.com
		this.registerQuickCreateEvent();
	}
});

// Actually, Users Module is in Settings. Controller in application.js will check for Settings_Users_Detail_Js 
Users_Detail_Js("Settings_Users_Detail_Js");

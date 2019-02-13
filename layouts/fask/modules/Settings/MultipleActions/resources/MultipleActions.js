/*+**************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 ******************************************************************************************************************/
jQuery.Class('Settings_MultipleActions_Js', {
	//holds the currency instance
	MultipleActionsInstance : false,
	saveRestrictActions : function(form) {
		var aDeferred = jQuery.Deferred();

		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		var data = form.serializeFormData();
		data['module'] = app.getModuleName();//which is PDFSetting
		data['parent'] = app.getParentModuleName();//which is Settings
		data['action'] = 'Save';
	
		AppConnector.request(data).then(
			function(data) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.resolve(data);
			},
			function(error) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				//TODO : Handle error
				aDeferred.reject(error);
			}
		);
		return aDeferred.promise();
	},

	registerSetRestrictFormValues : function() {
		
	},
	
	registerEvents : function() {
		//this._super();
		var thisInstance = this;
		thisInstance.registerSetRestrictFormValues();
		var form = jQuery('#MultipleActionsForm');
			form.submit(function(e) {
					e.preventDefault();
				 thisInstance.saveRestrictActions(form).then(
					function(data) {
						var result = data['result'];
						if(result['success']) {
							var params = {
								text: app.vtranslate('Restrict Actions Saved !!'),
								animation: 'show',
								type: 'success'
							}
							Settings_Vtiger_Index_Js.showMessage(params);
						}
					},
					function(error){
						//TODO: Handle Error
					}
				);	
			});
		}	
});
jQuery(document).ready(function(){ 
	var MultipleActionsInstance = new Settings_MultipleActions_Js();
    MultipleActionsInstance.registerEvents();
})

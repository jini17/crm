/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created by Nirbhay on 17-04-2018
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_GoogleConfig_Js",{},{
	
	/*
	 * Function to save the Configuration Editor content
	 */
	saveConfigEditor : function(form) {
		var aDeferred = jQuery.Deferred();
		
		var data = form.serializeFormData();
		var updatedFields = {};
		jQuery.each(data, function(key, value) {
			updatedFields[key] = value;
		})
		
		var params = {
			'module' : app.getModuleName(),
			'parent' : app.getParentModuleName(),
			'action' : 'GoogleConfigSaveAjax',
			'updatedFields' : JSON.stringify(updatedFields)
		}
		AppConnector.request(params).then(
			function(data) {
				aDeferred.resolve(data);
			},
			function(error,err){
				aDeferred.reject();
			}
		);
		return aDeferred.promise();
	},
	
	/*
	 * Function to load the contents from the url through pjax
	 */
	loadContents : function(url) {
		var aDeferred = jQuery.Deferred();
		AppConnector.requestPjax(url).then(
			function(data){
				aDeferred.resolve(data);
			},
			function(error, err){
				aDeferred.reject();
			}
		);
		return aDeferred.promise();
	},	


	registerEditViewEvents: function () {
		var thisInstance = this;
		var form = jQuery('#GoogleConfigForm');
		var detailUrl = form.data('detailUrl');
		//register validation 
		var params = {
			submitHandler: function (form) {
				var form = jQuery(form);
				thisInstance.saveConfigEditor(form).then(
					function (data) {
						if (data) {
							var message = app.vtranslate('JS_GOOGLE_DETAILS_SAVED');
							thisInstance.loadContents(detailUrl).then(
								function (data) {
									jQuery('#body').html(data);	
									thisInstance.registerDetailViewEvents();
								}
							);
						}
						app.helper.showSuccessNotification({'message': message});
					});
			}
		};
		form.vtValidate(params);
		form.on('submit', function (e) {
			e.preventDefault();
			return false;
		});

		//Register click event for cancel link
		var cancelLink = form.find('.cancelLink');
		cancelLink.click(function() {
			app.helper.showProgress();	
			thisInstance.loadContents(detailUrl).then(
				function(data) {
					app.helper.hideProgress();
					jQuery('#body').html(data);			
					thisInstance.registerDetailViewEvents();
				}
			);
		})
		vtUtils.enableTooltips();
	},	

	registerEditViewEvents2: function () {
		var thisInstance = this;
		var form = jQuery('#AdvanceGoogleConfigForm');
		var detailUrl = form.data('detailUrl');
		//register validation 
		var params = {
			submitHandler: function (form) {
				var form = jQuery(form);
				thisInstance.saveConfigEditor(form).then(
					function (data) {
						if (data) {
							var message = app.vtranslate('JS_GOOGLE_DETAILS_SAVED');
							thisInstance.loadContents(detailUrl).then(
								function (data) {
									jQuery('#body').html(data);	
									thisInstance.registerDetailViewEvents();
								}
							);
						}
						app.helper.showSuccessNotification({'message': message});
					});
			}
		};
		form.vtValidate(params);
		form.on('submit', function (e) {
			e.preventDefault();
			return false;
		});

		//Register click event for cancel link
		var cancelLink = form.find('.cancelLink');
		cancelLink.click(function() { 
			app.helper.showProgress();	
			thisInstance.loadContents(detailUrl).then(
				function(data) {
					app.helper.hideProgress();
					jQuery('#body').html(data);			
					thisInstance.registerDetailViewEvents();
					// thisInstance.loadNewEmailpage();
				}
			);
		})
		vtUtils.enableTooltips();
	},	

	
	/*
	 * function to register the events in DetailView
	 */
	registerDetailViewEvents : function() {
		var thisInstance = this;
		var container = jQuery('#GoogleConfigDetails');
		var container2 = jQuery('#AdvanceGoogleConfigDetails');
		var editButton = container.find('.editButton');	
		var editButton2 = container2.find('.editButton');	
		jQuery(".group4").colorbox({rel:'group4'});		
			
		
		//Register click event for edit button
		editButton.click(function() {
			var url = editButton.data('url');
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});
			thisInstance.loadContents(url).then(
				function(data) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
					jQuery('#contents').html(data);
					thisInstance.registerEditViewEvents();
				}, function(error, err) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
				}
			);
		});

		//Register click event for edit button
		editButton2.click(function() {
			var url = editButton2.data('url');
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});
			thisInstance.loadContents(url).then(
				function(data) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
					jQuery('#contents2').html(data);
					thisInstance.registerEditViewEvents2();
				}, function(error, err) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
				}
			);
		});
	},
		
	
	registerEvents: function() { 
		if(jQuery('#GoogleConfigDetails').length > 0) {
			this.registerDetailViewEvents();
		} else {
			this.registerEditViewEvents();
		}
	}

});

jQuery(document).ready(function(e){ 
	var tacInstance = new Settings_Vtiger_GoogleConfig_Js();
    var vtigerinst = new Vtiger_Index_Js();
    vtigerinst.registerEvents();
	tacInstance.registerEvents();
})

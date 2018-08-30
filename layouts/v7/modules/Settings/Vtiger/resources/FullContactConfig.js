/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created by DANIAL FAJAR
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_FullContactConfig_Js",{},{
	
	/*
	 * Function to save the Configuration Editor content
	 */
	saveConfigEditor : function(form, configtype="") {
		var aDeferred = jQuery.Deferred();		
		var data = form.serializeFormData(); 
		var updatedFields = {};
		var accesskey = "";

		jQuery.each(data, function(key, value) {
			if (key == "accesskey")
				accesskey = value;
			updatedFields[key] = value;
		})

			var params = {
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : 'FullContactConfigSaveAjax',
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

	/*
	 * Function to load the events for Edit View
	 */
	registerEditViewEvents : function () {
	
		var thisInstance = this;
		var form = jQuery('#FullContactConfigForm');
		var detailUrl = form.data('detailUrl');		
		//register validation 
		var params = {
			submitHandler: function (form) {
				var form = jQuery(form);
				thisInstance.saveConfigEditor(form).then(
					function (data) {
						if (data) {
							var message = app.vtranslate('FUCKING HELL YEAH ITS SAVED !');
							
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

		//When page is refreshed/reloaded, it will redirect to the Index View
		history.pushState({}, null, 'index.php?module=Vtiger&parent=Settings&view=FullContactConfigIndex&block=12&fieldid=40');
	},	


	
	/*
	 * function to register the events in DetailView
	 */
	registerDetailViewEvents : function() {

		var thisInstance = this;
		var container = jQuery('#FullContactConfigDetails');
		//var advanceConfigContainer = jQuery('#AdvanceFullContactConfigDetails');
		var editButton = container.find('editButton');	

		//var advanceConfigEditButton = advanceConfigContainer.find('.editButton');	
		jQuery(".group4").colorbox({rel:'group4'});
		//jQuery(".group5").colorbox({rel:'group5'});


		jQuery('#editButton').click(function(){
		var url = jQuery('#editButton').data('url');

			console.log(url);
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
		
	},		
	
	registerEvents: function() { 
		if(jQuery('#FullContactConfigDetails').length > 0) {
			this.registerDetailViewEvents();
		} else {

			this.registerEditViewEvents();
		}
	}

});

jQuery(document).ready(function(e){ 

	var tacInstance = new Settings_Vtiger_FullContactConfig_Js();
    	var vtigerinst = new Vtiger_Index_Js();
    	vtigerinst.registerEvents();
	tacInstance.registerEvents();
        //Added By Mabruk
	var vtigerSettings = new Settings_Vtiger_Index_Js();
	vtigerSettings.registerAccordionClickEvent();
})

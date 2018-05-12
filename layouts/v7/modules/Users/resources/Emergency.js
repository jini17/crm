/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Emergency_Js",{},{
		
	editEmergency : function(url, currentTrElement) {
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		
		AppConnector.request(url).then(
			function(data) {
				var callBackFunction = function(data) {
					//cache should be empty when modal opened 
					thisInstance.duplicateCheckCache = {};
					var form = jQuery('#editEmergency');
					
					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
							var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
							var aparams = form.serializeFormData();
							aparams.module = app.getModuleName();
							aparams.action = 'SaveSubModuleAjax';
							aparams.mode = 'saveEmergencyContact';
							aparams.isview = chkboxval;	
							AppConnector.request(aparams).then(

							function(data) { 
							//show notification after Contact details saved
								params = {
									text: data['result'],
									type:'success'	
								};
								Vtiger_Helper_Js.showPnotify(params);
								progressIndicatorElement.progressIndicator({'mode':'hide'});
								app.hideModalWindow();	
								//Update the Contact details in the list
								thisInstance.updateDetailViewContact(userid);
							}
						);
					}
				}           
			});
			
			form.submit(function(e) {
				e.preventDefault();
			})
		}
		progressIndicatorElement.progressIndicator({'mode':'hide'});
		app.showModalWindow(data,function(data){
			if(typeof callBackFunction == 'function'){
				callBackFunction(data);
			}
		}, {'width':'500px'});
	},
		function(error) {
		//TODO : Handle error
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
},
	
updateDetailViewContact : function(userid) { 
		var params = {
			'module' : app.getModuleName(),
			'view'   : 'ListViewAjax',
			'record' : userid,		
			'mode'   : 'getUserEmergency',
		}
		AppConnector.request(params).then(
		function(data) {
			$('#emergency').html(data);
		},
	
		function(error,err){
			aDeferred.reject();
		}
	);
},

/*
 * Function to register all actions in the project List
 */
registerActions : function() {
	var thisInstance = this;
	var container = jQuery('#UserEmergencyContainer');

		
	//register event for edit Emergency icon
	container.on('click', '.editEmergency', function(e) { 
		var editEmergencyButton = jQuery(e.currentTarget);
		var currentTrElement = editEmergencyButton.closest('tr');
		thisInstance.editEmergency(editEmergencyButton.data('url'), currentTrElement);
	});
},

registerEvents: function() {
	this.registerActions();
	}
});

jQuery(document).ready(function(e){ 
	var emergencyinstance = new Users_Emergency_Js();
	emergencyinstance.registerEvents();
})

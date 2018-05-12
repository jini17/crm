/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Project_Js",{},{
		
	editProject : function(url, currentTrElement) {
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
					thisInstance.textAreaLimitChar();
					var form = jQuery('#editProject');
					
					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
							var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
							var aparams = form.serializeFormData();
							aparams.module = app.getModuleName();
							aparams.action = 'SaveSubModuleAjax';
							aparams.mode = 'saveProject';
							aparams.isview = chkboxval;	
							AppConnector.request(aparams).then(

							function(data) { 
							//show notification after Project details saved
								params = {
									text: data['result'],
									type:'success'	
								};
							Vtiger_Helper_Js.showPnotify(params);
							progressIndicatorElement.progressIndicator({'mode':'hide'});
							app.hideModalWindow();
							//Adding or update the Project details in the list
							thisInstance.updateProjectGrid(userid);
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
	
updateProjectGrid : function(userid) { 
		var params = {
			'module' : app.getModuleName(),
			'view'   : 'ListViewAjax',
			'record' : userid,		
			'mode'   : 'getUserProject',
		}
		AppConnector.request(params).then(
		function(data) {
			$('#project').html(data);
		},
	
		function(error,err){
			aDeferred.reject();
		}
	);
},

deleteProject : function(deleteRecordActionUrl) { 
		var message = app.vtranslate('JS_DELETE_PROJECT_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(function(data) {
		AppConnector.request(deleteRecordActionUrl).then(
		function(data){
				var response = data['result'];
				var result   = data['success'];
				if(result == true) {
					params = {
						text: response.msg,
						type:'success'	
					};
				} else {
						params = {
						text: response.msg,
						type:'error'	
					};
				}
				
				Vtiger_Helper_Js.showPnotify(params);
				//delete the Project details in the list
				thisInstance.updateProjectGrid(userid);
			}
		);
	});
},	

textAreaLimitChar : function(){ 
			$('#description').keyup(function () {
				var maxchar = 300;
				var len = $(this).val().length;
			 	if (len > maxchar) {
			    		$('#charNum').text(' you have reached the limit');
					$(this).val($(this).val().substring(0, len-1));
			  	} else {
			    		var remainchar = maxchar - len;
			    		$('#charNum').text(remainchar + ' character(s) left');
					
			  	}
			});
	},




/*
 * Function to register all actions in the project List
 */
registerActions : function() {
	var thisInstance = this;
	var container = jQuery('#UserProjectContainer');
	//register click event for Add New project button
	container.find('.addProject').click(function(e) {
		var addProjectButton = jQuery(e.currentTarget);
		var createProjectUrl = addProjectButton.data('url');
		thisInstance.editProject(createProjectUrl);
	});
		
	//register event for edit project icon
	container.on('click', '.editProject', function(e) {
		var editProjectButton = jQuery(e.currentTarget);
		var currentTrElement = editProjectButton.closest('tr');
		thisInstance.editProject(editProjectButton.data('url'), currentTrElement);
	});
	
	//register event for delete project icon
	container.on('click', '.deleteProject', function(e) { ;
		var deleteProjectButton = jQuery(e.currentTarget);
		var currentTrElement = deleteProjectButton.closest('tr');
		thisInstance.deleteProject(deleteProjectButton.data('url'), currentTrElement);
	});	
},

registerEvents: function() {
	this.registerActions();
	}
});

jQuery(document).ready(function(e){ 
	var projectinstance = new Users_Project_Js();
	projectinstance.registerEvents();
})

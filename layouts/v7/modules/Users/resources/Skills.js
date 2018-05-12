/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

jQuery.Class("Users_Skills_Js",{},{
		
	editLanguage : function(url, currentTrElement) {

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
					var form = jQuery('#editLanguage');

					$("#language").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"language","languagebox"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
					});


					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
								//	var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
									var aparams = form.serializeFormData();
									aparams.module = app.getModuleName();
									aparams.action = 'SaveSubModuleAjax';
									aparams.mode = 'saveLanguage';
								//	aparams.isview = chkboxval;	
									AppConnector.request(aparams).then(
										function(data) {
											//show notification after Education details saved
											params = {
													text: data['result'],
													type: 'success'
											};	
											Vtiger_Helper_Js.showPnotify(params);
											progressIndicatorElement.progressIndicator({'mode':'hide'});
											app.hideModalWindow();
										
											//Adding or update the Education details in the list
											thisInstance.updateLanguageGrid(userid);
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

	updateLanguageGrid : function(userid) { 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserSkills',
					'section':'L',
				}
				AppConnector.request(params).then(
					function(data) { 
						$('#skills').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},	
	
	deleteLanguage : function(deleteRecordActionUrl) {
		var message = app.vtranslate('JS_DELETE_LANG_CONFIRMATION');
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
				//delete the Language details in the list
				thisInstance.updateLanguageGrid(userid);
				}
			);
		});
	},
	
	addSkills : function(url, currentTrElement) {

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
					var form = jQuery('#addSkill');

					$("#skill").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"skill","skillbox"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
					});

					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
								
									var aparams = form.serializeFormData();
									aparams.module = app.getModuleName();
									aparams.action = 'SaveSubModuleAjax';
									aparams.mode = 'saveSkill';
									AppConnector.request(aparams).then(
										function(data) {
											//show notification after Education details saved
											params = {
													text: data['result'],
													type: 'success'
											};	
											Vtiger_Helper_Js.showPnotify(params);
											progressIndicatorElement.progressIndicator({'mode':'hide'});
											app.hideModalWindow();
											//Adding or update the Skills details in the list
											thisInstance.updateSkillCloud(userid);
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

	deleteSkill : function(deleteRecordActionUrl) {
		var message = app.vtranslate('JS_DELETE_SKILL_CONFIRMATION');
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
				//delete the Skill details in the Cloud
				 thisInstance.updateSkillCloud(userid);
				}
			);
		});
	},
	updateSkillCloud : function(userid) { 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserSkills',
					'section':'S',
				}
				AppConnector.request(params).then(
					function(data) { 
						$('#skills').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},
	/*
	 * Function to register all actions in the Tax List
	 */
	registerActions : function() { 
		var thisInstance = this;
		var langcontainer = jQuery('#LanguageContainer');
		var skillcontainer = jQuery('#SkillContainer');
		
		//register click event for Add New language button
		langcontainer.find('.addLanguage').click(function(e) { 
			var addLangButton = jQuery(e.currentTarget);
			var createLangUrl = addLangButton.data('url');
			thisInstance.editLanguage(createLangUrl);
		});		

		//register event for edit language icon
		langcontainer.on('click', '.editLanguage', function(e) { 
			var editLangButton = jQuery(e.currentTarget);
			var currentTrElement = editLangButton.closest('tr');
			thisInstance.editLanguage(editLangButton.data('url'), currentTrElement);
		});

		//register event for delete language icon
		langcontainer.on('click', '.deleteLanguage', function(e) { 
		var deleteLangButton = jQuery(e.currentTarget);
		var currentTrElement = deleteLangButton.closest('tr');
		thisInstance.deleteLanguage(deleteLangButton.data('url'), currentTrElement);
		});	

		//register click event for Add New Skill button
		skillcontainer.find('.addSkill').click(function(e) {
			var addSkillsButton = jQuery(e.currentTarget);
			var createSkillUrl = addSkillsButton.data('url');
			thisInstance.addSkills(createSkillUrl);
		});
		
		//register event for edit Skill icon
		skillcontainer.on('click', '.deleteSkill', function(e) {
			var deleteSkillButton = jQuery(e.currentTarget);
			var currentTrElement = deleteSkillButton.closest('tr');
			thisInstance.deleteSkill(deleteSkillButton.data('url'), currentTrElement);
		});
	},
	
	registerEvents: function() {
		this.registerActions();
	}

});

jQuery(document).ready(function(e){ 
	var skillinstance = new Users_Skills_Js();
	skillinstance.registerEvents();
})

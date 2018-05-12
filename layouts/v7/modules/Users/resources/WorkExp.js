/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

jQuery.Class("Users_WorkExp_Js",{},{
	editWorkExp : function(url, currentTrElement) {
		$("#errordate").html('');	
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
					var form = jQuery('#editWorkExp');
					$("#company_title").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"company_title","comtxt"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
						});
					$("#designation").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"designation","desigtxt"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
						});
					$("#location").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"location","loctxt"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
						});

					thisInstance.textAreaLimitChar();		// for textarea limit
					var currentworkcheck =  form.find('.currentworking');
					currentworkcheck.on('change',function(e){ 
						var elem = jQuery(e.currentTarget);
						if(elem.is(':checked')) {
							jQuery('#enddate_div').addClass('hide');
						}else{
							jQuery('#enddate_div').removeClass('hide').show();
						}
					});
					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
									var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
									var chkboxworking = $('#chkcurrently').is(':checked')?'1':'0';
									var aparams = form.serializeFormData();
									aparams.module = app.getModuleName();
									aparams.action = 'SaveSubModuleAjax';
									aparams.mode = 'saveWorkExp';
									aparams.isview = chkboxval;
									aparams.isworking = chkboxworking;	
									AppConnector.request(aparams).then(
										function(data) { 
											//show notification after WorkExp details saved
											params = {
													text: data['result'],
													type: 'success'
											};	
											Vtiger_Helper_Js.showPnotify(params);
											progressIndicatorElement.progressIndicator({'mode':'hide'});
											app.hideModalWindow();
										
											//Adding or update the WorkExp details in the list
											thisInstance.updateWorkExpGrid(userid);
												
											
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
	
	updateWorkExpGrid : function(userid) { 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserWorkexp',
				}
				AppConnector.request(params).then(
					function(data) {
						$('#workexp').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},

	deleteWorkExp : function(deleteRecordActionUrl) { 
		var message = app.vtranslate('JS_DELETE_WORKEXP_CONFIRMATION');
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
				//delete the Education details in the list
				thisInstance.updateWorkExpGrid(userid);
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
	 * Function to register all actions in the WorkExp List
	 */
	registerActions : function() {
		
		var thisInstance = this;
		
		var container = jQuery('#UserWorkExpContainer');
		
		//register click event for Add New WorkExp button
		container.find('.addWorkExp').click(function(e) {
			var addWorkExpButton = jQuery(e.currentTarget);
			var createWorkExpUrl = addWorkExpButton.data('url');
			thisInstance.editWorkExp(createWorkExpUrl);
			
			
		});
		
		//register event for edit WorkExp icon
		container.on('click', '.editWorkExp', function(e) {
			var editWorkExpButton = jQuery(e.currentTarget);
			var currentTrElement = editWorkExpButton.closest('tr');
			thisInstance.editWorkExp(editWorkExpButton.data('url'), currentTrElement);
			
		});

		//register event for delete WorkExp icon
		container.on('click', '.deleteWorkExp', function(e) {
		var deleteWorkExpButton = jQuery(e.currentTarget);
		var currentTrElement = deleteWorkExpButton.closest('tr');
		thisInstance.deleteWorkExp(deleteWorkExpButton.data('url'), currentTrElement);
		});	
	},
	
	registerEvents: function() {
		this.registerActions();
	}

});

jQuery(document).ready(function(e){ 
	var uwinstance = new Users_WorkExp_Js();
	uwinstance.registerEvents();
})

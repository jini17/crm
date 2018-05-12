/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Education_Js",{},{

	//Stored history of TaxName and duplicate check result
	duplicateCheckCache : {},
		
	editEducation : function(url, currentTrElement) { 
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		app.helper.showProgress();
		app.request.post({url:url}).then(
			function(err,data) { 
                app.helper.hideProgress();
                if(err == null){
                	var callBackFunction = function(data) { alert('Jitu');
                        //cache should be empty when modal opened 
                       /* thisInstance.duplicateCheckCache = {};

                        var form = jQuery('#editEducation');

                        thisInstance.textAreaLimitChar();		// for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});
                        $("#institution_name").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"institution_name","institution_nametxt"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
						});

					$("#areaofstudy").select2({formatNoMatches: function() {
						var concatselboxNtxtbox = '"areaofstudy","areaofstudytxt"';
						return "<span>"+app.vtranslate('JS_NO_MATCH_FOUND')+"<a href='#' onclick=updateBox(" +concatselboxNtxtbox+ ")>"+app.vtranslate('JS_ADD_NEW')+"</a></span>";} 
						});
					
					var currentstudycheck =  form.find('.currentstudying');
					currentstudycheck.on('change',function(e){ 
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
									var chkboxstudying = $('#chkstudying').is(':checked')?'1':'0';
									var aparams = form.serializeFormData();
									aparams.module = app.getModuleName();
									aparams.action = 'SaveSubModuleAjax';
									aparams.mode = 'saveEducation';
									aparams.isview = chkboxval;
									aparams.is_studying = chkboxstudying;		
									AppConnector.request(aparams).then(
										function(data) { 
											//show notification after Education details saved
											params = {
													text: data['result'],
													type: 'success'
											};	
											Vtiger_Helper_Js.showPnotify(params);
											app.helper.hideProgress();

											app.hideModalWindow();
										
											//Adding or update the Education details in the list
											thisInstance.updateEducationGrid(userid);
												
											
										}
									);
							}
						}           
					});

					var params = {
                            submitHandler : function(form){
                                var form = jQuery(form);
                                thisInstance.saveTaxDetails(form, currentTrElement);
                            }
                        }
                        form.vtValidate(params);
                        
                        form.submit(function(e) {
                            e.preventDefault();
                        })*/
                 }
                         app.helper.showModal(data,function(data){ alert('Raaa'+typeof callBackFunction);
					if(typeof callBackFunction == 'function'){
						callBackFunction(data);
							
						}
					}, {'width':'200px'});
                
			}
		});
		return aDeferred.promise();	
	},
	
	updateEducationGrid : function(userid) { 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserEducation',
				}
				AppConnector.request(params).then(
					function(data) {
						$('#education').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},	
	
	deleteEducation : function(deleteRecordActionUrl) { 
		var message = app.vtranslate('JS_DELETE_EDUCATION_CONFIRMATION');
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
				thisInstance.updateEducationGrid(userid);
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
	 * Function to register all actions in the Tax List
	 */
	registerActions : function() {
		var thisInstance = this;
		var container = jQuery('#UserEducationContainer');
		
		//register click event for Add New Education button
		container.find('.addEducation').click(function(e) {
			var addEducationButton = jQuery(e.currentTarget);
			var createEducationUrl = addEducationButton.data('url');
			thisInstance.editEducation(createEducationUrl);
		});
		
		//register event for edit Education icon
		container.on('click', '.editEducation', function(e) {
			var editEducationButton = jQuery(e.currentTarget);
			var currentTrElement = editEducationButton.closest('tr');
			thisInstance.editEducation(editEducationButton.data('url'), currentTrElement);
		});
		
		//register event for delete project icon
		container.on('click', '.deleteEducation', function(e) { ;
		var deleteEducationButton = jQuery(e.currentTarget);
		var currentTrElement = deleteEducationButton.closest('tr');
		thisInstance.deleteEducation(deleteEducationButton.data('url'), currentTrElement);
	});

	},

	
	registerEvents: function(eduinstance) {
		eduinstance.registerActions();
	}

});

jQuery(document).ready(function(e){ 
	var eduinstance = new Users_Education_Js();
	eduinstance.registerEvents(eduinstance);
})

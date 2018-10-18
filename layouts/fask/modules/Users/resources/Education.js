/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Education_Js", {

	//register click event for Add New Education button
	addEducation : function(url) { 
	     this.editEducation(url);
	    
	},
	
	textAreaLimitChar : function(){
			jQuery('#description').keyup(function () { 
				var maxchar = 300;
				var len = jQuery(this).val().length;
			 	if (len > maxchar) {
			    		jQuery('#charNum').text(' you have reached the limit');
					jQuery(this).val($(this).val().substring(0, len-1));
			  	} else {
			    		var remainchar = maxchar - len;
			    		jQuery('#charNum').text(remainchar + ' character(s) left');
					
			  	}
			});
	},
	editEducation : function(url) { 
	    var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		app.helper.showProgress();
		app.request.post({url:url}).then(
		function(err,data) { 
		      app.helper.hideProgress();
              
                if(err == null){
                    app.helper.showModal(data);
                    var form = jQuery('#editEducation');
                        thisInstance.textAreaLimitChar();	
                      
                        	// for textarea limit
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

                         form.submit(function(e) { 
                            e.preventDefault();
                         })
					var params = {
                            submitHandler : function(form){
                                var form = jQuery('#editEducation');   
                                thisInstance.saveEducationDetails(form);
                            }
                        };
                         form.vtValidate(params)
          		} else {
                        aDeferred.reject(err);
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
				app.request.post({'data':params}).then(
					function(err, data) {
						jQuery('#education').html(data);
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
		app.helper.showConfirmationBox({'message' : message}).then(function(e) {
		
          	app.request.post({url:deleteRecordActionUrl}).then(
          	     function(data){
				      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
				     //delete the Education details in the list
				     thisInstance.updateEducationGrid(userid);
			     }
		     );
	     });
     },

     saveEducationDetails : function(form){
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var chkboxval = $('#chkviewable:checked').val();

          var chkboxstudying = chkboxval;//$('#chkstudying').is(':checked')?'1':'0';
          var formData = form.serializeFormData();
          var params = {
				'module': 'Users',
				'action': "SaveSubModuleAjax",
				'mode'  : 'saveEducation',
				'form' : formData,
				'isview' : chkboxval,
				'is_studying':chkboxstudying
			};	
				
         app.request.post({'data': params}).then(function (err, data) {     
              app.helper.hideProgress();
               //show notification after Education details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the Education details in the list
               thisInstance.updateEducationGrid(userid);
             }
          );
           return aDeferred.promise();
     },	
	
},{
	//constructor
	init : function() {
		Users_Education_Js.eduInstance = this;
	},
	

	
	registerEvents: function(eduinstance) {
		eduinstance.registerActions();
	}

});

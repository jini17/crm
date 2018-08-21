/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Skills_Js", {

	//register click event for Add New Education button
	addLanguage : function(url) { 
	     this.editLanguage(url);
	    
	},
	addSkill : function(url) { 
	     this.editSkill(url);
	    
	},
	
	editLanguage : function(url) { 
	    var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		app.helper.showProgress();
		app.request.post({url:url}).then(
		function(err,data) { 
		      app.helper.hideProgress();
              
                if(err == null){
                    app.helper.showModal(data);
                    var form = jQuery('#editLanguage');
                      
                        	// for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});
                    

                         form.submit(function(e) { 
                            e.preventDefault();
                         })
					var params = {
                            submitHandler : function(form){
                                var form = jQuery('#editLanguage');   
                                thisInstance.saveLanguageDetails(form);
                            }
                        };
                         form.vtValidate(params)
          		} else {
                        aDeferred.reject(err);
                    }
	     	});
	     return aDeferred.promise();	
	},
     updateLanguageGrid : function(userid) { 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserLanguage',
					'section':'L',
				}
				app.request.post({'data':params}).then(
					function(err, data) {
						jQuery('#skills').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},
	
	deleteLanguage : function(record) { 
		var message = app.vtranslate('JS_DELETE_LANG_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		app.helper.showConfirmationBox({'message' : message}).then(function(e) {
		var params = {
					'module':'Users',
					'action': 'DeleteSubModuleAjax',
					'record':record,
					'mode':'deleteLanguage'
		};
          	app.request.post({data:params}).then(
          	     function(err, data){  
				      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
				     //delete the Education details in the list
				      thisInstance.updateSkillCloud(userid);
			     }
		     );
	     });
     },

     saveLanguageDetails : function(form){
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
          var formData = form.serializeFormData();
          console.log(formData);
          var params = {
				'module': 'Users',
				'action': "SaveSubModuleAjax",
				'mode'  : 'saveLanguage',
				'form' : formData,
			
				//'isview' : chkboxval,
				//'is_studying':chkboxstudying
			};	
				
         app.request.post({'data': params}).then(function (err, data) {  //alert(data);   
              app.helper.hideProgress();
               //show notification after Education details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the Education details in the list

               thisInstance.updateSkillCloud(userid);
             }
          );
           return aDeferred.promise();
     },	
     

editSkill : function(url) { 

		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		
		app.helper.showProgress();
		app.request.post({url:url}).then(
		function(err,data) { 
		      app.helper.hideProgress();
              
                if(err == null){
                    app.helper.showModal(data);
                    var form = jQuery('#addSkill');   
                        
                        	// for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});
                    
	

                         form.submit(function(e) { 
                            e.preventDefault();
                         })
					var params = {
                            submitHandler : function(form){
                                var form = jQuery('#addSkill');   
                                thisInstance.saveSkillDetails(form);
                            }
                        };
                         form.vtValidate(params)
          		} else {
                        aDeferred.reject(err);
                    }
	     	});
	     return aDeferred.promise();	
	},

	     saveSkillDetails : function(form){ 
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var formData = form.serializeFormData();
          console.log(formData);
          var params = {
				'module': 'Users',
				'action': "SaveSubModuleAjax",
				'mode'  : 'saveSkill',
				'form' : formData,
				
			};	
				
         app.request.post({'data': params}).then(function (err, data) {     
              app.helper.hideProgress();
               //show notification after Education details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the Education details in the list
                thisInstance.updateSkillCloud(userid);
             }
          );
           return aDeferred.promise();
     },	

	deleteSkill : function(record) {
		var message = app.vtranslate('JS_DELETE_LANG_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		app.helper.showConfirmationBox({'message' : message}).then(function(e) {
		
          	var params = {
					'module':'Users',
					'action': 'DeleteSubModuleAjax',
					'record':record,
					'mode':'deleteSkill'
		};
          	app.request.post({data:params}).then(
          	     function(err, data){  
				      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
				     //delete the Education details in the list
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

				app.request.post({data:params}).then(
          	     function(err, data){  
						$('#skills').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
			},



	
},{
	//constructor
	init : function() {
		Users_Skills_Js.skillInstance = this;
	},
	

	
	registerEvents: function(skillinstance) {
		skillinstance.registerActions();
	}

});

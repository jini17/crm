/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Project_Js", {

        //register click event for Add New Education button
        addProject : function(url) { 
             this.editProject(url);

        },	
        editProject : function(url, currentTrElement) { 
         var aDeferred = jQuery.Deferred();
                var thisInstance = this;
                var userid = jQuery('#recordId').val();

                app.helper.showProgress();
                app.request.post({url:url}).then(
                function(err,data) { 
                  if(err == null){
                   app.helper.hideProgress();
                   app.helper.showModal(data);
                        var form = jQuery('#editProject');
                                 thisInstance.textAreaLimitChar();

                                   form.submit(function(e) { 
                            e.preventDefault();
                         })
                                        var params = {
                            submitHandler : function(form){
                                var form = jQuery('#editProject');   
                                thisInstance.saveProjectsDetails(form);
                            }
                        };
                         form.vtValidate(params)
                        } else {
                        aDeferred.reject(err);
                    }
                });
             return aDeferred.promise();	
        },

updateProjectGrid : function(userid) { 
                var params = {
                        'module' : app.getModuleName(),
                        'view'   : 'ListViewAjax',
                        'record' : userid,		
                        'mode'   : 'getUserProject',
                }
                app.request.post({'data':params}).then(
                function(err, data) {
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
                     app.helper.showConfirmationBox({'message' : message}).then(function(e) {

                app.request.post({url:deleteRecordActionUrl}).then(
                     function(data){
                                           app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
                                          //delete the Education details in the list
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

saveProjectsDetails : function(form){
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var chkboxval = $('input[name=chkviewable]:checked').val();
          var formData = form.serializeFormData();
          var params = {
                                'module': 'Users',
                                'action': "SaveSubModuleAjax",
                                'mode'  : 'saveProject',
                                'form' : formData,
                                'isview' : chkboxval
                        };	

               app.request.post({'data': params}).then(function (err, data) {     
                    app.helper.hideProgress();
                    //show notification after Education details saved
                    app.helper.showSuccessNotification({'message': data});
                    //Adding or update the Project details in the list
                    thisInstance.updateProjectGrid(userid);
             }
          );
           return aDeferred.promise();
     },		

},{
        //constructor
        init : function() {
                Users_Education_Js.eduInstance = this;
        },
});

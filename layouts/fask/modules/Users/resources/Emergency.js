/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Emergency_Js", {

        //register click event for Add New emergencycontact button
        addEmergency : function(url) { 
             this.editEmergency(url);

        },

        editEmergency : function(url) { 

            var aDeferred = jQuery.Deferred();
                var thisInstance = this;
                var userid = jQuery('#recordId').val();


                app.helper.showProgress();
                app.request.post({url:url}).then(
                function(err,data) { 
                      app.helper.hideProgress();

                if(err == null){
                    app.helper.showModal(data);
                    var form = jQuery('#editEmergency');
                                // for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});
                         form.submit(function(e) { 
                            e.preventDefault();
                         })

                        jQuery('#home_phone,#office_phone, #mobile').keyup(function(event){
                                  var $this = $(this);
                          var input = $this.val();
                          var input = input.replace(/[^0-9+()-]/g, '');


                           $this.val( function() {
                                return ( input === 0 ) ? "" : input.replace();
                           });
                        });
                           // console.log(form);
                                        var params = {
                            submitHandler : function(form){
                                var form = jQuery('#editEmergency');   
                                thisInstance.saveEmergencyDetails(form);
                            }
                        };
                         form.vtValidate(params)
                        } else {
                        aDeferred.reject(err);
                    }
                });
             return aDeferred.promise();	
        },
     updateEmergencyGrid : function(userid) { 
          var aDeferred = jQuery.Deferred();
                        var params = {
                                        'module' : app.getModuleName(),
                                        'view'   : 'ListViewAjax',
                                        'record' : userid,		
                                        'mode'   : 'getUserEmergency',
                                }
                                app.request.post({'data':params}).then(
                                        function(err, data) {
                                                jQuery('#UserEmergencyContainer').html(data);
                                        },

                                        function(error,err){
                                                aDeferred.reject();
                                        }
                                );
        },
        // Added by Khaled
deleteEmergerncyContact : function(deleteRecordActionUrl,userid) { 
            var message = app.vtranslate('JS_DELETE_CONTACT_CONFIRMATION');
            var thisInstance = this;       
            app.helper.showConfirmationBox({'message' : message}).then(function(e) {

            app.request.post({url:deleteRecordActionUrl}).then(
                 function(data){
                                  app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
                                 //delete the Education details in the list
                                 thisInstance.updateEmergencyGrid(userid);
                         }
                 );
         });
     },
    

     saveEmergencyDetails : function(form){
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
          //var chkboxstudying = $('#chkstudying').is(':checked')?'1':'0';
          var formData = form.serializeFormData();
          //console.log(formData);
          var params = {
                                'module': 'Users',
                                'action': "SaveSubModuleAjax",
                                'mode'  : 'saveEmergencyContact',
                                'form' : formData,
                                'isview' : chkboxval,

                        };
                        

         app.request.post({'data': params}).then(function (err, data) {     
              app.helper.hideProgress();
               //show notification after Education details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the Education details in the list
               thisInstance.updateEmergencyGrid(userid);
             }
          );
           return aDeferred.promise();
     },	


},{
        //constructor
        init : function() {

                Users_Emergency_Js.emeInstance = this;
        },



        registerEvents: function(emeInstance) {

                emeInstance.registerActions();
        }

});

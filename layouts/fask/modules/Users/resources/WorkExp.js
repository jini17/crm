/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Vtiger.Class("Users_WorkExp_Js", {


        addWorkExp : function(url){
             this.editWorkExp(url);
        },
        /**
         * Date Validation added by Khaled
         * @returns {undefined}
         */
dateVidation:function(){
        
            jQuery('#end_date').on('change',function(){                      
                        var startDate = jQuery('#start_date').val().replace(/-/g,'/');
                        var endDate = jQuery('#end_date').val().replace(/-/g,'/');
                   
                        if(endDate.length > 0 && startDate > endDate){
                                  app.helper.showSuccessNotification({'message': 'End Date must be greater than start date'});
                                  jQuery('#end_date').val('');
                            //return false;
                           // do your stuff here...
                        }
                });
        },
        editWorkExp : function(url) {
                $("#errordate").html('');	
                var aDeferred = jQuery.Deferred();
                var thisInstance = this;
                var userid = jQuery('#recordId').val();

                app.helper.showProgress();

                app.request.post({url:url}).then(
                function(err,data) { 
                      app.helper.hideProgress();
                       if(err == null){
                    app.helper.showModal(data);
                                var form = jQuery('#editWorkExp');
                                thisInstance.textAreaLimitChar();	
                                thisInstance.dateVidation();	
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

                           form.submit(function(e) { 
                            e.preventDefault();
                         })
                                        var params = {
                            submitHandler : function(form){
                                var form = jQuery('#editWorkExp');   
//                                var form = jQuery(form);
                                thisInstance.saveWorkExpDetails(form);
                            }
                        };
                         form.vtValidate(params)
                        } else {
                        aDeferred.reject(err);
                    }
                });
             return aDeferred.promise();
        },

        updateWorkExpGrid : function(userid) { 
                        var params = {
                                        'module' : app.getModuleName(),
                                        'view'   : 'ListViewAjax',
                                        'record' : userid,		
                                        'mode'   : 'getUserWorkexp',
                                }
                                app.request.post({'data':params}).then(
                                        function(err, data) {
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
                app.helper.showConfirmationBox({'message' : message}).then(function(e) {

                app.request.post({url:deleteRecordActionUrl}).then(
                     function(data){
                                      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
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
     saveWorkExpDetails : function(form){
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          app.helper.showProgress();
          var chkboxval = $('input[name=chkviewable]:checked').val();
          var chkcurrently = chkboxval;
          var formData = form.serializeFormData();
          var params = {
                                'module': 'Users',
                                'action': "SaveSubModuleAjax",
                                'mode'  : 'saveWorkExp',
                                'form' : formData,
                                'isview' : chkboxval,
                                'isworking':chkcurrently
                        };	

         app.request.post({'data': params}).then(function (err, data) {     
              app.helper.hideProgress();
               //show notification after WorkExp details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the WorkExp details in the list
               thisInstance.updateWorkExpGrid(userid);
             }
          );
           return aDeferred.promise();
     },		
},{
        //constructor
        init : function() {
                Users_WorkExp_Js.WEInstance = this;
        },
});

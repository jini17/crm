/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Leave_Js", {

        //register click event for Add New Education button
        addLeave : function(url) { 
             var thisInstance = this;
            
             //check the anyleaveType for login user 
                var params = {
                                                'module' 	: 'Users',
                                                'action' 	: 'SaveSubModuleAjax',
                                                'mode'   	: 'IsAnyLeaveTypeAssign',
                }

             app.request.post({'data': params}).then(function (err, data) {  
                    if(data.length >0){
                         app.helper.showErrorNotification({'message': app.vtranslate(data, 'Users')});
                         return false;
                    } else{
                          thisInstance.editLeave(url);
                    }
             }); 
        },

        //register click event for Add New Education button
        addClaim : function(url) { 
             var thisInstance = this;
                //check the anyclaimType for login user 
                var params = {
                                                'module' : 'Users',
                                                'action' 	: 'SaveSubModuleAjax',
                                                'mode'   	: 'IsAnyClaimTypeAssign',
                }

             app.request.post({'data': params}).then(function (err, data) {  
                    if(data.length >0){
                         app.helper.showErrorNotification({'message': app.vtranslate(data, 'Users')});
                         return false;
                    } else{
                          thisInstance.editClaim(url);
                    }
             }); 

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
        editLeave : function(url) { 
            var aDeferred = jQuery.Deferred();
                var thisInstance = this;
                var user_id = jQuery('#recordId').val();

                app.helper.showProgress();
                app.request.post({url:url}).then(
                        function(err,data) { 
                      app.helper.hideProgress();

                if(err == null){
                    app.helper.showModal(data);

                    var form = jQuery('#editLeave');
                        thisInstance.textAreaLimitChar();
                        
                     $('#start_date').change(function() { 
                               var selectedDate = $(this).val()
                                var expireDateArr = selectedDate.split("-");                               
                                var expireDate = new Date(expireDateArr[2]+"-"+expireDateArr[1]+"-"+ expireDateArr[0]);                               
                                var todayDate = new Date();                               
                                if(expireDate < todayDate){
                                    $(this).val("")
                                      app.helper.showErrorNotification({'message': "Start Date must be greater than today's date"});
                                    return false;
                                }
                            });
                            
                            $('#end_date').change(function() { 
                                var selectedDate = $(this).val()
                                var startDate = jQuery("#start_date").val()
                                
                                if(startDate.length == 0){
                                     $(this).val("")
                                      app.helper.showErrorNotification({'message': "Start Date is required"});
                                    return false;
                                }
//                                
                                var expireDateArr = selectedDate.split("-");
                                var startDate_Split = startDate.split("-");
                                var expireDate = new Date(expireDateArr[2]+"-"+expireDateArr[1]+"-"+ expireDateArr[0]);                   
                                var SDate = new Date(startDate_Split[2]+"-"+startDate_Split[1]+"-"+ startDate_Split[0]); 
                                var todayDate = new Date();
                         
                                if(expireDate < SDate){
                                           $(this).val("")
                                      app.helper.showErrorNotification({'message': "End Date must be greater than Start date"});
                                    return false;
                                }
                              

                            });


                                // for textarea limit
                                        $("#start_date").on("change", function(){ 
                                                if($("#hdnhalfday").val()==1) {
                                                        $("#end_date").val($("#start_date").val());
                                                        $('#starthalf').prop('checked',true);
                                                        $("#endhalfcheck").addClass('hide');
                                                        $("#endhalf").addClass('hide');

                                                } else {
                                                        $("#endhalfcheck").addClass('hide');
                                                        $("#endhalf").addClass('hide');
                                                        $('#endhalf').prop('checked',false);
                                                        $("#starthalf").prop('checked',false);
                                                        $("#starthalfcheck").addClass('hide');
                                                        $("#starthalf").addClass('hide');
                                                }
                                        });
                                        $("#end_date").on("change", function(){
                                                if($("#hdnhalfday").val()==1) {
                                                        if($("#end_date").val() != $("#start_date").val()) {
                                                                $("#endhalfcheck").removeClass('hide');
                                                                $("#endhalf").removeClass('hide');
                                                        } else {
                                                                $("#endhalfcheck").addClass('hide');
                                                                $("#endhalf").addClass('hide');
                                                        }
                                                } else {
                                                        $("#endhalfcheck").addClass('hide');
                                                        $("#endhalf").addClass('hide');
                                                        $('#endhalf').prop('checked',false);
                                                        $("#starthalf").prop('checked',false);
                                                        $("#starthalfcheck").addClass('hide');
                                                        $("#starthalf").addClass('hide');
                                                }	
                                        });

                                        $("#starthalf").on("click", function(){	
                                                if($("#start_date").val() == $("#end_date").val()) {
                                                //	$('#starthalf').prop('checked',true);
                                                        $('#endhalf').prop('checked',false);
                                                } 
                                        });
                                        $("#endhalf").on("click", function(){	
                                                if($("#start_date").val() == $("#end_date").val()) {
                                                        $('#starthalf').prop('checked',false);
                                                        $('#endhalf').prop('checked',true);
                                                } 
                                        });

                                        $("#leave_type").select2(
                                                {
                                                formatResult: function(item, container) { 
                                                                        var originalOption = item.id;
                                                                        var originalText = (item.text).split('@');
                                                                        var color = originalText[1];
                                                                        var balance = originalText[2];
                                                                        var title = originalText[0];

                                                                if(typeof balance === "undefined") {
                                                                        balance = '';	
                                                                } else {
                                                                        balance = '<strong>['+balance+']</strong>';
                                                                }	
                                                                return '<div title="' + title + '">'+'<span class="empty_fill" style="background-color:'+color+';"></span>' + title+balance+'</div>';	

                                                },

                                                formatSelection: function(item, container) { 
                                                                        var originalOption = item.id;
                                                                        var originalText = (item.text).split('@');
                                                                        var color = originalText[1];
                                                                        var balance = originalText[2];
                                                                        var title = originalText[0];	
                                                                        var halfday = originalText[3];
                                                                        //hiddentextbox
                                                                        $("#hdnhalfday").val(halfday);
                                                                        if(typeof balance === "undefined") {
                                                                                balance = '';	
                                                                        } else {
                                                                                balance = '<strong>['+balance+']</strong>';
                                                                        }	
                                                                if(halfday ==0) {
                                                                        $("#starthalfcheck").addClass('hide');
                                                                        $("#endhalfcheck").addClass('hide');
                                                                        $("#starthalf").addClass('hide');
                                                                        $("#starthalf").prop('checked',false);
                                                                        $("#endhalf").prop('checked',false);
                                                                        $("#endhalf").addClass('hide');
                                                                } else {
                                                                        $("#starthalfcheck").removeClass('hide');
                                                                        $("#starthalf").removeClass('hide');
                                                                }	
                                                        //return color

                                                                return '<span class="empty_fill" style="background-color:'+color+';margin-right:10px;"></span>'+ title +balance+'</strong>';
                                                }
                                        });

                                        //**
                                        if(jQuery('#savetype').val() == 'Approved' || jQuery('#savetype').val() == 'Cancel' || jQuery('#savetype').val() == 'Not Approved'){

                                                 $('#leave_type').select2('disable');
                                                 $("#start_date").attr("disabled",true);
                                                 $("#end_date").attr("disabled",true);
                                                 $("#replaceuser").select2("disable");
                                                 $("#reason").attr("disabled", true);
                                                 $("#rejectionreasontxt").attr("disabled", true);			
                                                 $("input").attr("disabled",true);	
                                        }

                                        if(jQuery('#savetype').val() == 'Apply'){
                                                 $('#leave_type').select2('disable');
                                                 $("#start_date").attr("disabled",true);
                                                 $("#end_date").attr("disabled",true);
                                                 $("#replaceuser").select2("disable");
                                                 $("#reason").attr("disabled", true);

                                        }
                                        var len = $("#reason").val().length;
                                        var remainchar = 300 - len;
                                        $('#charNum_reason').text(remainchar + ' character(s) left');

                         form.submit(function(e) { 
                            e.preventDefault();
                         })
                                        var params = {
                            submitHandler : function(form1){
                              var form = jQuery("#editLeave");


                              var userid = jQuery('#current_user_id').val();

                             // app.helper.showProgress();
                              var extraData = form.serializeFormData();
                              var chkboxstarthalf = $('#starthalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX
                                 var chkboxendhalf = $('#endhalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX
                              var chkboxval = $('#chkviewable').is(':checked')?'1':'0';
                              var chkboxstudying = $('#chkstudying').is(':checked')?'1':'0';


                              extraData.chkboxstarthalf = jQuery('#starthalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX
                              extraData.chkboxendhalf = jQuery('#endhalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX

                              thisInstance._upload(form, extraData).then(function(data) { 
                                     app.helper.hideProgress(); 
                                     app.helper.hideModal();
                                     app.helper.showSuccessNotification({'message': app.vtranslate(data.result.msg, 'Users')});	
                                           thisInstance.updateLeaveGrid(user_id);

                                         }, function(e) {
                                            app.helper.showErrorNotification({'message': app.vtranslate(data.result.msg, 'Users')});
                                 }); 

                             }
                        };
                         form.vtValidate(params)
                        } else {
                        aDeferred.reject(err);
                    }
                });
             return aDeferred.promise();	
        },

     _upload : function(form,extraData) {

        var aDeferred = jQuery.Deferred();
        var file_data = jQuery('#attachment').prop('files')[0];   
        var formData = new FormData();                    
            formData.append('attachment', file_data);                            
                  if(typeof extraData === 'object') {
                             jQuery.each(extraData, function(name,value) {
                                     formData.append(name,value);
                             });
                     }

                    jQuery.ajax({
                        url: 'index.php?module=Users&parent=Settings&action=SaveSubModuleAjax&mode=saveLeave', 
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,                         
                        type: 'post',
                        success: function(res){
                            aDeferred.resolve(res);
                       }
                });
                return aDeferred.promise();
        },

                //Added by jitu@secondcrm on 17-03-2015 for 

        registerSetLeaveType : function() {
                $("#my_selyear").select2({ width: '100px'});
                $("#team_selyear").select2({ width: '100px'});
                $("#sel_teammember").select2({ width: '200px'});
                $("#sel_leavetype").select2().select2("val", ' ');
                $("#sel_leavetype").select2(
                        { 
                                width:'200px',	
                                formatResult: function(item, container) { 
                                        var originalOption = item.id;
                                        var originalText = (item.text).split('@');
                                        var color = originalText[1];
                                        var balance = originalText[2];
                                        var title = originalText[0];	
                                        return '<div title="' + title + '">'+'<span class="empty_fill" style="background-color:'+color+';"></span>' + title+'</div>';
                                },
                                formatSelection: function(item, container) { 
                                        var originalOption = item.id;
                                        var originalText = (item.text).split('@');
                                        var color = originalText[1];
                                        var balance = originalText[2];
                                        var title = originalText[0];	
                                //return color
                                return '<span class="empty_fill" style="background-color:'+color+';margin-right:10px;"></span>'+ title;
                                }
                        }
                );
        },
     updateLeaveGrid : function(userid) {  
                        var params = {
                                        'module' : 'Users',
                                        'view'   : 'ListViewAjax',
                                        'record' : userid,		
                                        'mode'   : 'getUserLeave',
                                }
                                app.request.post({'data':params}).then(
                                        function(err, data) {
                                                jQuery('#leave').html(data);
                                        },

                                        function(error,err){
                                                aDeferred.reject();
                                        }
                                );
        },

         checkApplyLeave : function(userid) {  
                        var params = {
                                        'module' :  'Users',
                                        'view'   : 'ListViewAjax',
                                        'mode'   : 'checkApplyLeave',
                                        'record' :userid,
                                }
                                app.request.post({'data':params}).then(
                                        function(err, data) {
                                                 if(data==0) 
                                                        return true;	
                                                 else 
                                                        return false;	
                                        },

                                        function(error,err){
                                                aDeferred.reject();
                                        }
                                );
        },

        deleteLeave : function(deleteRecordActionUrl) { 
                var message = app.vtranslate('JS_DELETE_LEAVE_CONFIRMATION');
                var thisInstance = this;
                var userid = jQuery('#recordId').val();
                app.helper.showConfirmationBox({'message' : message}).then(function(e) {

                app.request.post({url:deleteRecordActionUrl}).then(
                     function(err,data){
                                      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
                                     //delete the Education details in the list
                                     thisInstance.updateLeaveGrid(userid);
                             }
                     );
             });
     },


        cancelLeave : function(cancelRecordActionUrl,currentTrElement) { 

                var message = app.vtranslate('JS_CANCEL_LEAVE_CONFIRMATION');
                var thisInstance = this;
                var userid = jQuery('#recordId').val();
                var section = currentTrElement;	
                app.helper.showConfirmationBox({'message' : message}).then(function(data) {

                app.request.post({url:cancelRecordActionUrl}).then(
                     function(err,data){
                                      app.helper.showSuccessNotification({'message': 'Cancel successfully'});
                                     //delete the Education details in the list
                                     thisInstance.updateLeaveGrid(userid);
                             }
                     );
        });
},

        registerChangeYear : function(changeYearActionUrl,section) {  

                var thisInstance = this;
                var divcontainer  = section =='T'?'myteamleavelist':'myleavelist';

        var aDeferred = jQuery.Deferred();


                app.helper.showProgress();
                if (section == 'M'){
                var my_selyear=jQuery("#my_selyear").val();
                     changeYearActionUrl=changeYearActionUrl+'&selyear='+my_selyear;
                        }
                app.request.post({url:changeYearActionUrl}).then(
                function(err,data) { 
                      app.helper.hideProgress();

                if(err == null){

               $('#' + divcontainer).html(data);           



                    var form = jQuery('#my_selyear');                        
                                // for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});

                            form.submit(function(e) { 
                            e.preventDefault();
                         })
                                        var params = {
                            submitHandler : function(form){
                                var form = jQuery('#my_selyear');   
                                thisInstance.saveSkillDetails(form);
                            }
                        };
                         form.vtValidate(params);

                        } else {
                        aDeferred.reject(err);
                    }
                });
             //return aDeferred.promise();	

///////////////////////////////////////////

        },

 sel_teammember : function(changeYearActionUrl,section){
                var membercombo = jQuery('#sel_teammember');
                var myyearcombo = jQuery("#team_selyear");
                var leavetypecombo = jQuery("#sel_leavetype");	

                Users_Leave_Js.registerChangeYear(changeYearActionUrl+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val(),section);


        },

         Popup_LeaveApprove : function(LeaveApproveUrl){

                this.editLeave(LeaveApproveUrl);

        },

        /*
         * Function to register all actions in the Tax List
         */
        registerActions : function() {
                var thisInstance = this;
                var container = jQuery('#MyLeaveContainer');

                //register click event for Add New Leave button
                container.find('.addMyLeave').click(function(e) {
                        var addMyLeaveButton = jQuery(e.currentTarget);
                        var createLeaveUrl = addMyLeaveButton.data('url');
                        var isAllow = addMyLeaveButton.data('allow');

                        if(isAllow) { 
                                thisInstance.editLeave(createLeaveUrl,'');
                        } else {
                                var params = {
                                                text: app.vtranslate('JS_NO_LEAVE_ALLOCATE','LEAVE'),
                                                type:'error'	
                                        };
                                Vtiger_Helper_Js.showPnotify(params);
                        }

                });
                var tab = $("#defaulttab").val();
                if(tab =='leave'){ 
                        var applicantid = $("#wapplicant").val();
                        var leaveid = $("#wleaveid").val();

                        var registerChangeYearlUrl = "?module=Users&view=EditLeave&record="+leaveid+"&userId="+applicantid+"&leavestatus=Apply&manager=true";
                        thisInstance.editLeave(lUrl, '');

                }
                //register event for edit Leave icon
                container.on('click', '.editLeave', function(e) {
                        var editLeaveButton = jQuery(e.currentTarget);
                        var currentTrElement = editLeaveButton.closest('tr');
                        thisInstance.editLeave(editLeaveButton.data('url'), currentTrElement);
                });CurrentDate

                //register event for delete leave icon
                container.on('click', '.deleteLeave', function(e) { ;
                var deleteLeaveButton = jQuery(e.currentTarget);
                var currentTrElement = deleteLeaveButton.closest('tr');
                thisInstance.deleteLeave(deleteLeaveButton.data('url'), currentTrElement);
                });

                //register event for cancel leave icon
                container.on('click', '.cancelLeave', function(e) { ;
                var cancelLeaveButton = jQuery(e.currentTarget);
                var currentTrElement = cancelLeaveButton.closest('tr');
                thisInstance.cancelLeave(cancelLeaveButton.data('url'), currentTrElement);
                });

                //register event for my leave year combobox.
                container.on('change', '.my_selyear', function(e) { 
                var myyearcombo = jQuery(e.currentTarget);
                thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val(),myyearcombo.data('section'));
                });

        },


        //MYTEAMLEAVEPAGING BY SAFUAN
        registerPaging : function(changePageActionUrl,section) {
                var thisInstance = this;
                var divcontainer  = section =='T'?'myteamleavelist':'myleavelist';

//////////////////////////////////

                var aDeferred = jQuery.Deferred();


                app.helper.showProgress();		
                console.log(changePageActionUrl);
                app.request.post({url:changePageActionUrl}).then(
                function(err,data) { 
               app.helper.hideProgress();
                    if(err == null){
                         $('#' + divcontainer).html(data);   
                    } else {
                         aDeferred.reject(err);
                    }
                });

             return aDeferred.promise();	

        },

        /*
         * Function to register all actions in the MY Team List List List
         */
        registerActionsTeamLeave : function() {
                var thisInstance = this;
                var container = jQuery('#MyTeamLeaveContainer');


                container.on('click','#LeaveNextPageButton', function(e) { 

                var myyearcombo = $('#team_selyear');
                var membercombo = jQuery("#sel_teammember");
                var leavetypecombo = jQuery("#sel_leavetype");
                var pagenum = parseInt($('#pageNumber').val());
                var nextpagenum = pagenum + 1;

                thisInstance.registerPaging(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val()+'&pagenumber='+nextpagenum,myyearcombo.data('section'));
                });

                //register event for my team leave paging<previous>.MYTEAMLEAVEPAGING BY SAFUAN
                container.on('click', '#LeavePreviousPageButton', function(e) {	

                var myyearcombo = $('#team_selyear');
                var membercombo = jQuery("#sel_teammember");
                var leavetypecombo = jQuery("#sel_leavetype");
                var pagenum = parseInt($('#pageNumber').val());
                var prevpagenum = pagenum - 1;

                thisInstance.registerPaging(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val()+'&pagenumber='+prevpagenum,myyearcombo.data('section'));
                });

                return true;


        },

        textAreaLimitCharDisapprove : function(){
                        $('#rejectionreasontxt').keyup(function() { 
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

        textAreaLimitChar : function(){
                        $('#reason').keyup(function() { 
                                var maxchar = 300;
                                var len = $(this).val().length;
                                if (len > maxchar) {
                                        $('#charNum_reason').text(' you have reached the limit');
                                        $(this).val($(this).val().substring(0, len-1));
                                } else {
                                        var remainchar = maxchar - len;
                                        $('#charNum_reason').text(remainchar + ' character(s) left');

                                }
                        });
        },
        registerFileChange: function(){
          jQuery('#attachment').on('change', function(e){
               var element = jQuery('#attachment')
                        var uploadFileSizeHolder = jQuery('.uploadedFileDetails');
               var fileName = e.target.files[0].name;
                        uploadFileSizeHolder.text(fileName);
                });
        },
},{
        //constructor



        registerEvents: function() {
            Users_Leave_Js.registerSetLeaveType();
        }

});

jQuery(document).ready(function(e){ 

        var eduinstance = new Users_Leave_Js();
        eduinstance.registerEvents();


})

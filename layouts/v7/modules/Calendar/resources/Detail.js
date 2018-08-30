Vtiger_Detail_Js("Calendar_Detail_Js", {
    
}, {
    
    _delete : function(deleteRecordActionUrl) {
        var params = app.convertUrlToDataParams(deleteRecordActionUrl+"&ajaxDelete=true");
        app.helper.showProgress();
        app.request.post({data:params}).then(
        function(err,data){
            app.helper.hideProgress();
            if(err === null) {
                if(typeof data !== 'object') {
                    window.location.href = data;
                } else {
                    app.helper.showAlertBox({'message' : data.prototype.message});
                }
            } else {
                app.helper.showAlertBox({'message' : err});
            }
        });
    },

    /*
     * Function to save the Configuration Editor content
     */
    registerSaveButton : function(form) {
        var aDeferred = jQuery.Deferred();      
        var data = form.serializeFormData();       
        var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'action' : 'CalendarActions',
                'mode' : 'updateMOMContent',
                'data' : data
            }

        AppConnector.request(params).then(
            function(data) {
                aDeferred.resolve(data);
            },
            function(error,err){
                aDeferred.reject();
            }
        );

        return aDeferred.promise();
    },
	 /**
	 * Added By Jitu and Mabruk Function to register event for ckeditor for description field
	 */
	registerTextEditorForMOM : function(e){
        var thisInstance = this;
		
		var noteContentElement = jQuery("#min_meeting");
		if(noteContentElement.length > 0 && jQuery('#cke_min_meeting').length < 1){
			noteContentElement.removeAttr('data-validation-engine').addClass('ckEditorSource');
			var ckEditorInstance = new Vtiger_CkEditor_Js();
			ckEditorInstance.loadCkEditor(noteContentElement);
			noteContentElement.closest('td').css({'width':'1015px'});
			//noteContentElement.closest('tr').find('td:nth-child(1)').hide();
			//noteContentElement.closest('tr').find('td:nth-child(3)').hide();
			//noteContentElement.closest('tr').find('td:nth-child(4)').hide();			
		}

       // thisInstance.loadMeetingContainer();
	},

	/**
	 * Added By Mabruk Function to Load edit View of MOM Text Editor
     	 * This function is being called in the file modules/vtiger/resources/Detail.js
	 */
	loadMeetingContainer : function(){
        var clickmeeting = jQuery("#clickmeeting");
        var meetingContainer = jQuery("#meetingContainer");
        var meetingContent = jQuery('#meetingContent');

        if (jQuery('#meetingStatus').val() == "Held") 
            var contentType = "MOM";
        else
            var contentType = "Agenda";

        var subject = jQuery('#subject').val();

        var thisInstance = this;
        clickmeeting.unbind('click'); /**Unbinded to avoid infinite loop on every register**/
		clickmeeting.click( function(){
            thisInstance.registerTextEditorForMOM();
			clickmeeting.hide();
            meetingContent.hide();
			meetingContainer.show();
		});


        jQuery(".cancelMOM").unbind('click'); /**Unbinded to avoid infinite loop on every register**/
        jQuery(".cancelMOM").click(function() {
            meetingContainer.hide();
            meetingContent.show();
            clickmeeting.show();
        });

        //Register Save Button for Edit MOM
        jQuery("#saveMOM").unbind('click'); /**Unbinded to avoid infinite loop on every register**/
        jQuery("#saveMOM").click( function(){
            var form = jQuery('#MOM');
            form.on('submit', function (e) {
                e.preventDefault();
                return false;
            });

            var aDeferred = jQuery.Deferred();
            var formData = form.serializeFormData();
            //alert(jQuery("#min_meeting").html());
            var params = {
                'module'  : app.getModuleName(),
                'parent'  : app.getParentModuleName(),
                'action'  : 'CalendarActions',
                'mode'    : 'updateMOMContent',
                'id'      : app.getRecordId(),
                'content' : CKEDITOR.instances['min_meeting'].getData()
            }

            AppConnector.requestPjax(params).then(
                function(data) { //alert('success');
                var response = JSON.parse(data);
               // alert(data);
               // alert(response.result.min_meeting);
                    meetingContent.show();
                    clickmeeting.show();                    
                    meetingContent.html(response.result);
                    jQuery('#min_meeting').html(response.result);
                    meetingContainer.hide();

                    aDeferred.resolve();
                    history.pushState({}, null, window.history.back());
                },
                function(error,err){// alert('failed');
                    app.helper.showErrorNotification({message: 'Content for ' + contentType + ' is too small'});
                    meetingContent.show();
                    clickmeeting.show();
                    meetingContainer.hide();
                    aDeferred.reject();
                }
            );
            return aDeferred.promise();
        });

        //Register Send Email Button for Edit MOM
        jQuery(".sendMail").unbind('click'); /**Unbinded to avoid infinite loop on every register**/
        jQuery(".sendMail").click( function(e){            
            var aDeferred = jQuery.Deferred();

            var content = jQuery("#meetingContent").html();
            var emails = [];
            jQuery('.chkbox:checked').each(function() {
                emails.push(jQuery(this).val());
            });

            if (emails.length > 0) {

                if (content == '' || content == null)
                    app.helper.showAlertBox({message: 'MOM Content is Empty'});   

                else
                {
                    var params = {
                        'module'      : app.getModuleName(),
                        'parent'      : app.getParentModuleName(),
                        'action'      : 'CalendarActions',
                        'mode'        : 'sendAgendaOrMOM',
                        'emails'      : emails,
                        'body'        : content,
                        'contentType' : contentType,
                        'subject'     : subject
                    }

                    AppConnector.request(params).then(
                        function(data) { 
                            app.helper.showSuccessNotification({message: 'Success'});
                            aDeferred.resolve();
                        },
                        function(error,err){
                            app.helper.showErrorNotification({message: 'Fail'});
                            aDeferred.reject();
                        }
                    );
                }     
            }

            else
                app.helper.showAlertBox({message: 'Select at least one participant'});    

            return aDeferred.promise();
        });
	},

    /**
    * To Delete Record from detail View
    * @param URL deleteRecordActionUrl
    * @returns {undefined}
    */
    remove : function(deleteRecordActionUrl) {
        var thisInstance = this;
        var isRecurringEvent = jQuery('#addEventRepeatUI').data('recurringEnabled');
        if(isRecurringEvent) {
            app.helper.showConfirmationForRepeatEvents().then(function(postData) {
                deleteRecordActionUrl += '&' + jQuery.param(postData);
                thisInstance._delete(deleteRecordActionUrl);
            });
        } else {
            this._super(deleteRecordActionUrl);
        }
    },    
    
    registerEvents : function() {
        this._super();
    }
    
});

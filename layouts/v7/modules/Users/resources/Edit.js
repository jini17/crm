/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

var imported = document.createElement('script');
imported.src = 'layouts/v7/modules/Users/resources/google.js';
document.head.appendChild(imported);

Vtiger_Edit_Js("Users_Edit_Js",{},{
	
	
	duplicateCheckCache : {},
    
	/**
	 * Function to register recordpresave event
	 */
	registerRecordPreSaveEvent : function(form){
		var thisInstance = this;
		var roleId = jQuery('input[name="title"]').val(); 
		app.event.on(Vtiger_Edit_Js.recordPresaveEvent, function(e, data) {
			var userName = jQuery('input[name="user_name"]').val();
			var newPassword = jQuery('input[name="user_password"]').val();
		     var confirmPassword = jQuery('input[name="confirm_password"]').val();
			var record = jQuery('input[name="record"]').val();
            var firstName = jQuery('input[name="first_name"]').val();
            var lastName = jQuery('input[name="last_name"]').val();
            var specialChars = /[<\>\"\,]/;
            if((specialChars.test(firstName)) || (specialChars.test(lastName))) {
                app.helper.showErrorNotification({message :app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS')});
                e.preventDefault();
                return false;
            }
			var firstName = jQuery('input[name="first_name"]').val();
			var lastName = jQuery('input[name="last_name"]').val();
			if((firstName.indexOf(',') !== -1) || (lastName.indexOf(',') !== -1)) {
                app.helper.showErrorNotification({message :app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS')});
				e.preventDefault();
				return false;
			}
			if(record == ''){
				if(newPassword != confirmPassword){
                    app.helper.showErrorNotification({message :app.vtranslate('JS_REENTER_PASSWORDS')});
					e.preventDefault();
				}

                if(!(userName in thisInstance.duplicateCheckCache)) {
                    e.preventDefault();
                    thisInstance.checkDuplicateUser(userName).then(
                        function(data,error){
                            thisInstance.duplicateCheckCache[userName] = data;
                            form.submit();
                        }, 
                        function(data){
                            if(data) {
                                thisInstance.duplicateCheckCache[userName] = data;
                                app.helper.showErrorNotification({message :app.vtranslate('JS_USER_EXISTS')});
                            } 
                        }
                    );
                } else {
                    if(thisInstance.duplicateCheckCache[userName] == true){
                        app.helper.showErrorNotification({message :app.vtranslate('JS_USER_EXISTS')});
                        e.preventDefault();
                    } else {
                        delete thisInstance.duplicateCheckCache[userName];
                        return true;
                    }
                }
            }
        })
	},
	
	checkDuplicateUser: function(userName){
		var aDeferred = jQuery.Deferred();
		var params = {
				'module': app.getModuleName(),
				'action' : "SaveAjax",
				'mode' : 'userExists',
				'user_name' : userName
			}
		app.request.post({data:params}).then(
				function(err,data) {
					if(data){
						aDeferred.resolve(data);
					}else{
						aDeferred.reject(data);
					}
				}
			);
		return aDeferred.promise();
	},
	
	/**
	 * Function load the ckeditor for signature field in edit view of my preference page.
	 */
	registerSignatureEvent: function(){
		var templateContentElement = jQuery("#Users_editView_fieldName_signature");
		if(templateContentElement.length > 0) {
			var ckEditorInstance = new Vtiger_CkEditor_Js();
			//Customized toolbar configuration for ckeditor  
			//to support basic operations
			var customConfig = {
				toolbar: [
					{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup','align','list', 'indent','colors' ,'links'], items: [ 'Bold', 'Italic', 'Underline', '-','TextColor', 'BGColor' ,'-','JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList','-', 'Link', 'Unlink','Image','-','RemoveFormat'] },
					{ name: 'styles', items: ['Font', 'FontSize' ] },
                    {name: 'document', items:['Source']}
				]};
			ckEditorInstance.loadCkEditor(templateContentElement,customConfig);
		}
	},
		registerGoogleAddress : function(container){
		var thisInstance = this;
	
		
	    var script = document.createElement('script');
	    script.type = 'text/javascript';
	    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyA7QuhuZ34ygC0j5RHmYuqtK_uwecsNb9E&libraries=places&callback=initAutocomplete";
	    document.body.appendChild(script);	
	},

	/**
	 * Function Added By Mabruk
	 * for user limit per role validation while creating a user
	 */
	registerEventForUserlimitValidation : function() {
		
		var role = jQuery("[name=roleid]");

		role.change( function(){		

			if (role.val() != null && role.val() != "") {
				var aDeferred = jQuery.Deferred();
				var params = {
						'module' : app.getModuleName(),
						'action' : "UserLimitPerRoleValidation",				
						'roleid' : role.val()
					}
				app.request.post({data:params}).then(
						function(err,data) {
							if(data){
								if (data.result != true) {

									app.helper.showErrorNotification({message : "User limit reached for this Role"});
									role.val('').trigger("liszt:updated");
									role.closest('div').find('.select2-chosen:first').text("Select Role");									
									
								} 

								aDeferred.resolve(data);
							}

							else{ 
								aDeferred.reject(data);
							}
						}
					);
				return aDeferred.promise();
			}		
		});


	},
	
	registerEvents : function() { 
        this._super();
		var form = this.getForm();
		this.registerRecordPreSaveEvent(form);
        this.registerSignatureEvent();
        this.registerEventForUserlimitValidation();
        Settings_Users_PreferenceEdit_Js.registerChangeEventForCurrencySeparator();
        
        var instance = new Settings_Vtiger_Index_Js(); 
        instance.registerBasicSettingsEvents();
        this.registerGoogleAddress();
	}
});

// Actually, Users Module is in Settings. Controller in application.js will check for Settings_Users_Edit_Js 
Users_Edit_Js("Settings_Users_Edit_Js");

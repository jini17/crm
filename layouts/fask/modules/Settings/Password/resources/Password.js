/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
var Settings_Password_Js = {
	loadAction: function() {
        jQuery("#big_letters").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).is(':checked'));
        });
        jQuery("#small_letters").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).is(':checked'));
        });
        jQuery("#numbers").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).is(':checked'));
        });
        jQuery("#special").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).is(':checked'));
        });
        jQuery("#min_length").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).val());
        });
        jQuery("#max_length").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).val());
        });
	jQuery("#pwd_exp").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).val());
        });
	jQuery("#pwd_reuse").change(function() {
			Settings_Password_Js.saveConf(jQuery(this).attr('name'), jQuery(this).val());
        });

	jQuery("#is_minlen").change(function() {
			if (jQuery(this).is(':checked')) { 
				jQuery('#min_length').prop('disabled','');
			} else {
				jQuery('#min_length').val('');
				Settings_Password_Js.saveConf(jQuery('#min_length').attr('name'), '');
				jQuery('#min_length').prop('disabled','disabled');
			}
	});

	jQuery("#is_maxlen").change(function() {
			if (jQuery(this).is(':checked')) { 
				jQuery('#max_length').prop('disabled','');
			} else {
				jQuery('#max_length').val('');
				Settings_Password_Js.saveConf(jQuery('#max_length').attr('name'), '');
				jQuery('#max_length').prop('disabled','disabled');
			}
	});

	jQuery("#is_pwdexp").change(function() {
			if (jQuery(this).is(':checked')) { 
				jQuery('#pwd_exp').prop('disabled','');
			} else {
				jQuery('#pwd_exp').val('');
				Settings_Password_Js.saveConf(jQuery('#pwd_exp').attr('name'), '');
				jQuery('#pwd_exp').prop('disabled','disabled');
			}
        });

	jQuery("#is_pwdreuse").change(function() {
			if (jQuery(this).is(':checked')) { 
				jQuery('#pwd_reuse').prop('disabled','');
			} else {
				jQuery('#pwd_reuse').val('');
				Settings_Password_Js.saveConf(jQuery('#pwd_reuse').attr('name'), '');
				jQuery('#pwd_reuse').prop('disabled','disabled');
			}
	});	
				
		jQuery('#min_length').keyup(function () {  
			this.value = this.value.replace(/[^0-9\.]/g,''); 
		});
		jQuery('#max_length').keyup(function () {  
			this.value = this.value.replace(/[^0-9\.]/g,''); 
		});
		jQuery('#pwd_exp').keyup(function () {   
			this.value = this.value.replace(/[^0-9\.]/g,''); 
		});
		jQuery('#pwd_reuse').keyup(function () {  
			this.value = this.value.replace(/[^0-9\.]/g,''); 
		});	
	},

	saveConf: function( type , vale ) {
		app.helper.showProgress();
        var params = {
			'module' : app.getModuleName(),
			'parent' : app.getParentModuleName(),
			'action': "Save",
               'type': type,
               'vale': vale
        }
         app.helper.showProgress(); 
		app.request.post({'data': params}).then(function (error, data) {
			app.helper.hideProgress();
			     if (error == null) {
					app.helper.showSuccessNotification({'message': app.vtranslate(data)});
				}
				else {
				     app.helper.showErrorNotification({'message': app.vtranslate('JS_DUPLICATE_HANDLING_FAILURE_MESSAGE')});
				}
       		 });
	},
	
	registerEvents : function() {
		Settings_Password_Js.loadAction();
	}
}
jQuery(document).ready(function(){
	Settings_Password_Js.registerEvents();
})

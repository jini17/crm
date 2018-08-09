/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
var Settings_MaxLogin_Js = {
	runAppConnector : function(params) {
		  AppConnector.request(params).then(
			function(data) {
				var response = data['result'];
				
				if ( response.success) {
					app.helper.showSuccessNotification({'message': app.vtranslate(response.message)})
									}
				else {
					app.helper.showErrorNotification({'message': app.vtranslate(response.message)});
				}
			},
			function(data,err){
				app.helper.showErrorNotification({'message': app.vtranslate(err)});    
			}
		);      
	},
	registerEvents : function() {
		var instance = this;
		jQuery('#saveConfig').click(function() { 
			var attempsNumber = jQuery('[name="attempsnumber"]').val();
			var timeLock = jQuery('[name="timelock"]').val();
			
			if (!attempsNumber.length && !timeLock) { 
				var params = {
					text: app.vtranslate('Complete the fields'),
					animation: 'show',
					type: 'warning'
				};
				Vtiger_Helper_Js.showPnotify(params);    
				return false;
			}
			var params = {}
			params = {
				module: 'MaxLogin',
				action: 'SaveConfig',
				parent: app.getParentModuleName(),
				number: attempsNumber,
				timelock: timeLock,
			};
			params.async = false;
			params.dataType = 'json';
			instance.runAppConnector(params);
			return false;
		});
		
		$( "#brutalforce_tab_btn_1" ).click(function() { 
			$("#brutalforce_tab_btn_2").attr('class', '');
			$("#brutalforce_tab_btn_1").attr('class', 'active');
			$("#brutalforce_tab_2" ).hide(); 
			$("#brutalforce_tab_1" ).show();      
		});
		$( "#brutalforce_tab_btn_2" ).click(function() { 
			$("#brutalforce_tab_btn_1").attr('class', '');
			$("#brutalforce_tab_btn_2").attr('class', 'active');
			$("#brutalforce_tab_2" ).prop('class','active');
			$("#brutalforce_tab_1" ).hide(); 
			$("#brutalforce_tab_2" ).show();      
		});   
		
		jQuery(".unblock").on("click", function(){
			jQuery(this).parents('tr').hide();
			username = jQuery(this).attr('data-username');
			var params = {}
			params = {
				module: 'MaxLogin',
				action: 'UnBlock',
				parent: app.getParentModuleName(),
				username: username,
			};
			params.async = false;
			params.dataType = 'json';
			instance.runAppConnector(params);          
			return false;
		});
	}
}
jQuery(document).ready(function(){
	//var currencyInstance = new Settings_MaxLogin_Js();
	Settings_MaxLogin_Js.registerEvents();
    //currencyInstance.registerEvents();
	//Added By Mabruk
	var vtigerSettings = new Settings_Vtiger_Index_Js();
	vtigerSettings.registerAccordionClickEvent();
	var tacInstance = new Settings_Vtiger_OutgoingServer_Js();
	var vtigerinst = new Vtiger_Index_Js();
    	vtigerinst.registerEvents();
})

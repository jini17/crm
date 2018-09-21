/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Users_Edit_Js("Settings_Users_PreferenceEdit_Js",{
	
	addressFieldsMappingInModule : 
	{
		'address_street' : 'paddress_street',
		'address_city' : 'paddress_city',
		'address_state' : 'paddress_state',
		'address_postalcode' : 'paddress_postalcode',
		'address_country' : 'paddress_country'
	},	
	
	registerCopyPermanentAddress: function(){ 
		var container = jQuery("form");
		var thisInstance = this;
		var element = jQuery('[name="sameaddresscheck"]', container);
		element.on('click', function(e){
			var response = element.is(':checked');
			
			if (response) { 
				var addressMapping = thisInstance.addressFieldsMappingInModule;
		
				for(var key in addressMapping) {
						var fromElement = container.find('[name="'+key+'"]');
						var toElement = container.find('[name="'+addressMapping[key]+'"]');
						var inputctr = toElement.get(0).tagName;
						if(inputctr == 'SELECT') { 
							var selectcontainerID = toElement.get(0).id+'_chzn';
							jQuery('#'+selectcontainerID).remove();
							toElement.select2().select2('val',fromElement.val());
							jQuery('#s2id_'+toElement.get(0).id).addClass('chzn-container chzn-container-single').css('width','220px');
						} else {
							toElement.val(fromElement.val());
						}
				}
			} 
		});	
	},
    
	/**
	 * Function to register change event for currency separator
	 */
	registerChangeEventForCurrencySeparator : function(){
		var form = jQuery('form');
		jQuery('[name="currency_decimal_separator"]',form).on('change',function(e){
			var element = jQuery(e.currentTarget);
			var selectedValue = element.val();
			var groupingSeparatorValue = jQuery('[name="currency_grouping_separator"]',form).data('selectedValue');
			if(groupingSeparatorValue == selectedValue){
				app.helper.showErrorNotification({'message': app.vtranslate('JS_DECIMAL_SEPARATOR_AND_GROUPING_SEPARATOR_CANT_BE_SAME')});
				var previousSelectedValue = element.data('selectedValue');
				element.select2('val', previousSelectedValue);
			} else {
				element.data('selectedValue',selectedValue);
			}
		})
		jQuery('[name="currency_grouping_separator"]',form).on('change',function(e){
			var element = jQuery(e.currentTarget);
			var selectedValue = element.val();
			var decimalSeparatorValue = jQuery('[name="currency_decimal_separator"]',form).data('selectedValue');
			if(decimalSeparatorValue == selectedValue){
				app.helper.showErrorNotification({'message': app.vtranslate('JS_DECIMAL_SEPARATOR_AND_GROUPING_SEPARATOR_CANT_BE_SAME')});
				var previousSelectedValue = element.data('selectedValue');
				element.select2('val', previousSelectedValue);
			} else {
				element.data('selectedValue',selectedValue);
			}
		})
	},

	
	registerNameFieldChangeEvent : function() {
		var form = jQuery('form');
		var specialChars = /[<\>\"\,]/;
		jQuery('[name="first_name"]',form).on('change',function(e){
			var firstNameEle = jQuery(e.currentTarget);
			var firstName = firstNameEle.val();
			var firstNameOldVal = firstNameEle.parent().find('.fieldname').data('prev-value');
			if(specialChars.test(firstName)) {
				Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS'));
				firstNameEle.val(firstNameOldVal);
			}
		});
		jQuery('[name="last_name"]',form).on('change',function(e){
			var lastNameEle = jQuery(e.currentTarget);
			var lastName = lastNameEle.val();
			var lastNameOldVal = lastNameEle.parent().find('.fieldname').data('prev-value');
			if(specialChars.test(lastName)) {
				Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS'));
				lastNameEle.val(lastNameOldVal);
			}
		});
	}
},{
	
	
	registerNameFieldChangeEvent: function () {
		var form = jQuery('form');
		jQuery('[name="first_name"]', form).on('change', function (e) {
			var firstNameEle = jQuery(e.currentTarget);
			var firstName = firstNameEle.val();
			var firstNameOldVal = firstNameEle.parent().find('.fieldname').data('prev-value');
			if (firstName.indexOf(',') !== -1) {
				Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS'));
				firstNameEle.val(firstNameOldVal);
			}
		});
		jQuery('[name="last_name"]', form).on('change', function (e) {
			var lastNameEle = jQuery(e.currentTarget);
			var lastName = lastNameEle.val();
			var lastNameOldVal = lastNameEle.parent().find('.fieldname').data('prev-value');
			if (lastName.indexOf(',') !== -1) {
				Vtiger_Helper_Js.showPnotify(app.vtranslate('JS_COMMA_NOT_ALLOWED_USERS'));
				lastNameEle.val(lastNameOldVal);
			}
		});
	}
		
	
}, {
	

	/**
	 * register Events for my preference
	 */
	registerEvents : function(){
		this._super();
		Users_PreferenceEdit_Js.registercopyPermanentAddress();
		Users_PreferenceEdit_Js.registerChangeEventForCurrencySeparator();
	}
});

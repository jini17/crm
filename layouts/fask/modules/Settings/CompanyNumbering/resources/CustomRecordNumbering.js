/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

jQuery.Class('Settings_CustomRecordNumbering_Js', {}, {
	
	form : false,
	getForm : function(){
		if(this.form == false){
			this.form = jQuery('#EditView');
		}
		return this.form;
	},
	
	registerOnChangeEventOfCompany :function(){
		var editViewForm = this.getForm();
		editViewForm.find('[name="company"]').on('change',function(e){ 
			var company = editViewForm.find('[name="company"]').val();
			var sourceModule = editViewForm.find('[name="sourceModule"]').val();
			params = {
				'company': company,
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : "CustomRecordNumberingAjax",
				'mode'   : "getModuleCustomNumberingData",
				'sourceModule' : sourceModule
			}
			
			AppConnector.request(params).then(
					function(data){
						if(data){
							editViewForm.find('[name="prefix"]').val(data.result.prefix);
							editViewForm.find('[name="sequenceNumber"]').val(data.result.sequenceNumber);
							editViewForm.find('[name="sequenceNumber"]').data('oldSequenceNumber',data.result.sequenceNumber);
						}
					},
					function(jqXHR,textStatus, errorThrown){
			})
		})	
	},

	/**
	 * Function to register change event for source module field
	 */
	registerOnChangeEventOfSourceModule :function(){
		var editViewForm = this.getForm();
		editViewForm.find('[name="sourceModule"]').on('change',function(e){
			jQuery('.saveButton').removeAttr('disabled');
			var element = jQuery(e.currentTarget);
			var params = {};
			var company    = jQuery('#company').val();			
			var sourceModule = element.val();
			
			params = {
				'company' : company,
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : "CustomRecordNumberingAjax",
				'mode' : "getModuleCustomNumberingData",
				'sourceModule' : sourceModule
			}
			
			AppConnector.request(params).then(
					function(data){
						if(data){
							editViewForm.find('[name="prefix"]').val(data.result.prefix);
							editViewForm.find('[name="sequenceNumber"]').val(data.result.sequenceNumber);
							editViewForm.find('[name="sequenceNumber"]').data('oldSequenceNumber',data.result.sequenceNumber);
						}
					},
					function(jqXHR,textStatus, errorThrown){
			})
		})
	},

	toggleMultipleNumbering : function(){ 
		jQuery('#saveNumbering').on('click',function(e) { 
		e.preventDefault();			
		var params = {}		
		params = {
			 module  : app.getModuleName(),
			 parent  : app.getParentModuleName(),
			 action  : "SaveAjax",
			 mode	 : "saveCompanyNumberingSetting", 	
			 business: jQuery("#business").val()
		}
		
		AppConnector.request(params).then(
			function(data){
				var params;
				var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_UPDATED_SUCCESSFULLY');
				if(data.success == true){
					jQuery(e.currentTarget).attr('disabled','disabled');
					params = {
						text: successfullSaveMessage
					};
					Settings_Vtiger_Index_Js.showMessage(params);
				}else{
					var errorMessage = app.vtranslate(data.error.message);
					params = {
						text: errorMessage,
						type: 'error'
					};
					Settings_Vtiger_Index_Js.showMessage(params);
				}
			});
	        });
	},
	
	/**
	 * Function to register event for saving module custom numbering
	 */
	saveModuleCustomNumbering : function(){

		var editViewForm = this.getForm();
		jQuery('.saveButton').on('click', function(){
			
			var params = {}
				
			var company = editViewForm.find('[name="company"]').val();
				
			var sourceModule = editViewForm.find('[name="sourceModule"]').val();
				
			var sourceModuleLabel = editViewForm.find('option[value="'+sourceModule+'"]').text();
			var prefix = editViewForm.find('[name="prefix"]');
			var currentPrefix = jQuery.trim(prefix.val());
			var oldPrefix = prefix.data('oldPrefix');
			var oldcompany = editViewForm.find('[name="oldcompany"]').val();

			var sequenceNumberElement = editViewForm.find('[name="sequenceNumber"]');
			var sequenceNumber = sequenceNumberElement.val();
			var oldSequenceNumber = sequenceNumberElement.data('oldSequenceNumber');

			if((sequenceNumber < oldSequenceNumber) && (currentPrefix == oldPrefix) && (oldcompany == company)){
				var errorMessage = app.vtranslate('JS_SEQUENCE_NUMBER_MESSAGE')+" "+oldSequenceNumber;
				sequenceNumberElement.validationEngine('showPrompt', errorMessage , 'error','topLeft',true);
				return;
			}

			params = {
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : "CustomRecordNumberingAjax",
				'mode' : "saveModuleCustomNumberingData",
				'company' : company,
				'sourceModule' : sourceModule,
				'prefix' : currentPrefix,
				'sequenceNumber' : sequenceNumber
			}
		
				jQuery('.saveButton').attr("disabled","disabled");
				AppConnector.request(params).then(
						function(data){
							var params;
							var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_UPDATED_SUCCESSFULLY')+" "+sourceModuleLabel;
							if(data.success == true){
								params = {
									text: successfullSaveMessage
								};
								Settings_Vtiger_Index_Js.showMessage(params);
							}else{
								var errorMessage = currentPrefix+" "+app.vtranslate(data.error.message);
								params = {
									text: errorMessage,
									type: 'error'
								};
								Settings_Vtiger_Index_Js.showMessage(params);
							}
						},
						function(jqXHR,textStatus, errorThrown){
				});
		
		});
	},	
	
	/**
	 * Function to handle update record with the given sequence number
	 */
	registerEventToUpdateRecordsWithSequenceNumber : function(){
		var editViewForm = this.getForm();
		editViewForm.find('[name="updateRecordWithSequenceNumber"]').on('click',function(){
			var params = {};
			var company      = editViewForm.find('[name="company"]').val();
			var sourceModule = editViewForm.find('[name="sourceModule"]').val();
			var sourceModuleLabel = editViewForm.find('option[value="'+sourceModule+'"]').text();
			
			params = {
				'company':company,
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : "CustomRecordNumberingAjax",
				'mode' : "updateRecordsWithSequenceNumber",
				'sourceModule' : sourceModule
			}
			
			AppConnector.request(params).then(
					function(data){ 
						var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_UPDATED_SUCCESSFULLY')+" "+sourceModuleLabel;
						if(data.success == true){
							var params = {
								text: successfullSaveMessage
							};
							Settings_Vtiger_Index_Js.showMessage(params);
						}else{
							Settings_Vtiger_Index_Js.showMessage(data.error.message);
						}
			
			paramscheck = {
				'company': company,
				'module' : app.getModuleName(),
				'parent' : app.getParentModuleName(),
				'action' : "CustomRecordNumberingAjax",
				'mode'   : "getModuleCustomNumberingData",
				'sourceModule' : sourceModule
			}
			
			AppConnector.request(paramscheck).then(
					function(data){
						if(data){
							editViewForm.find('[name="prefix"]').val(data.result.prefix);
							editViewForm.find('[name="sequenceNumber"]').val(data.result.sequenceNumber);
							editViewForm.find('[name="sequenceNumber"]').data('oldSequenceNumber',data.result.sequenceNumber);
						}
				})
		
			})
		})
	},
	
	/**
	 * Function to register change event for prefix and sequence number
	 */
	registerChangeEventForPrefixAndSequenceNumber : function() {
		var editViewForm = this.getForm();
		editViewForm.find('[name="prefix"],[name="sequenceNumber"]').on('change',function(){
			jQuery('.saveButton').removeAttr('disabled');
		})
	},

	/**
	 * Function to Handle Picklist Depedency of the Companies By Mabruk
	 */
	registerPicklistEvents : function() {

		var picklistParent = jQuery('#sourceModule');
		var selectedValue  = jQuery('#s2id_sourceModule').find('.select2-chosen');

		var allOptions = jQuery('#sourceModule').html();
		var altOptions = '<option value="Invoice" selected>Invoice</options>' +
			'<option value="Quotes">Quotes</options>' +
			'<option value="PurchaseOrder">Purchase Order</options>' +
			'<option value="SalesOrder">Sales Order</options>'; 

		jQuery('#company').change(function(){ 
			if (jQuery(this).val() != "1") {
				picklistParent.html(altOptions);
				selectedValue.html("Invoice");
				jQuery(this).val("Invoice");
			}
			else{
				picklistParent.html(allOptions);
				selectedValue.html("Contacts");	
				jQuery(this).val("Contacts");
			}	
				
		})		
			

	}, 
	
	/**
	 * Function to register events
	 */
	registerEvents : function(){
		var thisInstance = this;
		var editViewForm = this.getForm();
		this.registerOnChangeEventOfCompany();
		this.registerOnChangeEventOfSourceModule();
		this.registerEventToUpdateRecordsWithSequenceNumber();
		this.registerChangeEventForPrefixAndSequenceNumber();
		this.registerPicklistEvents();
		this.saveModuleCustomNumbering();		
		//this.toggleMultipleNumbering();
		
	}
})
jQuery(document).ready(function() { 
	var customRecordNumberingInstance = new Settings_CustomRecordNumbering_Js();
	customRecordNumberingInstance.registerEvents();
});

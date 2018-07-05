/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
var imported = document.createElement('script');
imported.src = 'layouts/v7/modules/Invoice/resources/google.js';
document.head.appendChild(imported);

Inventory_Edit_Js("Invoice_Edit_Js",{},{
    
    accountRefrenceField : false,
    
    initializeVariables : function() {
        this._super();
        var form = this.getForm();
        this.accountReferenceField = form.find('[name="account_id"]');
    },
    
    /**
	 * Function which will register event for Reference Fields Selection
	 */
	registerReferenceSelectionEvent : function(container) {
		this._super(container);
		var self = this;
		
		this.accountReferenceField.on(Vtiger_Edit_Js.referenceSelectionEvent, function(e, data){
			self.referenceSelectionEventHandler(data, container);
		});
	},
    
    /**
	 * Function to get popup params
	 */
	getPopUpParams : function(container) {
		var params = this._super(container);
        var sourceFieldElement = jQuery('input[class="sourceField"]',container);
		if(!sourceFieldElement.length) {
			sourceFieldElement = jQuery('input.sourceField',container);
		}

		if(sourceFieldElement.attr('name') == 'contact_id') {
			var form = this.getForm();
			var parentIdElement  = form.find('[name="account_id"]');
			if(parentIdElement.length > 0 && parentIdElement.val().length > 0 && parentIdElement.val() != 0) {
				var closestContainer = parentIdElement.closest('td');
				params['related_parent_id'] = parentIdElement.val();
				params['related_parent_module'] = closestContainer.find('[name="popupReferenceModule"]').val();
			}
        }
        return params;
    },
    
    /**
	 * Function to search module names
	 */
	searchModuleNames : function(params) {
		var aDeferred = jQuery.Deferred();

		if(typeof params.module == 'undefined') {
			params.module = app.getModuleName();
		}
		if(typeof params.action == 'undefined') {
			params.action = 'BasicAjax';
		}
		
		if(typeof params.base_record == 'undefined') {
			var record = jQuery('[name="record"]');
			var recordId = app.getRecordId();
			if(record.length) {
				params.base_record = record.val();
			} else if(recordId) {
				params.base_record = recordId;
			} else if(app.view() == 'List') {
				var editRecordId = jQuery('#listview-table').find('tr.listViewEntries.edited').data('id');
				if(editRecordId) {
					params.base_record = editRecordId;
				}
			}
		}

		if (params.search_module == 'Contacts') {
			var form = this.getForm();
			if(this.accountReferenceField.length > 0 && this.accountReferenceField.val().length > 0) {
				var closestContainer = this.accountReferenceField.closest('td');
				params.parent_id = this.accountReferenceField.val();
				params.parent_module = closestContainer.find('[name="popupReferenceModule"]').val();
			}
		}
        
        // Added for overlay edit as the module is different
        if(params.search_module == 'Products' || params.search_module == 'Services') {
            params.module = 'Invoice';
        }
        
		app.request.get({'data':params}).then(
			function(error, data) {
                if(error == null) {
                    aDeferred.resolve(data);
                }
			},
			function(error){
				aDeferred.reject();
			}
		)
		return aDeferred.promise();
	},
		registerGoogleAddress : function(container){
		var thisInstance = this;
	
	    var script = document.createElement('script');
	    script.type = 'text/javascript';
	    script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyA7QuhuZ34ygC0j5RHmYuqtK_uwecsNb9E&libraries=places&callback=initAutocomplete";
	    document.body.appendChild(script);
  
		
	},
        
        registerBasicEvents: function(container){
            this._super(container);
            this.registerForTogglingBillingandShippingAddress();
            this.registerEventForCopyAddress();  
            this.registerGoogleAddress();
        },
});
    


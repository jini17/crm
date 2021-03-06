/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Settings_Vtiger_List_Js("Settings_ManageDiscount_List_Js",{
	triggerEditEvent : function(editUrl) {
		
			AppConnector.request(editUrl).then(function(data) {
				app.showModalWindow(data);
				jQuery('#managediscountSaveAjax').validationEngine(app.validationEngineOptions);
				var listViewInstance = Settings_ManageDiscount_List_Js.getInstance();
				listViewInstance.registerSaveEvent();
			});
		

	},

	triggerDeleteEvent : function(editUrl) {
		
			AppConnector.request(editUrl).then(function(data) {
				app.showModalWindow(data);
				jQuery('#managediscountDeleteAjax').validationEngine(app.validationEngineOptions);
				var listViewInstance = Settings_ManageDiscount_List_Js.getInstance();
				listViewInstance.registerDELETEEvent();
			});
	}

},{


	getListViewRecords : function() {
		var thisInstance = this;
		var params = {
			module : app.getModuleName(),
			parent : app.getParentModuleName(),
			view : 'List'
		}
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		AppConnector.request(params).then(function(data){
			jQuery('#listViewContents').html(data);
			thisInstance.registerSortableEvent();
			progressIndicatorElement.progressIndicator({
				mode : 'hide'
			});
		})
	},
	
	
	registerSaveEvent : function() {
		var thisInstance = this;
		thisInstance.triggerOptionEvent();
		jQuery('#managediscountSaveAjax').on('submit',function(e){
			var form = jQuery(e.currentTarget);
			var validationResult = form.validationEngine('validate');
			var rolesSelectElement = jQuery('[name="roles[]"]',form);
				var select2Element = app.getSelect2ElementFromSelect(rolesSelectElement);
				var result = Vtiger_MultiSelect_Validator_Js.invokeValidation(rolesSelectElement);
				var discountamt = jQuery("#discountvalue").val();
				var discounttitle = jQuery("#title").val();
				var discountSelectElement = jQuery("#currentdiscount").val();

				if(discounttitle =='' && discountSelectElement=='') {
					alert(app.vtranslate('JS_EITHER_SELECT_OR_ENTER_DISCOUNT'));
					e.preventDefault();
					return;
						
				} else if(discountamt =='') {
				
					alert(app.vtranslate('JS_DISCOUNT_CANNT_BLANK'));	
					e.preventDefault();
					return;
				} else if(result != true){ 
					alert(result);
					select2Element.validationEngine('showPrompt', result , 'error','bottomLeft',true);
					e.preventDefault();
					return;
				} else {
					app.hideModalWindow();
					if(validationResult == true) {
						var params = form.serializeFormData();
						AppConnector.request(params).then(function(data){
							if(typeof data.result != 'undefined' && data.result[0] == true){
								app.hideModalWindow();
								var params = {};
								params.text = app.vtranslate('JS_DISCOUNT_SAVED');	
								thisInstance.getListViewRecords();
							}
						});			
					}
				}
			e.preventDefault();
		});
	},

	registerDELETEEvent : function() {
		var thisInstance = this;//
		jQuery('.deletediscount').on('click',function(e){
			var form = jQuery("#managediscountDeleteAjax");
			var discountSelectElement = jQuery('[name="discounts[]"]',form);
			var select2Element = app.getSelect2ElementFromSelect(discountSelectElement);
			var result = Vtiger_MultiSelect_Validator_Js.invokeValidation(discountSelectElement);
			if(result != true) { 
				alert(result);
				select2Element.validationEngine('showPrompt', result , 'error','bottomLeft',true);
				e.preventDefault();
				return;
			} else {
				var params = form.serializeFormData();
				AppConnector.request(params).then(function(data){
					if(typeof data.result != 'undefined' && data.result[0] == true){
						app.hideModalWindow();
						var params = {};
						params.text = app.vtranslate('JS_DISCOUNT_DELETED');
						Settings_Vtiger_Index_Js.showMessage(params);
						thisInstance.getListViewRecords();
					}
				});			
			e.preventDefault();
			}
			
		});
	},

	triggerOptionEvent : function(){ 
		var form = jQuery('#managediscountSaveAjax');
		jQuery(".currentdiscount").on('change', function(e) {
			var selectallrole = jQuery("#jsonrole").attr('data-allrole');
			
			if(jQuery(".currentdiscount").val() !='') {
				
				jQuery("#title").prop('readonly',true);
				var selectedoption = jQuery(".currentdiscount").find('option:selected');
				if(selectedoption.attr('data-criteria') == 'P') {
					var criteriatxt = 'Percentage';
				} else {
					var criteriatxt = 'Amount';
				}
				jQuery("#criteria").select2().select2('data', {id: selectedoption.attr('data-criteria'), text: criteriatxt});		jQuery("#s2id_criteria").addClass('chzn-container chzn-container-single').css({'width':'220px'});		jQuery("#criteria_chzn").addClass('hide');
				jQuery("#s2id_criteria .select2-drop select2-offscreen").css({'display':'none'});
				
				jQuery("#type").select2().select2('data', {id: 'V', text: 'Flexible'});
				jQuery("#s2id_type").addClass('chzn-container chzn-container-single').css({'width':'220px'});		jQuery("#type_chzn").addClass('hide');

				

				//Remove All Roles
				$.each($.parseJSON(selectallrole), function(index,item) {
					jQuery('#roles option[value="'+item.roleid+'"]').remove();	
				}); //End here		
				
				
				//Append All 
				$.each($.parseJSON(selectallrole), function(index,item) {
				   	jQuery("#roles").append(jQuery('<option>', {value:item.roleid, text: item.rolename}))
				}); //end here
				

				//Remove Selected Role
				var selectrole = selectedoption.attr('data-role').split('::');
				for(var role in selectrole) {
					jQuery('#roles option[value="'+selectrole[role]+'"]').remove();	
				} //End here	 
								
			} else {
				jQuery("#title").prop('readonly',false);
				jQuery("#s2id_type").addClass('hide');
				jQuery("#type_chzn").removeClass('hide');

				jQuery("#s2id_criteria").addClass('hide');
				jQuery("#criteria_chzn").removeClass('hide');

				//Append All 
				$.each($.parseJSON(selectallrole), function(index,item) {
				   	jQuery("#roles").append(jQuery('<option>', {value:item.roleid, text: item.rolename}))
				}); //end here
				
				
			}		
		});	
	},
	registerSortableEvent : function() {
		var thisInstance = this;
		var sequenceList = {};
		var tbody = jQuery( "tbody",jQuery('.listViewEntriesTable'));
		tbody.sortable({
			'helper' : function(e,ui){
				//while dragging helper elements td element will take width as contents width
				//so we are explicity saying that it has to be same width so that element will not
				//look like distrubed
				ui.children().each(function(index,element){
					element = jQuery(element);
					element.width(element.width());
				})
				return ui;
			},
			'containment' : tbody,
			'revert' : true,
			update: function(e, ui ) {
				jQuery('tbody tr').each(function(i){
					sequenceList[++i] = jQuery(this).data('id');
				});
				var params = {
					sequencesList : JSON.stringify(sequenceList),
					module : app.getModuleName(),
					parent : app.getParentModuleName(),
					action : 'UpdateSequence'
				}
				AppConnector.request(params).then(function(data) {
					thisInstance.getListViewRecords();
				});
			}
		});
	},

	registerEvents : function() {
		this.registerSortableEvent();
	}
});

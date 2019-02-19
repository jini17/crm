/*+***********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
 *************************************************************************************/
var Settings_ManageTerritory_Js = {
	
	//newPriviliges : false,
	//For Add AND Edit link
	triggerShowEditView : function(url) {
		window.location.href = url;
	},
	
	//Savig a new region
	triggerSaveNewRegion : function() {
			var regionname = jQuery('#regionname').val();
			//alert(regionname);
			var params = {
				module: 'ManageTerritory',
				action: 'SaveAjax',
				parent: 'Settings',
				regionname: regionname
			}
			
			AppConnector.request(params).then(function(res) {

				if (res.success) {

					window.location.href = 'index.php?module=ManageTerritory&parent=Settings&view=Edit&record='+res.result;

				}
			});
	},

	//Saaving new Sub Region
	triggerSaveSubRegion : function() {
			var subregionname = jQuery('#subregionname').val();
			var regionid = jQuery('#regionid').val();
			var regiontree = jQuery('#regiontree').val();
			//alert(regionid);
			var params = {
				module: 'ManageTerritory',
				action: 'SaveAjax',
				parent: 'Settings',
				mode: 'savesubregion',
				subregionname: subregionname,
				regionid: regionid,
				regiontree: regiontree
			}
			
			AppConnector.request(params).then(function(res) {

				if (res.success) {
					//alert(res.result);
					window.location.href = 'index.php?module=ManageTerritory&parent=Settings&view=Edit&record='+res.result;

					//alert(app.vtranslate('JS_FAILED_TO_SAVE'));
					//window.location.reload();
				}
			});
	},

	//Delete whole region
	triggerDeleteRegion : function(regionid) {
		var message = app.vtranslate('JS_DELETE_REGION_CONFIRMATION');
		var thisInstance = this;

		var deleteActionUrl = "";
			var params = {
				module: 'ManageTerritory',
				action: 'SaveAjax',
				parent: 'Settings',
				mode: 'deleteregion',
				regionid: regionid
			}
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(function(data) {
		AppConnector.request(params).then(
		function(data){
				var response = data['result'];
				var result   = data['success'];
				if(result == true) {
					params = {
						text: response.msg,
						type:'success'	
					};
				} else {
						params = {
						text: response.msg,
						type:'error'	
					};
				}
				
				Vtiger_Helper_Js.showPnotify(params);

				window.location.reload();
				}
			);
		});
	},
	
	//Delete Sub Region
	triggerDeleteSubRegion : function(regiontree, regionid) {
		var message = app.vtranslate('JS_DELETE_REGION_CONFIRMATION');
		var thisInstance = this;alert(regiontree);alert(regionid);
		var userid = jQuery('#recordId').val();
			var params = {
				module: 'ManageTerritory',
				action: 'SaveAjax',
				parent: 'Settings',
				mode: 'deletesubregion',
				regionid: regionid,
				regiontree: regiontree
			}
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(function(data) {
		AppConnector.request(params).then(
		function(data){
				var response = data['result'];
				var result   = data['success'];
				if(result == true) {
					params = {
						text: response.msg,
						type:'success'	
					};
				} else {
						params = {
						text: response.msg,
						type:'error'	
					};
				}
				
				Vtiger_Helper_Js.showPnotify(params);

				//window.location.reload();
				}
			);
		});
	},
	
	//Delete Sub Region Edit View Handler
	initDeleteView: function() {
		jQuery('#treeDeleteForm').validationEngine(app.validationEngineOptions);
		
		jQuery('[data-action="popup"]').on('click',function(e) {
			e.preventDefault();
			var target = $(e.currentTarget);
			var field  = target.data('field');

			// TODO simiplify by pushing the retrieveSelectedRecords to library
			var popupInstance = Vtiger_Popup_Js.getInstance();
			popupInstance.show(target.data('url'));
			popupInstance.retrieveSelectedRecords(function(data) {
				try {
					data = JSON.parse(data);
				} catch (e) {}
				
				if (typeof data == 'object') {
					jQuery('[name="'+field+'_display"]').val(data.label);
					data = data.value;
				}
				jQuery('[name="'+field+'"]').val(data);
			});
		});
		
		jQuery('#clearRegion').on('click',function(e){
			jQuery('[name="transfer_record_display"]').val('');
		});
	},


	
	initPopupView: function() {
		jQuery('.treeEle').click(function(e){
			var target = $(e.currentTarget);
			// jquery_windowmsg plugin expects second parameter to be string.
			jQuery.triggerParentEvent('postSelection', JSON.stringify({value: target.closest('li').data('treeid'), label: target.text()}));
			self.close();
		});
	},
	
	initEditView: function() {
		
		function applyMoveChanges(treeid, parent_treeid, regionid) {
			var params = {
				module: 'ManageTerritory',
				action: 'MoveAjax',
				parent: 'Settings',
				tree: treeid,
				parent_treeid: parent_treeid,
				regionid: regionid
			}
			
			AppConnector.request(params).then(function(res) {
				if (!res.success) {
					alert(app.vtranslate('JS_FAILED_TO_SAVE'));
					window.location.reload();
				}else{
					params = {
						text: app.vtranslate('JS_SAVE_SUCCESSFULL'),
						type:'success'	
					};
					Vtiger_Helper_Js.showPnotify(params);
				}
			});
		}
		
		jQuery('[rel="tooltip"]').tooltip();
		
		function modalActionHandler(event) {
			var target = $(event.currentTarget);
			app.showModalWindow(null, target.data('url'),function(data){
				Settings_ManageTerritory_Js.initDeleteView();
			});
		}
		
		jQuery('[data-action="modal"]').click(modalActionHandler);
		
		jQuery('.toolbar').hide();
		
		jQuery('.toolbar-handle').bind('mouseover', function(e){
			var target = $(e.currentTarget);
			jQuery('.toolbar', target).css({display: 'inline'});
		});
		jQuery('.toolbar-handle').bind('mouseout', function(e){
			var target = $(e.currentTarget);
			jQuery('.toolbar', target).hide();
		});
		
		jQuery('.draggable').draggable({
			containment: '.treeView',
			start : function(event, ui) {
				var container = jQuery(ui.helper);
				var referenceid = container.data('refid');
				var sourceGroup = jQuery('[data-grouprefid="'+referenceid+'"]');
				var sourceRegionId = sourceGroup.data('treeid');
				if(sourceRegionId == 'H5' || sourceRegionId == 'H2') {
					var params = {};
					params.title = app.vtranslate('JS_PERMISSION_DENIED');
					params.text = app.vtranslate('JS_NO_PERMISSIONS_TO_MOVE');
					params.type = 'error';
					Settings_Vtiger_Index_Js.showMessage(params);
				}
			},
			helper: function(event) {
				var target = $(event.currentTarget);
				var targetGroup = target.closest('li');
				var timestamp = +(new Date());

				var container = $('<div/>');
				container.data('refid', timestamp);
				container.html(targetGroup.clone());

				// For later reference we shall assign the id before we return
				targetGroup.attr('data-grouprefid', timestamp);

				return container;
			}
		});
		jQuery('.droppable').droppable({
			hoverClass: 'btn-primary',
			tolerance: 'pointer',
			drop: function(event, ui) {
				var container = $(ui.helper);
				var referenceid = container.data('refid');
				var sourceGroup = $('[data-grouprefid="'+referenceid+'"]');
				
				var thisWrapper = $(this).closest('div');
				var regionid  = thisWrapper.closest('li').data('regionid');
				var targetRegion  = thisWrapper.closest('li').data('tree');
				var targetRegionId= thisWrapper.closest('li').data('treeid');
				var sourceRegion   = sourceGroup.data('tree');
				var sourceRegionId = sourceGroup.data('treeid');

				// Attempt to push parent-into-its own child hierarchy?
				if (targetRegion.indexOf(sourceRegion) == 0) {
					// Sorry
					return;
				}
				//Attempt to move the ManageTerritory CEO and Sales Person
				if (sourceRegionId == 'H5' || sourceRegionId == 'H2') {
					return;
				}
				sourceGroup.appendTo(thisWrapper.next('ul'));

				applyMoveChanges(sourceRegionId, targetRegionId, regionid);
			}
		});
	},
/*	
	registerShowNewProfilePrivilegesEvent : function() {
		jQuery('[name="profile_directly_related_to_tree"]').on('change',function(e){
			var target = jQuery(e.currentTarget);
			var hanlder = target.data('handler');
			if(hanlder == 'new'){
				Settings_ManageTerritory_Js.getProfilePriviliges();return false;
			}
			var container = jQuery('[data-content="'+ hanlder + '"]');
			jQuery('[data-content]').not(container).fadeOut('slow',function(){
				container.fadeIn('slow');
			});
		})
	},
	
	onLoadProfilePrivilegesAjax : function() {
		jQuery('[name="profile_directly_related_to_tree"]:checked').trigger('change');
	},
	
	getProfilePriviliges : function() {
		var content = jQuery('[data-content="new"]');
		var profileId = jQuery('[name="profile_directly_related_to_tree_id"]').val();
		var params = {
			module : 'Profiles',
			parent: 'Settings',
			view : 'EditAjax',
			record : profileId
		}
		if(Settings_ManageTerritory_Js.newPriviliges == true) {
			jQuery('[data-content="existing"]').fadeOut('slow',function(){
				content.fadeIn('slow');
			});
			return false;
		}
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		AppConnector.request(params).then(function(data) {
			content.find('.fieldValue').html(data);
			app.changeSelectElementView(jQuery('#directProfilePriviligesSelect'), 'select2');
			Settings_ManageTerritory_Js.registerExistingProfilesChangeEvent();
			progressIndicatorElement.progressIndicator({
				'mode' : 'hide'
			});
			Settings_ManageTerritory_Js.newPriviliges = true;
			jQuery('[data-content="existing"]').fadeOut('slow',function(){
				content.fadeIn('slow',function(){
				});
			});
		})
	},
	
	registerExistingProfilesChangeEvent : function() {
		jQuery('#directProfilePriviligesSelect').on('change',function(e) {
			var profileId = jQuery(e.currentTarget).val();
			var params = {
				module : 'Profiles',
				parent: 'Settings',
				view : 'EditAjax',
				record : profileId
			}
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});
			
			AppConnector.request(params).then(function(data) {
				jQuery('[data-content="new"]').find('.fieldValue').html(data);
				progressIndicatorElement.progressIndicator({
					'mode' : 'hide'
				});
				app.changeSelectElementView(jQuery('#directProfilePriviligesSelect'), 'select2');
				Settings_ManageTerritory_Js.registerExistingProfilesChangeEvent();
			});
		});
	},
	
	registerSubmitEvent : function() {
		var thisInstance = this;
		var form = jQuery('#EditView');
		form.on('submit',function(e) {
			if(form.data('submit') == 'true' && form.data('performCheck') == 'true') {
				return true;
			} else {
				if(jQuery('[data-handler="existing"]').is(':checked')){
					var selectElement = jQuery('#profilesList');
					var select2Element = app.getSelect2ElementFromSelect(selectElement);
					var result = Vtiger_MultiSelect_Validator_Js.invokeValidation(selectElement);
					if(result != true){
						select2Element.validationEngine('showPrompt', result , 'error','bottomLeft',true);
						e.preventDefault();
						return;
					} else {
						select2Element.validationEngine('hide');
					}
				} 
				
				if(form.data('jqv').InvalidFields.length <= 0) {
					var formData = form.serializeFormData();
					thisInstance.checkDuplicateName({
						'treename' : formData.treename,
						'record' : formData.record
					}).then(
						function(data){
							form.data('submit', 'true');
							form.data('performCheck', 'true');
							form.submit();
							jQuery.progressIndicator({
								'blockInfo' : {
								'enabled' : true
								}
							});
						},
						function(data, err){
							var params = {};
							params['text'] = data['message'];
							params['type'] = 'error';
							Settings_Vtiger_Index_Js.showMessage(params);
							return false;
						}
					);
				} else {
					//If validation fails, form should submit again
					form.removeData('submit');
					// to avoid hiding of error message under the fixed nav bar
					app.formAlignmentAfterValidation(form);
				}
				e.preventDefault();
			}
		});
	},
*/	
	/*
	 * Function to check Duplication of Region Names
	 * returns boolean true or false
	 */

	checkDuplicateName : function(details) {
		var aDeferred = jQuery.Deferred();
		
		var params = {
		'module' : app.getModuleName(),
		'parent' : app.getParentModuleName(),
		'action' : 'EditAjax',
		'mode'   : 'checkDuplicate',
		'treename' : details.treename,
		'record' : details.record
		}
		
		AppConnector.request(params).then(
			function(data) {
				var response = data['result'];
				var result = response['success'];
				if(result == true) {
					aDeferred.reject(response);
				} else {
					aDeferred.resolve(response);
				}
			},
			function(error,err){
				aDeferred.reject();
			}
		);
		return aDeferred.promise();
	},
	
	registerEvents : function() {
		Settings_ManageTerritory_Js.initEditView();
		//Settings_ManageTerritory_Js.registerShowNewProfilePrivilegesEvent();
		//Settings_ManageTerritory_Js.onLoadProfilePrivilegesAjax();
		//Settings_ManageTerritory_Js.registerSubmitEvent();
	}
}
jQuery(document).ready(function(){
	Settings_ManageTerritory_Js.registerEvents();
})

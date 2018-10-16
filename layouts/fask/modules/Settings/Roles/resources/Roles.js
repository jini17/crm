/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

var Settings_Roles_Js = {


                newPriviliges : false,

        initDeleteView: function() {



                var form = jQuery('#roleDeleteForm');

                var params = {
                        submitHandler : function(form) {
                                var form = jQuery(form);
                                var transferRecordNameEle = jQuery('[name="transfer_record_display"]', form);
                                var transferRecordEle = jQuery('[name="transfer_record"]', form);
                                var transferRecordName = transferRecordNameEle.val();
                                var transferRecordRoleId = transferRecordEle.val();

                                if(transferRecordName === '' || transferRecordRoleId === '') {
                                        transferRecordNameEle.addClass('input-error');
                                        return false;
                                }else {
                                        transferRecordNameEle.removeClass('input-error');
                                }

                                app.helper.showProgress();
                                var formData = form.serializeFormData();

                                app.request.post({'data' : formData}).then(function(err, data){
                                        app.helper.hideProgress();
                                        app.helper.hideModal();
                                        if(err === null){
                                                jQuery('.settingsPageDiv').html(data);
                                                Settings_Roles_Js.initTreeView();
                                        }
                                });

                        }
                };

                form.vtValidate(params);

        //toggle readonly- So validation works for the element
        jQuery('[name="transfer_record_display"]', form).on('focus', function() {
            jQuery(this).prop('readonly',true);
        }).on('focusout', function() {
            jQuery(this).prop('readonly',false);
        });

                jQuery('[data-action="popup"]').on('click',function(e) {
                        e.preventDefault();
                        var target = $(e.currentTarget);
                        var field  = target.data('field');
                        var popupjs = new Vtiger_Popup_Js();

                        var transferRole = function(container) {
                                jQuery('.roleEle', container).click(function(e){
                                        e.preventDefault();
                                        var target = jQuery(e.currentTarget);
                                        var selectedRoledId = target.closest('li').data('roleid');
                                        jQuery('[name="'+field+'_display"]', form).val(target.text());
                     jQuery('.clearReferenceSelection').removeClass('hide');
                                        jQuery('[name="'+field+'"]', form).val(selectedRoledId);
                    jQuery('[name="transfer_record_display"]', form).valid();
                                        app.helper.hidePopup();
                                });
                        };

                        popupjs.showPopup(target.data('url'),'', transferRole);
                });

                jQuery('#clearRole').on('click',function(e){
                        jQuery('[name="transfer_record_display"]', form).val('');
                        jQuery('[name="transfer_record"]', form).val('');
            jQuery('.clearReferenceSelection').addClass('hide');
                });

        },

        initTreeView: function() {

                function applyMoveChanges(roleid, parent_roleid) {
                        var params = {
                                module: 'Roles',
                                action: 'MoveAjax',
                                parent: 'Settings',
                                record: roleid,
                                parent_roleid: parent_roleid
                        }

                        app.request.post({'data' : params}).then(function(err, res) {
                                if (err) {
                                        alert(app.vtranslate('JS_FAILED_TO_SAVE'));
                                        window.location.reload();
                                }
                        });
                }

                function modalActionHandler(event) {
                        var target = $(event.currentTarget);
                        var params = {};
                        params.cb = function(data){
                                Settings_Roles_Js.initDeleteView();
                        };

                        app.request.get({'url' : target.data('url')}).then(function(err, data){
                                if(err === null) {
                                        app.helper.showModal(data, params);
                                }
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
                                var sourceRoleId = sourceGroup.data('roleid');
                                if(sourceRoleId == 'H5' || sourceRoleId == 'H2') {
                                        var params = {};
                                        params.title = app.vtranslate('JS_PERMISSION_DENIED');
                                        params.message = app.vtranslate('JS_NO_PERMISSIONS_TO_MOVE');
                                        app.helper.showErrorNotification(params);
                                }
                        },
                        helper: function(event) {
                                var target = $(event.currentTarget);
                                var targetGroup = target.closest('li');
                                var timestamp = +(new Date());

                                var container = $('<div/>');
                container.css('z-index',1000);
                                container.data('refid', timestamp);
                                container.html(targetGroup.clone());

                                // For later reference we shall assign the id before we return
                                targetGroup.attr('data-grouprefid', timestamp);
                //remove tooltip in the clone
                container.find('.tooltip').remove();
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

                                var targetRole  = thisWrapper.closest('li').data('role');
                                var targetRoleId= thisWrapper.closest('li').data('roleid');
                                var sourceRole   = sourceGroup.data('role');
                                var sourceRoleId = sourceGroup.data('roleid');

                                // Attempt to push parent-into-its own child hierarchy?
                                if (targetRole.indexOf(sourceRole) == 0) {
                                        // Sorry
                                        return;
                                }
                                //Attempt to move the roles CEO and Sales Person
                                if (sourceRoleId == 'H5' || sourceRoleId == 'H2') {
                                        return;
                                }
                                sourceGroup.appendTo(thisWrapper.next('ul'));

                                applyMoveChanges(sourceRoleId, targetRoleId);
                        }
                });
        vtUtils.enableTooltips();
        },

        registerShowNewProfilePrivilegesEvent : function() {
                jQuery('[name="profile_directly_related_to_role"]').on('change',function(e){
                        var target = jQuery(e.currentTarget);
                        var hanlder = target.data('handler');			
                        var container = jQuery('[data-content="'+ hanlder + '"]');

            vtUtils.hideValidationMessage(jQuery('#profilesList'));            
                        if(hanlder === 'new'){
                                Settings_Roles_Js.getProfilePriviliges();
                                return false;
                        }else {
                                jQuery('#profilesList', container).removeClass('hide');
                Settings_Roles_Js.registerProfileEvents();
                        }

                        jQuery('[data-content]').not(container).fadeOut('slow',function(){
                                container.fadeIn('slow');
                        });
                });
        },

    /**
     * To register Profile Edit View Events
     */
        _registeredProfileEvents: false,
    registerProfileEvents : function() {
        if(!this._registeredProfileEvents && typeof window['Settings_Profiles_Edit_Js'] != 'undefined'){ 
            var instance = new Settings_Profiles_Edit_Js();
                        this._registeredProfileEvents = true;
        }
    },

        onLoadProfilePrivilegesAjax : function() {
                jQuery('[name="profile_directly_related_to_role"]:checked').trigger('change');
        },

        getProfilePriviliges : function() { 
                var content = jQuery('[data-content="new"]');
                var profileId = jQuery('[name="profile_directly_related_to_role_id"]').val();
                var plan = jQuery('[name="planid"]').val();

                var params = {
                        data : {
                                module : 'Profiles',
                                parent: 'Settings',
                                view : 'EditAjax',
                                record : profileId,
                                plan:plan
                        }
                }
                if(Settings_Roles_Js.newPriviliges == true) {
                        jQuery('[data-content="existing"]').fadeOut('slow',function(){
                                content.fadeIn('slow');
                        });
                        return false;
                }

                app.helper.showProgress();

                app.request.post(params).then(function(err, data) {
                        app.helper.hideProgress();
                        if(err === null) {
                                content.find('.profileData').html(data);
                                vtUtils.showSelect2ElementView(jQuery('#directProfilePriviligesSelect'));

                                Settings_Roles_Js.newPriviliges = true;
                                jQuery('[data-content="existing"]').fadeOut('slow',function(){
                                        content.fadeIn('slow',function(){
                                        });
                                });
                                Settings_Roles_Js.registerExistingProfilesChangeEvent();
                                 //Settings_Roles_Js.registerProfileEvents();
                                        jQuery('[data-togglehandler]').click(function(e){

                                                                var target = jQuery(e.currentTarget);
                                                                var container = jQuery('[data-togglecontent="'+ target.data('togglehandler') + '"]');
                                                                var closestTrElement = container.closest('tr');

                                                                if (target.find('i').hasClass('fa-chevron-down')) {
                                                                        closestTrElement.removeClass('hide');
                                                                        container.slideDown('slow');
                                                                        target.find('.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                                                                } else {
                                                                        container.slideUp('slow',function(){
                                                                                closestTrElement.addClass('hide');
                                                                        });
                                                                        target.find('.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                                                                }
                                                                                });

                                                                jQuery('[data-range]').each(function(index, item) {
                                                                                item = jQuery(item);
                                                                                if(item.data('locked')){
                                                                                        jQuery('.editViewMiniSlider').css('cursor','pointer');
                                                                                }
                                                                                var value = item.data('value');
                                                                                item.slider({
                                                                                        min: 0,
                                                                                        max: 2,
                                                                                        value: value,
                                                                                        disabled: item.data('locked'),
                                                                                        slide: function(e,ui){
                                                                                                        var target = jQuery(ui.handle);
                                                                                                        if (!target.hasClass('mini-slider-control')) {
                                                                                                                target = target.closest('.mini-slider-control');
                                                                                                        }
                                                                                                        var input  = jQuery('[data-range-input="'+target.data('range')+'"]');
                                                                                                        input.val(ui.value);
                                                                                                        target.attr('data-value', ui.value);
                                                                                        }
                                                                                });
                                                                        });	

                                                                //fix for IE jQuery UI slider
                                                                jQuery('[data-range]').find('a').css('filter','');

                                                                jQuery('[data-module-state]').change(function(e){
                                                                        var target = jQuery(e.currentTarget);
                                                                        var tabid  = target.data('value');

                                                                        var parent = target.closest('tr');
                                                                        var without_first_td  =  parent.not(":eq(0)");
                                                                        if (target.is(':checked')) {
                                                                                jQuery('[data-action-state]', parent).prop('checked', true);
                                                                                jQuery('[data-action-tool="'+tabid+'"]').prop('checked', true);
                                                                                jQuery('[data-handlerfor]', parent).removeAttr('disabled');
                                                                        } else {

                                                                               jQuery('[data-action-state]', parent).prop('checked', false);

                                                                                // Pull-up fields / tools details in disabled state.
                                                                                jQuery('[data-handlerfor]', parent).attr('disabled', 'disabled');
                                                                                jQuery('[data-handlerfor]', parent).find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                                                                                jQuery('[data-togglecontent="'+tabid+'-fields"]').hide();
                                                                                jQuery('[data-togglecontent="'+tabid+'-tools"]').hide();
                                                                                jQuery('[data-togglecontent="'+tabid+'-fields"]').closest('tr').addClass('hide');

                                                                        }
                                                                });

                                                                jQuery('[data-action-state]').change(function(e){ 
                                                                        var target = jQuery(e.currentTarget);
                                                                        var parent = target.closest('tr');
                                                                        var checked = target.prop('checked')? true : false;

                                                                        if (jQuery.inArray(target.data('action-state'), ['CreateView', 'EditView', 'Delete']) != -1) {
                                                                                if (checked) {
                                                                                 jQuery('[data-action-state="DetailView"]', parent).prop('checked', true);
                                                                                    jQuery('[data-action-state="EditView"]', parent).prop('checked', true);
                                                                                   jQuery('[data-module-state]', parent).prop('checked', true);
                                                                                   jQuery('[data-handlerfor]', parent).removeAttr('disabled');
                                                                                }
                                                                        }
                                                                        
                                                                        if(target.data('action-state') == 'DetailView'){
                                                                            if(checked){
                                                                                   jQuery('[data-handlerfor]', parent).removeAttr('disabled');
                                                                                    jQuery('[data-module-state]', parent).prop('checked', true);
                                                                                    
                                                                            }
                                                                            
                                                                            if(!checked){
                                                                                 var lenght = parent.not('td').find("input[checked='true']").length;
                                                                           
                                                                                 if(lenght <3){
                                                                                     jQuery('[data-handlerfor]', parent).attr('disabled','disabled');
                                                                                    jQuery('[data-module-state]', parent).prop('checked', false);
                                                                                     jQuery('[data-action-state="EditView"]', parent).prop('checked', false);
                                                                                 }
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                         if(target.data('action-state') == 'EditView'){
                                                                            if(checked){
                                                                                   jQuery('[data-handlerfor]', parent).removeAttr('disabled');
                                                                                    jQuery('[data-module-state]', parent).prop('checked', true);
                                                                                    jQuery('[data-action-state="DetailView"]', parent).prop('checked', true);
                                                                            }
                                                                            
                                                                            if(!checked){
                                                                                 var lenght = parent.find("input[type='checkbox'").length;
                                                                                alert(lenght);
                                                                                 if(lenght <3){
                                                                                     jQuery('[data-handlerfor]', parent).attr('disabled','disabled');
                                                                                    jQuery('[data-module-state]', parent).prop('checked', false);
                                                                                 }
                                                                                 else{
                                                                                           jQuery('[data-handlerfor]', parent).removeAttr('disabled','disabled');
                                                                                    jQuery('[data-module-state]', parent).prop('checked', true);
                                                                                 }
                                                                            }
                                                                            
                                                                        }
                                                                        
//                                                                        if (target.data('action-state') == 'EditView') {
//                                                                                        var lenght = parent.not('td').find("input[checked='true']").length;
//                                                                                     if (!checked) {
//                                                                                        jQuery('[data-action-state]', parent).prop('checked', false);
//                                                                                           jQuery('[data-action-state="DetailView"]', parent).prop('checked', true);
//                                                                                           jQuery( parent).find('input:first').prop('checked', true);
//                                                                                        jQuery('[data-module-state]', parent).prop('checked', false).trigger('change');
//                                                                             
//                                                                           
//                                                                                 if(lenght <3){
//                                                                                     jQuery('[data-handlerfor]', parent).attr('disabled','disabled');
//                                                                                    jQuery('[data-module-state]', parent).prop('checked', false);
//                                                                                 }
//                                                                                 else{
//                                                                                            jQuery('[data-handlerfor]', parent).removeAttr('disabled','disabled');
//                                                                                    jQuery('[data-module-state]', parent).prop('checked', false);
//                                                                                 }
//
//                                                                                } else {
//                                                                                        jQuery('[data-module-state]', parent).prop('checked', true);
//                                                                                        jQuery('[data-handlerfor]', parent).removeAttr('disabled');
//
//                                                                                }
//                                                                        }
                                                                
                                                                        
                                                                });

                                                                var moduleCheckBoxes = jQuery('.modulesCheckBox');
                                                                var viewAction = jQuery('#mainAction4CheckBox');
                                                                var createAction = jQuery('#mainAction7CheckBox');
                                                                var editAction = jQuery('#mainAction1CheckBox');
                                                                var deleteAction = jQuery('#mainAction2CheckBox');
                                                                var mainModulesCheckBox = jQuery('#mainModulesCheckBox');
                                                                mainModulesCheckBox.on('change',function(e) {
                                                                        var mainCheckBox = jQuery(e.currentTarget);
                                                                        if(mainCheckBox.is(':checked')){
                                                                                moduleCheckBoxes.prop('checked',true);
                                                                                viewAction.prop('checked',true);
                                                                                createAction.show().prop('checked',true);
                                                                                editAction.show().prop('checked',true);
                                                                                deleteAction.show().prop('checked',true);
                                                                                moduleCheckBoxes.trigger('change');
                                                                        } else {
                                                                                moduleCheckBoxes.filter(':visible').not(':disabled').prop('checked',false);
                                                                                moduleCheckBoxes.trigger('change');
                                                                                viewAction.prop('checked',false);
                                                                                createAction.prop('checked', false);
                                                                                editAction.prop('checked', false);
                                                                                deleteAction.prop('checked', false);
                                                                        }
                                                                });

                                                                viewAction.on('change',function(){
                                                                        Settings_Roles_Js.registerSelectAllViewActionsEvent();
                                                                });
                                                                createAction.on('change',function(){
                                                                        Settings_Roles_Js.registerSelectAllCreateActionsEvent();
                                                                });
                                                                editAction.on('change',function(){
                                                                        Settings_Roles_Js.registerSelectAllEditActionsEvent();
                                                                });
                                                                deleteAction.on('change',function(){
                                                                        Settings_Roles_Js.registerSelectAllDeleteActionsEvent();
                                                                });


                                        }else {
                                                app.helper.showErrorNotification({'message' : err.message});
                                        }
                });
        },

        registerSelectAllViewActionsEvent : function() {
                var viewActionCheckBoxes = jQuery('.action4CheckBox');
                var mainViewActionCheckBox = jQuery('#mainAction4CheckBox');
                var modulesMainCheckBox = jQuery('#mainModulesCheckBox');

                mainViewActionCheckBox.on('change',function(e){
                        var mainCheckBox = jQuery(e.currentTarget);
                        if(mainCheckBox.is(':checked')){
                                modulesMainCheckBox.prop('checked',true);
                                modulesMainCheckBox.trigger('change');
                        } else {
                                modulesMainCheckBox.prop('checked',false);
                                modulesMainCheckBox.trigger('change');
                        }
                });

                viewActionCheckBoxes.on('change',function() {
                        Settings_Roles_Js.checkSelectAll(viewActionCheckBoxes,mainViewActionCheckBox);
                });

        },

        registerSelectAllCreateActionsEvent : function() {
                var createActionCheckBoxes = jQuery('.action7CheckBox');
                var mainCreateActionCheckBox = jQuery('#mainAction7CheckBox');
                mainCreateActionCheckBox.on('change', function (e) {
                        var mainCheckBox = jQuery(e.currentTarget);
                        if (mainCheckBox.is(':checked')) {
                                createActionCheckBoxes.prop('checked', true);
                        } else {
                                createActionCheckBoxes.prop('checked', false);
                        }
                });
                createActionCheckBoxes.on('change', function () {
                        Settings_Roles_Js.checkSelectAll(createActionCheckBoxes, mainCreateActionCheckBox);
                });

        },

        registerSelectAllEditActionsEvent : function() {
                var createActionCheckBoxes = jQuery('.action1CheckBox');
                var mainCreateActionCheckBox =  jQuery('#mainAction1CheckBox');
                mainCreateActionCheckBox.on('change',function(e){
                        var mainCheckBox = jQuery(e.currentTarget);
                        if(mainCheckBox.is(':checked')){
                                createActionCheckBoxes.prop('checked',true);
                        } else {
                                createActionCheckBoxes.prop('checked',false);
                        }
                });
                createActionCheckBoxes.on('change',function() {
                        Settings_Roles_Js.checkSelectAll(createActionCheckBoxes,mainCreateActionCheckBox);
                });

        },

        registerSelectAllDeleteActionsEvent : function() {
                var deleteActionCheckBoxes = jQuery('.action2CheckBox');
                var mainDeleteActionCheckBox =  jQuery('#mainAction2CheckBox');
                mainDeleteActionCheckBox.on('change',function(e){
                        var mainCheckBox = jQuery(e.currentTarget);
                        if(mainCheckBox.is(':checked')){
                                deleteActionCheckBoxes.prop('checked',true);
                        } else {
                                deleteActionCheckBoxes.prop('checked',false);
                        }
                });
                deleteActionCheckBoxes.on('change',function() {
                        Settings_Roles_Js.checkSelectAll(deleteActionCheckBoxes,mainDeleteActionCheckBox);
                });
        },

        checkSelectAll : function(checkBoxElement,mainCheckBoxElement){
                var state = true;
                if(typeof checkBoxElement == 'undefined' || typeof mainCheckBoxElement == 'undefined'){
                        return false;
                }
                checkBoxElement.each(function(index,element){
                        if(jQuery(element).is(':checked')){
                                state = true;
                        }else{
                                state = false;
                                return false;
                        }
                });
                if(state == true){
                        mainCheckBoxElement.prop('checked',true);
                } else {
                        mainCheckBoxElement.prop('checked', false);
                }
        },

        registerExistingProfilesChangeEvent : function() {
                jQuery('#directProfilePriviligesSelect').on('change',function(e) {

                        var profileId = jQuery(e.currentTarget).val();
                        var params = {
                                module : 'Profiles',
                                parent: 'Settings',
                                view : 'EditAjax',
                                record : profileId
                        };
                        app.helper.showProgress();

                        app.request.get({'data' : params}).then(function(err, data) {
                                app.helper.hideProgress();
                                if(err === null) {
                                        jQuery('[data-content="new"]').find('.profileData').html(data);
                                        vtUtils.showSelect2ElementView(jQuery('#directProfilePriviligesSelect'));
                                        Settings_Roles_Js.registerExistingProfilesChangeEvent();
                                   Settings_Roles_Js.registerProfileEvents();
                                }
                        });
                });
        },


        registerAllowModulePermission : function() {
                jQuery('#planFilter').on('change',function(e) {
                        var planid = jQuery(e.currentTarget).val();
                        var params = {
                                module : 'Profiles',
                                parent: 'Settings',
                                view : 'EditAjax',
                                plan : planid

                        };
                        app.helper.showProgress();

                        app.request.get({'data' : params}).then(function(err, data) { 

                                app.helper.hideProgress();
                                     //alert(data);
                                if(err === null) {
                                        jQuery('[data-content="new"]').find('.profileData').html(data);
                                        //vtUtils.showSelect2ElementView(jQuery('#directProfilePriviligesSelect'));
                                    //Settings_Roles_Js.registerExistingProfilesChangeEvent();
                    Settings_Roles_Js.registerProfileEvents();
                                }
                        });
                });
        },

        registerSubmitEvent : function() {
                var thisInstance = this;
                var form = jQuery('[name="EditRole"]');

                var params = {
                        submitHandler : function(data) {
                jQuery("button[name='saveButton']").attr("disabled","disabled");
                                var form = jQuery(data);
                                if(form.data('submit') == 'true' && form.data('performCheck') == 'true') {
                                        return true;
                                } else {
                                        if(this.numberOfInvalids() <= 0) {
                                                app.helper.showProgress();
                                                var formData = form.serializeFormData();

                                                thisInstance.checkDuplicateName({
                                                        'rolename' : formData.rolename,
                                                        'record' : formData.record
                                                }).then(
                                                        function(data){
                                                                app.helper.showProgress();
                                                                form.data('submit', 'true');
                                                                form.data('performCheck', 'true');

                                                                app.request.post({'data' : formData}).then(function(err, data){
                                                                        app.helper.hideProgress();
                                                                        if(err === null ){
                                                                                window.history.back();
                                                                        }else {

                                                                        }
                                                                });
                                                        },
                                                        function(err){
                                                                app.helper.hideProgress();
                                                                app.helper.showErrorNotification({'message' : err.message});
                                                        });
                                        } else {
                                                //If validation fails, form should submit again
                                                form.removeData('submit');
                                        }
                                }
                        }
                };

                form.vtValidate(params);
        },

        /*
         * Function to check Duplication of Role Names
         * returns boolean true or false
         */

        checkDuplicateName : function(details) {
                var aDeferred = jQuery.Deferred();

                var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'action' : 'EditAjax',
                'mode'   : 'checkDuplicate',
                'rolename' : details.rolename,
                'record' : details.record
                };

                app.request.get({'data' : params}).then(
                        function(err, response) {
                                if(err === null) {
                                        var result = response['success'];
                                        if(result === true) {
                                                aDeferred.reject(response);
                                        } else {
                                                aDeferred.resolve(response);
                                        }
                                }
                        });
                return aDeferred.promise();
        },

        registerEvents : function() {
        var view = app.view();
        if(view === 'Index') {

            Settings_Roles_Js.initTreeView();
        } else if(view === 'Edit') {
            Settings_Roles_Js.registerShowNewProfilePrivilegesEvent();
            Settings_Roles_Js.onLoadProfilePrivilegesAjax();
            Settings_Roles_Js.registerSubmitEvent();
            Settings_Roles_Js.registerAllowModulePermission();
        }

        }
};

Vtiger.Class("Settings_Roles_Index_Js",{},{
        init : function() {
                this.addComponents();
                Settings_Roles_Js.registerEvents();
        },

        addComponents : function() {
                this.addModuleSpecificComponent('Index','Vtiger',app.getParentModuleName());
        }
});

Vtiger.Class("Settings_Roles_Edit_Js",{},{
        init : function() {
                this.addComponents();
                Settings_Roles_Js.registerEvents();
        },

        addComponents : function() {
                this.addModuleSpecificComponent('Index','Vtiger',app.getParentModuleName());
        }
});

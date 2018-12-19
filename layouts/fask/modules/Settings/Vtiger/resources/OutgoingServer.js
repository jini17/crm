/**
 * Created by Mabruk Khan and Nirbhay Khan
 */

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_OutgoingServer_Js",{},{


    /**
     * Function to load the contents from the url through pjax
     * Create by Nirbhay to reload the content
     */
    loadContents : function(url) {
        var aDeferred = jQuery.Deferred();
        AppConnector.requestPjax(url).then(
            function(data){
                aDeferred.resolve(data);
            },
            function(error, err){
                aDeferred.reject();
            }
        );
        return aDeferred.promise();
    },


    /**
     * Function created by Nirbhay to get all the checked values in the array form
     */

    getAllCheckedValues : function (){
        var chkArray = [];
        jQuery(".smallchkd:checked").each(function() {
            chkArray.push(jQuery(this).val());
        });

        var selected;
        selected = chkArray.join(',') ;
        return selected;

    },



    /**
     * Function created by Nirbhay to delete the values
     */
    registerDeleteButton : function() {
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();

        jQuery("#deleteItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#deleteItem").click(function () {
            var selectedvalues = thisInstance.getAllCheckedValues();
            
            if (selectedvalues.length > 0) {
                var params = {
                    'module' : app.getModuleName(),
                    'parent' : app.getParentModuleName(),
                    'action' : 'DeleteOutgoingServers',
                    'values' : selectedvalues
                }

                AppConnector.request(params).then(
                    function() {
                        var url = "?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=8&fieldid=15";
                        thisInstance.loadContents(url).then(function(data){
                            jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                            thisInstance.registerEvents();
                            app.helper.showSuccessNotification({"message":"Deleted Successfully"});
                        });
                        aDeferred.resolve();
                    },
                    function(error,err){
                        aDeferred.reject();
                    }
                );
            }            
            else 
                app.helper.showAlertBox({"message":"Select atleast one record"});
            return aDeferred.promise();
        });
    },

    /**
     * Added By Mabruk and Nirbhay to add Outgoing Servers
     */
    registerAddButton: function(){
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();

        jQuery("#addItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addItem").click(function () {

            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AddOutgoingServer',
                'mode' : 'LoadRules'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    history.pushState({}, null, window.history.back());
                    thisInstance.saveRule();
                    jQuery('#TypeOfOutgoing').unbind('click');
                    jQuery("#TypeOfOutgoing").click(function () {
                        var typeofoutgoing = jQuery('#TypeOfOutgoing :selected').val();
                        if(typeofoutgoing == 'Gmail'){
                            jQuery('#host').val('ssl://smtp.gmail.com:465');
                        }
                        else if(typeofoutgoing == 'Office365'){
                            jQuery('#host').val('tls://smtp.office365.com:587');
                        }else{
                            jQuery('#host').val('');
                        }
                    });
                });

        });
        return aDeferred.promise();
    },

    /**
     * Added By Mabruk and Nirbhay to edit Outgoing Servers
     */
    registerEditButton: function(){
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();

        jQuery("#editItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#editItem").click(function () {
            var checkedData = thisInstance.getAllCheckedValues();
            if (checkedData.indexOf(',') > -1 || checkedData == '' || checkedData == null)
                app.helper.showAlertBox({"message":"Incorrect number of selected records"});
            else {
                //app.helper.showProgress();
                var params = {
                    'module' : app.getModuleName(),
                    'parent' : app.getParentModuleName(),
                    'view'   : 'AddOutgoingServer',
                    'mode'   : 'editForm',
                    'id' : checkedData
                }
                AppConnector.requestPjax(params).then(
                    function(data) {
                        //app.helper.hideProgress();
                        app.helper.showModal(data);
                        history.pushState({}, null, window.history.back());
                        thisInstance.saveRule(true,checkedData);
                        jQuery('#TypeOfOutgoing').unbind('click');
                        jQuery("#TypeOfOutgoing").click(function () {
                            var typeofoutgoing = jQuery('#TypeOfOutgoing :selected').val();
                            if(typeofoutgoing == 'Gmail'){
                                jQuery('#host').val('ssl://smtp.gmail.com:465');
                            }
                            else if(typeofoutgoing == 'Office365'){
                                jQuery('#host').val('tls://smtp.office365.com:587');
                            }else{
                                jQuery('#host').val('');
                            }
                        });
                    });
            }
            return aDeferred.promise();
        });        
    },

    /**
     * Added By Mabruk and Nirbhay to get From Mail list
     */
    registerFromMailButton: function(){
        var thisInstance = this;
        var aDeferred = jQuery.Deferred(); 

        jQuery(".showFromAddress").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery(".showFromAddress").click(function () {
            app.helper.showProgress();
            var serverId = jQuery(this).val();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AddOutgoingServer',
                'mode' : 'fromAddressFunction',
                'serverid' : serverId
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    history.pushState({}, null, window.history.back());
                    thisInstance.fromMailAddressFeatures(serverId);
                    thisInstance.registerDeleteButton()
                });
        });
        return aDeferred.promise();
    },

    /**
     * Added By Mabruk to Show/hide Add From Email form, delete and reload From Email list
     */
    fromMailAddressFeatures: function(serverId){
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        var addButton = jQuery("#addFromAddress");
        var editButton = jQuery("#editFromAddress");
        var saveButton = jQuery(".saveFromAddress"); 
        var cancel = jQuery('.cancelForm');
        var name = jQuery("#name");
        var email = jQuery("#email");
        var form = jQuery('.addFromAddressForm');
        
        form.hide();

        //Register Add Button for FromEmailAddress Form    
        addButton.unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        addButton.click(function () {
            
            form.show();

            name.val('');
            email.val('');

            saveButton.unbind('click'); /**Unbinded to avoid infinite loop on every register***/
            saveButton.click( function() { 
                var formData = form.serializeArray();  
                var params = {
                    'module' : app.getModuleName(),
                    'parent' : app.getParentModuleName(),
                    'view' : 'AddOutgoingServer',
                    'mode' : 'fromAddressFunction',
                    'task' : 'add',
                    'form' : formData,
                    'serverid' : serverId
                }
                AppConnector.requestPjax(params).then(
                    function(data) { 
                        form.hide();
                        jQuery('.listFromAddress').html(data);                    
                });
            });

            cancel.click( function() { 
                form.hide();
            });
        });

        //Register Edit Button for FromEmailAddress Form    
        editButton.unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        editButton.click(function () { 
            var checkedData = thisInstance.getAllCheckedValues();

            if (checkedData.indexOf(',') > -1 || checkedData == '' || checkedData == null)
                app.helper.showAlertBox({"message":"Incorrect number of selected records"});
            else {           
                form.show();

                var params = {
                    'module' : app.getModuleName(),
                    'parent' : app.getParentModuleName(),
                    'view'   : 'AddOutgoingServer',
                    'mode'   : 'editFromEmailAddress',
                    'id' : checkedData
                }

                AppConnector.request(params).then(
                    function(data) {                             
                        var dataName = data.result.name;
                        var dataEmail = data.result.email;
                        name.val(dataName);
                        email.val(dataEmail);                 
                });


                saveButton.unbind('click'); /**Unbinded to avoid infinite loop on every register***/
                saveButton.click( function() { 
                    var formData = form.serializeArray();  
                    var params = {
                        'module' : app.getModuleName(),
                        'parent' : app.getParentModuleName(),
                        'view' : 'AddOutgoingServer',
                        'mode' : 'fromAddressFunction',
                        'task' : 'edit',
                        'id' : checkedData,
                        'form' : formData,
                        'serverid' : serverId
                    }
                    AppConnector.requestPjax(params).then(
                        function(data) {                             
                            form.hide();
                            jQuery('.listFromAddress').html(data);                    
                    });
                });

                cancel.click( function() { 
                    form.hide();
                });
            }
        });

        //Register Delete Button for FromEmailAddress Form
        jQuery(".deleteFromEmail").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery(".deleteFromEmail").click(function () {             
            var checkedData = thisInstance.getAllCheckedValues();

            if (checkedData.length > 0) {  
                var params = {
                    'module' : app.getModuleName(),
                    'parent' : app.getParentModuleName(),
                    'view' : 'AddOutgoingServer',
                    'mode' : 'fromAddressFunction',
                    'task' : 'delete',
                    'checkedData' : checkedData,
                    'serverid' : serverId
                }
                AppConnector.requestPjax(params).then(
                    function(data) { 
                        form.hide();
                        app.helper.showSuccessNotification({"message":"Deleted Successfully"});
                        jQuery('.listFromAddress').html(data);             
                });
            }
            else 
                app.helper.showAlertBox({"message":"Select atleast one record"});
        });

        return aDeferred.promise();
    },    

    /**
     * Function to save a particular rule
     */

    saveRule: function(edit = false, id = false){
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;

        jQuery(document).ready(function () {
            jQuery(document).off('click',"#saveButtonRule"); /**Unbinded to avoid infinite loop on every register***/
            jQuery(document).on('click', "#saveButtonRule", function () {
                var form = jQuery('#outgoingServer').serializeArray();
                if (edit == true)
                    var params = {
                        'module' : 'Vtiger',
                        'parent' : 'Settings',
                        'view'   : 'AddOutgoingServer',
                        'mode'   : 'AddServer',
                        'form'   : form,
                        'type'   : 'edit',
                        'id'     : id
                    };
                else        
                    var params = {
                        'module' : 'Vtiger',
                        'parent' : 'Settings',
                        'view'   : 'AddOutgoingServer',
                        'mode'   : 'AddServer',
                        'form'   : form,
                        'type'   : 'Add'
                    };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                        if(data=='success'){
                            var url = "?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=8&fieldid=15";
                            thisInstance.loadContents(url).then(function(data){
                                console.log(data);

                                jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                                app.hideModalWindow();
                                thisInstance.registerEvents();
                                app.helper.showSuccessNotification({"message":"Action successful"});
                            });

                            aDeferred.resolve(data);
                            return;
                        }
                        else{
                            app.hideModalWindow();
                            app.helper.showErrorNotification({"message":err});
                            thisInstance.registerEvents();
                            aDeferred.reject(data);
                            return;
                        }
                    });
            });
        });

        aDeferred.promise();
    },
    registerEvents: function() {
        this.registerDeleteButton();
        this.registerAddButton();
        this.registerEditButton();
        this.registerFromMailButton();
    }

});

jQuery(document).ready(function(e){
    var tacInstance = new Settings_Vtiger_OutgoingServer_Js();
    var vtigerinst = new Vtiger_Index_Js();
    vtigerinst.registerEvents();
    tacInstance.registerEvents();
    //Added By Mabruk
    var vtigerSettings = new Settings_Vtiger_Index_Js();
    vtigerSettings.registerAccordionClickEvent();
})






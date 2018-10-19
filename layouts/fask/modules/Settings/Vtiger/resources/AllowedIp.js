/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_AllowedIp_Js",{},{


    /**
     * Function to load the contents from the url through pjax
     * Create by Nirbhay to reload the content
     */
    loadContents : function(url) {
        var aDeferred = jQuery.Deferred();
        AppConnector.requestPjax(url).then(
            function(data){
                var blocksList = jQuery(".contents.tabbable.clearfix");

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
            app.helper.showProgress();
            var selectedvalues = thisInstance.getAllCheckedValues();

            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'action' : 'DeleteAllowedIp',
                'values' : selectedvalues
            }

            AppConnector.request(params).then(
                function() {
                    var url = "?module=Vtiger&parent=Settings&view=AllowedIpDetailView&block=8&fieldid=47";
                    thisInstance.loadContents(url).then(function(data){
                        app.helper.hideProgress();
                        jQuery(".settingsPageDiv.content-area.clearfix").html(data);

                        thisInstance.registerEvents();
                        app.helper.showSuccessNotification({"message":"Deleted Result Successfully"});
                    });
                    aDeferred.resolve();

                },
                function(error,err){
                    aDeferred.reject();
                }
            );

            return aDeferred.promise();

        });
    },

    /**
     * Added By Nirbhay to add a value
     */
    registerAddButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#addItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addItem").click(function () {
           // console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AddRule',
                'mode' : 'LoadRules'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    thisInstance.saveRule();


                    // var thisInstance1 = this;


                });

        });
        return aDeferred.promise();
    },

    /**
     * Function to save a particular rule
     */

    saveRule: function(){
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;

        jQuery(document).ready(function () {
            jQuery(document).off('click',"#saveButtonRule"); /**Unbinded to avoid infinite loop on every register***/
            jQuery(document).on('click', "#saveButtonRule", function () {
                var form = jQuery('#AddRule').serializeArray();

                if(jQuery("#EditAllowedIPContainer").length >0){
                    mode = 'UpdateRule'
                }else{
                    mode = 'AddRule';
                }
                var params = {
                    'module' : 'Vtiger',
                    'parent' : 'Settings',
                    'view' : 'AddRule',
                    'mode'   : mode,
                    'form' : form


                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                        if(data=='success'){
                            //console.log(data);
                            var url = "?module=Vtiger&parent=Settings&view=AllowedIpDetailView&block=8&fieldid=47";
                            thisInstance.loadContents(url).then(function(data){
                                jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                                app.hideModalWindow();
                                thisInstance.registerEvents();
                                app.helper.showSuccessNotification({"message":"Successfully Added"});
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

    /**
     * Function Added to make ajax call on default button
     */

    registerDefaultButton : function(){
        var thisInstance = this;
        jQuery("#NotAllowed").hide();
        jQuery("#Allowed").hide();

        var checked = jQuery("input[id=defaultvalue]:checked").length;
        if(checked==0){
            jQuery("#Allowed").show();
            jQuery("#NotAllowed").hide();
        }else{
            jQuery("#NotAllowed").show();
            jQuery("#Allowed").hide();
        }

        jQuery(document).ready(function () {
            var checked = jQuery("input[id=defaultvalue]:checked").length;
            jQuery("#defaultvalue").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
            jQuery("#defaultvalue").click(function () {
                    var params = {
                        'module' : 'Vtiger',
                        'parent' : 'Settings',
                        'view'   : 'AllowedIPTools',
                        'values' : checked,
                        'mode'   : 'DefaultToggle'
                    };
                    app.helper.showProgress();

                    app.request.post({'data' : params}).then(
                        function(err, data) {
                            app.helper.hideProgress();
                            if(data=='success'){
                                //console.log(data);
                                var url = "?module=Vtiger&parent=Settings&view=AllowedIpDetailView&block=8&fieldid=47";
                                thisInstance.loadContents(url).then(function(data){
                                    jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                                    app.hideModalWindow();
                                    thisInstance.registerEvents();
                                    app.helper.showSuccessNotification({"message":"Successfully Added"});
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
                    if(checked==0){
                       jQuery("#Allowed").show();
                       jQuery("#NotAllowed").hide();
                   }else{
                       jQuery("#NotAllowed").show();
                       jQuery("#Allowed").hide();
                   }
                });
        });

    },

    /**
     * Added By Nirbhay to add a value
     */
    registerEditButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#editItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/

        jQuery("#editItem").click(function () {
            var selectedvalues = thisInstance.getAllCheckedValues();
            if(selectedvalues < 1){
                alert("Invalid Selection");
                return aDeferred.promise();
            }


            //console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AllowedIPTools',
                'values' : selectedvalues,
                'mode' : 'EditAllowedIPForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    thisInstance.saveRule();
                    history.pushState({}, null, window.history.back());


                    // var thisInstance1 = this;


                });

        });
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

    registerEvents: function() {
        this.registerDeleteButton();
        this.registerAddButton();
        this.registerDefaultButton();
        this.registerEditButton();
    }

});

jQuery(document).ready(function(e){
    var tacInstance = new Settings_Vtiger_AllowedIp_Js();
    var vtigerinst = new Vtiger_Index_Js();
    vtigerinst.registerEvents();
    tacInstance.registerEvents();

})





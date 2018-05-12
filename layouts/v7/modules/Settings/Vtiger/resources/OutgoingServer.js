/**
 * Created by Mabruk Khan and Nirbhay Shah
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
                //var blocksList = jQuery(".contents.tabbable.clearfix");
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
                'action' : 'DeleteOutgoingServers',
                'values' : selectedvalues
            }

            AppConnector.request(params).then(
                function() {
                    var url = "?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=8&fieldid=15";
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
     * Added By Mabruk and Nirbhay to add Outgoing Servers
     */
    registerAddButton: function(){
        //alert("Same name na aee aee, waka waka aee aee");
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();

        jQuery("#addItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addItem").click(function () {

            // console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AddOutgoingServer',
                'mode' : 'LoadRules'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
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
     * Added By Mabruk and Nirbhay to get From Mail list
     */
    registerFromMailButton: function(){
        //alert("Same name na aee aee, waka waka aee aee");
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();

        jQuery(".addFromAddress").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery(".addFromAddress").click(function () {
            // console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AddOutgoingServer',
                'mode' : 'LoadFromAddress',
                'serverid' : jQuery(this).val()
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    //thisInstance.saveRule();

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
                var form = jQuery('#outgoingServer').serializeArray();
                var params = {
                    'module' : 'Vtiger',
                    'parent' : 'Settings',
                    'view' : 'AddOutgoingServer',
                    'mode'   : 'AddServer',
                    'form' : form
                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                        if(data=='success'){
                            //console.log(data);
                            var url = "?parent=Settings&module=Vtiger&view=OutgoingServerDetail&block=8&fieldid=15";
                            thisInstance.loadContents(url).then(function(data){
                                console.log(data);

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
    registerEvents: function() {
        this.registerDeleteButton();
        this.registerAddButton();
        this.registerFromMailButton();

    }

});

jQuery(document).ready(function(e){
    //alert("Aku aku");
    var tacInstance = new Settings_Vtiger_OutgoingServer_Js();
    tacInstance.registerEvents();
})






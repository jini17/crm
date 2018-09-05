/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_Allocation_Js",{},{


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
          
            var selectedvalues = thisInstance.getAllCheckedValues();
		
		    if(selectedvalues < 1){
                alert("Invalid Selection");
                return aDeferred.reject();
            }
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AllocationTools',
                'values' : selectedvalues,
                'mode'  : 'DeleteAllocation'
            }

            AppConnector.request(params).then(
                function() {
                    var url = "?module=Vtiger&parent=Settings&view=AllocationListView&block=14&fieldid=49";
                    thisInstance.loadContents(url).then(function(data){
                        app.helper.hideProgress();
                        jQuery(".settingsPageDiv.content-area.clearfix").html(data);

                        thisInstance.registerEvents();
                        app.helper.showSuccessNotification({"message":"Records deleted successfully"});
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
                'view' : 'AllocationTools',
                'values' : selectedvalues,
                'mode' : 'EditAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    history.pushState({}, null, window.history.back());
                    thisInstance.saveRule();
                    thisInstance.autoAddMultipleLeavetype();
                    thisInstance.showLeaveTypeEditAddition();

                    // var thisInstance1 = this;


                });

        });
        return aDeferred.promise();
    },


    /**
     * Added By Nirbhay to add a value
     */
    registerAddButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#addItem").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addItem").click(function () {
            //console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AllocationTools',
                'mode' : 'AddAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    thisInstance.saveRule();
                    thisInstance.showLeaveTypeAddition();
                    thisInstance.addMultipleLeavetype();
                    history.pushState({}, null, window.history.back());


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
              //  alert("Here");
                var form = jQuery('#AddAllocation').serializeArray();


                if(jQuery("#EditAllocationContainer").length >0){
                    mode = 'UpdateAllocation'
                }else{
                    mode = 'AddAllocation';
                }

                var params = {
                    'module' : 'Vtiger',
                    'parent' : 'Settings',
                    'view' : 'AllocationTools',
                    'mode'   : mode,
                    'form' : form


                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                        if(data=='success'){
                            //console.log(data);
                            var url = "?module=Vtiger&parent=Settings&view=AllocationListView&block=14&fieldid=49";
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
     * Added By Nirbhay to show and hide leave allocation
     */
    showLeaveTypeAddition: function(){

        var thisInstance = this;
            //LeaveTypeAllocation
        jQuery("#LeaveTypeAllocation").hide();
        jQuery("#AllocateLeave").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#AllocateLeave").click(function () {
            //console.log("add item");
            if(jQuery("#AllocateLeave:checkbox:checked").length>0){
                jQuery("#LeaveTypeAllocation").show();
            }
            else{
                jQuery("#LeaveTypeAllocation").hide();

            }
        });

    },

    /**
     * Added By Nirbhay to show and hide leave allocation
     */
    showLeaveTypeEditAddition: function(){

        var thisInstance = this;
        jQuery("#EditLeaveTypeAllocation").hide();
        jQuery("#EditAllocateLeave").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#EditAllocateLeave").click(function () {
            if(jQuery("#EditAllocateLeave:checkbox:checked").length>0){
                jQuery("#EditLeaveTypeAllocation").show();
            }
            else{
                jQuery("#EditLeaveTypeAllocation").hide();

            }
        });

    },


    /**
     * Added By Nirbhay to add leavetype allocation
     */
    addMultipleLeavetype: function(){
        var counter=0;
        var thisInstance = this;
         jQuery("#AddLeavetype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#AddLeavetype").click(function () {
            counter++;
            var dropdownvalues_en = jQuery("#dropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);


            var element ='<div id="Leavetypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype'+ counter +'" name="Allocation_leavetype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Leavetypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;<input type="text" placeholder="" id="ageleave'+ counter +'" name="ageleave'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesless'+ counter +'" name="numberofleavesless'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesmore'+ counter +'" name="numberofleavesmore'+ counter +'" style="width: 50px;"></div></div>';

            element = element + '</div>';

            jQuery("#LeaveTypeAllocation").append(element);
        });

    },

    /**
     * Auto Add Multiple Leave type for Edit View Form
     */
    autoAddMultipleLeavetype: function(){
        var counter=0;
        var thisInstance = this;

        var exisitngvals_en = jQuery('#EditallocatedLeaveTypeValues').val();
        var exisitngvals = jQuery.parseJSON(exisitngvals_en);
        for(var j=0;j<exisitngvals.length;j++){
            counter++;
            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            var element ='<div id="Leavetypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype'+ counter +'" name="Allocation_leavetype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                if(dropdownvalues[i]['id'] == exisitngvals[j]['leavetype_id']){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + ' selected>'+ dropdownvalues[i]['title'] +'</option>';
                }else{
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>';

                }
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Leavetypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;<input type="text" placeholder="" id="ageleave'+ counter +'" name="ageleave'+ counter +'" style="width: 50px;" value='+ exisitngvals[j]['ageleave'] +'>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesless'+ counter +'" name="numberofleavesless'+ counter +'" style="width: 50px;" value='+ exisitngvals[j]['numberofleavesless'] +'>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesmore'+ counter +'" name="numberofleavesmore'+ counter +'" style="width: 50px;" value='+ exisitngvals[j]['numberofleavesmore'] +'></div></div>';

            element = element + '</div>';

            jQuery("#EditLeaveTypeAllocation").append(element);
        }


        jQuery("#EditAddLeavetype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#EditAddLeavetype").click(function () {
            counter++;

            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            var element ='<div id="Leavetypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype'+ counter +'" name="Allocation_leavetype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Leavetypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;<input type="text" placeholder="" id="ageleave'+ counter +'" name="ageleave'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesless'+ counter +'" name="numberofleavesless'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesmore'+ counter +'" name="numberofleavesmore'+ counter +'" style="width: 50px;"></div></div>';

            element = element + '</div>';

            jQuery("#EditLeaveTypeAllocation").append(element);
        });

    },


    registerEvents: function() {
        this.registerDeleteButton();
        this.registerAddButton();
        this.registerEditButton();

    }

});

jQuery(document).ready(function(e){
    var tacInstance = new Settings_Vtiger_Allocation_Js();
    var vtigerinst = new Vtiger_Index_Js();
    vtigerinst.registerEvents();
    tacInstance.registerEvents();

})

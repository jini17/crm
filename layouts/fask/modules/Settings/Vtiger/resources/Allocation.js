/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_Allocation_Js",{

     checkContractStatus : function(){ 
        var aDeferred = jQuery.Deferred();
        
        app.helper.showProgress();
        //first check the how many employee missing active contract  
          var checkparams = {
                'module' : 'Vtiger',
                'parent' : app.getParentModuleName(),
                'view'   : 'AllocationTools',
                'mode'   : 'CheckEmployeeContracts'
            }
          app.request.post({'data' : checkparams}).then(
                 function(err, data) { 
                    //console.log("Inside pjax");
                   app.helper.hideProgress();
                   jQuery('#myModal').modal('show');
                   jQuery(".checkleavestatus").html('System checking...');
                   jQuery(".checkleavestatus").attr('disabled',true);
                   jQuery(".modal-body").html(data);
                });

        return aDeferred.promise();
      },
      
      registerExecuteYND : function(){
          var thisInstance = this;
          var aDeferred = jQuery.Deferred();
          jQuery(".ynd").hide();
          var module = app.getModuleName();
          app.helper.showProgress();
          var params = {
               'module' : app.getModuleName(),
               'parent' : app.getParentModuleName(),
               'action' : 'RunYndProcess'
           }
           
           app.request.post({'data' : params}).then(
                 function(err, data) { 
                   jQuery('#myModal').modal('hide');
                   app.helper.hideProgress();
                   app.helper.showSuccessNotification({"message":"Leave allocation done successfully!!"});
                    
                    //Refresh the grid after allocation
                    var forfit = 0;
                    if(jQuery('#forfit').is(':checked')){
                        forfit = 1;
                    }
                    var checkparams = {
                          'module' : 'Vtiger',
                          'parent' : app.getParentModuleName(),
                          'view'   : 'BalanceLeave',
                          'mode'   : 'filterLeaveStatus',
                          'grade'  : jQuery("#grade_status").val(),
                          'emp'    : jQuery("#emp_name").val(),
                          'leave'  : jQuery("#leave_type").val(),
                          'forfit' : forfit
                      }
                      
                    app.request.post({'data' : checkparams}).then(
                      function(err, loaddata) {
                        jQuery("#searchresult").html(loaddata);
                     });
                });

        return aDeferred.promise();
     },
   
     
},{
     
     filterLeaveStatus : function(){ 
      
           jQuery(".searchFilter").click(function(){
                  var aDeferred = jQuery.Deferred();
                  app.helper.showProgress();
                  
                   var forfit = 0;
                    if(jQuery('#forfit').is(':checked')){
                       forfit = 1;
                     }
                  //first check the how many employee missing active contract  
                    var checkparams = {
                          'module' : 'Vtiger',
                          'parent' : app.getParentModuleName(),
                          'view'   : 'BalanceLeave',
                          'mode'   : 'filterLeaveStatus',
                          'grade'  : jQuery("#grade_status").val(),
                          'emp'    : jQuery("#emp_name").val(),
                          'leave'  : jQuery("#leave_type").val(),
                          'forfit' : forfit
                      }
                    app.request.post({'data' : checkparams}).then(
                           function(err, data) {
                            jQuery("#searchresult").html('');
                             app.helper.hideProgress();
                             jQuery("#searchresult").html(data);
                          });

                // return aDeferred.promise();
              });   
      },

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

    registerClaimDeleteButton : function() {


        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#deleteClaim").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#deleteClaim").click(function () {
          
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
                'mode'  : 'DeleteClaimAllocation'
            }

            AppConnector.request(params).then(
                function() {
                    var url = "?module=Vtiger&parent=Settings&view=ClaimAllocationListView&block=14&fieldid=49";
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

    registerBenefitDeleteButton : function() {


        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#deleteBenefit").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#deleteBenefit").click(function () {
          
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
                'mode'  : 'DeleteBenefitAllocation'
            }

            AppConnector.request(params).then(
                function() {
                    var url = "?module=Vtiger&parent=Settings&view=BenefitAllocationListView&block=14&fieldid=49";
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
            // Added By Mabruk
            var array = selectedvalues.split(",")            

            if(array.length != 1 || selectedvalues == ""){
                alert("Invalid Selection");
                return aDeferred.promise();
            }            



            //console.log("add item");
            
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view'   : 'AllocationTools',
                'values' : selectedvalues,
                'mode'   : 'EditAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
            
                    app.helper.showModal(data);
                    //history.pushState({}, null, window.history.back());
                    thisInstance.saveRule();
                    thisInstance.autoAddMultipleLeavetype();
                    thisInstance.showLeaveTypeEditAddition();
                                      // var thisInstance1 = this;

                });

        });
        return aDeferred.promise();
    },

    registerClaimEditButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#editClaim").unbind('click'); /**Unbinded to avoid infinite loop on every register***/

        jQuery("#editClaim").click(function () {
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
                'mode' : 'EditClaimAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    history.pushState({}, null, window.history.back());
                    thisInstance.saveClaimRule();
                    thisInstance.autoAddMultipleClaimtype();
                    //thisInstance.showLeaveTypeEditAddition();

                    // var thisInstance1 = this;

                    jQuery('#monthly_limit3').on('change', function() {

                        alert('changed');

                    })


                });

        });
        return aDeferred.promise();
    },

    registerBenefitEditButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#editBenefit").unbind('click'); /**Unbinded to avoid infinite loop on every register***/

        jQuery("#editBenefit").click(function () {
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
                'mode' : 'EditBenefitAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    history.pushState({}, null, window.history.back());
                    thisInstance.saveBenefitRule();
                    thisInstance.autoAddMultipleBenefittype();
                    //thisInstance.showLeaveTypeEditAddition();

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
                    // var thisInstance1 = this
                });

        });
        return aDeferred.promise();
    },

    registerClaimAddButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#addClaim").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addClaim").click(function () {
            //console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AllocationTools',
                'mode' : 'AddClaimAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    thisInstance.saveClaimRule();
                    thisInstance.showLeaveTypeAddition();
                    thisInstance.addMultipleClaimtype();
                    history.pushState({}, null, window.history.back());
                    // var thisInstance1 = this
                });

        });
        return aDeferred.promise();
    },

    registerBenefitAddButton: function(){

        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        jQuery("#addBenefit").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#addBenefit").click(function () {
            //console.log("add item");
            app.helper.showProgress();
            var params = {
                'module' : app.getModuleName(),
                'parent' : app.getParentModuleName(),
                'view' : 'AllocationTools',
                'mode' : 'AddBenefitAllocationForm'
            }
            AppConnector.requestPjax(params).then(
                function(data) {
                    //console.log("Inside pjax");
                    app.helper.hideProgress();
                    app.helper.showModal(data);
                    thisInstance.saveBenefitRule();
                    //thisInstance.showLeaveTypeAddition();
                    thisInstance.addMultipleBenefittype();
                    history.pushState({}, null, window.history.back());
                    // var thisInstance1 = this
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
                    'view'   : 'AllocationTools',
                    'mode'   : mode,
                    'form'   : form


                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                       // var jsonData = JSON.stringify(data); alert(jsonData);
                        if(data.result=='success'){
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

                        else if (data.result == "Missing") {

                            app.helper.showErrorNotification({"message": "Empty:<br>" + data.data});

                        }

                        
                        else if (data.result == "Not Allowed") { 
//alert(JSON.stringify(data));
                            var claims      = JSON.stringify(data.data.claims);
                            var leaveTypes  = JSON.stringify(data.data.leaveTypes); 
                            if (data.data.claims != "") {                              

                                    app.helper.showErrorNotification({"message":claims.replace(/"/g , "")});
                              
                            }
                            if (data.data.leaveTypes != "") {                              

                                    app.helper.showErrorNotification({"message":leaveTypes.replace(/"/g , "")});
                              
                            }
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

    saveClaimRule: function(){
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;

        jQuery(document).ready(function () {
            jQuery(document).off('click',"#saveButtonClaim"); /**Unbinded to avoid infinite loop on every register***/
            jQuery(document).on('click', "#saveButtonClaim", function () {
               
                var form = jQuery('#AddClaimAllocation').serializeArray();


                if(jQuery("#EditClaimAllocationContainer").length >0){
                    mode = 'UpdateClaimAllocation'
                }else{
                    mode = 'AddClaimAllocation';
                }

                var params = {
                    'module' : 'Vtiger',
                    'parent' : 'Settings',
                    'view'   : 'AllocationTools',
                    'mode'   : mode,
                    'form'   : form


                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                       // var jsonData = JSON.stringify(data); alert(jsonData);
                        if(data.result=='success'){
                            //console.log(data);

                            var url = "?module=Vtiger&parent=Settings&view=ClaimAllocationListView&block=14&fieldid=49";
                            thisInstance.loadContents(url).then(function(data){
                                jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                                app.hideModalWindow();
                                thisInstance.registerEvents();
                                app.helper.showSuccessNotification({"message":"Successfully Added"});
                            });

                            aDeferred.resolve(data);
                            return;
                        }

                        else if (data.result == "Missing") {

                            app.helper.showErrorNotification({"message": "Empty:<br>" + data.data});

                        }

                        
                        else if (data.result == "Not Allowed") { 
//alert(JSON.stringify(data));

                            var claimTypes  = JSON.stringify(data.data.claimTypes); 
                            if (data.data.claimTypes != "") {                              

                                    app.helper.showErrorNotification({"message":claimTypes.replace(/"/g , "")});
                              
                            }
                        }
                        else{ 
                            alert(mode);
                            console.log(data);
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

    saveBenefitRule: function(){
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;

        jQuery(document).ready(function () {
            jQuery(document).off('click',"#saveButtonBenefit"); /**Unbinded to avoid infinite loop on every register***/
            jQuery(document).on('click', "#saveButtonBenefit", function () {
               
                var form = jQuery('#AddBenefitAllocation').serializeArray();


                if(jQuery("#EditBenefitAllocationContainer").length >0){
                    mode = 'UpdateBenefitAllocation'
                }else{
                    mode = 'AddBenefitAllocation';
                }

                var params = {
                    'module' : 'Vtiger',
                    'parent' : 'Settings',
                    'view'   : 'AllocationTools',
                    'mode'   : mode,
                    'form'   : form


                };
                app.helper.showProgress();

                app.request.post({'data' : params}).then(
                    function(err, data) {
                        app.helper.hideProgress();
                       // var jsonData = JSON.stringify(data); alert(jsonData);
                        if(data.result=='success'){
                            //console.log(data);

                            var url = "?module=Vtiger&parent=Settings&view=BenefitAllocationListView&block=14&fieldid=49";
                            thisInstance.loadContents(url).then(function(data){
                                jQuery(".settingsPageDiv.content-area.clearfix").html(data);
                                app.hideModalWindow();
                                thisInstance.registerEvents();
                                app.helper.showSuccessNotification({"message":"Successfully Added"});
                            });

                            aDeferred.resolve(data);
                            return;
                        }

                        else if (data.result == "Missing") {

                            app.helper.showErrorNotification({"message": "Empty:<br>" + data.data});

                        }

                        
                        else if (data.result == "Not Allowed") { 
//alert(JSON.stringify(data));

                            var claimTypes  = JSON.stringify(data.data.claimTypes); 
                            if (data.data.claimTypes != "") {                              

                                    app.helper.showErrorNotification({"message":claimTypes.replace(/"/g , "")});
                              
                            }
                        }
                        else{ 
                            alert(mode);
                            console.log(data);
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
        var limit=0;
        var thisInstance = this;
        jQuery("#AddLeavetype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#AddLeavetype").click(function () {
            counter++;
            limit++;
            var dropdownvalues_en = jQuery("#dropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#AddLeavetype").prop('disabled', true);

            }

            var element ='<div id="Leavetypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype'+ counter +'" name="Allocation_leavetype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Leavetypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;<input type="text" placeholder="" id="ageleave'+ counter +'" name="ageleave'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesless'+ counter +'" name="numberofleavesless'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesmore'+ counter +'" name="numberofleavesmore'+ counter +'" style="width: 50px;"></div></div>';

            element = element + '</div>';

            jQuery("#LeaveTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#AddLeavetype").prop('disabled', false);
            });
        });

    },

    toggleLimit : function(e){
        alert('ok');
    },

    addMultipleClaimtype: function(){ 
        var counter=0;
        var limit=0;
        var thisInstance = this;
         jQuery("#AddClaimtype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
         jQuery("#AddClaimtype").click(function () {
            counter++;
            limit++;
            
            var dropdownvalues_en = jQuery("#dropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#AddClaimtype").prop('disabled', true);

            }
            

            var element ='<div id="Claimtypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_claimtype'+ counter +'" name="Allocation_claimtype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['claimtype'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Claimtypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left" style="margin-left:221px;">'+
                    '<div class="contents row form-group" style="margin-left: 30px;">'+
                    '<label class="switch"><input class="sliderform-check-input" type="checkbox" id="trans_limit'+counter+'" data-child="#trans_limit_input'+ counter +'">Transaction Limit</input><span class="slider round"></span>'+
                    '<input style="margin-left:15px;" id="trans_limit_input'+ counter +'" type="text" name="trans_limit'+ counter +'" hidden>'+
                    '</div><div class="contents row form-group" style="margin-left: 30px;">'+
                    '<label class="switch"><input class="sliderform-check-input" type="checkbox" id="monthly_limit'+counter+'" data-child="#monthly_limit_input'+ counter +'">Monthly Limit</input><span class="slider round"></span>'+
                    '<input style="margin-left:36px;" type="text" id="monthly_limit_input'+ counter +'" name="monthly_limit'+ counter +'" hidden></div>'+
                    '<div class="contents row form-group" style="margin-left: 30px;">'+
                    '<label class="switch"><input class="sliderform-check-input" type="checkbox" id="yearly_limit'+counter+'" data-child="#yearly_limit_input'+ counter +'">Yearly Limit</input><span class="slider round"></span>'+
                    '<input style="margin-left:53px;" type="text" id="yearly_limit_input'+ counter +'" name="yearly_limit'+ counter +'" hidden>'+
                    '</div></div></div>'

            element = element + '</div>';

            jQuery("#ClaimTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid" + counter,function(){
                limit--;
                jQuery("#AddClaimtype").prop('disabled', false);
            });

            // Added By Mabruk
            jQuery('.sliderform-check-input').change(function(){ 
                
                input = jQuery(jQuery(this).data('child')); 
                if (input.is(':hidden'))
                    input.show();
                else
                    input.hide();    

            });           

        });

    },

    addMultipleBenefittype: function(){
        var counter=0;
        var limit=0;
        var thisInstance = this;
         jQuery("#AddBenefittype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
         jQuery("#AddBenefittype").click(function () {
            counter++;
            limit++;
            
            var dropdownvalues_en = jQuery("#dropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#AddBenefittype").prop('disabled', true);

            }
            

            var element ='<div id="Benefittypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_benefittype'+ counter +'" name="Allocation_benefittype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['benefittype'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Benefittypesection'+counter +'\').remove();">X</button></div></div></div>';

            //element = element + '<div class="container float-left" style="margin-left:221px;"><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="trans_limit'+counter+'" value="trans_limit">Transaction Limit</input><input style="margin-left:15px;" id="trans_limit_input'+ counter +'" type="text" name="trans_limit'+ counter +'"> </div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="monthly_limit'+counter+'" name="">Monthly Limit</input><input style="margin-left:36px;" type="text" id="monthly_limit_input'+ counter +'" name="monthly_limit'+ counter +'" ></div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="yearly_limit'+counter+'" name="">Yearly Limit</input><input style="margin-left:53px;" type="text" id="yearly_limit_input'+ counter +'" name="yearly_limit'+ counter +'" ></div></div></div>'

            element = element + '</div>';

            jQuery("#BenefitTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#AddBenefittype").prop('disabled', false);
            });

        });

    },

    /**
     * Auto Add Multiple Leave type for Edit View Form
     */
    autoAddMultipleLeavetype: function(){
        var counter=0;
        var thisInstance = this;
        var limit=0;

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
            limit++;
            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#EditAddLeavetype").prop('disabled', true);

            }

            var element ='<div id="Leavetypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype'+ counter +'" name="Allocation_leavetype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Leavetypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;<input type="text" placeholder="" id="ageleave'+ counter +'" name="ageleave'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesless'+ counter +'" name="numberofleavesless'+ counter +'" style="width: 50px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;<input type="text" placeholder="" id="numberofleavesmore'+ counter +'" name="numberofleavesmore'+ counter +'" style="width: 50px;"></div></div>';

            element = element + '</div>';

            jQuery("#EditLeaveTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#EditAddLeavetype").prop('disabled', false);
            });
        });

    },

    autoAddMultipleClaimtype: function(){
        var counter=0;
        var thisInstance = this;
        var limit = 0;

        var exisitngvals_en = jQuery('#EditallocatedClaimTypeValues').val();
        var exisitngvals = jQuery.parseJSON(exisitngvals_en);
        for(var j=0;j<exisitngvals.length;j++){
            counter++;
            limit++;
            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#EditAddClaimtype").prop('disabled', true);

            }

            var element ='<div id="Claimtypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_claimtype'+ counter +'" name="Allocation_claimtype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                if(dropdownvalues[i]['id'] == exisitngvals[j]['claim_id']){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + ' selected>'+ dropdownvalues[i]['claimtype'] +'</option>';
                }else{
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['claimtype'] +'</option>';

                }
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Claimtypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left" style="margin-left:221px;"><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="trans_limit'+counter+'" value="trans_limit">Transaction Limit</input><input style="margin-left:15px;" id="trans_limit_input'+ counter +'" type="text" name="trans_limit" value='+ exisitngvals[j]['transaction_limit'] +'></input> </div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="monthly_limit'+counter+'" name="">Monthly Limit</input><input style="margin-left:36px;" type="text" id="monthly_limit_input'+ counter +'" name="monthly_limit" value='+ exisitngvals[j]['monthly_limit'] +'></input></div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="yearly_limit'+counter+'" name="">Yearly Limit</input><input style="margin-left:53px;" type="text" id="yearly_limit_input'+ counter +'" name="yearly_limit" value='+ exisitngvals[j]['yearly_limit'] +'></input></div></div></div>'

            element = element + '</div>';

            jQuery("#ClaimTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#EditAddClaimtype").prop('disabled', false);
            });
        }


        jQuery("#EditAddClaimtype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#EditAddClaimtype").click(function () {
            counter++;
            limit++;

            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#EditAddClaimtype").prop('disabled', true);

            }

            var element ='<div id="Claimtypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_claimtype'+ counter +'" name="Allocation_claimtype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['claimtype'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Claimtypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '<div class="container float-left" style="margin-left:221px;"><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="trans_limit'+counter+'" value="trans_limit">Transaction Limit</input><input style="margin-left:15px;" id="trans_limit_input'+ counter +'" type="text" name="trans_limit"></input> </div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="monthly_limit'+counter+'" name="">Monthly Limit</input><input style="margin-left:36px;" type="text" id="monthly_limit_input'+ counter +'" name="monthly_limit" ></input></div><div class="contents row form-group" style="margin-left: 30px;"><input class="form-check-input" type="checkbox" id="yearly_limit'+counter+'" name="">Yearly Limit</input><input style="margin-left:53px;" type="text" id="yearly_limit_input'+ counter +'" name="yearly_limit" ></input></div></div></div>'

            element = element + '</div>';

            jQuery("#ClaimTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#EditAddClaimtype").prop('disabled', false);
            });
        });

    },

    autoAddMultipleBenefittype: function(){
        var counter=0;
        var thisInstance = this;
        var limit = 0;

        var exisitngvals_en = jQuery('#EditallocatedBenefitTypeValues').val();
        var exisitngvals = jQuery.parseJSON(exisitngvals_en);
        for(var j=0;j<exisitngvals.length;j++){
            counter++;
            limit++;
            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#EditAddBenefittype").prop('disabled', true);

            }

            var element ='<div id="Benefittypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_benefittype'+ counter +'" name="Allocation_benefittype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                if(dropdownvalues[i]['id'] == exisitngvals[j]['benefit_type']){
                    element = element + '<option value=' + dropdownvalues[i]['id'] + ' selected>'+ dropdownvalues[i]['title'] +'</option>';
                }else{
                    element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>';

                }
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Benefittypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '</div>';

            jQuery("#BenefitTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#EditAddBenefittype").prop('disabled', false);
            });
        }


        jQuery("#EditAddBenefittype").unbind('click'); /**Unbinded to avoid infinite loop on every register***/
        jQuery("#EditAddBenefittype").click(function () {
            counter++;
            limit++;
            var dropdownvalues_en = jQuery("#EditdropdownValue").val();
            var dropdownvalues = jQuery.parseJSON(dropdownvalues_en);

            if(limit >= dropdownvalues.length){
                jQuery("#EditAddBenefittype").prop('disabled', true);

            }

            var element ='<div id="Benefittypesection'+ counter +'"><div class="contents row form-group"><div class="contents row form-group"><div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div><div class="fieldValue col-lg-4 col-md-4 col-sm-4"><select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_benefittype'+ counter +'" name="Allocation_benefittype'+ counter +'"><option value="">Select One</option>';

            for(var i=0;i<dropdownvalues.length;i++){
                element = element + '<option value=' + dropdownvalues[i]['id'] + '>'+ dropdownvalues[i]['title'] +'</option>'
            }

            element = element + '</select><button id="removeid'+ counter +'" onclick="jQuery(\'#Benefittypesection'+counter +'\').remove();">X</button></div></div></div>';

            element = element + '</div>';

            jQuery("#BenefitTypeAllocation").append(element);

            jQuery(document).on('click', "#removeid"+ counter,function(){
                limit--;
                jQuery("#EditAddBenefittype").prop('disabled', false);
            });
        });

    },
     
     registerYearEndProcess:function(){
          var aDeferred = jQuery.Deferred();
          jQuery(".checkleavestatus").on('click', function(){
               app.helper.showProgress();

               var params = {
                'module' : 'Users',
                'view'   : 'ListViewAjax',
                'mode'   : 'getUsersLeaveStatus'
               }

            app.request.post({'data' : params}).then(
                 function(err, data) { 
                    //console.log("Inside pjax");
                   app.helper.hideProgress();
                   jQuery('#myModal').modal('show');
                   jQuery(".checkleavestatus").html('System checking...');
                   jQuery(".checkleavestatus").attr('disabled',true);
                   jQuery(".modal-body").html(data);
                  // jQuery("#btnyearendprocess").trigger('click');
                    //history.pushState({}, null, window.history.back());
                });

        });
        return aDeferred.promise();
     },
     
    
     
    registerEvents: function() {
        this.registerDeleteButton();
        this.registerAddButton();
        this.registerClaimAddButton();
        this.registerEditButton();
        this.registerClaimEditButton();
        this.registerClaimDeleteButton();
        this.registerBenefitDeleteButton();
        this.registerBenefitAddButton();
        this.registerBenefitEditButton();
        this.registerYearEndProcess();
        this.filterLeaveStatus();
    
    }

});

jQuery(document).ready(function(e){
    var tacInstance = new Settings_Vtiger_Allocation_Js();
    var vtigerinst = new Vtiger_Index_Js();
    vtigerinst.registerEvents();
    tacInstance.registerEvents();

})


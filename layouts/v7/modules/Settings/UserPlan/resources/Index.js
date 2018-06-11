/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Jitu/Mabruk on 02/04/2018
 *************************************************************************************/

Vtiger.Class("Settings_UserPlan_Index_Js",{},{

   plancontainer : false,
   getContainer : function(){
        if(this.plancontainer == false){
            this.plancontainer =  jQuery("#plansettingcontainer");
        }
        return this.plancontainer;
    },

  
      submitPlan : function(targetid){
	  var thisInstance = this;
	  var form = jQuery('#editPlan');
	  jQuery('#planFilter').on('change',function(e){ 
	    var aDeferred = jQuery.Deferred();
		var currtgt = jQuery(e.currentTarget);
		var planid  = currtgt.val();
		
			var params = {
			'module' : app.getModuleName(),
			'parent' : app.getParentModuleName(),
			'view' : 'UserPlanAjax',
			'mode'   : 'LoadRole',
			'planid' : planid,
		};
		
		app.request.post({'data' : params}).then(
			function(err, data) {
				if(err === null) {
					var result = data['success'];
					var dropdown = jQuery("#roleFilter");
                         dropdown.empty();
                         dropdown.select2('data', '');
                         if(result == true) {
					     dropdown.append('<option value="" selected>' + app.vtranslate('JS_SELECT_ROLE') + '</option>');
     		            $.each(data['roles'], function(k, v) {
                             dropdown.append('<option value="' + v.roleid + '">' + v.rolename + '</option>');
                           });
						//thisInstance.loadUserPlan();
						aDeferred.resolve(data);
					} else {
						aDeferred.reject(data);
					}
				}
			});
	   });
	  form.find('[name="saveButton"]').on('click', function(e){
	  var selectedplan = jQuery("#planFilter").val();
	  var oldplan = jQuery("#"+targetid).data('planid');
	  var aDeferred = jQuery.Deferred();
	  var role = jQuery("#roleFilter").val();

       if(role==''){
          app.helper.showErrorNotification({'message': app.vtranslate('JS_PLEASE_SELECT_ROLE')});
          return false;
       }
		
		var params = {
			'module' : app.getModuleName(),
			'parent' : app.getParentModuleName(),
			'action' : 'UserPlanAjax',
			'mode'   : 'updatePlan',
			'newPlan': selectedplan,
			'oldPlan': oldplan,
			'userid'  : targetid,
			'role' : role
		};

		app.request.post({'data' : params}).then( 
			function(err, data) { 
			app.hideModalWindow();
				if(err === null) {
					var result = data['success'];
					if(result == true) {
						thisInstance.loadUserPlan();
						aDeferred.resolve(data);
					} else {
						aDeferred.reject(data);
					}
				}
			});
		aDeferred.promise();
		 
	  });	
	},

	registerActions : function() { 
		var thisInstance = this;
		var container  = jQuery("#plansettingcontainer");
		//var container = thisInstance.getContainer();
          //container.find('.editPlan').trigger('click');
		//register click event for Add New Tax button
		container.find('.editPlan').click(function(e) {
			var changePlanButton = jQuery(e.currentTarget);
			var editPlanUrl = changePlanButton.data('url');
			editPlanUrl = editPlanUrl+'&username='+changePlanButton.data('username')+'&plantitle='+changePlanButton.data('plantitle');
			thisInstance.editPlan(editPlanUrl,changePlanButton.data('id'));
		});
	},
 	editPlan : function(url, targetid) {

       // alert("Here");
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;


		app.helper.showProgress();
		app.request.post({url:url}).then(
		function(err,data) {
        		app.helper.hideProgress();
       			 if(err === null){
            		var callBackFunction = function(data) {
                	//cache should be empty when modal opened 
                	thisInstance.duplicateCheckCache = {};		
			}
		  }	
			app.helper.showModal(data, {cb:callBackFunction});
		
			
			thisInstance.submitPlan(targetid);
			return true;

		});
		
		//return aDeferred.promise();	
	},
   loadUserPlan:function(){
	var thisInstance = this;
	//var aDeferred = jQuery.Deferred();
		
	var params = {
		'module' : app.getModuleName(),
		'parent' : app.getParentModuleName(),
		'view' : 'Index',
		'mode'   : 'LoadPlan',
	};
		
	app.request.post({'data' : params}).then(
		function(err, data) {
			if(err === null) {
				jQuery('#loadplan').html(data);
				thisInstance.registerActions();
				//thisInstance.loadUserPlan();
				//aDeferred.promise();
				//location.reload(); 

			}
		});
	return true;
	//aDeferred.promise();
   },	

    registerEvents :  function(){ 
	//this.registerActions();

	this.loadUserPlan();
	var vtigerinst = new Vtiger_Index_Js();
	vtigerinst.registerEvents();

    }

});	

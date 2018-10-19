/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Settings_Vtiger_OutgoingServer_Js",{},{
     
     getListViewRecords : function() {
		var thisInstance = new Settings_Vtiger_OutgoingServer_Js();
		var params = {
			module : app.getModuleName(),
			parent : app.getParentModuleName(),
			view : 'OutgoingServerDetail'
		}
		app.helper.showProgress();
		app.request.post({data:params}).then(function (error, data) {
		     if (error === null) {
              	   app.helper.hideProgress();
                  jQuery('#OutgoingServerDetails').html(data);
                  thisInstance.DeleteRecord();
                  thisInstance.loadNewEmailpage();
		     }	
		});
	},

	saveOutgoingServerEditor: function (form) {
		var aDeferred = jQuery.Deferred();
		var data = form.serializeFormData();
		

		var params = {
			'module': app.getModuleName(),
			'parent': app.getParentModuleName(),
			'action': 'OutgoingServerSaveAjax',
			'data' : data
			//'updatedFields': JSON.stringify(updatedFields)
		};

		app.request.post({"data": params}).then(
			function (err, data) {
				if (err === null) {
					aDeferred.resolve(data);
				}
			},
			function (error, err) {
				aDeferred.reject();
			}
		);
		return aDeferred.promise();
	},
	
	/*
	 * Function to load the contents from the url through pjax
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

	/*
	 * function to register the events in editView
	 */
	registerEditViewEvents: function () {
		var thisInstance = this;
		var form = jQuery('#OutgoingServerForm');
		var detailUrl = form.data('detailUrl');
		//register validation 
		var params = {
			submitHandler: function (form) {
				var form = jQuery(form);
				thisInstance.saveOutgoingServerEditor(form).then(
					function (data) {
						if (data) {
							var message = app.vtranslate('JS_OUTGOING_DETAILS_SAVED');
							thisInstance.loadContents(detailUrl).then(
								function (data) {
									jQuery('#contents').html(data);	
									thisInstance.registerDetailViewEvents();
								}
							);
						}
						app.helper.showSuccessNotification({'message': message});
					});
			}
		};
		form.vtValidate(params);
		form.on('submit', function (e) {
			e.preventDefault();
			return false;
		});

		//Register click event for cancel link
		var cancelLink = form.find('.cancelLink');
		cancelLink.click(function() {
			 app.helper.showProgress();	
			thisInstance.loadContents(detailUrl).then(
				function(data) {
					app.helper.hideProgress();
					jQuery('#contents').html(data);			
					thisInstance.registerDetailViewEvents();
					 thisInstance.loadNewEmailpage();
				}
			);
		})
		vtUtils.enableTooltips();
	},	

	/*
	 * Function to load the contents from the url through pjax
	 */
	
	loadNewEmailpage: function () {
		var url = jQuery('#newmailbtn').data('url');
		jQuery('#newEmail').click(function(){
		    jQuery("#deleteItem").hide();
			jQuery('#detailHeader').detach();	
			jQuery('#bottom').detach();
			jQuery('#newEmail').detach();
			jQuery('#deleteItem').detach();
			jQuery('#contents').load(url);
		});
	},
	
	/*
	 * function to register the events in DetailView
	 */
	registerDetailViewEvents : function() {
		var thisInstance = this;
		var container = jQuery('#OutgoingServerDetails');
		var editButton = container.find('.editButton');
		
		//Register click event for edit button
		editButton.click(function() {
			var url = editButton.data('url');
			app.helper.showProgress();	
			thisInstance.loadContents(url).then(
				function(data) {
					app.helper.hideProgress();
					jQuery('#contents').html(data);
					jQuery('#detailHeader').detach();	
					jQuery('#bottom').detach();
					jQuery('#newEmail').detach();
					jQuery('#deleteItem').detach();
					thisInstance.registerEditViewEvents();
				}, function(error, err) {
					 app.helper.hideProgress();
				}
			);
		});
	},
	
	/**
	 * Function to delete Mutliple Company
	 */
	DeleteRecord : function() {
	
		jQuery("#deleteItem").on('click', function(e) {    
		
			var thisInstance = new Settings_Vtiger_OutgoingServer_Js();
			var message = app.vtranslate('LBL_DELETE_CONFIRMATION');
			var selection = thisInstance.CheckSelection();
			var idlist =  jQuery("#idlist").val();
	
			var params = {
				'module' : app.getModuleName(),
				'parent':app.getParentModuleName(),
				'action' : "DeleteEmailDetails",
				'idlist' : idlist
				}

			if(selection || (typeof idlist !=='undefined' && idlist !='')) {
			    app.helper.showConfirmationBox({'message' : message}).then(function(e){
				     app.helper.showProgress();	
				     app.request.post({data:params}).then(function (error, data) {
				          if (error === null) {
					          app.helper.hideProgress();
					          app.helper.showSuccessNotification({'message': app.vtranslate('JS_RECORD_DELETED_SUCCESSFULLY')});
				               thisInstance.getListViewRecords();
				          }
				          else {
						     app.event.trigger('post.save.failed', error);
					     }
				     });
			       },
			       function (error, err) {
				  });
				}
			});
	   }, 
	CheckSelection:function(e) {
		var x = document.massdelete.selected_id.length;
	        var idstring = "";
	        
		if ( x == undefined) {
			 if (document.massdelete.selected_id.checked) {
			    
			 	document.massdelete.idlist.value=document.massdelete.selected_id.value+';';
                      		xx=1;
			 } else {
			 	alert(app.vtranslate('SELECT_ATLEAST_ONE'));
                        	return false;
			 }
		} else {
			 var xx = 0;
			
               		 for(i = 0; i < x ; i++) {
               		 	 if(document.massdelete.selected_id[i].checked) {
               		 	 	 idstring = document.massdelete.selected_id[i].value +";"+idstring
                       			 xx++
               		 	 }
               		 }
               		 if (xx != 0) {
               		 	 document.massdelete.idlist.value=idstring;
               		 	 return true;
               		 } else {
               		 	alert(app.vtranslate('SELECT_ATLEAST_ONE'));
	                        return false;
               		 }
		}
	},	
	registerEvents: function() {

		if(jQuery('#OutgoingServerDetails').length > 0) {
			this.registerDetailViewEvents();
		} else {
			this.registerEditViewEvents();
		}
	}

});

jQuery(document).ready(function(e){
	var tacInstance = new Settings_Vtiger_OutgoingServer_Js();
	tacInstance.registerEvents();
	tacInstance.DeleteRecord();
	tacInstance.loadNewEmailpage();
})




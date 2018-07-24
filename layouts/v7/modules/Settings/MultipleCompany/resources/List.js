/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Vtiger.Class("Settings_MultipleCompany_List_Js",{},{


	getListViewRecords : function() {
		var thisInstance = new Settings_MultipleCompany_List_Js();
		var params = {
			module : app.getModuleName(),
			parent : app.getParentModuleName(),
			view : 'List'
		}
		app.helper.showProgress();	
		app.request.post({data:params}).then(function (error, data) {
               if (error === null) {
         	          app.helper.hideProgress();
              		jQuery('#layoutEditorContainer').html(data);
              		thisInstance.DeleteRecord();
		     }
		});
	},
	/**
	 * Function to delete Mutliple Company
	 */
	DeleteRecord : function() {
	
		jQuery("#deleteItem").on('click', function(e) {    
		
			var thisInstance = new Settings_MultipleCompany_List_Js();
			var message = app.vtranslate('LBL_DELETE_CONFIRMATION');
			var selection = thisInstance.CheckSelection();
			var idlist =  jQuery("#idlist").val();
			var params = {
				'module' : app.getModuleName(),
				'parent':app.getParentModuleName(),
				'action' : "Delete",
				'idlist' : idlist
				}

			if(selection || idlist !='') {
			
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
	/**
	 * Function to register all the events
	 */
	registerEvents : function() {
		this.DeleteRecord();
	}
});
jQuery(document).ready(function(e){
     var vtigerinst = new Vtiger_Index_Js();
     vtigerinst.registerEvents();
}); 

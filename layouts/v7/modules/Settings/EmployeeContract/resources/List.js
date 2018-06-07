/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Settings_Vtiger_List_Js('Settings_EmployeeContract_List_Js',{
    triggerDelete : function(url) {
        var instance = app.controller();
        instance.deleteEmployeeContract(url);
    },

	 triggerDetailView : function(url) {
		var instance = app.controller();
		instance.viewDetailView(url);
	    },
},{
   
    /**
	 * Function to get Page Jump Params
	 */
	getPageJumpParams : function(){
		var params = this.getDefaultParams();
		params['action'] = "ListAjax";
		params['mode'] = "getPageCount";

		return params;
	},
    
    
    deleteEmployeeContract : function(url) {
        var self = this;
        app.helper.showConfirmationBox({'message' : app.vtranslate('JS_ARE_YOU_SURE_YOU_WANT_TO_DELETE')}).then(function(){
            app.request.post({'url' : url}).then(function(error, data){
                if(data){
                    self.loadListViewRecords();
                }   
            });
        })
    },

  viewDetailView : function(url) {
 	var params = this.getDefaultParams();
		params['parent'] = "Settings";
		params['module'] = "EmployeeContract";	
		params['record'] = url;
		params['view'] = "RecordQuickPreview";
	
		app.helper.showProgress();
		 app.request.post({'data' : params}).then(function(error, data){
     		app.helper.hideProgress();
				
           if(error === null) {
	     	 app.helper.showModal(data);
           }
});
	

     	
    },
    
    registerEvents : function() {
        var self = this;
        this._super();
        app.event.on('post.listViewFilter.click', function(e){
            //clearing cached dom element. Since it will be replaced with ajax request
        })
    }
});

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("WorkingHours_Edit_Js",{},{
   
	
	/**
	 * Function which will map the address details of the selected record
	 */
	registerEventForCopyDuration : function() {
	     var clickall = jQuery("#WorkingHours_editView_fieldName_copy_all");
	     var form = jQuery("#EditView");
	     var dayarray = new Array('tuesday', 'wednesday','thursday','friday','saturday','sunday');

           clickall.on('click',function () {
	           if(clickall.is(':checked')){
	              var  day_fromobj = form.find('[name="monday_from"]').val();
                   var day_toobj = form.find('[name="monday_to"]').val();
                   if(day_fromobj =='' || day_toobj ==''){
                        var msg = app.vtranslate('JS_PLEASE_SELECT_MONDAY_TIMINGS');
                         app.helper.showErrorNotification({"message" : msg});
                         return false;
                   }
	              jQuery.each(dayarray, function( index, value ) {
	               var dayfrom = value+'_from';
                    var dayto = value+'_to';
                       form.find('[name="'+dayfrom+'"]').val(day_fromobj);
                       form.find('[name="'+dayto+'"]').val(day_toobj);
                });
             } else {
               jQuery.each(dayarray, function( index, value ) {
	               var dayfrom = value+'_from';
                    var dayto = value+'_to';
                       form.find('[name="'+dayfrom+'"]').val('');
                       form.find('[name="'+dayto+'"]').val('');
                });
             }
         }); 
	},
	
	/**
	 * Function which will register basic events which will be used in quick create as well
	 *
	 */
	
	registerEvents : function() {

		// Parent Call Added By Mabruk .. It is important to get all the Edit Functions From Parent 
		this._super();

    	var vtigerinst = new Vtiger_Index_Js();
	    vtigerinst.registerEvents();
     	this.registerEventForCopyDuration();
	}
	
});

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

jQuery.Class("Vtiger_Header_Js", {
   
    previewFile : function(e,recordId) {
        e.stopPropagation();
        var currentTarget = e.currentTarget;
        var currentTargetObject = jQuery(currentTarget);
        if(typeof recordId == 'undefined') {
            if(currentTargetObject.closest('tr').length) {
                recordId = currentTargetObject.closest('tr').data('id');
            } else {
                recordId = currentTargetObject.data('id');
            }
        }
        var fileLocationType = currentTargetObject.data('filelocationtype');
        var fileName = currentTargetObject.data('filename'); 
        //fileLocationType == 'G' condition added By Jitu/Mabruk for Google Drive Integration 28/03/2018
        if(fileLocationType == 'I' || fileLocationType == 'G'){
            var params = {
                module : 'Documents',
                view : 'FilePreview',
                record : recordId
            };
            app.request.post({"data":params}).then(function(err,data){
                app.helper.showModal(data);
            });
        } else {
            var win = window.open(fileName, '_blank');
            win.focus();
        }
    },
   
    showNotification : function(){
     jQuery( ".notification-list" ).toggle(function() {
          if(jQuery('.notification-list').hasClass('hide')) {  
                jQuery('.notification-list').removeClass('hide');  
          } else {
                jQuery('.notification-list').addClass('hide');  
          } 
     });          
   }, 
   
   hideNotification : function(){
      jQuery('.notification-list').addClass('hide'); 
   },
    
   
},{
});

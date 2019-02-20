/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Vtiger_Edit_Js("MessageBoard_Edit_Js",{},{


    /**
         * Function load the ckeditor for signature field in edit view of my preference page.
         */
        registerMessageBoardEvent: function(){
                var templateContentElement = jQuery("#MessageBoard_editView_fieldName_message");
                if(templateContentElement.length > 0) {
                        var ckEditorInstance = new Vtiger_CkEditor_Js();
                        //Customized toolbar configuration for ckeditor  
                        //to support basic operations
                        var customConfig = {
                                toolbar: [
                                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup','align','list', 'indent','colors' ,'links'], items: [ 'Bold', 'Italic', 'Underline', '-','TextColor', 'BGColor' ,'-','JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList','-', 'Link', 'Unlink','Image','-','RemoveFormat'] },
                                        { name: 'styles', items: ['Font', 'FontSize' ] },
                    {name: 'document', items:['Source']}
                                ]};
                        ckEditorInstance.loadCkEditor(templateContentElement,customConfig);
                }
        },


        /**
         * register Events for my preference
         */
        registerEvents : function(){
                this._super();
                this.registerMessageBoardEvent();

        }
});
jQuery(document).ready(function(){
    var height = jQuery("#MessageBoard_editView_fieldName_message").height();
   jQuery("#MessageBoard_editView_fieldName_message").closest('.row').find('div').css('height',"300px");
   jQuery("#MessageBoard_Edit_fieldName_department").closest(".row").find('.fieldLabel').css("height","80px").css("margin-top","5px").css("background-color","#fafafa").css("border","none")
      jQuery("#MessageBoard_Edit_fieldName_department").closest(".row").find('.fieldValue').css("margin-top","5px").css("background-color","#fafafa").css("border","none")
      jQuery(".fieldLabel").css("background-color","#fafafa")
jQuery(".fieldValue.col-md-4").css("width","38%");
$(".select2").on("select2:unselecting", function(e) {
   alert("clear");
 });
})


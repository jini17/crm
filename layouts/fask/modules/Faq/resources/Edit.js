/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Vtiger_Edit_Js("Faq_Edit_Js",{},{
/**
	 * Function load the ckeditor for signature field in edit view of my preference page.
	 */
	registerDescriptionEvent: function(){
		var templateContentElement = jQuery("#Faq_editView_fieldName_faq_answer");
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
	
	
	
	registerEvents : function() {
	     this.registerDescriptionEvent();
	}
});

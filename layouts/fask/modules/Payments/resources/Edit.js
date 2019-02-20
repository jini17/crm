/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("Payments_Edit_Js",{},{

	 //########################Added by jitu@secondcrm.com on 25 sep 2014#########	
	getCompanyTermsNCondition : function() {
		jQuery('#company_details').on('change',function(e){
		app.helper.showProgress();
	    var element = jQuery(e.currentTarget);
         var selectedCompany = jQuery(e.currentTarget).val();
	    var selectedTnC     = $("#hdnTermsCondition").val();
	  
         if(selectedCompany.length <= 0) {
			var params = {
					title : app.vtranslate('JS_SELECT_COMPANY'),
					text: app.vtranslate('JS_PLEASE_SELECT_COMPANY'),
					animation: 'show',
					type: 'info'
				};
       	Vtiger_Helper_Js.showPnotify(params);
		var result = "<div class='row-fluid'><div class='span6 fieldValue'><select class='chzn-select' id='terms_conditions' name='terms_conditions' data-validation-engine='validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]'><optgroup>";
		//    result += "<option value=''>Select Option</option>";	
		    result +="</optgroup></select></div></div>";
		    app.helper.hideProgress();
 		    jQuery("#terms_conditions").parent().html(result);
		    app.changeSelectElementView(jQuery('#terms_conditions'));	
                return;
            }
			var params = {
				module :'Inventory',
				company_Id : selectedCompany,
				view : 'TnCAjax',
				mode : 'getTermsNConditionForCompany'
			}
			AppConnector.request(params).then(function(data){

				app.helper.hideProgress();
				var output = "<div class='row-fluid'><div class='span6 fieldValue'><select class='inputElement select2' id='terms_conditions' name='terms_condition' data-validation-engine='validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]'><optgroup>";
							for(var i=0;i<data.result.length;i++)
								{
								     if(data.result[i].id == selectedTnC) {	
									     output += "<option value="+data.result[i].id+" selected='selected'>"+data.result[i].title+"</option>";
								     } else {
									     output += "<option value="+data.result[i].id+">"+data.result[i].title+"</option>";	
								     }	 	 		
								}
				output +="</optgroup></select></div></div>";
				jQuery("#terms_conditions").parent().html(output);
				app.changeSelectElementView(jQuery('#terms_conditions'));
				
			});
		});
	},
	
	/**Add this function for on load page set Terms and condition 
		By Jitu@secondcrm.com on 11 Aug 2014
	**/	
	setCompanyTermsCondition : function() {
		
		 var selectedCompany = $("#company_details").val();
		 var selectedTnC     = $("#hdnTermsCondition").val();
	     
	     if(selectedCompany !=''){
           	 var params = {
				module :'Inventory',
				company_Id : selectedCompany,
				view : 'TnCAjax',
				mode : 'getTermsNConditionForCompany'
			}
			app.helper.showProgress();
			AppConnector.request(params).then(function(data){
                    app.helper.hideProgress();
                   console.log(data);
				var output = "<div class='row-fluid'><div class='span6 fieldValue'><select class='inputElement select2' id='terms_conditions' name='terms_condition' data-validation-engine='validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]'><optgroup>";
							for(var i=0;i<data.result.length;i++)
								{
								     if(data.result[i].id == selectedTnC) {	
									     output += "<option value="+data.result[i].id+" selected='selected'>"+data.result[i].title+"</option>";
								     } else {
									     output += "<option value="+data.result[i].id+">"+data.result[i].title+"</option>";	
								     }	 	 		
								}
				output +="</optgroup></select></div></div>";

				jQuery("#terms_conditions").parent().html(output);
				app.changeSelectElementView(jQuery('#terms_conditions'));
				
			});
		}	
	},
	registerEvents: function(){
		this._super();
		this.getCompanyTermsNCondition();
		this.setCompanyTermsCondition();
	}
});

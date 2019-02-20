/*+***********************************************************************************
 * The contents of this file are subject to the second CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by jitu@secondcrm.com are Copyright (C) secondcrm.
 * All Rights Reserved.
 *************************************************************************************/
 
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

jQuery.Class('SalesTarget_Target_Js', {
	
	//holds the :salesTarget instance
	salesTargetInstance : false,
	
	/**
	 * This function used to trigger Confirmation for Year End process
	 */
	GenerateTarget : function(targetUrl) {
		var module = app.getModuleName();
		var thisInstance = this;
		var listInstance = Vtiger_List_Js.getInstance();	
		var validationResult = listInstance.checkListRecordSelected();
		if(validationResult != true){	
			
			var selectedIds = listInstance.readSelectedIds(true);
			var postData = listInstance.getDefaultParams();	
			
		  delete postData.module;
            delete postData.view;
            delete postData.parent;
		  delete postData.search_params;	
		  delete postData.orderby;
		  delete postData.sortorder;
		  delete postData.viewname;	
            
            postData.selected_ids = selectedIds;
            alert(targetUrl);
			var actionParams = {
				"type":"POST",
				"url":targetUrl,
				"dataType":"html",
				"data" : postData
			};
			var message = app.vtranslate('JS_SURE_GENERATE_TARGET',module);
			Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(
				function(e) {
				
				AppConnector.request(actionParams).then(
				function(data) {  
				alert(data);
					var json = $.parseJSON(data);
					var jsontype =  json.success==true?'success':'error';
					var msg = json.success==true?json.result:json.error.code;
						params = {
								text: app.vtranslate(msg),
								type: jsontype
							};			
										
						Vtiger_Helper_Js.showPnotify(params);	
				});
					
			});	
		} else {
			listInstance.noRecordSelectedAlert();
		}		
	},
	
	
}, {
	
	//constructor
	init : function() {
		SalesTarget_Target_Js.salesTargetInstance = this;
	},

	ReportTarget : function() {
		jQuery('#reportTarget').on('click',function(e){ 
			var module = app.getModuleName();
			var thisInstance = this;
			var progressIndicatorElement = jQuery.progressIndicator({
					'position' : 'html',
					'blockInfo' : {
						'enabled' : true
					}
				});
		
			var ReportParams = {};
			ReportParams['module'] = app.getModuleName();
			ReportParams['view'] = "AjaxReport";
			ReportParams['targetid'] = jQuery('#targetid').val();
			
			ReportParams['monthly'] = jQuery('#monthly').is(':checked')?jQuery('#monthly').val():'';
			ReportParams['quaterly'] = jQuery('#quaterly').is(':checked')?jQuery('#quaterly').val():'';	
			ReportParams['annually'] = jQuery('#annually').is(':checked')?jQuery('#annually').val():'';
			ReportParams['groupby'] = jQuery('#groupby').val();
			
			AppConnector.request(ReportParams).then(
				function(data) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
					jQuery(".exportreport").removeClass('hide');
					jQuery('#result').html(data);
				}
			);
		});

		jQuery(".exportreport").on('click',function(e){ 
			var element = jQuery(e.currentTarget); 
			var type = element.attr("name");
			var href = element.data('href');
		
			var formelement = jQuery("#ReportView");
			var targetid 	= formelement.find('[name="targetid"]').val();	
			var groupby 	= formelement.find('[name="groupby"]').val();
		
			var monthly 	= formelement.find('[name="monthly"]').is(':checked')?1:'';
			var quaterly 	= formelement.find('[name="quaterly"]').is(':checked')?1:'';
			var annually 	= formelement.find('[name="annually"]').is(':checked')?1:'';	
	
		
	
			if(type.indexOf("Print") != -1){
			    var newEle = '<form action='+href+' method="POST" target="_blank">'+
			    '<input type = "hidden" name ="'+csrfMagicName+'"  value=\''+csrfMagicToken+'\'>'+	
				    '<input type="hidden" value="" name="targetid" id="targetid" />'+
				    '<input type="hidden" value="" name="groupby" id="groupby" />'+
				    '<input type="hidden" value="" name="monthly" id="monthly" />'+
				    '<input type="hidden" value="" name="quaterly" id="quaterly" />'+
				    '<input type="hidden" value="" name="annually" id="annually" /></form>';
			}else{
			    newEle = '<form action='+href+' method="POST">'+
				'<input type = "hidden" name ="'+csrfMagicName+'"  value=\''+csrfMagicToken+'\'>'+
				    '<input type="hidden" value="" name="targetid" id="targetid" />'+
				    '<input type="hidden" value="" name="groupby" id="groupby" />'+
				    '<input type="hidden" value="" name="monthly" id="monthly" />'+
				    '<input type="hidden" value="" name="quaterly" id="quaterly" />'+
				    '<input type="hidden" value="" name="annually" id="annually" /></form>';
			}	
		
			var ele = jQuery(newEle);
			
		  	var headerContainer = jQuery('div.exportcontainer');
			var form = ele.appendTo(headerContainer);
	 		form.find('#targetid').val(targetid); 
		
			form.find('#groupby').val(groupby); 
			form.find('#monthly').val(monthly); 
			form.find('#quaterly').val(quaterly); 
			form.find('#annually').val(annually); 
			form.submit();
		});	
	},
	registerEvents : function() { 
		this.ReportTarget();
	}
	
});

jQuery(document).ready(function(){
	var salesTargetInstance = new SalesTarget_Target_Js();
	 salesTargetInstance.registerEvents();
})

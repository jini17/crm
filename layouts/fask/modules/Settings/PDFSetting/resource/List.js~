/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Settings_Vtiger_List_Js("Settings_PDFSetting_List_Js",{},{
	
	/*
	 * function to load CKEditor
	 */
	loadCkEditor : function(){ 

		var instance = CKEDITOR.instances['customfooter'];
		if(instance)
		{
			CKEDITOR.remove(instance);
		}
	
	//configured ckeditor toolbar for vtiger
	var Vtiger_ckeditor_toolbar = 
	[
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink'],
		['Source','-','NewPage','Preview','Templates'],
		'/',
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
									['Table','HorizontalRule','SpecialChar','PageBreak','TextColor','BGColor'], //,'Smiley','UniversalKey'],
		'/',
		['Styles','Format','Font','FontSize']
	];
    CKEDITOR.replace( 'customfooter',
	{
		fullPage :true,
		extraPlugins : '',
		toolbar : Vtiger_ckeditor_toolbar
	});
		CKEDITOR.config.fontSize_sizes = '8/8pt;9/9pt;10/10pt;11/11pt;12/12pt;14/14pt;16/16pt;18/18pt;20/20pt;22/22pt;24/24pt;26/26pt;28/28pt;36/36pt;48/48pt;72/72pt';
	},
	

	registerAction : function() {

		jQuery('#showgroupno').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnNo').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnNo').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgrouporder').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnOrderCode').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnOrderCode').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgroupitem').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnItemId').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnItemId').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgroupsqm').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnQty').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnQty').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgroupunit').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnUnit').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnUnit').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgpricesqm').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnUnitPrice').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnUnitPrice').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgroupdiscount').on('change', function(e) {
			if (this.checked) {
			    jQuery('th#pdfColumnDiscount').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnDiscount').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showgroupamount').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#pdfColumnTotal').fadeIn('slow');
			  } else {
			    jQuery('th#pdfColumnTotal').fadeOut('slow');
			  }                   			 
		});


	},

	registerActionIndTax : function() {

		jQuery('#showindno').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxNo').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxNo').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindorder').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxOrderCode').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxOrderCode').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showinditem').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxItemId').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxItemId').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindsqm').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxQty').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxQty').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindunit').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxUnit').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxUnit').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindpricesqm').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxUnitPrice').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxUnitPrice').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showinddiscount').on('change', function(e) {
			if (this.checked) {
			    jQuery('th#indTaxDiscount').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxDiscount').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindgst').on('change', function(e) {
			if (this.checked) {
			    jQuery('th#indTaxGst').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxGst').fadeOut('slow');
			  }                   			 
		});

		jQuery('#showindamount').on('change', function(e) { 
			if (this.checked) {
			    jQuery('th#indTaxTotal').fadeIn('slow');
			  } else {
			    jQuery('th#indTaxTotal').fadeOut('slow');
			  }                   			 
		});


	},
	
	registerActionChangeMod : function() {
		jQuery('#displaymodul').on('change', function(e) { 
			var displayMod = jQuery('#displaymodul').val();
			//alert(displayMod);
		 	var ActionUrl = 'index.php?parent=Settings&module=PDFSetting&view=List&block=4&fieldid=3&displaymodul='+displayMod ;
			window.location.href = ActionUrl;
		});	

	},

	savePDFSetting : function(form) {
		var aDeferred = jQuery.Deferred();

		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
				'enabled' : true
			}
		});
		CKEDITOR.instances['customfooter'].updateElement();
		var data = form.serializeFormData();
		data['module'] = app.getModuleName();//which is PDFSetting
		data['parent'] = app.getParentModuleName();//which is Settings
		data['action'] = 'Save';
		AppConnector.request(data).then(
			function(data) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.resolve(data);
			},
			function(error) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				//TODO : Handle error
				aDeferred.reject(error);
			}
		);
		return aDeferred.promise();
	},



	registerEvents : function() {
		//this._super();

		this.registerAction();
		this.registerActionIndTax();
		this.registerActionChangeMod();

		this.loadCkEditor();
		
		var thisInstance = this;
		var form = jQuery('#pdfsettingsform');
		form.submit(function(e) {
			e.preventDefault();
				
			//save the customer portal settings
			thisInstance.savePDFSetting(form).then(
				function(data) {
					var result = data['result'];
					if(result['success']) {
						var params = {
							text: app.vtranslate('JS_PDFSETTING_SAVED')
						}
						Settings_Vtiger_Index_Js.showMessage(params);
					}
				},
				function(error){
					//TODO: Handle Error
				}
			);
		});
	}

});



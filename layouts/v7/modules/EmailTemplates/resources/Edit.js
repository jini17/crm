/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("EmailTemplates_Edit_Js",{},{
	
	/**
	 * Function to register event for ckeditor for description field
	 */
	registerEventForCkEditor : function(){
		var templateContentElement = jQuery("#templatecontent");
		if(templateContentElement.length > 0) {
			if(jQuery('#EditView').find('.isSystemTemplate').val() == 1) {
				templateContentElement.removeAttr('data-validation-engine').addClass('ckEditorSource');
			}
            var customConfig = {
                "height":"300px"
            }  
           
			var ckEditorInstance = new Vtiger_CkEditor_Js();
			ckEditorInstance.loadCkEditor(templateContentElement,customConfig);
			jQuery(".padding-bottom1per").prepend('<span id="charlen"></span>').css({'color':'#d61b1b'});

               var editorContent = jQuery(CKEDITOR.instances.templatecontent.getData());
               var plainEditorContent = editorContent.text();

			if(jQuery('#EditView').find('[name="record"]').val() !=''){
     			 jQuery("#charlen").html("Total Characters :"+(plainEditorContent.length-6));
     		} else {
     		     jQuery("#charlen").html("Total Characters :"+(plainEditorContent.length));
     		}	
		}
        this.registerFillTemplateContentEvent();
		
	},
	
	/**
	 * Function which will register module change event
	 */
	registerChangeEventForModule : function(){
		var thisInstance = this;
		var advaceFilterInstance = Vtiger_AdvanceFilter_Js.getInstance();
		var filterContainer = advaceFilterInstance.getFilterContainer();
		filterContainer.on('change','select[name="modulename"]',function(e){
			thisInstance.loadFields();
		});
	},
	
	/**
	 * Function to load condition list for the selected field
	 * @params : fieldSelect - select element which will represents field list
	 * @return : select element which will represent the condition element
	 */
	loadFields : function() {
		var moduleName = jQuery('select[name="modulename"]').val();
		var allFields = jQuery('[name="moduleFields"]').data('value');
		var fieldSelectElement = jQuery('select[name="templateFields"]');
		var options = '';
		for(var key in allFields) {
			//IE Browser consider the prototype properties also, it should consider has own properties only.
			if(allFields.hasOwnProperty(key) && key == moduleName) {
				var moduleSpecificFields = allFields[key];
				var len = moduleSpecificFields.length;
				for (var i = 0; i < len; i++) {
					var fieldName = moduleSpecificFields[i][0].split(':');
					options += '<option value="'+moduleSpecificFields[i][1]+'"';
					if(fieldName[0] == moduleName) {
						options += '>'+fieldName[1]+'</option>';
					} else {
						options += '>'+moduleSpecificFields[i][0]+'</option>';
					}
				}
			}
		}
		
		if(options == '')
			options = '<option value="">NONE</option>';
		
		fieldSelectElement.empty().html(options);
        fieldSelectElement.select2("destroy");
        fieldSelectElement.select2();
        
		return fieldSelectElement;
		
	},

	/**
	 * Function to Show Hide Some Fields
	 * Added By Mabruk on 02/05/2018
	 * for Meeting Templates 
	 */
	showHideFields : function() { 

		var fields = jQuery('#extraFields');

		if (jQuery('#templateType :selected').val() == 'Meeting Templates')
			fields.hide();
		else
			fields.show();

		jQuery('#templateType').change(function(){ 
			if (jQuery('#templateType :selected').val() == 'Meeting Templates')
				fields.hide();
			else
				fields.show();				
		});
	}, 	

	registerFillTemplateContentEvent : function() {
		var thisInstance = this;
		 CKEDITOR.instances.templatecontent.on('blur', function(){
			 jQuery('#templateFields,#generalFields').off('change');
			 jQuery('#templateFields,#generalFields').on('change',function(e){
				var mergeTag = jQuery(e.currentTarget).val();
				var textarea = CKEDITOR.instances.templatecontent;
				textarea.insertHtml(mergeTag);
			 });
		 });
		 jQuery('.recordEditView').on('blur','#EmailTemplates_editView_fieldName_subject',function(){
			 jQuery('#templateFields,#generalFields').off('change');
			 jQuery('#templateFields,#generalFields').on('change',function(e){
				var mergeTag = jQuery(e.currentTarget).val();
				thisInstance.insertValueAtCursorPosition();
				jQuery('#EmailTemplates_editView_fieldName_subject').insertAtCaret(mergeTag);
			});
		});
	},
    
	insertValueAtCursorPosition: function() {
		$.fn.extend({
			insertAtCaret: function(myValue) {
				var obj;
				if (typeof this[0].name !== 'undefined'){
					obj = this[0];
                } else {
					obj = this;
                }
                
                // $.browser got deprecated from jQuery 1.9
                // Inorder to know browsername, we are depending on useragent
                var browserInfo  = navigator.userAgent.toLowerCase();
				if (browserInfo.indexOf('msie') !== -1) {
					obj.focus();
					sel = document.selection.createRange();
					sel.text = myValue;
					obj.focus();
				} else if (browserInfo.indexOf('mozilla') !== -1 || browserInfo.indexOf('webkit')!==-1) {
					var startPos = obj.selectionStart;
					var endPos = obj.selectionEnd;
					var scrollTop = obj.scrollTop;
					obj.value = obj.value.substring(0, startPos) + myValue + obj.value.substring(endPos, obj.value.length);
					obj.focus();
					obj.selectionStart = startPos + myValue.length;
					obj.selectionEnd = startPos + myValue.length;
					obj.scrollTop = scrollTop;
				} else {
					obj.value += myValue;
					obj.focus();
				}
			}
		});
	},
	
	registerCharacterlength :function(){
       /*  CKEDITOR.instances.templatecontent.on("key", function (event)
          { 
               var editorContent = jQuery(CKEDITOR.instances.templatecontent.getData());
               var plainEditorContent = editorContent.text();
               
              
		     
          });
       */   
          CKEDITOR.instances.templatecontent.on('contentDom', function() {
               CKEDITOR.instances.templatecontent.document.on('keyup', function(event) { 
               jQuery("#charlen").html('');
               jQuery(".padding-bottom1per").prepend('<span id="charlen"></span>').css({'color':'#d61b1b'});
               var editorContent = jQuery(CKEDITOR.instances.templatecontent.getData());
               var plainEditorContent = editorContent.text();
               jQuery("#charlen").html("Total Characters :"+(plainEditorContent.length-6));
              
               });
           })
       
          /*CKEDITOR.instances.templatecontent.on("change", function (event)
          { 
               var editorContent = jQuery(CKEDITOR.instances.templatecontent.getData());
          alert(editorContent.data.keyCode);
               var plainEditorContent = editorContent.text();
                  jQuery("#charlen").html('');
                  jQuery(".padding-bottom1per").prepend('<span id="charlen"></span>').css({'color':'#d61b1b'});
			   jQuery("#charlen").html("Total Characters :"+(plainEditorContent.length-6));
          });*/
     },	
	
	registerPageLeaveEvents : function() {
            app.helper.registerLeavePageWithoutSubmit(this.getForm());
	},
	/**
	 * Registered the events for this page
	 */
	registerEvents : function() {
		this.registerEventForCkEditor();
		this.showHideFields();
		this.registerChangeEventForModule();
		this.registerCharacterlength();
	//	this.loadContentOnTemplateChange();
		//To load default selected module fields in edit view
		this.loadFields();

		if (window.hasOwnProperty('Settings_Vtiger_Index_Js')) {
			var instance = new Settings_Vtiger_Index_Js();
			instance.registerBasicSettingsEvents();
		}
		this._super();
	}
});

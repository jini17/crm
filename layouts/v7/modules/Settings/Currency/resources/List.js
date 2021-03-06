/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
Settings_Currency_Js('Settings_Currency_List_Js', {}, {


/****** add for sequence of Currency list js*************/
/****** start********/
	    registerSaveEvent : function() {
		var thisInstance = this;
        jQuery('#cronJobSaveAjax').on('submit',function(e){
            e.preventDefault();
            var form = jQuery(e.currentTarget);
	
			var timeFormat = jQuery('#time_format').val();
			var frequencyElement = jQuery('#frequencyValue');
			var frequencyValue = frequencyElement.val() * 60;
			if (timeFormat == 'hours') {
				frequencyValue = frequencyValue * 60;
			}

			var minimumFrequency = jQuery('#minimumFrequency').val();
			if (frequencyValue < minimumFrequency) {
				var message = app.vtranslate('JS_VALUE_SHOULD_NOT_BE_LESS_THAN');
				var minutes = app.vtranslate('JS_MINUTES');
				vtUtils.showValidationMessage(frequencyElement, message+' '+(minimumFrequency / 60)+' '+minutes, {
                    position: {
                        my: 'bottom left',
                        at: 'top left',
                        container: frequencyElement.closest('.form-group')
                    }
                });
				e.preventDefault();
				return;
			} else {
				jQuery('#frequency').val(frequencyValue);
			}
			app.helper.showProgress();
			app.helper.hideModal();
            var params = form.serializeFormData();
            
            app.request.post({"data":params}).then(function(err,data){

                if(err === null) {
                    app.helper.hideProgress();
                    thisInstance.loadListViewRecords();
                }else{
                    app.helper.showErrorNotification({'message':err.message});
                }
            });
			e.preventDefault();
		});
	},
    
    loadListViewRecords : function(urlParams) {
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        var defParams = this.getDefaultParams();
        if(typeof urlParams === "undefined") {
            urlParams = {};
        }
        if(typeof urlParams.search_params === "undefined") {
            urlParams.search_params = JSON.stringify(thisInstance.getListSearchParams(false));
        }
        urlParams = jQuery.extend(defParams, urlParams);
        app.helper.showProgress();
		
        app.request.get({data:urlParams}).then(function(err, res){
            aDeferred.resolve(res);
            var container = thisInstance.getListViewContainer();
			container.html(res);
            thisInstance.registerSortableEvent(); 
            app.helper.hideProgress();
            app.event.trigger('post.listViewFilter.click');
		});
        return aDeferred.promise();
    },
    
    
    registerSortableEvent : function() {
		var thisInstance = this;
		var sequenceList = {};
		var tbody = jQuery('tbody');
		
		tbody.sortable({
			'helper' : function(e,ui){
				//while dragging helper elements td element will take width as contents width
				//so we are explicity saying that it has to be same width so that element will not
				//look like distrubed
				ui.children().each(function(index,element){
					element = jQuery(element);
					element.width(element.width());
				});
                return ui;
			},
			'containment' : tbody,
			'revert' : true,
			update: function(e, ui ) {
				jQuery('tbody tr').each(function(i){
					sequenceList[++i] = jQuery(this).data('id');
                    
				});
				var params = {
					sequencesList : JSON.stringify(sequenceList),
					module : app.getModuleName(),
					parent : app.getParentModuleName(),
					action : 'UpdateSequence'
				};
				app.request.post({"data":params}).then(function(err,data) { 
                         if(err === null){
                              var successfullSaveMessage = app.vtranslate('JS_CURRENCY_SEQUENCE_UPDATED');
                              app.helper.showSuccessNotification({'message':successfullSaveMessage});
						thisInstance.loadListViewRecords(); 
                         }
				});
			}
		});
	},
/*******        end     **********/
	

	init : function() {
        this._super();
		this.addComponents();
		//Added By Mabruk
		var vtigerSettings = new Settings_Vtiger_Index_Js();
		vtigerSettings.registerAccordionClickEvent();
		this.registerSortableEvent();
		this.registerPostListLoadListener();
	},
	
	addComponents : function() {
		this.addModuleSpecificComponent('Index','Vtiger',app.getParentModuleName());
	}
});

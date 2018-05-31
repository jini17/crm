Vtiger_List_Js("Timesheet_Listview_Js", {},
	{
		moduleEdit : false,
		formElement : false,
		getForm : function() {
			if(this.formElement === false){
				this.formElement = jQuery('#EditView');
			}
			return this.formElement;
		},
		/*
		 * Function to get reference select popup parameters
		 */
		getPopUpParams : function(container) {
			var params = {};
			var sourceModule = app.getModuleName();
			var editTaskContainer = jQuery('[name="editTask"]');
			if(editTaskContainer.length > 0){
				sourceModule = editTaskContainer.find('#sourceModule').val();
			}
			var quickCreateConatiner = jQuery('[name="QuickCreate"]');
			if(quickCreateConatiner.length!=0){
				sourceModule = quickCreateConatiner.find('input[name="module"]').val();
			}
			var searchResultContainer = jQuery('#searchResults-container');
			if(searchResultContainer.length) {
				sourceModule = jQuery('select#searchModuleList').val();
			}
			var popupReferenceModuleElement = jQuery('input[name="popupReferenceModule"]',container).length ?
				jQuery('input[name="popupReferenceModule"]',container) : jQuery('input.popupReferenceModule',container);
			var popupReferenceModule = popupReferenceModuleElement.val();
			var sourceFieldElement = jQuery('input[class="sourceField"]',container);
			if(!sourceFieldElement.length) {
				sourceFieldElement = jQuery('input.sourceField',container);
			}
			var sourceField = sourceFieldElement.attr('name');
			var sourceRecordElement = jQuery('input[name="record"]');
			var sourceRecordId = '';
			var recordId = app.getRecordId();
			if(sourceRecordElement.length > 0) {
				sourceRecordId = sourceRecordElement.val();
			} else if(recordId) {
				sourceRecordId = recordId;
			} else if(app.view() == 'List') {
				var editRecordId = jQuery('#listview-table').find('tr.listViewEntries.edited').data('id');
				if(editRecordId) {
					sourceRecordId = editRecordId;
				}
			}

			if(searchResultContainer.length) {
				sourceRecordId = searchResultContainer.find('tr.listViewEntries.edited').data('id')
			}

			var isMultiple = false;
			if(sourceFieldElement.data('multiple') == true) {
				isMultiple = true;
			}

			// TODO : Need to recheck. We don't have reference field module name if that module is disabled
			if(typeof popupReferenceModule == "undefined"){
				popupReferenceModule = "undefined";
			}

			var params = {
				'module' : popupReferenceModule,
				'src_module' : sourceModule,
				'src_field' : sourceField,
				'src_record' : sourceRecordId
			}

			if(isMultiple) {
				params.multi_select = true ;
			}
			return params;
		},

		/*
		 * Function to set reference field value
		 */
		setReferenceFieldValue : function(container, params) {
			var sourceField = container.find('input.sourceField').attr('name');
			var fieldElement = container.find('input[name="'+sourceField+'"]');
			var sourceFieldDisplay = sourceField+"_display";
			var fieldDisplayElement = container.find('input[name="'+sourceFieldDisplay+'"]');
			var popupReferenceModuleElement = container.find('input[name="popupReferenceModule"]').length ? container.find('input[name="popupReferenceModule"]') : container.find('input.popupReferenceModule');
			var popupReferenceModule = popupReferenceModuleElement.val();
			var selectedName = params.name;
			var id = params.id;

			if (id && selectedName) {
				if(!fieldDisplayElement.length) {
					fieldElement.attr('value',id);
					fieldElement.data('value', id);
					fieldElement.val(selectedName);
				} else {
					fieldElement.val(id);
					fieldElement.data('value', id);
					fieldDisplayElement.val(selectedName);
					if(selectedName) {
						fieldDisplayElement.attr('readonly', 'readonly');
					} else {
						fieldDisplayElement.removeAttr("readonly");
					}
				}

				if(selectedName) {
					fieldElement.parent().find('.clearReferenceSelection').removeClass('hide');
					fieldElement.parent().find('.referencefield-wrapper').addClass('selected');
				}else {
					fieldElement.parent().find('.clearReferenceSelection').addClass('hide');
					fieldElement.parent().find('.referencefield-wrapper').removeClass('selected');
				}
				fieldElement.trigger(Vtiger_Edit_Js.referenceSelectionEvent, {'source_module' : popupReferenceModule, 'record' : id, 'selectedName' : selectedName});
			}
		},

		/*
		 * Function to get referenced module name
		 */
		getReferencedModuleName : function(parentElement) {
			var referenceModuleElement = jQuery('input[name="popupReferenceModule"]',parentElement).length ?
				jQuery('input[name="popupReferenceModule"]',parentElement) : jQuery('input.popupReferenceModule',parentElement);
			return referenceModuleElement.val();
		},

		/*
		 * Function to show quick create modal while creating from reference field
		 */
		referenceCreateHandler : function(container) {
			var thisInstance = this;
			var postQuickCreateSave = function(data) {
				var module = thisInstance.getReferencedModuleName(container);
				var params = {};
				params.name = data._recordLabel;
				params.id = data._recordId;
				params.module = module;
				thisInstance.setReferenceFieldValue(container, params);

				var tdElement = thisInstance.getParentElement(container.find('[value="'+ module +'"]'));
				var sourceField = tdElement.find('input[class="sourceField"]').attr('name');
				var fieldElement = tdElement.find('input[name="'+sourceField+'"]');
				thisInstance.autoFillElement = fieldElement;
				thisInstance.postRefrenceSearch(params, container);

				tdElement.find('input[class="sourceField"]').trigger(Vtiger_Edit_Js.postReferenceQuickCreateSave, {'data' : data});
			}

			var referenceModuleName = this.getReferencedModuleName(container);
			var quickCreateNode = jQuery('#quickCreateModules').find('[data-name="'+ referenceModuleName +'"]');
			if(quickCreateNode.length <= 0) {
				var notificationOptions = {
					'title' : app.vtranslate('JS_NO_CREATE_OR_NOT_QUICK_CREATE_ENABLED')
				}
				app.helper.showAlertNotification(notificationOptions);
			}
			quickCreateNode.trigger('click',[{'callbackFunction':postQuickCreateSave}]);
		},

		/**
		 * Function to get reference search params
		 */
		getReferenceSearchParams : function(element){
			var tdElement = this.getParentElement(element);
			var params = {};
			var referenceModuleElement = jQuery('input[name="popupReferenceModule"]',tdElement).length ?
				jQuery('input[name="popupReferenceModule"]',tdElement) : jQuery('input.popupReferenceModule',tdElement);
			var searchModule = referenceModuleElement.val();
			params.search_module = searchModule;
			return params;
		},

		searchModuleNames : function(params) {
			var aDeferred = jQuery.Deferred();

			if(typeof params.module == 'undefined') {
				params.module = app.getModuleName();
			}

			if(typeof params.action == 'undefined') {
				params.action = 'BasicAjax';
			}

			if(typeof params.base_record == 'undefined') {
				var record = jQuery('[name="record"]');
				var recordId = app.getRecordId();
				if(record.length) {
					params.base_record = record.val();
				} else if(recordId) {
					params.base_record = recordId;
				} else if(app.view() == 'List') {
					var editRecordId = jQuery('#listview-table').find('tr.listViewEntries.edited').data('id');
					if(editRecordId) {
						params.base_record = editRecordId;
					}
				}
			}
			app.request.get({data:params}).then(
				function(err, res){
					aDeferred.resolve(res);
				},
				function(error){
					//TODO : Handle error
					aDeferred.reject();
				}
			);
			return aDeferred.promise();
		},

		/*
		 * Function to get Field parent element
		 */
		getParentElement : function(element) {
			var parent = element.closest('.vtereference');
			// added to support from all views which may not be table format
			/*if(parent.length === 0) {
				parent = element.closest('.td').length ?
					element.closest('.td') : element.closest('.fieldValue');
			}*/
			return parent;
		},
		getBasicRow : function(container) {
			var basicRow = container.find('.TimesheetRecordsClone');
			var newRow = basicRow.clone();
			return newRow.removeClass('hide TimesheetRecordsClone');
		},
		registerEventForDeleteButton : function(container,id){
			var thisInstance = this;
			jQuery('.deleteTimesheetButton').on('click', function (e) {
				var elem = jQuery(e.currentTarget);
				var parent = elem;
				var params = {};

				var moduleName = app.getModuleName();
				if (moduleName && typeof moduleName != 'undefined') {
					params['module'] = moduleName;
				}

				var recordId = elem.data('record-id');
				if(recordId){
					thisInstance.deleteRecord(recordId, params);
				}else{
					var currentRow = elem.closest("tr");
					var curRowTd = currentRow.find("td");
					if(curRowTd.length <=7){
						var rowBefore = currentRow.prevAll( ".timesheetRecords:first" );
						var rowBeforeTdFirst = rowBefore.find("td.listViewEntryValue");
						var numRow = rowBeforeTdFirst.attr('rowspan');
						rowBefore.find('td.listViewEntryValue:first').attr('rowspan', parseInt(numRow) - 1);
						rowBefore.find('td.worked').attr('rowspan', parseInt(numRow) - 1);
						currentRow.closest('.timesheetRecords').remove();
					}else {
						currentRow.find('.fieldValue').html('');
						thisInstance.registerEventForDetailAddMoreButton();
					}
				}
				timesheetEdit = false;
			});
		},
		_deleteRecord: function (recordId, extraParams) {
			var thisInstance = this;
			var module = app.getModuleName();
			var postData = {
				"data": {
					"module": module,
					"action": "DeleteAjax",
					"record": recordId,
					"parent": app.getParentModuleName(),
					"viewname": this.getCurrentCvId()

				}
			};

			if (typeof extraParams === 'undefined') {
				extraParams = {};
			}
			jQuery.extend(postData.data, extraParams);

			app.helper.showProgress();
			app.request.post(postData).then(
				function (err, data) {
					if (err == null) {
						app.helper.hideProgress();
						location.reload();//thisInstance.loadListViewRecords();
					} else {
						app.helper.hideProgress();
						app.helper.showErrorNotification({message: app.vtranslate(err.message)})
					}
				});
		},
		deleteRecord: function (recordId, extraParams) {
			var thisInstance = this;
			var message = app.vtranslate('LBL_DELETE_CONFIRMATION');
			app.helper.showConfirmationBox({'message': message}).then(function () {
				thisInstance._deleteRecord(recordId, extraParams);
			});
		},
		registerEventForDetailSaveButton: function (container) {
			var thisInstance = this;
			var current_url = jQuery.url();
			var userId = current_url.param('userid');
			jQuery('[name="time_in"],[name="time_out"]').on("change", function(e){
				var element = jQuery(e.currentTarget);
				var inTdElement = element.closest('tr');
				var elementIn = inTdElement.find('#Timesheet_editView_fieldName_time_in');
				var elementOut = inTdElement.find('#Timesheet_editView_fieldName_time_out');
				elementOut.timepicker('option', 'minTime', elementIn.val());
				var timeStart = new Date("01/01/2001 " + elementIn.val());
				var timeEnd = new Date("01/01/2001 " + elementOut.val());
				var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds
				var minutes = diff % 60;
				minutes = (minutes == 0)? ('0'+minutes):minutes;
				var hours = (diff - minutes) / 60;
				hours = (hours < 10)? ('0'+hours):hours;
				if (diff > 0) {
					inTdElement.find('#Timesheet_editView_fieldName_total').val(hours + ":" + minutes);
				}else {
					inTdElement.find('#Timesheet_editView_fieldName_total').val('');
				}
			});
			var dayStartTime = jQuery('#txtDayStartTime').val();
			var dayEndTime = jQuery('#txtDayEndTime').val();
			$('input.ui-timepicker-input').timepicker('option', 'minTime', dayStartTime);
			$('input.ui-timepicker-input').timepicker('option', 'maxTime', dayEndTime);
			//add new record
			jQuery('.saveTimesheetButton').on('click', function (e) {
				app.helper.showProgress();
				elem = jQuery(e.currentTarget);
				var recordId = elem.data('record-id');
				var timesheetdate = elem.attr('record-date');
				var data = {};
				data['module'] = 'Timesheet';
				data['action'] = 'ActionAjax';
				data['mode'] = 'saveRecord';
				data['userid'] = userId;
				data['recordid'] = recordId;
				data['timesheetdate'] = timesheetdate;

				var mesError= '';
				var relatedRecords=jQuery(e.currentTarget).closest('tr');
				relatedRecords.find(':input').each(function(i,e) {
					if(typeof jQuery(e).attr('name') != 'undefined') {
						data[jQuery(e).attr('name')] = jQuery(e).val();
						if (jQuery(e).val() == '' && jQuery(e).attr('name') !='description' && jQuery(e).attr('name') !='total' && jQuery(e).attr('name') !='related_to_display'&& jQuery(e).attr('name') !='related_to') {
							mesError += jQuery(e).attr('field_label') + ' field is required<br>';
						}
					}
				});
				var timeStart = new Date("01/01/2001 " + data['time_in']);
				var timeEnd = new Date("01/01/2001 " + data['time_out']);
				var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds
				if (diff <= 0){
					mesError = 'Time In can not be greater than Time Out';
				}
				if(mesError !='') {
					app.helper.hideProgress();
					app.helper.showErrorNotification({message: mesError})
					return false;
				}
				if(typeof timesheetdate != 'undefined') {
					app.request.post({data: data}).then(
						function (err, data) {
							if (err == null && data) {
								app.helper.hideProgress();
								var related_record = data.related_record;
								var params = {};
								params.message = app.vtranslate('Record Saved');
								app.helper.showSuccessNotification(params);
								location.reload();
							}
						}
					);
				}
			});
		},
		registerEventForAddNewRow: function (container) {
			var thisInstance = this;
			var newRow = jQuery('.TimesheetRecordsClone').clone();
			var currentRow = container.closest("tr.timesheetRecords");
			newRow.removeClass("TimesheetRecordsClone");
			newRow.removeClass("hide");
			newRow.addClass('timesheetRecords');
			newRow.find(':input').removeAttr("disabled");
			newRow.find('input,select').each(function (idx,ele) {
				if(jQuery(ele).hasClass('input-medium')) {
					jQuery(ele).removeClass('input-medium').addClass('input-small');
				}else if(jQuery(ele).hasClass('input-large') || jQuery(ele).is('select')) {
					jQuery(ele).removeClass('input-large');//.addClass('input-medium');
					jQuery(ele).css('width', '130px')
				}else if(jQuery(ele).hasClass('dateField')) {
					jQuery(ele).css('width', '91px');
					jQuery(ele).parent().css('display', 'none');
					jQuery(ele).val(container.attr('data-date'));
				}
				if(ele.name=='total') {
					jQuery(ele).attr('disabled','disabled');
				}
				jQuery(ele).attr('data-validation-engine','validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]');
			});
			var currentFirstTd = currentRow.find("td.listViewEntryValue");
			container.closest("tr.timesheetRecords").html(newRow.html());
			currentRow.prepend("<td>" + currentFirstTd.html() + "</td>");
			currentRow.find('td.fieldValue:first').remove();

			newRow.find(".select2-container.select2").remove();
			vtUtils.applyFieldElementsView(newRow);
			newRow.find(".select2-container.select2").css({"width": "100%"});
			thisInstance.registerEventForDeleteButton(newRow);
			thisInstance.registerEventForDetailSaveButton(newRow);
			var indexInstance = Vtiger_Index_Js.getInstance();
			indexInstance.referenceModulePopupRegisterEvent(newRow);
            thisInstance.referenceModulePopupRegisterEvent(container);
            thisInstance.registerAutoCompleteFields(container);
		},
		// Register event for add more button
		registerEventForDetailAddMoreButton: function (container) {
			var thisInstance = this;
			// Add disable to template row of list
			jQuery('.btnAddMore').on('click', function (e) {
				if(timesheetEdit) return;
				timesheetEdit = true;
				var relatedRecordsClone = jQuery('.TimesheetRecordsClone');
				relatedRecordsClone.find(':input').attr("disabled","disabled");
				var element = jQuery(e.currentTarget);
				var curDate = element.attr('data-date');
				var currentRow = element.closest("tr.timesheetRecords");
				var currentFirstTd = currentRow.find("td.listViewEntryValue");
				var elementNext = currentRow.nextAll('tr.timesheetRecords:first');
				var currentRowNumber=jQuery('.timesheetRecords', currentRow).length;
				var sequenceNumber=currentRowNumber+1;
				var container = element.closest('div.timesheetRecords');
				var listViewEntriesTable=container.find('table.listViewEntriesTable');
				var newRow = thisInstance.getBasicRow(container).addClass('timesheetRecords');
				if(currentRow.find('td span.actionImages').length>0){
					var numRow = currentFirstTd.attr('rowspan');
					currentRow.find('td.listViewEntryValue:first').attr('rowspan',parseInt(numRow)+1);
					var newRowFirstTd = newRow.find("td.fieldValue");
					newRow.find('td.fieldValue:first').append(newRowFirstTd.html());
					newRow.find('td.fieldValue:first').remove();
					newRow.find('td:last').remove();
					currentRow.find('td.worked').attr('rowspan',parseInt(numRow)+1);
				}else{
					newRow.find('td.fieldValue:first').append(currentFirstTd.html());
					newRow.find('td:first').removeClass('fieldValue');
					newRow.find('td:first').addClass('listViewEntryValue');
					currentRow.remove();
				}

				newRow.find(':input').removeAttr("disabled");
				elementNext.before(newRow);
				newRow.find('input,select').each(function (idx,ele) {
					if(jQuery(ele).hasClass('input-medium')) {
						jQuery(ele).removeClass('input-medium').addClass('input-small');
					}else if(jQuery(ele).hasClass('input-large') || jQuery(ele).is('select')) {
						jQuery(ele).removeClass('input-large');//.addClass('input-medium');
						jQuery(ele).css('width', '130px')
					}else if(jQuery(ele).hasClass('dateField')) {
						jQuery(ele).css('width', '91px');
						jQuery(ele).parent().css('display', 'none');
						jQuery(ele).val(element.attr('data-date'));
					}
					if(ele.name=='total') {
						jQuery(ele).attr('disabled','disabled');
					}
					jQuery(ele).attr('field_label',jQuery(ele).closest('td.fieldValue').attr('field_label'));
					//jQuery(ele).attr('data-validation-engine','validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]');
				});
				newRow.find('a.saveTimesheetButton').attr('record-date',curDate);
				newRow.find(".select2-container.select2").remove();
				vtUtils.applyFieldElementsView(newRow);
				newRow.find(".select2-container.inputElement.select2").css({"width": "100%"});
				thisInstance.registerEventForDeleteButton(newRow);
				thisInstance.registerEventForDetailSaveButton(newRow);
				var indexInstance = Vtiger_Index_Js.getInstance();
				indexInstance.referenceModulePopupRegisterEvent(newRow);
				indexInstance.registerAutoCompleteFields(newRow);				
			});
		},
		initializeWidgets: function () {
			var thisInstance = this;
			var widgets = jQuery('.sidebar-widget');
			jQuery.each(widgets, function () {
				var widget = jQuery(this);
				var widgetHeader = widget.find('.sidebar-widget-header');
				var dataUrl = widgetHeader.data('url');
				var dataParams = app.convertUrlToDataParams(dataUrl);
				var widgetBody = widget.find('.sidebar-widget-body');
				app.request.post({data: dataParams}).then(function (e, data) {
					if (!e) {
						widgetBody.html(data);
						app.helper.showVerticalScroll(
							widgetBody,
							{
								'autoHideScrollbar': true,
								'scrollbarPosition': 'outside'
							}
						);
						//app.event.trigger(Calendar_Calendar_Js.feedsWidgetPostLoadEvent, widget);
					} else {
						console.log("error in response : ", e);
					}
				});
			});
		},
		registerAddTimesheetUsers : function(){
			var thisInstance = this;
			jQuery('#addTimesheetUsers').on('click',function(event){
				var url='module=Timesheet&related_module=Users&src_module=Accounts&src_record=52&view=Popup';
				var record='52';
				thisInstance.showSelectRelationPopup( url, record) ;
			});
		},
		registerPayPeriodClickEvent : function(){
			var thisInstance = this;
			var current_url = jQuery.url();
			var userid = current_url.param('userid');
			jQuery('#slbPeriodDuration').on('change',function(event){
				var val = $(event.target).val();
				var url='index.php?module=Timesheet&view=Listview&payperiod='+val;
				if('undefined'!= typeof userid)
					url+='&userid='+userid;
				location.href= url;
			});
			var payperiod = '';
			if('undefined'!= typeof payperiod) payperiod = current_url.param('payperiod');
			$("#slbPeriodDuration").val(payperiod);

			jQuery('#cbLockTimesheet').change(function(e) {
				var thisInstance = this;
				var curUserId = '';
				if('undefined'!= typeof userid) curUserId =userid;
				var element=e.currentTarget;
				var value=0;
				if(element.checked) {
					value=1;
				}
				var message = app.vtranslate('LBL_LOCK_CONFIRMATION');
				var lockTimeSheet = jQuery('#txtLockTimesheet').val();
				if(lockTimeSheet == 1) {
					var message = app.vtranslate('LBL_UNLOCK_CONFIRMATION');
					$(thisInstance).prop("checked", true);
				}else {
					$(thisInstance).prop("checked", false);
				}
				app.helper.showConfirmationBox({'message': message}).then(function (result) {
					app.helper.showProgress();
					var params = {};
					var data = {
						action:'ActionAjax',
						module: 'Timesheet',
						value: value,
						mode:'lockTimesheets',
						payperiod: payperiod,
						userid: curUserId,
					};
					params.data = data;
					app.request.post(params).then(
						function(err,data){
							if(err == null){
								app.helper.hideProgress();
								app.helper.showSuccessNotification({'message': data.message});
								location.reload();
							}
						}
					);
				});
			});
		},
		registerEmployeesClickEvent : function() {
			var thisInstance = this;
			var current_url = jQuery.url();
			var userid = current_url.param('userid');
			var element = jQuery('#vtetimesheets_employees');
			var liActive ='';
			element.find('a.showTimesheetUser').each (function() {
				var recordId = jQuery(this).attr('data-record-id');
				var liElement = jQuery(this).parent();
				if('undefined'!= typeof userid && userid != recordId) {
					liElement.removeClass('active');
				}
				if('undefined'!= typeof userid && userid == recordId) {
					liElement.addClass('active');
				}
			});
			jQuery('.showTimesheetUser').on('click', function(event){
				if(timesheetEdit){
					var r = confirm(app.vtranslate('Your user have not been setup to use timesheets.'));
					if (r != true){
						e.preventDefault();
					}
				}
				var userid = jQuery(this).data('record-id');
				var payperiod = current_url.param('payperiod');
				var url='index.php?module=Timesheet&view=Listview&userid='+userid;
				if('undefined' != typeof payperiod)
					url+='&payperiod='+payperiod;
				location.href= url;

			});
		},
		showSelectRelationPopup : function(url, record){
			var aDeferred = jQuery.Deferred();
			var thisInstance = this;
			var popupInstance = Vtiger_Popup_Js.getInstance();
			var params=thisInstance.getQueryParams(url);
			popupInstance.showPopup(params, function(responseString){
					var responseData = JSON.parse(responseString);
					var relatedIdList = Object.keys(responseData);
					var data = {};
					data['module'] = 'Timesheet';
					data['action'] = 'ActionAjax';
					data['mode'] = 'addExistedRecords';
					data['recordid'] = record;
					data['relatedIdList'] = relatedIdList;
					app.request.post({data:data}).then(
						function(err,data) {
							if (err == null && data) {
								location.reload();
							}
						}
					);
				}
			);
			return aDeferred.promise();
		},
		getQueryParams:function(qs) {
			if(typeof(qs) != 'undefined' ){
				qs = qs.toString().split('+').join(' ');
				var params = {},
					tokens,
					re = /[?&]?([^=]+)=([^&]*)/g;
				while (tokens = re.exec(qs)) {
					params[decodeURIComponent(tokens[1])] = decodeURIComponent(tokens[2]);
				}
				return params;
			}
		},
		ajaxEditHandling: function(container, currentTdElement) {
			var thisInstance = this;
			var detailViewValue = jQuery('.dplvalue',currentTdElement);
			var editElement = jQuery('.edit',currentTdElement);
			var fieldnameElement = editElement.find(':input');
			var fieldName = fieldnameElement.attr('name');
			fieldnameElement.attr('field_label',editElement.attr('field_label'));
			if(editElement.length == 0) {
				return;
			}
			detailViewValue.addClass('hide');
			editElement.removeClass('hide').show();
		},
		registerHoverEditEvent: function(container) {
			var thisInstance = this;
			jQuery('.editVTETimeSheetsButton').on('click', function (e) {
				if(timesheetEdit) return;
				timesheetEdit = true;
				var currentTdElement = jQuery(e.currentTarget);
				var currentTrElement = currentTdElement.closest('tr');
				var elemTotal = currentTrElement.find('#Timesheet_editView_fieldName_total');
				var curTotal = elemTotal.val();
				var minutes = curTotal % 60;
				minutes = (minutes == 0) ? ('0' + minutes) : minutes;
				var hours = (curTotal - minutes) / 60;
				hours = (hours < 10) ? ('0' + hours) : hours;
				elemTotal.val(hours + ":" + minutes);
				elemTotal.attr('disabled','disabled');
				var elementIn = currentTrElement.find('#Timesheet_editView_fieldName_time_in');
				var elementOut = currentTrElement.find('#Timesheet_editView_fieldName_time_out');
				elementOut.timepicker('option', 'minTime', elementIn.val());
				currentTrElement.find('td.fieldValue').each (function() {
					thisInstance.ajaxEditHandling(container, jQuery(this));
				});
			});
			jQuery('[name="time_in"],[name="time_out"]').on("change", function(e) {
				var element = jQuery(e.currentTarget);
				var inTdElement = element.closest('tr');
				var elementIn = inTdElement.find('#Timesheet_editView_fieldName_time_in');
				var elementOut = inTdElement.find('#Timesheet_editView_fieldName_time_out');
				elementOut.timepicker('option', 'minTime', elementIn.val());
				var timeStart = new Date("01/01/2001 " + elementIn.val());
				var timeEnd = new Date("01/01/2001 " + elementOut.val());
				var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds
				var minutes = diff % 60;
				minutes = (minutes == 0) ? ('0' + minutes) : minutes;
				var hours = (diff - minutes) / 60;
				hours = (hours < 10) ? ('0' + hours) : hours;
				if (diff > 0){
					inTdElement.find('#Timesheet_editView_fieldName_total').val(hours + ":" + minutes);
				}else {
					inTdElement.find('#Timesheet_editView_fieldName_total').val('');
				}
			});
			var dayStartTime = jQuery('#txtDayStartTime').val();
			var dayEndTime = jQuery('#txtDayEndTime').val();
			$('input.ui-timepicker-input').timepicker('option', 'minTime', dayStartTime);
			$('input.ui-timepicker-input').timepicker('option', 'maxTime', dayEndTime);
			//edit record
			jQuery('.saveVTETimeSheetsButton').on('click', function (e) {
				app.helper.showProgress();
				elem = jQuery(e.currentTarget);
				var recordId = elem.data('record-id');
				var timesheetdate = elem.data('record-date');
				var current_url = jQuery.url();
				var userId = current_url.param('userid');

				var data = {};
				data['module'] = 'Timesheet';
				data['action'] = 'ActionAjax';
				data['mode'] = 'saveRecord';
				data['userid'] = userId;
				data['recordid'] = recordId;
				var mesError = '';
				var relatedRecords=jQuery(e.currentTarget).closest('tr');
				relatedRecords.find(':input').each(function(i,e) {
					if(typeof jQuery(e).attr('name') != 'undefined') {
						data[jQuery(e).attr('name')] = jQuery(e).val();
						if (jQuery(e).val() == '' && jQuery(e).attr('name') !='description' && jQuery(e).attr('name') !='total' && jQuery(e).attr('name') !='related_to_display'&& jQuery(e).attr('name') !='related_to') {
							mesError += jQuery(e).attr('field_label') + ' field is required<br>';
						}
					}
				});
				var timeStart = new Date("01/01/2001 " + data['time_in']);
				var timeEnd = new Date("01/01/2001 " + data['time_out']);
				var diff = (timeEnd - timeStart) / 60000; //dividing by seconds and milliseconds
				if (diff <= 0){
					mesError = 'Time In can not be greater than Time Out';
				}

				if(mesError !='') {
					app.helper.hideProgress();
					app.helper.showErrorNotification({message: mesError})
					return false;
				}
				if(typeof timesheetdate != 'undefined') {
					data['timesheetdate'] = timesheetdate;
					app.request.post({data: data}).then(
						function (err, data) {
							if (err == null && data) {
								app.helper.hideProgress();
								var related_record = data.related_record;
								var params = {};
								params.message = app.vtranslate('Record Saved');
								app.helper.showSuccessNotification(params);
								timesheetEdit = false;
								location.reload();
							}
						}
					);
				}
			});
			jQuery('.hoverEditCancel').on('click', function (e) {
				var currentElement = jQuery(e.currentTarget);
				var currentTdElement = currentElement.closest('td');
				var currentTrElement = currentTdElement.closest('tr');
				currentTrElement.find('td.fieldValue').each (function() {
					var detailViewValue = jQuery('.dplvalue',jQuery(this));
					var editElement = jQuery('.edit',jQuery(this));
					editElement.addClass('hide');
					detailViewValue.removeClass('hide');
					e.stopPropagation();
				});
				timesheetEdit = false;
			});
		},
		/**
		 * Function which will register event for create of reference record
		 * This will allow users to create reference record from edit view of other record
		 */
		registerReferenceCreate : function(container) {
			var thisInstance = this;
			container.on('click','.createReferenceRecord', function(e) {
				var element = jQuery(e.currentTarget);
				var controlElementTd = thisInstance.getParentElement(element);
				thisInstance.referenceCreateHandler(controlElementTd);
			});
		},

		/**
		 * Funtion to register popup search event for reference field
		 * @param <jQuery> container
		 */
		referenceModulePopupRegisterEvent : function(container) {
			var thisInstance = this;
			//container.off('click', '.relatedPopup');
			container.on("click",'.relatedPopup',function(e) {
				thisInstance.openPopUp(e);
			});
			container.on('change','.referenceModulesList',function(e){
				var element = jQuery(e.currentTarget);
				var closestTD = thisInstance.getParentElement(element).next();
				var popupReferenceModule = element.val();
				var referenceModuleElement = jQuery('input[name="popupReferenceModule"]', closestTD).length ?
					jQuery('input[name="popupReferenceModule"]', closestTD) : jQuery('input.popupReferenceModule', closestTD);
				var prevSelectedReferenceModule = referenceModuleElement.val();
				referenceModuleElement.val(popupReferenceModule);

				//If Reference module is changed then we should clear the previous value
				if(prevSelectedReferenceModule != popupReferenceModule) {
					closestTD.find('.clearReferenceSelection').trigger('click');
				}
			});
		},

		/**
		 * Function to open popup list modal
		 */
		openPopUp : function(e) {
			var thisInstance = this;
			var parentElem = thisInstance.getParentElement(jQuery(e.target));

			var params = this.getPopUpParams(parentElem);
			params.view = 'Popup';

			var isMultiple = false;
			if(params.multi_select) {
				isMultiple = true;
			}

			var sourceFieldElement = jQuery('input[class="sourceField"]',parentElem);

			var prePopupOpenEvent = jQuery.Event(Vtiger_Edit_Js.preReferencePopUpOpenEvent);
			sourceFieldElement.trigger(prePopupOpenEvent);

			if(prePopupOpenEvent.isDefaultPrevented()) {
				return ;
			}
			var popupInstance = Vtiger_Popup_Js.getInstance();

			app.event.off(Vtiger_Edit_Js.popupSelectionEvent);
			app.event.one(Vtiger_Edit_Js.popupSelectionEvent,function(e,data) {
				var responseData = JSON.parse(data);
				var dataList = new Array();
				jQuery.each(responseData, function(key, value){
					var counter = 0;
					for(var valuekey in value){
						if(valuekey == 'name') continue;
						if(typeof valuekey == 'object') continue;
//					var referenceModule = value[valuekey].module;
//					if(typeof referenceModule == "undefined") {
//						referenceModule = value.module;
//					}
//					if(parentElem.find('[name="popupReferenceModule"]').val() != referenceModule) continue;
//
						var data = {
							'name' : value.name,
							'id' : key
						}
						if(valuekey == 'info') {
							data['name'] = value.name;
						}
						dataList.push(data);
						if(!isMultiple && counter === 0) {
							counter++;
							thisInstance.setReferenceFieldValue(parentElem, data);
						}
					}
				});

				if(isMultiple) {
					sourceFieldElement.trigger(Vtiger_Edit_Js.refrenceMultiSelectionEvent,{'data':dataList});
				}
				sourceFieldElement.trigger(Vtiger_Edit_Js.postReferenceSelectionEvent,{'data':responseData});
			});
			popupInstance.showPopup(params,Vtiger_Edit_Js.popupSelectionEvent,function() {});
		},
        /**
         * Function to register clear reference selection event
         * @param <jQUery> container
         */
        registerClearReferenceSelectionEvent : function(container) {
            container.off('click', '.clearReferenceSelection');
            container.on('click', '.clearReferenceSelection',function(e){
                e.preventDefault();
                var element = jQuery(e.currentTarget);
                var parentTdElement = element.closest('td');
                if(parentTdElement.length == 0){
                    parentTdElement = element.closest('.fieldValue');
                }
                var inputElement = parentTdElement.find('.inputElement');
                var fieldName = parentTdElement.find('.sourceField').attr("name");

                parentTdElement.find('.referencefield-wrapper').removeClass('selected');
                inputElement.removeAttr("disabled").removeAttr('readonly');
                inputElement.attr("value","");
                inputElement.data('value','');
                inputElement.val("");
                parentTdElement.find('input[name="'+fieldName+'"]').val("");
                element.addClass('hide');
                element.trigger(Vtiger_Edit_Js.referenceDeSelectionEvent);
            });
        },
		/**
		 * Function which will handle the reference auto complete event registrations
		 * @params - container <jQuery> - element in which auto complete fields needs to be searched
		 */
		registerAutoCompleteFields : function(container) {
			var thisInstance = this;
			container.find('input.autoComplete').autocomplete({
				'minLength' : '3',
				'source' : function(request, response){
					//element will be array of dom elements
					//here this refers to auto complete instance
					var inputElement = jQuery(this.element[0]);
					var searchValue = request.term;
					var params = thisInstance.getReferenceSearchParams(inputElement);
					params.module = app.getModuleName();
					if (jQuery('#QuickCreate').length > 0) {
						params.module = container.find('[name="module"]').val();
					}
					params.search_value = searchValue;
					if(params.search_module && params.search_module!= 'undefined') {
						thisInstance.searchModuleNames(params).then(function(data){
							var reponseDataList = new Array();
							var serverDataFormat = data;
							if(serverDataFormat.length <= 0) {
								jQuery(inputElement).val('');
								serverDataFormat = new Array({
									'label' : 'No Results Found',
									'type'	: 'no results'
								});
							}
							for(var id in serverDataFormat){
								var responseData = serverDataFormat[id];
								reponseDataList.push(responseData);
							}
							response(reponseDataList);
						});
					} else {
						jQuery(inputElement).val('');
						serverDataFormat = new Array({
							'label' : 'No Results Found',
							'type'	: 'no results'
						});
						response(serverDataFormat);
					}
				},
				'select' : function(event, ui ){
					var selectedItemData = ui.item;
					//To stop selection if no results is selected
					if(typeof selectedItemData.type != 'undefined' && selectedItemData.type=="no results"){
						return false;
					}
					var element = jQuery(this);
					var parent = element.closest('td');
					if(parent.length == 0){
						parent = element.closest('.fieldValue');
					}
					var sourceField = parent.find('.sourceField');
					selectedItemData.record = selectedItemData.id;
					selectedItemData.source_module = parent.find('input[name="popupReferenceModule"]').val();
					selectedItemData.selectedName = selectedItemData.label;
					var fieldName = sourceField.attr("name");
					parent.find('input[name="'+fieldName+'"]').val(selectedItemData.id);
					element.attr("value",selectedItemData.id);
					element.data("value",selectedItemData.id);
					parent.find('.clearReferenceSelection').removeClass('hide');
					parent.find('.referencefield-wrapper').addClass('selected');
					element.attr("disabled","disabled");
					//trigger reference field selection event
					sourceField.trigger(Vtiger_Edit_Js.referenceSelectionEvent,selectedItemData);
					//trigger post reference selection
					sourceField.trigger(Vtiger_Edit_Js.postReferenceSelectionEvent,{'data':selectedItemData});
				}
			});
		},
		registerBasicEvents : function(container) {
			this.registerAutoCompleteFields(container);
			this.referenceModulePopupRegisterEvent(container);
			this.registerClearReferenceSelectionEvent(container);
		},
		registerEvents: function() {
			this.registerEventForDetailAddMoreButton();
			this.registerEventForDeleteButton();
			this.initializeWidgets();
			this.registerAddTimesheetUsers();
			this.registerPayPeriodClickEvent();
			this.registerEmployeesClickEvent();
			this.registerHoverEditEvent();
			this.registerBasicEvents(this.getForm());
			this._super();
		}
	});
jQuery(document).ajaxComplete(function(event, xhr, settings) {
	if (settings.data && (settings.data.indexOf('mode=showPayPeriod') > -1)){
		var current_url = jQuery.url();
		var payperiod = current_url.param('payperiod');
		var slbPeriodDuration = jQuery('[name="slbPeriodDuration"]');

		if('undefined'==typeof payperiod)
			slbPeriodDuration.val($("#slbPeriodDuration option:first").val());
		else {
			slbPeriodDuration.val(payperiod);
		}
		slbPeriodDuration.trigger("liszt:updated");
		vtUtils.showSelect2ElementView($("[name='slbPeriodDuration']"));
		vtUtils.applyFieldElementsView($("[name='slbPeriodDuration']"));
		$('.timesheet-look-tooltip').popover({container: 'body'});
		instance = new Timesheet_Listview_Js();
		instance.registerPayPeriodClickEvent();
		var lockTimeSheet = jQuery('#txtLockTimesheet').val();
		if(lockTimeSheet==1) {
			jQuery('#cbLockTimesheet').prop("checked", true);
			jQuery('.timesheetLock').removeClass('hide');
		}
	}
	if (settings.data && (settings.data.indexOf('mode=getViewEmployees') > -1)){
		instance = new Timesheet_Listview_Js();
		instance.registerEmployeesClickEvent();


	}
});
$(document).on('click', 'span.value a', function(e){
	e.preventDefault();
	var url = $(this).attr('href');
	window.open(url, '_blank');
});
jQuery(document).ready(function(){
	var dayStartTime = jQuery('#txtDayStartTime').val();
	var dayEndTime = jQuery('#txtDayEndTime').val();
	var lockTimeSheet = jQuery('#txtLockTimesheet').val();
	var isAdminUser = jQuery('#txtIsAdminUser').val();
	if(lockTimeSheet == 1 && isAdminUser == 0){
		$('.btnAddMore').unbind();
		$('.editVTETimeSheetsButton').unbind();
		$('.deleteVTETimeSheetsButton').unbind();
	}
	$('input.ui-timepicker-input').timepicker('option', 'minTime', dayStartTime);
	$('input.ui-timepicker-input').timepicker('option', 'maxTime', dayEndTime);
	rebindEventForHyperlink();
	/*$('.listViewEntriesTable tbody tr')
	 .on( "mouseenter", function() {
	 $(this).find('span.actionImages').css({
	 "opacity": "1"
	 });
	 })
	 .on( "mouseleave", function() {
	 var styles = {
	 "opacity": "0"
	 };
	 $(this).find('span.actionImages').css( styles );
	 });*/
});
$.fn.bindUp = function(type, fn) {
	type = type.split(/\s+/);
	this.each(function() {
		var len = type.length;
		while( len-- ) {
			$(this).bind(type[len], fn);
			var evt = $.data(this, 'events')[type[len]];
			evt.splice(0, 0, evt.pop());
		}
	});
};

function rebindEventForHyperlink() {
	var items = $("a:not('.saveVTETimeSheetsButton,.hoverEditCancel,.editVTETimeSheetsButton,.clearReferenceSelection')");
	var total = items.length;
	for (var i = 0; i <  total; i++){
		var item = $(items[i]);
		item.click(function (e) {
			if(timesheetEdit){
				var r = confirm(app.vtranslate('Your user have not been setup to use timesheets.'));
				if (r != true){
					e.preventDefault();
				}
			}
		})

		var clickHandlers = item.data('events').click;
		clickHandlers.reverse(); // reverse the order of the Array
	}
}

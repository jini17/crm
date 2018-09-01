/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Index_Js("Vtiger_TaskManagement_Js",{},{



	overlayContainer : false,
	getOverlayContainer : function(){

		if(this.overlayContainer === false){
			this.overlayContainer = jQuery('#taskManagementContainer');
		}
		return this.overlayContainer;
	},

	getModuleName : function(){
		return "Calendar";
	},

	getColors : function(){
	  return jQuery('input[name="colors"]').val();
	},

	saveFieldValue : function(recordId, fieldNameValueMap){
		var aDeferred = jQuery.Deferred();

		var data = {};
		if(typeof fieldNameValueMap != 'undefined'){
			data = fieldNameValueMap;
		}
		data['record'] = recordId;
		data['module'] = this.getModuleName();
		data['calendarModule'] = this.getModuleName();
		data['action'] = 'SaveAjax';

		//console.log(this.getModuleName());



		app.request.post({data:data}).then(
			function(err, reponseData){
				if(err === null){
					app.helper.showSuccessNotification({"message":''});
					aDeferred.resolve(reponseData);
				} else {
					app.helper.showErrorNotification({"message":err});
				}
			}
		);
	   return aDeferred.promise();
	},

	registerStatusCheckboxEvent : function(){
		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		overlay.on('click','.statusCheckbox',function(e){
			var element = overlay.find(e.currentTarget);
			var task = element.closest('.task');
			var taskSubjectEle = task.find('.taskSubject');
			var recordId = task.data('recordid');
			var fieldNameValueMap = {};
			if (element.is(':checked')) {
				element.disable();
				fieldNameValueMap['value'] = 'Completed';
				fieldNameValueMap['field'] = 'taskstatus';
				app.helper.showProgress();
				thisInstance.saveFieldValue(recordId,fieldNameValueMap).then(function(){
					app.helper.hideProgress();
					taskSubjectEle.addClass("textStrike");
					thisInstance.clearExistingCustomScroll();
					thisInstance.loadContents();

				});
			}
		});
	},


    /**
     * Function to get all the data of Tasks
     * @param params
     */
    getAllContents : function(params){
        var aDeferred = jQuery.Deferred();
        var filters = this.getAllFilterParams();
        //console.log(filters);
        var mode = "getAllContents";
        if(params == {}){
            mode = "getAllContents";
        }else if(params == "ReloadContent"){
            mode = "showManagementView";
            params = {};
        }
        var dataParams = {
            'module' : this.getModuleName(),
            'filters': filters,
            'view' : 'TaskManagement',
            'mode' : mode
        }
        var dataParams = jQuery.extend(dataParams,params);


        var colors = this.getColors();
        if(typeof colors != "undefined"){
            dataParams["colors"] = colors;
        }

        app.request.get({"data":dataParams}).then(function(err,data){
            if(err === null){
                //console.log("No error");
                aDeferred.resolve(data);
            }
            if(err != null){
                //console.log("error");
                aDeferred.reject("Cannot filter the records");
            }
        });

        /*this.filterRecords(params, "getAllContents").then(function(data){
           aDeferred.resolve(data);
        });*/

		return  aDeferred.promise();
	},


    /**
     * If not used till the end please delete this
     * @param params
     */
    getContentsOfPriority : function(params){
    	//console.log("Nirbhay"+params);
		var aDeferred = jQuery.Deferred();
		this.filterRecords(params, "getContentsOfPriority").then(function(data){
			aDeferred.resolve(data);
		});
		return  aDeferred.promise();
	},


    /**
     * Not needed as of now added this functionality in get content itself
     * @param params
     * @param mode
     */
	filterRecords : function(params,mode){
	    var aDeferred = jQuery.Deferred();
		var filters = this.getAllFilterParams();

		var dataParams = {
			'module' : this.getModuleName(),
			'filters': filters,
			'view' : 'TaskManagement',
			'mode' : mode
		}

		var dataParams = jQuery.extend(dataParams,params);

		var colors = this.getColors();
		if(typeof colors != "undefined"){
			dataParams["colors"] = colors;
		}

		app.request.get({"data":dataParams}).then(function(err,data){
			if(err === null){
				aDeferred.resolve(data);
			}
			if(err !== null){
			    aDeferred.reject("Cannot filter the records");
            }
		});
		var response = aDeferred.promise();
		return  response;
	},

	clearExistingCustomScroll : function(){
		var blocksList = jQuery(".contentsBlock");
		blocksList.each(function(index,blockElement){
			var blockElement = jQuery(blockElement);
			var scrollableElement = blockElement.find('.scrollable');
			scrollableElement.mCustomScrollbar('destroy');
		});
	},

	registerDateFilters : function(){
		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		overlay.on("click",".dateFilters button",function(e){
		    console.log("After clicking date filter");
			var currentTarget = jQuery(e.currentTarget);
			if(!currentTarget.hasClass('rangeDisplay')){
			jQuery('#taskManagementContainer .dateFilters button').removeClass('active');
				currentTarget.addClass('active');
				thisInstance.clearExistingCustomScroll();
			thisInstance.loadContents();
			app.helper.hideProgress();
			}
		});

		overlay.on('datepicker-change', 'button[data-calendar-type="range"]', function(e){
			var element = jQuery(e.currentTarget);
			jQuery('#taskManagementContainer .dateFilters button').removeClass('active');
			element.addClass('active');
			var parentContainer = element.closest('.dateFilters');
			parentContainer.find('.selectedRange').html("("+element.val()+")").closest('button').removeClass('hide');
			thisInstance.clearExistingCustomScroll();
			thisInstance.loadContents();
		});

		overlay.on('click', '.clearRange', function(e){
			var container = jQuery('.dateFilters');
			container.find('[data-filtermode="all"]').trigger('click');
			container.find('.rangeDisplay').addClass('hide');
		});
	},

	registerTaskManagementSearch : function(){
	    var thisInstance = this;
		var overlay = this.getOverlayContainer();

		overlay.find('#taskManagementOtherFilters').find('.search').on('click',function(e){
		    thisInstance.clearExistingCustomScroll();
            thisInstance.ReloadKanBanContents();
            //thisInstance.registerEvents();
           // thisInstance.initializeTaskStatus();

		});
	},

    ReloadKanBanContents : function(){
	    var thisInstance = this;
        app.helper.showProgress();
        params = "ReloadContent";
        thisInstance.getAllContents(params).then(function(data){
            app.helper.hideProgress();
            //console.log(data);
            jQuery(".data-body.row").html(data);
            thisInstance.loadContents();
            thisInstance.registerTaskDropEvent();
            //thisInstance.registerEvents();
        });


    },
	registerQuickEditTaskEvent : function(){
		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		jQuery('#taskManagementContainer').on('click', ".quickTask",function(e){

			e.stopImmediatePropagation();
			var target = jQuery(e.currentTarget);
			var quickCreateNode = jQuery('#quickCreateModules').find('[data-name="Calendar"]');
			if(quickCreateNode.length <= 0) {
				app.helper.showErrorMessage(app.vtranslate('JS_NO_CREATE_OR_NOT_QUICK_CREATE_ENABLED'));
			}

			var status = target.closest(".content").data("status");

            app.event.one("post.QuickCreateForm.show",function(event,form){
				var basicInfo = target.closest(".task").data('basicinfo');
				var recordId = target.closest(".task").data('recordid');

				form.find('.modal-header h4').html(app.vtranslate('JS_CREATE_TASK'));

				if(typeof basicInfo != "undefined"){
					// we should set field values when we edit any record
					form.append("<input type=hidden name=record value='"+recordId+"'>");
					thisInstance.fillPopoverFieldValues(form,basicInfo);
				} else {
					var taskSubject = jQuery(".taskSubject."+status.toLowerCase()).val();
					if(taskSubject.length > 0){
						form.find('input[name="subject"]').val(taskSubject);
					}


				}

				var taskPriority = form.find('select[name="taskstatus"]');
				if(taskPriority.length > 0){
					taskPriority.val(status.replace("_"," "));
					vtUtils.showSelect2ElementView(taskPriority);
				}

				form.append("<input type=hidden name='taskstatus' value='"+status+"'>");
			});

			var QuickCreateParams = {};
			QuickCreateParams['noCache'] = false;
			quickCreateNode.trigger('click', QuickCreateParams);
		});
	},

	registerPostQuickCreateSaveEvent : function() {
		var thisInstance = this;
		app.event.on('post.QuickCreateForm.save',function(event,data){
			if(typeof data == 'object'){
				status = data['taskstatus']['value'];
			}
			//console.log(status);
			var contentsBlock = jQuery("#taskManagementContainer").find(".contentsBlock."+status.toLowerCase()+"");
			thisInstance.clearExistingCustomScroll();
			thisInstance.loadContent(status.toLowerCase());
		});
	},

	fillPopoverFieldValues : function(form,data){
		var formName = form.attr('name');
		for (var key in data) {
			var value = data[key];
			if((key == 'parent_id') || (key == 'contact_id')){
				var fieldElement = jQuery('form[name="'+formName+'"]').find('[name="'+key+'_display"]');
			}else{
				var fieldElement = jQuery('form[name="'+formName+'"]').find('[name="'+key+'"]');
			}

			if(fieldElement.length > 0){
				var elementType = fieldElement.data("fieldtype");
				if(elementType == "picklist" || elementType == "owner"){
					fieldElement.select2("val", value);
				} else if(elementType == "multipicklist"){
					// for multipicklist name in field element will be key[]
					fieldElement = jQuery('form[name="'+formName+'"]').find('[name="'+key+'[]"]');
					if(value != null){
						value = value.split(" |##| ");
					}
					fieldElement.select2("val", value);
				}else if(elementType == "checkbox"){
					if(value == 1){
						fieldElement.attr("checked",true);
						fieldElement.prop("checked",true);
					} else {
						fieldElement.attr("checked",false);
						fieldElement.prop("checked",false);
					}
				} else if(elementType == "reference"){
					var parent = fieldElement.closest('.input-group');
					if((value != null) && (value["id"] != null)){
						parent.find(".sourceField").attr("value",value["id"]);
						fieldElement.val(value["display_value"]);
						fieldElement.attr("disabled","disabled");
						parent.find('.clearReferenceSelection').removeClass('hide');
						parent.find('input[name="popupReferenceModule"]').val(value["module"]);

						var referenceModuleList =  parent.find(".referenceModulesList");
						if(referenceModuleList.length > 0){
							referenceModuleList.select2("val",value["module"]);
						}
					}else {
						parent.find('.clearReferenceSelection').trigger('click');
					}
				}else {
					fieldElement.val(value);
				}
			}
		}
	},

	/**
	 * Function to get parameters for related module popup
	 * @param {type} container
	 * @returns {TaskManagementAnonym$1.getPopUpParams.params|TaskManagementAnonym$1.getPopUpParams@call;_super}
	 */
	getPopUpParams : function(container) {
		var params = this._super(container);
		var sourceFieldElement = jQuery('input[class="sourceField"]',container);

		if(sourceFieldElement.attr('name') == 'contact_id') {
			var form = container.closest('form');
			var parentIdElement  = form.find('[name="parent_id"]');
			var closestContainer = parentIdElement.closest('.referencefield-wrapper');
			var referenceModule = closestContainer.find('[name="popupReferenceModule"]');
			if(parentIdElement.length > 0 && parentIdElement.val().length > 0 && referenceModule.length >0) {
				params['related_parent_id'] = parentIdElement.val();
				params['related_parent_module'] = referenceModule.val();
			}
		}
		return params;
	},

	saveNewTask : function(fieldValues){
		var aDeferred = jQuery.Deferred();
		var params = {
			'module' : this.getModuleName(),
			'action' : 'TaskManagement',
			'mode' : 'addTask',
			'calendarModule':this.getModuleName()
		}

		var postParams = jQuery.extend(params,fieldValues);
		app.request.post({"data":postParams}).then(function(err,data){
			if(err === null){
				aDeferred.resolve(data);
			}
		});
		return aDeferred.promise();
	},

	registerSubjectFieldEnterEvent : function(){

		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		overlay.on("keypress",".taskSubject",function(e){

			var currentTarget = jQuery(e.currentTarget);
			var keycode = (e.keyCode ? e.keyCode : e.which);
			if(keycode == '13'){
				jQuery(this).blur();
				var subject = currentTarget.val();
				var status = currentTarget.closest('.content').data("status");
                status = status.replace("_"," ");

				//console.log(status);
				if(subject.trim() == ""){
					app.helper.showErrorNotification({'message': app.vtranslate('JS_SUBJECT_VALUE_CANT_BE_EMPTY')})
					return false;
				}
				var form = jQuery(".editTaskContent").find("#editTask").clone().removeClass('hide');
				vtUtils.applyFieldElementsView(form);
				var formValues = form.serializeArray();

				var count = formValues.length;
				var fieldNameValueMap = {};
				for(var i=0 ; i<count;i++){
					var dataElement = formValues[i];
					fieldNameValueMap[dataElement["name"]] = dataElement["value"];
				}
				fieldNameValueMap["taskstatus"] = status;
				fieldNameValueMap["subject"] = subject;
				fieldNameValueMap["assigned_user_id"] = app.getUserId();

				app.helper.showProgress();
				thisInstance.saveNewTask(fieldNameValueMap).then(function(e){
					currentTarget.val("");
					var contentsBlock = jQuery("#taskManagementContainer").find(".contentsBlock ."+status.toLowerCase()+"");
					thisInstance.clearExistingCustomScroll();
					thisInstance.loadContent(status.toLowerCase());
				});
			}
		})
	},


	registerEditedTaskCancelEvent : function(e){
		var overlay = this.getOverlayContainer();
		overlay.on("click",".popoverClose",function(){
			var popoverDescribedBy = jQuery(this).closest('.popover').attr('id');
			jQuery('[aria-describedby="'+popoverDescribedBy+'"]').popover("hide");
		});
	},

	getAllFilterParams : function(){
		var filterParams = {};
		var dateFilter = jQuery('.dateFilters button.active');
		var filterMode = dateFilter.data('filtermode');
		filterParams["date"] = filterMode;

		if(filterMode == "range"){
			var rangeValue = dateFilter.val();
			var res = rangeValue.split(",");
			filterParams['startRange'] = res[0];
			filterParams['endRange'] = res[1];
		}



		var statusFilter = jQuery('.otherFilters select[name="taskstatus"]').val();
		if(statusFilter){
			filterParams["status"] = statusFilter;
		}


		var userFilter = jQuery('.otherFilters select[name="assigned_user_id"]').val();
		if(userFilter){
			filterParams["assigned_user_id"] = userFilter;
		}
        //console.log(filterParams);
		return filterParams;
	},
    /*
    Do not know what the below function does, comment if creates issue, all the main functionalities working without this function
     */
	registerParentModuleChangeEvent : function(e){

		var overlay = this.getOverlayContainer();
		overlay.on('change',"select.referenceModulesList:visible",function(e){
			var currentTarget = jQuery(e.currentTarget);
			var selectedValue = currentTarget.select2("val");

			var field = currentTarget.closest(".field");
			var fieldValue = field.find('.fieldValue');
			fieldValue.find('input[name="popupReferenceModule"]').val(selectedValue);
			fieldValue.find('.clearReferenceSelection').click();
		});
	},

	registerTaskDragEvent : function(e) {
		var overlay = this.getOverlayContainer();
		// appendTo : will allow the draggable element to view on top of given element
		overlay.find('.ui-draggable').draggable({appendTo:".data-body",revert: "invalid",helper:'clone',cursor: 'move',
			drag:function(e, ui){
				ui.helper.css({
					'width': '30%',
					'background-color':'white',
					'height':'auto'
				});
			}
		});
	},

	registerTaskDropEvent : function() {
		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		overlay.find(".ui-droppable").droppable({
			'accept' : '.ui-draggable',
			drop: function( event, ui ) {
				var currentBlock = jQuery(this);
				var status = currentBlock.find('.content').data("status");

				var colors = JSON.parse(jQuery('input[name="colors"]').val());
				var color = colors[status];

				var draggedElement = jQuery(ui.draggable);
				var draggedElementTask = draggedElement.find(".task");
				var draggedElementPriority = draggedElementTask.data("status");

				if(draggedElementPriority != status){
					var draggedElementrecordID = draggedElementTask.data("recordid");
					var fieldNameValueMap = {"taskstatus":status};
					app.helper.showProgress();
					thisInstance.saveFieldValue(draggedElementrecordID,fieldNameValueMap).then(function(data){
						if(data){
							app.helper.hideProgress();
							draggedElementTask.attr("data-status",status).data('status',status);
							draggedElementTask.css({"border-left":"4px solid "+color});
							currentBlock.find("."+status.toLowerCase()+"-entries").prepend(draggedElement);
							thisInstance.clearExistingCustomScroll();
							var params = {
								setHeight: '400px',
								autoHideScrollbar: false
							};
							thisInstance.loadContent(status.toLowerCase());
//							app.helper.showVerticalScroll(currentBlock.find("."+status.toLowerCase()+"-entries"),params);
						}
					})
				}
			}
		});
	},

    /*
    Remove this piece of shit if found usless*/

	loadContent : function(status){
		status = (status.toLowerCase()).replace(" ","_");
       // console.log("Nirbhay"+status);

        var thisInstance = this;
		var blockElement = jQuery("#taskManagementContainer").find(".contentsBlock."+status+"");

		var status = blockElement.data("status");
        //console.log("Nirbhay123");

        var params = {
			"status" : (status.toLowerCase()).replace(" ","_")
		};

		thisInstance.getContentsOfPriority(params).then(function(data){
			app.helper.hideProgress();
			blockElement.find(".dataEntries").html(data);
			blockElement.attr("data-page",1).data("page",1);
			app.event.trigger("post.filter.load");
		});
	},

	loadContents : function(){
		var thisInstance = this;
		app.helper.showProgress();
        //console.log("Load Contents");
        thisInstance.getAllContents({}).then(function(data){
            app.helper.hideProgress();
            var data = JSON.parse(data);

            var blocksList = jQuery(".contentsBlock");
            blocksList.each(function(index,blockElement){
                var blockElement = jQuery(blockElement);
                var status = blockElement.data('status');
                blockElement.find(".dataEntries").html(data[status]);
                blockElement.attr("data-page",1).data("page",1);
            });
            app.event.trigger("post.filter.load");
            });

	},
    /*
    ** Commented By Nirbhay to disable more functionality
	registerMoreButtonClickEvent : function(){
		var thisInstance = this;
		var overlay = this.getOverlayContainer();
		var fetchingContents = false;
		overlay.on("click",'button.moreRecords',function(e){
			if(!fetchingContents) {
				fetchingContents = true;
				var currentTarget = jQuery(e.currentTarget);
				var blockElement = currentTarget.closest(".contentsBlock");
				var status  = blockElement.attr('data-status');
				var page  = blockElement.attr("data-page");
				console.log("Page No. :" +page);
				page = parseInt(parseFloat(page)) + 1;
				app.helper.showProgress();
				var params = {
					"status":status,
					"page" : page
				};
				thisInstance.getContentsOfPriority(params).then(function(data){
					fetchingContents = false;
					currentTarget.closest(".moreButtonBlock").remove();
					blockElement.find(".dataEntries").append(data);
					blockElement.attr("data-page",page).data("page",page);
					thisInstance.clearExistingCustomScroll();
					app.event.trigger("post.filter.load");
				});
			}
		});
	},*/

	registerDeleteTaskEvent : function(){
		var overlay = this.getOverlayContainer();
		overlay.on('click', '.taskDelete', function(e){
		   var elem = jQuery(e.currentTarget);
		   var container = elem.closest('div.task');
		   var recordId = container.data('recordid');
		   var params = {
			   'module' : 'Calendar',
			   'action' : 'DeleteAjax',
			   'record' : recordId
		   };
		   var message = app.vtranslate('JS_ARE_YOU_SURE_YOU_WANT_TO_DELETE');
			app.helper.showConfirmationBox({'message' : message}).then(function() {
				app.helper.showProgress();
				app.request.post({"data":params}).then(function(err,data){
					if(err === null){
						container.closest('.entries').remove();
						app.helper.hideProgress();
					}
				});
			});
		});
	},

	initializeTaskStatus : function(){
        var statusesArr = [];
        if(jQuery("[name = sessionStatus]").val()){
            var statuses = jQuery("[name = sessionStatus]").val();
            if(statuses != ''){
                var statuses = statuses.replace(new RegExp("_","g"), " ");
                statusesArr = statuses.split(",");
            }
        }


       // console.log("Nirbhay" + statusesArr.length);

		var container = this.getOverlayContainer();
		var taskStatus = container.find('select[name="taskstatus"]');
		//console.log(taskStatus);
        if(statusesArr.length > 0 && taskStatus.length > 0){
            taskStatus.find('[value="'+statusesArr[i]+'"]').attr('selected', "selected");

        }
		else if(taskStatus.length > 0){
            taskStatus.find('[value="Not Started"]').attr('selected', "selected");
           taskStatus.find('[value="In Progress"]').attr('selected', "selected");
			taskStatus.find('[value="Pending Input"]').attr('selected', "selected");
			taskStatus.find('[value="Planned"]').attr('selected', "selected");

        }

        vtUtils.showSelect2ElementView(taskStatus);

	},


    initializeAssignedUser : function(){
        var container = this.getOverlayContainer();
        var assigneduser = container.find('select[name="assigned_user_id"]');


        if(assigneduser.length > 0){

            assigneduser.find('[value="Mine"]').attr('selected', "selected");
        }

        vtUtils.showSelect2ElementView(assigneduser);

    },

	registerQuickPreviewForTask : function(){
		var self = this;
		var container = this.getOverlayContainer();
		container.on('click', '.quickPreview', function(e){
			e.preventDefault();
			var element = jQuery(e.currentTarget);
			var recordId = element.data('id');
			var href = element.attr("href");
			var module = self.getModuleName();
			if(typeof href != 'undefined'){
				var data = app.convertUrlToDataParams(href);
				module = data.module;
			}
			var vtigerInstance = Vtiger_Index_Js.getInstance();
			vtigerInstance.showQuickPreviewForId(recordId, module);
		});
	},
	
	
	/*registerTabClick : function(){
		var self = this;

		jQuery(".dashboardTab").on('click', function(e){ 
		    var tabid = element.data('tabid');
		    alert('Raju'+tabid);
		    var element = jQuery(e.currentTarget);
			var recordId = element.data('id');
			window.location = 'index.php?module=Home&view=DashBoard&tabid='+tabid;
			var DashboardInst = new Vtiger_Widget_Js();
			DashboardInst.refreshWidget();
		});
	},*/


	registerEvents : function(){
		var thisInstance = this;
		this.loadContents();
		//this.registerMoreButtonClickEvent(); Commented by Nirbhay to disbale the functionality
		this.registerStatusCheckboxEvent();
        this.registerDateFilters();

        this.initializeTaskStatus();
        this.initializeAssignedUser();
        this.registerTaskManagementSearch();
        this.registerEditedTaskCancelEvent();
        this.registerSubjectFieldEnterEvent();
        this.registerTaskDropEvent();
        this.registerDeleteTaskEvent();


        /*****Validate from here**********/


        this.registerParentModuleChangeEvent();
        this.registerQuickEditTaskEvent();
        this.registerPostQuickCreateSaveEvent();
        this.registerQuickPreviewForTask();
       // this.registerTabClick();
        
		vtUtils.registerEventForDateFields(jQuery('#taskManagementContainer'));

		app.event.on("post.filter.load",function(e){
			var params = {
				setHeight: '400px',
				autoHideScrollbar: false
			 };
			 app.helper.showVerticalScroll(jQuery('.scrollable'),params);
			 thisInstance.registerTaskDragEvent();
			 app.helper.hideProgress();
		});

        window.onbeforeunload = function() {
      	
           var tabid = jQuery("#default_tab").val();
           
            window.setTimeout(function () {
                window.location = 'index.php?module=Home&view=DashBoard&tabid='+tabid;
            }, 0);

            window.onbeforeunload = null;
        }
	}




});

/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_List_Js("Users_Leave_Js",{},{
		
	editLeave : function(url, currentTrElement) {
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
			var section = 'M';
		if(currentTrElement !='') {
			section = currentTrElement.data('section');
		}
			
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			
			'blockInfo' : {
				'enabled' : true
			}
		});

		AppConnector.request(url).then(
			function(data) {
				var callBackFunction = function(data) { 
					//cache should be empty when modal opened
					//var thisInstance = this;
					thisInstance.duplicateCheckCache = {};
					var form = jQuery('#editLeave');
					
					thisInstance.textAreaLimitCharDisapprove();// for textarea limit
					thisInstance.textAreaLimitChar();
					//**

					$("#start_date").on("change", function(){ 
						if($("#hdnhalfday").val()==1) {
							$("#end_date").val($("#start_date").val());
							$('#starthalf').prop('checked',true);
							$("#endhalfcheck").addClass('hide');
							$("#endhalf").addClass('hide');

						} else {
							$("#endhalfcheck").addClass('hide');
							$("#endhalf").addClass('hide');
							$('#endhalf').prop('checked',false);
							$("#starthalf").prop('checked',false);
							$("#starthalfcheck").addClass('hide');
							$("#starthalf").addClass('hide');
						}
					});
					$("#end_date").on("change", function(){
						if($("#hdnhalfday").val()==1) {
							if($("#end_date").val() != $("#start_date").val()) {
								$("#endhalfcheck").removeClass('hide');
								$("#endhalf").removeClass('hide');
							} else {
								$("#endhalfcheck").addClass('hide');
								$("#endhalf").addClass('hide');
							}
						} else {
							$("#endhalfcheck").addClass('hide');
							$("#endhalf").addClass('hide');
							$('#endhalf').prop('checked',false);
							$("#starthalf").prop('checked',false);
							$("#starthalfcheck").addClass('hide');
							$("#starthalf").addClass('hide');
						}	
					});
				
					$("#starthalf").on("click", function(){	
						if($("#start_date").val() == $("#end_date").val()) {
						//	$('#starthalf').prop('checked',true);
							$('#endhalf').prop('checked',false);
						} 
					});
					$("#endhalf").on("click", function(){	
						if($("#start_date").val() == $("#end_date").val()) {
							$('#starthalf').prop('checked',false);
							$('#endhalf').prop('checked',true);
						} 
					});
	
					$("#leave_type").select2(
						{
						formatResult: function(item, container) { 
									var originalOption = item.id;
									var originalText = (item.text).split('@');
									var color = originalText[1];
									var balance = originalText[2];
									var title = originalText[0];

								if(typeof balance === "undefined") {
									balance = '';	
								} else {
									balance = '<strong>['+balance+']</strong>';
								}	
								return '<div title="' + title + '">'+'<span class="empty_fill" style="background-color:'+color+';"></span>' + title+balance+'</div>';	
								
						},
					
						formatSelection: function(item, container) { 
									var originalOption = item.id;
									var originalText = (item.text).split('@');
									var color = originalText[1];
									var balance = originalText[2];
									var title = originalText[0];	
									var halfday = originalText[3];
									//hiddentextbox
									$("#hdnhalfday").val(halfday);
									if(typeof balance === "undefined") {
										balance = '';	
									} else {
										balance = '<strong>['+balance+']</strong>';
									}	
								if(halfday ==0) {
									$("#starthalfcheck").addClass('hide');
									$("#endhalfcheck").addClass('hide');
									$("#starthalf").addClass('hide');
									$("#starthalf").prop('checked',false);
									$("#endhalf").prop('checked',false);
									$("#endhalf").addClass('hide');
								} else {
									$("#starthalfcheck").removeClass('hide');
									$("#starthalf").removeClass('hide');
								}	
							//return color
								
								return '<span class="empty_fill" style="background-color:'+color+';margin-right:10px;"></span>'+ title +balance+'</strong>';
						}
					});
					
					//**
					if(jQuery('#savetype').val() == 'Approved' || jQuery('#savetype').val() == 'Cancel' || jQuery('#savetype').val() == 'Not Approved'){
							
						 $('#leave_type').select2('disable');
						 $("#start_date").attr("disabled",true);
						 $("#end_date").attr("disabled",true);
						 $("#replaceuser").select2("disable");
						 $("#reason").attr("disabled", true);
						 $("#rejectionreasontxt").attr("disabled", true);			
						 $("input").attr("disabled",true);	
					}

					if(jQuery('#savetype').val() == 'Apply'){
						 $('#leave_type').select2('disable');
						 $("#start_date").attr("disabled",true);
						 $("#end_date").attr("disabled",true);
						 $("#replaceuser").select2("disable");
						 $("#reason").attr("disabled", true);
				
					}
					var len = $("#reason").val().length;
					var remainchar = 300 - len;
			    		$('#charNum_reason').text(remainchar + ' character(s) left');
					//**
					//**DISBLE SELECT 2 PENDING
					//**
					if(jQuery('#notapprove').is(':checked')){
						$('div#rejectionreason').removeClass('hide');
					}


					form.validationEngine('attach', {
						onValidationComplete: function(form, status){ 
							if (status == true) {  
							$(".btn-success").attr("disabled", true);
						var progressIndicatorElement = jQuery.progressIndicator({
							'position' : 'html',
							'top': 120,
							'left': 120,
							'blockInfo' : {
								'enabled' : false
							}
						});			var aparams = form.serializeFormData();
									aparams.chkboxstarthalf = jQuery('#starthalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX
									aparams.chkboxendhalf = jQuery('#endhalf').is(':checked')?'1':'0';//ADDED BY JITU - HALFDAY CHECKBOX
									aparams.module = app.getModuleName();
									aparams.action = 'SaveSubModuleAjax';
									aparams.mode = 'saveLeave';

									AppConnector.request(aparams).then(
										function(data) { 
											//show notification after Leave details saved
				
											params = {
												text: app.vtranslate(data['result'],app.getModuleName()),
												type: 'success'
											};	
											Vtiger_Helper_Js.showPnotify(params);	
			progressIndicatorElement.progressIndicator({'mode':'hide'});
			if(data['result'] == 'JS_USER_ALREADY_APPLIED') {
				$(".btn-success").attr("disabled", false);
			} else {
				//Adding or update the Leave details in the list	
				
				app.hideModalWindow();
				thisInstance.updateLeaveGrid(userid,section);
			}
										}
									);
return false;
							}
						}           
					});
			
					form.submit(function(e) {
						e.preventDefault();
					})
				}
				
				progressIndicatorElement.progressIndicator({'mode':'hide'});
				app.showModalWindow(data,function(data){
					if(typeof callBackFunction == 'function'){
						callBackFunction(data);
							
						}
				}, {'width':'500px'});
			},
			function(error) {
				//TODO : Handle error
				aDeferred.reject(error);
			}
		);
		return aDeferred.promise();
	},
	
	//Added by jitu@secondcrm on 17-03-2015 for 
	registerSetLeaveType : function() {
		$("#my_selyear").select2({ width: '100px'});
		$("#team_selyear").select2({ width: '100px'});
		$("#sel_teammember").select2({ width: '200px'});
		$("#sel_leavetype").select2().select2("val", ' ');
		$("#sel_leavetype").select2(
			{ 
				width:'200px',	
				formatResult: function(item, container) { 
					var originalOption = item.id;
					var originalText = (item.text).split('@');
					var color = originalText[1];
					var balance = originalText[2];
					var title = originalText[0];	
					return '<div title="' + title + '">'+'<span class="empty_fill" style="background-color:'+color+';"></span>' + title+'</div>';
				},
				formatSelection: function(item, container) { 
					var originalOption = item.id;
					var originalText = (item.text).split('@');
					var color = originalText[1];
					var balance = originalText[2];
					var title = originalText[0];	
				//return color
				return '<span class="empty_fill" style="background-color:'+color+';margin-right:10px;"></span>'+ title;
				}
			}
		);
	},

	updateLeaveGrid : function(userid,section) { 
			//update particular div on request from My leave or My team leave
			var divcontainer  = section =='T'?'myteamleavelist':'myleavelist';
			
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});

			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,	
					'section' :section,		
					'mode'   : 'getUserLeave',
				}
				AppConnector.request(params).then(
					function(data) { 
						progressIndicatorElement.progressIndicator({'mode':'hide'});
						$('#'+divcontainer).html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},	
	
	deleteLeave : function(deleteRecordActionUrl,currentTrElement) { 
		var message = app.vtranslate('JS_DELETE_LEAVE_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		var section = currentTrElement.data('section');	
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(function(data) {
		AppConnector.request(deleteRecordActionUrl).then(
		function(data){
				var response = data['result'];
				var result   = data['success'];
				if(result == true) {
					params = {
						text: response.msg,
						type:'success'	
					};
				} else {
						params = {
						text: response.msg,
						type:'error'	
					};
				}
				
				Vtiger_Helper_Js.showPnotify(params);
				//delete the Leave details in the list
				thisInstance.updateLeaveGrid(userid,section);
			}
		);
	});
},

	cancelLeave : function(cancelRecordActionUrl,currentTrElement) { 
		
		var message = app.vtranslate('JS_CANCEL_LEAVE_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		var section = currentTrElement.data('section');	
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(function(data) {
		AppConnector.request(cancelRecordActionUrl).then(
		function(data){
				var response = data['result'];
				var result   = data['success'];
				if(result == true) {
					params = {
						text: response.msg,
						type:'success'	
					};
				} else {
						params = {
						text: response.msg,
						type:'error'	
					};
				}
				
				Vtiger_Helper_Js.showPnotify(params);
				//delete the Leave details in the list
				thisInstance.updateLeaveGrid(userid, section);
			}
		);
	});
},

	/*
	 * Function to register all actions in the Tax List
	 */
	registerActions : function() {
		var thisInstance = this;
		var container = jQuery('#MyLeaveContainer');

		//register click event for Add New Leave button
		container.find('.addMyLeave').click(function(e) {
			var addMyLeaveButton = jQuery(e.currentTarget);
			var createLeaveUrl = addMyLeaveButton.data('url');
			var isAllow = addMyLeaveButton.data('allow');

			if(isAllow) { 
				thisInstance.editLeave(createLeaveUrl,'');
			} else {
				var params = {
						text: app.vtranslate('JS_NO_LEAVE_ALLOCATE','LEAVE'),
						type:'error'	
					};
				Vtiger_Helper_Js.showPnotify(params);
			}
			
		});
		var tab = $("#defaulttab").val();
		if(tab =='leave'){ 
			var applicantid = $("#wapplicant").val();
			var leaveid = $("#wleaveid").val();

			var lUrl = "?module=Users&view=EditLeave&record="+leaveid+"&userId="+applicantid+"&leavestatus=Apply&manager=true";
			thisInstance.editLeave(lUrl, '');
			
		}
		//register event for edit Leave icon
		container.on('click', '.editLeave', function(e) {
			var editLeaveButton = jQuery(e.currentTarget);
			var currentTrElement = editLeaveButton.closest('tr');
			thisInstance.editLeave(editLeaveButton.data('url'), currentTrElement);
		});
		
		//register event for delete leave icon
		container.on('click', '.deleteLeave', function(e) { ;
		var deleteLeaveButton = jQuery(e.currentTarget);
		var currentTrElement = deleteLeaveButton.closest('tr');
		thisInstance.deleteLeave(deleteLeaveButton.data('url'), currentTrElement);
		});

		//register event for cancel leave icon
		container.on('click', '.cancelLeave', function(e) { ;
		var cancelLeaveButton = jQuery(e.currentTarget);
		var currentTrElement = cancelLeaveButton.closest('tr');
		thisInstance.cancelLeave(cancelLeaveButton.data('url'), currentTrElement);
		});

		//register event for my leave year combobox.
		container.on('change', '.my_selyear', function(e) { 
		var myyearcombo = jQuery(e.currentTarget);
		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val(),myyearcombo.data('section'));
		});

	},
	registerChangeYear : function(changeYearActionUrl,section) {
		var thisInstance = this;
		var divcontainer  = section =='T'?'myteamleavelist':'myleavelist';
		var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});
		AppConnector.request(changeYearActionUrl).then(
			function(data){
				progressIndicatorElement.progressIndicator({'mode':'hide'});
				$('#'+divcontainer).html(data);
			}
		);
	
	},
	//MYTEAMLEAVEPAGING BY SAFUAN
	registerPaging : function(changePageActionUrl,section) {
		var thisInstance = this;
		var divcontainer  = section =='T'?'myteamleavelist':'myleavelist';
		var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
					'enabled' : true
				}
			});
		AppConnector.request(changePageActionUrl).then(
			function(data){
				progressIndicatorElement.progressIndicator({'mode':'hide'});
				$('#'+divcontainer).html(data);
			}
		);
	
	},
	
	/*
	 * Function to register all actions in the MY Team List List List
	 */
	registerActionsTeamLeave : function() {
		var thisInstance = this;
		var container = jQuery('#MyTeamLeaveContainer');
		

		
		//register event for edit Leave icon
		container.on('click', '.editLeave', function(e) {
			var editLeaveButton = jQuery(e.currentTarget);
			var currentTrElement = editLeaveButton.closest('tr');
			thisInstance.editLeave(editLeaveButton.data('url'), currentTrElement);
		});
		
		//register event for delete leave icon
		container.on('click', '.deleteLeave', function(e) { ;
		var deleteLeaveButton = jQuery(e.currentTarget);
		var currentTrElement = deleteLeaveButton.closest('tr');
		thisInstance.deleteLeave(deleteLeaveButton.data('url'), currentTrElement);
		});
		//register event for cancel leave icon
		container.on('click', '.cancelLeave', function(e) { ;
		var cancelLeaveButton = jQuery(e.currentTarget);
		var currentTrElement = cancelLeaveButton.closest('tr');
		thisInstance.cancelLeave(cancelLeaveButton.data('url'), currentTrElement);
		});

		//register event for my team leave year combobox.
		container.on('change', '.team_selyear', function(e) { 
		var myyearcombo = jQuery(e.currentTarget);
		var membercombo = jQuery("#sel_teammember");
		var leavetypecombo = jQuery("#sel_leavetype");	
		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val(),myyearcombo.data('section'));
		});

		//register event for my team member combobox.
		container.on('change', '.sel_teammember', function(e) { 
		var membercombo = jQuery(e.currentTarget);
		var myyearcombo = jQuery("#team_selyear");
		var leavetypecombo = jQuery("#sel_leavetype");
		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val(),myyearcombo.data('section'));
		});

		//register event for my leave type combobox.
		container.on('change', '.sel_leavetype', function(e) { 
		var leavetypecombo = jQuery(e.currentTarget);
		var membercombo = jQuery("#sel_teammember");
		var myyearcombo = jQuery("#team_selyear");
		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val(),myyearcombo.data('section'));
		});

		//register event for my team leave paging<next>.MYTEAMLEAVEPAGING BY SAFUAN
		container.on('click', '#listViewNPageButton, #userleavenextpagebutton', function(e) { 

		var myyearcombo = $('#team_selyear');
		var membercombo = jQuery("#sel_teammember");
		var leavetypecombo = jQuery("#sel_leavetype");
		var pagenum = parseInt($('#pageNumber').val());
		var nextpagenum = pagenum + 1;

		thisInstance.registerPaging(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val()+'&pagenumber='+nextpagenum,myyearcombo.data('section'));
		});

		//register event for my team leave paging<previous>.MYTEAMLEAVEPAGING BY SAFUAN
		container.on('click', '#previouspage,#userleaveprevpagebutton', function(e) {

		var myyearcombo = $('#team_selyear');
		var membercombo = jQuery("#sel_teammember");
		var leavetypecombo = jQuery("#sel_leavetype");
		var pagenum = parseInt($('#pageNumber').val());
		var prevpagenum = pagenum - 1;
		
		thisInstance.registerPaging(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selleavetype='+leavetypecombo.val()+'&pagenumber='+prevpagenum,myyearcombo.data('section'));
		});


	},
	
	textAreaLimitCharDisapprove : function(){
			$('#rejectionreasontxt').keyup(function() { 
				var maxchar = 300;
				var len = $(this).val().length;
			 	if (len > maxchar) {
			    		$('#charNum').text(' you have reached the limit');
					$(this).val($(this).val().substring(0, len-1));
			  	} else {
			    		var remainchar = maxchar - len;
			    		$('#charNum').text(remainchar + ' character(s) left');
					
			  	}
			});
	},

	textAreaLimitChar : function(){
			$('#reason').keyup(function() { 
				var maxchar = 300;
				var len = $(this).val().length;
			 	if (len > maxchar) {
			    		$('#charNum_reason').text(' you have reached the limit');
					$(this).val($(this).val().substring(0, len-1));
			  	} else {
			    		var remainchar = maxchar - len;
			    		$('#charNum_reason').text(remainchar + ' character(s) left');
					
			  	}
			});
	},

	registerEvents: function() { 
		//this._super();
		this.registerActions();
		this.registerActionsTeamLeave();
		this.registerPageNavigationEvents();	
		this.registerEventForTotalRecordsCount();
		this.registerSetLeaveType();
	}

});

jQuery(document).ready(function(e){ 
	var Leaveinstance = new Users_Leave_Js();
	Leaveinstance.registerEvents();


})

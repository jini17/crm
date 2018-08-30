/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger.Class("Users_Claim_Js", {

	//register click event for Add New Education button
	addClaim : function(url) { 
	     this.editClaim(url);
	    
	},
	
	textAreaLimitChar : function(){
			jQuery('#description').keyup(function () { 
				var maxchar = 300;
				var len = jQuery(this).val().length;
			 	if (len > maxchar) {
			    		jQuery('#charNum').text(' you have reached the limit');
					jQuery(this).val($(this).val().substring(0, len-1));
			  	} else {
			    		var remainchar = maxchar - len;
			    		jQuery('#charNum').text(remainchar + ' character(s) left');
					
			  	}
			});
	},
	editClaim : function(url) {  
	    var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		
		app.helper.showProgress();
		app.request.post({url:url}).then(
		function(err,data) {  
		      app.helper.hideProgress();
              
                if(err == null){ 
                    app.helper.showModal(data);
                    var form = jQuery('#editClaim'); 

                        thisInstance.textAreaLimitChar();	
                     
                        	// for textarea limit
	
	
					$("#category").select2( 
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
					if(jQuery('#savetype').val() == 'Approved' || jQuery('#savetype').val() == 'Cancel' || jQuery('#savetype').val() == 'Rejected'){
							
						 $('#category').select2('disable');
						 $("#transactiondate").attr("disabled",true);
						 $("#end_date").attr("disabled",true);
						 $("#totalamount").select2("disable");
						 $("#description").attr("disabled", true);
						 $("#rejectionreasontxt").attr("disabled", true);			
						 $("input").attr("disabled",true);	
					}


					if(jQuery('#savetype').val() == 'Apply'){
						 $('#leave_type').select2('disable');
						 $("#start_date").attr("disabled",true);
						 $("#end_date").attr("disabled",true);
						 $("#replaceuser").select2("disable");
						 $("#description").attr("disabled", true);
				
					}

					jQuery('#listViewNPageButton, #userclaimnextpagebutton').click(function(e) {  		
					var myyearcombo = $('#team_selyear');
					var membercombo = jQuery("#sel_teammember");
					var claimtypecombo = jQuery("#sel_claimtype");
					var pagenum = parseInt($('#pageNumber').val());
					var nextpagenum = pagenum + 1;

					thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selclaimtype='+claimtypecombo.val()+'&pagenumber='+nextpagenum,myyearcombo.data('section'));
					});

					if(jQuery('#notapprove').is(':checked')){
						$('div#rejectionreason').removeClass('hide');
					}

					
					$('#category').change(function(){
   						$("#totalamount").val('');		
					});  

					$('#transactiondate').change(function(){ 

/*
						var today = new Date();
						var dd = today.getDate();

						var mm = today.getMonth()+1; 
						var yyyy = today.getFullYear();
						if(dd<10) 
						{
						    dd='0'+dd;
						} 

						if(mm<10) 
						{
						    mm='0'+mm;
						} 

						today = dd+'-'+mm+'-'+yyyy;*/



						transactiondate = $("#transactiondate").val(); 
					    var date = transactiondate.substring(0, 2);
					    var month = transactiondate.substring(3, 5);
					    var year = transactiondate.substring(6, 10);
					 
					    var dateToCompare = new Date(year, month - 1, date);
					    var currentDate = new Date();




						if(dateToCompare >= currentDate){
						app.helper.showErrorNotification({'message': app.vtranslate('JS_ERROR_TRANSACTION_DATE')});
						$("#transactiondate").val('');
						$("#totalamount").val('');	
		            	e.preventDefault();
							
						}


   						//$("#totalamount").val('');		
					});  


				    $('#totalamount').focusout(function(){
					if(	$("#category").val()=="select" ){
						app.helper.showErrorNotification({'message': app.vtranslate('JS_SELECT_CLAIM_TYPE')});
		            	e.preventDefault();
		            	$("#totalamount").val('');  
		            }
					if(	$("#transactiondate").val()=="" ){
						app.helper.showErrorNotification({'message': app.vtranslate('JS_SELECT_TRANSACTION_DATE')});
		            	e.preventDefault();
		            	$("#totalamount").val('');  

		            }
					var totalamount = $('#totalamount').val();
					var current_user_id = $('#current_user_id').val();
					var transactiondate = $("#transactiondate").val();
					var category = $("#category").val();
					var trans =$( "#category option:selected" ).data('trans');
					var monthly =$( "#category option:selected" ).data('monthly');
					var yearly =$( "#category option:selected" ).data('yearly');

					 thisInstance.ValidateClaimAmount(current_user_id,trans,monthly,yearly,totalamount,transactiondate,category);

					 });




				    $("#description").keyup(function () {
					var len = $("#description").val().length;
					var remainchar = 300 - len;
			    		$('#charNum').text(remainchar + ' character(s) left');
			    	});			


	
                    form.submit(function(e) { 
                            e.preventDefault();
                         })
 
					var params = { 
                            submitHandler : function(form){
                                var form = jQuery('#editClaim');   
                                thisInstance.saveClaimDetails(form); 
                            }
                        };

         
                         form.vtValidate(params)  //alert("hsssei");
          		} else {
                        aDeferred.reject(err);
                    }
	     	});
	     return aDeferred.promise();	
	},

	
 //use error notification
		 ValidateClaimAmount : function(current_user_id,trans,monthly,yearly,totalamount,transactiondate,category){  
		 	
			var params = {
					'module' 		  : app.getModuleName(),
					'action' 		  : 'SaveSubModuleAjax',
					'mode'   		  : 'ValidateClaimAmount',
					'current_user_id' : current_user_id,
					'trans'   		  : trans,
					'monthly'  	      : monthly,
					'yearly'   		  : yearly,
					'totalamount'     : totalamount,
					'transactiondate' : transactiondate,
					'category'        : category,
				
				}

              app.request.post({'data': params}).then(function (err, data) {         
              app.helper.hideProgress(); 
               //show notification after Education details saved
                if((data==app.vtranslate('JS_TRANSACTION_LIMIT_EXCEED')) || (data==app.vtranslate('JS_MONTHLY_LIMIT_EXCEED')) || (data==app.vtranslate('JS_YEARLY_LIMIT_EXCEED')) || (data=='undefined')){
                app.helper.showErrorNotification({'message': data});
                $("#totalamount").val('');
           		 }else{ 
           		 	e.preventDefault();
           		 	//app.helper.showSuccessNotification({'message': data});
           		 }
               //Adding or update the Education details in the list
              
             }
          );

           return aDeferred.promise();
				

		  


     },	


	 saveClaimDetails : function(form){   
          var aDeferred = jQuery.Deferred();
          app.helper.hideModal();
          var thisInstance = this;
          var userid = jQuery('#current_user_id').val();
          var user = jQuery('#user').val();
          var manager = jQuery('#manager').val();
          app.helper.showProgress();

        var aparams = form.serializeFormData(); 
      
				aparams.module = app.getModuleName();
				aparams.action = 'SaveSubModuleAjax';
				aparams.mode = 'saveClaim';
		  
				
       
         app.request.post({'data': aparams}).then(function (err, data) {     
              app.helper.hideProgress(); 
               //show notification after Education details saved
                app.helper.showSuccessNotification({'message': data});
               //Adding or update the Education details in the list
               if(manager == 'true'){

               		thisInstance.updateClaimGrid(user);
               }else{
               		thisInstance.updateClaimGrid(userid);
               }
               
             }
          );
           return aDeferred.promise();
     },	

		//Added by jitu@secondcrm on 17-03-2015 for 
/*
	registerSetClaimType : function() {
		$("#my_selyear").select2({ width: '100px'});
		$("#team_selyear").select2({ width: '100px'});
		$("#sel_teammember").select2({ width: '200px'});
		$("#sel_claimtype").select2().select2("val", ' ');
		$("#sel_claimtype").select2(
			{ 
				width:'200px',	
				formatResult: function(item, container) { 
					var originalOption = item.id;
					var originalText = (item.text).split('@');
					var color = originalText[1];
					var balance = originalText[2];
					var title = originalText[0];	
					return '<div title="' + title + '">'+'<span class="empty_fill" style="background-color:#92a8d1;"></span>' + title+'</div>';
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
	},*/
     updateClaimGrid : function(userid) { 
     		//var thisInstance = this;
    		// this.registerActionsTeamClaim(); 
			var params = {
					'module' : app.getModuleName(),
					'view'   : 'ListViewAjax',
					'record' : userid,		
					'mode'   : 'getUserClaim',
				}
				app.request.post({'data':params}).then(
					function(err, data) {
						jQuery('#claim').html(data);
					},
					
					function(error,err){
						aDeferred.reject();
					}
				);
	},


	
	deleteClaim : function(deleteRecordActionUrl) {  
		var message = app.vtranslate('JS_DELETE_CLAIM_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		app.helper.showConfirmationBox({'message' : message}).then(function(e) {
		
          	app.request.post({url:deleteRecordActionUrl}).then(
          	     function(err,data){
				      app.helper.showSuccessNotification({'message': 'Record deleted successfully'});
				     //delete the Education details in the list
				     thisInstance.updateClaimGrid(userid);
			     }
		     );
	     });
     },



  	cancelClaim : function(cancelRecordActionUrl,currentTrElement) {  
		var message = app.vtranslate('JS_CANCEL_CLAIM_CONFIRMATION');
		var thisInstance = this;
		var userid = jQuery('#recordId').val();
		var section = currentTrElement;	
		app.helper.showConfirmationBox({'message' : message}).then(function(data) {
		app.request.post({url:cancelRecordActionUrl}).then(
          	     function(err,data){ 
				      app.helper.showSuccessNotification({'message': 'Cancel successfully'});
				     //delete the Education details in the list
				     thisInstance.updateClaimGrid(userid);
			     }
		     );
	});
},

	registerChangeYear : function(changeYearActionUrl,section) {  

		var thisInstance = this;
	 	var divcontainer  = section =='T'?'myteamclaimlist':'myclaimlist';

//////////////////////////////////

		var aDeferred = jQuery.Deferred();
			
		
		app.helper.showProgress();
		if (section == 'M'){
		my_selyear=jQuery('.my_selyear').val();
		changeYearActionUrl=changeYearActionUrl+'&selyear='+my_selyear;
			}
		app.request.post({url:changeYearActionUrl}).then(
		function(err,data) { 
		      app.helper.hideProgress();
              
                if(err == null){
          		
               $('#' + divcontainer).html(data);

      
                    var form = jQuery('#my_selyear');                        
                        	// for textarea limit
                        app.helper.showVerticalScroll(jQuery('#scrollContainer'), {setHeight:'80%'});
                    
						 Users_Claim_Js.registerActionsTeamClaim();

                         form.submit(function(e) { 
                            e.preventDefault();
                         })
					var params = {
                            submitHandler : function(form){
                                var form = jQuery('#my_selyear');   
                                //thisInstance.saveSkillDetails(form);
                            }
                        };
                         form.vtValidate(params);
                 
          		} else {
                        aDeferred.reject(err);
                    }
	     	});
	     return aDeferred.promise();	


////////////////////////////////////////////


	
	},

	 sel_teammember : function(changeYearActionUrl,section){
 		var membercombo = jQuery('#sel_teammember');
 		var myyearcombo = jQuery("#team_selyear");
		var claimtypecombo = jQuery("#sel_claimtype");
		
			
		Users_Claim_Js.registerChangeYear(changeYearActionUrl+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selclaimtype='+claimtypecombo.val(),section);
	},


	sel_pagination : function(changeYearActionUrl,section){ 
 		var membercombo = jQuery('#sel_teammember');
 		var myyearcombo = jQuery("#team_selyear");
		var claimtypecombo = jQuery("#sel_claimtype");	


		var pagenum = parseInt($('#pageNumber').val());
		var nextpagenum = pagenum + 1;
		
		Users_Claim_Js.registerPaging(changeYearActionUrl+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selclaimtype='+claimtypecombo.val()+'&pagenumber='+nextpagenum,section);
			
		},

	 Popup_ClaimApprove : function(ClaimApproveUrl){   

	 	this.editClaim(ClaimApproveUrl);
 		

			
		

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

			var registerChangeYearlUrl = "?module=Users&view=EditLeave&record="+leaveid+"&userId="+applicantid+"&leavestatus=Apply&manager=true";
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


	registerPaging : function(changePageActionUrl,section) { 
		var thisInstance = this;
	 	var divcontainer  = section =='T'?'myteamclaimlist':'myclaimlist';

//////////////////////////////////

		var aDeferred = jQuery.Deferred();
			
		
		app.helper.showProgress();		
		console.log(changePageActionUrl);
		app.request.post({url:changePageActionUrl}).then(
		function(err,data) { 
		      app.helper.hideProgress();
             
                if(err == null){
                	
               $('#' + divcontainer).html(data);   
               
           	this.registerActionsTeamClaim();	
          			
          		} else {
                        aDeferred.reject(err);
                    }
	     	});

	     return aDeferred.promise();	
	
	},
	
	/*
	 * Function to register all actions in the MY Team List List List
	 */
	registerActionsTeamClaim : function() { 
		var aDeferred = jQuery.Deferred();
		var thisInstance = this;
		var container = jQuery('#MyTeamClaimContainer');
	

		jQuery('#listViewNPageButton, #userclaimnextpagebutton').click(function(e) {  
		
		var myyearcombo = $('#team_selyear');
		var membercombo = jQuery("#sel_teammember");
		var claimtypecombo = jQuery("#sel_claimtype");
		var pagenum = parseInt($('#pageNumber').val());
		var nextpagenum = pagenum + 1;

		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selclaimtype='+claimtypecombo.val()+'&pagenumber='+nextpagenum,myyearcombo.data('section'));
		});

		//register event for my team leave paging<previous>.MYTEAMLEAVEPAGING BY SAFUAN
		container.on('click', '#previouspage,#userclaimprevpagebutton', function(e) {

		var myyearcombo = $('#team_selyear');
		var membercombo = jQuery("#sel_teammember");
		var claimtypecombo = jQuery("#sel_claimtype");
		var pagenum = parseInt($('#pageNumber').val());
		var prevpagenum = pagenum - 1;
		
		thisInstance.registerChangeYear(myyearcombo.data('url')+'&selyear='+myyearcombo.val()+'&selmember='+membercombo.val()+'&selclaimtype='+claimtypecombo.val()+'&pagenumber='+prevpagenum,myyearcombo.data('section'));
		});

		return true;


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
			$('#description').keyup(function() { 
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
	
},{
	

	registerEvents: function() {
	
		//this._super();
	
		//this.registerActions();	
		Users_Claim_Js.registerActionsTeamClaim();	 	
		//Users_Claim_Js.registerSetClaimType();
	}

});

jQuery(document).ready(function(e){ 

	var eduinstance = new Users_Claim_Js();
	eduinstance.registerEvents();



})
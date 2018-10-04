{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}


 <div class="claimModalContainer modal-dialog modal-xs modelContainer">
        {if $MANAGER eq 'true'}
                {assign var="HEADER_TITLE" value={vtranslate('LBL_CLAIM_APPROVAL', $QUALIFIED_MODULE)}}
        {else}
                        {if $LEAVEID neq ''}
                         <h3>{assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_CLAIM', $QUALIFIED_MODULE)}}</h3>
                        {else} 
                         <h3> {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_CLAIM', $QUALIFIED_MODULE)}}</h3>
                {/if}
        {/if}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <form id="editClaim" name="editClaim" class="form-horizontal" method="POST">
                <input type="hidden" name="record" value="{$CLAIMID}" />
                <input type="hidden" id="manager"  name="manager" value="{$MANAGER}" />
                <input type="hidden" name="jobgrade" value="{$JOBGRADE}" />
                <input type="hidden" value="Users" name="module">
                <input type="hidden" value="SaveSubModuleAjax" name="action">
                <input type="hidden" value="saveClaim" name="mode">
                <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}"> 
                <input id="user" name="current_user_id" type="hidden" value="{$smarty.session.authenticated_user_id}">
                <input type="hidden" value="{$CLAIM_DETAIL.claim_status}" name="savetype" id="savetype">
        <!--<input type="hidden" value="{$CLAIM_DETAIL.from_date}" name="hdnstartdate" id="hdnstartdate">
                <input type="hidden" value="{$CLAIM_DETAIL.to_date}" name="hdnenddate" id="hdnenddate">
                <input type="hidden" value="{$CLAIM_DETAIL.leave_type}" name="hdnleavetype" id="hdnleavetype">	
                <input type="hidden" value="{$CLAIM_DETAIL.leavestatus}" name="savetype" id="savetype">  
                <input type="hidden" id="hdnhalfday" id="hdnhalfday" value="" /> -->

                <div class="modal-body">



                        <!--start-->
                                <div class="row-fluid">
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                        &nbsp;{vtranslate('LBL_CLAIM_TYPE', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">

                                        <select  class="select2" name="category" id="category" required data-validation-engine="validate[required]" style="width:100%;" {if $CLAIMSTATUS eq 'Apply'} disabled {/if} >
                                                <option value="">Please Select</option>
                                                {if $CLAIMTYPELIST|count gt 0}
                                                {foreach key=LEAVE_ID item=CLAIM_MODEL from=$CLAIMTYPELIST name=institutionIterator}		
                                                 
                                                <option value="{$CLAIM_MODEL.claimtypeid}" style="float:left;margin-right:5px;background-color:{$CLAIM_MODEL['color_code']};width:30px;height:20px;" data-bal="{$CLAIM_MODEL.balance}" data-transaction="{$CLAIM_MODEL.transaction_limit}" data-monthly="{$CLAIM_MODEL.monthly_limit}" data-yearly="{$CLAIM_MODEL.yearly_limit}" {if $CLAIM_DETAIL.category eq $CLAIM_MODEL.claimtypeid} selected {/if}>
                                                {$CLAIM_MODEL.claimtype} {if $CLAIM_MODEL.balance ne 0} (Max: {$CLAIM_MODEL.balance}){/if}</option>

                                                {/foreach}

                                                 {else}
                                                        <option value=''></option>	
                                                {/if}	

                                        </select>
                                                        </div>
                                                </div>
                                        </div>
                        <!--end-->
 

                                <!--start DATE -->
                                <div class="row-fluid">
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                        {vtranslate('LBL_TRANSACTION_DATE', $QUALIFIED_MODULE)} &nbsp;
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                        <input id="transactiondate" type="text" class="dateField inputElement" type="text" value="{$CLAIM_DETAIL.transactiondate}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="transactiondate" data-date-format="dd-mm-yyyy" data-rule-required = "true" {if $CLAIMSTATUS eq 'Apply'} disabled {/if} >	
                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>&nbsp;&nbsp;
                                                        </div>
                                                </div>
                                        </div>
                        <!--end-->


                        <!--start-->

                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                        {vtranslate('LBL_AMOUNT', $QUALIFIED_MODULE)}&nbsp;<span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                                                 <input id="totalamount" class="fieldValue inputElement" data-trans ="{$CLAIM_MODEL.transaction_limit}"  data-rule-required = "true" type="text" value="{$CLAIM_DETAIL['totalamount']}" name="totalamount" {if $CLAIMSTATUS eq 'Apply'} disabled {/if}>
                                                        </div>
                                                </div>
                                        <div class="col-md-12" id="validateamount" style="margin-bottom: 15px;display:none;">
                                                <div class="col-md-4">
                                                        <label class="control-label" style="text-align: right;float: right;">&nbsp;</label>
                                                </div>	
                                                <div class="redColor" id="alert" style="font-size:12px;">{vtranslate('Please Select Claim Type and Transaction first!', $QUALIFIED_MODULE)}</div>
                                        </div>
                                        </div>
                        <!--end-->
                        <!--start-->

                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                        &nbsp;{vtranslate('LBL_INVOICE', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                                                 <input id="title" class="fieldValue inputElement" data-rule-required = "true" type="text" value="{$CLAIM_DETAIL['taxinvoice']}" name="taxinvoice" {if $CLAIMSTATUS eq 'Apply'} disabled {/if}>
                                                        </div>
                                                </div>
                                        </div>
                        <!--end-->
                             <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>			
                                                <div class="controls date col-md-8">
                                                         <textarea style="width:350px!important" data-rule-required = "true"  id="description" name="description" class="span11"  maxlength="300">{$CLAIM_DETAIL['description']}</textarea>
                                                </div>
                                        </div>	
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label" style="text-align: right;float: right;">&nbsp;</label>
                                                </div>	
                                                <div class="controls pull-right" id="charNum" style="font-size:12px; margin-right: 10px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                                        </div>
                            </div>	
                             <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                   <div class="col-md-4">
                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                &nbsp;{vtranslate('LBL_ATTACHMENTS', $QUALIFIED_MODULE)}
                                        </label>
                                    </div>  
                                    <div class="fileUploadContainer">
                                        <div class="fileUploadBtn btn btn-primary" style="margin-left:15px;" onclick="javascript:Users_Claim_Js.registerFileChange();">
                                            <i class="fa fa-laptop"></i>
                                            <span>{vtranslate('LBL_UPLOAD', $QUALIFIED_MODULE)}</span>
                                            <input id="attachment" class="fieldValue inputElement" type="file" value="{$CLAIM_DETAIL['attachment']}" name="attachment" {if $CLAIMSTATUS eq 'Apply'} disabled {/if}>
                                        </div>&nbsp;<span class="uploadedFileDetails">{$CLAIM_DETAIL['attachment']}</span>
                                    </div>
                                </div>    
                            </div>   
                        <!--start-->
                        {if $MANAGER eq 'true'}
                            <div class="row-fluid">
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                    <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                            <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                    &nbsp;{vtranslate('LBL_APPROVED_BY', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                            </label>
                                        </div>
                                        <div class="controls fieldValue col-md-8">
                                            <select class="select2 form-control" name="approved_by" id="replaceuser" data-validation-engine="validate[required]">
                                            {foreach key=USER_ID item=USER_MODEL from=$USERSLIST name=userIterator}
                                                <option value="{$USER_MODEL.id}" {if $LEAVE_DETAIL.approved_by eq $USER_MODEL.id} selected {/if}>
                                                {$USER_MODEL.fullname}</option>
                                                {/foreach}

                                            </select>
                                        </div>
                                    </div>
                                </div>
                             </div>
                                                <!--end-->


                        <div class="form-group">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-8">
                                 <label for="approve"> 
                                        {if $CLAIM_DETAIL.claim_status == 'Approved'}
                                                &nbsp;<input type="radio" name="claim_status" id="approve" class="pull-left" value="Approved" onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');" checked="checked">
                                                {else}
                                                &nbsp;<input type="radio" name="claim_status" id="approve"  class="pull-left" value="Approved" onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');">
                                                {/if}
                                                {vtranslate('LBL_CLAIM_APPROVED', $QUALIFIED_MODULE)}
                                 </label>
                                 <label for="notapprove" style="margin-left: 31px">
                                                        {if $CLAIM_DETAIL.claim_status eq 'Rejected'}
                                                        <input type="radio" name="claim_status"  class="pull-left" id="notapprove" value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');" checked="checked">
                                                        {else}
                                                        <input type="radio" name="claim_status"  class="pull-left" id="notapprove" value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');">
                                                        {/if}
                                                        &nbsp;{vtranslate('LBL_CLAIM_NOT_APPROVED', $QUALIFIED_MODULE)}
                                 </label>   
                            </div>    
                                <!--approved start-->
                               
                        </div>
                              
                        {/if}

                                <div class="hide" id="rejectionreason" >
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_REJECTION_REASON', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>			
                                                <div class="controls date col-md-8">
                                                        <textarea style="width:350px!important" name="rejectionreasontxt" id="rejectionreasontxt" class="span11" maxlength="300" required data-validation-engine="validate[required]">{$CLAIM_DETAIL['resonforreject']}</textarea>
                                                </div>
                                        </div>	
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label" style="text-align: right;float: right;">&nbsp;</label>
                                                </div>	
                                                <div class="controls pull-right" id="chrNum" style="font-size:12px;margin-right: 13px;">&nbsp;{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                                        </div>
                                </div>	
                                </div>	


                <div class="modal-footer" >
                    <div style="margin-right: 190px;">
                        <div class="pull-right cancelLinkContainer" style="margin-top:0px;">

                {if $MANAGER eq 'true'}
                        <input class="cancelLink btn btn-danger pull-right" type="button" value="{vtranslate('Cancel',$MODULE)}" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal" style="margin-left: 5px;">

                        <input class="btn btn-success" type="submit" value="Save Changes" name="savechanges" accesskey="LBL_SAVE_CHANGES_BUTTON_KEY" title="Save Changes">

                {else}	
                        <input class="cancelLink btn btn-danger  pull-right" type="button" value="{vtranslate('Cancel',$MODULE)}" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal" style="margin-left: 5px;">

                        </div>
                        <!--Enable or disable button-->
                        {if $CLAIMSTATUS eq 'Apply' || $CLAIMSTATUS eq 'Approve' || $CLAIMSTATUS eq 'Not Approved' || $CLAIMSTATUS eq 'Cancel'}
                              <input class="btn btn-disable" type="button"    value="{vtranslate('Apply',$MODULE)}" name="claim_status" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">
                        {else}
                             <input class="btn btn-success" type="submit" value="{vtranslate('Apply',$MODULE)}" name="claim_status" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">
                        {/if}


                {/if}
                    </div>
                </div>  


                </form>
        </div>
</div>
{/strip}
{literal}
<script>
    $('#totalamount').on('change', function() {
        var balance     = parseFloat(jQuery('#category').find(':selected').data('bal'));
        var transaction = parseFloat(jQuery('#category').find(':selected').data('transaction'));
        var monthly     = parseFloat(jQuery('#category').find(':selected').data('monthly'));
        var yearly      = parseFloat(jQuery('#category').find(':selected').data('yearly'));
        var useramount = parseFloat(jQuery('#totalamount').val());        
        if( useramount > balance){
           if(transaction != 0.00){
                app.helper.showErrorNotification({'message': app.vtranslate('JS_TRANSACTION_AMOUNT_EXCEEDED')});
            }else if(monthly != 0.00){
                app.helper.showErrorNotification({'message': app.vtranslate('JS_MONTHLY_AMOUNT_EXCEEDED')});
            }else
                app.helper.showErrorNotification({'message': app.vtranslate('JS_YEARLY_AMOUNT_EXCEEDED')});

            jQuery('#totalamount').val('');
            
        }else if(useramount <= 0){
            jQuery('#totalamount').val('');
        }
    });

                                function show1(){
                                  document.getElementById('div1').style.display ='none';
                                }
                                function show2(){
                                  document.getElementById('div1').style.display = 'block';
                                }

                                        jQuery('#rejectionreasontxt').keyup(function () { 
                                var maxchar = 300;
                                var len = jQuery(this).val().length;
                                if (len > maxchar) {
                                        jQuery('#chrNum').text(' you have reached the limit');
                                        jQuery(this).val($(this).val().substring(0, len-1));
                                } else {
                                        var remainchar = maxchar - len;
                                        jQuery('#chrNum').text(remainchar + ' character(s) left');

                                }
                        });

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
 $(function(){
                if($('#notapprove').is(':checked')){
                $('div#rejectionreason').show();
                }
                 });

          $(function(){
        $(".static_class").click(function(){
          if($(this).val() === "Rejected")
            $("#rejectionreason").show("fast");
          else
            $("#rejectionreason").hide("fast");
        });
      });

        function toggleRejectionReasontxt(trigger){	
        if(trigger == 'show'){
                var txtobj    = document.getElementById('rejectionreason');

                txtobj.className = '';
                //alert('ok'+ trigger);
        }else{
                var txtobj    = document.getElementById('rejectionreason');

                txtobj.className = 'hide';
        }

}


function updateBox(selectbox, txtbox){

        var selectboxid = "#"+selectbox;

        $(selectboxid).select2("data", {id: "0", text: "Others"}); 
        $(selectboxid).select2("close");

        var selectobj = document.getElementById(selectbox);
        var txtobj    = document.getElementById(txtbox);

        txtobj.className = '';
}

function updateSelectBox(selectbox, txtbox)
{
//alert(JSON.stringify(selectbox));
        var selectobj = document.getElementById(selectbox);

        var txtobj    = document.getElementById(txtbox);

        if(selectobj==null || selectobj==undefined || selectobj.value=='0') {
                if(txtbox == 'designationtxt') {
                        txtobj.className = '';
                } 
        } else if(selectobj.value!=null) {
                        txtobj.className = 'hide';
        }
}
</script>
{/literal}

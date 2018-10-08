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

<style>
    .uploadedFileDetails{

    }

</style>
{strip}   
 <div class="leaveModalContainer modal-dialog modal-xs modelContainer">
                {if $MANAGER eq 'true'}
                {assign var="HEADER_TITLE" value={vtranslate('LBL_LEAVE_APPROVAL', $QUALIFIED_MODULE)}}		
                {else}
                        {if $LEAVEID neq ''}
                        {assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_LEAVE', $QUALIFIED_MODULE)}}
                        {else} 
                        {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_LEAVE', $QUALIFIED_MODULE)}}
                        {/if}
                {/if}
                {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>





        <form id="editLeave" name="editLeave" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="record" value="{$LEAVEID}" />

                <input type="hidden" name="manager" value="{$MANAGER}" />
                <input type="hidden" value="Users" name="module">
                <input type="hidden" value="SaveSubModuleAjax" name="action">
                <input type="hidden" value="saveLeave" name="mode">
                <input type="hidden" value="{$LEAVE_DETAIL.from_date}" name="hdnstartdate" id="hdnstartdate">
                <input type="hidden" value="{$LEAVE_DETAIL.to_date}" name="hdnenddate" id="hdnenddate">
                <input type="hidden" value="{$LEAVE_DETAIL.leave_type}" name="hdnleavetype" id="hdnleavetype">	
                <input type="hidden" value="{$LEAVE_DETAIL.leavestatus}" name="savetype" id="savetype">
                <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
                <input type="hidden" id="hdnhalfday" id="hdnhalfday" value="" />
                <div class="modal-body">
                        <!--start-->

                        <div class="control-group">
                                <label class="control-label fieldLabel col-md-4">
                                        &nbsp;{vtranslate('LBL_LEAVE_TYPE', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                </label>

                                <div class="controls  col-md-8">
                                    <select class="select2" name="leave_type" id="leave_type" data-validation-engine="validate[required]" style="width:100%;">
                                                {if $LEAVETYPELIST|count gt 0}
                                                {foreach key=LEAVE_ID item=LEAVE_MODEL from=$LEAVETYPELIST name=institutionIterator}		
                                                        {$LEAVE_MODEL.leavetypeid}
                                                <option value="{$LEAVE_MODEL.leavetypeid}" {if $LEAVE_DETAIL.leave_type eq $LEAVE_MODEL.leavetypeid} selected {/if}>
                                                {$LEAVE_MODEL.leavetype} 
                                                &nbsp;&nbsp;({$LEAVE_MODEL.leave_remain}) 
                                              

                                        </option>

                                                {/foreach}

                                                 {else}
                                                        <option value=''></option>	
                                                {/if}	

                                        </select>
                                </div>

                        </div><br><br>
                <!--end-->
                        <div class="control-group">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                <div class="controls date  col-md-8">
                                        <input id="start_date" type="text" class="dateField inputElement" type="text" value="{$LEAVE_DETAIL.from_date}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="start_date" data-date-format="dd-mm-yyyy" required>	
                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>&nbsp;&nbsp;
                                        <div style="float: right;margin-bottom:10px;margin-top:10px;">
                                            <span style="margin-right:7px;" id="starthalfcheck" class="hide">{vtranslate('LBL_HALF_DAY', $QUALIFIED_MODULE)}</span>
                                            <input type="checkbox" {if $LEAVE_DETAIL.starthalf eq 1} checked {/if} name="starthalf" id="starthalf" value="1" style="float: left;
    margin-right: 10px;">

                                        </div>
                                </div>
                        </div><br><br>
                        <div class="control-group">
                        <div class="control-group" id="enddate_div">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                <div class="controls row-fluid date  col-md-8">
                                        <input id="end_date" type="text" class="dateField inputElement nameFields" type="text" value="{if $LEAVE_DETAIL.to_date neq '00-00-0000'}{$LEAVE_DETAIL.to_date}{/if}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($ENDDATEFIELD))}'  data-validator={$VALIDATOR} data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"  name="end_date" data-date-format="dd-mm-yyyy" required>	
                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>&nbsp;&nbsp;
                                        <span style="margin-right:7px;" class="{if $LEAVE_DETAIL.endhalf eq 0} hide {/if}" id="endhalfcheck">{vtranslate('LBL_HALF_DAY', $QUALIFIED_MODULE)}</span>
                                        <input type="checkbox" name="endhalf" class="{if $LEAVE_DETAIL.endhalf eq 0} hide {/if}"  {if $LEAVE_DETAIL.endhalf eq 1} checked{/if} id="endhalf" value="1">
                                </div>
                        </div><br><br>
                        <div class="control-group">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_REPLACE_USER', $QUALIFIED_MODULE)}</label>		
                                        <div class="controls  col-md-8">
                                        <select class="select2" name="replaceuser" id="replaceuser" data-validation-engine="validate[required]" style="width:100%;">
                                                {foreach key=USER_ID item=USER_MODEL from=$USERSLIST name=userIterator}
                                                <option value="{$USER_MODEL.id}" {if $LEAVE_DETAIL.replaceuser eq $USER_MODEL.id} selected {/if}>
                                                {$USER_MODEL.fullname}</option>
                                                {/foreach}

                                        </select>
                                </div>
                        </div><br>&nbsp;<br>
                </div>
                        <div class="control-group">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_REASON', $QUALIFIED_MODULE)}  <span class="redColor">*</span> </label>		
                                <div class="controls  col-md-8">
                                        <textarea style="width:100%;" name="reason" id="reason" class="span11" required maxlength="300">{$LEAVE_DETAIL.leave_reason}</textarea>
                                </div>
                                <div class="controls text-right" id="charNum_reason" style="font-size:12px; margin-right: 13px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px !important;">
                            <div class="col-md-12" style="margin-bottom: 15px;">
                               <div class="col-md-4">
                                    <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                            &nbsp;{vtranslate('LBL_ATTACHMENTS', $QUALIFIED_MODULE)} 
                                    </label>
                                </div>  
                                <div class="fileUploadContainer">
                                    <div class="fileUploadBtn btn btn-primary" style="margin-left:15px;" onclick="javascript:Users_Leave_Js.registerFileChange();">
                                        <i class="fa fa-laptop"></i>
                                        <span>{vtranslate('LBL_UPLOAD', $QUALIFIED_MODULE)}</span>
                                        <input id="attachment" class="fieldValue inputElement" type="file" value="{$CLAIM_DETAIL['attachment']}" name="attachment" {if $LEAVESTATUS eq 'Apply'} disabled {/if}>
                                    </div>&nbsp;<span class="uploadedFileDetails">{$LEAVE_DETAIL.attachment}</span>
                                </div>
                                
                            </div>    
                        </div>        
                {if $MANAGER eq 'true'}
                        <div class="control-group">
                                <!--approved start-->
                                <div class="form-group">
                                        <div class="col-md-4">
                                        </div>
                                            <div class="col-md-8">
                                                 <label for="approve"> 
                                                        {if $LEAVE_DETAIL.leavestatus eq 'Approved'}
                                                                &nbsp;<input type="radio" name="approval" id="approve" class="pull-left" value="Approved" required onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');" checked="checked">
                                                                {else}
                                                                &nbsp;<input type="radio" name="approval" id="approve"  class="pull-left" value="Approved" required onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');">
                                                                {/if}
                                                                {vtranslate('LBL_APPROVED', $QUALIFIED_MODULE)}
                                                 </label>
                                                 <label for="notapprove" style="margin-left: 31px">
                                                                        {if $LEAVE_DETAIL.leavestatus eq 'Not Approved'}
                                                                        <input type="radio" name="approval"  class="pull-left" id="notapprove" required value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');" checked="checked">
                                                                        {else}
                                                                        <input type="radio" name="approval"  class="pull-left" id="notapprove" required value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');">
                                                                        {/if}
                                                                        &nbsp;{vtranslate('LBL_NOT_APPROVED', $QUALIFIED_MODULE)}
                                                 </label>   
                                            </div>
                                </div><br>
                {/if}
                        <div class="hide" id="rejectionreason">
                        <div class="control-group">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_REJECTION_REASON', $QUALIFIED_MODULE)}<span class="redColor">*</span></label>		
                                <div class="controls  col-md-8">
                                        <textarea style="width:350px!important" required name="rejectionreasontxt" id="rejectionreasontxt" class="span11" maxlength="300">{$LEAVE_DETAIL.reasonnotapprove}</textarea>

                                </div>
                                <div class="controls text-right" id="charNum" style="font-size:12px; margin-right: 13px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                                <label class="control-label fieldLabel">&nbsp;</label>
                              <!--  <div class="controls inputElement" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>-->
                        </div>
                        </div>

                </div>
                <div class="modal-footer" style="margin-bottom: 10px;margin-right: 10px; margin-left: 10px; padding-top: 5px; padding-bottom: 5px;">
                    <div style="margin-right: 140px;">
                        <div class="pull-right cancelLinkContainer" style="margin-top:0px;margin-left: 5px;">

                {if $MANAGER eq 'true'}
                        <input class="btn btn-success" type="submit" value="{vtranslate('Save Changes',$MODULE)}" name="savechanges" accesskey="LBL_SAVE_CHANGES_BUTTON_KEY" title="Save Changes">
                         <input class="cancelLink btn btn-danger" type="button" value="{vtranslate('Cancel',$MODULE)}" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel" aria-hidden="true" data-dismiss="modal">
                         
                        </div>
                {else}	
                        <input class="cancelLink btn btn-danger" type="button" value="{vtranslate('Cancel',$MODULE)}" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal">

                        <!--Enable or disable button-->
                        {if $LEAVESTATUS eq 'Apply' || $LEAVESTATUS eq 'Approve' || $LEAVESTATUS eq 'Not Approved' || $LEAVESTATUS eq 'Canccel'}

                        <input class="btn btn-disable" type="button" onclick="document.getElementById('savetype').value='Apply'"  value= "{vtranslate('Apply Leave',$MODULE)}" name="applyleave" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">
                        {else}
                        <input class="btn btn-success" type="submit" onclick="document.getElementById('savetype').value='Apply'"  value="{vtranslate('Apply Leave',$MODULE)}" name="applyleave" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">

                        {/if}

                        <!--Enable or disable button-->
                        {if $LEAVESTATUS eq 'Apply' || $LEAVESTATUS eq 'Approve' || $LEAVESTATUS eq 'Not Approved' || $LEAVESTATUS eq 'Canccel'}

                        <input class="btn btn-disable" type="button" onclick="document.getElementById('savetype').value='New';" value="{vtranslate('Save As Draft',$MODULE)}" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
                        {else}
                        <input class="btn btn-success" type="submit" onclick="document.getElementById('savetype').value='New';" value="{vtranslate('Save As Draft',$MODULE)}" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">

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
function toggleRejectionReasontxt(trigger){	
        if(trigger == 'show'){
                var txtobj    = document.getElementById('rejectionreason');
                txtobj.className = '';
                Users_Leave_Js.textAreaLimitCharDisapprove();
                //alert('ok'+ trigger);
        }else{
                var txtobj    = document.getElementById('rejectionreason');
                txtobj.className = 'hide';
        }

}
</script>
{/literal}

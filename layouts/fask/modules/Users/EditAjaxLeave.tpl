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
<!--
{strip}
<style>
.select2
{
        width:300px;
}
span.empty_fill {
    display:block;
    overflow:visible;
    width:20px;
    height:20px;
    color:#FFFFFF;
   float:left;
margin-right:10px;
margin-top:2px;
}
#starthalf{
        position:relative;
        top:-3px;
}
</style>
<script>
jQuery(document).ready(function(e){ 
/*('#testSelect').select2({
                                allowClear: true,
                                formatResult: format,
                                formatSelection: format
                        });
*/
});

</script>
<div class="leaveModalContainer">
        <div class="modal-header contentsBackground">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                {if $MANAGER eq 'true'}	
                <h3>{vtranslate('LBL_LEAVE_APPROVAL', $QUALIFIED_MODULE)}</h3>
                {else}
                        {if $LEAVEID neq ''}
                         <h3>{vtranslate('LBL_EDIT_LEAVE', $QUALIFIED_MODULE)}</h3>
                        {else} 
                         <h3>{vtranslate('LBL_ADD_NEW_LEAVE', $QUALIFIED_MODULE)}</h3>
                        {/if}
                {/if}
        </div>
-->
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





        <form id="editLeave" name="editLeave" class="form-horizontal" method="POST">
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
                                                {if $LEAVE_MODEL.leave_remain gt 0} 
                                                  {$LEAVE_MODEL.leave_remain} {vtranslate('LBL_DAY_REMAINING', $QUALIFIED_MODULE)}
                                                {else}
                                                   {vtranslate('LBL_0_DAY_REMAINING', $QUALIFIED_MODULE)}
                                                {/if}

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
                                        <input id="start_date" type="text" class="dateField inputElement" type="text" value="{$LEAVE_DETAIL.from_date}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="start_date" data-date-format="dd-mm-yyyy">	
                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>&nbsp;&nbsp;
                                        <div style="float: right;margin-bottom:10px;margin-top:10px;">
                                            <span style="margin-right:7px;" id="starthalfcheck" class="hide">{vtranslate('LBL_HALF_DAY', $QUALIFIED_MODULE)}</span>
                                            <input type="checkbox" class="hide" {if $LEAVE_DETAIL.starthalf eq 1} checked {/if} name="starthalf" id="starthalf" value="" style="float: left;
    margin-right: 10px;">

                                        </div>
                                </div>
                        </div><br><br>
                        <div class="control-group">
                        <div class="control-group" id="enddate_div">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                <div class="controls row-fluid date  col-md-8">
                                        <input id="end_date" type="text" class="dateField inputElement nameFields" type="text" value="{if $LEAVE_DETAIL.to_date neq '00-00-0000'}{$LEAVE_DETAIL.to_date}{/if}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($ENDDATEFIELD))}'  data-validator={$VALIDATOR} data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"  name="end_date" data-date-format="dd-mm-yyyy" >	
                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>&nbsp;&nbsp;
                                        <span style="margin-right:7px;" class="{if $LEAVE_DETAIL.endhalf eq 0} hide {/if}" id="endhalfcheck">{vtranslate('LBL_HALF_DAY', $QUALIFIED_MODULE)}</span>
                                        <input type="checkbox" name="endhalf" class="{if $LEAVE_DETAIL.endhalf eq 0} hide {/if}"  {if $LEAVE_DETAIL.endhalf eq 1} checked{/if} id="endhalf" value="">
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
                                        <textarea style="width:100%;" name="reason" id="reason" class="span11" maxlength="300" data-validation-engine="validate[required]">{$LEAVE_DETAIL.leave_reason}</textarea>
                                </div>
                                <label class="control-label fieldLabel">&nbsp;</label>
                                <div class="controls" id="charNum_reason" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                        </div><br><br>
                {if $MANAGER eq 'true'}
                        <div class="control-group">
                                <!--approved start-->
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_APPROVED', $QUALIFIED_MODULE)}</label>

                                <div class="controls  col-md-8">
                                        <span>
                                                {if {$LEAVE_DETAIL.leavestatus == 'Approved'}}
                                                <input type="radio" name="approval" id="approve" value="Approved" onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');" checked="checked">
                                                {else}
                                                <input type="radio" name="approval" id="approve" value="Approved" onclick="document.getElementById('savetype').value='Approved';toggleRejectionReasontxt('hide');">
                                                {/if}
                                        </span>
                                        <!--not approved start-->
                                        <span>
                                                <span style="position:relative;top:4px;padding-left:20px;padding-right:15px;">{vtranslate('LBL_NOT_APPROVED', $QUALIFIED_MODULE)}</span>
                                                <span>
                                                        {if {$LEAVE_DETAIL.leavestatus == 'Not Approved'}}
                                                        <input type="radio" name="approval" id="notapprove" value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');" checked="checked">
                                                        {else}
                                                        <input type="radio" name="approval" id="notapprove" value="Not Approved" onclick="document.getElementById('savetype').value='Not Approved';toggleRejectionReasontxt('show');">
                                                        {/if}
                                                </span>
                                        </span>
                                </div>

                        </div><br><br>
                {/if}
                        <div class="hide" id="rejectionreason">
                        <div class="control-group">
                                <label class="control-label fieldLabel  col-md-4">&nbsp;{vtranslate('LBL_REJECTION_REASON', $QUALIFIED_MODULE)}</label>		
                                <div class="controls  col-md-8">
                                        <textarea style="width:300px!important" name="rejectionreasontxt" id="rejectionreasontxt" class="span11" maxlength="300">{$LEAVE_DETAIL.reasonnotapprove}</textarea>

                                </div>
                                <label class="control-label fieldLabel">&nbsp;</label>
                                <div class="controls inputElement" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                        </div><br><br>
                        </div>

                </div>
                <div class="modal-footer">
                        <div class="pull-right cancelLinkContainer" style="margin-top:0px;margin-left: 5px;">

                {if $MANAGER eq 'true'}
                        <input class="cancelLink btn btn-danger" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel" aria-hidden="true" data-dismiss="modal">

                        <input class="btn btn-success" type="submit" value="Save Changes" name="savechanges" accesskey="LBL_SAVE_CHANGES_BUTTON_KEY" title="Save Changes">

                {else}	
                        <input class="cancelLink btn btn-danger" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal">

                        </div>
                        <!--Enable or disable button-->
                        {if $LEAVESTATUS eq 'Apply' || $LEAVESTATUS eq 'Approve' || $LEAVESTATUS eq 'Not Approved' || $LEAVESTATUS eq 'Canccel'}
                        <input class="btn btn-disable" type="button" onclick="document.getElementById('savetype').value='Apply'"  value="Apply Leave" name="applyleave" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">
                        {else}
                        <input class="btn btn-success" type="submit" onclick="document.getElementById('savetype').value='Apply'"  value="Apply Leave" name="applyleave" accesskey="LBL_APPLY_BUTTON_KEY" title="Apply Leave">
                        {/if}

                        <!--Enable or disable button-->
                        {if $LEAVESTATUS eq 'Apply' || $LEAVESTATUS eq 'Approve' || $LEAVESTATUS eq 'Not Approved' || $LEAVESTATUS eq 'Canccel'}
                        <input class="btn btn-disable" type="button" onclick="document.getElementById('savetype').value='New';" value="Save As Draft" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
                        {else}
                        <input class="btn btn-success" type="submit" onclick="document.getElementById('savetype').value='New';" value="Save As Draft" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
                        {/if}
                {/if}
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
                if(txtbox == 'leave_typetxt' || txtbox == 'areaofstudytxt') {
                        txtobj.className = '';
                } 
        } else if(selectobj.value!=null) {
                        txtobj.className = 'hide';
        }
}
</script>
{/literal}

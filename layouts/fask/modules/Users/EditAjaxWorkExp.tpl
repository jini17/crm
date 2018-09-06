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
 <div class="workexpModalContainer modal-dialog modal-xs modelContainer">
        {if $UW_ID neq ''}
                {assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_WORKEXP', $QUALIFIED_MODULE)}}
        {else} 
                 {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_WORKEXP', $QUALIFIED_MODULE)}}
        {/if}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <form id="editWorkExp" class="form-horizontal" method="POST">
                        <input type="hidden" name="record" value="{$UW_ID}" />
                        <!--<input type="hidden" value="Users" name="module">
                        <input type="hidden" value="SaveSubModuleAjax" name="action">
                        <input type="hidden" value="saveEducation" name="mode">-->
                        <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
                        <div class="modal-body">
                                <!--start-->
                                <div class="row-fluid">
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                       &nbsp;{vtranslate('LBL_COMPANY_NAME', $QUALIFIED_MODULE)} &nbsp;  <span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                                                        <select class="select2 inputElement"onchange="updateSelectBox('company_title','comtxt');" name="company_title" id="company_title" data-rule-required = "true" style="width: 100%;">
                                                                                <option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 
                                                                                {foreach key=COMPANY_ID item=COMPANY_MODEL from=$COMPANY_LIST name=companyIterator}
                                                                                <option value="{$COMPANY_MODEL.company_id}" {if $WORKEXP_DETAIL.company_id eq $COMPANY_MODEL.company_id} selected {/if}>
                                                                                ({$COMPANY_MODEL.company_title})</option>
                                                                                {/foreach}						
                                                                                <option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
                                                                        </select>
                                                        </div>
                                                </div>

                                                <div class="col-md-12" style="margin-bottom: 15px;">
                                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                </label>
                                                        </div>

                                                        <div class="controls fieldValue col-md-8" align="right">
                                                                <span class="hide" id="comtxt">
                                                                    <input class="inputElement" type="text" name="companytxt" id="companytxt" data-rule-required = "true" />
                                                                </span>
                                                        </div>
                                                </div>
                                        </div>
                        <!--end-->
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_DESIGNATION', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>
                                                <div class="controls date col-md-8">
                                                    <select class="select2 inputElement" onchange="updateSelectBox('designation','desigtxt');" name="designation" id="designation" data-rule-required = "true" style="width:100%;">
                                                                <option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 
                                                                {foreach key=DESIGNATION_ID item=DESIGNATION_MODEL from=$DESIGNATION_LIST name=designationIterator}
                                                                <option value="{$DESIGNATION_MODEL.designation_id}" {if $WORKEXP_DETAIL.designation_id eq $DESIGNATION_MODEL.designation_id} selected {/if}>
                                                                ({$DESIGNATION_MODEL.designation})</option>
                                                                {/foreach}	
                                                                <option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
                                                </select>		
                                                </div>
                                        </div>
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                        </label>
                                                </div>

                                                <div class="controls fieldValue col-md-8" align="right">
                                                        <span class="hide" id="desigtxt">
                                                                <input style="width:100%;" type="text" name="designtxt" id="designtxt" data-rule-required = "true"/>
                                                        </span>
                                                </div>
                                        </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_LOCATION', $QUALIFIED_MODULE)}</label>
                                                </div>
                                                <div class="controls col-md-8">
                                                    <select class="select2" onchange="updateSelectBox('location','loctxt');" name="location" id="location" style="width: 100%;">
                                                                <option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option>
                                                                {foreach key=LOCATION_ID item=LOCATION_MODEL from=$LOCATION_LIST name=designationIterator}
                                                                <option value="{$LOCATION_MODEL.location_id}" {if $WORKEXP_DETAIL.location_id eq $LOCATION_MODEL.location_id} selected {/if}>
                                                                ({$LOCATION_MODEL.location})</option>
                                                                {/foreach}
                                                                <option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
                                                        </select>
                                                </div>
                                        </div>
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                        </label>
                                                </div>

                                                <div class="controls fieldValue col-md-8" align="right">
                                                        <span class="hide" id="loctxt">
                                                                <input  style="width:100%;" type="text" name="locatxt" id="locatxt" data-rule-required = "true"/>
                                                        </span>
                                                </div>
                                        </div>
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <input id="start_date" type="text" class="dateField inputElement" type="text" value="{$WORKEXP_DETAIL.start_date}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="start_date" data-date-format="dd-mm-yyyy">	
                                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>		
                                                </div>
                                        </div>
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;"> &nbsp;{vtranslate('LBL_CURRENTLY_WORKING', $QUALIFIED_MODULE)} &nbsp; <span class="redColor">*</span></label>
                                                </div>	

                                                <div class="controls date col-md-8">
                                                         <input type="checkbox" class="currentworking inputElement" name="chkcurrently" id="chkcurrently" {if $WORKEXP_DETAIL.currentlyworking eq 1} checked {/if}>
                                                </div>		
                                        </div>
                                </div>		 	
                                <div class="form-group  {if $WORKEXP_DETAIL.currentlyworking eq 1} hide{/if}" style="margin-bottom: 0px !important;" id="enddate_div">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)} &nbsp; <span class="redColor">*</span></label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <input id="end_date" type="text" class="dateField inputElement" type="text" value="{if $WORKEXP_DETAIL.end_date neq '00-00-0000'}{$WORKEXP_DETAIL.end_date}{/if}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($ENDDATEFIELD))}'  data-validator={$VALIDATOR} data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"  name="end_date" data-date-format="dd-mm-yyyy" >	
                                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>	
                                                </div>
                                        </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>
                                                </div>			
                                                <div class="controls date col-md-8">
                                                        <textarea style="width:300px!important" maxlength="300" name="description" id="description" class="span11" >{$WORKEXP_DETAIL.description}</textarea>
                                                </div>
                                        </div>	
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;</label>
                                                </div>	
                                                <div class="controls" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                                        </div>
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                          <input type="checkbox" {(''==$UW_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $WORKEXP_DETAIL.isview eq 1} checked {/if}>
                                                </div>	
                                        </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                                 {include file='ModalFooter.tpl'|@vtemplate_path:'Vtiger'}
                        </div>    	 	
                </form>
        </div>
</div>
{/strip}
{literal}
<script>

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
        var selectobj = document.getElementById(selectbox);
        var txtobj    = document.getElementById(txtbox);
        if(selectobj.value=='0') {
                if(txtbox == 'comtxt' || txtbox == 'desigtxt' || txtbox == 'loctxt') {
                        txtobj.className = '';
                } 
        } else {
                txtobj.className = 'hide';
        }
}
</script>
{/literal}
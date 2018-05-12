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
<style>
.select2
{
	width:300px;
}
</style>
<div class="workexpModalContainer">
	<div class="modal-header contentsBackground">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		{if $UW_ID neq ''}
		 <h3>{vtranslate('LBL_EDIT_WORKEXP', $QUALIFIED_MODULE)}</h3>
		{else} 
		 <h3>{vtranslate('LBL_ADD_NEW_WORKEXP', $QUALIFIED_MODULE)}</h3>
		{/if}
	</div>
	<form id="editWorkExp" name="editWorkExp" class="form-horizontal" method="POST">		
	<input type="hidden" name="record" value="{$UW_ID}" />
	<input type="hidden" value="Users" name="module">
	<input type="hidden" value="SaveSubModuleAjax" name="action">
	<input type="hidden" value="saveWorkExp" name="mode">
	<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label">
				   {vtranslate('LBL_COMPANY_NAME', $QUALIFIED_MODULE)}
				</label>
				<div class="controls">
					<select class="select2" onchange="updateSelectBox('company_title','comtxt');" name="company_title" id="company_title">
						{foreach key=COMPANY_ID item=COMPANY_MODEL from=$COMPANY_LIST name=companyIterator}
						<option value="{$COMPANY_MODEL.company_id}" {if $WORKEXP_DETAIL.company_id eq $COMPANY_MODEL.company_id} selected {/if}>
						({$COMPANY_MODEL.company_title})</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<div style="margin-left:160px;" class="hide controls" id="comtxt"><input style="width:290px;" type="text" name="companytxt" id="companytxt" data-validation-engine="validate[required]"/></div>
			</div>	

			<div class="control-group">
				<label class="control-label">
				   {vtranslate('LBL_DESIGNATION', $QUALIFIED_MODULE)}
				</label>
				<div class="controls">
					<select class="select2" onchange="updateSelectBox('designation','desigtxt');" name="designation" id="designation" >
						{foreach key=DESIGNATION_ID item=DESIGNATION_MODEL from=$DESIGNATION_LIST name=designationIterator}
						<option value="{$DESIGNATION_MODEL.designation_id}" {if $WORKEXP_DETAIL.designation_id eq $DESIGNATION_MODEL.designation_id} selected {/if}>
						({$DESIGNATION_MODEL.designation})</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<div style="margin-left:160px;" class="hide controls" id="desigtxt"><input style="width:290px;" type="text" name="designationtxt" id="designationtxt" data-validation-engine="validate[required]"/></div>
			</div>	
			<div class="control-group">
				<label class="control-label">
					{vtranslate('LBL_LOCATION', $QUALIFIED_MODULE)}
				</label>
				<div class="controls">
					<select class="select2" onchange="updateSelectBox('location','loctxt');" name="location" id="location">
						{foreach key=LOCATION_ID item=LOCATION_MODEL from=$LOCATION_LIST name=designationIterator}
						<option value="{$LOCATION_MODEL.location_id}" {if $WORKEXP_DETAIL.location_id eq $LOCATION_MODEL.location_id} selected {/if}>
						({$LOCATION_MODEL.location})</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<div style="margin-left:160px;" class="hide controls" id="loctxt"><input style="width:290px;" type="text" name="locationtxt" id="locationtxt" data-validation-engine="validate[required]"/></div>
			</div>	
			<div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls date">
					<input id="start_date" type="text" class="dateField" type="text" value="{$WORKEXP_DETAIL.start_date}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="start_date" data-date-format="dd-mm-yyyy">	
					<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>		
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_CURRENTLY_WORKING', $QUALIFIED_MODULE)}</label>
				<div class="controls">
				   <input type="checkbox" class="currentworking" name="chkcurrently" id="chkcurrently" {if $WORKEXP_DETAIL.is_working eq 1} checked {/if}>
				</div>
			</div>	
			<div class="control-group {if $WORKEXP_DETAIL.is_working eq 1} hide{/if}" id="enddate_div">
				<label class="control-label">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls row-fluid date">
					<input id="end_date" type="text" class="dateField" type="text" value="{if $WORKEXP_DETAIL.end_date neq '00-00-0000'}{$WORKEXP_DETAIL.end_date}{/if}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($ENDDATEFIELD))}'  data-validator={$VALIDATOR} data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"  name="end_date" data-date-format="dd-mm-yyyy" >	
					<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>	
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>		
				<div class="controls">
					<textarea style="width:300px!important" maxlength="300" name="description" id="description" class="span11" >{$WORKEXP_DETAIL.description}</textarea>
				</div>
				<label class="control-label">&nbsp;</label>
				<div class="controls" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
				<div class="controls">
				   <input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $WORKEXP_DETAIL.isview eq 1} checked {/if}>
				</div>
			</div>	
		</div>	
		<div class="modal-footer">
			<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
				<input class="cancelLink" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel" style="margin:0;background:none;border:none;" aria-hidden="true" data-dismiss="modal">
			</div>
			<input class="btn btn-success" type="submit" value="Save" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
		</div>
	</form>
</div>
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
{/strip}

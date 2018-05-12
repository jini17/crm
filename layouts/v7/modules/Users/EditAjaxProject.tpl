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
#s2id_project_month{
	margin-right:5px;
}
</style>
<div class="projectModalContainer">
	<div class="modal-header contentsBackground">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		{if $PROJECT_ID neq ''}
		<h3>{vtranslate('LBL_EDIT_PROJECT', $QUALIFIED_MODULE)}</h3>
		{else} 
		 <h3>{vtranslate('LBL_ADD_NEW_PROJECT', $QUALIFIED_MODULE)}</h3>
		{/if}
	</div>
	<form id="editProject" name="editProject" class="form-horizontal" method="POST">
		<input type="hidden" name="record" value="{$PROJECT_ID}" />
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="saveProject" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_PROJECT_TITLE', $QUALIFIED_MODULE)}
				</label>
				<div class="controls">
				   <input id="title" class="fieldValue" type="text" data-validation-engine="validate[required]" value="{$PROJECT_DETAIL['title']}" name="title">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>		
				<div class="controls">
					 <textarea style="width:300px!important"  id="description" name="description" class="span11"  maxlength="300">{$PROJECT_DETAIL['description']}</textarea>
				</div>
				<label class="control-label">&nbsp;</label>
				<div class="controls" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
			</div>
		    <div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_OCCUPATION', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<select class="select2" name="designation" id="designation" data-validation-engine="validate[required]">	{foreach item=DESIGNATION from=$DESIGNATION_LIST}
						{if $PROJECT_DETAIL['designation'] eq $DESIGNATION_LIST.designation_id}
						<option value="{$DESIGNATION.designation_id}" selected>{if $DESIGNATION.relation_type eq 'E'} Student at {/if}{$DESIGNATION.designation}</option>
						{else}
						<option value="{$DESIGNATION.designation_id}">{if $DESIGNATION.relation_type eq 'E'} Student at {/if}{$DESIGNATION.designation}</option>
						{/if}
						{/foreach}
					</select>	
				</div>
			</div>
		    <div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<select style="width:50%;" class="select2" name="project_month" id="project_month" data-validation-engine="validate[required]">
						{foreach item=MONTH from=$PROJECT_MONTH}
						{if $PROJECT_DETAIL['project_month'] eq $MONTH}
						<option value="{$MONTH}" selected>{$MONTH}</option>
						{else}
						<option value="{$MONTH}">{$MONTH}</option>
						{/if}
						{/foreach}
					</select>	
					<select style="width:45%;" class="select2" name="project_year" id="project_year" data-validation-engine="validate[required]">
						{for $iend=1970 to $CURRENTYEAR}
						{if $PROJECT_DETAIL['project_year'] eq $iend}
						<option value="{$iend}" selected>{$iend}</option>
						{else}
						<option value="{$iend}" {if $iend eq $CURRENTYEAR}selected{/if}>{$iend}</option>
						{/if}
						{/for}
					</select>
				</div>	
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_PROJECT_URL', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<input id="project_url" class="fieldValue" type="text" value="{$PROJECT_DETAIL['project_url']}" name="project_url">
				</div>
			</div>		 	
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
				<div class="controls">
				   <input type="checkbox" {(''==$PROJECT_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $PROJECT_DETAIL.isview eq 1} checked {/if}>
				</div>
			</div>	
		</div>
		<div class="modal-footer">
			<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
			<input class="cancelLink" type="button" value="Cancel" name="button" 						 accesskey="LBL_CANCEL_BUTTON_KEY" 						title="Cancel" style="margin:0;background:none;border:none;" aria-hidden="true" data-dismiss="modal">
			</div>
			<input class="btn btn-success" type="submit" value="Save" name="saverecord" 				accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
		</div>		 	
	</form>
</div>
{/strip}

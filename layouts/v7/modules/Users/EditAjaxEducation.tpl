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
	margin-left:0;
}
</style>
<div class="educationModalContainer">
	<div class="modal-header contentsBackground">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		{if $EDU_ID neq ''}
		 <h3>{vtranslate('LBL_EDIT_EDUCATION', $QUALIFIED_MODULE)}</h3>
		{else} 
		 <h3>{vtranslate('LBL_ADD_NEW_EDUCATION', $QUALIFIED_MODULE)}</h3>
		{/if}
	</div>
	<form id="editEducation" name="editEducation" class="form-horizontal" method="POST">
		<input type="hidden" name="record" value="{$EDU_ID}" />
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="saveEducation" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
		<div class="modal-body">
			<!--start-->
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_INSTITUTION_NAME', $QUALIFIED_MODULE)}
				</label>
				<div class="controls">
					<select class="select2" onchange="updateSelectBox('institution_name','institution_nametxt');" name="institution_name" id="institution_name" data-validation-engine="validate[required]">
						{foreach key=INSTITUTION_ID item=INSTITUTION_MODEL from=$INSTITUTION_LIST name=institutionIterator}
						<option value="{$INSTITUTION_MODEL.institution_id}" {if $EDUCATION_DETAIL.institution_id eq $INSTITUTION_MODEL.institution_id} selected {/if}>
						({$INSTITUTION_MODEL.institution})</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<label class="control-label"></label>
				<div class="controls">
					<span class="hide" id="institution_nametxt">
						<input style="width:290px;" type="text" name="institutiontxt" id="institutiontxt" data-validation-engine="validate[required]"/>
					</span>
				</div>
			</div>
		<!--end-->
			<div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls date">
					<input id="start_date" type="text" class="dateField" type="text" value="{$EDUCATION_DETAIL.start_date}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($STARTDATEFIELD))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" name="start_date" data-date-format="dd-mm-yyyy">	
					<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>		
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_CURRENTLY_STUDYING', $QUALIFIED_MODULE)}</label>
				<div class="controls">
				   <input type="checkbox" class="currentstudying" name="chkstudying" id="chkstudying" {if $EDUCATION_DETAIL.is_studying eq 1} checked {/if}>
				</div>
			</div>	
			<div class="control-group {if $EDUCATION_DETAIL.is_studying eq 1} hide{/if}" id="enddate_div">
				<label class="control-label">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls row-fluid date">
					<input id="end_date" type="text" class="dateField" type="text" value="{if $EDUCATION_DETAIL.end_date neq '00-00-0000'}{$EDUCATION_DETAIL.end_date}{/if}" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($ENDDATEFIELD))}'  data-validator={$VALIDATOR} data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"  name="end_date" data-date-format="dd-mm-yyyy" >	
					<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>	
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_EDUCATION_LEVEL', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<select class="select2 span4" name="education_level" id="education_level" data-validation-engine="validate[required]">
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}">{vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}">{vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}">{vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MBA', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MBA', $QUALIFIED_MODULE)}">{vtranslate('LBL_MBA', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}">{vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MD', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MD', $QUALIFIED_MODULE)}">{vtranslate('LBL_MD', $QUALIFIED_MODULE)}</option>
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_PHD', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_PHD', $QUALIFIED_MODULE)}">{vtranslate('LBL_PHD', $QUALIFIED_MODULE)}</option> 	
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_ENG', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_ENG', $QUALIFIED_MODULE)}">{vtranslate('LBL_ENG', $QUALIFIED_MODULE)}</option> 	
						<option {if $EDUCATION_DETAIL.education_level eq {vtranslate('OTHERS', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('OTHERS', $QUALIFIED_MODULE)}">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>	
				</div>
			</div>		 	
			<div class="control-group">
				<label class="control-label"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_AREA_OF_STUDY', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<select class="select2" onchange="updateSelectBox('areaofstudy','areaofstudytxt');" name="areaofstudy" id ="areaofstudy">	
						{foreach key=MAJOR_ID item=MAJOR_MODEL from=$MAJOR_LIST name=majorIterator}
						<option value="{$MAJOR_MODEL.major_id}" {if $EDUCATION_DETAIL.major_id eq $MAJOR_MODEL.major_id} selected {/if}>
						({$MAJOR_MODEL.major})</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
					</select>	
				</div>
				<label class="control-label"></label>
				<div class="controls">
				<span class="hide" id="areaofstudytxt"><input type="text" name="majortxt" id="majortxt" data-validation-engine="validate[required]"/></span>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>		
				<div class="controls">
					<textarea style="width:300px!important" name="description" id="description" class="span11" maxlength="300" >{$EDUCATION_DETAIL.description}</textarea>	
				</div>
				<label class="control-label">&nbsp;</label>
				<div class="controls" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
			</div>
			<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $EDUCATION_DETAIL.isview eq 1} checked {/if}>
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
//alert(JSON.stringify(selectbox));
	var selectobj = document.getElementById(selectbox);

	var txtobj    = document.getElementById(txtbox);

	if(selectobj==null || selectobj==undefined || selectobj.value=='0') {
		if(txtbox == 'institution_nametxt' || txtbox == 'areaofstudytxt') {
			txtobj.className = '';
		} 
	} else if(selectobj.value!=null) {
			txtobj.className = 'hide';
	}
}
</script>
{/literal}

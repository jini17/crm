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
 <div class="educationModalContainer modal-dialog modal-xs modelContainer">
 	{if $EDU_ID neq ''}
 	 	{assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_EDUCATION', $QUALIFIED_MODULE)}}
	{else} 
		 {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_EDUCATION', $QUALIFIED_MODULE)}}
	{/if}
 	{include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
	<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		
	<form id="editEducation" class="form-horizontal" method="POST">
		<input type="hidden" name="record" value="{$EDU_ID}" />
		<!--<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="saveEducation" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">-->
		<div class="modal-body">
			<!--start-->
			<div class="row-fluid">
                <div class="form-group" style="margin-bottom: 0px !important;">
                	<div class="col-md-12" style="margin-bottom: 15px;">
                		<div class="col-md-4">
							<label class="control-label fieldLabel" style="text-align: right;float: right;">
								<span class="redColor">*</span>&nbsp;{vtranslate('LBL_INSTITUTION_NAME', $QUALIFIED_MODULE)}
							</label>
						</div>
						<div class="controls fieldValue col-md-8">
							<select class="select2 inputElement" onchange="updateSelectBox('institution_name','institution_nametxt');" name="institution_name" id="institution_name" data-rule-required = "true">
							{foreach key=INSTITUTION_ID item=INSTITUTION_MODEL from=$INSTITUTION_LIST name=institutionIterator}
							<option value="{$INSTITUTION_MODEL.institution_id}" {if $EDUCATION_DETAIL.institution_id eq $INSTITUTION_MODEL.institution_id} selected {/if}>
							({$INSTITUTION_MODEL.institution})</option>
							{/foreach}
							<option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 	
							<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
							</select>
						</div>
					</div>
					
					<div class="col-md-12" style="margin-bottom: 15px;">
						<div class="col-md-4">
								<label class="control-label fieldLabel" style="text-align: right;float: right;"></label>
						</div>

						<div class="controls fieldValue col-md-8" align="right">
							<span class="hide" id="institution_nametxt">
								<input style="width:100%;" type="text" name="institutiontxt" id="institutiontxt" data-rule-required = "true" />
							</span>
						</div>
					</div>
				</div>
		<!--end-->
			<div class="form-group" style="margin-bottom: 0px !important;">
				<div class="col-md-12" style="margin-bottom: 15px;">
					<div class="col-md-4">
						<label class="control-label" style="text-align: right;float: right;"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)}</label>
					</div>
					<div class="controls date col-md-8">
						<input style="width: 100%;" id="start_date" type="text" class="dateField" type="text" value="{$EDUCATION_DETAIL.start_date}" data-rule-required = "true" name="start_date" data-date-format="dd-mm-yyyy">	
						<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>		
					</div>
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0px !important;">
				<div class="col-md-12" style="margin-bottom: 15px;">
					<div class="col-md-4">
						<label class="control-label" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_CURRENTLY_STUDYING', $QUALIFIED_MODULE)}</label>
					</div>
					<div class="controls col-md-8">
				  		<input type="checkbox" class="currentstudying" name="chkstudying" id="chkstudying" {if $EDUCATION_DETAIL.is_studying eq 1} checked {/if}>
					</div>
				</div>
			</div>	
			<div class="form-group {if $EDUCATION_DETAIL.is_studying eq 1} hide{/if}" id="enddate_div" style="margin-bottom: 0px !important;">
				<label class="control-label" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)}</label>
				<div class="controls row-fluid date">
					<input id="end_date" type="text" class="dateField" type="text" value="{if $EDUCATION_DETAIL.end_date neq '00-00-0000'}{$EDUCATION_DETAIL.end_date}{/if}" data-rule-required = "true"  name="end_date" data-date-format="dd-mm-yyyy" >	
					<span class="add-on">&nbsp;<i class="icon-calendar"></i></span>	
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0px !important;">
				<label class="control-label" style="text-align: right;float: right;"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_EDUCATION_LEVEL', $QUALIFIED_MODULE)}</label>
				<div class="controls fieldValue col-xs-6">
					<select class="select2 inputElement" name="education_level" id="education_level" data-rule-required = "true">
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
			<div class="form-group" style="margin-bottom: 0px !important;">
				<label class="control-label" style="text-align: right;float: right;"><span class="redColor">*</span>&nbsp;{vtranslate('LBL_AREA_OF_STUDY', $QUALIFIED_MODULE)}</label>
				<div class="controls fieldValue col-xs-6">
					<select class="select2 inputElement" onchange="updateSelectBox('areaofstudy','areaofstudytxt');" name="areaofstudy" id ="areaofstudy" data-rule-required = "true">	
						{foreach key=MAJOR_ID item=MAJOR_MODEL from=$MAJOR_LIST name=majorIterator}
						<option value="{$MAJOR_MODEL.major_id}" {if $EDUCATION_DETAIL.major_id eq $MAJOR_MODEL.major_id} selected {/if}>
						({$MAJOR_MODEL.major})</option>
						{/foreach}
						<option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 	
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
					</select>	
				</div>
				<label class="control-label" style="text-align: right;float: right;"></label>
				<div class="controls">
				<span class="hide" id="areaofstudytxt"><input type="text" name="majortxt" id="majortxt" data-rule-required = "true"/></span>
				</div>
			</div>
			<div class="form-group" style="margin-bottom: 0px !important;">
				<label class="control-label" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>		
				<div class="controls">
					<textarea style="width:300px!important" name="description" id="description" class="span11" maxlength="300" data-rule-required = "true" >{$EDUCATION_DETAIL.description}</textarea>	
				</div>
				<label class="control-label" style="text-align: right;float: right;">&nbsp;</label>
				<div class="controls" id="charNum" style="font-size:12px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
			</div>
			<div class="form-group" style="margin-bottom: 0px !important;">
				<label class="control-label" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $EDUCATION_DETAIL.isview eq 1} checked {/if}>
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
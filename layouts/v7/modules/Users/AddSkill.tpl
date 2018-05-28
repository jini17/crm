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
		 {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_SKILL', $QUALIFIED_MODULE)}}
	{/if}
 	{include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
 	
	<div class="modal-content">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		
	<form id="addSkill" name="addSkill" class="form-horizontal" method="POST">
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="saveSkill" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">	
			<div class="modal-body">
				<!--start-->
				<div class="row-fluid">
	                <div class="form-group" style="margin-bottom: 0px !important;">
	                	<div class="col-md-12" style="margin-bottom: 15px;">
	                		<div class="col-md-4">
								<label class="control-label fieldLabel" style="text-align: right;float: right;">
									<span class="redColor">*</span>&nbsp;{vtranslate('LBL_ADD_SKILL', $QUALIFIED_MODULE)}
								</label>
							</div>
							<div class="controls fieldValue col-md-8">
								<select class="select2 inputElement" onchange="updateSelectBox('institution_name','institution_nametxt');" name="skill" id="institution_name" data-rule-required = "true">
									<option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 
								{foreach key=INSTITUTION_ID item=SKILL_MODEL from=$SKILL_LIST name=institutionIterator}
								<option value="{$SKILL_MODEL.skill_id}">{$SKILL_MODEL.skill}</option>
								{/foreach}
									
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
									<input style="width:100%;" type="text" name="skilltxt" id="institutiontxt" data-rule-required = "true" />
								</span>
							</div>
						</div>
					</div>
			<!--end-->
			
			
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
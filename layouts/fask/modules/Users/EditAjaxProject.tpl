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
 <div class="projectModalContainer modal-dialog modal-xs modelContainer">
        {if $PROJECT_ID neq ''}
                {assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_PROJECT', $QUALIFIED_MODULE)}}
        {else} 
                 {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_PROJECT', $QUALIFIED_MODULE)}}
        {/if}

        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <form id="editProject" class="form-horizontal" method="POST">
                        <input type="hidden" name="record" value="{$PROJECT_ID}" />
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
                                                                        &nbsp;{vtranslate('LBL_PROJECT_TITLE', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                                                 <input id="title" class="fieldValue inputElement" data-rule-required = "true" type="text" value="{$PROJECT_DETAIL['title']}" name="title">
                                                        </div>
                                                </div>
                                        </div>
                        <!--end-->
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;"> &nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>			
                                                <div class="controls date col-md-8">
                                                         <textarea style="width:300px!important" data-rule-required = "true"  id="description" name="description" class="span11"  maxlength="300">{$PROJECT_DETAIL['description']}</textarea>
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
                                                        <label class="control-label fieldLabel  pull-right btn-block">&nbsp;{vtranslate('LBL_OCCUPATION', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>
                                                <div class="controls col-md-8">
                                                        <select class="select2" name="designation" id="designation" onchange="updateSelectBox('designation','designationtxt');" data-rule-required = "true" style="width: 100%;">	
                                                                <option value="" selected>Select Anyone</option>
                                                                {foreach item=DESIGNATION from=$DESIGNATION_LIST}
                                                                <option value="{$DESIGNATION.designation}" {if $PROJECT_DETAIL['designation'] eq $DESIGNATION.designation} selected {/if}>{$DESIGNATION.designation}</option>
                                                        {/foreach}
                                                        <option value="0">Others</option>
                                                </select>	
                                                </div>
                                                <div class="col-md-12" style="margin-bottom: 15px;">
                                                        <div class="col-md-4">
                                                                        <label class="control-label fieldLabel pull-right btn-block" style="text-align: right;float: right;"></label>
                                                        </div>

                                                        <div class="controls fieldValue col-md-8" align="right">
                                                                <span class="hide" id="designationtxt">
                                                                        <input class="inputElement" type="text" name="designation_titletxt" id="designation_titletxt"  data-rule-required = "true" />
                                                                </span>
                                                        </div>
                                                </div>
                                        </div>
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel pull-right btn-block">&nbsp;{vtranslate('LBL_DATE', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <select style="width:50%;" class="select2" name="project_month" id="project_month" data-rule-required = "true" >
                                                                {foreach item=MONTH key=k from=$PROJECT_MONTH}
                                                                {if $PROJECT_DETAIL['project_month'] eq $k}
                                                                <option value="{$k}" selected>{$MONTH}</option>
                                                                {else}
                                                                <option value="{$k}">{$MONTH}</option>
                                                                {/if}
                                                                {/foreach}
                                                        </select>
                                                        <select style="width:45%;" class="select2" name="project_year" id="project_year" data-rule-required = "true" >
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
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel pull-right btn-block">&nbsp;{vtranslate('LBL_PROJECT_URL', $QUALIFIED_MODULE)}</label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <input id="project_url" class="fieldValue inputElement" type="text" value="{$PROJECT_DETAIL['project_url']}" name="project_url" data-rule-required = "true" >
                                                </div>		
                                        </div>
                                </div>		 	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <input class="inputElement" type="checkbox" name="chkviewable" id="chkviewable" {if $PROJECT_DETAIL.isview eq 1} checked {/if}>
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
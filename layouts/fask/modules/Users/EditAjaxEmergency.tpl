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
        {if $REC_ID neq ''}
                {assign var="HEADER_TITLE" value={vtranslate('Edit Emergency Contact', $QUALIFIED_MODULE)}}
        {else} 
                 {assign var="HEADER_TITLE" value={vtranslate('Add Emergency Contact', $QUALIFIED_MODULE)}}
        {/if}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

        <form id="editEmergency" name="editEmergency" class="form-horizontal" method="POST">
                <input type="hidden" name="record_id" value="{$REC_ID}" />
                <input type="hidden" value="Users" name="module">
                <input type="hidden" value="SaveSubModuleAjax" name="action">
                <input type="hidden" value="saveEmergencyContact" name="mode">
                <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
                <div class="modal-body">
                         <!--start-->
                    <div class="row-fluid addemergency">
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                <label class="control-label fieldLabel">
                                                    &nbsp;{vtranslate('LBL_CONTACT_NAME', $MODULE)} &nbsp;  <span class="redColor">*</span>
                                                </label>
                                        </div>
                                        <div class="controls fieldValue col-md-8">
                                            <input id="contact_name" class="input-large inputElement nameField" type="text"  value="{if !empty($REC_ID)} {$EMERGENCY_DETAIL[0]['contact_name']}{/if}" name="contact_name"  data-validation-engine="validate[required]" data-rule-required = "true">
                                        </div>
                                </div>
                        </div>
                        <!--end-->
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                <label class="control-label fieldLabel">
                                                    &nbsp;{vtranslate('LBL_HOME_PH', $MODULE)} &nbsp;  <span class="redColor">*</span>
                                                </label>
                                        </div>
                                        <div class="controls fieldValue col-md-8">
                                            <input id="home_phone" class="input-large inputElement nameField" type="text"  value="{if !empty($REC_ID)} {$EMERGENCY_DETAIL[0]['home_phone']}{/if}" name="home_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($HOMEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true" maxlength="15">
                                        </div>
                                </div>

                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                <label class="control-label fieldLabel">
                                                    &nbsp;{vtranslate('LBL_OFFICE_PH', $MODULE)} <span class="redColor">*</span>
                                                </label>
                                        </div>
                                        <div class="controls fieldValue col-md-8">
                                            <input id="office_phone" class="input-large inputElement nameField" type="text" value="{if !empty($REC_ID)} {$EMERGENCY_DETAIL[0]['office_phone']}{/if}" name="office_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($OFFICEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true" maxlength="15">
                                        </div>
                                </div>

                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                <label class="control-label  fieldLabel">
                                                    &nbsp;{vtranslate('LBL_MOBILE', $MODULE)} &nbsp;    <span class="redColor">*</span>
                                                </label>
                                        </div>
                                        <div class="controls fieldValue col-md-8">
                                            <input id="mobile" class="input-large inputElement nameField" type="text"  value="{if !empty($REC_ID)} {$EMERGENCY_DETAIL[0]['mobile']}{/if}" name="mobile" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($MOBILEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true" maxlength="15">
                                        </div>
                                </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                <label class="control-label fieldLabel">
                                                    &nbsp;{vtranslate('LBL_RELATIONSHIP', $MODULE)} &nbsp;   <span class="redColor">*</span>
                                                </label>
                                        </div>

                                        <div class="controls fieldValue col-md-8">
                                            <select class="select2" name="relationship" id ="relationship" data-rule-required = "true" style="width:100%;"> 
                                                <option value="{vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('LBL_FATHER', $QUALIFIED_MODULE)} selected {/if}>
                                                {vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)} selected {/if}>
                                                {vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)} selected {/if}>
                                                {vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('LBL_SISTER', $QUALIFIED_MODULE)} selected {/if}>
                                                {vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)} selected {/if}>
                                                {vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('OTHERS', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL[0]['relationship'] eq vtranslate('OTHERS', $QUALIFIED_MODULE)} selected {/if}>{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
                                        </select>
                                        </div>
                                </div>
                        </div>

                    </div>
                        <!--<div class="control-group">
                                <label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
                                <div class="controls">
                                        <input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $EMERGENCY_DETAIL.isview eq 1} checked {/if}>
                                </div>
                        </div>-->
                </div>
                <div class="modal-footer" style="margin-bottom: 10px;margin-right: 10px; margin-left: 10px;">
                    <div style="margin-right: 220px;">
                        <div class="pull-right cancelLinkContainer" style="margin-top:0px;margin-left: 5px;">
                                <input class="cancelLink btn btn-danger" type="button" value="{vtranslate('Cancel',$MODULE)}" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal">
                        </div>
                        <input class="btn btn-success" type="submit" value="{vtranslate('Save',$MODULE)}" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
                    </div>
                </div>    	 	
        </form>


        </div>
</div>
{/strip}

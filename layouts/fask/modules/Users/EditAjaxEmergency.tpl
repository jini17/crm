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
                {assign var="HEADER_TITLE" value={vtranslate('Edit Emergency Contact', $QUALIFIED_MODULE)}}
        {else} 
                 {assign var="HEADER_TITLE" value={vtranslate('Add Emergency Contact', $QUALIFIED_MODULE)}}
        {/if}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>


        <form id="editEmergency" name="editEmergency" class="form-horizontal" method="POST">
                <input type="hidden" name="record" value="{$EDU_ID}" />
                <input type="hidden" value="Users" name="module">
                <input type="hidden" value="SaveSubModuleAjax" name="action">
                <input type="hidden" value="saveEmergencyContact" name="mode">
                <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
                <div class="modal-body">
                        <!--start-->
                        <div class="control-group">
                                <label class="control-label fieldLabel">
                                    &nbsp;{vtranslate('LBL_CONTACT_NAME', $MODULE)} &nbsp;  <span class="redColor">*</span>
                                </label>
                                <div class="controls">
                                        <input id="contact_name" class="input-large inputElement nameField" type="text"  value="{$EMERGENCY_DETAIL['contact_name']}" name="contact_name"  data-validation-engine="validate[required]" data-rule-required = "true">
                                </div>
                          
                        </div>
                <!--end-->
                        <div class="control-group">
                                <label class="control-label fieldLabel">
                                    &nbsp;{vtranslate('LBL_HOME_PH', $MODULE)} &nbsp;  <span class="redColor">*</span>
                                </label>
                                <div class="controls">
                                        <input id="home_phone" class="input-large inputElement nameField" type="text"  value="{$EMERGENCY_DETAIL['home_phone']}" name="home_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($HOMEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true">
                                </div>
                        </div>
                        <div class="control-group">
                                <label class="control-label fieldLabel">
                                        &nbsp;{vtranslate('LBL_OFFICE_PH', $MODULE)} &nbsp; <span class="redColor">*</span>
                                </label>
                                <div class="controls">
                                        <input id="office_phone" class="input-large inputElement nameField" type="text" value="{$EMERGENCY_DETAIL['office_phone']}" name="office_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($OFFICEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true">
                                </div>
                        </div>
                        <div class="control-group">
                                <label class="control-label  fieldLabel">
                                     &nbsp;{vtranslate('LBL_MOBILE', $MODULE)} &nbsp;    <span class="redColor">*</span>
                                </label>
                                <div class="controls">
                                        <input id="mobile" class="input-large inputElement nameField" type="text"  value="{$EMERGENCY_DETAIL['mobile']}" name="mobile" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($MOBILEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-rule-required = "true">
                                </div>
                        </div>		 	
                        <div class="control-group">
                                <label class="control-label fieldLabel">
                                      &nbsp;{vtranslate('LBL_RELATIONSHIP', $MODULE)} &nbsp;   <span class="redColor">*</span>
                                </label>
                                <div class="controls">
                                    <select class="select2" name="relationship" id ="relationship" data-rule-required = "true" style="width:100%;">	
                                                <option value="{vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}} selected {/if}>
                                                {vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}} selected {/if}>
                                                {vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}} selected {/if}>
                                                {vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}} selected {/if}>
                                                {vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}} selected {/if}>
                                                {vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}</option>

                                                <option value="{vtranslate('OTHERS', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('OTHERS', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
                                        </select>	
                                </div>
                        </div>
                        <!--<div class="control-group">
                                <label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
                                <div class="controls">
                                        <input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $EMERGENCY_DETAIL.isview eq 1} checked {/if}>
                                </div>
                        </div>-->
                </div>
                <div class="modal-footer">
                        <div class="pull-right cancelLinkContainer" style="margin-top:0px;">
                                <input class="cancelLink btn btn-danger" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel"  aria-hidden="true" data-dismiss="modal">
                        </div>
                        <input class="btn btn-success" type="submit" value="Save" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
                </div>    	 	
        </form>


        </div>
</div>
{/strip}

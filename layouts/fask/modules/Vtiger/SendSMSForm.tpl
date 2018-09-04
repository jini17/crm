{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Vtiger/views/MassActionAjax.php *}

<div id="sendSmsContainer" class='modal-xs modal-dialog'>
    <div class = "modal-content">
        {assign var=TITLE value="{vtranslate('LBL_SEND_SMS', $MODULE)}"}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$TITLE}

        <form class="form-horizontal" id="massSave" method="post" action="index.php">
            <input type="hidden" name="module" value="{$MODULE}" />
            <input type="hidden" name="source_module" value="{$SOURCE_MODULE}" />
            <input type="hidden" name="action" value="MassSaveAjax" />
            <input type="hidden" name="viewname" value="{$VIEWNAME}" />
            <input type="hidden" name="selected_ids" value={ZEND_JSON::encode($SELECTED_IDS)}>
            <input type="hidden" name="excluded_ids" value={ZEND_JSON::encode($EXCLUDED_IDS)}>
            <input type="hidden" name="search_key" value= "{$SEARCH_KEY}" />
            <input type="hidden" name="operator" value="{$OPERATOR}" />
            <input type="hidden" name="search_value" value="{$ALPHABET_VALUE}" />
            <input type="hidden" name="search_params" value='{ZEND_JSON::encode($SEARCH_PARAMS)}' />
            
            <div class="modal-body">
                <div>
                    <span><strong>{vtranslate('LBL_STEP_1',$MODULE)}</strong></span>
                    &nbsp;:&nbsp;
                    {vtranslate('LBL_SELECT_THE_PHONE_NUMBER_FIELDS_TO_SEND',$MODULE)}
                </div>
                <br>
                <div>
                    <div>
                        <select name="fields[]" data-placeholder="{vtranslate('LBL_SELECT_THE_PHONE_NUMBER_FIELDS_TO_SEND',$MODULE)}" data-rule-required="true" multiple class = "select2 form-control">
                            {foreach item=PHONE_FIELD from=$PHONE_FIELDS}
                                {assign var=PHONE_FIELD_NAME value=$PHONE_FIELD->get('name')}
                                <option value="{$PHONE_FIELD_NAME}">
                                    {if !empty($SINGLE_RECORD)}
                                        {assign var=FIELD_VALUE value=$SINGLE_RECORD->get($PHONE_FIELD_NAME)}
                                    {/if}
                                    {vtranslate($PHONE_FIELD->get('label'), $SOURCE_MODULE)}{if !empty($FIELD_VALUE)} ({$FIELD_VALUE}){/if}
                                </option>
                            {/foreach}
                        </select>
                    </div>
                    <br>        
                    <div>
                        <span id='phoneFormatWarning'> 
                            <i rel="popover" data-placement="right" id="phoneFormatWarningPop" class="glyphicon glyphicon-info-sign" style="padding-right : 5px; padding-left : 5px" data-original-title="{vtranslate('LBL_WARNING',$MODULE)}" data-trigger="hover" data-content="{vtranslate('LBL_PHONEFORMAT_WARNING_CONTENT',$MODULE)}"></i>
                            {vtranslate('LBL_PHONE_FORMAT_WARNING', $MODULE)}
                        </span>
                    </div>
                </div>
                <!-----Added By Mabruk on 06/04/2018 For SMS Vendor---->
                <hr>
                <div>
                    <div>
                        <span><strong>{vtranslate('LBL_STEP_2',$MODULE)}</strong></span>
                        &nbsp;:&nbsp;
                        {vtranslate('LBL_SELECT_THE_SMS_PROVIDER',$MODULE)}
                    </div>
                    <br>                    
                    <div>
                        <select class="select2-container select2 inputElement col-sm-6 selectModule" id="smsvendor" name="smsvendor" data-rule-required="true" aria-required="true" style="width:50%">
                            <option>{vtranslate('LBL_SELECT_VENDOR', $MODULE)}</option>
                            {foreach item=VENDOR from=$VENDORS}
                            <option value={$VENDOR.providertype}>{$VENDOR.providertype}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <!------END------>

                <!-----Added By Mabruk on 30/04/2018 For SMS Template Type---->
                <hr>
                <div>
                    <div>
                        <span><strong>{vtranslate('LBL_STEP_3',$MODULE)}</strong></span>
                        &nbsp;:&nbsp;
                        {vtranslate('LBL_SELECT_THE_SMS_TEMPLATE',$MODULE)}
                    </div>
                    <br>                    
                    <div>
                        <select class="select2-container select2 inputElement col-sm-6 selectModule" id="smstemplate" name="smstemplate" data-rule-required="true" aria-required="true" style="width:50%">
                            <option>{vtranslate('LBL_SELECT_TEMPLATE', $MODULE)}</option>
                            {foreach item=TEMPLATE from=$TEMPLATES}
                            <option value={$TEMPLATE.templateid}>{$TEMPLATE.templatename}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <br>
                <!------END------>
                <div>
                <br>    
                <hr>    
                    <span><strong>{vtranslate('LBL_STEP_4',$MODULE)}</strong></span>
                    &nbsp;:&nbsp;
                    {vtranslate('LBL_TYPE_THE_MESSAGE',$MODULE)}&nbsp;(&nbsp;{vtranslate('LBL_SMS_MAX_CHARACTERS_ALLOWED',$MODULE)}&nbsp;)
                </div>
                <br>
                <textarea class="form-control smsTextArea" data-rule-required="true" name="message" id="message" maxlength="160" placeholder="{vtranslate('LBL_WRITE_YOUR_MESSAGE_HERE', $MODULE)}"></textarea>
            </div>
            <div>
                <div class="modal-footer">
                    <center>
                        <button class="btn btn-success" type="submit" name="saveButton"><strong>{vtranslate('LBL_SEND', $MODULE)}</strong></button>
                        <a class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                    </center>
                </div>
            </div>
        </form>
    </div>
</div>



{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
    <div class="row" style="margin-bottom: 70px;">
        <div class="col-lg-9">
            <div class="row form-group">
                <div class="col-lg-2">{vtranslate('LBL_RECEPIENTS',$QUALIFIED_MODULE)}<span class="redColor">*</span></div>
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-5">
                            <input type="text" class="inputElement fields" data-rule-required="true" name="sms_recepient" value="{$TASK_OBJECT->sms_recepient}" />
                        </div>
                        <div class="col-lg-6">
                            <select class="select2 task-fields" style="min-width: 150px;" data-placeholder="{vtranslate('LBL_SELECT_FIELDS', $QUALIFIED_MODULE)}">
                                <option></option>
                                {foreach from=$RECORD_STRUCTURE_MODEL->getFieldsByType('phone') item=FIELD key=FIELD_VALUE}
                                    <option value=",${$FIELD_VALUE}">({vtranslate($FIELD->getModule()->get('name'),$FIELD->getModule()->get('name'))})  {vtranslate($FIELD->get('label'),$FIELD->getModule()->get('name'))}</option>
                                {/foreach}
                            </select>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-lg-2">{vtranslate('LBL_ADD_FIELDS',$QUALIFIED_MODULE)}</div>
                <div class="col-lg-10">
                    <select class="select2 task-fields" style="min-width: 150px;" data-placeholder="{vtranslate('LBL_SELECT_FIELDS', $QUALIFIED_MODULE)}">
                        <option></option>
                        {$ALL_FIELD_OPTIONS}
                    </select>   
                </div>
                <div class="col-lg-2"> &nbsp; </div>
                             
            </div>
            <!-----Added By Mabruk on 06/04/2018 For SMS Vendor---->
                  <div class="form-group">
                      <div class="col-lg-2">
                           Select SMS Vendor<span class="redColor">*</span>
                      </div>
                      <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                            <select class="select2-container select2 inputElement col-sm-6 selectModule" id="smsvendor" name="smsvendor" data-rule-required="true" aria-required="true">
                                {foreach item=VENDOR from=$VENDORS}
                                    {if $VENDOR.providertype eq $TASK_OBJECT->smsvendor}
                                        <option value={$VENDOR.providertype} selected>{$VENDOR.providertype}</option>
                                    {else}    
                                        <option value={$VENDOR.providertype}>{$VENDOR.providertype}</option>
                                    {/if}    
                                {/foreach}
                            </select>
                      </div>
                  </div>
            <!------END------>
            
            <!-----Added By Mabruk on 30/04/2018 For SMS Template---->      
                  <div class="form-group">
                      <div class="col-lg-2">
                           Select SMS Template
                      </div>
                      <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                            <select class="select2-container select2 inputElement col-sm-6 selectModule" id="smstemplate" name="smstemplate">
                                <option value=''>Select a SMS Template</option>
                                {foreach item=TEMPLATE from=$TEMPLATES}
                                    {if $TEMPLATE.templateid eq $TASK_OBJECT->smstemplate}
                                        <option value={$TEMPLATE.templateid} selected>{$TEMPLATE.templatename}</option>
                                    {else}    
                                        <option value={$TEMPLATE.templateid}>{$TEMPLATE.templatename}</option>
                                    {/if}    
                                {/foreach}
                            </select>
                      </div>
                  </div>            
                  <div class="form-group">  
                    <div class="col-lg-2">{vtranslate('LBL_SMS_TEXT',$QUALIFIED_MODULE)}</div>
                    <div class="col-lg-6">
                        <textarea id="content" name="content" class="inputElement fields" style="height: inherit;">{$TASK_OBJECT->content}</textarea>
                    </div>
                  <div class="form-group">
            <!------END------>          
        </div>
    </div>
{/strip}    

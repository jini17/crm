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
    <style>
        #Users_detailView_fieldLabel_signature{
            height: 48px;
        }
        .detailViewContainer .block{
            padding-bottom: 15px;
        }
    </style>
     <div class="contents">
            <div class="block">
                <div class="row">
                    <div class="col-xs-12"><h5>{vtranslate('LBL_CHANGE_PASSWORD','Users')} </h5>
                        <div class='clearfix'></div>
                        <hr>                        
                    </div>
                </div>
                <div class="row">
                    <div class='col-xs-12'>
                        <form class="form-horizontal" id="changePassword" name="changePassword" method="post" action="index.php" novalidate="novalidate">
                            <input type="hidden" name="__vtrftk" value="sid:fe329e04a69675cb4c85e8737687ca187f65a1e2,1543035448">
                            <input type="hidden" name="module" value="Users">
                            <input type="hidden" name="userid" value="1">
                            <div name="massEditContent">   
                                <div class="form-group">
                                    <label class="control-label fieldLabel col-sm-5">New Password&nbsp;<span class="redColor">*</span></label>
                                    <div class="controls col-xs-6">
                                        <input type="password" class="form-control inputElement" name="new_password" data-rule-required="true" autofocus="autofocus" aria-required="true">
                                    </div>
                                </div>
                                <div class='clearfix'></div>
                                <div class='clearfix' style='height: 10px;'></div>
                                <div class="form-group">
                                    <label class="control-label fieldLabel col-sm-5">Confirm Password&nbsp;<span class="redColor">*</span></label>
                                    <div class="controls col-xs-6">
                                        <input type="password" class="form-control inputElement" name="confirm_password" data-rule-required="true" aria-required="true">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                         <div class="controls col-xs-12 pull-right">
                                             <button class="btn btn-success pull-right"  onclick="Users_Detail_Js.triggerUpdatePassword()"type="button" name="saveButton">
                                                <strong>Save</strong>
                                            </button>
                                         </div>
                                </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        <div class="clearfix"></div>
    <form id="detailView" data-name-fields='{ZEND_JSON::encode($MODULE_MODEL->getNameFields())}' method="POST">
            <div class="contents">
            {foreach key=BLOCK_LABEL_KEY item=FIELD_MODEL_LIST from=$RECORD_STRUCTURE}
                <div class="block block_{$BLOCK_LABEL_KEY}">
                    {assign var=BLOCK value=$BLOCK_LIST[$BLOCK_LABEL_KEY]}
                {if $BLOCK eq null or $FIELD_MODEL_LIST|@count lte 0}{continue}{/if}
                {assign var=IS_HIDDEN value=$BLOCK->isHidden()}
                {assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
                <input type=hidden name="timeFormatOptions" data-value='{$DAY_STARTS}' />
                <div class="row">
                    <h5 class="col-xs-8">{vtranslate({$BLOCK_LABEL_KEY},{$MODULE_NAME})}</h4>
                    <div class="col-xs-4 ">
                        <div class=" pull-right detailViewButtoncontainer">
                            <!--Added By Mabruk-->
                            {if $BLOCK_LABEL_KEY eq "LBL_CALENDAR_SETTINGS"}
                            <div class="btn-group  pull-right">
                                <a class="btn btn-primary" href="{$RECORD->getCalendarSettingsEditViewUrl()}">Edit</a>
                            </div>  
                            {/if}
                        </div>
                    </div>
                </div>
                <hr>
                <div class=" row">
                    <div class='col-md-12'>
                     
                        <div class="table detailview-table" style="width: 100%;margin: 0 auto;">
                            {assign var=COUNTER value=0}
                            <div class="row">
                                {foreach item=FIELD_MODEL key=FIELD_NAME from=$FIELD_MODEL_LIST}
                                    {assign var=fieldDataType value=$FIELD_MODEL->getFieldDataType()}
                                    {if !$FIELD_MODEL->isViewableInDetailView()}
                                        {continue}
                                    {/if}
                                
                                        {foreach item=tax key=count from=$TAXCLASS_DETAILS}
                                            {if $COUNTER eq 1}
                            </div>
                                <div class="row">
                                                {assign var="COUNTER" value=1}
                                            {else}
                                                {assign var="COUNTER" value=$COUNTER+1}
                                            {/if}
                                            <div class="col-lg-3 fieldLabel {$WIDTHTYPE}">
                                                <span class='muted'>{vtranslate($tax.taxlabel, $MODULE)}(%)</span>
                                            </div>
                                            <div class="col-lg-3 fieldValue {$WIDTHTYPE}">
                                                <span class="value textOverflowEllipsis" data-field-type="{$FIELD_MODEL->getFieldDataType()}" >
                                                    {if $tax.check_value eq 1}
                                                        {$tax.percentage}
                                                    {else}
                                                        0
                                                    {/if} 
                                                </span>
                                            </div>
                                        {/foreach}                                                                 
                                        
                                      
                            
                                        <div class="col-lg-3 fieldLabel textOverflowEllipsis {$WIDTHTYPE}" id="{$MODULE_NAME}_detailView_fieldLabel_{$FIELD_MODEL->getName()}" {if $FIELD_MODEL->getName() eq 'description' or $FIELD_MODEL->get('uitype') eq '69'} style='width:8%'{/if}>
                                            <span class="muted">
                                                {if $MODULE_NAME eq 'Documents' && $FIELD_MODEL->get('label') eq "File Name" && $RECORD->get('filelocationtype') eq 'E'}
                                                    {vtranslate("LBL_FILE_URL",{$MODULE_NAME})}
                                                {else}
                                                    {vtranslate({$FIELD_MODEL->get('label')},{$MODULE_NAME})}
                                                {/if}
                                                {if ($FIELD_MODEL->get('uitype') eq '72') && ($FIELD_MODEL->getName() eq 'unit_price')}
                                                    ({$BASE_CURRENCY_SYMBOL})
                                                {/if}
                                            </span>
                                        </div>
                                        <div class="col-lg-3 fieldValue {$WIDTHTYPE}" id="{$MODULE_NAME}_detailView_fieldValue_{$FIELD_MODEL->getName()}" {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '20' or $fieldDataType eq 'reminder' or $fieldDataType eq 'recurrence'} colspan="3" {assign var=COUNTER value=$COUNTER+1} {/if}>

                                            {assign var=FIELD_VALUE value=$FIELD_MODEL->get('fieldvalue')}
                                            {if $fieldDataType eq 'multipicklist'}
                                                {assign var=FIELD_DISPLAY_VALUE value=$FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue'))}
                                            {else}
                                                {assign var=FIELD_DISPLAY_VALUE value=Vtiger_Util_Helper::toSafeHTML($FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue')))}
                                            {/if}

                                            <span class="value textOverflowEllipsis" data-field-type="{$FIELD_MODEL->getFieldDataType()}"  {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '20' or $FIELD_MODEL->get('uitype') eq '21'} style="white-space:normal;" {/if}>
                                                {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getDetailViewTemplateName(),$MODULE_NAME) FIELD_MODEL=$FIELD_MODEL USER_MODEL=$USER_MODEL MODULE=$MODULE_NAME RECORD=$RECORD}
                                            </span>
                                            {if $IS_AJAX_ENABLED && $FIELD_MODEL->isEditable() eq 'true' && $FIELD_MODEL->isAjaxEditable() eq 'true'}
                                                <div class="hide edit pull-left calendar-timezone clearfix">
                                                    {if $fieldDataType eq 'multipicklist'}
                                                        <input type="hidden" class="fieldBasicData" data-name='{$FIELD_MODEL->get('name')}[]' data-type="{$fieldDataType}" data-displayvalue='{$FIELD_DISPLAY_VALUE}' data-value="{$FIELD_VALUE}" />
                                                    {else}
                                                        <input type="hidden" class="fieldBasicData" data-name='{$FIELD_MODEL->get('name')}' data-type="{$fieldDataType}" data-displayvalue='{$FIELD_DISPLAY_VALUE}' data-value="{$FIELD_VALUE}" />
                                                    {/if}
                                                </div>
                                                <!--Removed By Mabruk-->
                                                <!--<span class="action pull-right"><a href="#" onclick="return false;" class="editAction ti-pencil"></a></span>-->
                                                {/if}
                                        </div>
                               

                                    {if $FIELD_MODEL_LIST|@count eq 1 and $FIELD_MODEL->get('uitype') neq "19" and $FIELD_MODEL->get('uitype') neq "20" and $FIELD_MODEL->get('uitype') neq "30" and $FIELD_MODEL->get('name') neq "recurringtype" and $FIELD_MODEL->get('uitype') neq "69" and $FIELD_MODEL->get('uitype') neq "105"}
                                        </div><div class="row"><div class="col-lg-6 fieldLabel {$WIDTHTYPE}"></div><div class="col-lg-6 {$WIDTHTYPE}"></div></div>
                                        {/if}
                                    {/foreach}
                                    {* adding additional column for odd number of fields in a block *}
                                    {if $FIELD_MODEL_LIST|@end eq true and $FIELD_MODEL_LIST|@count neq 1 and $COUNTER eq 1}
                                     </div>
                                        <div class="row">
                                            <div class="col-lg-6 fieldLabel {$WIDTHTYPE}"></div><div class="col-lg-6 {$WIDTHTYPE}"></div></div>
                                    {/if}
                                    <div class="clearfix"></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <br>
        {/foreach}
     
    {/strip}
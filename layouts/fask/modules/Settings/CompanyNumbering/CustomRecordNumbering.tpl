{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
-->*}
{strip}
    <div class="container-fluid" style="position: relative;">
      <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 1px;right:0 ; left:98%" title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
    <div class="clearfix"></div>
    <form id="EditView" method="POST">
        <input type="hidden" name="oldcompany" id="oldcompany" value = "{$DEFAULT_COMPANY}">	

        <div class="row-fluid">
            <span class="widget_header row-fluid">
                <div class="row-fluid"><h3>{vtranslate('LBL_CUSTOMIZE_RECORD_NUMBERING', $QUALIFIED_MODULE)}</h3></div>
            </span>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <table id="customRecordNumbering" class="table table-bordered">
                {assign var=DEFAULT_MODULE_DATA value=$DEFAULT_MODULE_MODEL->getModuleCustomNumberingData()}
                {assign var=DEFAULT_MODULE_NAME value=$DEFAULT_MODULE_MODEL->getName()}
                                {assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
                    <thead>
                        <tr>
                            <th width="30%" class="{$WIDTHTYPE}">
                                <strong>{vtranslate('LBL_CUSTOMIZE_RECORD_NUMBERING', $QUALIFIED_MODULE)}</strong>
                            </th>
                            <th width="70%" class="{$WIDTHTYPE}" style="border-left: none">
                            <span class="pull-right">
                                <button type="button" class="btn" name="updateRecordWithSequenceNumber"><b>{vtranslate('LBL_UPDATE_MISSING_RECORD_SEQUENCE', $QUALIFIED_MODULE)}</b></button>
                            </span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                         <tr>
                <td class="{$WIDTHTYPE}">
                    <label class="pull-right marginRight10px"><b>{vtranslate('LBL_SELECT_COMPANY', $QUALIFIED_MODULE)}</b></label>
                </td>
                                <td class="fieldValue {$WIDTHTYPE}" style="border-left: none">
                                        <select id="company" class="select2" name="company" data-placeholder="{vtranslate('LBL_ADD_COMPANY', $QUALIFIED_MODULE)}" data-validation-engine="validate[required]" data-old-company="{$DEFAULT_COMPANY}" >
                                        {foreach from=$ALL_COMPANY item=COMPANY}
                                        <option value="{$COMPANY.organizationId}" {if $COMPANY.organizationId eq $DEFAULT_COMPANY} selected="selected"{/if}>{$COMPANY.organization_title}</option>
                                        {/foreach}
                                        </select>
                                </td>


                    <tr>
                        <td class="{$WIDTHTYPE}">
                            <label class="pull-right marginRight10px"><b>{vtranslate('LBL_SELECT_MODULE', $QUALIFIED_MODULE)}</b></label>
                        </td>
                        <td class="fieldValue {$WIDTHTYPE}" style="border-left: none">
                            <select class="select2" name="sourceModule" id="sourceModule">
                                {foreach key=index item=MODULE_MODEL from=$SUPPORTED_MODULES}
                                    {assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
                                    <option value={$MODULE_NAME} {if $MODULE_NAME eq $DEFAULT_MODULE_NAME} selected {/if}>
                                        {vtranslate($MODULE_NAME, $MODULE_NAME)}
                                    </option>
                                {/foreach}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="{$WIDTHTYPE}">
                            <label class="pull-right marginRight10px"><b>{vtranslate('LBL_USE_PREFIX', $QUALIFIED_MODULE)}</b><span class="redColor">*</span></label>
                        </td>
                        <td class="fieldValue {$WIDTHTYPE}" style="border-left: none">
                            <input type="text" value="{$DEFAULT_MODULE_DATA['prefix']}" data-old-prefix="{$DEFAULT_MODULE_DATA['prefix']}" name="prefix" data-validation-engine="validate[funcCall[Vtiger_AlphaNumeric_Validator_Js.invokeValidation]]"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="{$WIDTHTYPE}">
                            <label class="pull-right marginRight10px">
                                <b>{vtranslate('LBL_START_SEQUENCE', $QUALIFIED_MODULE)}</b><span class="redColor">*</span>
                            </label>
                        </td>
                        <td class="fieldValue {$WIDTHTYPE}" style="border-left: none">
                            <input type="text" value="{$DEFAULT_MODULE_DATA['sequenceNumber']}"
                                   data-old-sequence-number="{$DEFAULT_MODULE_DATA['sequenceNumber']}" name="sequenceNumber"
                                   data-validation-engine="validate[required,funcCall[Vtiger_WholeNumber_Validator_Js.invokeValidation]]"/>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 pull-right">
                <div class="pull-right">
                    <button class="btn btn-success saveButton" type="button" disabled="disabled"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
                    <a class="cancelLink" type="reset" onclick="javascript:window.history.back();">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
                </div>
            </div>
        </div>
    </form>
    <br><br><br>
    <!-- Added By Mabruk Custom Numbering -->
    <div class="row-fluid">
        <div class="span12">
            <input type="hidden" value="{$COMPANYNUMBERING}" name="hidBusiness" id="hidBusiness">
            <table id="customRecordNumbering" class="table table-bordered">
                            {assign var=WIDTHTYPE value="200"}
             <tbody>
                    <tr>
                    <td style="padding-top:16px">
                        <input type="checkbox" name="business" id="business" {if $COMPANYNUMBERING eq 1} checked {/if}/>
                    </td>
                    <td class="fieldValue {$WIDTHTYPE}" style="border-left: none;padding-top:16px">
                        <!-- add text and Payments for Payments as Inventory module -->     
                        Separate numbering for Business Document (Quotes, Invoces,Sales Order, Purchase Order and Payments)
                       <!-- End here--> 
                    </td>
                    <td style="text-align:center">
                        <button id="saveNumbering" class="btn btn-success" disabled="" style="width:80%"><strong>{vtranslate('LBL_UPDATE', $QUALIFIED_MODULE)}</strong></button>                   
                    </td>    
                </tr>                
            </tbody>
            </table>
        </div>
    </div>
{/strip}

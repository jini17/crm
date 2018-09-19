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
<div class="tab-pane" id="UserEducationContainer">
        <div class="contents row-fluid">
                {assign var=CREATE_EDUCATION_URL value=$EDUCATION_RECORD_MODEL->getCreateEducationUrl()}
                {assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	

                        <!--<a id="menubar_quickCreate_Education" class="quickCreateModule" data-name="Education" data-url="index.php?module=Education&view=QuickCreateAjax" href="javascript:void(0)">Add Education</a>-->
                        <div class="myProfileBtn">
                                <button type="button" class="btn btn-primary pull-right"onclick="Users_Education_Js.addEducation('{$CREATE_EDUCATION_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_EDUCATION', $MODULE)}</strong></button>
                        </div>
                            
                        <div class="clearfix"></div>    
                        <div class="block block_Education">
                            <div>
                                <h5>Education</h5>
                                <hr>
                                <div class="blockData">
                                    <div class="table detailview-table no-border">
                                         {foreach item=USER_EDUCATION from=$USER_EDUCATION_LIST}
                                            <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_INSTITUTION_NAME" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_INSTITUTION_NAME', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_INSTITUTION_NAME" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EDUCATION['institution_name']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_DURATION">
                                                    <span class="muted">{vtranslate('LBL_DURATION', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DURATION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EDUCATION['start_date']} {vtranslate('LBL_TO', $MODULE)} {if $USER_EDUCATION['is_studying'] eq 1}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_EDUCATION['end_date']}{/if}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_EDUCATION_LEVEL" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_EDUCATION_LEVEL', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_Institution_Name" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EDUCATION['education_level']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_duration">
                                                    <span class="muted">{vtranslate('LBL_AREA_OF_STUDY', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_duration" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EDUCATION['area_of_study']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_DESCRIPTION', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EDUCATION['description']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_duration">
                                                    <span class="muted">{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_duration" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{(0==$USER_EDUCATION['public'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span>
                                                </div>
                                                {/foreach}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
</div>
{/strip}

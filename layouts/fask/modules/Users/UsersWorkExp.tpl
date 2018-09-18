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
<div id="UserWorkExpContainer">
	<div class="contents row-fluid">
		{assign var=CREATE_WORKEXP_URL value=$WORKEXP_RECORD_MODEL->getCreateUserWorkExpUrl()}
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	

		<div class="myProfileBtn">
			<button type="button" class="btn btn-primary pull-right" onclick="Users_WorkExp_Js.addWorkExp('{$CREATE_WORKEXP_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_WORKEXP', $MODULE)}</strong></button>
		</div>

        <div class="clearfix"></div>

        <div class="block block_WorkExperience">
            <div>
                <h5>Work Experience</h5>
                    <hr>
                        <div class="blockData">
                            <div class="table detailview-table no-border">
                                 {foreach item=USER_WORKEXP from=$USER_WORKEXP_LIST}
                                <div class="row">
                                    <div id="Users_detailView_fieldLabel_LBL_COMPANY_NAME" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                    	<span class="muted">{vtranslate('LBL_COMPANY_NAME', $MODULE)}</span>
                                	</div>
                                	<div id="Users_detailView_fieldLabel_LBL_COMPANY_NAME" class="fieldValue  col-xs-6 col-md-3 medium">
                                        <span class="value textOverflowEllipsis" data-field-type="string">{$USER_WORKEXP['company_title']}</span>
                                    </div>
                                    <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_DESIGNATION">
                                    	<span class="muted">{vtranslate('LBL_DESIGNATION', $MODULE)}</span>
                                    </div>
                                    <div id="Users_detailView_fieldLabel_LBL_DESIGNATION" class="fieldValue  col-xs-6 col-md-3 medium">
                                        <span class="value textOverflowEllipsis" data-field-type="string">{$USER_WORKEXP['designation']}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="Users_detailView_fieldLabel_LBL_LOCATION" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                        <span class="muted">{vtranslate('LBL_LOCATION', $MODULE)}</span>
                                    </div>
                                    <div id="Users_detailView_fieldLabel_LBL_LOCATION" class="fieldValue  col-xs-6 col-md-3 medium">
                                        <span class="value textOverflowEllipsis" data-field-type="string">{$USER_WORKEXP['location']}}</span>
                                    </div>
                                    <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_TIMEPERIOD">
                                        <span class="muted">{vtranslate('LBL_TIMEPERIOD', $MODULE)}</span>
                                    </div>
                                    <div id="Users_detailView_fieldLabel_LBL_TIMEPERIOD" class="fieldValue  col-xs-6 col-md-3 medium">
                                    	<span class="value textOverflowEllipsis" data-field-type="string">{$USER_WORKEXP['start_date']} {vtranslate('LBL_TO', $MODULE)} {if $USER_WORKEXP['end_date'] eq ''}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_WORKEXP['end_date']}{/if}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                        <span class="muted">{vtranslate('LBL_DESCRIPTION', $MODULE)}</span>
                                    </div>
                                    <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldValue  col-xs-6 col-md-3 medium">
                                        <span class="value textOverflowEllipsis" data-field-type="string">{$USER_WORKEXP['description']}</span>
                                    </div>
                                    <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_duration">
                                        <span class="muted">{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</span>
                                    </div>
                                    <div id="Users_detailView_fieldLabel_duration" class="fieldValue  col-xs-6 col-md-3 medium">
                                        <span class="value textOverflowEllipsis" data-field-type="string">{('0'==$USER_WORKEXP['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span>
                                    </div>
                                </div>
                                {/foreach}
                            </div>
                        </div>
            </div>
		</div>	
	</div>
</div>
{/strip}

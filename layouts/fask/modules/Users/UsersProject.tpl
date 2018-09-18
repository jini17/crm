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
    <style>
        .listTableRow.small{
          border: 1px solid #ddd !important;
        }
    </style>
<div id="UserProjectContainer">
	<div class="contents row-fluid">
		{assign var=CREATE_PROJECT_URL value=$PROJECT_RECORD_MODEL->getCreateProjectUrl()}
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	

		<div class="myProfileBtn">
			<button type="button" class="btn btn-primary pull-right" onclick="Users_Project_Js.addProject('{$CREATE_PROJECT_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_PROJECT', $MODULE)}</strong></button>
		</div>
        <div class="clearfix" ></div>

        <div class="block block_LBL_USER_PROJECTS">
                            <div>
                                <h5>User Projects</h5>
                                <hr>
                                <div class="blockData">
                                    <div class="table detailview-table no-border">
                                         {foreach item=USER_PROJECT from=$USER_PROJECT_LIST}
                                            <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_PROJECT_TITLE" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_PROJECT_TITLE', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_PROJECT_TITLE" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_PROJECT['title']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_DESCRIPTION">
                                                    <span class="muted">{vtranslate('LBL_DESCRIPTION', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_PROJECT['description']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_OCCUPATION" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_OCCUPATION', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_OCCUPATION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{if $USER_PROJECT['relation_type'] eq 'E'}Student at {/if}{$USER_PROJECT['designation']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_DATE">
                                                    <span class="muted">{vtranslate('LBL_DATE', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DATE" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_PROJECT['project_start_date']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_PROJECT_URL" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_PROJECT_URL', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DESCRIPTION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_PROJECT['project_url']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_EDUCATION_ISVIEW">
                                                    <span class="muted">{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_duration" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{('0'==$USER_PROJECT['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span>
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
</div>
{/strip}

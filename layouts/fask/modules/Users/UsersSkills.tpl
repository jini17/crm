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

<!--Start of Language Container-->
<div id="skill">
<div id="LanguageContainer">

{strip} 
{assign var=CREATE_LANGUAGE_URL value=$LANGUAGE_RECORD_MODEL->getCreateLanguageUrl()}
{assign var=CREATE_SKILL_URL value=$LANGUAGE_RECORD_MODEL->getCreateSkillUrl()}
{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
		<div class="myProfileBtn">
			<button type="button" class="btn btn-primary pull-right" onclick="Users_Skills_Js.addLanguage('{$CREATE_LANGUAGE_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_LANGUAGE', $MODULE)}</strong></button>
		</div>
        <div class="clearfix"></div>

        <div class="block block_LBL_SKILL_LANG">
                            <div>
                                <h5>{vtranslate('LBL_SKILL_LANG', $MODULE)}</h5>
                                <hr>
                                <div class="blockData">
                                    <div class="table detailview-table no-border">
                                         {foreach item=USER_LANGUAGE from=$USER_SOFTSKILL_LIST}
                                            <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_LANGUAGE" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_LANGUAGE', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_LANGUAGE" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_LANGUAGE['language']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_DURATION">
                                                    <span class="muted">{vtranslate('LBL_PROFICIENCY', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_DURATION" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_LANGUAGE['proficiency']}</span>
                                                </div>
                                        	</div>
                                        {/foreach}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>	
</div>
<!--End of Language Container-->
<!--- Start of Skill Container-->
<div id="SkillContainer">

	<button type="button" class="btn btn-primary pull-right" onclick="Users_Skills_Js.addSkill('{$CREATE_SKILL_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_SKILL', $MODULE)}</strong></button>

        <div class="clearfix"></div>
        <div class="row-fluid paddingTop20" style="width: 100%; margin-top: 10px;">
		<div class="select2-container select2-container-multi select2 span12" id="allskillslist"  style="width: 100%;">
			<ul class="select2-choices ui-sortable">
				{foreach item=SKILL from=$USER_SKILL_CLOUD}
				<li class="select2-search-choice" style="cursor:default;" data-id="54" data-item-name="SQL">
					<div class="pull-left" style="padding-right:25px;">{$SKILL['skill_title']}</div>
					<a class="deleteSkill select2-search-choice-close" onclick="Users_Skills_Js.deleteSkill('{$SKILL['skill_id']}')" title="Delete"></a>
					<div class="pull-right skillnum">{$SKILL['endorsement']}</div>
				</li>	
				{/foreach}
			</ul>
		</div>
	</div>
</div>
</div>
{/strip}

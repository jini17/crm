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
<script src="layouts/vlayout/modules/Users/resources/Skills.js?v=6.1.0" type="text/javascript"></script>
{strip} 
{assign var=CREATE_LANGUAGE_URL value=$LANGUAGE_RECORD_MODEL->getCreateLanguageUrl()}
{assign var=CREATE_SKILL_URL value=$LANGUAGE_RECORD_MODEL->getCreateSkillUrl()}
{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
<!--Start of Language Container-->
<div id="LanguageContainer">
	<button type="button" class="addLanguage btn addButton" data-url="{$CREATE_LANGUAGE_URL}&userId={$USERID}"><i class="icon-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_LANGUAGE', $MODULE)}</strong></button>
	<br /><br />
	<table class="table table-bordered listViewEntriesTable">
		<thead>
			<tr>
				<th nowrap><strong>{vtranslate('LBL_LANGUAGE', $MODULE)}</strong></th>
				<th nowrap colspan="2"><strong>{vtranslate('LBL_PROFICIENCY', $MODULE)}</strong></th>
				<!--<th nowrap><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>-->
			</tr>
		</thead>
		<tbody>
			{foreach item=USER_LANGUAGE from=$USER_SOFTSKILL_LIST}
				<tr>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LANGUAGE['language']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LANGUAGE['proficiency']}</label></td>
					<!--<td class="listTableRow small" valign=top><span class="isviewlabel">{('0'==$USER_LANGUAGE['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span></td>-->
					<td class="listTableRow small" valign=top>
						<div class="pull-right actions">
							<span class="actionImages">
								<a class="editLanguage cursorPointer" data-url="{$CREATE_LANGUAGE_URL}&record={$USER_LANGUAGE['ss_id']}&userId={$USERID}&selected_id={$USER_LANGUAGE['language_id']}"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;<a class="deleteLanguage cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLanguage&record={$USER_LANGUAGE['ss_id']}"><i class="icon-trash alignMiddle" title="Delete"></i></a>
							</span>
						</div>
					</td>
				</tr>
			{/foreach}
		</tbody>			
	</table>	
</div>
<!--End of Language Container-->
<!--- Start of Skill Container-->
<div id="SkillContainer">
	<button type="button" class="addSkill btn addButton" data-url="{$CREATE_SKILL_URL}&userId={$USERID}"><i class="icon-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_SKILL', $MODULE)}</strong></button>
	<br />
	<div class="row-fluid paddingTop20">
		<div class="select2-container select2-container-multi select2 span12" id="allskillslist">
			<ul class="select2-choices ui-sortable">
				{foreach item=SKILL from=$USER_SKILL_CLOUD}
				<li class="select2-search-choice" style="cursor:default;" data-id="54" data-item-name="SQL">
					<div class="pull-left" style="padding-right:25px;">{$SKILL['skill_title']}</div>
					<a class="deleteSkill select2-search-choice-close" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteSkill&record={$SKILL['skill_id']}" title="Delete"></a>
					<div class="pull-right skillnum">{$SKILL['endorsement']}</div>
				</li>	
				{/foreach}
			</ul>
		</div>
	</div>
</div>
{/strip}

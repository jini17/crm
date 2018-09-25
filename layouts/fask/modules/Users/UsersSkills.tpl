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
<div id="skill">
<div id="LanguageContainer">
{assign var=CREATE_LANGUAGE_URL value=$LANGUAGE_RECORD_MODEL->getCreateLanguageUrl()}
{assign var=CREATE_SKILL_URL value=$LANGUAGE_RECORD_MODEL->getCreateSkillUrl()}
{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
        <div class="myProfileBtn">
            <button type="button" class="btn btn-primary pull-right" onclick="Users_Skills_Js.addLanguage('{$CREATE_LANGUAGE_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_LANGUAGE', $MODULE)}</strong></button>
        </div>
        <div class="clearfix"></div>

                    <div class="block listViewContentDiv" id="listViewContents" style="marign-top: 15px;">
                        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
                            <div class="bottomscroll-div"><div>
                                <h5>{vtranslate('LBL_SKILL_LANG', $MODULE)}</h5>
                            </div>
                            <hr>
                            <table class="table detailview-table">
                                <thead>
                                    <tr>
                                        <th nowrap="">
                                            <strong>{vtranslate('LBL_LANGUAGE', $MODULE)}</strong>
                                        </th>
                                        <th colspan="2" class="medium" nowrap=""><strong>{vtranslate('LBL_PROFICIENCY', $MODULE)}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=USER_LANGUAGE from=$USER_SOFTSKILL_LIST}
                                    <tr>
                                        <td class="listTableRow small" valign="top">{$USER_LANGUAGE['language']}</td>
                                        <td class="listTableRow small" valign="top">{$USER_LANGUAGE['proficiency']}</td>
                                        <td class="listTableRow small" width="5%" valign="top">
                                            <div class="pull-right actions">
                                                <span class="actionImages">
                                                    <a class="editLanguage cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Skills_Js.editLanguage('{$CREATE_LANGUAGE_URL}&record={$USER_LANGUAGE['ss_id']}&userId={$USERID}&selected_id={$USER_LANGUAGE['language_id']}');"></a>&nbsp;&nbsp;
                                                    <a class="deleteLanguage cursorPointer" onclick="Users_Skills_Js.deleteLanguage('{$USER_LANGUAGE['ss_id']}');">
                                                        <i class="fa fa-trash-o" title="Delete"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </td>    
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>    
            </div>
</div>
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




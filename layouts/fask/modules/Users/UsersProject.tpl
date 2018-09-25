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
<div id="UserProjectContainer">
    <div class="contents row-fluid">
        {assign var=CREATE_PROJECT_URL value=$PROJECT_RECORD_MODEL->getCreateProjectUrl()}
        {assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}  

        <div class="myProfileBtn">
            <button type="button" class="btn btn-primary pull-right" onclick="Users_Project_Js.addProject('{$CREATE_PROJECT_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_PROJECT', $MODULE)}</strong></button>
        </div>
        <div class="clearfix" ></div>

                    <div class="block listViewContentDiv" id="listViewContents" style="marign-top: 15px;">
                        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
                            <div class="bottomscroll-div"><div>
                                <h5>{vtranslate('User Projects', $MODULE)}</h5>
                            </div>
                            <hr>
                            <table class="table detailview-table">
                                <thead>
                                    <tr>
                                        <th nowrap="">
                                            <strong>{vtranslate('LBL_PROJECT_TITLE', $MODULE)}</strong>
                                        </th>
                                        <th nowrap=""><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>
                                        <th nowrap=""><strong>{vtranslate('LBL_OCCUPATION', $MODULE)}</strong></th>
                                        <th nowrap=""><strong>{vtranslate('LBL_DATE', $MODULE)}</strong></th>
                                        <th nowrap=""><strong>{vtranslate('LBL_PROJECT_URL', $MODULE)}</strong></th>
                                        <th colspan="2" class="medium" nowrap=""><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=USER_PROJECT from=$USER_PROJECT_LIST}
                                    <tr>
                                        <td class="listTableRow small" valign="top">{$USER_PROJECT['title']}</td>
                                        <td class="listTableRow small" valign="top">{$USER_PROJECT['description']}</td>
                                        <td class="listTableRow small" valign="top">{if $USER_PROJECT['relation_type'] eq 'E'}Student at {/if}{$USER_PROJECT['designation']}</td>
                                        <td class="listTableRow small" valign="top">{$USER_PROJECT['project_start_date']}</td>
                                        <td class="listTableRow small" valign="top">{$USER_PROJECT['project_url']}</td>
                                        <td class="listTableRow small" valign="top">{('0'==$USER_PROJECT['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</td>
                                        <td class="listTableRow small" width="5%" valign="top">
                                            <div class="pull-right actions">
                                                <span class="actionImages">
                                                <a class="editProject editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Project_Js.editProject('index.php{$CREATE_PROJECT_URL}&record={$USER_PROJECT['employeeprojectsid']}&userId={$USERID}');"></a>
                                                &nbsp;&nbsp;
                                                <a class="cursorPointer" onclick="Users_Project_Js.deleteProject('index.php?module=EmployeeProjects&action=Delete&record={$USER_PROJECT['employeeprojectsid']}');">
                                                <i title="{vtranslate('LBL_DELETE', $MODULE)}" class="fa fa-trash-o"></i></a>
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
{/strip}



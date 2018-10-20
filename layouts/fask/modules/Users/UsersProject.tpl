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

        <div class="btn-group pull-right allprofilebtn">
            <button type="button" class="btn btn-primary" onclick="Users_Project_Js.addProject('{$CREATE_PROJECT_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_PROJECT', $MODULE)}</strong></button>
        </div>
        <div class="clearfix" ></div>

                    <div class="block listViewContentDiv" id="listViewContents" >
                        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
                            <div class="bottomscroll-div"><div>
                                <h5>{vtranslate('User Projects', $MODULE)}</h5>
                            </div>
                            <hr>
                            <table class="table detailview-table">
                                <thead>
                                    <tr>
                                        <th nowrap="" style="width:10%;">
                                            <strong>{vtranslate('LBL_PROJECT_TITLE', $MODULE)}</strong>
                                        </th>                                        
                                        <th nowrap="" style="width:10%;"><strong>{vtranslate('LBL_OCCUPATION', $MODULE)}</strong></th>
                                        <th nowrap="" style="width:10%;"><strong>{vtranslate('LBL_DATE', $MODULE)}</strong></th>
                                                          
                                        <th  class=""  nowrap="" style="width:10%;"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
                      
                                        <th nowrap="" style="width:40%;"><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>   
                                        <th nowrap=""style="width:10%;"><strong>{vtranslate('LBL_PROJECT_URL', $MODULE)}</strong></th>             
                                        <th> &nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=USER_PROJECT from=$USER_PROJECT_LIST}
                                         {if $USER_PROJEC['public'] eq '0'}
                                               {assign var=PERMISSION value=LBL_PUBLIC}  
                                        {elseif $USER_PROJECT['public'] eq '1'}
                                                {assign var=PERMISSION value=LBL_PRIVATE}  
                                        {else}
                                                {assign var=PERMISSION value='LBL_PROTECTED'}  
                                        {/if}    
                                    <tr>
                                        <td class="" valign="top" style="width:10%;">{$USER_PROJECT['title']}</td>                                     
                                        <td class="" valign="top" style="width:10%;">{if $USER_PROJECT['relation_type'] eq 'E'}Student at {/if}{$USER_PROJECT['designation']}</td>
                                        <td class="" valign="top" style="width:10%;">{$USER_PROJECT['project_start_date']}</td>
                                        <td class="" valign="top" style="width:10%;">{vtranslate($PERMISSION,$MODULE)}</td>
                                       
                                         <td class="" valign="top" style="width:40%;">{$USER_PROJECT['description']}</td>
                                          <td class="" valign="top" style="width:10%;"><a href="{$USER_PROJECT['project_url']}" class="btn btn-success">click to visit</a></td>
                                        <td class=""  valign="top">
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



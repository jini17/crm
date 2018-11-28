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
<div class="tab-pane" id="UserWorkExpContainer">
        <div class="contents row-fluid">
                {assign var=CREATE_WORKEXP_URL value=$WORKEXP_RECORD_MODEL->getCreateUserWorkExpUrl()}
                {assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}  

                        <!--<a id="menubar_quickCreate_Education" class="quickCreateModule" data-name="Education" data-url="index.php?module=Education&view=QuickCreateAjax" href="javascript:void(0)">Add Education</a>-->
                        
                        <div class="btn-group pull-right allprofilebtn">
                            {if $USER_MODEL->get('id') eq $USERID}
                            <button type="button" class="btn btn-primary" onclick="Users_WorkExp_Js.addWorkExp('{$CREATE_WORKEXP_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_WORKEXP', $MODULE)}</strong></button>
                            {/if}
                        </div>
                        
                    <div class="clearfix"></div>
                    <div class="block listViewContentDiv" id="listViewContents">
                        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
                            <div class="bottomscroll-div"><div>
                                <h5>{vtranslate('Work Experience', $MODULE)}</h5>
                            </div>
                            <hr>
                            <table class="table detailview-table">
                                <thead>
                                    <tr>
                                        <th nowrap="">
                                            <strong>{vtranslate('LBL_COMPANY_NAME', $MODULE)}</strong>
                                        </th>
                                        <th><strong>{vtranslate('LBL_DESIGNATION', $MODULE)}</strong></th>
                                        <th><strong>{vtranslate('LBL_LOCATION', $MODULE)}</strong></th>
                                        <th style="width: 15%"><strong>{vtranslate('LBL_TIMEPERIOD', $MODULE)}</strong></th>
                                        <th><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>
                                        <th><strong>{vtranslate('LBL_JOB_TYPE', $MODULE)}</strong></th>
                                        <th colspan="2" class="medium" ><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=USER_WORKEXP from=$USER_WORKEXP_LIST}
                                            {if $USER_WORKEXP['isview'] eq '0'}
                                                  {assign var=PERMISSION value=LBL_PUBLIC}  
                                            {elseif $USER_WORKEXP['isview'] eq '1'}
                                                {assign var=PERMISSION value=LBL_PRIVATE}  
                                            {else}
                                                {assign var=PERMISSION value='LBL_PROTECTED'}  
                                             {/if}    
                                               {if $USER_WORKEXP['job_type'] eq '0'}
                                                  {assign var=JOB_TYPE value=LBL_PART_TIME}  
                                              {else}
                                                      {assign var=JOB_TYPE  value=LBL_FULL_TIME}  
                                               {/if}       
                                             
                                    <tr>
                                        <td class="medium" valign="top">{$USER_WORKEXP['company_title']}</td>
                                        <td class="medium" valign="top">{$USER_WORKEXP['designation']}</td>
                                        <td class="medium" valign="top">{$USER_WORKEXP['location']}</td>
                           
                                        <td class="medium" valign="top">{$USER_WORKEXP['start_date']}  {if $USER_WORKEXP['end_date'] eq ''} - {vtranslate('LBL_TILL_NOW', $MODULE)}{else}-{$USER_WORKEXP['end_date']}{/if}</td>
                                        <td class="medium" valign="top">{$USER_WORKEXP['description']}</td>
                                         <td class="medium" valign="top">{vtranslate($JOB_TYPE,$MODULE)}</td>
                                        <td class="medium" valign="top">{vtranslate($PERMISSION,$MODULE)}</td>
                                        {if $USER_MODEL->get('id') eq $USERID}
                                        <td class="medium" width="5%" valign="top">
                                            <div class="pull-right actions">
                                                <span class="actionImages">
                                                <a class="editWorkExp editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_WorkExp_Js.editWorkExp('index.php{$CREATE_WORKEXP_URL}&record={$USER_WORKEXP['uw_id']}&userId={$USERID}');"></a>&nbsp;&nbsp;<a class="cursorPointer" onclick="Users_WorkExp_Js.deleteWorkExp('index.php?module=Users&action=DeleteSubModuleAjax&mode=deleteWorkExp&record={$USER_WORKEXP['uw_id']}');"><i class="fa fa-trash-o" title="Delete"></i></a>
                                            </span>
                                            </div>
                                        </td> 
                                       {/if}    
                                    </tr>
                                    {/foreach}
                                </tbody>
                            </table>
                        </div>
                    </div>    
                </div>    
            </div>
</div>



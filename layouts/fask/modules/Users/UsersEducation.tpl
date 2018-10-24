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
        <div class="btn-group pull-right allprofilebtn">
            <button type="button" class="btn btn-primary"onclick="Users_Education_Js.addEducation('{$CREATE_EDUCATION_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_EDUCATION', $MODULE)}</strong></button>
        </div>

        <div class="clearfix"></div>
        <div class="block listViewContentDiv" id="listViewContents" >

            <div>
                <h5>{vtranslate('Education', $MODULE)}</h5>
            </div>
            <hr>
            <table class="table detailview-table">
                <thead>
                    <tr>
                        <th class="medium"><strong>{vtranslate('LBL_INSTITUTION_NAME', $MODULE)}</strong></th>
                        <th class="medium"><strong>{vtranslate('LBL_LOCATION', $MODULE)}</strong></th>
                        <th class="medium"><strong>{vtranslate('LBL_EDUCATION_TYPE', $MODULE)}</strong></th>
                        <th style='width:15%' class="medium"><strong>{vtranslate('LBL_DURATION', $MODULE)}</strong></th>
                        <th class="medium"><strong>{vtranslate('LBL_EDUCATION_LEVEL', $MODULE)}</strong></th>
                        <th class="medium"><strong>{vtranslate('LBL_AREA_OF_STUDY', $MODULE)}</strong></th>
                        <th class="medium"><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>
                        <th colspan="2" class="medium"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
                    </tr>
                </thead>
                <tbody>
                    {foreach item=USER_EDUCATION from=$USER_EDUCATION_LIST}
                        {if $USER_EDUCATION['public'] eq '0'}
                                {assign var=PERMISSION value=LBL_PUBLIC}  
                        {elseif $USER_EDUCATION['public'] eq '1'}
                                {assign var=PERMISSION value=LBL_PRIVATE}  
                        {else}
                            {assign var=PERMISSION value='LBL_PROTECTED'}  
                        {/if}    
                    <tr>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['institution_name']}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_location']}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_type']}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['start_date']} - {if $USER_EDUCATION['is_studying'] eq 1}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_EDUCATION['end_date']}{/if}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['education_level']}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['area_of_study']}</td>
                        <td class="listTableRow medium" valign="top">{$USER_EDUCATION['description']}</td>
                        <td class="listTableRow medium" valign="top">{vtranslate($PERMISSION,$MODULE)}</td>
                        <td class="listTableRow medium" width="5%" valign="top">
                            <div class="pull-right actions">
                                <span class="actionImages">
                                    <a class="editEducation editAction ti-pencil" title="Edit" onclick="Users_Education_Js.editEducation('index.php?module=Users&amp;view=EditEducation&amp;record={$USER_EDUCATION['educationid']}&amp;userId={$USERID}');"></a>
                                    &nbsp;&nbsp;
                                    <a class="cursorPointer" onclick="Users_Education_Js.deleteEducation('index.php?module=Education&amp;action=Delete&amp;record={$USER_EDUCATION['educationid']}');"><i class="fa fa-trash-o" title="Delete"></i></a>
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


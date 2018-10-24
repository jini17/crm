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
    .tooltip{ 
  position:relative;
  float:right;
  top: -13px;
}
.tooltip > .tooltip-inner {
    padding:5px 5px;
    font-weight:bold; font-size:13px;
     position: absolute;

}

.popOver + .tooltip > .tooltip-arrow {	
    border-left: 5px solid transparent; 
    border-right: 5px solid transparent;
    border-top: 5px solid #eebf3f;
}
.tooltip.top{
margin: 15px;
}
.tooltip-arrow{
display: none;
}


.progress{
  border-radius:0;
  overflow:visible;
  margin: 0;

  border: none;
  position: relative;
  height: 20px;
margin-bottom: 20px;
overflow: hidden;
background-color: #f5f5f5;
border-radius: 4px;
-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
}
.progress-bar{
  -webkit-transition: width 1.5s ease-in-out;
  transition: width 1.5s ease-in-out;
}
    </style>
<div id="skill">
<div id="LanguageContainer">
{assign var=CREATE_LANGUAGE_URL value=$LANGUAGE_RECORD_MODEL->getCreateLanguageUrl()}
{assign var=CREATE_SKILL_URL value=$LANGUAGE_RECORD_MODEL->getCreateSkillUrl()}
{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
        <div class="btn-group pull-right allprofilebtn">
            <button type="button" class="btn btn-primary" onclick="Users_Skills_Js.addLanguage('{$CREATE_LANGUAGE_URL}&userId={$USERID}');">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;
                <strong>{vtranslate('LBL_ADD_LANGUAGE', $MODULE)}</strong>
            </button>
        </div>
        <div class="clearfix"></div>
                    <div class="block listViewContentDiv" id="listViewContents" >
                        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
                            <div class="bottomscroll-div"><div>
                                <h5>{vtranslate('LBL_SKILL_LANG', $MODULE)}</h5>
                            </div>
                            <hr>
                            <table class="table detailview-table">
                                <thead>
                                    <tr>
                                        <th nowrap="">
                                          {*  <strong>{vtranslate('LBL_LANGUAGE', $MODULE)}</strong>*}
                                        </th>
                                        <th colspan="2" class="medium" nowrap=""><strong>{vtranslate('LBL_PROFICIENCY', $MODULE)}</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {foreach item=USER_LANGUAGE from=$USER_SOFTSKILL_LIST}
                                        {if $USER_LANGUAGE['proficiency'] eq 'Elementary'}
                                           {assign var=ACCURACY value="25"}
                                        {elseif $USER_LANGUAGE['proficiency'] eq 'Limited Working'}    
                                              {assign var=ACCURACY value="50"}
                                        {elseif $USER_LANGUAGE['proficiency'] eq 'Professional Working'}    
                                              {assign var=ACCURACY value="75"}
                                        {elseif $USER_LANGUAGE['proficiency'] eq 'Full Professional'}    
                                              {assign var=ACCURACY value="85"}
                                         {elseif $USER_LANGUAGE['proficiency'] eq 'Native or Bilingual'}
                                               {assign var=ACCURACY value="100"}
                                        {/if}    
                                    <tr>
                                        <td class="medium" valign="top">{$USER_LANGUAGE['language']}</td>
                                        <td class="medium" valign="top">                                  
                                                <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                                                aria-valuenow="{$ACCURACY}" aria-valuemin="0" aria-valuemax="100" style="width:{$ACCURACY}%">
                                                         {$USER_LANGUAGE['proficiency']}
                                                </div>
                                              </div>
                                        </td>
                                        <td class="medium" width="5%" valign="top">
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
<div id="SkillContainer" >
    <div class="btn-group pull-right allprofilebtn">

        <button type="button" class="btn btn-primary pull-right" onclick="Users_Skills_Js.addSkill('{$CREATE_SKILL_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_SKILL', $MODULE)}</strong></button>
    </div>
    <div class="clearfix"></div>
    <div class="block listViewContentDiv" id="listViewContents" >
        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
            <div class="bottomscroll-div">
                <div>
                    <table class="table detailview-table">
                        <tr>
                        <th> {vtranslate('LBL_SKILL',$MODULE)} </th>
                        <th> </th> 
                        <th></th>
                        </tr>
                                {foreach item=SKILL from=$USER_SKILL_CLOUD}
                                    {assign var=LABEL value =$SKILL['skill_label']}
                                    {if $LABEL eq 'LBL_BEGINNER_LABEL'}
                                         {assign var=ACCURACY value= "40"}
                                    {elseif $LABEL eq 'LBL_INTERMEDIATE_LABEL'}
                                         {assign var=ACCURACY value= "70"}
                                    {elseif $LABEL eq 'LBL_EXPERT_LABEL'}
                                         {assign var=ACCURACY value= "70"}     
                                    {else}
                                          {assign var=ACCURACY value= "0"}
                                    {/if}
                                    <tr>
                                        <td>
                                        {$SKILL['skill_title']}
                                        </td>
                                        <td> 
                                          
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar"
                                                aria-valuenow="{$ACCURACY}" aria-valuemin="0" aria-valuemax="100" style="width:{$ACCURACY}%">
                                                                     {vtranslate($LABEL,$MODULE)}
                                                </div>
                                              </div>
                                        </td>
                                        <td>
                                            <a class="deleteSkills" onclick="Users_Skills_Js.deleteSkill('{$SKILL['skill_id']}')" title="Delete">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            {*<div class="pull-right skillnum">{$SKILL['endorsement']}</div>*}
                                        </td>
                                    </tr>
                                    
                                {/foreach}
                           </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>
</div>
<script>
$(function() {
  $('[data-toggle="tooltip"]').tooltip({
    trigger: 'manual'
  }).tooltip('show');
});
</script>

{/strip}




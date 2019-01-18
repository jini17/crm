{*<!--
/*+***********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************/
-->*}

{strip}
<div class="col-sm-12 col-xs-12 module-action-bar clearfix coloredBorderTop">
        <div class="module-action-content clearfix">
                <div class="col-lg-7 col-md-7 breadcrumbcrumb">
                        {if $USER_MODEL->isAdminUser()}
                        <a title="{vtranslate('Home', $MODULE)}" href='index.php?module=Vtiger&parent=Settings&view=Index'>
                                <h4 class="module-title pull-left text-uppercase">{vtranslate('LBL_HOME', $MODULE)} </h4>
                        </a>
                        &nbsp;<span class="ti-angle-right pull-left {if $VIEW eq 'Index' && $MODULE eq 'Vtiger'} hide {/if}" aria-hidden="true" style="padding-top: 12px;padding-left: 5px; font-size: 12px;"></span>
                        {/if}
                        {if $MODULE neq 'Vtiger' or $smarty.request.view neq 'Index'}
                        {if $ACTIVE_BLOCK['block']}
                        <span class="current-filter-name filter-name pull-left">
                                {vtranslate($ACTIVE_BLOCK['block'], $QUALIFIED_MODULE)}&nbsp;
                                <span class="ti-angle-right" aria-hidden="true"></span>&nbsp;
                        </span>
                        {/if}
                        {if $MODULE neq 'Vtiger'}
                        {assign var=ALLOWED_MODULES value=","|explode:'Users,Profiles,Groups,Roles,Webforms,Workflows'}
                        {if $MODULE_MODEL and $MODULE|in_array:$ALLOWED_MODULES}
                        {if $MODULE eq 'Webforms'}
                        {assign var=URL value=$MODULE_MODEL->getListViewUrl()}
                        {else}
                        {assign var=URL value=$MODULE_MODEL->getDefaultUrl()}
                        {/if}
                        {if $URL|strpos:'parent' eq ''}
                        {assign var=URL value=$URL|cat:'&parent='|cat:$smarty.request.parent} 
                        {/if}
                        {/if}
                        
                      
                                {if $smarty.request.view eq 'Calendar'}
                                {if $smarty.request.mode eq 'Edit'}
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                <a href="{"index.php?module="|cat:$smarty.request.module|cat:'&parent='|cat:$smarty.request.parent|cat:'&view='|cat:$smarty.request.view}">
                                        {vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}
                                </a>&nbsp;
                                <i class="ti-angle-right" aria-hidden="true"></i>&nbsp;
                                      </span>
                                  <span class="current-filter-name settingModuleName filter-name pull-left">
                                      <a>
                                             {vtranslate('LBL_EDITING', $MODULE)} :&nbsp;{vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}&nbsp;{vtranslate('LBL_OF',$QUALIFIED_MODULE)}&nbsp;{$USER_MODEL->getName()}
                                      </a>
                                  </span>
                                  {else}
                                        <span class="current-filter-name settingModuleName filter-name pull-left">
                                            <a>  {vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}&nbsp;<span class="ti-angle-right" aria-hidden="true"></span>&nbsp;{$USER_MODEL->getName()}</a>
                                        </span>
                                {/if}
                                {else if $smarty.request.view neq 'List' and $smarty.request.module eq 'Users'}
                                {if $smarty.request.view eq 'PreferenceEdit'}
                                    <span class="current-filter-name settingModuleName filter-name pull-left">
                                <a href="{"index.php?module="|cat:$smarty.request.module|cat:'&parent='|cat:$smarty.request.parent|cat:'&view=PreferenceDetail&record='|cat:$smarty.request.record}">
                                        {vtranslate($ACTIVE_BLOCK['block'], $QUALIFIED_MODULE)}&nbsp;
                                </a>
                                <i class="ti-angle-right" aria-hidden="true"></i>&nbsp;
                                    </span>
                                <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a>{vtranslate('LBL_EDITING', $MODULE)} :&nbsp;{$USER_MODEL->getName()}</a>
                                </span>
                                {else if $smarty.request.view eq 'Edit' or $smarty.request.view eq 'Detail'}
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                <a href="{$URL}">
                                        {if $smarty.request.extensionModule}{$smarty.request.extensionModule}{else}{vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}{/if}&nbsp;
                                </a>
                                <i class="ti-angle-right " aria-hidden="true"></i>&nbsp;
                                </span>
                                {if $smarty.request.view eq 'Edit'}
                                {if $RECORD}
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a>   {vtranslate('LBL_EDITING', $MODULE)} :&nbsp;{$RECORD->getName()}     <i class="ti-angle-right" aria-hidden="true"></i>&nbsp;</a>
                                      </span>
                                {else}
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a>{vtranslate('LBL_ADDING_NEW', $MODULE)} </a>
                             
                                      </span>
                                {/if}
                                {else}
                                    <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a>{$RECORD->getName()}</a>
                               
                                    </span>
                                {/if}
                                {else}
                                          <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a>{$USER_MODEL->getName()}</a>   
                                          </span>
                                {/if}
                                {else if $URL and $URL|strpos:$smarty.request.view eq ''}
                                          <span class="current-filter-name settingModuleName filter-name pull-left">
                                <a href="{$URL}">
                                        {if $smarty.request.extensionModule}
                                        {$smarty.request.extensionModule}
                                        {else}
                                        {vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}
                                        {/if}
                                </a>&nbsp;
                             
                                          </span>
                                {if $RECORD}
                                {if $smarty.request.view eq 'Edit'}
                                          <span class="current-filter-name settingModuleName filter-name pull-left">
                                    <a> {vtranslate('LBL_EDITING', $MODULE)} </a>:&nbsp;
                                       
                                          </span>
                                {/if}
                                
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                <a>{$RECORD->getName()} </a>
                                    
                                      </span>
                                {/if}
                                {else}
                               
                                      <span class="current-filter-name settingModuleName filter-name pull-left">
                                    &nbsp;{if $smarty.request.extensionModule}<a>{$smarty.request.extensionModule}</a>{else}<a>{vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}</a>{/if}
                                      </span>
                                {/if}
                    
                        {else}
                        {if $smarty.request.view eq 'TaxIndex'}
                        {assign var=SELECTED_MODULE value='LBL_TAX_MANAGEMENT'}
                        {elseif $smarty.request.view eq 'TermsAndConditionsEdit'}
                        {assign var=SELECTED_MODULE value='LBL_TERMS_AND_CONDITIONS'}
                        {else}
                        {assign var=SELECTED_MODULE value=$ACTIVE_BLOCK['menu']}
                        {/if}
                        <span class="current-filter-name filter-name pull-left" style='width:50%;'><a class="display-inline-block">{vtranslate({$PAGETITLE}, $QUALIFIED_MODULE)}</a></span>
                        {/if}
                        {/if}
                </div>
                <div class="col-lg-5 col-md-5 pull-right">
                        <div id="appnav" class="navbar-right">
                                <div class="btn-group">
                                 
                                        {foreach item=BASIC_ACTION from=$MODULE_BASIC_ACTIONS}
                                        {if $BASIC_ACTION->getLabel() == 'LBL_IMPORT'}
                                     
                                        <button id="{$MODULE}_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($BASIC_ACTION->getLabel())}" 
                                                type="button" class="btn addButton {if $MODULE eq 'Users'} btn-primary text-white {else} module-buttons  {/if}" 
                                                {if $MODULE eq 'Users' AND  $BASIC_ACTION->getLabel() eq 'LBL_IMPORT'} style="margin-right:5px; margin-top:5px;"  {/if}
                                                {if stripos($BASIC_ACTION->getUrl(), 'javascript:')===0}
                                                onclick='{$BASIC_ACTION->getUrl()|substr:strlen("javascript:")};'
                                                {else} 
                                                onclick="Vtiger_Import_Js.triggerImportAction('{$BASIC_ACTION->getUrl()}')"
                                                {/if}>
                                            <!-- Added by Khaled -->
                                            {if $BASIC_ACTION->getLabel() eq 'LBL_IMPORT'}
                                                 <i class="ti ti-upload" aria-hidden="true"></i>&nbsp;&nbsp;
                                            {else}    
                                                <i class="fa {$BASIC_ACTION->getIcon()}" aria-hidden="true"></i>&nbsp;&nbsp;
                                             {/if}   
                                                {vtranslate($BASIC_ACTION->getLabel(), $MODULE)}
                                        </button>
                                        {else}
                                            
                                        <button type="button" class="btn addButton  {if $MODULE eq 'Users'} btn-primary text-white {else} module-buttons {/if}" 
                                                {if $MODULE eq 'Users'} style="margin-right:5px; margin-top: 5px; "  {/if}
                                        id="{$MODULE}_listView_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($BASIC_ACTION->getLabel())}"
                                        {if stripos($BASIC_ACTION->getUrl(), 'javascript:')===0}
                                        onclick='{$BASIC_ACTION->getUrl()|substr:strlen("javascript:")};'
                                        {else} 
                                        onclick='window.location.href="{$BASIC_ACTION->getUrl()}"'
                                        {/if}>
                                        <div class="fa {$BASIC_ACTION->getIcon()}" aria-hidden="true"></div>
                                        &nbsp;&nbsp;{vtranslate($BASIC_ACTION->getLabel(), $MODULE)}
                                </button>
                                {/if}
                                {/foreach}
                                {if $LISTVIEW_LINKS['LISTVIEWSETTING']|@count gt 0}
                                {if empty($QUALIFIEDMODULE)} 
                                {assign var=QUALIFIEDMODULE value=$MODULE}
                                {/if}
                                <!-- Added BY khaled -->
                                       {if $MODULE neq 'Users'}
                                            <div class="settingsIcon">
                                                    <button type="button" class="btn module-buttons dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="ti-settings" aria-hidden="true" title="{vtranslate('LBL_SETTINGS', $MODULE)}"></span>&nbsp; <span class="caret"></span>
                                                    </button>
                                                    <ul class="detailViewSetting dropdown-menu animated flipInY">
                                                            {foreach item=SETTING from=$LISTVIEW_LINKS['LISTVIEWSETTING']}
                                                            <li id="{$MODULE}_setings_lisview_advancedAction_{$SETTING->getLabel()}">
                                                                <a href="javascript:void(0);" onclick="{$SETTING->getUrl()};">{vtranslate($SETTING->getLabel(), $QUALIFIEDMODULE)}</a>
                                                            </li>
                                                            {/foreach}
                                                    </ul>
                                            </div>
                                        {else}
                                              {foreach item=SETTING from=$LISTVIEW_LINKS['LISTVIEWSETTING']}
                                               {*     <li id="{$MODULE}_setings_lisview_advancedAction_{$SETTING->getLabel()}">*}
                                               <!-- Khaled Note :
                                                    Change Owner will be placed to somewhere else. For Now it is Hidden
                                               -->
                                               <a  class="btn  {if $MODULE eq 'Users'} btn-primary text-white {else} module-buttons {/if} {if $SETTING->getLabel() eq 'LBL_CHANGE_OWNER'} hide {/if}" 
                                                    {if $MODULE eq 'Users'} style="margin-right:5px; margin-top:5px;"  {/if}
                                                   href="javascript:void(0);" onclick="{$SETTING->getUrl()};">
                                                   {if $SETTING->getLabel() eq 'LBL_CHANGE_OWNER'} 
                                                       <i class="material-icons module-icon" style="font-weight:bold;">person</i>&nbsp;
                                                   {elseif $SETTING->getLabel() eq 'LBL_EXPORT'} 
                                                       <i class="ti ti-download" style="font-weight:bold;"></i>&nbsp;
                                                   {/if}                                                
                                                       {vtranslate($SETTING->getLabel(), $QUALIFIEDMODULE)}
                                                   </a>
                                                   {* </li>*}
                                            {/foreach}
                                        {/if}
                                {/if}

                                {assign var=RESTRICTED_MODULE_LIST value=['Users', 'EmailTemplates']}
                                {if $LISTVIEW_LINKS['LISTVIEWBASIC']|@count gt 0 and !in_array($MODULE, $RESTRICTED_MODULE_LIST)}
                                {if empty($QUALIFIED_MODULE)} 
                                {assign var=QUALIFIED_MODULE value='Settings:'|cat:$MODULE}
                                {/if}
                                {foreach item=LISTVIEW_BASICACTION from=$LISTVIEW_LINKS['LISTVIEWBASIC']}
                                {if $MODULE eq 'Users'} {assign var=LANGMODULE value=$MODULE} {/if}
                                <button class="btn module-buttons"
                                id="{$MODULE}_listView_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($LISTVIEW_BASICACTION->getLabel())}" 
                                {if $MODULE eq 'Workflows'}
                                onclick='Settings_Workflows_List_Js.triggerCreate("{$LISTVIEW_BASICACTION->getUrl()}&mode=V7Edit")'
                                {else}
                                {if stripos($LISTVIEW_BASICACTION->getUrl(), 'javascript:')===0}
                                onclick='{$LISTVIEW_BASICACTION->getUrl()|substr:strlen("javascript:")};'
                                {else}
                                onclick='window.location.href = "{$LISTVIEW_BASICACTION->getUrl()}"'
                                {/if}
                                {/if}>
                                {if $MODULE eq 'Tags'}
                                <i class="ti-plus"></i>&nbsp;&nbsp;
                                {vtranslate('LBL_ADD_TAG', $QUALIFIED_MODULE)}
                                {else}
                                {if $LISTVIEW_BASICACTION->getIcon()}
                                <i class="{$LISTVIEW_BASICACTION->getIcon()}"></i>&nbsp;&nbsp;
                                {/if}
                                {vtranslate($LISTVIEW_BASICACTION->getLabel(), $QUALIFIED_MODULE)}
                                {/if}
                        </button>
                        {/foreach}
                        {/if}
                </div>
        </div>
</div>
</div>
{if $FIELDS_INFO neq null}
<script type="text/javascript">
        var uimeta = (function () {
                var fieldInfo = {$FIELDS_INFO};
                return {
                        field: {
                                get: function (name, property) {
                                        if (name && property === undefined) {
                                                return fieldInfo[name];
                                        }
                                        if (name && property) {
                                                return fieldInfo[name][property]
                                        }
                                },
                                isMandatory: function (name) {
                                        if (fieldInfo[name]) {
                                                return fieldInfo[name].mandatory;
                                        }
                                        return false;
                                },
                                getType: function (name) {
                                        if (fieldInfo[name]) {
                                                return fieldInfo[name].type
                                        }
                                        return false;
                                }
                        },
                };
        })();
</script>
{/if}
</div>
{/strip}

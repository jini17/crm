{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
 <div class="col-sm-12 col-xs-12 module-action-bar clearfix coloredBorderTop">
        <div class="module-action-content clearfix {$MODULE}-module-action-content">
                <div class="col-xs-{if $smarty.request.view eq 'Edit'}12{else}3{/if} col-lg-3 module-breadcrumb module-breadcrumb-{$smarty.request.view} transitionsAllHalfSecond">
                        {assign var=MODULE_MODEL value=Vtiger_Module_Model::getInstance($MODULE)}
                        {if $MODULE_MODEL->getDefaultViewName() neq 'List'}
                                {assign var=DEFAULT_FILTER_URL value=$MODULE_MODEL->getDefaultUrl()}
                        {else}
                                {assign var=DEFAULT_FILTER_ID value=$MODULE_MODEL->getDefaultCustomFilter()}
                                {if $DEFAULT_FILTER_ID}
                                        {assign var=CVURL value="&viewname="|cat:$DEFAULT_FILTER_ID}
                                        {assign var=DEFAULT_FILTER_URL value=$MODULE_MODEL->getListViewUrl()|cat:$CVURL}
                                {else}
                                        {assign var=DEFAULT_FILTER_URL value=$MODULE_MODEL->getListViewUrlWithAllFilter()}
                                {/if}
                        {/if}
                        {if ($MODULE eq 'LeaveType' || $MODULE eq 'BenefitType' || $MODULE eq 'Holiday' || $MODULE eq 'Grade' || $MODULE eq 'ClaimType' || $MODULE eq 'WorkingHours') 
                                && ($CURRENT_USER_MODEL->is_admin eq 'on' || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H12' || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H12') }
                                <a title="{vtranslate($MODULE, $MODULE)}" href='index.php?module=Users&view=PreferenceDetail&parent=Settings&record=1&subtype=H'><h4 class="module-title pull-left text-uppercase"> {vtranslate('SETTINGS', 'SETTINGS')} </h4>&nbsp;&nbsp;</a>
                        {elseif ($MODULE eq 'EmployeeContract' || $MODULE eq 'PassportVisa' || $MODULE eq 'Performance' || $MODULE eq 'Payslip') 
                                && ($CURRENT_USER_MODEL->is_admin eq 'on' || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H13' || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H12')}	
                                <a title="{vtranslate($MODULE, $MODULE)}" href='index.php?module=Users&view=PreferenceDetail&parent=Settings&record=1&subtype=E'><h4 class="module-title pull-left text-uppercase"> {vtranslate('SETTINGS', 'SETTINGS')} </h4>&nbsp;&nbsp;</a>
                        {else}
                                <a title="{vtranslate($MODULE, $MODULE)}" href='{$DEFAULT_FILTER_URL}&app={$SELECTED_MENU_CATEGORY}'><h4 class="module-title pull-left text-uppercase"> {vtranslate($MODULE, $MODULE)} </h4>&nbsp;&nbsp;</a>
                        {/if}


                        {if $smarty.session.lvs.$MODULE.viewname}
                                {assign var=VIEWID value=$smarty.session.lvs.$MODULE.viewname}
                        {/if}
                        {if $VIEWID}
                                {foreach item=FILTER_TYPES from=$CUSTOM_VIEWS}
                                        {foreach item=FILTERS from=$FILTER_TYPES}
                                                {if $FILTERS->get('cvid') eq $VIEWID}
                                                        {assign var=CVNAME value=$FILTERS->get('viewname')}
                                                        {break}
                                                {/if}
                                        {/foreach}
                                {/foreach}
                              {if ($MODULE eq 'LeaveType' 
                                    || $MODULE eq 'BenefitType' 
                                    || $MODULE eq 'EmployeeContract' 
                                    || $MODULE eq 'Holiday' 
                                    || $MODULE eq 'WorkingHours' 
                                    || $MODULE eq 'Claim' 
                                    || $MODULE eq 'Grade' 
                                    || $MODULE eq 'ClaimType' 
                                    || $MODULE eq 'PassportVisa' 
                                    || $MODULE eq 'Performance' 
                                    || $MODULE eq 'Payslip'
                                    ) 
                                    && ($CURRENT_USER_MODEL->is_admin eq 'on' 
                                    || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H2' 
                                    || $CURRENT_USER_MODEL->column_fields['roleid'] eq 'H12')
                              }
                                    <p class="current-filter-name filter-name pull-left cursorPointer {if $smarty.request.view eq 'Edit' or $RECORD}hidden-xs{/if}" title="{$CVNAME}">
                                        <span class="ti-angle-right pull-left" aria-hidden="true"></span>
                                        <a href='{$MODULE_MODEL->getListViewUrl()}&viewname={$VIEWID}&app={$SELECTED_MENU_CATEGORY}'>
                                            &nbsp;&nbsp;{vtranslate($CVNAME,'Vtiger')}&nbsp;&nbsp;{vtranslate($MODULE,'Vtiger')}
                                        </a> 
                                    </p>
                        {else}
                                <p class="current-filter-name filter-name pull-left cursorPointer {if $smarty.request.view eq 'Edit' or $RECORD}hidden-xs{/if}" title="{$CVNAME}"><span class="ti-angle-right pull-left" aria-hidden="true"></span><a href='{$MODULE_MODEL->getListViewUrl()}&viewname={$VIEWID}&app={$SELECTED_MENU_CATEGORY}'>&nbsp;&nbsp;{vtranslate($CVNAME,'Vtiger')}&nbsp;&nbsp;</a> </p>
                        {/if}



                        {/if}
                        {assign var=SINGLE_MODULE_NAME value='SINGLE_'|cat:$MODULE}
                        {if $RECORD and $smarty.request.view eq 'Edit'}
                                <p class="current-filter-name filter-name pull-left ">
                                    <span class="ti-angle-right pull-left" aria-hidden="true"></span>
                                    <a title="{$RECORD->get('label')}">
                                        &nbsp;&nbsp;{vtranslate('LBL_EDITING', $MODULE)} : {$RECORD->get('label')} &nbsp;&nbsp;
                                    </a>
                                </p>
                        {else if $smarty.request.view eq 'Edit'}
                                <p class="current-filter-name filter-name pull-left ">
                                    <span class="ti-angle-right pull-left" aria-hidden="true"></span>
                                    <a>
                                        &nbsp;&nbsp;{vtranslate('LBL_ADDING_NEW', $MODULE)}&nbsp;&nbsp;
                                    </a>
                                </p>
                        {/if}
                        {if $smarty.request.view eq 'Detail'}
                                <p class="current-filter-name filter-name pull-left">
                                    <span class="ti-angle-right pull-left" aria-hidden="true"></span>
                                    <a title="{$RECORD->get('label')}">&nbsp;&nbsp;{$RECORD->get('label')} &nbsp;&nbsp;
                                    </a>
                                </p>
                        {/if}
                </div> 
                <div class="col-xs-5 col-lg-5 col-md-5 col-sm-5">
                        {if $MODULE eq 'Home'  AND     $LOGGED_NOW == 'in' }
                        <div class="clearfix">

                                <div class="col-xs-12">
                                        <!-- added by jitu@28Dec2016-->
                                        <div style="text-align:center;display:block;width:100%;margin:0 auto;padding:2px;">{vtranslate('LBL_LAST_LOGINTIME')} {$LAST_LOGIN_TIME} {vtranslate('LBL_USERIP')} {$LAST_USER_IP}
                                        </div>
                                        <!--end here -->
                                </div>

                        </div>
                        <br>
                        {/if}
                </div>

                <div class="col-xs-4 col-lg-4 col-md-4 col-sm-4 module-breadcrumb-{$smarty.request.view}" style="margin:  0px; padding: 0px;">
                         <div id="appnav" class="navbar-right">


                <div class="clearfix"></div>
                                <div class="btn-group">

                                        {foreach item=BASIC_ACTION from=$MODULE_BASIC_ACTIONS}
                                                {if $BASIC_ACTION->getLabel() == 'LBL_IMPORT'}
                                                                <button id="{$MODULE}_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($BASIC_ACTION->getLabel())}" type="button" class="btn module-buttons addButton" 
                                                                                {if stripos($BASIC_ACTION->getUrl(), 'javascript:')===0}  
                                                                                        onclick='{$BASIC_ACTION->getUrl()|substr:strlen("javascript:")};'
                                                                                {else}
                                                                                        onclick="Vtiger_Import_Js.triggerImportAction('{$BASIC_ACTION->getUrl()}')"
                                                                                {/if}>
                                                                        <i class="material-icons">import_export</i>
                                                                        <span class="hidden-sm hidden-xs">{vtranslate($BASIC_ACTION->getLabel(), $MODULE)}</span>
                                                                </button>
                                                {else}
                                                                <button id="{$MODULE}_listView_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($BASIC_ACTION->getLabel())}" type="button" class="btn module-buttons addButton" 
                                                                                {if stripos($BASIC_ACTION->getUrl(), 'javascript:')===0}  
                                                                                        onclick='{$BASIC_ACTION->getUrl()|substr:strlen("javascript:")};'
                                                                                {else} 
                                                                                        onclick='window.location.href = "{$BASIC_ACTION->getUrl()}&app={$SELECTED_MENU_CATEGORY}"'
                                                                                {/if}>
                                                                        <i class="material-icons">add</i>
                                                                        <span class="hidden-sm hidden-xs">{vtranslate($BASIC_ACTION->getLabel(), $MODULE)}</span>
                                                                </button>
                                                {/if}
                                        {/foreach}
                                        {if $MODULE_SETTING_ACTIONS|@count gt 0}
                                                                <button type="button" class="btn module-buttons dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                        <span class="hidden-xs hidden-sm" aria-hidden="true" title="{vtranslate('LBL_SETTINGS', $MODULE)}">&nbsp;{vtranslate('LBL_CUSTOMIZE', 'Reports')}</span><i class="material-icons">settings</i> 
                                                                </button>
                                                                <ul class="detailViewSetting dropdown-menu pull-right animated fadeIn">
                                                                        {foreach item=SETTING from=$MODULE_SETTING_ACTIONS}
                                                                                <li id="{$MODULE_NAME}_listview_advancedAction_{$SETTING->getLabel()}"><a href={$SETTING->getUrl()}>{vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate($SETTING->getLabel(), $MODULE_NAME)}</a></li>
                                                                        {/foreach}
                                                                </ul>
                                        {/if}
                                        <a class='btn btn-default Help-btn'>
                                                <i class="glyphicon glyphicon-question-sign"></i>&nbsp;&nbsp; Help
                                        </a>


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
{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{strip}
{assign var=SETTINGS_MENU_LIST value=Settings_Vtiger_Module_Model::getSettingsMenuListForNonAdmin()}

<div class="settingsgroup hidden-sm hidden-xs" style="overflow: scroll">
         <div class="col-xs-12 text-center visible-xs visible-sm" style="margin-top: 20px;margin-bottom:20px;">

        </div>
        <br><div class="clearfix"></div>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="settingsgroup-panel panel panel-default">

                        {foreach item=BLOCK_MENUS key=BLOCK_NAME from=$SETTINGS_MENU_LIST}
                                {assign var=NUM_OF_MENU_ITEMS value= $BLOCK_MENUS|@sizeof}
                                {if $NUM_OF_MENU_ITEMS gt 0}
                                        <div id="{$BLOCK_NAME}_accordion" class="app-nav hidden-sm hidden-xs" role="tab">
                                                <div class="app-settings-accordion">
                                                        <div class="settingsgroup-accordion">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#{$BLOCK_NAME}" {if $ACTIVE_BLOCK['block'] eq $BLOCK_NAME} class="btn-primary text-white"{/if}>
                                                                        <i class="indicator ti {if $ACTIVE_BLOCK['block'] eq $BLOCK_NAME} ti-angle-down {else} ti-angle-right {/if}"></i>
                                                                        &nbsp;<span>{vtranslate($BLOCK_NAME,$QUALIFIED_MODULE)}</span>
                                                                </a>
                                                        </div>
                                                </div>
                                        </div>  
                                        <div id="{$BLOCK_NAME}" class="panel-collapse collapse {if $ACTIVE_BLOCK['block'] eq $BLOCK_NAME} in {/if}">
                                                <ul class="list-group">
                                                        {foreach item=URL key=MENU from=$BLOCK_MENUS}
                                                       
                                                                {assign var=MENU_URL value='#'}
                                                                {assign var=MENU_LABEL value=$MENU}

                                                                {if $MENU eq 'My Preferences'}
                                                                        {assign var=MENU_URL value=$USER_MODEL->getPreferenceDetailViewUrl()}
                                                                {elseif $MENU eq 'Calendar Settings'}
                                                                        {assign var=MENU_URL value=$USER_MODEL->getCalendarSettingsDetailViewUrl()}
                                                                {elseif $MENU === $URL.0}
                                                                        {if $SETTINGS_MENU_ITEMS[$MENU]}
                                                                                {assign var=MENU_URL value=$SETTINGS_MENU_ITEMS[$MENU]->getURL()}
                                                                        {/if}
                                                                {elseif is_string($URL.0)}
                                                                        {assign var=MENU_URL value=$URL.0}
                                                                {/if}
                                                                {if $MENU eq 'LBL_EMPLOYEMENT_DETAILS' || $MENU eq  'LBL_PASSPORTVISA'
                                                             || $MENU eq  'LBL_PERFORMANCE' || $MENU eq  'LBL_PAYSLIP' } 
                                                                  {assign var=MENU_URL value=$USER_MODEL->getEmploymentTabURL($URL.0)}

                                                                {/if}    
                                                            
                                                                <li><a href="{$MENU_URL}" class="menuItemLabel {if $ACTIVE_BLOCK['menu'] eq $MENU} settingsgroup-menu-color {/if}">&nbsp;<i class="material-icons module-icon">&nbsp;{$URL[1]}</i>{vtranslate($MENU_LABEL,$QUALIFIED_MODULE)}</a></li>
                                                        {/foreach}
                                                </ul>
                                        </div>
                                {/if}
                        {/foreach}
                </div>
        </div>
</div>

<div id="ssidebar-essentials" class="sidebar-essentials visible-xs visible-sm">
        <div class="col-xs-12 text-center visible-xs visible-sm" style="margin-top: 20px;margin-bottom:20px;">
        <a class="btn btn-default" onclick="$('.sidebar-menu-u, .settingsNav').toggleClass('hidden-xs hidden-sm'); $('.settingsNav').find('.settingsgroup').toggleClass('hidden-xs hidden-sm');">Sidebar 
        &nbsp;<span class="toggleButton"><i class="ti-angle-down"></i></span></a>
        </div>
        <br/><div class="clearfix"></div><br/>
        <div class="sidebar-menu-u hidden-xs hidden-sm">

<div class="settingsgroup visible-sm visible-xs" style="overflow: scroll">

        <div class="panel-group" id="accordion_mobile" role="tablist" aria-multiselectable="true">
                <div class="settingsgroup-panel panel panel-default">
                    {$SETTINGS_MENU_LIST|print_r}
                        {foreach item=BLOCK_MENUS key=BLOCK_NAME from=$SETTINGS_MENU_LIST}
                                {assign var=NUM_OF_MENU_ITEMS value= $BLOCK_MENUS|@sizeof}
                                {if $NUM_OF_MENU_ITEMS gt 0}

                                        <div id="{$BLOCK_NAME}_accordion_mobile" class="app-nav " role="tab">
                                                <div class="app-settings-accordion">
                                                        <div class="settingsgroup-accordion">
                                                                <a data-toggle="collapse" data-parent="#accordion_mobile" href="#{$BLOCK_NAME}_mobile">
                                                                        <i class="indicator ti  {if $ACTIVE_BLOCK['block'] eq $BLOCK_NAME} ti-angle-down {else} ti-angle-right {/if}"></i>
                                                                        &nbsp;<span>{vtranslate($BLOCK_NAME,$QUALIFIED_MODULE)}</span>
                                                                </a>
                                                        </div>
                                                </div>
                                        </div>  
                                        <div id="{$BLOCK_NAME}_mobile" class="panel-collapse collapse {if $ACTIVE_BLOCK['block'] eq $BLOCK_NAME} in {/if}">
                                                <ul class="list-group">
                                                        {foreach item=URL key=MENU from=$BLOCK_MENUS}
                                                                {assign var=MENU_URL value='#'}
                                                                {assign var=MENU_LABEL value=$MENU}

                                                                {if $MENU eq 'My Preferences'}
                                                                        {assign var=MENU_URL value=$USER_MODEL->getPreferenceDetailViewUrl()}
                                                                {elseif $MENU eq 'Calendar Settings'}
                                                                        {assign var=MENU_URL value=$USER_MODEL->getCalendarSettingsDetailViewUrl()}
                                                                {elseif $MENU === $URL}
                                                                        {if $SETTINGS_MENU_ITEMS[$MENU]}
                                                                                {assign var=MENU_URL value=$SETTINGS_MENU_ITEMS[$MENU]->getURL()}
                                                                        {/if}
                                                                {elseif is_string($URL)}
                                                                        {assign var=MENU_URL value=$URL}
                                                                {/if}

                                                                <li><a href="{$MENU_URL}" class="menuItemLabel {if $ACTIVE_BLOCK['menu'] eq $MENU} settingsgroup-menu-color {/if}">{vtranslate($MENU_LABEL,$QUALIFIED_MODULE)}</a></li>
                                                        {/foreach}
                                                </ul>
                                        </div>
                                {/if}
                        {/foreach}
                </div>
        </div>
</div>

</div>
</div>


{/strip}

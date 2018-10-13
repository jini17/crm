{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Vtiger/views/DashBoard.php *}

{strip}
<input type="hidden" name="default_tab" id="default_tab" value="{$SELECTED_TAB}" />
<div class="dashBoardContainer clearfix">
        <div class="tabContainer">

                 <ul class="nav nav-tabs tabs sortable container-fluid visible-lg">
                {foreach key=index item=TAB_DATA from=$DASHBOARD_TABS}
                    <li class="{if $TAB_DATA["id"] eq $SELECTED_TAB}active{/if} dashboardTab" data-tabid="{$TAB_DATA["id"]}" data-tabname="{$TAB_DATA["tabname"]}">
                        <a data-toggle="tab" href="#tab_{$TAB_DATA["id"]}">
                            <div>
                                <span class="name textOverflowEllipsis" value="{$TAB_DATA["tabname"]}" style="width:10%">
                                    <strong>{vtranslate($TAB_DATA["tabname"],'Vtiger')}</strong>
                                </span>
                                <span class="editTabName hide">
                                    <input type="text" name="tabName"/>
                                </span>
                                {if $TAB_DATA["isdefault"] eq 0}
                                    <i class="material-icons deleteTab">close</i>
                                {/if}
                                <i class="fa fa-bars moveTab hide"></i>
                            </div>
                        </a>
                    </li>
                {/foreach}

           <div class="moreSettings pull-right col-lg-4 col-md-2 col-sm-12 col-xs-12">
               <div class="buttonGroups pull-left">
                   {if $SELECTED_TAB neq 1}
                <div class="btn-group"  {$SELECTED_TAB}>
                      <button class = "addNewDashBoard btn-primary btn pull-left" style='margin-right: 5px;'><i class="fa fa-edit"></i>&nbsp;{vtranslate('LBL_ADD_NEW_DASHBOARD',$MODULE)}</button> &nbsp;
                       <button class="btn btn-success updateSequence pull-right hide">{vtranslate('LBL_SAVE_ORDER',$MODULE)}</button>
                      <button class = "reArrangeTabs btn-primary btn pull-right" style='margin-right: 10px;'>{vtranslate('LBL_REARRANGE_DASHBOARD_TABS',$MODULE)}</button>
                      {if $SELECTABLE_WIDGETS|count gt 0}
                                <button class='btn btn-info addButton dropdown-toggle widget-btn' data-toggle='dropdown'>
                                        {vtranslate('LBL_ADD_WIDGET')}&nbsp;&nbsp;<i class="caret"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right widgetsList pull-right animated flipInY" style="min-width:100%;text-align:left;">
                                        {assign var="MINILISTWIDGET" value=""}
                                        {foreach from=$SELECTABLE_WIDGETS item=WIDGET}
                                                {if $WIDGET->getName() eq 'MiniList'}
                                                        {assign var="MINILISTWIDGET" value=$WIDGET} {* Defer to display as a separate group *}
                                                {elseif $WIDGET->getName() eq 'Notebook'}
                                                        {assign var="NOTEBOOKWIDGET" value=$WIDGET} {* Defer to display as a separate group *}
                                                {else}
                                                        <li>
                                                                <a onclick="Vtiger_DashBoard_Js.addWidget(this, '{$WIDGET->getUrl()}')" href="javascript:void(0);"
                                                                        data-linkid="{$WIDGET->get('linkid')}" data-name="{$WIDGET->getName()}" data-width="{$WIDGET->getWidth()}" data-height="{$WIDGET->getHeight()}">
                                                                        {vtranslate($WIDGET->getTitle(), $MODULE_NAME)}</a>
                                                        </li>
                                                {/if}
                                        {/foreach}

                                        {if $MINILISTWIDGET && $MODULE_NAME == 'Home'}
                                                <li class="divider"></li>
                                                <li>
                                                        <a onclick="Vtiger_DashBoard_Js.addMiniListWidget(this, '{$MINILISTWIDGET->getUrl()}')" href="javascript:void(0);"
                                                                data-linkid="{$MINILISTWIDGET->get('linkid')}" data-name="{$MINILISTWIDGET->getName()}" data-width="{$MINILISTWIDGET->getWidth()}" data-height="{$MINILISTWIDGET->getHeight()}">
                                                                {vtranslate($MINILISTWIDGET->getTitle(), $MODULE_NAME)}</a>
                                                </li>
                                                <li>
                                                        <a onclick="Vtiger_DashBoard_Js.addNoteBookWidget(this, '{$NOTEBOOKWIDGET->getUrl()}')" href="javascript:void(0);"
                                                                data-linkid="{$NOTEBOOKWIDGET->get('linkid')}" data-name="{$NOTEBOOKWIDGET->getName()}" data-width="{$NOTEBOOKWIDGET->getWidth()}" data-height="{$NOTEBOOKWIDGET->getHeight()}">
                                                                {vtranslate($NOTEBOOKWIDGET->getTitle(), $MODULE_NAME)}</a>
                                                </li>
                                        {/if}


                                </ul>
                        {else if $MODULE_PERMISSION}
                            
                                <button class='btn addButton dropdown-toggle' disabled="disabled" data-toggle='dropdown'>
                                        <strong>{vtranslate('LBL_ADD_WIDGET')}</strong> &nbsp;&nbsp;
                                        <i class="caret"></i>
                                </button>
                        {/if}
                      
                </div>
                {/if}
        </div>
                    {*<div class="dropdown dashBoardDropDown pull-right">
                        <button class="btn btn-info reArrangeTabs dropdown-toggle" type="button" data-toggle="dropdown">{vtranslate('LBL_MORE',$MODULE)}
                            &nbsp;&nbsp;<span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right moreDashBoards">
                            <li id="newDashBoardLi"{if count($DASHBOARD_TABS) eq $DASHBOARD_TABS_LIMIT}class="disabled"{/if}>
                                <a class = "addNewDashBoard" href="#">{vtranslate('LBL_ADD_NEW_DASHBOARD',$MODULE)}</a>
                            </li>
                            <li><a class = "reArrangeTabs" href="#">{vtranslate('LBL_REARRANGE_DASHBOARD_TABS',$MODULE)}</a></li>
                        </ul>
                    </div>*}
                 
                </div>

            </ul>

            <!-- Related mobile -->
<div class="sortable container-fluid visible-md visible-sm visible-xs" style="display:none!important" >
<div class="col-md-12 col-sm-12 col-xs-12 text-right padding0px">
<div class="btn-group">
  <button type="button" class="btn btn-info dropdown-toggle" style="width:200px!important;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="material-icons">attach_file</i> Tabs Dashboard <i class="material-icons">arrow_drop_down</i>
  </button>
  <ul class="dropdown-menu">
 {foreach key=index item=TAB_DATA from=$DASHBOARD_TABS}
                    <li class="{if $TAB_DATA["id"] eq $SELECTED_TAB}active{/if} dashboardTab" data-tabid="{$TAB_DATA["id"]}" data-tabname="{$TAB_DATA["tabname"]}">
                        <a data-toggle="tab" href="#tab_{$TAB_DATA["id"]}">
                            <div>
                                <span class="name textOverflowEllipsis" value="{$TAB_DATA["tabname"]}" style="width:10%">
                                    <span>{$TAB_DATA["tabname"]}</span>
                                </span>
                                <span class="editTabName hide">
                                    <input type="text" name="tabName"/>
                                </span>
                                {if $TAB_DATA["isdefault"] eq 0}
                                    <i class="material-icons deleteTab">close</i>
                                {/if}
                                <i class="fa fa-bars moveTab hide"></i>
                            </div>
                        </a>
                    </li>
                {/foreach}


  </ul>
</div></div></div>
    <!-- / Related mobile -->

            <div class="tab-content">
                {foreach key=index item=TAB_DATA from=$DASHBOARD_TABS}
                    <div id="tab_{$TAB_DATA["id"]}" data-tabid="{$TAB_DATA["id"]}" data-tabname="{$TAB_DATA["tabname"]}" class="tab-pane fade {if $TAB_DATA["id"] eq $SELECTED_TAB}in active{/if}">
                        {if $TAB_DATA["id"] eq $SELECTED_TAB}
                            {include file="modules/Vtiger/dashboards/DashBoardTabContents.tpl" TABID=$TABID}
                        {/if}
                    </div>
                {/foreach}
            </div>
        </div>
</div>
{/strip}
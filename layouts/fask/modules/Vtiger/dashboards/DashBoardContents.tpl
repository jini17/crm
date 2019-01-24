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
               <div class="buttonGroups pull-right">
                   {if $SELECTED_TAB neq 1 AND $SELECTED_TAB neq 1298}
                <div class="btn-group pull-right"  {$SELECTED_TAB}>
                      <button class = "addNewDashBoard btn-primary btn pull-left" style='margin-right: 5px;'><i class="fa fa-edit"></i>&nbsp;{vtranslate('LBL_ADD_NEW_DASHBOARD',$MODULE)}</button> &nbsp;
                       <button class="btn btn-success updateSequence pull-right hide">{vtranslate('LBL_SAVE_ORDER',$MODULE)}</button>
                      <button class = "reArrangeTabs btn-primary btn pull-right" style='margin-right: 0'>{vtranslate('LBL_REARRANGE_DASHBOARD_TABS',$MODULE)}</button>
                      {if $SELECTABLE_WIDGETS|count gt 0}
                                <button class='btn btn-info addButton dropdown-toggle widget-btn' data-toggle='dropdown'>
                                        {vtranslate('LBL_ADD_WIDGET')}&nbsp;&nbsp;<i class="caret"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-right widgetsList pull-right animated flipInY" style="min-width:58%;text-align:left;">
                                        {assign var="MINILISTWIDGET" value=""}
                                        {foreach from=$SELECTABLE_WIDGETS item=WIDGET}
                                                {if $WIDGET->getName() eq 'MiniList'}
                                                        {assign var="MINILISTWIDGET" value=$WIDGET} {* Defer to display as a separate group *}
                                                {elseif $WIDGET->getName() eq 'Notebook'}
                                                        {assign var="NOTEBOOKWIDGET" value=$WIDGET} {* Defer to display as a separate group *}
                                                {else}
                                                     <!--  <li>
                                                                <a onclick="Vtiger_DashBoard_Js.addWidget(this, '{$WIDGET->getUrl()}')" href="javascript:void(0);"
                                                                        data-linkid="{$WIDGET->get('linkid')}" data-name="{$WIDGET->getName()}" data-width="{$WIDGET->getWidth()}" 
                                                                        data-height="{$WIDGET->getHeight()}">
                                                                        {vtranslate($WIDGET->getTitle(), $MODULE_NAME)}
                                                                </a>
                                                        </li> -->
                                                {/if}
                                        {/foreach}
                                         
                                        {if count($EMPLOYEE_GROUP) > 0}
                                        <li class="group-heading employee" style="position:relative;">
                                             <a class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Employee <i class="fa fa-users pull-right widget-icon"></i></a>
                                          
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                             
                                                {foreach item="emp" from=$EMPLOYEE_GROUP }      
                                                       <li class="emp-widget widget-item ">
                                                           <a style="padding-left: 10px;" data-group="employee" {if $emp["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} onclick="Vtiger_DashBoard_Js.addWidget(this, '{$emp['URL']}')" href="javascript:void(0);"
                                                                   data-linkid="{$emp['linkid']}" 
                                                                   data-name="{$emp['name']}" 
                                                                   data-width="{$emp['width']}" 
                                                                   data-height="{$emp['height']}">
<<<<<<< HEAD
                                                                  {$emp['title']}
=======
                                                                  {vtranslate($emp['title'])}
>>>>>>> 20f1f25e9b7a979199ba5a838e54fd86d6e0bdd9
                                                           </a>
                                                       </li>
                                               {/foreach}
                                              
                                            </ul>
                                            
                                        </li>
                                        {/if}

                                        {if count($SALES) > 0}
                                        <li class="group-heading employee" style="position:relative;">
                                             <a class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Sales <i class="fa fa-usd pull-right widget-icon"></i></a>
                                          
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                             
                                                {foreach item="emp" from=$SALES }      
                                                       <li class="emp-widget widget-item ">
                                                           <a style="padding-left: 10px;" data-group="employee" {if $emp["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} onclick="Vtiger_DashBoard_Js.addWidget(this, '{$emp['URL']}')" href="javascript:void(0);"
<<<<<<< HEAD
                                                                   data-linkid="{$emp['linkid']}" 
                                                                   data-name="{$emp['name']}" 
                                                                   data-width="{$emp['width']}" 
                                                                   data-height="{$emp['height']}">
                                                                  {$emp['title']}
                                                           </a>
                                                       </li>
                                               {/foreach}
                                              
                                            </ul>
                                            
                                        </li>
                                        {/if}

                                        {if count($SERVICE) > 0}
                                        <li class="group-heading employee" style="position:relative;">
                                             <a class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Service <i class="fa fa-headphones pull-right widget-icon"></i></a>
                                          
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                             
                                                {foreach item="emp" from=$SERVICE }      
                                                       <li class="emp-widget widget-item ">
                                                           <a style="padding-left: 10px;" data-group="employee" {if $emp["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} onclick="Vtiger_DashBoard_Js.addWidget(this, '{$emp['URL']}')" href="javascript:void(0);"
=======
>>>>>>> 20f1f25e9b7a979199ba5a838e54fd86d6e0bdd9
                                                                   data-linkid="{$emp['linkid']}" 
                                                                   data-name="{$emp['name']}" 
                                                                   data-width="{$emp['width']}" 
                                                                   data-height="{$emp['height']}">
                                                                  {$emp['title']}
                                                           </a>
                                                       </li>
                                               {/foreach}
                                              
                                            </ul>
                                            
                                        </li>
                                        {/if}

<<<<<<< HEAD
=======
                                        {if count($SERVICE) > 0}
                                        <li class="group-heading employee" style="position:relative;">
                                             <a class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Service <i class="fa fa-headphones pull-right widget-icon"></i></a>
                                          
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                             
                                                {foreach item="emp" from=$SERVICE }      
                                                       <li class="emp-widget widget-item ">
                                                           <a style="padding-left: 10px;" data-group="employee" {if $emp["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} onclick="Vtiger_DashBoard_Js.addWidget(this, '{$emp['URL']}')" href="javascript:void(0);"
                                                                   data-linkid="{$emp['linkid']}" 
                                                                   data-name="{$emp['name']}" 
                                                                   data-width="{$emp['width']}" 
                                                                   data-height="{$emp['height']}">
                                                                  {$emp['title']}
                                                           </a>
                                                       </li>
                                               {/foreach}
                                              
                                            </ul>
                                            
                                        </li>
                                        {/if}

>>>>>>> 20f1f25e9b7a979199ba5a838e54fd86d6e0bdd9
                                        {if count($CHART_GROUP) > 0}                          
                                        <li  class="group-heading charts" style="">
                                            <a  class="widget-heading widget-item"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Charts <i class="fa fa-pie-chart pull-right widget-icon"></i></a> 
                                             
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                                
                                                {foreach item="chart" from=$CHART_GROUP}
                                                    <li class="chart-widget widget-item">
                                                       <a  class="widget-item" style="padding-left: 10px;" {if $chart["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if}  data-group="charts" onclick="Vtiger_DashBoard_Js.addWidget(this, '{$chart['URL']}')" href="javascript:void(0);"
                                                               data-linkid="{$chart['linkid']}" data-name="{$chart['name']}" data-width="{$chart['width']}" 
                                                               data-height="{$chart['height']}">
                                                              {$chart['title']}
                                                       </a>
                                                   </li>
                                               {/foreach}
                                                
                                            </ul>
                                        </li>
                                        {/if} 

                                        {if count($LEAVECLAIM_GROUP) > 0}                                                                
                                         <li  class="group-heading leaveclaim" >
                                       
                                             <a  class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp; Leaves & Claims <i class="fa fa-clipboard pull-right widget-icon"></i></a>
                                            
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                                
                                                {foreach item="leaveclaim" from=$LEAVECLAIM_GROUP }
                                                   <li class="leaveclaim-widget widget-item">
                                                       <a  class=" widget-item" {if $leaveclaim["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} style="padding-left: 5px;" onclick="Vtiger_DashBoard_Js.addWidget(this, '{$leaveclaim['URL']}')" href="javascript:void(0);"
                                                               data-linkid="{$leaveclaim['linkid']}"  data-group="leaveclaim" data-name="{$leaveclaim['name']}" data-width="{$leaveclaim['width']}" 
                                                               data-height="{$leaveclaim['height']}">
                                                              {$leaveclaim['title']}
                                                       </a>
                                                   </li>
                                                {/foreach}
                                                
                                            </ul>
                                        </li>                                     
                                        {/if}

                                        {if count($GENERAL_GROUP) > 0}
                                        <li class='general'>
                                            <a  class="widget-heading"><i class="fa fa-angle-left"></i>  &nbsp;&nbsp;  General <i class="fa fa-windows pull-right widget-icon"></i></a>
                                            <ul class="widget-group-item hide list-unstyled" style="padding:5px; width: 100%; top: 0; position: absolute; left: -227px; background:#fff;  z-index: -1; ; padding: 15px;">
                                                 
                                                    {foreach item="general" from=$GENERAL_GROUP}
                                                        <li  class="general-widget widget-item ">
                                                            <a class="widget-item_{$general['linkid']}}"  {if $general["is_closed"] eq 0} disabled="disabled" title="This widget is currently active"{/if} style="padding-left: 10px;" data-group="general" onclick="Vtiger_DashBoard_Js.addWidget(this, '{$general['URL']}')" href="javascript:void(0);"
                                                                    data-linkid="{$general['linkid']}" data-name="{$general['name']}" data-width="{$general['width']}" 
                                                                    data-height="{$general['height']}">
                                                                   {$general['title']}
                                                            </a>
                                                       </li>
                                                    {/foreach}
                                                 
                                               
                                            </ul>
                                        </li>
                                        {/if}
                                        
                                        {if $MINILISTWIDGET && $MODULE_NAME == 'Home'}
                                                <li class="divider"></li>
                                                <li>
                                                    <a class="minilist-widget" onclick="Vtiger_DashBoard_Js.addMiniListWidget(this, '{$MINILISTWIDGET->getUrl()}')" href="javascript:void(0);"
                                                            data-linkid="{$MINILISTWIDGET->get('linkid')}" data-name="{$MINILISTWIDGET->getName()}" data-width="{$MINILISTWIDGET->getWidth()}" data-height="{$MINILISTWIDGET->getHeight()}">
                                                            {vtranslate($MINILISTWIDGET->getTitle(), $MODULE_NAME)}
                                                            <i class="fa fa-list pull-right widget-icon"></i>
                                                    </a>
                                                </li>
                                                <li  >
                                                    <a  class="notebook-widget"  onclick="Vtiger_DashBoard_Js.addNoteBookWidget(this, '{$NOTEBOOKWIDGET->getUrl()}')" href="javascript:void(0);"
                                                            data-linkid="{$NOTEBOOKWIDGET->get('linkid')}" data-name="{$NOTEBOOKWIDGET->getName()}" data-width="{$NOTEBOOKWIDGET->getWidth()}" data-height="{$NOTEBOOKWIDGET->getHeight()}">
                                                            {vtranslate($NOTEBOOKWIDGET->getTitle(), $MODULE_NAME)}
                                                            <i class="fa fa fa-sticky-note pull-right widget-icon"></i>
                                                    </a>
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
</div></div>
</div>
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
                <div class="clearfix"></div>
                <a class="strolltotop pull-right">
                    <i class="fa fa-arrow-up"></i>
                </a>
</div>
{/strip}
<script>
 jQuery(document).ready(function(){
     //Widget Drop Down
            jQuery(".widget-heading").on("hover",function(){ 
            
            var $this = jQuery(this);
            jQuery(".widget-group-item").addClass("hide")
            $this.closest("li").find(".widget-group-item").removeClass("hide");
        })
        
        jQuery(".strolltotop").on("click",function () {
                     $("#page").animate({ scrollTop: 0 }, "slow"); 
                     return false;
            });
          });

        jQuery('')

</script>

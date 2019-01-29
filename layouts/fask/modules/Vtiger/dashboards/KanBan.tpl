{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

{strip}
    <div id="taskManagementContainer" class='fc-overlay-modal modal-content' style="height:100%;">
        <input type="hidden" name="colors" value='{json_encode($COLORS)}'>

            {assign var=HEADER_TITLE value="TASK MANAGEMENT"}

        <hr style="margin:0px;">
        <div class='modal-body overflowYAuto'>
            <div class='datacontent'>
                <div class="data-header clearfix">
                    <div class="btn-group dateFilters col-md-3 col-sm-3 col-xs-3" role="group" aria-label="...">

                        <button type="button" class="btn btn-default {if $TASK_FILTERS['date'] eq "all"}active{/if}" data-filtermode="all">{vtranslate('LBL_ALL', $MODULE)}</button>
                        <button type="button" class="btn btn-default {if $TASK_FILTERS['date'] eq "today"}active{/if}" data-filtermode="today">{vtranslate('LBL_TODAY', $MODULE)}</button>
                        <button type="button" class="btn btn-default {if $TASK_FILTERS['date'] eq "thisweek"}active{/if}" data-filtermode="thisweek">{vtranslate('LBL_THIS_WEEK', $MODULE)}</button>
                       {* Hidden by nirbhay to hide date range
                       <button type="button" class="btn btn-default dateRange dateField" data-calendar-type="range" data-filtermode="range"><i class="fa fa-calendar"></i></button>
                        <button type="button" class="btn btn-default hide rangeDisplay">
                            <span class="selectedRange"></span>&nbsp;
                            <i class="fa fa-times clearRange"></i>
                        </button>*}
                    </div>

                    <div id="taskManagementOtherFilters" class="otherFilters  col-md-9 col-sm-9 col-xs-9" >
                        <div class='field col-md-6' style="position:relative;">
                            <div id="task-input-background">
                                Select Employee
                            </div>
                            {include file="modules/Calendar/uitypes/OwnerFieldTaskSearchView.tpl" FIELD_MODEL=$OWNER_FIELD}
                        </div>
                        <div class='field col-md-6'>
                            {assign var=FIELD_MODEL value=$STATUS_FIELD}
                            {assign var=FIELD_INFO value=$FIELD_MODEL->getFieldInfo()}
                            {assign var=PICKLIST_VALUES value=$FIELD_INFO['picklistvalues']}
                            {assign var=FIELD_INFO value=Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($FIELD_INFO))}
                            {assign var=SEARCH_VALUES value=explode(',',$SEARCH_INFO['searchValue'])}
                            <select class="select2 listSearchContributor" name="{$FIELD_MODEL->get('name')}" multiple data-fieldinfo='{$FIELD_INFO|escape}'>
                                {foreach item=PICKLIST_LABEL key=PICKLIST_KEY from=$PICKLIST_VALUES}
                                    <option {if $PICKLIST_KEY|in_array:$TASK_FILTERS['status']}selected{/if} value="{$PICKLIST_KEY}">{$PICKLIST_LABEL}</option>
                                {/foreach}
                            </select>
                            <button class="btn btn-success search" style="position: absolute; top:0;right:-26px;padding-top: 5px;padding-bottom: 5px;"><span class="fa fa-search"></span></button>
                        </div>

                    </div>
                </div>

                <hr>

                <div class="data-body row">
                    {assign var=MODULE_MODEL value= Vtiger_Module_Model::getInstance($MODULE)}
                    {assign var=USER_PRIVILEGES_MODEL value= Users_Privileges_Model::getCurrentUserPrivilegesModel()}

                    {foreach item=STATUSVAL from=$STATUSES}
                        <div class="col-lg-4 contentsBlock {strtolower($STATUSVAL|replace:' ':'_')} ui-droppable" data-status='{strtolower($STATUSVAL|replace:' ':'_')}' data-page="{$PAGE}">
                            <div class="{strtolower($STATUSVAL|replace:' ':'_')}-header" style="border-bottom: 1px solid {$COLORS[$STATUSVAL]}; ">
                                <div class="title" ><span>{vtranslate($STATUSVAL,$STATUSVAL)}</span></div>   
                            </div>
                            <br>
                            <div class="{strtolower($STATUSVAL|replace:' ':'_')}-content content" data-status='{$STATUSVAL|replace:' ':'_'}' style="border-bottom: 1px solid {$COLORS[$STATUSVAL]};padding-bottom: 10px">
                                {if $USER_PRIVILEGES_MODEL->hasModuleActionPermission($MODULE_MODEL->getId(), 'CreateView')}
                                    <div class="input-group">
                                        <input type="text" class="form-control taskSubject {strtolower($STATUSVAL|replace:' ':'_')}" placeholder="{vtranslate('LBL_ADD_TASK_AND_PRESS_ENTER', $MODULE)}" aria-describedby="basic-addon1" style="width: 99%">
                                        <span class="quickTask input-group-addon js-task-popover-container more cursorPointer" id="basic-addon1" style="border: 1px solid #ddd; padding: 0 13px;">
											<a href="#" id="taskPopover" status='{strtolower($STATUSVAL|replace:' ':'_')}'><i class="fa fa-plus icon"></i></a>
										</span>
                                    </div>
                                {/if}
                                <br>
                                <div class='{strtolower($STATUSVAL|replace:' ':'_')}-entries container-fluid scrollable dataEntries padding20' style="height:400px;overflow:auto;width:400px;padding-left: 0px;padding-right: 0px;">

                                </div>
                            </div>
                        </div>
                    {/foreach}
                </div>
                <div class="editTaskContent hide">
                    {include file="TaskManagementEdit.tpl"|vtemplate_path:$MODULE}
                </div>
            </div>
        </div>
    </div>
{/strip}
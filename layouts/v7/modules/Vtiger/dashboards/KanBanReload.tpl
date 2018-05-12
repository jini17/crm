{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

{strip}
    <input type="hidden" id="sessionStatus" name="sessionStatus" value="{$STATUSFILTER}" />

        <input type="hidden" name="colors" value='{json_encode($COLORS)}'>

        {assign var=HEADER_TITLE value="TASK MANAGEMENT"}




                <hr>


                    {assign var=MODULE_MODEL value= Vtiger_Module_Model::getInstance($MODULE)}
                    {assign var=USER_PRIVILEGES_MODEL value= Users_Privileges_Model::getCurrentUserPrivilegesModel()}

                    {foreach item=STATUSVAL from=$STATUSES}
                        <div class="col-lg-4 contentsBlock {strtolower($STATUSVAL|replace:' ':'_')} ui-droppable" data-status='{strtolower($STATUSVAL|replace:' ':'_')}' data-page="{$PAGE}">
                            <div class="{strtolower($STATUSVAL|replace:' ':'_')}-header" style="border-bottom: 2px solid ">
                                <div class="title" style="background:{$COLORS[$STATUSVAL]}"><span>{$STATUSVAL}</span></div>
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

                <div class="editTaskContent hide">
                    {include file="TaskManagementEdit.tpl"|vtemplate_path:$MODULE}
                </div>



{/strip}
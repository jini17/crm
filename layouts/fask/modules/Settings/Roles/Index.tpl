{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Roles/views/Index.php *}

{strip}
    <div class="listViewPageDiv " id="listViewContent" style="width:calc(100%); position: relative;">
        <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 1px;right:0; left: 100%" title="Left Panel Show/Hide">
            <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span></button>                    


        <div class="clearfix"></div>
        <div class="col-sm-12 col-xs-12 UserRole">
            <div class="clearfix"></div>
            <br>
            <div class="clearfix treeView">
                <ul>
                    <li data-role="{$ROOT_ROLE->getParentRoleString()}" data-roleid="{$ROOT_ROLE->getId()}">
                        <div class="toolbar-handle">
                            <a href="javascript:;" class="btn app-MARKETING droppable">{$ROOT_ROLE->getName()}</a>
                            <div class="toolbar" title="{vtranslate('LBL_ADD_RECORD', $QUALIFIED_MODULE)}">
                                &nbsp;<a href="{$ROOT_ROLE->getCreateChildUrl()}" data-url="{$ROOT_ROLE->getCreateChildUrl()}" data-action="modal"><span class="icon-plus-sign"></span></a>
                            </div>
                        </div>
                        {assign var="ROLE" value=$ROOT_ROLE}
                        {include file=vtemplate_path("RoleTree.tpl", "Settings:Roles")}
                    </li>
                </ul>
            </div>
                    <div class="clearfix"></div>
        </div>
    </div>
{/strip}
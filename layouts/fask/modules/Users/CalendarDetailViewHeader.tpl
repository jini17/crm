{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
    {assign var="MODULE_NAME" value=$MODULE_MODEL->get('name')}
    <input id="recordId" type="hidden" value="{$RECORD->getId()}" />
    <div class="detailViewContainer" style="position:relative;">
        <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
        <div class="detailViewTitle" id="prefPageHeader">
        </div>
        <div class="detailViewInfo userPreferences row-fluid">
            <div class="details col-xs-12">
            {/strip}
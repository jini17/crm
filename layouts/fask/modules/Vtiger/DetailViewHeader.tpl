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
<div class=" detailview-header-block">
    <div class="detailview-header">
        <div class="row">
        	{if $MODULE_NAME eq 'MessageBoard'}
        		{include file="modules/MessageBoard/DetailViewHeaderTitle.tpl"}
            {else}
            	{include file="modules/Vtiger/DetailViewHeaderTitle.tpl"}
            {/if}	
            {include file="modules/Vtiger/DetailViewActions.tpl"}
        </div>
</div>
    
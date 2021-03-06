{*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************}
{strip}
<ul>
{foreach from=$REGION->getChildren() item=CHILD_REGION}
	<li data-tree="{$CHILD_REGION->getParentRegionString()}" data-treeid="{$CHILD_REGION->getId()}" data-regionid="{$CHILD_REGION->getRegionid()}">
		<div {if $smarty.request.view != 'Popup'}class="toolbar-handle"{/if}>
			{if $smarty.request.type == 'Transfer'}
				{assign var="SOURCE_REGION_SUBPATTERN" value='::'|cat:$SOURCE_REGION->getId()}
				{if strpos($CHILD_REGION->getParentRegionString(), $SOURCE_REGION_SUBPATTERN) !== false}
					{$CHILD_REGION->getChildName()}
				{else}
					<a href="{$CHILD_REGION->getEditViewUrl()}" data-url="{$CHILD_REGION->getEditViewUrl()}" class="btn treeEle" rel="tooltip" >{$CHILD_REGION->getChildName()}</a>
				{/if}
			{else}
					<a href="{$CHILD_REGION->getEditViewUrl()}" data-url="{$CHILD_REGION->getEditViewUrl()}" class="btn draggable droppable" rel="tooltip" title="{vtranslate('LBL_CLICK_TO_EDIT_OR_DRAG_TO_MOVE',$QUALIFIED_MODULE)}">{$CHILD_REGION->getChildName()}</a>
			{/if}
			{if $smarty.request.view != 'Popup'}
			<div class="toolbar">
				&nbsp;<a href="{$CHILD_REGION->getCreateChildUrl()}" data-url="{$CHILD_REGION->getCreateChildUrl()}" title="{vtranslate('LBL_ADD_RECORD', $QUALIFIED_MODULE)}"><span class="icon-plus-sign"></span></a>
				&nbsp;<a data-id="{$CHILD_REGION->getId()}" href="javascript:;" data-url="{$CHILD_REGION->getDeleteActionUrl()}" data-action="modal" title="{vtranslate('LBL_DELETE', $QUALIFIED_MODULE)}"><span class="icon-trash"></span></a>
			</div>
			{/if}
		</div>

		{assign var="REGION" value=$CHILD_REGION}
		{include file=vtemplate_path("RegionTree.tpl", "Settings:ManageTerritory")}
	</li>
{/foreach}
</ul>
{/strip}

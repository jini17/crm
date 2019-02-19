{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
<div class="listViewPageDiv">
	<div class="listViewTopMenuDiv">
		<div class="widget_header row-fluid">
			<h3>{vtranslate($MODULE, $QUALIFIED_MODULE)}</h3>
		</div>
        <hr>
		<div class="row-fluid">
			<span class="span4 btn-toolbar">
				<button class="btn addButton" onclick="Settings_ManageTerritory_Js.triggerShowEditView('index.php?module=ManageTerritory&parent=Settings&view=Edit');">
					<i class="icon-plus"></i>&nbsp;
					<strong>{vtranslate('LBL_ADD_RECORD', $QUALIFIED_MODULE)}</strong>
				</button>
			</span>
		</div>
	</div>
	<div class="listViewEntriesDiv" style='overflow-x:auto;'>
		{if $LISTVIEW_REGION|COUNT ge '0'}
			<table class="table table-bordered table-condensed listViewEntriesTable">
				<thead>
					<tr class="listViewHeaders">
						<th>{vtranslate('LBL_REGION', $QUALIFIED_MODULE)}</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					{foreach item=REGIONS from=$LISTVIEW_REGION}
						<tr>
							<td>{$REGIONS['region']}</td>
							<td nowrap class="">
								<div class="pull-right actions">
									<span class="actionImages">
				<a onclick="Settings_ManageTerritory_Js.triggerShowEditView('index.php?module=ManageTerritory&parent=Settings&view=Edit&record={$REGIONS['regionid']}');">
<i class="icon-pencil alignMiddle" title="Edit"></i></a>&nbsp;&nbsp;

				<a onclick="Settings_ManageTerritory_Js.triggerDeleteRegion({$REGIONS['regionid']});">
<i class="icon-trash alignMiddle" title="Delete"></i></a>
									</span>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
	<!--added this div for Temporarily -->
		{else}	
			<table class="emptyRecordsDiv">
				<tbody>
					<tr>
						<td>
							{vtranslate('LBL_NO_RECORDS_FOUND', $QUALIFIED_MODULE)}
						</td>
					</tr>
				</tbody>
			</table>
		{/if}
	</div>
</div>
{/strip}

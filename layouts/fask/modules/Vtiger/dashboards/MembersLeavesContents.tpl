{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}

<div style='padding:5px;'>
{if count($MODELS) > 0}
<table class="table table-bordered listViewEntriesTable">
	<thead>
		<tr>
			<th style="width:43%;">
			<b>{vtranslate('LBL_NAME', $MODULE_NAME)}</b>
			</th>
			<th>
			<b>{vtranslate('LBL_DURATIONOFLEAVE', $MODULE_NAME)}</b>
			</th>
			<th>
			<b>{vtranslate('LBL_STATUS', $MODULE_NAME)}</b>
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$MODELS}
			<tr>
				<td>
				{$MODEL['fullname']}
				</td>
				<td>
				{$MODEL['duration']}
				</td>
				<td style="text-align:center;">
				{$MODEL['leavestatus']}
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
{else}
	<span class="noDataMsg">
		{vtranslate('LBL_NO_ONE',$MODULE_NAME)} {vtranslate($MODULE_NAME, $MODULE_NAME)} {$TIME_LABEL}
	</span>
{/if}
</div>

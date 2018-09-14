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
			<b>Holiday Name</b>
			</th>
			<th>
			<b>Start Date</b>
			</th>
			<th colspan="2">
			<b>End Date</b>
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$MODELS}
			<tr>
				<td>
				{$MODEL['holiday_name']}
				</td>
				<td>
				{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($MODEL['start_date'])}
				</td>
				<td style="text-align:center;">
				{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($MODEL['end_date'])}
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate('LBL_NO_HOLIDAY',$MODULE_NAME)}
	</span>
{/if}
</div>

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
			<b>Holidays</b>
			</th>
			<th>
			<b>Date</b>
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
				{$MODEL['start_date_day']}{if $MODEL['start_date_day'] eq 1}st{elseif $MODEL['start_date_day'] eq 2}nd{elseif $MODEL['start_date_day'] eq 3}rd{else}th{/if} 
				{Vtiger_Util_Helper::getMonthName($MODEL['start_date_month'])}
				{if $MODEL['start_date_day'] eq $MODEL['end_date_day']}{$MODEL['end_date_year']}
				{else} - {$MODEL['end_date_day']}{if $MODEL['end_date_day'] eq 1}st{elseif $MODEL['end_date_day'] eq 2}nd{elseif $MODEL['end_date_day'] eq 3}rd{else}th{/if} 
				{Vtiger_Util_Helper::getMonthName($MODEL['end_date_month'])} {$MODEL['end_date_year']}{/if}
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

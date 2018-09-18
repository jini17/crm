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
			<b>{vtranslate('LBL_LEAVE_TYPE', $MODULE_NAME)}</b>
			</th>
			<th>
			<b>{vtranslate('LBL_DURATIONOFLEAVE', $MODULE_NAME)}</b>
			</th>
			<th colspan="2">
			<b>{vtranslate('LBL_STATUS', $MODULE_NAME)}</b>
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$MODELS}
			<tr>
				<td>
				{$MODEL['leave_type']}
				</td>
				<td>	
				{$MODEL['from_date_day']}{if $MODEL['from_date_day'] eq 1}st
				{elseif $MODEL['from_date_day'] eq 2}nd
				{elseif $MODEL['from_date_day'] eq 3}rd
				{else}th{/if} 
				{Vtiger_Util_Helper::getMonthName($MODEL['from_date_month'])}
				{if $MODEL['from_date_day'] eq $MODEL['to_date_day']}2018 
				{else} - {$MODEL['to_date_day']}{if $MODEL['to_date_day'] eq 1}st{elseif $MODEL['to_date_day'] eq 2}nd{elseif $MODEL['to_date_day'] eq 3}rd{else}th{/if} {Vtiger_Util_Helper::getMonthName($MODEL['to_date_month'])} {$MODEL['to_date_year']}{/if}
				</td>
				<td style="text-align:center;">
				{$MODEL['leavestatus']}
				</td>
			</tr>
		{/foreach}
	</tbody>
</table>
<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate($TYPELABEL,$MODULE_NAME)}
	</span>
{/if}
</div>

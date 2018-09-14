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
			{if $VALUE eq  ''}
			<th>
			<b>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</b>
			</th>
			{/if}
			
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$MODELS}
			<tr>
				<td>
					<strong>{$MODEL['empname']}</strong>
					<br />
					(<i>{$MODEL['title']}<i>)
				</td>
			
				{if $VALUE eq ''}			
				<td style="text-align:center;">
					{$MODEL['department']}
				</td>
				{/if}
			</tr>
		{/foreach}
	</tbody>
</table>
<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate($TYPELABEL,$MODULE_NAME)} in {$VALUE}
	</span>
{/if}
</div>

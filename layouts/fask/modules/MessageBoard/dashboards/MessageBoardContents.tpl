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
			<b>Name</b>
			</th>
			<th>
			<b>Message</b>
			</th>
			<th colspan="2">
			<b>Time</b>
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$ANNOUNCEMENTS}
			<tr>
				<td>
				{$MODEL['first_name']}
				</td>
				<td>
				{$MODEL['message']}
				</td>
				<td style="text-align:center;">
				{$MODEL['messagetime']}
				</td>
				
			</tr>
		{/foreach}
                                   {$ANNOUNCEMENTS}
	</tbody>
</table>
<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate($TYPELABEL,$MODULE_NAME)}
	</span>
{/if}
</div>

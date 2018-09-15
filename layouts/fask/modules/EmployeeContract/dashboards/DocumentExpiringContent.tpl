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
			<th>
			<b>{vtranslate('Name',$MODULE_NAME)}</b>
			</th>
			<th>
			<b>{vtranslate('Department',$MODULE_NAME)}</b>
			</th>
			<th>
			<b>{vtranslate('Expiry Date',$MODULE_NAME)}</b>
			</th>
		</tr>
	</thead>
	<tbody>
		{foreach item=MODEL from=$MODELS}
			<tr>
				<td>
				<strong>{$MODEL['fullname']}</strong>
				{if $MODEL['designation'] neq ''}<br />(<i>{$MODEL['designation']}</i>){/if}
				</td>
				<td>
				{$MODEL['department']}
				</td>
				<td>
				{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($MODEL['expirydate'])}
				</td>

			</tr>
		{/foreach}
	</tbody>
</table>
{if $PAGE gt 0}
	<div class="row">
			<div class="col-lg-12">
				<h4><a href="javascript:;" class="text-info load-more" data-page="{$PAGE}" data-nextpage="{$NEXTPAGE}">{vtranslate('LBL_MORE')}...</a></h4>
		</div>
	</div>
{/if}
<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate($VALUELABEL,$MODULE_NAME)} {vtranslate('LBL_NOT_DURATION',$MODULE_NAME)}
	</span>
{/if}
</div>

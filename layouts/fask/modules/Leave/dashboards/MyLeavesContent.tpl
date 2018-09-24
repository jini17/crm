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
	 {if $VALUE eq 'leavetype'}
			{foreach item=MODEL from=$MODELS['display']}
			
			<div class='row miniListContent'>
				<div class='col-lg-3' align="center">
					{$MODEL['allocateleaves']}
				</div>
				<div class='col-lg-2' align="center">
					{$MODEL['takenleave']}
				</div>
				<div class='col-lg-3' align="center">
					{$MODEL['balanceleave']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['leavetype']}
				</div>
			</div>
			{/foreach}
		{else}
			{foreach item=MODEL from=$MODELS}
			<div class='row miniListContent' style="padding:5px">
				<div class='col-lg-4'>
					{$MODEL['title']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['fromdate']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['leavestatus']}
				</div>
			</div>
			{/foreach}
		{/if}
{else}
	<span class="noDataMsg">
		{vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
	</span>
{/if}
</div>
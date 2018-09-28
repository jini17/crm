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

<div style='padding:5px'>
{if count($MODELS) > 0}
	  <div class='row th' style="padding:5px">
        	{if $VALUE eq 'claimtype'}
	            <div class='col-lg-3'>
	                <strong>{vtranslate('Allocated', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Used', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-3'>
	                <strong>{vtranslate('Balance', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-4'>
	                <strong>{vtranslate('Type', $MODULE_NAME)}</strong>
	            </div>
            {else}
	            <div class='col-lg-4'>
	                <strong>{vtranslate('Claim Type', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-4'>
	                <strong>{vtranslate('Amount', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-4'>
	                <strong>{vtranslate('Date', $MODULE_NAME)}</strong>
	            </div>
	        {/if}
        </div>
		{if $VALUE eq 'claimtype'}
			{foreach item=MODEL from=$MODELS}
			
			<div class='row miniListContent'>
				<div class='col-lg-3' align="center">
					{$MODEL['yearlylimit']}
				</div>
				<div class='col-lg-2' align="center">
					{$MODEL['totalamount']}
				</div>
				<div class='col-lg-3' align="center">
					{$MODEL['balance']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['category']}
				</div>
			</div>
			{/foreach}
		{else}
			{foreach item=MODEL from=$MODELS}
			<div class='row miniListContent' style="padding:5px">
				<div class='col-lg-4'>
					{$MODEL['category']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['totalamount']}
				</div>
				<div class='col-lg-4'>
					{$MODEL['transactiondate']}
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
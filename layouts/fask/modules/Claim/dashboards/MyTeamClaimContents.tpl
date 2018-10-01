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
	                <strong>{vtranslate('Employee Name', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Claim Type', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-3'>
	                <strong>{vtranslate('Allocated', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Used', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Balance', $MODULE_NAME)}</strong>
	            </div>
            {else}
	            <div class='col-lg-3'>
	                <strong>{vtranslate('Employee Name', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Claim Type', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Amount', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-3'>
	                <strong>{vtranslate('Date', $MODULE_NAME)}</strong>
	            </div>
	            <div class='col-lg-2'>
	                <strong>{vtranslate('Action', $MODULE_NAME)}</strong>
	            </div>
	        {/if}
        </div>
		{if $VALUE eq 'claimtype'}
			{foreach item=MODEL from=$MODELS}
			
			<div class='row miniListContent' style="padding:5px">
				<div class='col-lg-3' align="center">
					{$MODEL['fullname']}
				</div>
				<div class='col-lg-2' align="center">
					{$MODEL['category']}
				</div>
				<div class='col-lg-3' align="center">
					{$MODEL['yearly_limit']}
				</div>
				<div class='col-lg-2' align="center">
					{$MODEL['totalamount']}
				</div>
				<div class='col-lg-2'>
					{$MODEL['balance']}
				</div>
			</div>
			{/foreach}
		{else}
			{foreach item=MODEL from=$MODELS}
			<div class='row miniListContent' style="padding:5px">
				<div class='col-lg-3'>
					{$MODEL['fullname']}
				</div>
				<div class='col-lg-2'>
					{$MODEL['category']}
				</div>
				<div class='col-lg-2' align="center">
					{$MODEL['totalamount']}
				</div>
				<div class='col-lg-3'>
					{$MODEL['transactiondate']}
				</div>
				<div class='col-lg-2'>
					<a class="editLeave cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Claim_Js.Popup_ClaimApprove('{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}&manager=true');"></a>&nbsp;&nbsp;
						
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

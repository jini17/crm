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
	<div class='row th' style="padding:5px;margin-right:-1px;margin-left:-1px;">
			<div class='col-lg-7'>
			<b>{vtranslate('Name',$MODULE_NAME)} &amp; {vtranslate('Department',$MODULE_NAME)} </b>
			</div>
			<!--<div class='col-lg-6'>
			<b>{vtranslate('Department',$MODULE_NAME)}</b>
			</div>-->
			<div class='col-lg-5'>
			<b>{vtranslate('Expiry Date',$MODULE_NAME)}</b>
			</div>
		</div>


		{foreach item=MODEL from=$MODELS}
			<div class='row miniListContent' style="padding:5px;margin-right:-1px;margin-left:-1px;">
				<div class='col-lg-7'>
				<strong>{$MODEL['fullname']}</strong>
				{if $MODEL['department'] neq ''}<br />(<i>{$MODEL['department']}</i>){/if}
				</div>
				<!--<div class='col-lg-6'>
				{$MODEL['department']}
				</div>-->
				<div class='col-lg-5'>
				{$MODEL['expirydate_day']}{if $MODEL['expirydate_day'] eq 1}st
				{elseif $MODEL['expirydate_day'] eq 2}nd
				{elseif $MODEL['expirydate_day'] eq 3}rd
				{else}th{/if}
				{Vtiger_Util_Helper::getMonthName($MODEL['expirydate_month'])} {$MODEL['expirydate_year']}
				</div>

			</div>
		{/foreach}


<br /><br />
{else}
	<span class="noDataMsg">
		{vtranslate($VALUELABEL,$MODULE_NAME)} {vtranslate('LBL_NOT_DURATION',$MODULE_NAME)}
	</span>
{/if}
</div>

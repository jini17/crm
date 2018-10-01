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
    <div class="row th" style="padding-top:5px; padding-bottom: 5px;">
        <div class="col-lg-5"><strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong></div>
        <div class="col-lg-5"><strong>{vtranslate('LBL_DURATIONOFLEAVE', $MODULE_NAME)}</strong></div>
        <div class="col-lg-2"><strong>{vtranslate('LBL_STATUS', $MODULE_NAME)}</strong></div>
    </div>
    <div class="clearfix"></div>
  
        {foreach item=MODEL from=$MODELS}
              <div class="row miniListContent">
                    <div class="col-lg-5">{$MODEL['fullname']}</div>
                    <div class="col-lg-5">{$MODEL['duration']}</div>
                    <div class="col-lg-2">{$MODEL['leavestatus']} &nbsp; {$MODEL['icon']}</div>
              </div>    
         {/foreach}


{else}
	<span class="noDataMsg">
		{vtranslate($TYPELABEL,$MODULE_NAME)}
	</span>
{/if}
</div>

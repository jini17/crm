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
	<div>
        <div class='row th' style="padding:5px;margin-right:-1px;margin-left:-1px;">
       		<div class='col-lg-5'>
             	<strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-5'>
               <strong>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-2'>
              <strong>{vtranslate('LBL_MC_TAKEN', $MODULE_NAME)}</strong>
            </div>
          </div>
		<hr>
		{foreach item=MODEL from=$MODELS}
			<div class='row miniListContent' style="padding:5px;margin-right:-1px;margin-left:-1px;">
				<div class='col-lg-5'>
					<a href="index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$MODEL['userid']}"><strong>{$MODEL['empname']}</strong></a>
						<br />
					<!--(<i>{$MODEL['title']}</i>)-->
				</div>
				<div class='col-lg-5'>
					{$MODEL['department']}
				</div>
				<div class='col-lg-2'>
					{$MODEL['leavecount']}
				</div>
			</div>
			{/foreach}
	</div>
{else}
	<span class="noDataMsg">
		{vtranslate($TYPELABEL,$MODULE_NAME)} in {$VALUE}
	</span>
{/if}
</div>
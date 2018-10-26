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
        <div class='row th' style="padding:5px">
            <div class='col-lg-3'>
                <strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-3'>
               <strong>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-3'>
              <strong>{vtranslate('LBL_STARTDATE', $MODULE_NAME)}</strong>
            </div>
              <div class='col-lg-3'>
              <strong>{vtranslate('LBL_ENDDATE', $MODULE_NAME)}</strong>
            </div>

          </div>
                {foreach item=MODEL from=$MODELS}
                        <div class='row miniListContent' style="padding:5px;margin-right:-1px;margin-left:-1px;">
                                <div class='col-lg-3'>
                                        <a href="index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$MODEL['userid']}"><strong>{$MODEL['empname']}</strong></a>
                                </div>
                                <div class='col-lg-3'>
                                        {$MODEL['department']}
                                </div>
                                <div class='col-lg-3'>
                                        <span>{$MODEL['fromdate']|date_format:" %b %e"}</span>
                                </div>
              <div class='col-lg-3'>
                <span>{$MODEL['todate']|date_format:" %b %e"}</span>
              </div>
                        </div>
                        {/foreach}
                         <div class="clearfix"></div>
                        <a href="index.php?module=Claim&view=List" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>
     </div>

{else}
        <span class="noDataMsg">
                {vtranslate($VALUELABEL,$MODULE_NAME)}
        </span>
{/if}
</div>
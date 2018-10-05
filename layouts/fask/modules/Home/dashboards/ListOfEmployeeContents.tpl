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
<script src="layouts/vlayout/modules/Emails/resources/MassEdit.js?v=6.1.0" type="text/javascript"></script>
<div style='padding:5px;'>
    {$DATA|print_r}
{if count($DATA) > 0}
    
    <div class="row th">
        <div class="col-md-6">{vtranslate('LBL_NAME', $MODULE_NAME)}</div>
        <div class="col-md-6">{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</div>
        
    </div>
        <div class="row">
              {foreach item=MODEL from=$DATA}
              <div class="col-md-6 ">   {$MODEL['first_name']}  {$MODEL['last_name']} </div>
              <div class="col-md-6 ">   
                  {$MODEL['department']} 
                   <a href="{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$MODEL['empid']}"><i class="fa fa-link"></i></a>
              </div>
            {/foreach}
        </div>

{else}
        <span class="noDataMsg">
                {vtranslate('LBL_NO','Home')} {vtranslate('LBL_BIRTHDAY','Home')} {vtranslate($TYPELABEL,'Home')}
        </span>
{/if}
</div>

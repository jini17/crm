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
  <div class="row entry clearfix">
        <div class='row th' style="padding:5px;margin-right:-1px;margin-left:-1px;font-size:12px;">
          <div class='col-lg-5'>
              <strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong>
            </div>
             <div class='col-lg-3'>
              <strong>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-4'>
               <strong>{vtranslate('LBL_BIRTHDATE', $MODULE_NAME)}</strong>
            </div>
          </div>
    {foreach item=MODEL from=$MODELS}
      <div class='row miniListContent' style="padding:5px;margin-right:-1px;margin-left:-1px;">
        <div class='col-lg-5'>
          {$MODEL['fullname']}
        </div>
         <div class='col-lg-3'>
          {if $MODEL['department'] eq 'Human Resource & Management'} HRM {else}  {$MODEL['department']}  {/if}
        </div>
        <div class='col-lg-4 birthdaywish'>
          <span>   {$MODEL['birthday']|date_format:" %b %e"}</span>
          <!--added by fadzil 27/2/15-->
          &nbsp;&nbsp;
        <i class="fa fa-gift pull-right" style="position: absolute;right: 15px;top: 3px; cursor:pointer;" title="Send Birthday wish"></i>
          {if $MODEL['module'] eq 'Accounts'}
            <input id="modulename" type="hidden" value="Contacts">
            <input id="fieldname" type="hidden" value="email">
          {else}  
          <input id="modulename" type="hidden" value="{$MODEL['module']}">
          <input id="fieldname" type="hidden" value="{$MODEL['fieldname']}">
          {/if}
          <input id="birthdayid" type="hidden" value="{$MODEL['id']}">
        </div>
      </div>
    {/foreach}
  </div>
{else}
  <span class="noDataMsg">
    {vtranslate('LBL_NO','Home')} {vtranslate('LBL_BIRTHDAY','Home')} {vtranslate($TYPELABEL,'Home')}
  </span>
{/if}
</div>
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
<div class="" style="height: 200px; ">
{if count($MODELS) > 0}
<<<<<<< HEAD
        <div>
        <div class='row th' style="padding:5px">
                <div class='col-lg-4'>
                <strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong>

            </div>
            <div class='col-lg-4'>
                <strong>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-4 text-left'>
               <strong>{vtranslate('LBL_BIRTHDATE', $MODULE_NAME)}</strong>
            </div>
          </div>

                {foreach item=MODEL from=$MODELS}
                        <div class='row miniListContent' >
                                <div class='col-lg-4'>
                                    <h5 style="padding-left: 5px;">{$MODEL['fullname']}</h5>
                                </div>
                                 <div class='col-lg-4'>
                                    <h5 style="padding-left: 5px;">{if $MODEL['department'] eq 'Human Resource & Management'} HRM {else} {$MODEL['department']}  {/if}</h5>
                                </div>
                                <div class='col-lg-4'>
                                
                                    <span class=" birthdaywish text-left" style="padding-top: 6px; display: block;">
                                        
                                    {$MODEL['birthday']|date_format:" %B %e"}
                                        <!--added by fadzil 27/2/15-->
                                        <i class="fa fa-gift pull-right" title="Send Birthday wish" style="padding: 5px 6px; font-size: 15px;"></i>
                                                {if $MODEL['module'] eq 'Accounts'}
                                                        <input id="modulename" type="hidden" value="Contacts">
                                                        <input id="fieldname" type="hidden" value="email">
                                                {else}	
                                                <input id="modulename" type="hidden" value="{$MODEL['module']}">
                                                <input id="fieldname" type="hidden" value="{$MODEL['fieldname']}">
                                                {/if}
                                                <input id="birthdayid" type="hidden" value="{$MODEL['id']}">
                                        </span>
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

<script type="text/javascript">
{*      jQuery(document).ready(function(){
          $(".birthdaybox").mCustomScrollbar();
    });*}
    $(window).on("load",function(){
      $(".birthdaybox").mCustomScrollbar({
        theme:"light-3",
        scrollButtons:{
          enable:false
        }
      });
    </script>

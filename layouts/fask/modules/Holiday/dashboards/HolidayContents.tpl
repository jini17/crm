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
                <div class='col-lg-6'>
                <strong>{vtranslate('LBL_HOLIDAY', $MODULE_NAME)}</strong>
            </div>
            <div class='col-lg-6'>
               <strong>{vtranslate('LBL_DATE', $MODULE_NAME)}</strong>
            </div>
          </div>

                {foreach item=MODEL from=$MODELS}

                        <div class='row miniListContent' style="padding:5px">

                                <div class='col-lg-6'>
                                        {$MODEL['holiday_name']}
                                </div>
                                <div class='col-lg-6'>
                            {Vtiger_Util_Helper::getMonthName($MODEL['start_date_month'])} {$MODEL['start_date_day']}
                           {if $MODEL['start_date_day'] neq $MODEL['end_date_day']}
                             -    {Vtiger_Util_Helper::getMonthName($MODEL['end_date_month'])}  {$MODEL['end_date_day']} ,                       
                                {$MODEL['end_date_year']}
                                {else}
                                 ,  {$MODEL['end_date_year']}
                            {/if}
                                {*{$MODEL['start_date_day']}
                                {if $MODEL['start_date_day'] eq 1}st{elseif $MODEL['start_date_day'] eq 2}nd{elseif $MODEL['start_date_day'] eq 3}rd{else}th{/if} 

                                {Vtiger_Util_Helper::getMonthName($MODEL['start_date_month'])}
                                {if $MODEL['start_date_day'] eq $MODEL['end_date_day']}{$MODEL['end_date_year']}
                                {else} - {$MODEL['end_date_day']}{if $MODEL['end_date_day'] eq 1}st{elseif $MODEL['end_date_day'] eq 2}nd{elseif $MODEL['end_date_day'] eq 3}rd{else}th{/if} 
                                {Vtiger_Util_Helper::getMonthName($MODEL['end_date_month'])} {$MODEL['end_date_year']}{/if}*}
                                </div>
                        </div>
                        {/foreach}
        </div>

{else}
        <span class="noDataMsg">
                {vtranslate('LBL_NO_HOLIDAY',$MODULE_NAME)} {vtranslate($TYPELABEL,$MODULE_NAME)}
        </span>
{/if}
</div>
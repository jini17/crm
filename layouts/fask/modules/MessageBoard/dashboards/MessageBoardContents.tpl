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
{if $MODELS > 0}
    {foreach item=MODEL key=k from=$ANNOUNCEMENTS}
        <div class="row row miniListContent" style="padding-top: 5px; padding-bottom: 5px;">
             <div class="col-lg-1">
                 <div class="img-holder"  style="border-radius: 50%; float:left;">
                     <img class="img-circle pull-left" src='{$MODEL['image']}' width='30;' height='30'  />
                    </div>
             </div>      
{*                                         <div class="col-lg-8"><span class="relatedpop"><a href="index.php?module=MessageBoard&view=Popup"> {$MODEL['message']} </a></span></div>
*}
                     <div class="col-lg-7">
                         <span class="relatedPopup" onclick="Vtiger_DashBoard_Js.ViewMessage({$MODEL['user_id']})">
                              {$MODEL['title']}
                           {*  <a href="index.php?module=MessageBoard&view=Popup"> {$MODEL['message']} </a>*}
                         </span>
                     </div>
              <div class="col-lg-4">{$MODEL['messagetime']}</div>
        </div>

    {/foreach}
 

{else}
    <span class="noDataMsg">
            {vtranslate($TYPELABEL,$MODULE_NAME)}
    </span>
{/if}
</div>

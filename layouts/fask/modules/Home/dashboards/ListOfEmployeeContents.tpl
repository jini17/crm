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

{if count($DATA) > 0}
    
    <div class="row th" style="padding:5px;margin-right:-1px;margin-left:-1px;">
        <div class="col-md-4"><b> {vtranslate('LBL_NAME', $MODULE_NAME)} </b></div>
        <div class="col-md-4"> <b>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)} </b></div>
         <div class="col-md-4"> <b>{vtranslate('LBL_DESIGNATION', $MODULE_NAME)} </b></div>
        
    </div>
        
              {foreach item=LIST from=$DATA}
                  <div class="row miniListContent" style="padding:5px;margin-right:-1px;margin-left:-1px;">
                        <div class="col-md-4 ">   <b> {$LIST['first_name']}  {$LIST['last_name']} </b> </div>
                        <div class="col-md-4">     {$LIST['department']}       </div>
                        <div class="col-md-4">     {$LIST['designation']}   
                            <a class="pull-right" href="{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$LIST['empid']}">
                                <i class="fa fa-link"></i>
                            </a> 
                        </div>                        
                   </div>
            {/foreach}
   

{else}
        <span class="noDataMsg">
       {vtranslate('LBL_NOT_FOUND','Home')} {vtranslate($TYPELABEL,'Home')}
        </span>
{/if}
</div>

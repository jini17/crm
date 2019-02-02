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
<div class="dashboardWidgetContent">
    <div class="contaier-fluid">
	{if count($DATADETAILS) > 0}
            <div class="row th" style="margin:0; padding-top: 5px; padding-bottom: 5px;">
                <div class="col-md-3"><b>{vtranslate('LBL_PLAN', 'Home')}</b></div>
                <div class="col-md-3"><b>{vtranslate('LBL_NO_USERS', 'Home')}</b></div>
                <div class="col-md-6"><b>{vtranslate('LBL_DURATION', 'Home')}</b></div>
            </div>    
          
                	{foreach item=MODEL key=k from=$DATADETAILS}
                              <div class="row miniListContent" style="margin:0; padding-top: 5px; padding-bottom: 5px;">
                <div class="col-md-3 col-sm-3 col-xs-3 " style=''>{$k}</div>
                 <div class="col-md-3 col-sm-3 col-xs-3 text-center">{$MODEL[0]}</div>
                  <div class="col-md-6 col-sm-6 col-xs-6 ">{$MODEL[1]|date_format} - {$MODEL[2]|date_format}</div>
                
                    </div>
                    <div class="clearfix"></div>
                  {/foreach}
          
	
{/if}
</div>
</div>
<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
    </div>		
</div>
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
<div class="dashboardWidgetHeader clearfix">
    <div class="title">
        <div class="dashboardTitle" title="{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}">{vtranslate($WIDGET->getTitle())}</div>
    </div>
  <div class="filterContainer">
      <div class="row">
           <div class="col-lg-6">
               <select class="select2 col-lg-12 widgetFilter "  name="department" >
                <option value="">{vtranslate('LBL_COMPANY', $MODULE_NAME)}</option> 
                {foreach item=DEPT from=$DEPARTMENT}
                <option value="{$DEPT}" {if $VALUE eq $DEPT}selected{/if}>{$DEPT}</option> 
                {/foreach}
              </select>
           </div>
              <div class="col-lg-6">   
                  <select class="select2 col-lg-12 widgetFilter" id="duration" name="type">
                    <option value="today" selected>{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
                    <option value="tomorrow" >{vtranslate('LBL_TOMORROW',$MODULE_NAME)}</option>
                    <option value="thisweek" selected>{vtranslate('LBL_THIS_WEEK',$MODULE_NAME)}</option>
                    <option value="nextweek" >{vtranslate('LBL_NEXT_WEEK',$MODULE_NAME)}</option>   
                    <option value="thismonth">{vtranslate('LBL_THIS_MONTH',$MODULE_NAME)}</option>
                </select>
            </div>
        </div>
      </div>    
</div>  

<div class="dashboardWidgetContent mCustomScrollbar _mCS_5" style="height:200px;">
	{include file="dashboards/ColleaguesContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
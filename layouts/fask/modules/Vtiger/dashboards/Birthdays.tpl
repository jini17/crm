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
                 <select class="select2 col-lg-10 widgetFilter" id="userGroup" name="group">
                    <option value="user" selected>{vtranslate('LBL_USER',$MODULE_NAME)}</option>           
                    <option value="customer">{vtranslate('LBL_CUSTOMER',$MODULE_NAME)}</option>  
                 </select>
              </div>
              <div class="col-lg-6">
                  <select class="select2 col-lg-10 widgetFilter" id="historyType" name="type">
                    <option value="today" >{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
                    <option value="tomorrow" >{vtranslate('LBL_TOMORROW',$MODULE_NAME)}</option>
                    <option value="thisweek" >{vtranslate('LBL_THIS_WEEK',$MODULE_NAME)}</option>
                    <option value="nextweek" >{vtranslate('LBL_NEXT_WEEK',$MODULE_NAME)}</option>   
                    <option value="thismonth" selected>{vtranslate('LBL_THIS_MONTH',$MODULE_NAME)}</option> 
                 </select>
              </div>
          </div>
      </div>
</div>
  
<div class="dashboardWidgetContent dashboardWidget" style="padding:5px;">
	{include file="dashboards/BirthdaysContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">


  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>

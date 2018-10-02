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
EmployeeChartByDept
<div class="dashboardWidgetHeader">
        {include file="dashboards/WidgetHeader.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
</div>

<div class="dashboardWidgetContent">
        {include file="dashboards/EmployeeChartByDeptContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
        <div class="filterContainer">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-lg-7">
                 {*  <select class="widgetFilter select2" id="duration" name="type" style='width:100%;'>
                                                <option value="today" selected>{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
                                                <option value="tomorrow" >{vtranslate('LBL_TOMORROW',$MODULE_NAME)}</option>
                                                <option value="thisweek" >{vtranslate('LBL_THIS_WEEK',$MODULE_NAME)}</option>
                                                <option value="nextweek" >{vtranslate('LBL_NEXT_WEEK',$MODULE_NAME)}</option>		
                                                <option value="thismonth">{vtranslate('LBL_THIS_MONTH',$MODULE_NAME)}</option>

                                        </select>*}
                </div>
            </div>
        </div>

  </div>

  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
  </div>
</div>



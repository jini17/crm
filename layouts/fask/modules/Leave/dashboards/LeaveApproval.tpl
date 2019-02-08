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

<div class="dashboardWidgetHeader">
	{include file="dashboards/WidgetHeader.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
  <div class="filterContainer">
        <div class="row">
            <div class="col-lg-12">
              <select class="widgetFilter select2 col-lg-12" id="duration" name="type" width='100%'>
                  <option value="today" >{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
                  <option value="tomorrow" >{vtranslate('LBL_TOMORROW',$MODULE_NAME)}</option>
                  <option value="thisweek" selected>{vtranslate('LBL_THIS_WEEK',$MODULE_NAME)}</option>
                  <option value="nextweek" >{vtranslate('LBL_NEXT_WEEK',$MODULE_NAME)}</option>   
                  <option value="thismonth">{vtranslate('LBL_THIS_MONTH',$MODULE_NAME)}</option>
              </select>
            </div>
        </div>
  </div>
</div>


<div class="dashboardWidgetContent">
	{include file="dashboards/LeaveApprovalContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>


            <a  onclick="window.location.href='index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USERID}&tab=ListClaim'" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>

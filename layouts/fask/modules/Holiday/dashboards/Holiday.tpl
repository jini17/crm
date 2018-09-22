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
</div>

<div class="dashboardWidgetContent mCustomScrollbar" style="height:250px;">
	{include file="dashboards/HolidayContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="filterContainer">
       <div class="row">
            <div class="col-sm-12">
                <div class="col-lg-7">
                   <select class="widgetFilter select2" id="month" name="type" style='width:100%;'>
                    <option value="" selected>{vtranslate('LBL_SELECT_ALL',$MODULE_NAME)}</option>
                      <option value="1" >{vtranslate('LBL_JANUARY',$MODULE_NAME)}</option>
                      <option value="2" >{vtranslate('LBL_FEBRUARY',$MODULE_NAME)}</option>
                      <option value="3" >{vtranslate('LBL_MARCH',$MODULE_NAME)}</option>
                      <option value="4" >{vtranslate('LBL_APRIL',$MODULE_NAME)}</option>
                      <option value="5" >{vtranslate('LBL_MAY',$MODULE_NAME)}</option>
                      <option value="6" >{vtranslate('LBL_JUNE',$MODULE_NAME)}</option>
                      <option value="7" >{vtranslate('LBL_JULY',$MODULE_NAME)}</option>
                      <option value="8" >{vtranslate('LBL_AUGUST',$MODULE_NAME)}</option>
                      <option value="9" >{vtranslate('LBL_SEPTEMBER',$MODULE_NAME)}</option>
                      <option value="10" >{vtranslate('LBL_OCTOBER',$MODULE_NAME)}</option>
                      <option value="11" >{vtranslate('LBL_NOVEMBER',$MODULE_NAME)}</option>
                      <option value="12" >{vtranslate('LBL_DECEMBER',$MODULE_NAME)}</option>
                  </select>
                </div>
            </div>
        </div>

  </div>
</div>
 
<div class="dashboardWidgetContent mCustomScrollbar _mCS_5" style="height:200px;">
	{include file="dashboards/HolidayContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>


<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>



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

    <div class="filterContainer">
        
        <div class="row">
            <div class="col-sm-12">
               <div class="col-lg-6">
                <label class="radio-group cursorPointer">
                    <input type="radio" id="myleavetype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="leavetype" checked="true" /> {vtranslate('LBL_LEAVE_TYPE', $MODULE_NAME)}
                </label>
              </div>
                <div class="col-lg-6">
                   <label class="radio-group cursorPointer">
                      <input type="radio" id="leave5" name="type" class="widgetFilter reloadOnChange cursorPointer" value="latest" /> 
                      <span>{vtranslate('LBL_LAST_5_LEAVES', $MODULE_NAME)}</span>
                    </label>
                </div>
            </div> 
            <div class='clearfix'></div>
        </div>
    </div>    
<hr >
<div class="dashboardWidgetContent mCustomScrollbar _mCS_5" style="height:200px;">
  {include file="dashboards/MyLeavesContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
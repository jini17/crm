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
                       <select class="widgetFilter select2" id="department" name="department" style="width:100%;">
                        <option value=""> All </option>
                        {foreach item=DEPT from=$DEPARTMENT}
                            <option value="{$DEPT}"> {$DEPT} </option>
                        {/foreach}    
                      <!--  <option value="horizontalbarChart"> Horizontalbar Chart</option>-->
                      </select>
                </div>
        </div>

  </div>
</div>

<div class="dashboardWidgetContent" style="widht:300px;height:300px;">
	{include file="dashboards/EmployeeChartByDeptContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	

  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>



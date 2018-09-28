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
           <div class="col-lg-6">
            <label class="radio-group cursorPointer">
                <input type="radio" id="myteamclaimtype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="claimtype" checked="true" /> {vtranslate('LBL_CLAIM_TYPE', $MODULE_NAME)}
            </label>
          </div>
          <div class="col-lg-6">
             <label class="radio-group cursorPointer">
                <input type="radio" id="pending" name="type" class="widgetFilter reloadOnChange cursorPointer" value="pending" /> 
                <span>{vtranslate('LBL_PENDING_APPROVAL', $MODULE_NAME)}</span>
              </label>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
              <select class="widgetFilter select2 col-lg-7" id="employee_name" name="employee_name">
                <option value="All" selected>{vtranslate('All', $MODULE_NAME)}</option>
                {foreach item = USERMODEL from = $USERMODELS }
                  <option value="{$USERMODEL['id']}">{$USERMODEL['fullname']}</option>
                {/foreach}
              </select>
            </div>
        </div>
  </div>
</div>


<div class="dashboardWidgetContent mCustomScrollbar _mCS_5">
	{include file="dashboards/MyTeamClaimContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>



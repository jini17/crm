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
          <div class="col-sm-12" id="department_dropdown">
            <select class="select2 widgetFilter col-lg-12"  name="department" >
              <option value="">{vtranslate('LBL_COMPANY', $MODULE_NAME)}</option>	
              {foreach item=DEPT from=$DEPARTMENT}
              <option value="{$DEPT}" {if $VALUE eq $DEPT}selected{/if}>{$DEPT}</option> 
              {/foreach}
            </select>
          </div>  
      </div>
  </div>    
</div>
<div class='row th' style="padding:5px">
      <div class='col-lg-5'>
       <strong>{vtranslate('LBL_NAME', $MODULE_NAME)}</strong>


      </div>
      <div class='col-lg-4'>
         <strong>{vtranslate('LBL_DEPARTMENT', $MODULE_NAME)}</strong>
      </div>
      <div class='col-lg-3'>
        <strong>{vtranslate('LBL_MC_TAKEN', $MODULE_NAME)}</strong>
      </div>
</div>
<div class="dashboardWidgetContent mCustomScrollbar _mCS_5" style="height:200px;">
	{include file="dashboards/TopNoMCEmployeesContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
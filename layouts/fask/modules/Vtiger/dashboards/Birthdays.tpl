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

<div class="dashboardWidgetContent" id="birthdayContents">
	{include file="dashboards/BirthdaysContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="filterContainer">
        <div class="row">
            <div class="col-sm-12">
                <div style="display:block;">
                   
                
                   <select class="select2 widgetFilter" id="historyType" name="type" style='width:150px;float:right' >
          						<option value="today" >{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
          						<option value="tomorrow" >{vtranslate('LBL_TOMORROW',$MODULE_NAME)}</option>
          						<option value="thisweek" >{vtranslate('LBL_THIS_WEEK',$MODULE_NAME)}</option>
          						<option value="nextweek" >{vtranslate('LBL_NEXT_WEEK',$MODULE_NAME)}</option>		
          						<option value="thismonth" selected>{vtranslate('LBL_THIS_MONTH',$MODULE_NAME)}</option>	
					         </select>
                   <select class="select2 widgetFilter" id="userGroup" name="group" style='width:120px;float:right'>
                      <option value="user" selected>{vtranslate('LBL_USER',$MODULE_NAME)}</option>           
                      <option value="customer">{vtranslate('LBL_CUSTOMER',$MODULE_NAME)}</option>  
                   </select>
                </div>
            </div>
        </div>
    </div>

  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
  </div>
</div>
{literal}
<!-- Added by jitu@secondcrm for common Select2 Class
<script>
	jQuery(document).ready(function(e){ 
		$("#userGroup").select2({ width: '100px'});
		$("#historyType").select2({ width: '100px'});
	})
</script>
<!-- End Here --->
{/literal}

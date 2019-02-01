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
     <div class="title">
        <div class="dashboardTitle" title="{vtranslate('Getting Started', $MODULE_NAME)}">{vtranslate('Getting Started')}</div>
    </div>
</div>


<div class="dashboardWidgetContent  dashboardWidget" >
        {include file="dashboards/GettingStartedWidgetContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
      <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
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

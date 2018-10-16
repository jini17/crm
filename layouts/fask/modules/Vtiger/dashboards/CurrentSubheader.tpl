<div class="dashboardWidgetHeader clearfix">
    <div class="title">
        <div class="dashboardTitle" title="{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}"><b>&nbsp;{vtranslate($WIDGET->getTitle())}</b></div>
    </div>
</div>   
<div class="dashboardWidgetContent" style="padding-top:15px;">
	{include file="dashboards/CurrentSubscription.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
    </div>		
</div>
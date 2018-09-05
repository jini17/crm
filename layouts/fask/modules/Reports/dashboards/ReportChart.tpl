{************************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************}
<!--//ADDED BY SAFUAN@SECONDCRM.COM- #dashreportchart-->
<div class="dashboardWidgetHeader">
	{include file="dashboards/WidgetHeader.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
<style>
.ChartWidgetContent {
	padding : 0px 10px;
}
</style>
<div class="ChartWidgetContent">
	{include file="dashboards/ReportChartContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

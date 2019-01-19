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
<div class="dashboardWidgetContent">

	{if count($DATADETAILS) > 0}
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>
				<b>{vtranslate('LBL_PLAN', 'Home')}</b>
				</th>
				<th>
				<b>{vtranslate('LBL_NO_USERS', 'Home')}</b>
				</th>
				<th>
				<b>{vtranslate('LBL_DURATION', 'Home')}</b>
				</th>
			</tr>
		</thead>
		<tbody>
			{foreach item=MODEL key=k from=$DATADETAILS}
				<tr>
					<td>
					{$k}
					</td>
					<td>
					{$MODEL[0]}
					</td>
					<td>
					{$MODEL[1]} - {$MODEL[2]}
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
{/if}
</div>
<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
    </div>		
</div>
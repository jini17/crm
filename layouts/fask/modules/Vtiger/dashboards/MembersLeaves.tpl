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
{*
<div class="dashboardWidgetHeader">
	<table width="100%" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="span4">
				<div class="dashboardTitle" title="{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}"><b>&nbsp;&nbsp;{vtranslate($WIDGET->getTitle(),$MODULE_NAME)}</b></div>
			</th>
			<th class="span4">
				<select class="widgetFilter" id="memberuserGroup" name="group" style='width:90px;margin-bottom:0px;margin-left:10px;'>
					<option value="all" >{vtranslate('LBL_ALL',$MODULE_NAME)}</option>					 
					<option value="myteam" >{vtranslate('LBL_MYTEAM',$MODULE_NAME)}</option>	
				</select>
			</th>
			
			<th class="span4">	
				<select class="widgetFilter" id="duration" name="duration" style='width:90px;margin-bottom:0px;margin-left:2px;'>
					<option value="today" >{vtranslate('LBL_TODAY',$MODULE_NAME)}</option>
					<option value="nextsevendays" >{vtranslate('LBL_NEXTSEVENDAYS',$MODULE_NAME)}</option>
					<option value="nextthirtydays" >{vtranslate('LBL_NEXTTHIRTYDAYS',$MODULE_NAME)}</option>
					</select>
			</th>
			<th class="widgeticons span5" align="right">
				{include file="dashboards/DashboardHeaderIcons.tpl"|@vtemplate_path:$MODULE_NAME}
			</th>
		</tr>
	</thead>
	</table>
</div>
<div class="dashboardWidgetContent">
	{include file="dashboards/MembersLeavesContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>
{literal}
<!-- Added by jitu@secondcrm for common Select2 Class
<script>
	jQuery(document).ready(function(e){ 
		$("#memberuserGroup").select2({ width: '100px'});
		$("#duration").select2({ width: '100px'});
	})
</script>
<!-- End Here --->
{/literal}
*}
Member Leave
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
	        
    <div class="title clearfix"  id="quickCreateMessage" style="margin-bottom: 0;">
        <div class="dashboardTitle" title="{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}" style="width: 25em;">{vtranslate($WIDGET->getTitle(), $MODULE_NAME)|@escape:'html'}</div>
   {if $ALLOWCREATE}     
   <a id="quickCreate_MessageBoard" style="margin-top: -22px; margin-bottom: 0; z-index: 1; position: absolute;right: 92px;top: 25px;"   class="quickCreateModule btn btn-primary pull-right" 
      data-name="MessageBoard"  
      data-url="index.php?module=MessageBoard&amp;view=QuickCreateAjax" 
      href="javascript:void(0)">Create Message</a> 
   {/if}   
    </div>    

        <div class="clearfix"></div>
</div>
<div class="dashboardWidgetContent">

	{include file="dashboards/MessageBoardContents.tpl"|@vtemplate_path:$MODULE_NAME}
                           

</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>


      <a href="index.php?module=MessageBoard&view=List" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>
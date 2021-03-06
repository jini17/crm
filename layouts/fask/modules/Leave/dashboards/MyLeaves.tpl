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
  <div class="filterContainer">
        <div class="row" style="margin-left:3px;">
               <div class="col-md-8" style="padding-left: 9px">
                
                <label class="radio-group cursorPointer" style="font-size:13px; padding:13px 0px 0 0;">
                    <input style="vertical-align:middle;" type="radio" id="myleavetype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="leavetype" checked="checked" / >&nbsp;&nbsp;{vtranslate('LBL_LEAVE_TYPE', $MODULE_NAME)}
                </label>&nbsp;&nbsp;
                
                <label class="radio-group cursorPointer" style="font-size:13px;padding:5px;">
                      <input style="vertical-align:middle;"  type="radio" id="leave5" name="type" class="widgetFilter reloadOnChange cursorPointer" value="latest" />&nbsp; 
                      <span>{vtranslate('LBL_LAST_5_LEAVES', $MODULE_NAME)}</span>
                </label>
             </div>

             {if $MODELS['balance'] gt 0}
               <div class="col-md-4 pull-right"  style="padding:5px;"><input type="button" class="btn btn-primary" onclick="Users_Leave_Js.addLeave('?module=Users&view=EditLeave&userId={$USERID}');" name="applyleave" value="{vtranslate('LBL_APPLY', $MODULE_NAME)}">
               </div>
             {/if}
            <div class='clearfix'></div>
      </div>    
   </div>

<div class="dashboardWidgetContent">
  {include file="dashboards/MyLeavesContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
 
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
              <a  onclick="window.location.href='index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USERID}&tab=ListLeave'" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>

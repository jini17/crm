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
            <div class="col-lg-8" style="padding-left: 9px;">
                <label class="radio-group cursorPointer" style="font-size:13px; padding:13px 0px 0 0;"> 
                    <input type="radio" id="myclaimtype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="claimtype" checked="true" />&nbsp;&nbsp; {vtranslate('LBL_CLAIM_TYPE', $MODULE_NAME)}
                </label>&nbsp;&nbsp;
               <label class="radio-group cursorPointer" style="font-size:13px; padding:5px;">
                  <input type="radio" id="claim5" name="type" class="widgetFilter reloadOnChange cursorPointer" value="latestclaim" /> 
                  <span>&nbsp;{vtranslate('LBL_LAST_5_CLAIM', $MODULE_NAME)}</span>
                </label>
              </div>
             
               <div class="col-lg-4 pull-right" style="padding:5px;"><input type="button" class="btn btn-primary" onclick="Users_Claim_Js.addClaim('?module=Users&view=EditClaim&userId={$USERID}');" name="applyclaim" value="{vtranslate('LBL_APPLY', $MODULE_NAME)}"></div>
             
            <div class='clearfix'></div>
      </div>    
   </div>
<div class="dashboardWidgetContent">
  {include file="dashboards/MyClaimContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
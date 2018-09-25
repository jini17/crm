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
        
        <div class="row">
               <div class="col-lg-6">
                <label class="radio-group cursorPointer">
                    <input type="radio" id="myclaimtype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="claimtype" checked="true" /> {vtranslate('LBL_CLAIM_TYPE', $MODULE_NAME)}
                </label>
              </div>
                <div class="col-lg-6">
                   <label class="radio-group cursorPointer">
                      <input type="radio" id="claim5" name="type" class="widgetFilter reloadOnChange cursorPointer" value="latestclaim" /> 
                      <span>{vtranslate('LBL_LAST_5_CLAIM', $MODULE_NAME)}</span>
                    </label>
                </div>
             {if $MODELS['balance'] gt 0}
               <div class="col-lg-4 pull-right"><input type="button" class="btn btn-primary" style="padding:5px;" onclick="window.location.href='index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USERID}'" name="applyleave" value="{vtranslate('LBL_APPLY', $MODULE_NAME)}"></div>
             {/if}
            <div class='clearfix'></div>
      </div>    
   </div>
 <hr >
<div class="dashboardWidgetContent mCustomScrollbar _mCS_5">
  {include file="dashboards/MyClaimContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>
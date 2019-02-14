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
<div class="dashboardWidgetHeader" id="widgetheader">
	{include file="dashboards/WidgetHeader.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
</div>

<div class="dashboardWidgetContent">
	{include file="dashboards/DocumentExpiringContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="filterContainer">
        
        <div class="row">
            <div class="col-lg-6">
               <div class="col-sm-12">
                <label class="radio-group cursorPointer">
                    <input type="radio" id="contracts" name="type" class="widgetFilter reloadOnChange cursorPointer" value="contract" checked="checked" /> Expiring Contracts
                </label>
              </div>
                <div class="col-sm-12">
                   <label class="radio-group cursorPointer">
                      <input type="radio" id="passport" name="type" class="widgetFilter reloadOnChange cursorPointer" value="passport" /> 
                      <span>Expiring Passport</span>
                    </label>
                </div>
                <div class="col-sm-12">
                   <label class="radio-group cursorPointer">
                      <input type="radio" id="visa" name="type" class="widgetFilter reloadOnChange cursorPointer" value="visa" /> 
                      <span>Expiring Visa</span>
                    </label>
                </div>
            </div>             
        </div>
    </div>    


  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
  </div>
</div>
<script>
  jQuery(document).ready(function(){
    
    $("#contracts").on('click',function(){
      //
       jQuery('#widgetheader .dashboardTitle').html(app.vtranslate('Employee Contract Expiring'));
    });

    $("#passport").on('click',function(){
      //
       jQuery('#widgetheader .dashboardTitle').html(app.vtranslate('Employee Passport Expiring'));
    });

      $("#visa").on('click',function(){
      //
       jQuery('#widgetheader .dashboardTitle').html(app.vtranslate('Employee Visa Expiring'));
    });
  })
</script>  
                        <a href="index.php?module=EmployeeContract&view=List&block=15&fieldid=53" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>

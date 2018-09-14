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

<div class="dashboardWidgetContent">
	{include file="dashboards/MyLeavesContent.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	<div class="filterContainer">
        
        <div class="row">
            <div class="col-sm-12">
                <label class="radio-group cursorPointer">
                    <input type="radio" id="myleavetype" name="type" class="widgetFilter reloadOnChange cursorPointer" value="leavetype" checked="checked" /> {vtranslate('LBL_LEAVE_TYPE', $MODULE_NAME)}
                </label>
                
               
                 <label class="radio-group cursorPointer">
                    <input type="radio" id="leave5" name="type" class="widgetFilter reloadOnChange cursorPointer" value="latest" /> 
                    <span>{vtranslate('LBL_LAST_5_LEAVES', $MODULE_NAME)}</span>
                </label>
            </div> 
            <div class='clearfix'></div>
            <div class="col-sm-12" id="leave_type_dropdown">
              <select class="select2 widgetFilter"  name="group" style='width:120px;'>
                {foreach item=LEAVE_TYPE from=$LEAVE_TYPE_LIST}
                <option value="{$LEAVE_TYPE['title']}">{$LEAVE_TYPE['title']}</option> 
                {/foreach}
              </select>
            </div>  
        </div>
     

    </div>    


  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=true}
  </div>
</div>
<script>
  jQuery(document).ready(function(){
    $("#leave5").on('click',function(){
      
       jQuery('#leave_type_dropdown').hide('slow');
    });
      $("#myleavetype").on('click',function(){
      
       jQuery('#leave_type_dropdown').show('slow');
    });
  })
</script>  


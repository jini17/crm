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
<script type="text/javascript">
  Vtiger_History_Widget_Js('Vtiger_ListOfEmployee_Widget_Js', {}, {});
</script>
<div class="dashboardWidgetHeader">
     <div class="title">
        <div class="dashboardTitle" title="{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}">{vtranslate($WIDGET->getTitle())}</div>
    </div>
  <div class="filterContainer">
        <div class="row">
               <div class="col-lg-12">
                    <select class="widgetFilter select2" id="department" name="department" style="width:100%;">
                        <option value=""> All</option>
                        {foreach item=DEPT key=k from=$DEPARTMENT}
                            <option value="{$k}"> {$DEPT}</option>
                        {/foreach}    
                       
                      <!--  <option value="horizontalbarChart"> Horizontalbar Chart</option>-->
                      </select>
                </div>
        </div>
  </div>
</div>
                        
<div class="dashboardWidgetContent dashboardWidget" style="padding:5px;">
        {include file="dashboards/ListOfEmployeeContents.tpl"|@vtemplate_path:$MODULE_NAME}
</div>

<div class="widgeticons dashBoardWidgetFooter">
	
  <div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
  </div>
</div>


   <a href="index.php?module=Users&view=List&parent=Settings" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>
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
	<div class="feature-box feature-box-style-5">
		<div class="feature-box-info col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;">
			{if $DATADETAILS['Foundation']}
				<div class="col-md-1" style="padding-right: 0px !important;padding-left: 0px !important;"><i class="fa fa-briefcase"></i></div>
				<div class="col-md-11" style="padding-right: 0px !important;padding-left: 0px !important;">
					<div style="padding-right: 0px !important;padding-left: 0px !important;display: inline-block;float: left;margin-right: 15px !important;">
						<p class="mb-sm text-uppercase"><strong>{vtranslate('Foundation', 'Home')}&nbsp;&nbsp;User:</strong>
						</p>

					</div>
					<div style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;display: inline-block;">
						<p class="mb-lg">{$DATADETAILS['Foundation']}</p>
					</div>
				</div>
			{/if}
		</div>
		<div class="feature-box-info col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;">
			{if $DATADETAILS['Sales'] || $DATADETAILS['Support'] || $DATADETAILS['Enterprise']}
			<div class="col-md-1" style="padding-right: 0px !important;padding-left: 0px !important;"><i class="fa fa-users"></i>
			</div>
			<div class="col-md-11" style="padding-right: 0px !important;padding-left: 0px !important;">
				<div class="col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;display: inline-block;float: left;margin-right: 15px !important;">
					<p class="mb-sm text-uppercase"><strong>Add-On's:</strong></p>
				</div>
			{/if}
				<div class="col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;display: inline-block;">
					{if $DATADETAILS['Sales']}
					<div class="col-md-4" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;">
						<div style="margin-right: 20px !important; padding-left: 0px !important;text-align: left;border-bottom: 2px solid #ffc400; border-right: 2px solid #ffc400;">
								<p class="mb-lg" style="display: inline-block;"><strong>{vtranslate('Sales', 'Home')}</strong></p>
								<p style="float: right;padding:0px 20px 0px 0px ">{$DATADETAILS['Sales']}</p>
						</div>
					</div>
					
					{/if}
					{if $DATADETAILS['Support']}
					<div class="col-md-4" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;">
						<div style="margin-right: 20px !important; padding-left: 0px !important;text-align: left;border-bottom: 2px solid #40e0d0; border-right: 2px solid #40e0d0;">
								<p class="mb-lg" style="display: inline-block;"><strong>{vtranslate('Support', 'Home')}</strong></p>
								<p style="float: right;padding:0px 20px 0px 0px ;display: inline-block;">{$DATADETAILS['Support']}</p>
						</div>
					</div>

					{/if}
					{if $DATADETAILS['Enterprise']}
					<div class="col-md-4" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;">
						<div style="margin-right: 20px !important; padding-left: 0px !important;text-align: left;border-bottom: 2px solid #b382c7; border-right: 2px solid #b382c7;">
								<p class="mb-lg" style="display: inline-block;"><strong>{vtranslate('Enterprise', 'Home')}</strong></p>
								<p style="float: right;padding:0px 20px 0px 0px ;display: inline-block;">{$DATADETAILS['Enterprise']}</p>
						</div>
					</div>
			
					{/if}

				</div>
			</div>
		</div>
		
	</div>
	<div class="col-md-12" style="vertical-align: bottom;position: absolute;bottom: 0;right: 0;padding: 5px !important;font-size: 12.3px;"> 
		<div class="feature-box feature-box-style-5">
			<div class="feature-box-info">
				<p class="mb-lg">Your subscription is started at <strong><i>{$DATADETAILS['startdate']}</i></strong> and will expire on <strong><i>{$DATADETAILS['enddate']}</i></strong>.
					{if $DATADETAILS['btnrenew'] eq 1}
					<button class="btn cpsubscription" onclick="javascript:Vtiger_Widget_Js.registerRenewSubscription('{$SHORTNAME}');" name="renewsubscription">Renew Now</button> 
					{/if}
				</p>
			</div>
		</div>
	</div>
</div>
<div class="widgeticons dashBoardWidgetFooter">
	<div class="footerIcons pull-right">
        {include file="dashboards/DashboardFooterIcons.tpl"|@vtemplate_path:$MODULE_NAME SETTING_EXIST=false}
    </div>		
</div>
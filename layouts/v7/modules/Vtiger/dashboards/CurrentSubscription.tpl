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
				<div class="col-md-6" style="padding-right: 0px !important;padding-left: 0px !important;">
					<p class="mb-sm text-uppercase"><strong>{vtranslate('Foundation', 'Home')}&nbsp;&nbsp;User:</strong>
					</p>

				</div>
				<div class="col-md-4" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;">
					<p class="mb-lg">{$DATADETAILS['Foundation']}</p>
				</div>
			{/if}
		</div>
		<div class="feature-box-info col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;">
			{if $DATADETAILS['Sales'] || $DATADETAILS['Support'] || $DATADETAILS['Enterprise']}
			<div class="col-md-1" style="padding-right: 0px !important;padding-left: 0px !important;"><i class="fa fa-users"></i>
			</div>
			<div class="col-md-6" style="padding-right: 0px !important;padding-left: 0px !important;">
				<p class="mb-sm text-uppercase">Add-On's</p>
			</div>
			{/if}
			<div class="col-md-4" style="padding-right: 0px !important;padding-left: 0px !important;text-align: left;">
				{if $DATADETAILS['Sales']}
				<div>
					<p class="mb-lg"><strong>{vtranslate('Sales', 'Home')}:</strong>{$DATADETAILS['Sales']}</p>
				</div>
				{/if}
				{if $DATADETAILS['Support']}
				<div>
					<p class="mb-lg"><strong>{vtranslate('Support', 'Home')}:</strong>{$DATADETAILS['Support']}</p>
				</div>
				{/if}
				{if $DATADETAILS['Enterprise']}
				<div>
					<p class="mb-lg"><strong>{vtranslate('Enterprise', 'Home')}:</strong>{$DATADETAILS['Enterprise']}</p>
				</div>
				{/if}

			</div>
		</div>
		
	</div>
	<div class="col-md-12" style="padding-right: 0px !important;padding-left: 0px !important;"> 
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
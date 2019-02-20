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

<style>
table.responsive {
color:#000;
font-size:12px;	
}
h2 { font-size:14px !important;}
div.control-label, div.controls>span { font-size:13px;}
</style>
{strip} 
{if $RESULT_REPORTS|count eq 0}
	
	<div style="background:#dfdfdf;color: #333; width: 350px; margin: 0 auto; padding: 10px; border-radius: 4px;"><center>{vtranslate('LBL_NO_DATA_FOUND',$MODULE)}</center></div>		
	
{else}
	{foreach key=mainkey item=colsData from=$RESULT_REPORTS}
		<div style="overflow-x:scroll;">
		{foreach key=MAINHEAD item=RAWDATA from=$colsData}
			<div class="dashboardHeading" title="{$MAINHEAD}"><h2 display:block;">{$MAINHEAD|substr:0:70}{if $MAINHEAD|count_characters gt 70}...{/if}</h2></div>
		{/foreach}
		<table class="table table-bordered responsive">
		<thead>
			
			
			<tr>
				{foreach key=k item=header from=$HEADERCOL}
					{if $k gt 1}
						<th colspan="2" style="vertical-align: middle;text-align:center;">{$header}</th>
					{else}
						<th rowspan="2" style="vertical-align: middle;text-align:center;">{$header}</th>	
					{/if}
				{/foreach}
			</tr>
			<tr>
				{for $i=1 to ($HEADERCOL|count-2)}
					<th style="border-left: 1px solid #ddd;text-align:center;">{vtranslate('LBL_ACTUAL',$MODULE)}</th>
					<th style="text-align:center;">{vtranslate('LBL_TARGET',$MODULE)}</th>
				{/for}
				
			</tr>
			
		</thead>	
		<tbody>
			{for $step=0 to $RAWDATA|count} 
				{if $RAWDATA[$step]|count >0}
				<tr>
					{foreach key=k item=header from=$HEADERCOL}
						{if $k gt 1} 
							<td>{$RAWDATA[$step][$header]['Actual']}</td>
							<td>{$RAWDATA[$step][$header]['Target']}</td>
						{else} 
							<td title="{$RAWDATA[$step][$header]}">{$RAWDATA[$step][$header]|substr:0:70}{if $RAWDATA[$step][$header]|count_characters gt 70}...{/if}</td>
						{/if}	
					{/foreach}
				</tr>
				{/if}
			{/for}
		</tbody>	
		</table>
		</div>
		<br />
	{/foreach}
<div class="exportcontainer"></div>
{/if}
{/strip}

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
{strip} 
<style>
.exportreport{
	float:right;
	position: relative;
	top: -35px;
}
</style>	
<div class="detailViewInfo row-fluid">
	<div><button name="Export Excel" data-href="index.php?module=SalesTarget&view=ExportReport&mode=GetXLS" class="btn exportreport hide"><strong>{vtranslate('LBL_EXPORT_EXCEL',$MODULE)}</strong></button></div>
	<!--<div class="span10 details">-->					
			<!--<div class="contents">-->
				<form id="ReportView" class="form-horizontal" method="post">
					<div class="modal-body tabbable">
						<div class="control-group">
							<div class="control-label">{vtranslate('LBL_TARGET',$MODULE)}</div>
							<div class="controls">
								<!--{assign var=TARGET_VALUES value=$RESULT_TARGETS}-->
									
								<select class="chzn-select" name="targetid" id="targetid">
									<!--{*<optgroup>
										{foreach from=$TARGET_VALUES key=TARGET_KEY item=TARGET_VALUE}
											<option value="{$TARGET_VALUE['salestargetid']}">{$TARGET_VALUE['target_title']}</option>
										{/foreach}	
									</optgroup>*}-->
									{$RESULT_TARGETS}
								</select>
							</div><br>
							
							<div class="control-label">{vtranslate('Group By',$MODULE)}</div>
							<div class="controls">	
								<select class="chzn-select" name="groupby" id="groupby">
									<option value="">{vtranslate('LBL_SELECTONE',$MODULE)}</option>
									<option value="Territory">{vtranslate('LBL_Territory',$MODULE)}</option>
									<option value="UserGroup">{vtranslate('User/Group',$MODULE)}</option>
									<option value="Product">{vtranslate('Product',$MODULE)}</option>
								</select>
							</div><br>
							<div class="control-label">{vtranslate('Column By',$MODULE)}</div>
					
								<div class="controls">	
									<span>{vtranslate('Monthly',$MODULE)}</span>
									<span><input style="margin:10px 10px;" id="monthly" type="checkbox" name="monthly" value="m"></span>
								
									<span>{vtranslate('Quaterly',$MODULE)}</span>
									<span><input style="margin:10px 10px;" id="quaterly" type="checkbox" name="quaterly" value="q"></span>
								
									<span>{vtranslate('Annually',$MODULE)}</span>
									<span><input style="margin:10px 10px;" id="annually" type="checkbox" name="annually" value="a"></span>

								</div><br>
						
						<div class="row-fluid">
							<div class="pull-right">
							    <button class="btn btn-success" id="reportTarget" type=
							    "button"><strong>{vtranslate('Submit',$MODULE)}</strong></button><a class="cancelLink"
							    onclick="javascript:window.history.back();" type="reset">{vtranslate('Cancel',$MODULE)}</a>
							</div>
						</div>
						<div class="clearfix"></div>
				</form>
				<!--start table here-->
				<div class="contents-bottomscroll" id="result">
				<!--{include file='Table1.tpl'|@vtemplate_path:$MODULE}	-->
				</div>
			<!--</div>-->
	<!--</div>-->
</div>
<!--
-->
{strip}

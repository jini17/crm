{*<!--
/* ===================================================================
Modified By: Jitendra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 16 / 09 / 2014
Change Reason: Multiple Term Details Feature, File modified
=================================================================== */

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
<!--form action start-->
<style>
.ui-wrapper{
	height:100% !important;
}
</style>
<div class="container-fluid">
<form class="form-horizontal" action="index.php?parent=Settings&module=MultipleTnC&action=Save" method="post" id="massEmailForm" name="index">
	<input type="hidden" name="record" value="{$RECORD_ID}">
	<input type="hidden" name="mode" value="{$MODE}">

	<!--start edit-->
	<div class="contentsDiv span10 marginLeftZero">
		<div class="padding-left1per">
			<div class="row-fluid widget_header">
				<span class="span8"><h3>{vtranslate('LBL_TERMS', $QUALIFIED_MODULE)}</h3>{$ERRORFLAG}</span>
			</div>
			<hr />
			
				<div class="contentArea">
					<!--start select company-->
					<div class="control-group col-md-12">
						<div class="col-md-2 x-label"><span>{vtranslate('LBL_SELECT_COMPANY', $QUALIFIED_MODULE)}<span class="redColor">*</span></span>
						</div>
						<div class="controls col-md-10">
							<div class="row-fluid">
								<span class="span6">
									<select id="companylist" class="select2 col-md-4" required multiple="" name="companies[]" data-validation-engine="validate[required]">
									{foreach from=$ALL_COMPANY item=COMPANY}
									{assign var=v value=$COMPANY.organizationId|@array_search:$SELECTED_COMPANY}
									<option value="{$COMPANY.organizationId}" {if $v!==FALSE} selected="selected"{/if}>{$COMPANY.organization_title}</option>
									{/foreach}
									</select>
								</span>
							</div>
						</div>
					</div>
					<!--end select company-->

					<!--start terms title-->
					<div class="control-group col-md-12">
						<div class="col-md-2 x-label"> <span>{vtranslate('LBL_TERMS_TITLE', $QUALIFIED_MODULE)}<span class="redColor">*</span></span>
						</div>
						<div class="controls col-md-10">
							<input type="text" name="term_title" id="term_title" class="detailedViewTextBox small" required value="{$TNC_RECORD.title}" data-validation-engine="validate[required]" aria-required="true">
						</div>
					</div>
					<!--end terms title-->
					<!--start terms & cond-->
					<div class="control-group col-md-12">
							 
						<div class="col-md-2 x-label"><span>{vtranslate('LBL_TERMS', $QUALIFIED_MODULE)}</span>
						</div>
						<div class="controls col-md-10">
							<textarea style="height: 200px;" class=small id="description" name="inventory_tandc" data-validation-engine="validate[required]">{$TNC_RECORD.tandc}</textarea>
						</div>
					</div>
					<!--end terms & cond-->
					<!--start button-->
					<div class="modal-footer">
						<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
							<input class="cancelLink" style="margin:0;background:none;border:none;" title="{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_CANCEL_BUTTON_KEY', $QUALIFIED_MODULE)}" onclick="window.history.back()" type="button" name="button" value="{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}">
						</div>
						<input class="btn btn-success" title="{vtranslate('LBL_SAVE_BUTTON_LABEL', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_SAVE_BUTTON_KEY', $QUALIFIED_MODULE)}" type="submit" name="button" value="{vtranslate('LBL_SAVE_BUTTON_LABEL', $QUALIFIED_MODULE)}">
					</div>
					<!--end button-->	
				</div>

			
		</div>
	</div>
	<!--end edit-->
</form>
</div>
<!--form action end-->
	<!--{include file='JSResourcesTandc.tpl'|@vtemplate_path}-->
	<!--end-->

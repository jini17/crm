{*/**===================================================================
Modified By: Zulhisyam, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 11 / 06 / 2014
Change Reason: Multiple Terms An Conditions , New file created
===================================================================**/*}
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
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<!--Codes modified for multiple terms&conditions-->
<form action="index.php" method="post" name="terms" onsubmit="VtigerJS_DialogBox.block();">
	<input type="hidden" name="module" value="Settings">
	<input type="hidden" name="action">
	<input type="hidden" name="inv_terms_mode">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="id" value="{$ID}">
	
	<!--start details-->
	<div class="contentsDiv span10 marginLeftZero">
		<div class="padding-left1per">
			<div class="row-fluid widget_header">
				<span class="span8"><h3>{vtranslate('LBL_TERMS', $QUALIFIED_MODULE)}</h3></span>
				<span class="span4">
					<input class="btn pull-right" title="{vtranslate('LBL_EDIT_BUTTON_TITLE', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_EDIT_BUTTON_KEY', $QUALIFIED_MODULE)}" onclick="location.href='index.php?parent=Settings&module=MultipleTnC&view=Edit&block=4&fieldid=21&id={$ID}'" type="button" name="Edit" value="{vtranslate('LBL_EDIT_BUTTON_LABEL', $QUALIFIED_MODULE)}">
				</span>
			</div>
			<hr >
			<div id="CompanyDetailsContainer">
				<!--start table-->
				<table class="table table-bordered">
					<tr class="blockHeader"><th colspan="2" class="medium"><strong>{$TERMTYPE}</strong></th></tr>
					<tbody>
						<!--Add code for multiple company details-->
						<tr>
							<td width="20%" class="small cellLabel"><label class="pull-right">{vtranslate('LBL_INVENTORY_TYPE', $QUALIFIED_MODULE)}</label></td>
							<td width="80%" class="small cellText">{$TERMTYPE}</td>
						</tr>
						<tr>
							<td width="20%" class="small cellLabel"><label class="pull-right">{vtranslate('LBL_TERMS_TITLE', $QUALIFIED_MODULE)}</label></td>
							<td width="80%" class="small cellText">{$TERMTITLE}</td>
						</tr>
						<tr>
							<td width="20%" class="small cellLabel"><label class="pull-right">{vtranslate('LBL_TERMS', $QUALIFIED_MODULE)}</label></td>
							<td width="80%" class="small cellText">{$TERMTANDC}</td>
						</tr>
						<tr>
							<td width="20%" class="small cellLabel"><label class="pull-right">{vtranslate('LBL_SELECTED_COMPANY',$QUALIFIED_MODULE)}</label></td>
							<td width="80%" class="small cellText">{$SELECTED_COMPANY}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!--end details-->
</form>

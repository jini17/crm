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
<form action="index.php" method="post" name="company" onsubmit="VtigerJS_DialogBox.block();">
	<input type="hidden" name="module" value="Vtiger">
	<input type="hidden" name="parent" value="Settings">
	<input type="hidden" name="action">
	<!--Code added for multiple company-->
	<input type="hidden" name="organizationid" value="{$ORGANIZATIONID}"><!--Add code for multiple company details-->
	<!--End code here-->

	<!--start details-->
	<div class="contentsDiv span10 marginLeftZero">
		<div class="padding-left1per">
			<div class="row-fluid widget_header">
				<span class="span8"><h3>{vtranslate('LBL_COMPANY_DETAILS', $QUALIFIED_MODULE)} </h3></span>
				<span class="span4">
					<input class="btn pull-right editButton" title="{vtranslate('LBL_EDIT_BUTTON_TITLE', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_EDIT_BUTTON_KEY', $QUALIFIED_MODULE)}" onclick="location.href='index.php?parent=Settings&module=MultipleCompany&view=Edit&block=3&fieldid=14&organizationid={$ORGANIZATIONID}'" type="button" name="Edit" value="{vtranslate('LBL_EDIT_BUTTON_LABEL', $QUALIFIED_MODULE)}" >
				</span>
			</div>
			<hr >
			<div id="CompanyDetailsContainer">
				<!--start table-->
				<table class="table table-bordered-white">
					<thead>
						<tr class="blockHeader">
							<th colspan="2" class="medium"><strong>Company Logo</strong></th>
						</tr>
					</thead>
					<tbody>
						<!--start company logo-->
						<tr>
							<td class="medium">
								<div class="companyLogo"><img style="height:auto;max-height:60px;max-width:auto;" src="{$ORGANIZATIONLOGOPATH}/{$ORGANIZATIONLOGONAME}" class="alignMiddle"></div>
							</td>
						</tr>
						<!--end company logo-->
					</tbody>
				</table>
				<table class="table table-bordered-white">
					<tr class="blockHeader"><th colspan="2" class="medium"><strong>Company Information</strong></th></tr>
					<tbody>
						<!--Add code for multiple company details-->
						<tr>
							<td width="15%" class="small cellLabel glabel"><label class="pull-right" >{vtranslate('LBL_ORGANIZATION_TITLE', $QUALIFIED_MODULE)}</label></td>
							<td width="85%" class="small cellText">{$ORGANIZATIONTITLE}</td>
						</tr>
						<!--End code for multiple company details-->
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_NAME', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONNAME}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_ADDRESS', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONADDRESS}</td>
						</tr>
						<tr> 
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_CITY', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONCITY}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_STATE', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONSTATE}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_CODE', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONCODE}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_COUNTRY', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONCOUNTRY}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_PHONE', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONPHONE}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_FAX', $QUALIFIED_MODULE)}</label></td>
							<td class="small cellText">{$ORGANIZATIONFAX}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_ORGANIZATION_WEBSITE', $QUALIFIED_MODULE)}</td>
							<td class="medium">{$ORGANIZATIONWEBSITE}</td>
						</tr>
						<tr>
							<td class="small cellLabel glabel" width="15%"><label class="pull-right">{vtranslate('LBL_VATID', $QUALIFIED_MODULE)}</td>
							<td class="medium">{$ORGANIZATIONVATID}</td>
						</tr>		
					</tbody>
				</table>
				<!--end table-->
			</div>
		</div>
	</div>
	<!--end details-->				
</form>	


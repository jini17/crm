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
<div class="container-fluid" id="updateCompanyDetailsForm">
		<form action="index.php?parent=Settings&module=MultipleCompany&action=Save" method="post" id="EditView" name="EditView" enctype="multipart/form-data" >
			<input type="hidden" name="return_module" value="Settings">
			<input type="hidden" name="parent" value="Settings">
			<input type="hidden" name="return_action" value="OrganizationConfig">
			<!--start edit-->
				<div class="row-fluid widget_header">
					<span class="span8"><h3>{vtranslate('LBL_COMPANY_DETAILS', $QUALIFIED_MODULE)}</h3></span>
				</div>
				<hr />
				{if $ERROR_MESSAGE neq ''}
				<div class="alert alert-danger">{vtranslate($ERROR_MESSAGE,$QUALIFIED_MODULE)}</div><br>
				{/if}
				</table>
				<!--start form-->
			
				<div class="contentArea">
					<div class="control-group col-md-12">
							<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_LOGO', $QUALIFIED_MODULE)}</div>
							<!--start company logo-->
							<div class="controls col-md-10">
								{if $ORGANIZATIONLOGONAME neq ''}
								<div class="companyLogo col-md-12" style="border: 1px solid #cecece;padding: 15px;margin-bottom: 20px;">
									<img style="max-height:60px;height:auto;" src="test/logo/{$ORGANIZATIONLOGONAME}" class="alignMiddle">
									<span>{$ORGANIZATIONLOGONAME}</span>
								</div>
								{else}
								<div class="companyLogo col-md-12" style="border: 1px solid #cecece;padding: 15px;margin-bottom: 20px;">
									<img style="max-height:60px;height:auto;" src="test/logo/nologo.gif" class="alignMiddle">
									<span>{$ORGANIZATIONLOGONAME}</span>
								</div>
								{/if}
								<INPUT TYPE="HIDDEN" NAME="MAX_FILE_SIZE" VALUE="800000">
								<INPUT TYPE="HIDDEN" NAME="PREV_FILE" VALUE="{$ORGANIZATIONLOGONAME}">
								<input class="control-label" style="width:190px;padding:0px;margin-bottom: 15px;"  type="file" name="binFile" class="small" value="{$ORGANIZATIONLOGONAME}">
								<div class="alert alert-info col-sm-12">
								<span style="margin-bottom: 15px;">Recommended size 170X60 pixels( .jpeg , .jpg , .png , .gif , .pjpeg , .x-png format ).</span>
								</div>
								<input type="hidden" name="binFile_hidden" value="{$ORGANIZATIONLOGONAME}" />
							</div>
							<!--end company logo-->
					</div>
					<br />
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_TITLE', $QUALIFIED_MODULE)}<span class="redColor">*</span></div>
						<div class="controls col-md-10"><input type="text" name="organization_title" id="organization_title" class="detailedViewTextBox" value="{$ORGANIZATIONTITLE}" data-validation-engine="validate[required]" required></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_NAME', $QUALIFIED_MODULE)}<span class="redColor">*</span></div>
						<div class="controls col-md-10"><input type="text" name="organizationname" id="organizationname" class="detailedViewTextBox" value="{$ORGANIZATIONNAME}" data-validation-engine="validate[required]" required></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_ADDRESS', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" name="address" class="detailedViewTextBox" value="{$ORGANIZATIONADDRESS}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_CITY', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" id="city" name="city" class="detailedViewTextBox" value="{$ORGANIZATIONCITY}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_STATE', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" id="state" name="state" class="detailedViewTextBox" value="{$ORGANIZATIONSTATE}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_CODE', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text"  name="code" class="detailedViewTextBox" value="{$ORGANIZATIONCODE}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_COUNTRY', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" id="country" name="country" class="detailedViewTextBox" value="{$ORGANIZATIONCOUNTRY}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_PHONE', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" name="phone" class="detailedViewTextBox" value="{$ORGANIZATIONPHONE}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_FAX', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" name="fax" class="detailedViewTextBox" value="{$ORGANIZATIONFAX}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_ORGANIZATION_WEBSITE', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" name="website" class="detailedViewTextBox" value="{$ORGANIZATIONWEBSITE}"></div>
					</div>
					<div class="control-group col-md-12">
						<div class="control-label col-md-2">{vtranslate('LBL_VATID', $QUALIFIED_MODULE)}</div>
						<div class="controls col-md-10"><input type="text" name="vatid" class="detailedViewTextBox" value="{$ORGANIZATIONVATID}"></div>
					</div>
				
				
					<div class="modal-footer">
						
						<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
							<input class="cancelLink" style="margin:0;background:none;border:none;" title="{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_CANCEL_BUTTON_KEY', $QUALIFIED_MODULE)}" onclick="window.history.back()" type="button" name="button" value="{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}">
						</div>
						<input class="btn btn-success" title="{vtranslate('LBL_SAVE_BUTTON_LABEL', $QUALIFIED_MODULE)}" accessKey="{vtranslate('LBL_SAVE_BUTTON_KEY', $QUALIFIED_MODULE)}" type="submit" name="button" value="{vtranslate('LBL_SAVE_BUTTON_LABEL', $QUALIFIED_MODULE)}">
						
					</div>
				
				</div>
				
			
			<!--end edit-->
			<!-- Added By Jitu on 15 Sep 2014 -->
			<input type="hidden" name="organization_id" id="organization_id" value="{$ORGANIZATIONID}" />
		</form>
		<!--end form-->
	</div>
{literal}
<script>
function verify_data(form,company_name)
{
	if (form.organization_name.value == "" )
	{
		{/literal}
                alert(company_name +"{vtranslate('CANNOT_BE_NONE', $QUALIFIED_MODULE)}");
                form.organization_name.focus();
                return false;
                {literal}
	}
	else if (form.organization_name.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
	{
	{/literal}
                alert(company_name +"{vtranslate('CANNOT_BE_EMPTY', $QUALIFIED_MODULE)}");
                form.organization_name.focus();
                return false;
                {literal}
	}
	else if (! upload_filter("binFile","jpg|jpeg|JPG|JPEG"))
        {
                form.binFile.focus();
                return false;
        }
	else
	{
		return true;
	}
}
</script>
{/literal}

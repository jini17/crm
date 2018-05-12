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
	.select2{
		width:300px;
	}
</style>
<div class="educationModalContainer">
	<div class="modal-header contentsBackground">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 <h3>{vtranslate('LBL_USER_EMERGENCY', $QUALIFIED_MODULE)}</h3>
	</div>
	<form id="editEmergency" name="editEmergency" class="form-horizontal" method="POST">
		<input type="hidden" name="record" value="{$EDU_ID}" />
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="saveEmergencyContact" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
		<div class="modal-body">
			<!--start-->
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_CONTACT_NAME', $MODULE)}
				</label>
				<div class="controls">
					<input id="contact_name" class="input-large nameField" type="text"  value="{$EMERGENCY_DETAIL['contact_name']}" name="contact_name"  data-validation-engine="validate[required]">
				</div>
				<label class="control-label"></label>
			</div>
		<!--end-->
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_HOME_PH', $MODULE)}
				</label>
				<div class="controls">
					<input id="home_phone" class="input-large nameField" type="text"  value="{$EMERGENCY_DETAIL['home_phone']}" name="home_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($HOMEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_OFFICE_PH', $MODULE)}
				</label>
				<div class="controls">
					<input id="office_phone" class="input-large nameField" type="text" value="{$EMERGENCY_DETAIL['office_phone']}" name="office_phone" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($OFFICEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_MOBILE', $MODULE)}
				</label>
				<div class="controls">
					<input id="mobile" class="input-large nameField" type="text"  value="{$EMERGENCY_DETAIL['mobile']}" name="mobile" data-fieldinfo= '{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($MOBILEPHONE))}' data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]">
				</div>
			</div>		 	
			<div class="control-group">
				<label class="control-label">
					<span class="redColor">*</span>&nbsp;{vtranslate('LBL_RELATIONSHIP', $MODULE)}
				</label>
				<div class="controls">
					<select class="select2" name="relationship" id ="relationship">	
						<option value="{vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}} selected {/if}>
						{vtranslate('LBL_FATHER', $QUALIFIED_MODULE)}</option>

						<option value="{vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}} selected {/if}>
						{vtranslate('LBL_MOTHER', $QUALIFIED_MODULE)}</option>

						<option value="{vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}} selected {/if}>
						{vtranslate('LBL_BROTHER', $QUALIFIED_MODULE)}</option>

						<option value="{vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}} selected {/if}>
						{vtranslate('LBL_SISTER', $QUALIFIED_MODULE)}</option>

						<option value="{vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}} selected {/if}>
						{vtranslate('LBL_FRIEND', $QUALIFIED_MODULE)}</option>
						
						<option value="{vtranslate('OTHERS', $QUALIFIED_MODULE)}" {if $EMERGENCY_DETAIL.relationship eq {vtranslate('OTHERS', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
					</select>	
				</div>
			</div>
			<!--<div class="control-group">
				<label class="control-label">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
				<div class="controls">
					<input type="checkbox" {(''==$EDU_ID)?'checked':''} name="chkviewable" id="chkviewable" {if $EMERGENCY_DETAIL.isview eq 1} checked {/if}>
				</div>
			</div>-->
		</div>
		<div class="modal-footer">
			<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
				<input class="cancelLink" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel" style="margin:0;background:none;border:none;" aria-hidden="true" data-dismiss="modal">
			</div>
			<input class="btn btn-success" type="submit" value="Save" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
		</div>    	 	
	</form>
</div>
{/strip}

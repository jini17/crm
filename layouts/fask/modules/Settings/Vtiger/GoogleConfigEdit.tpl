{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
	<div class="contents">
		<form id="GoogleConfigForm" class="form-horizontal" data-detail-url="{$MODEL->getIndexViewUrl()}" method="POST">
			
					<div class="pull-right">
						<button class="btn btn-success saveButton" type="submit" title="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
						<a type="reset" class="cancelLink" title="{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
					</div>
				
			{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
			{assign var=FIELD_VALIDATION  value=['clientId' => ['name'=>'clientId'],
												'clientSecret' => ['name' => 'clientSecret']]}
			<table class="table table-bordered table-condensed themeTableColor">
				<thead>
					<tr class="blockHeader"><th colspan="2" class="{$WIDTHTYPE}">{vtranslate('LBL_GOOGLE_CONFIG_FILE', $QUALIFIED_MODULE)}</th></tr>
				</thead>
				<tbody>
					{assign var=FIELD_DATA value=$MODEL->getViewableData()} 
					{foreach key=FIELD_NAME item=FIELD_DETAILS from=$MODEL->getEditableFields()}
						<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
							<td style="border-left: none;" class="row-fluid {$WIDTHTYPE}">
								<input type="text" name="{$FIELD_NAME}" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" {if $FIELD_VALIDATION[$FIELD_NAME]} data-validator={Zend_Json::encode([$FIELD_VALIDATION[$FIELD_NAME]])} {/if} value="{$FIELD_DATA[$FIELD_NAME]}" />
							</td></tr>
					{/foreach}
				</tbody>
			</table>
		</form>
	</div>
</div>
{/strip}

{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 Created by DANIAL FAJAR MODIFIED BY MABRUK but not enough
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
	<div class="contents">
		<form id="FullContactConfigForm" class="form-horizontal" data-detail-url="{$MODEL->getIndexViewUrl()}" method="POST">
			
				<div class="pull-right">
					<button class="btn btn-success saveButton" type="submit" title="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
					<a type="reset" class="cancelLink" title="{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
				</div>
				
			{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
			{assign var=FIELD_VALIDATION  value=['barrier' => ['name'=>'barrier']]}
			<table class="table table-bordered table-condensed themeTableColor">
				<thead>
					<tr class="blockHeader"><th colspan="2" class="{$WIDTHTYPE}">{vtranslate('LBL_FULLCONTACT_CONFIG_FILE', $QUALIFIED_MODULE)}</th></tr>
				</thead>
				<tbody>
					{assign var=FIELD_DATA value=$MODEL->getViewableData()} 
					{foreach key=FIELD_NAME item=FIELD_DETAILS from=$MODEL->getEditableFields()}
						{if $FIELD_NAME eq "preference"}
							<tr id="pref"><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
							<td style="border-left: none;" class="row-fluid {$WIDTHTYPE}">
								<div class="fieldValue">
	                                <select class="select2-container select2 inputElement col-sm-6 selectModule" name="{$FIELD_NAME}" id="{$FIELD_NAME}">
	                                    {if $FIELD_DATA[$FIELD_NAME] eq "Person Enrichment (Modules: Leads, Contacts)"}
	                                        <option value="">Select a option</option>
	                                        <option value="person" selected>Person Enrichment (Modules: Leads, Contacts)</option>
	                                        <option value="company">Company Enrichment (Modules: Organizations)</option>
	                                        <option value="both">Both (Modules: Leads, Contacts, Organizations)</option>
	                                    {elseif $FIELD_DATA[$FIELD_NAME] eq "Company Enrichment (Modules: Organizations)"}
	                                        <option value="">Select a option</option>
	                                        <option value="person">Person Enrichment (Modules: Leads, Contacts)</option>
	                                        <option value="company" selected>Company Enrichment (Modules: Organizations)</option>
	                                        <option value="both">Both (Modules: Leads, Contacts, Organizations)</option>
	                                    {elseif $FIELD_DATA[$FIELD_NAME] eq "Both (Modules: Leads, Contacts, Organizations)"}
	                                        <option value="">Select a option</option>
	                                        <option value="person">Person Enrichment (Modules: Leads, Contacts)</option>
	                                        <option value="company">Company Enrichment (Modules: Organizations)</option>
	                                        <option value="both" selected>Both (Modules: Leads, Contacts, Organizations)</option>
	                                    {else}
	                                        <option value="" selected>Select a option</option>
	                                        <option value="person">Person Enrichment (Modules: Leads, Contacts)</option>
	                                        <option value="company">Company Enrichment (Modules: Organizations)</option>
	                                        <option value="both">Both (Modules: Leads, Contacts, Organizations)</option>    
	                                    {/if}
	                                </select>
                            	</div>
							</td></tr>
						{elseif $FIELD_NAME eq "status"}
							<tr id="stat"><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
							<td style="border-left: none;" class="row-fluid {$WIDTHTYPE}">
								<div class="fieldValue">
	                                <select class="select2-container select2 inputElement col-sm-6 selectModule" name="{$FIELD_NAME}" id="{$FIELD_NAME}">
	                                    {if $FIELD_DATA[$FIELD_NAME] eq "Active"}
	                                        <option value="0">Inactive</option>
	                                        <option value="1" selected>Active</option>                       
	                                    {else}
	                                        <option value="0" selected>Inactive</option>
	                                        <option value="1">Active</option>
	                                    {/if}                                    
	                                </select>
                            	</div>
							</td></tr>
						{else}
						<tr id="bear"><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
							<td style="border-left: none;" class="row-fluid">
								<input type="text" style="width:50%" name="{$FIELD_NAME}" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" {if $FIELD_VALIDATION[$FIELD_NAME]} data-validator={Zend_Json::encode([$FIELD_VALIDATION[$FIELD_NAME]])} {/if} value="{$FIELD_DATA[$FIELD_NAME]}" />
							</td></tr>
						{/if}	
					{/foreach}
				</tbody>
			</table>
		</form>
	</div>
</div>
{/strip}

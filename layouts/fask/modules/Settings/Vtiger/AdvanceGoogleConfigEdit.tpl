{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
	<div class="contents">
		<form id="AdvanceGoogleConfigForm" enctype="multipart/form-data" class="form-horizontal" data-detail-url="{$MODEL->getIndexViewUrl()}" method="POST">
			
			<div class="pull-right">
				<button class="btn btn-success saveButton" type="submit" title="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
				<a type="reset" class="cancelLink" title="{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
			</div>			
			
			<table class="table table-bordered table-condensed themeTableColor">
				<thead>
					<tr class="blockHeader"><th colspan="2" class="{$WIDTHTYPE}">{vtranslate('LBL_GOOGLE_CONFIG_FILE', $QUALIFIED_MODULE)}</th></tr>
				</thead>
				<tbody>				
					{foreach key=FIELD_NAME item=FIELD_VALUE from=$ADVANCED_FIELD_VALUES}
						{if $FIELD_NAME eq 'Client Secret File'}
							<tr><td width="30%"><label class="muted marginRight10px pull-right">{$FIELD_NAME}</label></td>
								<td style="border-left: none;" class="{$WIDTHTYPE}">
									<input type="file" name="clientsecret" id="clientsecret">
									<input type="button" value="Request for Access Key Link" id="requestlink">
							    </td>
							</tr>
						{else}
							<tr><td><label class="muted marginRight10px pull-right">{$FIELD_NAME}</label></td>
								<td style="border-left: none;">
									<input type="text" value="{$FIELD_VALUE}" name="accesskey" id="accesskey" style="width:50%">
							    </td>
							</tr>
						{/if}
					{/foreach}
				</tbody>
			</table>
		</form>
	</div>
</div>
{/strip}

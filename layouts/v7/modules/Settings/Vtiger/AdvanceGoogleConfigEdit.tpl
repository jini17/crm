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
						<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">Client Secret File</label></td>
							<td style="border-left: none;" class="row-fluid {$WIDTHTYPE}">
								<input type="file" name="clientSecretFile" value="" />
							</td></tr>

						<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">Access Key</label></td>
							<td style="border-left: none;" class="row-fluid {$WIDTHTYPE}">
								<input type="text" name="{$FIELD_NAME}" value="" />
							</td></tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
{/strip}

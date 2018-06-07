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
<style>
.cboxTitle {
	width:300px;
}	
</style>
<div id="contents">
<div class="container-fluid" id="GoogleConfigDetails">
	
			<div class="pull-right">
				<button class="btn editButton" data-url='{$MODEL->getEditViewUrl()}' type="button" title="{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}" id="editButton"><strong>{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}</strong></button>
			</div>
		

	<div class="contents">
		<table class="table table-bordered table-condensed themeTableColor">
			<thead>
				<tr class="blockHeader">
					<th class="{$WIDTHTYPE}">
						<span class="alignMiddle">{vtranslate('LBL_GOOGLE_CONFIG_FILE', $QUALIFIED_MODULE)}</span>
					</th>
					<th class="pull-right">
						<p><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/createprj.png" title="Go to https://code.google.com/apis/console"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>	
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/newprj.png" title="Name your project and click create button"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/readyprj.png" title="Wait until your project ready"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/api.png" title="On your left hand side – select APIs"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/enable.png" title="Under google Apps APIs select Calendar API then click ENABLE API button"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/credential.png" title="Repeat step 6 for contact API <br />Go to Credentials. Under OAuth click Create new client ID"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/configure.png" title="Click configure consent screen"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/configure2.png" title="Put your product name and click save"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>

						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/authorize.png" title="Under Authorized JavaScript origins put your url"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/mismatchuri.png" title="Under Authorized redirect URLs copy url from the instance and paste then click create client id."></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/edit_client_secret.png" title="Copy and replace client id and Client Secret in the respective Text box"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/googlecontact.png" title="Go to Contact Module and again sync"></a></p>
						<p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/googlecalendar.png" title="Go to Calendar Module and again sync"></a></p>
					</th>
				</tr>
			</thead>
			<tbody>
				{assign var=FIELD_DATA value=$MODEL->getViewableData()}
				{foreach key=FIELD_NAME item=FIELD_DETAILS from=$MODEL->getEditableFields()}
					<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted marginRight10px pull-right">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
						<td style="border-left: none;" class="{$WIDTHTYPE}">
							<span>{$FIELD_DATA[$FIELD_NAME]}</span>
						</td></tr>
				{/foreach}
			</tbody>
		</table>
	</div>
</div>
</div>

{/strip}

{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is SecondCRM.
* Portions created by SecondCRM are Copyright (C) SecondCRM.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
<div class="container-fluid editViewContainer">
	<form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php" enctype="multipart/form-data">
	<input type="hidden" name="module" value="ManageTerritory"/>
	<input type="hidden" name="parent" value="Settings"/>
	<input type="hidden" name="action" value="Save"/>
	<input type="hidden" name="mode" value="savesubregion"/>
	<input type="hidden" name="regionid"  id="regionid" value="{$REGIONID}" />
	<input type="hidden" name="regiontree" id="regiontree" value="{$REGIONTREE}" />
	<div class="widget_header row-fluid">
		{if $MODE eq 'edit'}
			<h3>{vtranslate('LBL_EDIT_SUB_REGION', $QUALIFIED_MODULE)}</h3>
		{else}
			<h3>{vtranslate('LBL_CREATE_SUB_REGION', $QUALIFIED_MODULE)}</h3>
		{/if}
	</div>
	<hr>

	<div class="row-fluid">
		<label class="span3"><strong>{vtranslate('LBL_SUB_REGION_NAME', $QUALIFIED_MODULE)}<span class="redColor">*</span>: </strong></label>
		<div class="input-append span7">
			<input type="text" class="fieldValue span4 " name="subregionname" id="subregionname" value="" data-validation-engine='validate[required]'  />
		</div>
	</div>
	<br>
	<div class="pull-right">
		<a class="btn btn-success saveTree" onclick="Settings_ManageTerritory_Js.triggerSaveSubRegion();"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></a>
		<a class="cancelLink" type="reset" onclick="javascript:window.history.back();">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
	</div>

</div>
{/strip}

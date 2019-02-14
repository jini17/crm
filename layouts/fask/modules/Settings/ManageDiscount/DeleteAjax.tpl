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
<div class="modelContainer">	
	<div class="modal-header">
		<button data-dismiss="modal" class="close" title="{vtranslate('LBL_CLOSE')}">x</button>
		<h3>

			{vtranslate('LBL_DELETE', $QUALIFIED_MODULE)}
			
		</h3>
	</div>
	<form class="form-horizontal" id="managediscountDeleteAjax" method="post" action="index.php">
		<input type="hidden" name="module" value="{$MODULE}" />
		<input type="hidden" name="parent" value="Settings" />
		<input type="hidden" name="action" value="DeleteAjax" />

		<div class="modal-body tabbable">

			<div class="control-group">
				<div class="control-label">{vtranslate('LBL_DISCOUNT',$QUALIFIED_MODULE)}</div>
				<div class="controls">

					<select class="select2" name="discounts[]" data-validation-engine="validate[required]" multiple="" data-placeholder="Select Discount" style="min-width: 220px; display: none;">

							{foreach from=$MAINDISCOUNT item=DISCOUNT}
							<option value="{$DISCOUNT.discountid}">{$DISCOUNT.title}</b></option>
							{/foreach}

					</select>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
				<a class="cancelLink" data-dismiss="modal" type="reset">Cancel</a>
			</div>
			<button class="btn btn-success deletediscount" name="saveButton" type="submit">
				<strong>Save</strong>
			</button>
		</div>
	</form>
</div>		
{/strip}	

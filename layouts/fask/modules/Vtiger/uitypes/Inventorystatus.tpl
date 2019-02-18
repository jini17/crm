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
{assign var="FIELD_INFO" value=Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
	<input type="hidden" name="fldname" value="{$FIELD_MODEL->get('name')}" />
	<input type="hidden" name="dtfldname" value="targetdatecolumn" />	
	<input type="hidden" name="{$FIELD_MODEL->getFieldName()}" value="" />

	{assign var=FIELD_VALUE value=$FIELD_MODEL->get('fieldvalue')}
	{assign var=ID_ARRAY value=','|explode:$FIELD_VALUE}

	{assign var=MOD value=(''==$ID_ARRAY[0])?'Quotes':$ID_ARRAY[0]}
	{assign var=PICKLIST_VALUES value=$FIELD_MODEL->getStatusList({$MOD})}
	{assign var=DATE_COLS value=$FIELD_MODEL->getDateColumnList({$MOD})}
	
<div id="inventorystatus">
<select id="sourcemodule" name="sourcemodule" class="select2">
	<option value="Quotes" {if $ID_ARRAY[0] eq 'Quotes'}selected{/if}>{vtranslate('Quotes','SalesTarget')}</option>
	<option value="SalesOrder" {if $ID_ARRAY[0] eq 'SalesOrder'}selected{/if}>{vtranslate('SalesOrder','SalesTarget')}</option>
	<option value="Invoice" {if $ID_ARRAY[0] eq 'Invoice'}selected{/if}>{vtranslate('Invoice','SalesTarget')}</option>
	<option value="Payments" {if $ID_ARRAY[0] eq 'Payments'}selected{/if}>{vtranslate('Payments','SalesTarget')}</option>
	<option value="Potentials" {if $ID_ARRAY[0] eq 'Potentials'}selected{/if}>{vtranslate('Potentials','SalesTarget')}</option>	
</select>
&nbsp;
<select id="{$FIELD_MODEL->get('name')}" class="select2" name="{$FIELD_MODEL->getFieldName()}" data-fieldinfo='{$FIELD_INFO}' {if $FIELD_MODEL->isMandatory() eq true} data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" {if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if} {/if}>
    {foreach item=PICKLIST_VALUE key=PICKLIST_NAME  from=$PICKLIST_VALUES}
	{$PICKLIST_VALUE}
        <option value="{Vtiger_Util_Helper::toSafeHTML($PICKLIST_VALUE)}" {if Vtiger_Util_Helper::toSafeHTML($PICKLIST_VALUE) eq $ID_ARRAY[1]} selected {/if}>{vtranslate($PICKLIST_VALUE,'SalesTarget')}</option>
    {/foreach}
</select>
&nbsp;
<select id="datecolumn" class="select2" name="datecolumn" data-fieldinfo='{$FIELD_INFO}'>
    {foreach item=DCOL key=DNAME  from=$DATE_COLS}
	<option value="{Vtiger_Util_Helper::toSafeHTML($DCOL)}" {if Vtiger_Util_Helper::toSafeHTML($DCOL) eq $ID_ARRAY[2]} selected {/if}>{vtranslate($DCOL,'SalesTarget')}</option>
    {/foreach}
</select>
</div>
{/strip}
<script>
	jQuery(document).ready(function(e){ 
		var thisInstance = this;
		var form = jQuery('#EditView');
		
		form.find('[name=sourcemodule]').on('change', function(e) {
			var elem = jQuery(e.currentTarget);
			var dataUrl = "index.php?module=Vtiger&action=GetStatus&sourcemodule="+elem.val();
			
				AppConnector.request(dataUrl).then(
					function(response){ 
						if(response.success) { 
							var listitems = '';
							var getstatus = eval('(' + response.result.data + ')');
							for(var i in getstatus) {
								listitems += "<option value='"+getstatus[i]+"'>"+app.vtranslate(getstatus[i],'SalesTarget')+"</option>";
							}
							var containerelm = form.find('[name=fldname]').val();
							
							jQuery("#"+containerelm).html(listitems);
							var dateitems = '';
							var getdatedata = eval('(' + response.result.datedata + ')');
							for(var j in getdatedata) {
								dateitems += "<option value='"+getdatedata[j]+"'>"+app.vtranslate(getdatedata[j],'SalesTarget')+"</option>";
							}
							var dtcontainerelm = form.find('[name=dtfldname]').val();
							jQuery("#datecolumn").html(dateitems);
						}
					    
					},
					function(error,err){

					}
				);
			
		});		
	});
</script>

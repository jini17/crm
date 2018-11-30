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
{assign var="FIELD_INFO" value=$FIELD_MODEL->getFieldInfo()}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
{assign var=PICKLIST_VALUES value=$FIELD_INFO['picklistvalues']}
{assign var="FIELD_NAME" value=$FIELD_MODEL->getFieldName()}
	

{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$PICKLIST_VALUES}
	<label class="pull-left" style="font-weight:normal !important;">
			<input style="margin-right:5px;" id="{$MODULE}_editView_fieldName_{$FIELD_NAME}_from" type="radio" class="pull-left" value="{$PICKLIST_VALUE}" name="{$FIELD_NAME}"
		{if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if}
		{if $FIELD_INFO["mandatory"] eq true} data-rule-required="true" {/if}
		{if count($FIELD_INFO['validator'])}
			data-specific-rules='{ZEND_JSON::encode($FIELD_INFO["validator"])}'
		{/if} {if trim(decode_html($FIELD_MODEL->get('fieldvalue'))) eq trim($PICKLIST_NAME)} checked {/if} />
			{$PICKLIST_VALUE} &nbsp;
	</label>
{/foreach}
	
{/strip}

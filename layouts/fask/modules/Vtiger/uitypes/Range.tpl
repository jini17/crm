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
	{assign var=FIELD_VALUE value=$FIELD_MODEL->getEditViewDisplayValue($FIELD_MODEL->get('fieldvalue'), $BLOCK_FIELDS)}

	{assign var=FieldValue value="##"|explode:$FIELD_VALUE} 
	{assign var="TIME_FORMAT" value=$USER_MODEL->get('hour_format')}
	{if (!$FIELD_NAME)}
		{assign var="FIELD_NAME" value=$FIELD_MODEL->getFieldName()}
	{/if}
	<div class="input-group inputElement time" style="float: left;width: 30%;min-width: 30%;margin-right:15px;">	
		<input id="{$MODULE}_editView_fieldName_{$FIELD_NAME}_from" type="text" data-format="{$TIME_FORMAT}" class="timepicker-default form-control" value="{$FieldValue[0]}" name="{$FIELD_NAME}_from"
		{if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if}
		{if $FIELD_INFO["mandatory"] eq true} data-rule-required="true" {/if}
		{if count($FIELD_INFO['validator'])}
			data-specific-rules='{ZEND_JSON::encode($FIELD_INFO["validator"])}'
		{/if} data-rule-time="true"/>
		<span class="input-group-addon" style="width: 30px;">
			<i class="fa fa-clock-o"></i>
		</span>
	</div>
	
	<div class="input-group inputElement time" style="float: left;width: 30%;min-width: 30%;">
		<input id="{$MODULE}_editView_fieldName_{$FIELD_NAME}_to" type="text" data-format="{$TIME_FORMAT}" class="timepicker-default form-control" value="{$FieldValue[1]}" name="{$FIELD_NAME}_to"
		{if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if}
		{if $FIELD_INFO["mandatory"] eq true} data-rule-required="true" {/if}
		{if count($FIELD_INFO['validator'])}
			data-specific-rules='{ZEND_JSON::encode($FIELD_INFO["validator"])}'
		{/if} data-rule-time="true"/>
		<span class="input-group-addon" style="width: 30px;">
			<i class="fa fa-clock-o"></i>
		</span>
	</div>
	<!--
{assign var="FIELD_NAME" value=$FIELD_MODEL->getFieldName()}
{assign var=FIELD_NAME value=$FIELD_MODEL->get('name')}
{assign var="FIELD_INFO" value=Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}

<input type="text" name="{$FIELD_NAME}_from" id="{$FIELD_NAME}_from" value="{$FieldValue[0]}" style="width:100px;margin-right:10px;"> - &nbsp;<input type="text" name="{$FIELD_NAME}_to" id="{$FIELD_NAME}_to" value="{$FieldValue[1]}" style="width:100px;" >-->
{/strip}

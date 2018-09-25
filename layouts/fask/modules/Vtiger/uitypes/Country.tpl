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

{assign var=FIELD_NAME value=$FIELD_MODEL->get('name')}

{assign var="FIELD_INFO" value=Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($FIELD_MODEL->getFieldInfo()))}
{assign var=COUNTRY_LIST value=$FIELD_MODEL->getAllCountry()}

{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
<select class="inputElement select2" name="{$FIELD_NAME}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if} >
    {foreach item=COUNTRY_VALUE key=COUNTRY_NAME from=$COUNTRY_LIST}
	<option value="{$COUNTRY_VALUE}" {if $FIELD_MODEL->get('fieldvalue') eq $COUNTRY_VALUE  OR $COUNTRY_VALUE eq 'Malaysia'} selected {/if}>{vtranslate($COUNTRY_VALUE, $MODULE)}</option>
{/foreach}
</select>
{/strip}

{*<!--
/* Function added by ZULHISYAM on Jun 23, 2014 for new UI Type 3994
    This function will retrieve terms details */
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
{assign var="FIELD_INFO" value=Zend_Json::encode($FIELD_MODEL->getFieldInfo())}
{assign var=TERMCONDITION value=$FIELD_MODEL->getTermsDetails()}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
<select class="inputElement select2 {if $OCCUPY_COMPLETE_WIDTH} row-fluid {/if}"  id="terms_conditions" name="{$FIELD_MODEL->getFieldName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO|escape}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if} data-selected-value='{$FIELD_MODEL->get('fieldvalue')}'>
		{if $FIELD_MODEL->isEmptyPicklistOptionAllowed()}<option value="">{vtranslate('LBL_SELECT_OPTION','Vtiger')}</option>{/if}
</select>
<!--- added By jitu@secondcrm.com at 22 Sep 2014 for keeping previous value -->
<input type="hidden" name="hdnTermsCondition" id="hdnTermsCondition" value="{$FIELD_MODEL->get('fieldvalue')}">
{/strip}

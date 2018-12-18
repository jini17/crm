{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is: vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
{strip}

{assign var="FIELD_INFO" value=Zend_Json::encode($FIELD_MODEL->getFieldInfo())}
{assign var=COMPANYDETAILS value=$FIELD_MODEL->getCompanyDetails($id)}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}

{if $FIELD_MODEL->get('uitype') eq '3993'}
<select class="inputElement select2 {if $OCCUPY_COMPLETE_WIDTH} row {/if} id="{$FIELD_MODEL->getFieldName()}" name="{$FIELD_MODEL->getFieldName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO|escape}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if} data-selected-value='{$FIELD_MODEL->get('fieldvalue')}'>
		{if $FIELD_MODEL->isEmptyPicklistOptionAllowed()}<option value="">{vtranslate('LBL_SELECT_OPTION','Vtiger')}</option>{/if}
	{foreach key=labelval1 item=selCompanyDetails from=$COMPANYDETAILS}
            
				{if $selCompanyDetails.organization_id eq $FIELD_MODEL->get('fieldvalue')}
					{assign var=selectval1 value="selected"}
				{else}
					{assign var=selectval1 value=""}
				{/if}
				<option value="{$selCompanyDetails.organization_id}" {$selectval1}>{$selCompanyDetails.organization_title}</option>
                                
    {/foreach}
    
</select>
<input type="hidden" name="hdnCompanyId" id="hdnCompanyId" value="{$FIELD_MODEL->get('fieldvalue')}">
{else}
  <select class="inputElement select2 {if $OCCUPY_COMPLETE_WIDTH} row {/if} id="{$FIELD_MODEL->getFieldName()}" name="{$FIELD_MODEL->getFieldName()}" data-validation-engine="validate[{if $FIELD_MODEL->isMandatory() eq true} required,{/if}funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='{$FIELD_INFO|escape}' {if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if} data-selected-value='{$FIELD_MODEL->get('fieldvalue')}'>
    {if $FIELD_MODEL->isEmptyPicklistOptionAllowed()}<option value="">{vtranslate('LBL_SELECT_OPTION','Vtiger')}</option>{/if}
  {foreach key=labelval1 item=selCompanyDetails from=$COMPANYDETAILS}
            
        {if $selCompanyDetails.organization_id eq $FIELD_MODEL->get('fieldvalue')}
          {assign var=selectval1 value="selected"}
        {else}
          {assign var=selectval1 value=""}
        {/if}
        <option value="{$selCompanyDetails.organization_id}" {$selectval1}>{$selCompanyDetails.organization_title}, {$selCompanyDetails.city}</option>
  {/foreach}
    
</select>
{/if}
{/strip}
>>>>>>> ad3b71034325ed6f7f677cd4e7e7d19728136be0

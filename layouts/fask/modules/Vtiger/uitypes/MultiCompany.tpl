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
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
{assign var="FIELD_INFO" value=$FIELD_MODEL->getFieldInfo()}
{assign var="FIELD_VALUE_LIST" value=explode(' |##| ',$FIELD_MODEL->get('fieldvalue'))}

{assign var=ACCESSIBLE_COMPANYLIST value=Settings_MultipleCompany_List_Model::getListCompany()}
	
	<select id="{$MODULE}_{$smarty.request.view}_fieldName_{$FIELD_MODEL->getFieldName()}" placeholder='Select Company' class="select2 inputElement" data-name="" name="{$FIELD_MODEL->getFieldName()}[]" data-fieldtype="multicompany" style='width:210px;height:30px;'  multiple 
        {if $FIELD_INFO["mandatory"] eq true} data-rule-required="true" {/if}
        {if count($FIELD_INFO['validator'])} 
            data-specific-rules='{ZEND_JSON::encode($FIELD_INFO["validator"])}'
        {/if}
        >
		{foreach item=COMPANY_DETAILS from=$ACCESSIBLE_COMPANYLIST}
			<option value="{Vtiger_Util_Helper::toSafeHTML($COMPANY_DETAILS['organization_id'])}" {if in_array(Vtiger_Util_Helper::toSafeHTML($COMPANY_DETAILS['organization_id']), $FIELD_VALUE_LIST)} selected {/if}>{$COMPANY_DETAILS['organization_title']}</option>
		{/foreach}
	</select>
{/strip}
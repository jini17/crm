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

	{assign var=ALL_ACTIVEUSER_LIST value=$USER_MODEL->getAccessibleUsers()}
	{assign var=ALL_ACTIVEGROUP_LIST value=$USER_MODEL->getAccessibleGroups()}
	{assign var=ASSIGNED_USER_ID value=$FIELD_MODEL->get('name')}
	
    	{assign var=CURRENT_USER_ID value=$USER_MODEL->get('id')}
	{if $FIELD_MODEL->get('fieldvalue') neq ''}
		{assign var=FIELD_VALUE value=$FIELD_MODEL->get('fieldvalue')}
		{assign var=ID_ARRAY value=','|explode:$FIELD_VALUE}
		{assign var=OWNER_TYPE value=$FIELD_MODEL->getDBInsertValue($ID_ARRAY[0])}
	{else}
		{assign var=OWNER_TYPE value=''}
	{/if}	
	
	{assign var=ACCESSIBLE_USER_LIST value=$USER_MODEL->getAccessibleUsersForModule($MODULE)}
	{assign var=ACCESSIBLE_GROUP_LIST value=$USER_MODEL->getAccessibleGroupForModule($MODULE)}

	<div id="usergroupcheckbox" fieldValue  col-md-4 col-sm-12 col-xs-12 >
		<input type="radio" name="assigntype" {if $OWNER_TYPE eq 'User' || $OWNER_TYPE eq ''}checked{/if} value="U" >&nbsp;{vtranslate('LBL_USERS')} &nbsp;
	<input type="radio" name="assigntype" {if $OWNER_TYPE eq 'Group'}checked{/if} value="T">&nbsp;{vtranslate('LBL_GROUPS')}
	</div>
	<span id="assign_user" class="{if $OWNER_TYPE eq 'User' || $OWNER_TYPE eq ''}show;{else}hide{/if}">
		<select class="select2 assigneduserid" data-name="assigneduserid" name="assigneduserid[]" data-fieldinfo='{$FIELD_INFO}' {if !empty($SPECIAL_VALIDATOR)}data-validator={Zend_Json::encode($SPECIAL_VALIDATOR)}{/if} {if $MODULE eq 'SalesTarget' OR $MODULE eq 'Quotes'}multiple{/if}>
			{foreach key=OWNER_ID item=OWNER_NAME from=$ALL_ACTIVEUSER_LIST}
                    <option value="{$OWNER_ID}" data-picklistvalue= '{$OWNER_NAME}'{foreach item=USER from=$ID_ARRAY}{if $USER eq $OWNER_ID } selected {/if}{/foreach}
						{if array_key_exists($OWNER_ID, $ACCESSIBLE_USER_LIST)} data-recordaccess=true {else} data-recordaccess=false {/if}
						data-userId="{$CURRENT_USER_ID}">
                    {$OWNER_NAME}
                    </option>
			{/foreach}
		</select>
	</span>
	<span id="assign_team" class="{if $OWNER_TYPE eq 'Group'}show;{else}hide{/if}">
			<select class="select2 assignedgroupid" style="width:130p" data-name="assignedgroupid" name="assignedgroupid[]" data-fieldinfo='{$FIELD_INFO}' {if $MODULE eq 'SalesTarget' OR $MODULE eq 'Quotes'}multiple{/if}>
			{foreach key=OWNER_ID item=OWNER_NAME from=$ALL_ACTIVEGROUP_LIST}
				<option value="{$OWNER_ID}" data-picklistvalue= '{$OWNER_NAME}' {foreach item=USER from=$ID_ARRAY}{if $USER eq $OWNER_ID } selected {/if}{/foreach}
					{if array_key_exists($OWNER_ID, $ACCESSIBLE_GROUP_LIST)} data-recordaccess=true {else} data-recordaccess=false {/if} >
				{$OWNER_NAME}
				</option>
			{/foreach}
		</select>
	</span>
	<input type="hidden" name="fieldname" value="{$ASSIGNED_USER_ID}" />

<script>
	jQuery(document).ready(function(e){ 
		var thisInstance = this;
		var form = jQuery('#EditView');
		
		form.find('[name=assigntype]').on('click', function(e) {
			var elem = jQuery(e.currentTarget);
			var radiobtnval = elem.val();
			if(radiobtnval == 'U') { 
				jQuery("#assign_user").removeClass('hide').addClass('show');
				jQuery("#assign_team").addClass('hide');	
			} else {
				jQuery("#assign_team").removeClass('hide').addClass('show');
				jQuery("#assign_user").addClass('hide');
			}	
			
		});		
	});
</script>

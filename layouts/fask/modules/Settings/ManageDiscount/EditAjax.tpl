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
<style>
.select2-container-multi.select2-container-disabled .select2-choices .select2-search-choice {
	background-color: #fff;
}
#s2id_autogen1 {
	max-height:50px;
	overflow-y:scroll;
}
#s2id_autogen1 input {
	height: 50px;

}		
.select2-container-disabled .select2-search-choice div {
    border: medium none;
    color: #333;
}
#s2id_roles {
	width: 220px;
	height:50px;
	overflow-y:scroll;
}
#s2id_roles input {
	height:150px;
}
</style>

	{if $MODE eq 'new'}
	{assign var=HEADER_TITLE value=vtranslate('LBL_ADD_DISCOUNT', $QUALIFIED_MODULE)}
	{assign var=disabled value=''}
	{else}
	{assign var=disabled value='disabled'}	
	{assign var=HEADER_TITLE value=vtranslate('LBL_EDIT_DISCOUNT', $QUALIFIED_MODULE)}
	{/if}

<div class="currencyModalContainer modal-dialog modelContainer">
  {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
	<div class="modal-content">
		<form class="form-horizontal" id="managediscountSaveAjax" method="post" action="index.php">
			<input type="hidden" name="module" value="{$MODULE}" />
			<input type="hidden" name="parent" value="Settings" />
			<input type="hidden" name="action" value="SaveAjax" />
			<input type="hidden" name="record" value="{$RECORD}" />
			<input type="hidden" name="mode" value="{$MODE}" />
			<input type="hidden" name="discountid" value="{$RECORD_MODEL->get('discountid')}">
			
			<input type="hidden" name="jsonrole" id="jsonrole" data-allrole="{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($JSONROLE))}" />
				<div class="modal-body">
					<div class="row-fluid">
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">
								{vtranslate('LBL_SELECT_OR_CREATE',$QUALIFIED_MODULE)}
							</label>
							<div class="controls fieldValue col-xs-6">
								<select {$disabled} class="select2 inputElement" id="currentdiscount" name="currentdiscount">				
								<option value=''>{vtranslate('LBL_SELECT',$QUALIFIED_MODULE)}</option>
									{foreach from=$MAINDISCOUNT item=DISCOUNT}
										<option {if $RECORD_MODEL->get('discountid') eq $DISCOUNT.discountid} selected="" {/if} data-role="{$DISCOUNT.roles}" data-criteria="{$DISCOUNT.criteria}" value="{$DISCOUNT.discountid}">{$DISCOUNT.title} <b>[{$DISCOUNT.roles}]</b></option>
									{/foreach}
								</select>
							</div>	
						</div>
						<div class="form-group {if $MODE eq 'edit'} hide {/if}">
                            <label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_TITLE',$QUALIFIED_MODULE)}</label>
							<div class="controls fieldValue col-xs-6">
								<input {$disabled} class ="inputElement" type="text"   name="title" id="title" value="">
							</div>
						</div>
						<div class="form-group">
                            <label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_DISCOUNTLEVEL',$QUALIFIED_MODULE)}</label>
                            <div class="controls fieldValue col-xs-6">
								<select class="select2 inputElement" name="discountlevel" id="discountlevel">
										<option {if $RECORD_MODEL->get('discount_level') eq 'I'} selected="" {/if} value="I">{vtranslate('LBL_INDIVIDUAL',$QUALIFIED_MODULE)}</option>
										<option {if $RECORD_MODEL->get('discount_level') eq 'G'} selected="" {/if} value="G">{vtranslate('LBL_GROUP',$QUALIFIED_MODULE)}</option>
										<option {if $RECORD_MODEL->get('discount_level') eq 'B'} selected="" {/if} value="B">{vtranslate('LBL_BOTH',$QUALIFIED_MODULE)}</option>
								</select>
                            </div>	
                        </div>
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_DISCOUNTTYPE',$QUALIFIED_MODULE)}</label>
                            <div class="controls fieldValue col-xs-6">
								<select {$disabled} class="select2 inputElement discounttype" name="type" id="type">
										<option {if $RECORD_MODEL->get('discount_type') eq 'F'} selected="" {/if} value="F">{vtranslate('LBL_FIXED',$QUALIFIED_MODULE)}</option>
										<option {if $RECORD_MODEL->get('discount_type') eq 'V'} selected="" {/if} value="V">{vtranslate('LBL_FLEXIBLE',$QUALIFIED_MODULE)}</option>
								</select>
								<input type="hidden" name="hidtype" id="hidtype">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_DISCOUNTFORM',$QUALIFIED_MODULE)}</label>
							<div class="controls fieldValue col-xs-6">
								<select {$disabled} id="criteria" class="select2 inputElement" name="criteria">
										<option {if $RECORD_MODEL->get('discount_criteria') eq 'P'} selected="" {/if} value="P">{vtranslate('LBL_PERCENTAGE',$QUALIFIED_MODULE)}</option>
										<option {if $RECORD_MODEL->get('discount_criteria') eq 'A'} selected="" {/if} value="A">{vtranslate('LBL_AMOUNT',$QUALIFIED_MODULE)}</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_DISCOUNT_VALUE',$QUALIFIED_MODULE)}</label>
							<div class="controls fieldValue col-xs-6">
								<input class ="inputElement" type="text" id="discountvalue" name="value" value="{$RECORD_MODEL->get('discount_value')}">		
							</div>
						</div>
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_STATUS',$QUALIFIED_MODULE)}</label>
							<div class="controls fieldValue col-xs-6">
								<select class="select2 inputElement" name="status">
									<option value="0" {if $RECORD_MODEL->get('discount_status') eq 0}selected{/if}>{vtranslate('LBL_ACTIVE',$QUALIFIED_MODULE)}</option>
									<option value="1" {if $RECORD_MODEL->get('discount_status') eq 1}selected{/if}>{vtranslate('LBL_INACTIVE',$QUALIFIED_MODULE)}</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label fieldLabel col-sm-5">{vtranslate('LBL_ROLE',$QUALIFIED_MODULE)}</label>
							<div class="controls fieldValue col-xs-6">
								<select style="overflow:auto;max-height:50px;overflow-y: auto;" {$disabled} class="select2 inputElement" name="roles" name="roles[]" multiple="" data-placeholder="Add Role Here">
									{foreach from=$ROLESLIST item=ROLE}
										<option data-role="{$ROLE.roleid}" {if strpos($RECORD_MODEL->get('roles_allow'), $ROLE.roleid) !==false}selected{/if} value="{$ROLE.roleid}">{$ROLE.rolename}</option>
									{/foreach}
								</select>
							</div>
						</div>
					</div>
				</div>
			{include file='ModalFooter.tpl'|@vtemplate_path:'Vtiger'}
		</form>
	</div>
</div>
{/strip}


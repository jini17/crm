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
<div class="editViewPageDiv viewContent">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
	<div class="modal-header">
		<button data-dismiss="modal" class="close" title="{vtranslate('LBL_CLOSE')}">x</button>
		<h3>
			{if $MODE eq 'new'}
                <h4>
                    {vtranslate('LBL_ADD_DISCOUNT', $QUALIFIED_MODULE)}
                </h4>
                {assign var=disabled value=''}
            {else}
                <h4>
                    {vtranslate('LBL_EDIT_DISCOUNT', $QUALIFIED_MODULE)}
                </h4>
                {assign var=disabled value='disabled'}	
            {/if}
		</h3>
	</div>
	<form class="form-horizontal" id="managediscountSaveAjax" method="post" action="index.php">
		<input type="hidden" name="module" value="{$MODULE}" />
		<input type="hidden" name="parent" value="Settings" />
		<input type="hidden" name="action" value="SaveAjax" />
		<input type="hidden" name="record" value="{$RECORD}" />
		<input type="hidden" name="mode" value="{$MODE}" />
		<input type="hidden" name="discountid" value="{$RECORD_MODEL->get('discountid')}">
		
		<input type="hidden" name="jsonrole" id="jsonrole" data-allrole="{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($JSONROLE))}" />
		<div class="modal-body tabbable">
			<div class="form-group">

			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">{vtranslate('LBL_SELECT_OR_CREATE',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-lg-4 col-md-4 col-sm-4">
					<select {$disabled} class="select2  currentdiscount" id="currentdiscount" name="currentdiscount">				<option value=''>{vtranslate('LBL_SELECT',$QUALIFIED_MODULE)}</option>
							{foreach from=$MAINDISCOUNT item=DISCOUNT}
							<option {if $RECORD_MODEL->get('discountid') eq $DISCOUNT.discountid} selected="" {/if} data-role="{$DISCOUNT.roles}" data-criteria="{$DISCOUNT.criteria}" value="{$DISCOUNT.discountid}">{$DISCOUNT.title} <b>[{$DISCOUNT.roles}]</b></option>
							{/foreach}
					</select>
				</div>
			</div>
			<div class="form-group {if $MODE eq 'edit'} hide {/if}">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-">{vtranslate('LBL_TITLE',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-lg-9 col-md-9 col-sm-9">
					<input {$disabled} class ="inputElement" type="text"   name="title" id="title" value="">
				</div>
			</div>

			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-">{vtranslate('LBL_DISCOUNTLEVEL',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-lg-9 col-md-9 col-sm-9">
					<select class="select2  discountlevel" name="discountlevel" id="discountlevel">
							<option {if $RECORD_MODEL->get('discount_level') eq 'I'} selected="" {/if} value="I">{vtranslate('LBL_INDIVIDUAL',$QUALIFIED_MODULE)}</option>
							<option {if $RECORD_MODEL->get('discount_level') eq 'G'} selected="" {/if} value="G">{vtranslate('LBL_GROUP',$QUALIFIED_MODULE)}</option>
							<option {if $RECORD_MODEL->get('discount_level') eq 'B'} selected="" {/if} value="B">{vtranslate('LBL_BOTH',$QUALIFIED_MODULE)}</option>
					</select>
					
				</div>
			</div>

			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-">{vtranslate('LBL_DISCOUNTTYPE',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-lg-9 col-md-9 col-sm-9">
					<select {$disabled} class="select2   discounttype" name="type" id="type">
							<option {if $RECORD_MODEL->get('discount_type') eq 'F'} selected="" {/if} value="F">{vtranslate('LBL_FIXED',$QUALIFIED_MODULE)}</option>
							<option {if $RECORD_MODEL->get('discount_type') eq 'V'} selected="" {/if} value="V">{vtranslate('LBL_FLEXIBLE',$QUALIFIED_MODULE)}</option>
					</select>
					<input type="hidden" name="hidtype" id="hidtype">
				</div>
			</div>
			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">{vtranslate('LBL_DISCOUNTFORM',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-lg-9 col-md-9 col-sm-9">
					<select {$disabled} id="criteria" class="select2  " name="criteria">
							<option {if $RECORD_MODEL->get('discount_criteria') eq 'P'} selected="" {/if} value="P">{vtranslate('LBL_PERCENTAGE',$QUALIFIED_MODULE)}</option>
							<option {if $RECORD_MODEL->get('discount_criteria') eq 'A'} selected="" {/if} value="A">{vtranslate('LBL_AMOUNT',$QUALIFIED_MODULE)}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">{vtranslate('LBL_DISCOUNT_VALUE',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue col-md-9">
					<input class ="" type="text" id="discountvalue" name="value" value="{$RECORD_MODEL->get('discount_value')}">		</div>
			</div>

			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">{vtranslate('LBL_STATUS',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue">
					<select class="select2  " name="status">
							<option value="0" {if $RECORD_MODEL->get('discount_status') eq 0}selected{/if}>{vtranslate('LBL_ACTIVE',$QUALIFIED_MODULE)}</option>
							<option value="1" {if $RECORD_MODEL->get('discount_status') eq 1}selected{/if}>{vtranslate('LBL_INACTIVE',$QUALIFIED_MODULE)}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">{vtranslate('LBL_ROLE',$QUALIFIED_MODULE)}</div>
				<div class="controls fieldValue">

					<select {$disabled} class="select2 " id="roles" name="roles[]" multiple="" data-placeholder="Add Role Here">

						{foreach from=$ROLESLIST item=ROLE}
							<option data-role="{$ROLE.roleid}" {if strpos($RECORD_MODEL->get('roles_allow'), $ROLE.roleid) !==false}selected{/if} value="{$ROLE.roleid}">{$ROLE.rolename}</option>
						{/foreach}

					</select>
				</div>
			</div>
		</div>
			<div class='clearfix' style="padding-top: 10px;">
                <div class="row clearfix">
                    <div class=' textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                        <button type='submit' class='btn btn-success saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
                        <a class='cancelLink btn btn-danger' data-dismiss="modal" type="reset">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                    </div>
        	    </div>
	        </div>
		</div>
	</form>
</div>
{/strip}


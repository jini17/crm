{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
********************************************************************************/
-->*}

{strip}
	{assign var=LINEITEM_FIELDS value=$RECORD_STRUCTURE['LBL_ITEM_DETAILS']}
	{if $LINEITEM_FIELDS['image']}
		{assign var=IMAGE_EDITABLE value=$LINEITEM_FIELDS['image']->isEditable()}
	{if $IMAGE_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['productid']}
	{assign var=PRODUCT_EDITABLE value=$LINEITEM_FIELDS['productid']->isEditable()}
{if $PRODUCT_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['quantity']}
	{assign var=QUANTITY_EDITABLE value=$LINEITEM_FIELDS['quantity']->isEditable()}
{if $QUANTITY_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['purchase_cost']}
	{assign var=PURCHASE_COST_EDITABLE value=$LINEITEM_FIELDS['purchase_cost']->isEditable()}
{if $PURCHASE_COST_EDITABLE}{assign var=COL_SPAN2 value=($COL_SPAN2)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['listprice']}
	{assign var=LIST_PRICE_EDITABLE value=$LINEITEM_FIELDS['listprice']->isEditable()}
{if $LIST_PRICE_EDITABLE}{assign var=COL_SPAN2 value=($COL_SPAN2)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['margin']}
	{assign var=MARGIN_EDITABLE value=$LINEITEM_FIELDS['margin']->isEditable()}
{if $MARGIN_EDITABLE}{assign var=COL_SPAN3 value=($COL_SPAN3)+1}{/if}
{/if}
{if $LINEITEM_FIELDS['comment']}
	{assign var=COMMENT_EDITABLE value=$LINEITEM_FIELDS['comment']->isEditable()}
{/if}
{if $LINEITEM_FIELDS['discount_amount']}
	{assign var=ITEM_DISCOUNT_AMOUNT_EDITABLE value=$LINEITEM_FIELDS['discount_amount']->isEditable()}
{/if}
{if $LINEITEM_FIELDS['discount_percent']}
	{assign var=ITEM_DISCOUNT_PERCENT_EDITABLE value=$LINEITEM_FIELDS['discount_percent']->isEditable()}
{/if}
{if $LINEITEM_FIELDS['hdnS_H_Percent']}
	{assign var=SH_PERCENT_EDITABLE value=$LINEITEM_FIELDS['hdnS_H_Percent']->isEditable()}
{/if}
{if $LINEITEM_FIELDS['hdnDiscountAmount']}
	{assign var=DISCOUNT_AMOUNT_EDITABLE value=$LINEITEM_FIELDS['hdnDiscountAmount']->isEditable()}
{/if}
{if $LINEITEM_FIELDS['hdnDiscountPercent']}
	{assign var=DISCOUNT_PERCENT_EDITABLE value=$LINEITEM_FIELDS['hdnDiscountPercent']->isEditable()}
{/if}

{assign var="FINAL" value=$RELATED_PRODUCTS.1.final_details}
{assign var="IS_INDIVIDUAL_TAX_TYPE" value=false}
{assign var="IS_GROUP_TAX_TYPE" value=true}

{if $TAX_TYPE eq 'individual'}
	{assign var="IS_GROUP_TAX_TYPE" value=false}
	{assign var="IS_INDIVIDUAL_TAX_TYPE" value=true}
{/if}

<input type="hidden" class="numberOfCurrencyDecimal" value="{$USER_MODEL->get('no_of_currency_decimals')}" />
<input type="hidden" name="totalProductCount" id="totalProductCount" value="{$row_no}" />
<input type="hidden" name="subtotal" id="subtotal" value="" />
<input type="hidden" name="total" id="total" value="" />

<div name='editContent'>
	{assign var=LINE_ITEM_BLOCK_LABEL value="LBL_ITEM_DETAILS"}
	{assign var=BLOCK_FIELDS value=$RECORD_STRUCTURE.$LINE_ITEM_BLOCK_LABEL}
	{assign var=BLOCK_LABEL value=$LINE_ITEM_BLOCK_LABEL}
	{if $BLOCK_FIELDS|@count gt 0}
		<div class='fieldBlockContainer'>
			<div class="row">
				<div class="col-lg-12 col-xs-12">
							<h3 class='fieldBlockHeader' style="margin-top:5px;">&nbsp;&nbsp;&nbsp;{vtranslate($BLOCK_LABEL, $MODULE)}</h3>
				</div>
				<div class="clearfix"></div>
				<div class="col-lg-4 col-xs-12">
						
							{if $LINEITEM_FIELDS['region_id'] && $LINEITEM_FIELDS['region_id']->isEditable()}
								<div>
									<i class="ti-info-alt"></i>&nbsp;
									<label>{vtranslate($LINEITEM_FIELDS['region_id']->get('label'), $MODULE)}</label>&nbsp;
									<select class="select2" id="region_id" name="region_id" style="width: 164px;">
										<option value="0" data-info="{Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($DEFAULT_TAX_REGION_INFO))}">{vtranslate('LBL_SELECT_OPTION', $MODULE)}</option>
										{foreach key=TAX_REGION_ID item=TAX_REGION_INFO from=$TAX_REGIONS}
											<option value="{$TAX_REGION_ID}" data-info='{Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($TAX_REGION_INFO))}' {if $TAX_REGION_ID eq $RECORD->get('region_id')}selected{/if}>{$TAX_REGION_INFO['name']}</option>
										{/foreach}
									</select>
									<input type="hidden" id="prevRegionId" value="{$RECORD->get('region_id')}" />
									&nbsp;&nbsp;<a class="ti-settings" href="index.php?module=Vtiger&parent=Settings&view=TaxIndex" target="_blank" style="vertical-align:middle;"></a>

								</div>
							{/if}
				</div>
				<div class="col-lg-4 col-xs-12" style="top: 3px;">
						<i class="ti-info-alt"></i>&nbsp;
						<label>{vtranslate('LBL_CURRENCY',$MODULE)}</label>&nbsp;
						{assign var=SELECTED_CURRENCY value=$CURRENCINFO}
						{* Lookup the currency information if not yet set - create mode *}
						{if $SELECTED_CURRENCY eq ''}
							{assign var=USER_CURRENCY_ID value=$USER_MODEL->get('currency_id')}
							{foreach item=currency_details from=$CURRENCIES}
								{if $currency_details.curid eq $USER_CURRENCY_ID}
									{assign var=SELECTED_CURRENCY value=$currency_details}
								{/if}
							{/foreach}
						{/if}

						<select class="select2" id="currency_id" name="currency_id" style="width: 150px;">
							{foreach item=currency_details key=count from=$CURRENCIES}
								<option value="{$currency_details.curid}" class="textShadowNone" data-conversion-rate="{$currency_details.conversionrate}" {if $SELECTED_CURRENCY.currency_id eq $currency_details.curid} selected {/if}>
									{$currency_details.currencylabel|@getTranslatedCurrencyString} ({$currency_details.currencysymbol})
								</option>
							{/foreach}
						</select>

						{assign var="RECORD_CURRENCY_RATE" value=$RECORD_STRUCTURE_MODEL->getRecord()->get('conversion_rate')}
						{if $RECORD_CURRENCY_RATE eq ''}
							{assign var="RECORD_CURRENCY_RATE" value=$SELECTED_CURRENCY.conversionrate}
						{/if}
						<input type="hidden" name="conversion_rate" id="conversion_rate" value="{$RECORD_CURRENCY_RATE}" />
						<input type="hidden" value="{$SELECTED_CURRENCY.currency_id}" id="prev_selected_currency_id" />
						<!-- TODO : To get default currency in even better way than depending on first element -->
						<input type="hidden" id="default_currency_id" value="{$CURRENCIES.0.curid}" />
						<input type="hidden" value="{$SELECTED_CURRENCY.currency_id}" id="selectedCurrencyId" />
				</div>
				<div class="col-lg-4 col-xs-12" style="top: 6px;">
					<div>
						<i class="ti-info-alt"></i>&nbsp;
						<label>{vtranslate('LBL_TAX_MODE',$MODULE)}</label>&nbsp;
						<select class="select2 lineItemTax" id="taxtype" name="taxtype" style="width: 150px;">
							<option value="individual" {if $IS_INDIVIDUAL_TAX_TYPE}selected{/if}>{vtranslate('LBL_INDIVIDUAL', $MODULE)}</option>
							<option value="group" {if $IS_GROUP_TAX_TYPE}selected{/if}>{vtranslate('LBL_GROUP', $MODULE)}</option>
						</select>
					</div>
				</div>
			</div>
			<br/><div class="clearfix"></div></br>
			<div class="lineitemTableContainer">
				<table class="table table-bordered" id="lineItemTab">
					<tr>
						<td><strong>{vtranslate('LBL_TOOLS',$MODULE)}</strong></td>
						{if $IMAGE_EDITABLE}
							<td>
								<strong>{vtranslate({$LINEITEM_FIELDS['image']->get('label')},$MODULE)}</strong>
							</td>
						{/if}
						{if $PRODUCT_EDITABLE}
							<td>
								<span class="redColor">*</span><strong>{vtranslate({$LINEITEM_FIELDS['productid']->get('label')},$MODULE)}</strong>
							</td>
						{/if}
						<td>
							<strong>{vtranslate('LBL_QTY',$MODULE)}</strong>
						</td>
						{if $PURCHASE_COST_EDITABLE}
							<td>
								<strong class="pull-right">{vtranslate({$LINEITEM_FIELDS['purchase_cost']->get('label')},$MODULE)}</strong>
							</td>
						{/if}
						{if $LIST_PRICE_EDITABLE}
							<td>
								<strong>{vtranslate({$LINEITEM_FIELDS['listprice']->get('label')},$MODULE)}</strong>
							</td>
						{/if}
						<td><strong class="pull-right">{vtranslate('LBL_TOTAL',$MODULE)}</strong></td>
							{if $MARGIN_EDITABLE && $PURCHASE_COST_EDITABLE}
							<td>
								<strong class="pull-right">{vtranslate({$LINEITEM_FIELDS['margin']->get('label')},$MODULE)}</strong>
							</td>
						{/if}
						<td><strong class="pull-right">{vtranslate('LBL_NET_PRICE',$MODULE)}</strong></td>
					</tr>
					<tr id="row0" class="hide lineItemCloneCopy" data-row-num="0">
						{include file="partials/LineItemsContent.tpl"|@vtemplate_path:'Inventory' row_no=0 data=[] IGNORE_UI_REGISTRATION=true}
					</tr>
					{foreach key=row_no item=data from=$RELATED_PRODUCTS}
						<tr id="row{$row_no}" data-row-num="{$row_no}" class="lineItemRow" {if $data["entityType$row_no"] eq 'Products'}data-quantity-in-stock={$data["qtyInStock$row_no"]}{/if}>
							{include file="partials/LineItemsContent.tpl"|@vtemplate_path:'Inventory' row_no=$row_no data=$data}
							<!-- Added by jitu@30072015 keep discount id for deleted discount-->
							<input type="hidden" id="deleteddiscount_value{$row_no}" name="deleteddiscount_value{$row_no}" value=""  />
						</tr>
					{/foreach}
					{if count($RELATED_PRODUCTS) eq 0 and ($PRODUCT_ACTIVE eq 'true' || $SERVICE_ACTIVE eq 'true')}
						<tr id="row1" class="lineItemRow" data-row-num="1">
							{include file="partials/LineItemsContent.tpl"|@vtemplate_path:'Inventory' row_no=1 data=[] IGNORE_UI_REGISTRATION=false}
						</tr>
					{/if}
				</table>
			</div>
		</div>
		<br>
		<div>
			<div>
				{if $PRODUCT_ACTIVE eq 'true' && $SERVICE_ACTIVE eq 'true'}
					<div class="btn-toolbar">
						<span class="btn-group">
							<button type="button" class="btn btn-primary" id="addProduct" data-module-name="Products" >
								<i class="ti-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_PRODUCT',$MODULE)}</strong>
							</button>
						</span>
						<span class="btn-group">
							<button type="button" class="btn btn-primary" id="addService" data-module-name="Services" >
								<i class="ti-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_SERVICE',$MODULE)}</strong>
							</button>
						</span>
					</div>
				{elseif $PRODUCT_ACTIVE eq 'true'}
					<div class="btn-group">
						<button type="button" class="btn btn-primary" id="addProduct" data-module-name="Products">
							<i class="ti-plus"></i><strong> {vtranslate('LBL_ADD_PRODUCT',$MODULE)}</strong>
						</button>
					</div>
				{elseif $SERVICE_ACTIVE eq 'true'}
					<div class="btn-group">
						<button type="button" class="btn btn-primary" id="addService" data-module-name="Services">
							<i class="ti-plus"></i><strong> {vtranslate('LBL_ADD_SERVICE',$MODULE)}</strong>
						</button>
					</div>
				{/if}
			</div>
		</div>
		<br>
		<table class="table summaryView table-bordered table-striped blockContainer lineItemTable" id="lineItemResult">
			<tr>
				<td width="83%">
					<div class="pull-right"><strong>{vtranslate('LBL_ITEMS_TOTAL',$MODULE)}</strong></div>
				</td>
				<td>
					<div id="netTotal" class="pull-right netTotal">{if !empty($FINAL.hdnSubTotal)}{$FINAL.hdnSubTotal}{else}0{/if}</div>
				</td>
			</tr>
			{if $DISCOUNT_AMOUNT_EDITABLE || $DISCOUNT_PERCENT_EDITABLE}
				<tr>
					<td width="83%">
						<span class="pull-right">(-)&nbsp;
							<strong><a href="javascript:void(0)" id="finalDiscount">{vtranslate('LBL_OVERALL_DISCOUNT',$MODULE)}&nbsp;
									<span id="overallDiscount">
										{if $DISCOUNT_PERCENT_EDITABLE && $FINAL.discount_type_final eq 'percentage'}
											({$FINAL.discount_percentage_final}%)
										{else if $DISCOUNT_AMOUNT_EDITABLE && $FINAL.discount_type_final eq 'amount'}
											({$FINAL.discount_amount_final})
										{else}
											(0)
										{/if}
									</span></a>
							</strong>
						</span>
					</td>
					<td>
						<span id="discountTotal_final" class="pull-right discountTotal_final">{if $FINAL.discountTotal_final}{$FINAL.discountTotal_final}{else}0{/if}</span>

						<!-- Popup Discount Div -->
						<div id="finalDiscountUI" style="width:430px;" class="finalDiscountUI validCheck hide">
							<!-- Modified by jitu@30062015 for showing discount detail-->
							{assign var=discountcount value=$FINALDISCOUNT|count}	
			        		{assign var=discountdetails value=$FINALDISCOUNT}	
		        
	             {if $discountcount eq 0}
		  	       <table width="100%" border="0" cellpadding="5" cellspacing="0" class="table table-nobordered popupTable">
		                <thead>
		                    <tr>
		                        <th id="discount_div_title_final"><b>{vtranslate('LBL_SET_DISCOUNT_FOR',$MODULE)}:{$FINAL.hdnSubTotal}</b></th>
		                        <th>
		                            <button type="button" class="close closeDiv">x</button>
		                        </th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td colspan="2"><center>{vtranslate('LBL_NO_DISCOUNT_CONFIGURE',$MODULE)}</center></td>	                            <input type="hidden" class="discountVal" value="0" />
		                    </tr>
			</tbody>
			</table>
		{else}
                     	<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table table-nobordered popupTable">			<tr>
				<!-- TODO : CLEAN : should not append product total it should added in the js because product total can change at any point of time -->
					<th width ="200" id="discount_div_title_final" nowrap><b>{vtranslate('LBL_SET_DISCOUNT_FOR',$MODULE)} : {$FINAL.hdnSubTotal}</b></th>
					<th nowrap><b>{vtranslate('LBL_DISCOUNT_VAL',$MODULE)}:</b><span id="labelDiscountfinal">{$FINAL['discountTotal_final']}</span><br />
					<b>{vtranslate('LBL_NET_PRICE',$MODULE)}:<span id="labelNetPricefinal">{$FINAL['totalAfterDiscount']}</span>		  
						</th>
					<th>
						<button type="button" class="close closeDiv">x</button>
					</th>
				</tr>
				{foreach item=discounts key=key from=$discountdetails}
					{assign var=dismsg value=""}
					{assign var=disabled value=""}
					{if $RECORD_ID eq ''} 
						{assign var=disabled value=""}		
					{else}
						{if $discounts['deleted'] eq 1} 
						{assign var=dismsg value="{vtranslate('LBL_IS_DELETED_FROM_SYSTEM_PLEASE_REPLACE_OR_REMOVE_DISCOUNT', $MODULE)}"}	

						{assign var=disabled value="disabled"}
					{else if $discounts['discount_status'] eq 1} 

						{assign var=disabled value="disabled"}
					
					{else if $discounts['postdiscount_type'] ne '' AND $discounts['postdiscount_criteria'] ne ''}
						{if $discounts['currentrolediscount'][0]['discount_type'] ne $discounts['postdiscount_type'] OR $discounts['currentrolediscount'][0]['discount_criteria'] ne $discounts['postdiscount_criteria']} 	
						{assign var=disabled value="disabled"}

						{else if $discounts['postdiscount_value'] gt $discounts['currentrolediscount'][0]['discount_value'] } 
							{assign var=disabled value="disabled"}
						{else}
							{assign var=disabled value=""}
						{/if}
					{else}
						{assign var=disabled value=""}
					{/if}
				{/if} 
				<tr style="font-size:12px;">
					<td>
						{if $discounts['currentrolediscount']|count eq 0}	
							{if $discounts['postdiscount_type'] eq ''}
								{assign var=discounttype value=$discounts['prediscount_type']}						{assign var=discountcriteria value=$discounts['prediscount_criteria']}					{assign var=sequence value=$discounts['prediscount_sequence']}					{assign var=discountvalue value=$discounts['prediscount_value']}	
							{else} 
								{assign var=discounttype value=$discounts['postdiscount_type']}						{assign var=discountcriteria value=$discounts['postdiscount_criteria']}					{assign var=sequence value=$discounts['postdiscount_sequence']}					{assign var=discountvalue value=$discounts['postdiscount_value']}	
							{/if}
						{else}
							{if $discounts['postdiscount_type'] eq ''} 
								{if $discounts['prediscount_type'] eq 'F'} 
									{assign var=discounttype value=$discounts['prediscount_type']}							{assign var=discountcriteria value=$discounts['prediscount_criteria']}						{assign var=sequence value=$discounts['prediscount_sequence']}						{assign var=discountvalue value=$discounts['prediscount_value']}		
								{else}
									{assign var=discounttype value=$discounts['prediscount_type']}							{assign var=discountcriteria value=$discounts['prediscount_criteria']}						{assign var=sequence value=$discounts['prediscount_sequence']}						{assign var=discountvalue value=''}		
								{/if}
								
							{else}  
								{assign var=discounttype value=$discounts['postdiscount_type']}						{assign var=discountcriteria value=$discounts['postdiscount_criteria']}					{assign var=sequence value=$discounts['postdiscount_sequence']}					{assign var=discountvalue value=$discounts['postdiscount_value']}	
							{/if}
							
						{/if}
	            <input type="hidden" id="discount_typefinal_{$key}" name="discount_typefinal_{$key}" value="{$discounttype}" />
				<input type="hidden" id="discount_criteriafinal_{$key}" name="discount_criteriafinal_{$key}" value="{$discountcriteria}" />
				<input type="hidden" id="discountindexfinal_{$key}" name="discountindexfinal_{$key}" value="{$discounts['discountindex']}"  />
				<input type="hidden" id="discountidfinal_{$key}" name="discountidfinal_{$key}" value="{$discounts['discountid']}"  />
				<input type="hidden" id="discountseqfinal_{$key}" name="discountseqfinal_{$key}" value="{$sequence}"  />
				<input type="hidden" id="hiddiscount_valuefinal_{$key}" name="hiddiscount_valuefinal_{$key}" value="{$discountvalue}"  />
				
				<input {$disabled} type="checkbox" class="finalDiscounts" data-prediscountvalue="{$discounts['prediscount_value']}" {if $discounts['postdiscount_value'] neq 0.00} checked {/if} id="discountfinal_{$key}" name="discountfinal_{$key}" data-deleted="{$discounts['deleted']}" data-isdeleted="" data-discountid="{$discounts['discountid']}" data-type="{$discounts['prediscount_type']}" data-criteria="{$discounts['prediscount_criteria']}" data-postdiscount_value="{$discounts['postdiscount_value']}" />
						&nbsp;
						
						{if $discounttype eq 'F'}
						
							{if $discountcriteria eq 'P'}
								{$discounts['discount_title']} &nbsp;
								({$discounts['prediscount_value']}&nbsp;%)
								<span class="row-fluid redColor {if $discounts['deleted'] eq 1} deletedDiscount{/if}">{$dismsg}</span></td><td colspan="2"><input type="hidden" class="discount_value" name="discount_valuefinal_{$key}" id="discount_valuefinal_{$key}" value="{$discountvalue}"  />
								{if $CURRENTUSER[1] eq 1 AND $discounts['deleted'] eq 1} 									<i class="icon-trash deleteDiscountFinal cursorPointer" title="{vtranslate('LBL_DELETE',$MODULE)}"></i>	{/if}</td>
							{else}
								
								{$discounts['discount_title']} &nbsp;({$discounts['prediscount_value']})<br /><span class="row-fluid redColor {if $discounts['deleted'] eq 1} deletedDiscount{/if}">{$dismsg}</span></td><td colspan="2"><input type="hidden" class="discount_value" name="discount_valuefinal_{$key}" id="discount_valuefinal_{$key}" value="{$discountvalue}"  />
								{if $CURRENTUSER[1] eq 1 AND $discounts['deleted'] eq 1} 									<i class="icon-trash deleteDiscountFinal cursorPointer" title="{vtranslate('LBL_DELETE',$MODULE)}"></i>	{/if}</td>
							{/if}
						{else}
							{if $discountcriteria eq 'P'}
								
								{$discounts['discount_title']} &nbsp;(Upto {$discounts['prediscount_value']}&nbsp;%)<br /><span class="row-fluid redColor {if $discounts['deleted'] eq 1} deletedDiscount{/if}">{$dismsg}</span></td><td colspan="2"><input {$disabled} class="smallInputBox" class="discount_value" type="text" {$disabled} name="discount_valuefinal_{$key}" id="discount_valuefinal_{$key}" value="{$discounts['postdiscount_value']}"  />					{if $CURRENTUSER[1] eq 1 AND $discounts['deleted'] eq 1} 
									<i class="icon-trash deleteDiscountFinal cursorPointer" title="{vtranslate('LBL_DELETE',$MODULE)}"></i>	{/if}</td>
							{else}
								
								{$discounts['discount_title']} &nbsp;(Upto {$discounts['prediscount_value']})<br /><span class="row-fluid redColor {if $discounts['deleted'] eq 1} deletedDiscount{/if}">{$dismsg}</span></td><td colspan="2"><input {$disabled} class="smallInputBox" type="text" {$disabled} name="discount_valuefinal_{$key}" id="discount_valuefinal_{$key}" class="discount_value" {$disabled} value="{$discounts['postdiscount_value']}"  />								{if $CURRENTUSER[1] eq 1 AND $discounts['deleted'] eq 1} 
									<i class="icon-trash deleteDiscountFinal cursorPointer" title="{vtranslate('LBL_DELETE',$MODULE)}"></i>	{/if}</td>
							{/if}
						{/if}	
	
					</td>
					
				   </tr>
			{/foreach}
				
		                <tr>
					<td colspan="3"><div class="modal-footer lineItemPopupModalFooter modal-footer-padding">
					<div class=" pull-right cancelLinkContainer">
						<a class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>
					</div>
					<button class="btn btn-success finalDiscountSave" type="button" name="lineItemActionSave"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button></td>
			   	   </tr>	
			</table>
		<input type="hidden" id="deleteddiscountfinal_value" name="deleteddiscountfinal_value" value=""  />
		{/if}<!-- End here -->
		<!-- End Popup Div -->
					</td>
				</tr>
			{/if}
			{if $SH_PERCENT_EDITABLE}
				{assign var=CHARGE_AND_CHARGETAX_VALUES value=$FINAL.chargesAndItsTaxes}
				<tr>
					<td width="83%">
						<span class="pull-right">(+)&nbsp;<strong><a href="javascript:void(0)" id="charges">{vtranslate('LBL_CHARGES',$MODULE)}</a></strong></span>
						<div id="chargesBlock" class="validCheck hide chargesBlock">
							<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table table-nobordered popupTable">
								{foreach key=CHARGE_ID item=CHARGE_MODEL from=$INVENTORY_CHARGES}
									<tr>
										{assign var=CHARGE_VALUE value=$CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['value']}
										{assign var=CHARGE_PERCENT value=0}
										{if $CHARGE_MODEL->get('format') eq 'Percent' && $CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['percent'] neq NULL}
											{assign var=CHARGE_PERCENT value=$CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['percent']}
										{/if}

										<td class="lineOnTop chargeName" data-charge-id="{$CHARGE_ID}">{$CHARGE_MODEL->getName()}</td>
										<td class="lineOnTop">
											{if $CHARGE_MODEL->get('format') eq 'Percent'}
												<input type="text" class="span1 chargePercent" size="5" data-rule-positive=true data-rule-inventory_percentage=true name="charges[{$CHARGE_ID}][percent]" value="{if $CHARGE_PERCENT}{$CHARGE_PERCENT}{else if $RECORD_ID}0{else}{$CHARGE_MODEL->getValue()}{/if}" />&nbsp;%
											{/if}
										</td>
										<td style="text-align: right;" class="lineOnTop">
											<input type="text" class="span1 chargeValue" size="5" {if $CHARGE_MODEL->get('format') eq 'Percent'}readonly{/if} data-rule-positive=true name="charges[{$CHARGE_ID}][value]" value="{if $CHARGE_VALUE}{$CHARGE_VALUE}{else if $RECORD_ID}0{else}{$CHARGE_MODEL->getValue() * $USER_MODEL->get('conv_rate')}{/if}" />&nbsp;
										</td>
									</tr>
								{/foreach}
							</table>
						</div>
					</td>
					<td>
						<input type="hidden" class="lineItemInputBox" id="chargesTotal" name="shipping_handling_charge" value="{if $FINAL.shipping_handling_charge}{$FINAL.shipping_handling_charge}{else}0{/if}" />
						<span id="chargesTotalDisplay" class="pull-right chargesTotalDisplay">{if $FINAL.shipping_handling_charge}{$FINAL.shipping_handling_charge}{else}0{/if}</span>
					</td>
				</tr>
			{/if}
			<tr>
				<td width="83%">
					<span class="pull-right"><strong>{vtranslate('LBL_PRE_TAX_TOTAL', $MODULE)} </strong></span>
				</td>
				<td>
					{assign var=PRE_TAX_TOTAL value=$FINAL.preTaxTotal}
					<span class="pull-right" id="preTaxTotal">{if $PRE_TAX_TOTAL}{$PRE_TAX_TOTAL}{else}0{/if}</span>
					<input type="hidden" id="pre_tax_total" name="pre_tax_total" value="{if $PRE_TAX_TOTAL}{$PRE_TAX_TOTAL}{else}0{/if}"/>
				</td>
			</tr>
			<!-- Group Tax - starts -->

			<tr id="group_tax_row" valign="top" class="{if $IS_INDIVIDUAL_TAX_TYPE}hide{/if}">
				<td width="83%">
					<span class="pull-right">(+)&nbsp;<strong><a href="javascript:void(0)" id="finalTax">{vtranslate('LBL_TAX',$MODULE)}</a></strong></span>
					<!-- Pop Div For Group TAX -->
					<div class="hide finalTaxUI validCheck" id="group_tax_div">
						<input type="hidden" class="popover_title" value="{vtranslate('LBL_GROUP_TAX',$MODULE)}" />
						<table width="100%" border="0" cellpadding="5" cellspacing="0" class="table table-nobordered popupTable">
							{foreach item=tax_detail name=group_tax_loop key=loop_count from=$TAXES}
								<tr>
									<td class="lineOnTop">{$tax_detail.taxlabel}</td>
									<td class="lineOnTop">
										<input type="text" size="5" data-compound-on="{if $tax_detail['method'] eq 'Compound'}{Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($tax_detail['compoundon']))}{/if}"
											   name="{$tax_detail.taxname}_group_percentage" id="group_tax_percentage{$smarty.foreach.group_tax_loop.iteration}" value="{$tax_detail.percentage}" class="span1 groupTaxPercentage"
											   data-rule-positive=true data-rule-inventory_percentage=true />&nbsp;%
									</td>
									<td style="text-align: right;" class="lineOnTop">
										<input type="text" size="6" name="{$tax_detail.taxname}_group_amount" id="group_tax_amount{$smarty.foreach.group_tax_loop.iteration}" style="cursor:pointer;" value="{$tax_detail.amount}" readonly class="cursorPointer span1 groupTaxTotal" />
									</td>
								</tr>
							{/foreach}
							<input type="hidden" id="group_tax_count" value="{$smarty.foreach.group_tax_loop.iteration}" />
						</table>
					</div>
					<!-- End Popup Div Group Tax -->
				</td>
				<td><span id="tax_final" class="pull-right tax_final">{if $FINAL.tax_totalamount}{$FINAL.tax_totalamount}{else}0{/if}</span></td>
			</tr>
			<!-- Group Tax - ends -->
			{if $SH_PERCENT_EDITABLE}
				<tr>
					<td width="83%">
						<span class="pull-right">(+)&nbsp;<strong><a href="javascript:void(0)" id="chargeTaxes">{vtranslate('LBL_TAXES_ON_CHARGES',$MODULE)} </a></strong></span>

						<!-- Pop Div For Shipping and Handling TAX -->
						<div id="chargeTaxesBlock" class="hide validCheck chargeTaxesBlock">
							<p class="popover_title hide">
								{vtranslate('LBL_TAXES_ON_CHARGES', $MODULE)} : <span id="SHChargeVal" class="SHChargeVal">{if $FINAL.shipping_handling_charge}{$FINAL.shipping_handling_charge}{else}0{/if}</span>
							</p>
							<table class="table table-nobordered popupTable">
								<tbody>
									{foreach key=CHARGE_ID item=CHARGE_MODEL from=$INVENTORY_CHARGES}
										{foreach key=CHARGE_TAX_ID item=CHARGE_TAX_MODEL from=$RECORD->getChargeTaxModelsList($CHARGE_ID)}
											{if !isset($CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['taxes'][$CHARGE_TAX_ID]) && $CHARGE_TAX_MODEL->isDeleted()}
												{continue}
											{/if}
											{if !$RECORD_ID && $CHARGE_TAX_MODEL->isDeleted()}
												{continue}
											{/if}
											<tr>
												{assign var=SH_TAX_VALUE value=$CHARGE_TAX_MODEL->getTax()}
												{if $CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['value'] neq NULL}
													{assign var=SH_TAX_VALUE value=0}
													{if $CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['taxes'][$CHARGE_TAX_ID]}
														{assign var=SH_TAX_VALUE value=$CHARGE_AND_CHARGETAX_VALUES[$CHARGE_ID]['taxes'][$CHARGE_TAX_ID]}
													{/if}
												{/if}

												<td class="lineOnTop">{$CHARGE_MODEL->getName()} - {$CHARGE_TAX_MODEL->getName()}</td>
												<td class="lineOnTop">
													<input type="text" data-charge-id="{$CHARGE_ID}" data-compound-on="{if $CHARGE_TAX_MODEL->getTaxMethod() eq 'Compound'}{$CHARGE_TAX_MODEL->get('compoundon')}{/if}"
														   class="span1 chargeTaxPercentage" name="charges[{$CHARGE_ID}][taxes][{$CHARGE_TAX_ID}]" value="{$SH_TAX_VALUE}"
														   data-rule-positive=true data-rule-inventory_percentage=true />&nbsp;%
												</td>
												<td style="text-align: right;" class="lineOnTop">
													<input type="text" class="span1 chargeTaxValue cursorPointer pull-right chargeTax{$CHARGE_ID}{$CHARGE_TAX_ID}" size="5" value="0" readonly />&nbsp;
												</td>
											</tr>
										{/foreach}
									{/foreach}
								</tbody>
							</table>
						</div>
						<!-- End Popup Div for Shipping and Handling TAX -->
					</td>
					<td>
						<input type="hidden" id="chargeTaxTotalHidden" class="chargeTaxTotal" name="s_h_percent" value="{if $FINAL.shtax_totalamount}{$FINAL.shtax_totalamount}{else}0{/if}" />
						<span class="pull-right" id="chargeTaxTotal">{if $FINAL.shtax_totalamount}{$FINAL.shtax_totalamount}{else}0{/if}</span>
					</td>
				</tr>
				<tr>
					<td width="83%">
						<span class="pull-right">(-)&nbsp;<strong><a href="javascript:void(0)" id="deductTaxes">{vtranslate('LBL_DEDUCTED_TAXES',$MODULE)} </a></strong></span>

						<div id="deductTaxesBlock" class="hide validCheck deductTaxesBlock">
							<table class="table table-nobordered popupTable">
								<tbody>
									{foreach key=DEDUCTED_TAX_ID item=DEDUCTED_TAX_INFO from=$DEDUCTED_TAXES}
										<tr>
											<td class="lineOnTop">{$DEDUCTED_TAX_INFO['taxlabel']}</td>
											<td class="lineOnTop">
												<input type="text" class="span1 deductTaxPercentage" name="{$DEDUCTED_TAX_INFO['taxname']}_group_percentage" value="{if $DEDUCTED_TAX_INFO['selected'] || !$RECORD_ID}{$DEDUCTED_TAX_INFO['percentage']}{else}0{/if}"
													   data-rule-positive=true data-rule-inventory_percentage=true />&nbsp;%
											</td>
											<td style="text-align: right;" class="lineOnTop">
												<input type="text" class="span1 deductTaxValue cursorPointer pull-right" name="{$DEDUCTED_TAX_INFO['taxname']}_group_amount" size="5" readonly value="{$DEDUCTED_TAX_INFO['amount']}"/>&nbsp;
											</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
					</td>
					<td>
						<span class="pull-right" id="deductTaxesTotalAmount">{if $FINAL.deductTaxesTotalAmount}{$FINAL.deductTaxesTotalAmount}{else}0{/if}</span>
					</td>
				</tr>
			{/if}

			<tr valign="top">
				<td width="83%" >
					<div class="pull-right">
						<strong>{vtranslate('LBL_ADJUSTMENT',$MODULE)}&nbsp;&nbsp;</strong>
						<span>
							<input type="radio" name="adjustmentType" option value="+" {if $FINAL.adjustment gte 0}checked{/if}>&nbsp;{vtranslate('LBL_ADD',$MODULE)}&nbsp;&nbsp;
						</span>
						<span>
							<input type="radio" name="adjustmentType" option value="-" {if $FINAL.adjustment lt 0}checked{/if}>&nbsp;{vtranslate('LBL_DEDUCT',$MODULE)}
						</span>
					</div>
				</td>
				<td>
					<span class="pull-right">
						<input id="adjustment" name="adjustment" type="text" data-rule-positive="true" class="lineItemInputBox form-control" value="{if $FINAL.adjustment lt 0}{abs($FINAL.adjustment)}{elseif $FINAL.adjustment}{$FINAL.adjustment}{else}0{/if}">
					</span>
				</td>
			</tr>
			<tr valign="top">
				<td width="83%">
					<span class="pull-right"><strong>{vtranslate('LBL_GRAND_TOTAL',$MODULE)}</strong></span>
				</td>
				<td>
					<span id="grandTotal" name="grandTotal" class="pull-right grandTotal">{$FINAL.grandTotal}</span>
				</td>
			</tr>
			{if $MODULE eq 'Invoice' or $MODULE eq 'PurchaseOrder'}
				<tr valign="top">
					<td width="83%" >
						<div class="pull-right">
							{if $MODULE eq 'Invoice'}
								<strong>{vtranslate('LBL_RECEIVED',$MODULE)}</strong>
							{else}
								<strong>{vtranslate('LBL_PAID',$MODULE)}</strong>
							{/if}
						</div>
					</td>
					<td>
						{if $MODULE eq 'Invoice'}
							<span class="pull-right"><input id="received" name="received" type="text" class="lineItemInputBox form-control" value="{if $RECORD->getDisplayValue('received') && !($IS_DUPLICATE)}{$RECORD->getDisplayValue('received')}{else}0{/if}"></span>
							{else}
							<span class="pull-right"><input id="paid" name="paid" type="text" class="lineItemInputBox" value="{if $RECORD->getDisplayValue('paid') && !($IS_DUPLICATE)}{$RECORD->getDisplayValue('paid')}{else}0{/if}"></span>
							{/if}
					</td>
				</tr>
				<tr valign="top">
					<td width="83%" >
						<div class="pull-right">
							<strong>{vtranslate('LBL_BALANCE',$MODULE)}</strong>
						</div>
					</td>
					<td>
						<span class="pull-right"><input id="balance" name="balance" type="text" class="lineItemInputBox form-control" value="{if $RECORD->getDisplayValue('balance') && !($IS_DUPLICATE)}{$RECORD->getDisplayValue('balance')}{else}0{/if}" readonly></span>
					</td>
				</tr>
			{/if}
		</table>
	{/if}
	<!-- Added by jitu@30072015 keep discount id for deleted discount-->
   <input type="hidden" name="totalFinalDiscountCount" id="totalFinalDiscountCount" value="{$discountcount}" />		
<!-- end here -->
   <input type="hidden" name="noofdiscount" id="noofdiscount" value="{$DATA.discountdetails|count}">
   <input type="hidden" name="totalProductCount" id="totalProductCount" value="{$row_no}" />
   <input type="hidden" name="subtotal" id="subtotal" value="" />
   <input type="hidden" name="total" id="total" value="" />
   <input type="hidden" name="selectedlineitem" id="selectedlineitem" />
   <input type="hidden" name="labelDiscount_final" id="labelDiscount_final" value="{$FINAL['discountTotal_final']}" />	
   <input type="hidden" name="labelNetPrice_final" id="labelNetPrice_final" value="{$FINAL['totalAfterDiscount']}" />	
</div>


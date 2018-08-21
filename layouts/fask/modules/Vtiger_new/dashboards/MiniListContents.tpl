{************************************************************************************
	* The contents of this file are subject to the vtiger CRM Public License Version 1.0
	* ("License"); You may not use this file except in compliance with the License
	* The Original Code is: vtiger CRM Open Source
	* The Initial Developer of the Original Code is vtiger.
	* Portions created by vtiger are Copyright (C) vtiger.
	* All Rights Reserved.
	*************************************************************************************}
	<div style='padding-top: 0;margin-bottom: 2%;padding-right:15px;'>
		<input type="hidden" id="widget_{$WIDGET->get('id')}_currentPage" value="{$CURRENT_PAGE}">
		{* Comupte the nubmer of columns required *}
		{assign var="SPANSIZE" value=12}
		{assign var=HEADER_COUNT value=$MINILIST_WIDGET_MODEL->getHeaderCount()}
		{if $HEADER_COUNT}
		{assign var="SPANSIZE" value=12/$HEADER_COUNT}
		{/if}

		<div class="row" style="padding:10px;background-color: #2f5597;color:#fff;">
			{assign var=HEADER_FIELDS value=$MINILIST_WIDGET_MODEL->getHeaders()}
			{foreach item=FIELD from=$HEADER_FIELDS}
			<div class="col-lg-{$SPANSIZE}"><strong>{vtranslate($FIELD->get('label'),$BASE_MODULE)}</strong></div>
			{/foreach}
		</div>

		{assign var="MINILIST_WIDGET_RECORDS" value=$MINILIST_WIDGET_MODEL->getRecords()}

		{foreach item=RECORD from=$MINILIST_WIDGET_RECORDS}
		<div class="row miniListContent" style="    border-bottom: 1px solid #cecece;
		padding: 10px;">
		{foreach item=FIELD key=NAME from=$HEADER_FIELDS name="minilistWidgetModelRowHeaders"}
		<div class="col-lg-{$SPANSIZE} textOverflowEllipsis" title="{strip_tags($RECORD->get($NAME))}" style="padding-right: 5px;    line-height: 30px;
		vertical-align: middle;">
		{if $FIELD->get('uitype') eq '71' || ($FIELD->get('uitype') eq '72' && $FIELD->getName() eq 'unit_price')}
		{assign var=CURRENCY_ID value=$USER_MODEL->get('currency_id')}
		{if $FIELD->get('uitype') eq '72' && $NAME eq 'unit_price'}
		{assign var=CURRENCY_ID value=getProductBaseCurrency($RECORD_ID, $RECORD->getModuleName())}
		{/if}
		{assign var=CURRENCY_INFO value=getCurrencySymbolandCRate($CURRENCY_ID)}
		{if $RECORD->get($NAME) neq NULL}
		&nbsp;{CurrencyField::appendCurrencySymbol($RECORD->get($NAME), $CURRENCY_INFO['symbol'])}&nbsp;
		{/if}
		{else}
		{$RECORD->get($NAME)}&nbsp;
		{/if}
		{if $smarty.foreach.minilistWidgetModelRowHeaders.last}
		<a href="{$RECORD->getDetailViewUrl()}" class="pull-right"><i style="color: #fff;
		display: inline-block;
		background-color: #e51f2a;
		border-radius: 60px;
		/* box-shadow: 0px 0px 2px #888; */
		padding: 0.6em 0.6em;
		border: 1px solid #cecece;" title="{vtranslate('LBL_SHOW_COMPLETE_DETAILS',$MODULE_NAME)}" class="fa fa-list"></i></a>
		{/if}
	</div>
	{/foreach}
</div>
{/foreach}

{if $MORE_EXISTS}
<div class="moreLinkDiv" style="padding-top:10px;padding-bottom:5px;">
	<a class="miniListMoreLink" data-linkid="{$WIDGET->get('linkid')}" data-widgetid="{$WIDGET->get('id')}" onclick="Vtiger_MiniList_Widget_Js.registerMoreClickEvent(event);">{vtranslate('LBL_MORE')}...</a>
</div>
{/if}
</div>
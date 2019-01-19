{*<!--
/* ===================================================================
Modified By: Jitendra, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 16 / 09 / 2014
Change Reason: Multiple Term Details Feature, File modified
=================================================================== */

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
<!--form action start-->
<style>
.ui-wrapper{
	height:100% !important;
}
</style>
<div id="PDFSettings" class="contents row-fluid">
<form id="pdfsettingsform"  class="form-horizontal" method="POST">
<div class="widget_header row-fluid" id="prefPageHeader">
		<span class="span9">
			<span id="myPrefHeading" class="row-fluid"><h3>{vtranslate('LBL_PDF_SETTINGS',$QUALIFIED_MODULE)}</h3></span>
			<span class="row-fluid">{vtranslate('LBL_PDF_SETTINGS_DESC',$QUALIFIED_MODULE)}</span>
		</span>
	</span>
</div>
<br /><br />
<!--start edited by fadzil 27/2/15-->
<select name="displaymodul" class="chzn-select" id="displaymodul" style="width:30%;" onchange="tableswitch(this.value);">
	<optgroup>
			<option value="Quotes" {if $DETAILS['module'] eq 'Quotes'}selected{/if}>{vtranslate('LBL_QUOTES', $QUALIFIED_MODULE)}</option>								
			<option value="Invoice" {if $DETAILS['module'] eq 'Invoice'}selected{/if}>{vtranslate('LBL_INVOICE', $QUALIFIED_MODULE)}</option>				
			<option value="SalesOrder" {if $DETAILS['module'] eq 'SalesOrder'}selected{/if}>{vtranslate('LBL_SALESORDER', $QUALIFIED_MODULE)}</option>
			<option value="PurchaseOrder" {if $DETAILS['module'] eq 'PurchaseOrder'}selected{/if}>{vtranslate('LBL_PURCHASEORDER', $QUALIFIED_MODULE)}</option>
			<option value="Payments" {if $DETAILS['module'] eq 'Payments'}selected{/if}>{vtranslate('LBL_PAYMENTS', $QUALIFIED_MODULE)}</option>		
	</optgroup>
</select>
<!--end edited by fadzil 27/2/15-->
<br /><br />
<!--Header start-->
<div id="pdfconfig-wrap">
	<div id="general-wrap">
		<h4>{vtranslate('LBL_HEADER',$QUALIFIED_MODULE)}</h4>
		<ol>
		<li>{vtranslate('LBL_REPEAT_HEADER',$QUALIFIED_MODULE)}<input type="checkbox" name="repeatheader" id="repeatheader" {if $DETAILS['repeatheader'] eq 1}checked{/if}>
			<ol style="list-style-type: lower-alpha;">	
				<li>{vtranslate('LBL_SHOW_LOGO',$QUALIFIED_MODULE)}<input type="checkbox" name="showlogo" id="showlogo" {if $DETAILS['showlogo'] eq 1}checked{/if}></li>
				<li>{vtranslate('LBL_SHOW_ORGADD',$QUALIFIED_MODULE)}<input type="checkbox" name="showorgaddress" id="showorgaddress" {if $DETAILS['showorgaddress'] eq 1}checked{/if}></li>
				<li>{vtranslate('LBL_SHOW_SUMMARY',$QUALIFIED_MODULE)}<input type="checkbox" name="showsummary" id="showsummary" {if $DETAILS['showsummary'] eq 1}checked{/if}></li>
			</ol>
		</li>
		<li>{vtranslate('LBL_DISPLAY_DATE',$QUALIFIED_MODULE)}
			<select name="headerdate" id="headerdate">
				<option value="T" {if $DETAILS['headerdate'] eq 'T' }selected{/if}>{vtranslate('LBL_TODAY',$QUALIFIED_MODULE)}</option>	
				<option value="C" {if $DETAILS['headerdate'] eq 'C' }selected{/if}>{vtranslate('LBL_CREATEDTIME',$QUALIFIED_MODULE)}</option>
				<option value="M" {if $DETAILS['headerdate'] eq 'M' }selected{/if}>{vtranslate('LBL_MODIFIEDTIME',$QUALIFIED_MODULE)}</option>
			</select>
		</li>
		<li>{vtranslate('LBL_DISPLAY_PERSON',$QUALIFIED_MODULE)}<input type="checkbox" name="showperson_name" id="showperson_name" {if $DETAILS['showperson_name'] eq 1}checked{/if}></li>
		<li>{vtranslate('LBL_DISPLAY_PHONE',$QUALIFIED_MODULE)}<input type="checkbox" name="showphone" id="showphone" {if $DETAILS['showphone'] eq 1}checked{/if}></li>
		<li>{vtranslate('LBL_GAP_HEADER_LINE',$QUALIFIED_MODULE)}<select name="emptyline" id="emptyline">
				<option value="0" {if $DETAILS['emptyline'] eq 0 }selected{/if}>0</option>	
				<option value="1" {if $DETAILS['emptyline'] eq 1 }selected{/if}>1</option>
				<option value="2" {if $DETAILS['emptyline'] eq 2 }selected{/if}>2</option>
			</select></li>
		
		<li>{vtranslate('LBL_SHOW_SHIPPINGADD',$QUALIFIED_MODULE)}<input type="checkbox" name="showshipping" id="showshipping" {if $DETAILS['showshipping'] eq 1}checked{/if}></li>
		<li>{vtranslate('LBL_REPLACE_SHIPADD',$QUALIFIED_MODULE)}<input type="text" name="shippinglabel" id="shippinglabel" value="{$DETAILS['shippinglabel']}"></li>
		<li>{vtranslate('LBL_AVAILABLE_FONTS',$QUALIFIED_MODULE)}
		<select name="fontfamily" id="fontfamily">
			<option label="Aealarabiya" value="aealarabiya" {if $DETAILS['fontfamily'] eq 'aealarabiya' }selected{/if}>{vtranslate('AlArabia',$QUALIFIED_MODULE)}</option>
			<option label="Aefurat" value="aefurat" {if $DETAILS['fontfamily'] eq 'aefurat' }selected{/if}>{vtranslate('Furat',$QUALIFIED_MODULE)}</option>
			<option label="almohanad" value="almohanad" {if $DETAILS['fontfamily'] eq 'almohanad' }selected{/if}>{vtranslate('AlMohanad',$QUALIFIED_MODULE)}</option>
			<option label="arialunicid0" value="arialunicid0" {if $DETAILS['fontfamily'] eq 'arialunicid0' }selected{/if}>{vtranslate('Arial Unicode',$QUALIFIED_MODULE)}</option>
			<option label="courier" value="courier" {if $DETAILS['fontfamily'] eq 'courier' }selected{/if}>{vtranslate('Courier',$QUALIFIED_MODULE)}</option>
			<option label="courierb" value="courierb" {if $DETAILS['fontfamily'] eq 'courierb' }selected{/if}>{vtranslate('Courier Bold',$QUALIFIED_MODULE)}</option>
			<option label="freemonob" value="freemonob" {if $DETAILS['fontfamily'] eq 'freemonob' }selected{/if}>{vtranslate('Free Mono Bold',$QUALIFIED_MODULE)}</option>
			<option label="freemonobi" value="freemonobi" {if $DETAILS['fontfamily'] eq 'freemonobi' }selected{/if}>{vtranslate('Free Mono Bold Italic',$QUALIFIED_MODULE)}</option>
			<option label="freemonoi" value="freemonoi" {if $DETAILS['fontfamily'] eq 'freemonoi' }selected{/if}>{vtranslate('Free Mono Italic',$QUALIFIED_MODULE)}</option>
			<option label="freesansb" value="freesansb" {if $DETAILS['fontfamily'] eq 'freesansb' }selected{/if}>{vtranslate('Free Sans Bold',$QUALIFIED_MODULE)}</option>
			<option label="freesansbi" value="freesansbi" {if $DETAILS['fontfamily'] eq 'freesansbi' }selected{/if}>{vtranslate('Free Sans Bold Italic',$QUALIFIED_MODULE)}</option>
			<option label="freesansi" value="freesansi" {if $DETAILS['fontfamily'] eq 'freesansi' }selected{/if}>{vtranslate('Free Sans Italic',$QUALIFIED_MODULE)}</option>
			<option label="freeserif" value="freeserif" {if $DETAILS['fontfamily'] eq 'freeserif' }selected{/if}>{vtranslate('Free Serif',$QUALIFIED_MODULE)}</option>
			<option label="freeserifb" value="freeserifb" {if $DETAILS['fontfamily'] eq 'freeserifb' }selected{/if}>{vtranslate('Free Serif Bold',$QUALIFIED_MODULE)}</option>
			<option label="freeserifbi" value="freeserifbi" {if $DETAILS['fontfamily'] eq 'freeserifbi' }selected{/if}>{vtranslate('Free Serif Bold Italic',$QUALIFIED_MODULE)}</option>
			<option label="freeserifi" value="freeserifi" {if $DETAILS['fontfamily'] eq 'freeserifi' }selected{/if}>{vtranslate('Free Serif Italic',$QUALIFIED_MODULE)}</option>
			<option label="helvetica" value="helvetica" {if $DETAILS['fontfamily'] eq 'helvetica' }selected{/if}>{vtranslate('Helvetica',$QUALIFIED_MODULE)}</option>
			<option label="helveticab" value="helveticab" {if $DETAILS['fontfamily'] eq 'helveticab' }selected{/if}>{vtranslate('Helvetica Bold',$QUALIFIED_MODULE)}</option>
			<option label="helveticabi" value="helveticabi" {if $DETAILS['fontfamily'] eq 'helveticabi' }selected{/if}>{vtranslate('Helvetica Bold Italic',$QUALIFIED_MODULE)}</option>
			<option label="helveticai" value="helveticai" {if $DETAILS['fontfamily'] eq 'helveticai' }selected{/if}>{vtranslate('Helvetica Italic',$QUALIFIED_MODULE)}</option>
			<option label="pdfatimes" value="pdfatimes" {if $DETAILS['fontfamily'] eq 'pdfatimes' }selected{/if}>{vtranslate('Times New Roman',$QUALIFIED_MODULE)}</option>
			<option label="verase" value="verase" {if $DETAILS['fontfamily'] eq 'verase' }selected{/if}>{vtranslate('Verase',$QUALIFIED_MODULE)}</option>
		</select>
</li>		</ol>
	</div>
	<div style="clear:both"></div>
	<br />
	<!--Header end-->
	
	{if $DISPLAYMODULE eq 'Payments'}

	<!-- payments information start-->
	<div id="paymentwrap">
		<h4>{vtranslate('LBL_PAYMENT_INFO',$QUALIFIED_MODULE)}</h4>
		<span>{vtranslate('LBL_CHOOSE_COLUMN',$QUALIFIED_MODULE)}</span>

		<ol>
			<li>{vtranslate('Payment Ref.',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentRef" id="paymentRef" {if $DETAILS['paymentref'] eq 1}checked{/if}></li>
			<li>{vtranslate('Amount',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentAmmount" id="paymentAmmount" {if $DETAILS['paymentammount'] eq 1}checked{/if}></li>
			<li>{vtranslate('Payment For',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentFor" id="paymentFor" {if $DETAILS['paymentfor'] eq 1}checked{/if}></li>
			<li>{vtranslate('Ref. No.',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentRefNo" id="paymentRefNo" {if $DETAILS['paymentrefno'] eq 1}checked{/if}></li>
			<li>{vtranslate('Mode',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentMode" id="paymentMode" {if $DETAILS['paymentmode'] eq 1}checked{/if}></li>
			<li>{vtranslate('Bank Name',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentBankName" id="paymentBankName" {if $DETAILS['paymentbankname'] eq 1}checked{/if}></li>
			<li>{vtranslate('Bank Account Name',$QUALIFIED_MODULE)}<input type="checkbox" name="paymentBankAccount" id="paymentBankAccount" {if $DETAILS['paymentbankaccount'] eq 1}checked{/if}></li>
				
		</ol>
	</div>
	<div style="clear:both"></div>
	<!--payments information end-->

{else}

	<!--Line Item Section start-->
	<div class="contents tabbable ui-sortable" id="tab">
		<ul class="nav nav-tabs layoutTabs massEditTabs"> 
			<li class="relatedListTab active">
				<a data-toggle="tab" href="#groupwrap"><strong>{vtranslate('LBL_GROUP', $QUALIFIED_MODULE)}</strong></a>
			</li>
			<li class="relatedListTab">
				<a data-toggle="tab" href="#indwrap"><strong>{vtranslate('LBL_INDIVIDUAL', $QUALIFIED_MODULE)}</strong></a>
			</li>
		</ul>
	</div>
	<div class="tab-content">
		<!-- Start Group Section -->
		<div class="tab-pane active" id="groupwrap">
					<span>{vtranslate('LBL_CHOOSE_COLUMN',$QUALIFIED_MODULE)}</span>
					<table class="table table-bordered table-condensed listViewEntriesTable">
						<thead>
							<tr class="listViewHeaders">
								<th id="pdfColumnNo" {if $DETAILS['showgroupno'] eq 0}style="display: none;"{/if}>{vtranslate('No.',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnOrderCode" {if $DETAILS['showgrouporder'] eq 0}style="display: none;"{/if}>{vtranslate('Order Code',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnItemId" {if $DETAILS['showgroupdesc'] eq 0}style="display: none;"{/if}>{vtranslate('Item',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnQty" {if $DETAILS['showgroupsqm'] eq 0}style="display: none;"{/if}>{vtranslate('Qty.',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnUnit" {if $DETAILS['showgroupunit'] eq 0}style="display: none;"{/if}>{vtranslate('Unit',$QUALIFIED_MODULE)}</th> 
								<th id="pdfColumnUnitPrice" {if $DETAILS['showgpricesqm'] eq 0}style="display: none;"{/if}>{vtranslate('Unit Price',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnDiscount" {if $DETAILS['showgroupdiscount'] eq 0}style="display: none;"{/if}>{vtranslate('Discount',$QUALIFIED_MODULE)}</th>
								<th id="pdfColumnTotal" {if $DETAILS['showgroupamount'] eq 0}style="display: none;"{/if}>{vtranslate('Total',$QUALIFIED_MODULE)}</th>

							</tr>
						</thead>
					</table>
					<ol>
						<li>{vtranslate('No.',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupno" id="showgroupno" {if $DETAILS['showgroupno'] eq 1}checked{/if}></li>
						<li>{vtranslate('Order',$QUALIFIED_MODULE)}<input type="checkbox" name="showgrouporder" id="showgrouporder" {if $DETAILS['showgrouporder'] eq 1}checked{/if}></li>

						<li>{vtranslate('Item',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupdesc" id="showgroupitem" disabled {if $DETAILS['showgroupdesc'] eq 1}checked{/if}></li>
						<li>{vtranslate('Qty.',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupsqm" id="showgroupsqm" {if $DETAILS['showgroupsqm'] eq 1}checked{/if}></li>
						<li>{vtranslate('Unit',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupunit" id="showgroupunit" {if $DETAILS['showgroupunit'] eq 1}checked{/if}></li>
						<li>{vtranslate('Unitprice',$QUALIFIED_MODULE)}<input type="checkbox" name="showgpricesqm" id="showgpricesqm" {if $DETAILS['showgpricesqm'] eq 1}checked{/if}></li>
						<li>{vtranslate('Discount',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupdiscount" id="showgroupdiscount" {if $DETAILS['showgroupdiscount'] eq 1}checked{/if}></li>
						<li>{vtranslate('Total',$QUALIFIED_MODULE)}<input type="checkbox" name="showgroupamount"  id="showgroupamount" {if $DETAILS['showgroupamount'] eq 1}checked{/if}></li>	
					</ol>
			</div>
		<!-- End Group Section -->
		
		<!-- Start Ind Section --->
		<div id="indwrap" class="tab-pane">
			<span>{vtranslate('LBL_CHOOSE_COLUMN',$QUALIFIED_MODULE)}</span>
				<table class="table table-bordered table-condensed listViewEntriesTable">
					<thead>
						<tr class="listViewHeaders">
							<th id="indTaxNo" {if $DETAILS['showindno'] eq 0}style="display: none;"{/if}>{vtranslate('No.	',$QUALIFIED_MODULE)}</th>
							<th id="indTaxOrderCode" {if $DETAILS['showindorder'] eq 0}style="display: none;"{/if}>{vtranslate('Order Code',$QUALIFIED_MODULE)}</th> 
							<th id="indTaxItemId" {if $DETAILS['showinddesc'] eq 0}style="display: none;"{/if}>{vtranslate('Item',$QUALIFIED_MODULE)}</th>
							<th id="indTaxQty" {if $DETAILS['showindsqm'] eq 0}style="display: none;"{/if}>{vtranslate('Qty.',$QUALIFIED_MODULE)}</th>
							<th id="indTaxUnit" {if $DETAILS['showindunit'] eq 0}style="display: none;"{/if}>{vtranslate('Unit',$QUALIFIED_MODULE)}</th>
							<th id="indTaxUnitPrice" {if $DETAILS['showindpricesqm'] eq 0}style="display: none;"{/if}>{vtranslate('Unit Price',$QUALIFIED_MODULE)}</th>
							<th id="indTaxDiscount" {if $DETAILS['showinddiscount'] eq 0}style="display: none;"{/if}>{vtranslate('Discount',$QUALIFIED_MODULE)}</th>
							<th id="indTaxGst" {if $DETAILS['showindgst'] eq 0}style="display: none;"{/if}>{vtranslate('Tax',$QUALIFIED_MODULE)}</th>
							<th id="indTaxTotal" {if $DETAILS['showindamount'] eq 0}style="display: none;"{/if}>{vtranslate('Total',$QUALIFIED_MODULE)}</th>

						</tr>
					</thead>
				</table>
					<ol>
						<li>{vtranslate('No.',$QUALIFIED_MODULE)}<input type="checkbox" name="showindno" id="showindno" {if $DETAILS['showindno'] eq 1}checked{/if}></li>
						<li>{vtranslate('Order',$QUALIFIED_MODULE)}<input type="checkbox" name="showindorder" id="showindorder" {if $DETAILS['showindorder'] eq 1}checked{/if}></li> 
						<li>{vtranslate('Item',$QUALIFIED_MODULE)}<input type="checkbox" name="showinddesc"  id="showinditem" disabled {if $DETAILS['showinddesc'] eq 1}checked{/if}></li>
						<li>{vtranslate('Qty.',$QUALIFIED_MODULE)}<input type="checkbox" name="showindsqm" id="showindsqm" {if $DETAILS['showindsqm'] eq 1}checked{/if}></li>
						<li>{vtranslate('Unit',$QUALIFIED_MODULE)}<input type="checkbox" name="showindunit" id="showindunit" {if $DETAILS['showindunit'] eq 1}checked{/if}></li> 
						<li>{vtranslate('Unitprice',$QUALIFIED_MODULE)}<input type="checkbox" name="showindpricesqm" id="showindpricesqm" {if $DETAILS['showindpricesqm'] eq 1}checked{/if}></li>
						<li>{vtranslate('Discount',$QUALIFIED_MODULE)}<input type="checkbox" name="showinddiscount" id="showinddiscount" {if $DETAILS['showinddiscount'] eq 1}checked{/if}></li>
						<li>{vtranslate('Tax',$QUALIFIED_MODULE)}<input type="checkbox" name="showindgst" id="showindgst" {if $DETAILS['showindgst'] eq 1}checked{/if}></li>
						<li>{vtranslate('Total',$QUALIFIED_MODULE)}<input type="checkbox" name="showindamount"  id="showindamount" {if $DETAILS['showindamount'] eq 1}checked{/if}></li>
					</ol>
		</div>
		<!-- End here Ind Section -->
	</div>
	<div style="clear:both"></div>
	<br />
	<!-- Discount Section -->
	<div id="general-wrap">
		<h4>{vtranslate('LBL_DISCOUNT',$QUALIFIED_MODULE)}</h4>
		<ol>
			<li>
				<div>{vtranslate('LBL_LINE_DISCOUNT_DETAIL',$QUALIFIED_MODULE)}
				<input type="checkbox" name="showlineitemdiscountdetails" id="showlineitemdiscountdetails" {if $DETAILS['showlineitemdiscountdetails'] eq 1}checked{/if}> 
				</div>
			</li>
			<li>
				<div>{vtranslate('LBL_OVERALL_DISCOUNT_DETAIL',$QUALIFIED_MODULE)}
				<input type="checkbox" name="showoveralldiscountdetails" id="showoveralldiscountdetails" {if $DETAILS['showoveralldiscountdetails'] eq 1}checked{/if}> 
				</div>
			</li>
		</ol>
	</div>
	
{/if}
	<!--End Discount Section -->
	<!---Line item Section End -->
	<div style="clear:both"></div>
	<br />
	<div id="general-wrap">
		<h4>{vtranslate('LBL_FOOTER',$QUALIFIED_MODULE)}</h4>
		<ol>
		<li>{vtranslate('LBL_REPEAT_FOOTER',$QUALIFIED_MODULE)}<input type="checkbox" name="repeatfooter" id="repeatfooter" {if $DETAILS['repeatfooter'] eq 1}checked{/if}></li>	
		<li>{vtranslate('LBL_SHOW_PAGENO',$QUALIFIED_MODULE)}<input type="checkbox" name="showpager" id="showpager" {if $DETAILS['showpager'] eq 1}checked{/if}></li>
		<li>{vtranslate('LBL_SHOW_FOOTER',$QUALIFIED_MODULE)}<input type="checkbox" name="showfooter" id="showfooter" {if $DETAILS['showfooter'] eq 1}checked{/if}></li>	
		<li>{vtranslate('LBL_CUSTOM_FOOTER',$QUALIFIED_MODULE)}<textarea class=small id="customfooter" name="customfooter" data-validation-engine="validate[required]">{$DETAILS['customfooter']}</textarea></li>
		</ol>
	</div>
	
	<div style="width:725px;"><button class="btn btn-success pull-right" style="margin-top:10px;" type="submit" name="save" id="savePDFSetting"; value="Save">Save</button>
	</div>	
</div>
</form>
<!--form action end-->

</div>


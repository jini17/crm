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

<!--- Added by jitu@23-04-2015 for display Restrict Actions -->
<div class="filterContainer">
	<div class="allConditionContainer conditionGroup contentsBackground well">
		<div class="header">
			<span><strong>{vtranslate('LBL_RESTRICT_ACTIONS',$MODULE)}</strong></span>
		</div>
		<div class="contents">
			<div class="conditionList">
				<form id="MultipleActionsForm" class="form-horizontal" method="POST">
				<table class="table table-bordered table-condensed listViewEntriesTable">
					<thead>
						<tr class="listViewHeaders">
							<th id="codeDescription">{vtranslate('LBL_ACTION_DESC',$MODULE)}</th>
							<th id="restrict">{vtranslate('LBL_RESTRICT',$MODULE)}</th>
							<th id="allowAction">{vtranslate('LBL_ALLOW_ACTION',$MODULE)}</th>
						</tr>
					</thead>
					<tr>
						<td>{vtranslate('LBL_CONVERTLEAD',$MODULE)}</td>
						<td><input type="checkbox" name="Leads_cla" id="Leads_cla" {if $DETAILS['CLA']['isrestrict']==1}checked{/if} /></td>
						<td style="width:60%;">
							<select multiple name="Leads_cla_action" class="select2 inputElement col-lg-12" id="Leads__cla_action">	
			{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Leads']}						<option {if strpos($DETAILS['CLA']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
					
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_GENERATEINVOICE_FROMQUOTE',$MODULE)}</td>
						<td><input type="checkbox" name="Quotes_giq" id="Quotes_giq"  {if $DETAILS['GIQ']['isrestrict']==1}checked{/if} /></td>
						<td>
						<select multiple name="Quotes_giq_action" class="select2 inputElement col-lg-12" id="Quotes_giq_action" style="width:67%;">	
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Quotes']}						<option {if strpos($DETAILS['GIQ']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}		
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_GENERATESALESORDER_FROMQUOTE',$MODULE)}</td>
						<td><input type="checkbox" name="Quotes_gsq" id="Quotes_gsq" {if $DETAILS['GSQ']['isrestrict']==1}checked{/if}  /></td>
						<td><select multiple name="Quotes_gsq_action" class="select2 inputElement col-lg-12" id="Quotes_gsq_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Quotes']}						<option {if strpos($DETAILS['GSQ']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_GENERATEPURCHASEORDER_FROMQUOTE',$MODULE)}</td>
						<td><input type="checkbox" name="Quotes_gpq" id="Quotes_gpq" {if $DETAILS['GPQ']['isrestrict']==1}checked{/if}  /></td>
						<td><select multiple name="Quotes_gpq_action" class="select2 inputElement col-lg-12" id="Quotes_gpq_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Quotes']}						<option {if strpos($DETAILS['GPQ']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_CREATEINVOICE_FROMSALESORDER',$MODULE)}</td>
						<td><input type="checkbox" name="SalesOrder_cis" id="SalesOrder_cis" {if $DETAILS['CIS']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="SalesOrder_cis_action" class="select2 inputElement col-lg-12" id="SalesOrder_cis_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['SalesOrder']}						<option {if strpos($DETAILS['CIS']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_CREATEPURCHASEORDER_FROMSALESORDER',$MODULE)}</td>
						<td><input type="checkbox" name="SalesOrder_cps" id="SalesOrder_cps" {if $DETAILS['CPS']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="SalesOrder_cps_action" class="select2 inputElement col-lg-12" id="SalesOrder_cps_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['SalesOrder']}						<option {if strpos($DETAILS['CPS']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_CREATEINVOICE_FROMHELPDESK',$MODULE)}</td>
						<td><input type="checkbox" name="HelpDesk_cih" id="HelpDesk_cih" {if $DETAILS['CIH']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="HelpDesk_cih_action" class="select2 inputElement col-lg-12" id="HelpDesk_cih_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['HelpDesk']}						<option {if strpos($DETAILS['CIH']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<!--<tr>
						<td>{vtranslate('LBL_CREATEDO_FROMSALESORDER',$MODULE)}</td>
						<td><input type="checkbox" name="SalesOrder_cds" id="SalesOrder_cds" {if $DETAILS['CDS']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="SalesOrder_cds_action" class="select2 inputElement col-lg-12" id="SalesOrder_cds_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['SalesOrder']}						<option {if strpos($DETAILS['CDS']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_CREATEDO_FROMINVOICE',$MODULE)}</td>
						<td><input type="checkbox" name="Invoice_cdi" id="Invoice_cdi" {if $DETAILS['CDI']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="Invoice_cdi_action" class="select2 inputElement col-lg-12" id="Invoice_cdi_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Invoice']}						<option {if strpos($DETAILS['CDI']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>-->
					<tr>
						<td>{vtranslate('LBL_CREATE_SERVICE_REQUEST',$MODULE)}<br /><span style='font-size:12px;'>({vtranslate('LBL_CREATEINVOICE_FROMHELPDESKDESC',$MODULE)})</span></td>
						<td><input type="checkbox" name="ServiceContracts_csr" id="ServiceContracts_csr" {if $DETAILS['CSR']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="ServiceContracts_csr_action" class="select2 inputElement col-lg-12" id="ServiceContracts_csr_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['ServiceContracts']}						<option {if strpos($DETAILS['CSR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	
					<tr>
						<td>{vtranslate('LBL_SEND_QUOTE_EMAIL',$MODULE)}</td>
						<td><input type="checkbox" name="Quotes_sqe" id="Quotes_sqe" {if $DETAILS['SQE']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="Quotes_sqe_action" class="select2 inputElement col-lg-12" id="Quotes_sqe_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Quotes']}						<option {if strpos($DETAILS['SQE']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}	
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_SEND_INVOICE_EMAIL',$MODULE)}</td>
						<td><input type="checkbox" name="Invoice_sie" id="Quotes_sie" {if $DETAILS['SIE']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="Invoice_sie_action" class="select2 inputElement col-lg-12" id="Invoice_sie_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Invoice']}						<option {if strpos($DETAILS['SIE']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_SEND_SALESORDER_EMAIL',$MODULE)}</td>
						<td><input type="checkbox" name="SalesOrder_sse" id="SalesOrder_sse" {if $DETAILS['SSE']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="SalesOrder_sse_action" class="select2 inputElement col-lg-12" id="SalesOrder_sse_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['SalesOrder']}						<option {if strpos($DETAILS['SSE']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
				<!--	<tr>
						<td>{vtranslate('LBL_SEND_DO_EMAIL',$MODULE)}</td>
						<td><input type="checkbox" name="DeliveryOrder_sde" id="DeliveryOrder_dse" {if $DETAILS['SDE']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="DeliveryOrder_sde_action" class="select2 inputElement col-lg-12" id="DeliveryOrder_dse_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['DeliveryOrder']}						<option {if strpos($DETAILS['SDE']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	-->
				</table>
				<div class="header">
					<span><strong>{vtranslate('LBL_MAKE_READ_ONLY_ACTIONS',$MODULE)}</strong></span>
				</div>
				<table class="table table-bordered table-condensed listViewEntriesTable">
					<tr>
						<td>{vtranslate('LBL_SALESORDER_READ_ONLY',$MODULE)}</td>
						<td><input type="checkbox" name="SalesOrder_sor" id="SalesOrder_sor" {if $DETAILS['SOR']['isrestrict']==1}checked{/if} /></td>
						<td style="width:60%;"><select multiple name="SalesOrder_sor_action" class="select2 inputElement col-lg-12" id="SalesOrder_sor_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['SalesOrder']}						<option {if strpos($DETAILS['SOR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>
					<tr>
						<td>{vtranslate('LBL_QUOTES_READ_ONLY',$MODULE)}</td>
						<td><input type="checkbox" name="Quotes_qor" id="Quotes_qor" {if $DETAILS['QOR']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="Quotes_qor_action" class="select2 inputElement col-lg-12" id="Quotes_qor_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Quotes']}						<option {if strpos($DETAILS['QOR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	
					<tr>
						<td>{vtranslate('LBL_INVOICE_READ_ONLY',$MODULE)}</td>
						<td><input type="checkbox" name="Invoice_ior" id="Invoice_ior" {if $DETAILS['IOR']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="Invoice_ior_action" class="select2 inputElement col-lg-12" id="Invoice_ior_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['Invoice']}						<option {if strpos($DETAILS['IOR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	

					<tr>
						<td>{vtranslate('LBL_PURCHASEORDER_READ_ONLY',$MODULE)}</td>
						<td><input type="checkbox" name="PurchaseOrder_por" id="PurchaseOrder_por" {if $DETAILS['POR']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="PurchaseOrder_por_action" class="select2 inputElement col-lg-12" id="PurchaseOrder_por_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['PurchaseOrder']}						<option {if strpos($DETAILS['POR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	
					<!--<tr>
						<td>{vtranslate('LBL_DELIVERYORDER_READ_ONLY',$MODULE)}</td>
						<td><input type="checkbox" name="DeliveryOrder_dor" id="DeliveryOrder_dor" {if $DETAILS['DOR']['isrestrict']==1}checked{/if} /></td>
						<td><select multiple name="DeliveryOrder_dor_action" class="select2 inputElement col-lg-12" id="DeliveryOrder_dor_action" style="width:67%;">
						
							{foreach key=PICKLIST_STATUS item=PICKLIST_VALUE from=$PICKLIST_VALUES['DeliveryOrder']}						<option {if strpos($DETAILS['DOR']['statusvalue'], $PICKLIST_VALUE) !== false} selected{/if} value="{$PICKLIST_VALUE}">{$PICKLIST_VALUE}</option>
						{/foreach}
						
</select></td>
					</tr>	-->
			
				</table>
				<div class='clearfix' style="padding-top: 10px;">
	                <div class="row clearfix">
	                    <div class=' textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
	                        <button type='submit' class='btn btn-success saveButton' name="save" id="saveActions" >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
	                        <a class='cancelLink btn btn-danger'  href="javascript:history.back()" type="reset">{vtranslate('LBL_CANCEL', $MODULE)}</a>
	                    </div>
	                </div>
            	</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<!-- End here -->

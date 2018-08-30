{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created by afiq@secondcrm.com for Multiple Company Numbering
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
       <div class="row-fluid">
            <span class="widget_header row-fluid">
                <div class="row-fluid"><h3>{vtranslate('LBL_COMPANY_NUMBERING_SETTING', $QUALIFIED_MODULE)}</h3></div>
            </span>
        </div>
        <hr>
				<input type="hidden" value="{$COMPANYNUMBERING}" name="hidBusiness" id="hidBusiness">
        <div class="row-fluid">
            <div class="span12">
                <table id="customRecordNumbering" class="table table-bordered">
				{assign var=WIDTHTYPE value="200"}
		 <tbody>
					<tr>
                        <td>
			    <input type="checkbox" name="business" id="business" {if $COMPANYNUMBERING eq 1} checked {/if}/>
			</td>
                        <td class="fieldValue {$WIDTHTYPE}" style="border-left: none">
			    <!-- add text and Payments for Payments as Inventory module -->		
                            Separate numbering for Business Document (Quotes, Invoces,Sales Order, Purchase Order and Payments)
			   <!-- End here-->	
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row-fluid">
            <div class="span12 pull-right">
                <div > <!-- class="pull-right"-->
                    <button id="saveNumbering" class="btn btn-success saveButton" disabled=""><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
                    <a class="cancelLink" type="reset" onclick="javascript:window.history.back();">{vtranslate('LBL_CANCEL', $QUALIFIED_MODULE)}</a>
                </div>
            </div>
        </div>
</div>
{/strip}

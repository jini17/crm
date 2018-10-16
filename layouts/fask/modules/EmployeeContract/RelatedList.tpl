{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{strip}
	
	<div id="relatedClaims" style="width:30%;margin-left:2%">
		
			{if count($CLAIMDETAILS) > 0}
				  <div class='row th' style="padding:5px">			 
				            <div class='col-lg-3'>
				                <strong>{vtranslate('Allocated', $MODULE_NAME)}</strong>
				            </div>
				            <div class='col-lg-2'>
				                <strong>{vtranslate('Used', $MODULE_NAME)}</strong>
				            </div>
				            <div class='col-lg-3'>
				                <strong>{vtranslate('Balance', $MODULE_NAME)}</strong>
				            </div>
				            <div class='col-lg-4'>
				                <strong>{vtranslate('Type', $MODULE_NAME)}</strong>
				            </div>			         
			        </div>			
						{foreach item=CLAIMDETAIL from=$CLAIMDETAILS}
						
						<div class='row miniListContent' style="padding:5px">
							<div class='col-lg-3' >
								{$CLAIMDETAIL['allocated']}
							</div>
							<div class='col-lg-2' >
								{$CLAIMDETAIL['used']}
							</div>
							<div class='col-lg-3' >
								{$CLAIMDETAIL['balance']|string_format:"%.2f"}
							</div>
							<div class='col-lg-4'>	
								{$CLAIMDETAIL['category']}
							</div>
						</div>
						{/foreach}					
			{else}
				<span class="noDataMsg">
					{vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
				</span>
			{/if}
		


	</div>	

{/strip}
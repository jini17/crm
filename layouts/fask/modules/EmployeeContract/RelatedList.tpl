{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Mabruk
************************************************************************************}
{strip}
<!---------------------------------------------------------------CLAIM DETAIL------------------------------------------------------------------>

<div class="block BLOCK_LBL_EMPLOYEE_CLAIMS">   
   <div>
      <h5 class="textOverflowEllipsis maxWidth100"><i class="ti-plus cursorPointer alignMiddle blockToggle" data-mode="hide" data-id="140" style="display: none;"></i><i class="ti-minus cursorPointer alignMiddle blockToggle" data-mode="show" data-id="140" style="display: inline;"></i>&nbsp;Employee Claim Detail</h5>
   </div>
   <div class="blockData">	
   		<div class="table detailview-table">
	   		<div style="display: block;">
				<div id="relatedClaims" style="width:40%;margin-left:2%">
					
						{if count($CLAIMDETAILS) > 0}

							    <div class='row th' style="padding:5px">			 
							            <div class='col-lg-3' align="center">
							                <strong>{vtranslate('Allocated', $MODULE_NAME)}</strong>
							            </div>
							            <div class='col-lg-2' align="center">
							                <strong>{vtranslate('Used', $MODULE_NAME)}</strong>
							            </div>
							            <div class='col-lg-3' align="center">
							                <strong>{vtranslate('Balance', $MODULE_NAME)}</strong>
							            </div>
							            <div class='col-lg-4' align="center">
							                <strong>{vtranslate('Type', $MODULE_NAME)}</strong>
							            </div>			         
						        </div>	

								{foreach item=CLAIMDETAIL from=$CLAIMDETAILS}
									
									<div class='row miniListContent' style="padding:5px">
										<div class='col-lg-3' align="center">
											{$CLAIMDETAIL['allocated']}
										</div>
										<div class='col-lg-2' align="center">
											{$CLAIMDETAIL['used']}
										</div>
										<div class='col-lg-3' align="center">
											{$CLAIMDETAIL['balance']|string_format:"%.2f"}
										</div>
										<div class='col-lg-4' align="center">	
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
			</div>	
		</div>
	</div>
</div>

<!---------------------------------------------------------------LEAVE DETAIL------------------------------------------------------------------>
<div class="block BLOCK_LBL_EMPLOYEE_LEAVES">   
   <div>
      <h5 class="textOverflowEllipsis maxWidth100"><i class="ti-plus cursorPointer alignMiddle blockToggle" data-mode="hide" data-id="140" style="display: none;"></i><i class="ti-minus cursorPointer alignMiddle blockToggle" data-mode="show" data-id="140" style="display: inline;"></i>&nbsp;Employee Leave Detail</h5>
   </div>
   <div class="blockData">	
   		<div class="table detailview-table">
	   		<div style="display: block;">
				<div id="relatedLeaves" style="width:40%;margin-left:2%">
				{if count($LEAVEDETAILS) > 0}
					<div>

						<div class='row th' style="padding:5px">
				              <div class='col-lg-3' align="center">
				                  <strong>{vtranslate('Allocates', $MODULE_NAME)}</strong>
				              </div>
				              <div class='col-lg-2' align="center">
				                  <strong>{vtranslate('Used', $MODULE_NAME)}</strong>
				              </div>
				              <div class='col-lg-3' align="center">
				                  <strong>{vtranslate('Balanced', $MODULE_NAME)}</strong>
				              </div>
				              <div class='col-lg-4' align="center">
				                  <strong>{vtranslate('Type', $MODULE_NAME)}</strong>
				              </div>
				        </div>
							{foreach item=LEAVEDETAIL from=$LEAVEDETAILS['display']}
							
							<div class='row miniListContent' style="padding:5px;">
								<div class='col-lg-3' align="center">
									{$LEAVEDETAIL['allocateleaves']}
								</div>
								<div class='col-lg-2' align="center">
									{$LEAVEDETAIL['takenleave']}
								</div>
								<div class='col-lg-3' align="center">
									{$LEAVEDETAIL['balanceleave']}
								</div>
								<div class='col-lg-4' align="center">
									{$LEAVEDETAIL['leavetype']}
								</div>
							</div>

							{/foreach}
					</div>		
				{else}
					<span class="noDataMsg">
						{vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
					</span>
				{/if}
				</div>		
			</div>	
		</div>
	</div>
</div>



<!---------------------------------------------------------------BENEFIT DETAIL------------------------------------------------------------------>
<div class="block BLOCK_LBL_EMPLOYEE_BENEFITS">   
   <div>
      <h5 class="textOverflowEllipsis maxWidth100"><i class="ti-plus cursorPointer alignMiddle blockToggle" data-mode="hide" data-id="140" style="display: none;"></i><i class="ti-minus cursorPointer alignMiddle blockToggle" data-mode="show" data-id="140" style="display: inline;"></i>&nbsp;Employee Benefit Detail</h5>
   </div>
   <div class="blockData">	
   		<div class="table detailview-table">
	   		<div style="display: block;">
				<div id="relatedBenefits" style="width:40%;margin-left:2%">
				{if count($BENEFITDETAILS) > 0}
					<div>

						<div class='row th' style="padding:5px">
				              <div class='col-lg-4' align="center">
				                  <strong>{vtranslate('Benefit Code', $MODULE_NAME)}</strong>
				              </div>
				              <div class='col-lg-4' align="center">
				                  <strong>{vtranslate('Title', $MODULE_NAME)}</strong>
				              </div>
				              <div class='col-lg-4' align="center">
				                  <strong>{vtranslate('Benefit Type', $MODULE_NAME)}</strong>
				              </div>
				              <!--<div class='col-lg-4' align="center">
				                  <strong>{vtranslate('Status', $MODULE_NAME)}</strong>
				              </div>-->
				        </div>
							{foreach item=BENEFITDETAIL from=$BENEFITDETAILS}
							
							<div class='row miniListContent' style="padding:5px;">
								<div class='col-lg-4' align="center">
									{$BENEFITDETAIL['benefit_code']}
								</div>
								<div class='col-lg-4' align="center">
									{$BENEFITDETAIL['title']}
								</div>
								<div class='col-lg-4' align="center">
									{$BENEFITDETAIL['benefit_type']}
								</div>
								<!--<div class='col-lg-4' align="center">
									{$BENEFITDETAIL['status']}
								</div>-->
							</div>

							{/foreach}
					</div>		
				{else}
					<span class="noDataMsg">
						{vtranslate('LBL_NO')} {vtranslate($MODULE_NAME, $MODULE_NAME)} {vtranslate('LBL_MATCHED_THIS_CRITERIA')}
					</span>
				{/if}
				</div>		
			</div>	
		</div>
	</div>
</div>

{/strip}
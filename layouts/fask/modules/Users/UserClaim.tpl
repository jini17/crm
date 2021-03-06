{strip}
{if $SECTION eq 'M'}
<div class="block listViewContentDiv" id="listViewContents" style="marign-top: 15px;">
	<div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
		<div class="bottomscroll-div">
			<div>
				<h5>{vtranslate('Claims', $MODULE)}</h5>
			</div>
			<hr>
			<table class="table detailview-table listViewEntriesTable">
				<thead>
					<tr>
						<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
						<th nowrap>{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
						<th nowrap>{vtranslate('LBL_STATUS_CLAIM', $MODULE)}</th>
						<th nowrap>{vtranslate('LBL_TRANSACTION_DATE', $MODULE)}</th>
						<th nowrap>{vtranslate('LBL_AMOUNT', $MODULE)}</th>
						<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>	
					</tr>
				</thead>
				<tbody>
					{if count($MYCLAIM) gt 0}
					{foreach item=USER_CLAIM from=$MYCLAIM}
					<tr data-section="M">
						<td class="medium" valign=top>{$USER_CLAIM['claimno']}</td>
						<td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_CLAIM['color_code']};width:30px;height:20px;"></label>
						<span style="float:left;" >{$USER_CLAIM['category']}</span></td>		
						<td class="medium" valign=top>{$USER_CLAIM['claim_status']}</td>
						<td class="medium" valign=top>{$USER_CLAIM['transactiondate']}</td>
						<td class="medium" valign=top>{$USER_CLAIM['totalamount']}</td>
						<td class="medium" valign=top>

							<div class="pull-left actions">
								<span class="actionImages">
								  {if $USER_CLAIM['attachment'] neq ''}     

			                        <a href="index.php?module=Claim&action=DownloadAttachment&record={$USER_CLAIM['claimid']}&attachmentid={$USER_CLAIM['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
			                      {/if}
								
								{if $USER_CLAIM['claim_status'] eq 'Apply'}
								<a class="editLeave cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Claim_Js.editClaim('index.php{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USERID}&claim_status={$USER_CLAIM['claim_status']}&manager=false');"></a>
								{/if}

									<input type="hidden" name="manager" id="manager" value="false" />
								{if $USER_CLAIM['claim_status'] eq 'Apply'}
									<a class="deleteLeave cursorPointer" onclick="Users_Claim_Js.deleteClaim('index.php?module=Claim&action=Delete&record={$USER_CLAIM['claimid']}');"><i class="fa fa-trash" title="Delete"></i></a>
								{/if} 

							</span>
						</div>
					</td>
				</tr>
				{/foreach}
				{else}
				<tr><td colspan="6"><center>{vtranslate('LBL_NO_CLAIM_FOUND', $MODULE)}</center></td></tr>
				{/if}
			</tbody>			
		</table>
	</div>
</div>		
</div>


<!--@@@@@@@@@@@@START PAGINATION TOOLS@@@@@@@@@@@@@@@-->
{elseif $SECTION eq 'T'}
<div class="listViewActionsDiv row-fluid">                
    <div class="btn-group pull-right">
            <input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
            <input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
            <input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
            <input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
            <input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
            <input type="hidden" id="totalPage" value="{$PCOUNT}" />
            
            <input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
            <input type='hidden' value="{$PAGE_LIMIT}" id='pageLimit'>
            <input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">

            <button type="button" id="ClaimPreviousPageButton" class="btn btn-secondary" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if}><i class="material-icons">chevron_left</i></button>
          <!--   <button type="button" id="PageJump" data-toggle="dropdown" class="btn btn-secondary" aria-expanded="false">
                <i class="material-icons icon" title="Page Jump">more_horiz</i>
            </button>
            
           <ul class="listViewBasicAction dropdown-menu" id="PageJumpDropDown">
                <li>
                    <div class="listview-pagenum">
                        <span>Page</span>&nbsp;
                        <strong><span>{$PAGING_MODEL->getRecordStartRange()}</span></strong>&nbsp;
                        <span>of</span>&nbsp;
                        <strong><span id="totalPageCount">{$PCOUNT}</span></strong>
                    </div>
                    <div class="listview-pagejump">
                        <input id="pageToJump" placeholder="Jump To" class="listViewPagingInput text-center" type="text">&nbsp;
                        <button type="button" id="pageToJumpSubmit" class="btn btn-success listViewPagingInputSubmit text-center">GO</button>
                    </div>    
                </li>
            </ul>-->
            <button type="button" id="ClaimNextPageButton" class="btn btn-secondary" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if}><i class="material-icons">chevron_right</i></button>
    </div>
    <span class="pageNumbers  pull-right" style="position:relative;top:7px;">
        <span class="pageNumbersText">{$PAGING_MODEL->getRecordStartRange()} to {$PAGING_MODEL->getRecordEndRange()}</span>
            &nbsp;<span class="totalNumberOfRecords cursorPointer" title="Click for this list size">of {$LISTVIEW_COUNT}</span>&nbsp;&nbsp;
    </span>
</div>    
<!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->

<table class="table detailview-table  listViewEntriesTable">
	<thead>
		<tr>
			<th nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
			<th nowrap style="width:200px;">{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_TRANSACTION_DATE', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_AMOUNT', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_CLAIM_STATUS', $MODULE)}</th>

			<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>

		</tr>
	</thead>
	<tbody>
		{if count($MYTEAMCLAIMS) gt 0}
		{foreach item=USER_CLAIM from=$MYTEAMCLAIMS}

		<tr data-section="T">
			<td class="medium" valign=top>{$USER_CLAIM['fullname']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['claimno']}</td>
			<td class="medium" valign=top>
				<span style="background-color:{$USER_CLAIM['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></span>{$USER_CLAIM['category']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['transactiondate']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['totalamount']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['claim_status']}</td>

			<td class="medium" valign=top>
				<div class="pull-left actions">
					<span class="actionImages">

					  	{if $USER_CLAIM['attachment'] neq ''}     
	                        <a href="index.php?module=Claim&action=DownloadAttachment&record={$USER_CLAIM['claimid']}&attachmentid={$USER_CLAIM['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                       	{/if}



						{if $USER_CLAIM['claim_status'] eq 'Apply'} 
						<a class="editLeave cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Claim_Js.Popup_ClaimApprove('{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}&manager=true');"></a>

						<a class="cancelLeave cursorPointer" onclick="Users_Claim_Js.cancelClaim('?module=Users&action=DeleteSubModuleAjax&mode=cancelClaim&record={$USER_CLAIM['claimid']}&claim_type={$USER_CLAIM['claimtypeid']}&user_id={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}','T');"><i title="{vtranslate('LBL_CANCEL', $MODULE)}" class="fa fa-times-circle alignBottom"></i></a>				
						{/if}
					</span>
				</div>

			</td>
		</tr>
		{/foreach}
		{else}
		<tr><td colspan="7"><center>{vtranslate('LBL_NO_CLAIM_FOUND', $MODULE)}</center></td></tr>
		{/if}
	</tbody>				
</table>


{else}
<div style="margin-top:10px;" id="MyClaimContainer">
	<div style="float:right;margin-right:15px;margin-bottom:10px;">
		<button style="margin-left:15px;" type="button" class="btn btn-primary pull-right"onclick="Users_Claim_Js.addClaim('{$CREATE_CLAIM_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_APPLY_CLAIM', $MODULE)}</strong>
		</button>
		<select class="selectProfileCont" name="my_selyear" id="my_selyear" data-section="M"  class="my_selyear" data-url="?module=Users&view=ListViewAjax&mode=getUserClaim&section=M&record={$USERID}"   onchange="Users_Claim_Js.registerChangeYear('?module=Users&view=ListViewAjax&mode=getUserClaim&section=M&record={$USERID}','M');">

			<!--//Added By Jitu Date Combobox-->
			{for $year=$STARTYEAR to $CURYEAR}
				<option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
			{/for}
		</select>	
	</div>

	<div class="clearfix"></div>

	<div id="myclaimlist">
		<div class="block listViewContentDiv" id="listViewContents" >
			<div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
				<div class="bottomscroll-div">
					<div>
						<h5>{vtranslate('Claims', $MODULE)}</h5>
					</div>
					<hr />
					<table class="table detailview-table listViewEntriesTable">
						<thead>
							<tr>
								<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
								<th nowrap>{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
								<th nowrap>{vtranslate('LBL_STATUS_CLAIM', $MODULE)}</th>
								<th nowrap>{vtranslate('LBL_TRANSACTION_DATE', $MODULE)}</th>
								<th nowrap>{vtranslate('LBL_AMOUNT', $MODULE)}</th>
								<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>	
							</tr>
						</thead>
						<tbody>

						{if count($MYCLAIM) gt 0}<!--<pre>{$PAGING_MODEL|@print_r}</pre>-->
							{foreach item=USER_CLAIM from=$MYCLAIM}
								<tr data-section="M">
									<td class="medium" valign=top>{$USER_CLAIM['claimno']}</td>
									<td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_CLAIM['color_code']};width:30px;height:20px;"></label>
										<span style="float:left;" >{$USER_CLAIM['category']}</span></td>	
									<!--	<td class="medium" valign=top>{$USER_CLAIM['category']}</td>-->
									<td class="medium" valign=top>{$USER_CLAIM['claim_status']}</td>
									<td class="medium" valign=top>{$USER_CLAIM['transactiondate']}</td>
									<td class="medium" valign=top>{$USER_CLAIM['totalamount']}</td>
									<td class="medium" valign=top>
										<div class="pull-left actions">
											<span class="actionImages">


											  {if $USER_CLAIM['attachment'] neq ''}     
                        						<a href="index.php?module=Claim&action=DownloadAttachment&record={$USER_CLAIM['claimid']}&attachmentid={$USER_CLAIM['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                   							  {/if}
		

												{if $USER_CLAIM['claim_status'] eq 'Apply' } 

												<a class="editLeave cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}"  onclick="Users_Claim_Js.editClaim('index.php{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USERID}&claim_status={$USER_CLAIM['claim_status']}&manager=false');"></a>
												{/if} 
												{if $USER_CLAIM['claim_status'] eq 'Cancel' OR $USER_CLAIM['claim_status'] eq 'Apply'}
												<a class="deleteLeave cursorPointer" onclick="Users_Claim_Js.deleteClaim('index.php?module=Claim&action=Delete&record={$USER_CLAIM['claimid']}');"><i class="fa fa-trash" title="Delete"></i></a>
												{/if} 

												{if $USER_CLAIM['claim_status'] eq 'Apply' }
												<a class="cancelLeave cursorPointer" onclick="Users_Claim_Js.cancelClaim('?module=Users&action=DeleteSubModuleAjax&mode=cancelClaim&record={$USER_CLAIM['claimid']}&claim_type={$USER_CLAIM['claimtypeid']}&user_id={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}','T');"><i title="{vtranslate('LBL_CANCEL', $MODULE)}" class="fa fa-times-circle alignBottom"></i></a>				
												{/if}

											</span>
										</div>
									</td>
								</tr>
								{/foreach}
								{else}
								<tr><td colspan="6"><center>{vtranslate('LBL_NO_CLAIM_FOUND', $MODULE)}</center></td></tr>
								{/if}
							</tbody>			
						</table>
					</div>	
				</div>
			</div>
		</div>		
		<!--end my leaves-->

		<br>
		<!--START MY TEAM LEAVE-->
		{if $MANAGER eq 'true'}
		<div class="listViewTopMenuDiv noprint pull-right" style="margin-right:15px;">
			<select class="selectProfileCont" name="team_selyear" class="team_selyear" id="team_selyear" data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');" >
				{for $year=$STARTYEAR to $CURYEAR}
				<option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
				{/for}
			</select>&nbsp;
			<select class="selectProfileCont" name="sel_teammember" class="sel_teammember" id="sel_teammember" data-section="T" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');"  >
				<option value="All">{vtranslate('SEL_LBL_USER', $MODULE)}</option>
				{foreach item=MEMBERS from=$MYTEAM}
				<option value="{$MEMBERS['id']}">{$MEMBERS['fullname']}</option>
				{/foreach}
			</select>&nbsp;
			<select class="selectProfileCont" name="sel_claimtype" class="sel_claimtype" id="sel_claimtype"  data-section="T" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');" >
				<option value="All">{vtranslate('SEL_LBL_CLAIMTYPE', $MODULE)}</option>
				{foreach item=CLAIMTYPE from=$CLAIMTYPELIST}
				<option value="{$CLAIMTYPE['claimtypeid']}">{$CLAIMTYPE['claim_type']}</option>
				{/foreach}
			</select>
		</div>
		<br /><br />
		<!--start team leaves-->
		<div id="MyTeamClaimContainer">
			<div class="block listViewContentDiv" style="marign-top: 15px;">
				<div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
					<div class="bottomscroll-div">
						<div><h5>{vtranslate('LBL_MYTEAM_CLAIM', $MODULE)}</h5></div>

						<hr>
						<!--<div style="float:left;margin-bottom:21px;"><strong>{vtranslate('LBL_MYTEAM_CLAIM', $MODULE)}</strong></div>-->

						<div id="myteamclaimlist">
							<div class="listViewActionsDiv row-fluid">                
							    <div class="btn-group pull-right">
							            <input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
							            <input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
							            <input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
							            <input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
							            <input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
							            <input type="hidden" id="totalPage" value="{$PCOUNT}" />
							            
							            <input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
							            <input type='hidden' value="{$PAGE_LIMIT}" id='pageLimit'>
							            <input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">

							            <button type="button" id="ClaimPreviousPageButton" class="btn btn-secondary" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if}><i class="material-icons">chevron_left</i></button>
							          <!--   <button type="button" id="PageJump" data-toggle="dropdown" class="btn btn-secondary" aria-expanded="false">
							                <i class="material-icons icon" title="Page Jump">more_horiz</i>
							            </button>
							            
							           <ul class="listViewBasicAction dropdown-menu" id="PageJumpDropDown">
							                <li>
							                    <div class="listview-pagenum">
							                        <span>Page</span>&nbsp;
							                        <strong><span>{$PAGING_MODEL->getRecordStartRange()}</span></strong>&nbsp;
							                        <span>of</span>&nbsp;
							                        <strong><span id="totalPageCount">{$PCOUNT}</span></strong>
							                    </div>
							                    <div class="listview-pagejump">
							                        <input id="pageToJump" placeholder="Jump To" class="listViewPagingInput text-center" type="text">&nbsp;
							                        <button type="button" id="pageToJumpSubmit" class="btn btn-success listViewPagingInputSubmit text-center">GO</button>
							                    </div>    
							                </li>
							            </ul>-->
							            <button type="button" id="ClaimNextPageButton" class="btn btn-secondary" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if}><i class="material-icons">chevron_right</i></button>
							    </div>
							    <span class="pageNumbers  pull-right" style="position:relative;top:7px;">
							        <span class="pageNumbersText">{$PAGING_MODEL->getRecordStartRange()} to {$PAGING_MODEL->getRecordEndRange()}</span>
							            &nbsp;<span class="totalNumberOfRecords cursorPointer" title="Click for this list size">of {$LISTVIEW_COUNT}</span>&nbsp;&nbsp;
							    </span>
							</div> 
<!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->
<table class="table detailview-table listViewEntriesTable">
	<thead>
		<tr>
			<th nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
			<th nowrap style="width:200px;">{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_TRANSACTION_DATE', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_AMOUNT', $MODULE)}</th>
			<th nowrap>{vtranslate('LBL_CLAIM_STATUS', $MODULE)}</th>

			<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>

		</tr>
	</thead>
	<tbody>
		{if count($MYTEAMCLAIMS) gt 0}
		{foreach item=USER_CLAIM from=$MYTEAMCLAIMS}

		<tr data-section="T">
			<td class="medium" valign=top>{$USER_CLAIM['fullname']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['claimno']}</td>
			<td class="medium" valign=top><span style="background-color:{$USER_CLAIM['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></span>{$USER_CLAIM['category']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['transactiondate']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['totalamount']}</td>
			<td class="medium" valign=top>{$USER_CLAIM['claim_status']}</td>

			<td class="medium" valign=top>
				<div class="pull-left actions">
					<span class="actionImages">

						  {if $USER_CLAIM['attachment'] neq ''}     
	                        <a href="index.php?module=Claim&action=DownloadAttachment&record={$USER_CLAIM['claimid']}&attachmentid={$USER_CLAIM['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                          {/if}

						{if $USER_CLAIM['claim_status'] eq 'Apply'}
						<a class="editLeave cursorPointer editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Claim_Js.Popup_ClaimApprove('{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}&manager=true');"></a>
						&nbsp;&nbsp;
						<a class="cancelLeave cursorPointer" onclick="Users_Claim_Js.cancelClaim('?module=Users&action=DeleteSubModuleAjax&mode=cancelClaim&record={$USER_CLAIM['claimid']}&claim_type={$USER_CLAIM['claimtypeid']}&user_id={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}','T');"><i title="{vtranslate('LBL_CANCEL', $MODULE)}" class="fa fa-times-circle alignBottom"></i></a>				
						{/if}
					</span>
				</div>

			</td>
		</tr>
		{/foreach}
		{else}
		<tr><td colspan="7"><center>{vtranslate('LBL_NO_CLAIM_FOUND', $MODULE)}</center></td></tr>
		{/if}
	</tbody>			
</table>
</div>
</div>
</div></div></div></div>
<!--end team leaves-->
{/if}

{/if}
{/strip}
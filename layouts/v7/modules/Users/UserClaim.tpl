{strip}
{if $SECTION eq 'M'}

	<table class="table table-bordered listViewEntriesTable">
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
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claimno']}</label></td>
					<td class="listTableRow small" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_CLAIM['color_code']};width:30px;height:20px;"></label><label style="float:left;" class="instlabel">{$USER_CLAIM['category']}</label></td>		
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claim_status']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['transactiondate']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['totalamount']}</label></td>
					<td class="listTableRow small" valign=top>

							<div class="pull-left actions">
							<span class="actionImages">
							<!--	<a class="docsLeave cursorPointer" onclick="javascript:window.open('?module=Claim&relatedModule=Documents&view=Detail&record={$USER_CLAIM['claimid']}&mode=showRelatedList&tab_label=Documents&popup=Claim','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="fa fa-file alignMiddle" title="Documents"></i>  
								</a>	-->
					{if $USER_CLAIM['claim_status'] eq 'Apply' OR $USER_CLAIM['claim_status'] eq 'Rejected' OR $USER_CLAIM['claim_status'] eq 'Approved'} 
						<a class="editLeave cursorPointer" onclick="Users_Claim_Js.editClaim('index.php{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USERID}&claim_status={$USER_CLAIM['claim_status']}&manager=false');"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="fa fa-pencil alignBottom"></i></a>&nbsp;&nbsp;
						{/if} <input type="hidden" name="manager" id="manager" value="false" />
						{if $USER_CLAIM['claim_status'] eq 'Rejected' OR $USER_CLAIM['claim_status'] eq 'Apply' OR $USER_CLAIM['claim_status'] eq 'Approved'}
						<a class="deleteLeave cursorPointer" onclick="Users_Claim_Js.deleteClaim('index.php?module=Claim&action=Delete&record={$USER_CLAIM['claimid']}');"><i class="fa fa-trash alignMiddle" title="Delete"></i></a>
						{/if} 

						</span>
						</div>

		<!--				<div class="pull-right actions">
							<span class="actionImages">
			<a onclick="javascript:window.open('?module=Leave&relatedModule=Documents&view=Detail&record={$USER_LEAVE['id']}&mode=showRelatedList&tab_label=Documents&popup=Leave','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );">
			<i class="fa fa-file alignMiddle" title="Documents"></i>  </a>	
					{if $USER_LEAVE['leavestatus'] eq 'New'} 
						<a class="editLeave cursorPointer" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="fa fa-pencil alignBottom"></i></a>&nbsp;&nbsp;
					{/if}
					{if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
					<a class="deleteLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLeave&record={$USER_LEAVE['id']}"><i class="fa fa-trash alignMiddle" title="Delete"></i></a>
					{/if}
					{if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}
					dsdsssdsd<a class="cancelLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=CancelLeave&record={$USER_LEAVE['id']}&leavestatus={$USER_LEAVE['leavestatus']}&leave_type={$USER_LEAVE['leavetypeid']}"><i class="fa fa-trash alignMiddle" title="Cancel"></i></a>
					{/if}

							</span>
						</div>
					-->


					</td>
				</tr>
			{/foreach}
			{else}
				<tr><td colspan="6"><center>{vtranslate('LBL_NO_CLAIM_FOUND', $MODULE)}</center></td></tr>
			{/if}
		</tbody>			
	</table>


<!--@@@@@@@@@@@@START PAGINATION TOOLS@@@@@@@@@@@@@@@-->
{elseif $SECTION eq 'T'}
<div class="listViewActionsDiv row-fluid">
			<span class="span4 btn-toolbar" style="float:right;margin-left:0.12766%;margin-top:0;margin-bottom:9px;">

				

<input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
<input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
<input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
<input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
<input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
<input type='hidden' value="{$PAGE_LIMIT}" id='pageLimit'>
<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">

<div class="listViewActions pull-right {if $PCOUNT eq 0} hide{/if}">
	<div class="pageNumbers alignTop">
						<span>
							<span class="pageNumbersText" style="padding-right:5px">{if $PCOUNT>0}{$PAGING_MODEL->getRecordStartRange()} {vtranslate('LBL_to', $MODULE)} {$PAGING_MODEL->getRecordEndRange()}{else}<span>&nbsp;</span>{/if}</span>
							<!--<span class="icon-refresh pull-right totalNumberOfRecords cursorPointer{if !$LISTVIEW_ENTRIES_COUNT} hide{/if}"></span>-->
						</span>
	</div>
	<div class="btn-group alignTop margin0px">
				<span class="pull-right">
					<span class="btn-group">
						<button class="btn "  id="previouspage" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="fa fa-chevron-left"></span></button>
							<!--<button class="btn dropdown-toggle" type="button" id="listViewPageJump" data-toggle="dropdown" {if $PAGE_COUNT eq 1} disabled {/if}>
								<i class="vtGlyph vticon-pageJump" title="{vtranslate('LBL_LISTVIEW_PAGE_JUMP',$moduleName)}"></i>
							</button>
							<ul class="listViewBasicAction dropdown-menu" id="listViewPageJumpDropDown">
								<li>
									<span class="row-fluid">
										<span class="span3 pushUpandDown2per"><span class="pull-right">{vtranslate('LBL_PAGE',$moduleName)}</span></span>
										<span class="span4">
											<input type="text" id="pageToJump" class="listViewPagingInput" value="{$PAGE_NUMBER}"/>
										</span>
										<span class="span2 textAlignCenter pushUpandDown2per">
											{vtranslate('LBL_OF',$moduleName)}&nbsp;
										</span>
										<span class="span2 pushUpandDown2per" id="totalPageCount">{$PAGE_COUNT}</span>
									</span>
								</li>
							</ul>-->
				<button class="btn" id="listViewNPageButton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="fa fa-chevron-right"></span></button>			
					</span>
				</span>	
		</div>	
</div>
			</span>
		</div>
				<!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->



	<table class="table table-bordered listViewEntriesTable">
		<thead>
			<tr>
				<th nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
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
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['fullname']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claimno']}</label></td>
					<td class="listTableRow small" valign=top><label style="background-color:{$USER_CLAIM['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label><label class="instlabel">{$USER_CLAIM['category']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['transactiondate']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['totalamount']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claim_status']}</label></td>

					<td class="listTableRow small" valign=top>
						<div class="pull-left actions">
							<span class="actionImages">
								<a onclick="javascript:window.open('?module=Claim&relatedModule=Documents&view=Detail&record={$USER_CLAIM['claimid']}&mode=showRelatedList&tab_label=Documents&popup=Claim','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="fa fa-file alignMiddle" title="Documents"></i>  </a>&nbsp;&nbsp;	
								<a class="editLeave cursorPointer" onclick="Users_Claim_Js.Popup_ClaimApprove('{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}&manager=true');"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="fa fa-pencil alignBottom"></i></a>&nbsp;&nbsp;
								{if $USER_CLAIM['claim_status'] eq 'Apply' OR $USER_CLAIM['claim_status'] eq 'Approved'}
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
<!-- Added hidden field by jitu for paging --->
<script src="layouts/v7/modules/Vtiger/resources/List.js" type="text/javascript"></script>
<script src="layouts/v7/modules/Users/resources/Claim.js?v=6.1.0" type="text/javascript"></script>
<!--- End for pagination --->
<!--start my leaves-->

<div style="margin-top:10px;" id="MyClaimContainer">



	<div style="float:left;margin-bottom:10px;"><strong>{vtranslate('LBL_MY_CLAIM', $MODULE)}</strong>&nbsp;&nbsp;</div>&nbsp;&nbsp;

	<div style="float:left;margin-bottom:10px;"><button type="button" class="btn"
	onclick="Users_Claim_Js.addClaim('{$CREATE_CLAIM_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_APPLY_CLAIM', $MODULE)}</strong></button></div> &nbsp;&nbsp;

	<div style="float:left;margin-left:5px;margin-bottom:10px;">
	 <!--	<select name="my_selyear" id="my_selyear" data-section="M" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}" class="my_selyear"> -->
	 	<form id="my_selyear" name="my_selyear" class="form-horizontal" method="POST">
		<select name="my_selyear" id="my_selyear" data-section="M"  class="my_selyear" data-url="?module=Users&view=ListViewAjax&mode=getUserClaim&section=M&record={$USERID}"   onchange="Users_Claim_Js.registerChangeYear('?module=Users&view=ListViewAjax&mode=getUserClaim&section=M&record={$USERID}','M');">

			<!--//Added By Jitu Date Combobox-->
			{for $year=$STARTYEAR to $CURYEAR}
				<option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
			{/for}
		</select>	
	</form>
	</div><br /><br />
	<div style="clear:both;"></div>
	
	<div id="myclaimlist">
	<table class="table table-bordered listViewEntriesTable">
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
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claimno']}</label></td>
				<td class="listTableRow small" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_CLAIM['color_code']};width:30px;height:20px;"></label><label style="float:left;" class="instlabel">{$USER_CLAIM['category']}</label></td>	
				<!--	<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['category']}</label></td>-->
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claim_status']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['transactiondate']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['totalamount']}</label></td>
					<td class="listTableRow small" valign=top>
						<div class="pull-left actions">
							<span class="actionImages">
						<a class="docsLeave cursorPointer" onclick="javascript:window.open('?module=Claim&relatedModule=Documents&view=Detail&record={$USER_CLAIM['claimid']}&mode=showRelatedList&tab_label=Documents&popup=Claim','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="fa fa-file alignMiddle" title="Documents"></i> &nbsp;&nbsp; 
						</a>&nbsp;&nbsp;	
					{if $USER_CLAIM['claim_status'] eq 'New' } 
						<a class="editLeave cursorPointer" onclick="Users_Claim_Js.editClaim('index.php{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USERID}&claim_status={$USER_CLAIM['claim_status']}&manager=false');"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="fa fa-pencil alignBottom"></i></a>&nbsp;&nbsp;
					{/if} 
					{if $USER_CLAIM['claim_status'] eq 'Cancel' OR $USER_CLAIM['claim_status'] eq 'Apply'}
					<a class="deleteLeave cursorPointer" onclick="Users_Claim_Js.deleteClaim('index.php?module=Claim&action=Delete&record={$USER_CLAIM['claimid']}');"><i class="fa fa-trash alignMiddle" title="Delete"></i></a>&nbsp;&nbsp;
					{/if} 
				{if $USER_CLAIM['claim_status'] eq 'Apply' 	}
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
<!--end my leaves-->


<!--START MY TEAM LEAVE-->
{if $MANAGER eq 'true'}
<!--- Code for Pagination Added by jitu@secondcrm.com --->


<!----- End for pagination ----->
<br /><br />
<!--start team leaves-->
<div id="MyTeamClaimContainer">
	<div style="float:left;margin-bottom:21px;"><strong>{vtranslate('LBL_MYTEAM_CLAIM', $MODULE)}</strong></div>
	<div class="listViewTopMenuDiv noprint" style="float:left;margin-left:5px;">
		<select name="team_selyear" class="team_selyear" id="team_selyear" data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');" >
		{for $year=$STARTYEAR to $CURYEAR}
			<option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
		{/for}
		</select>&nbsp;
		<select name="sel_teammember" class="sel_teammember" id="sel_teammember" data-section="T" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');"  >
			<option value="All">{vtranslate('SEL_LBL_USER', $MODULE)}</option>
		{foreach item=MEMBERS from=$MYTEAM}
			<option value="{$MEMBERS['id']}">{$MEMBERS['fullname']}</option>
		{/foreach}
		</select>&nbsp;
		<select name="sel_claimtype" class="sel_claimtype" id="sel_claimtype"  data-section="T" onchange="Users_Claim_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserClaim&section=T&record={$USERID}','T');" >
			<option value="All">{vtranslate('SEL_LBL_CLAIMTYPE', $MODULE)}</option>
		{foreach item=CLAIMTYPE from=$CLAIMTYPELIST}
			<option value="{$CLAIMTYPE['claimtypeid']}">{$CLAIMTYPE['claim_type']}</option>
		{/foreach}
		</select>
	</div>


	<div id="myteamclaimlist">
		<div class="listViewActionsDiv row-fluid">
			<span class="span4 btn-toolbar" style="float:right;margin-left:0.12766%;margin-top:0;">
				<!--@@@@@@@@@@@@START PAGINATION TOOLS@@@@@@@@@@@@@@@-->
				<input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
				<input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
				<input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
				<input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
				<input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
				<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
				<input type='hidden' value="{$PAGE_LIMIT}" id='pageLimit'>
				<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">

<div class="listViewActions pull-right {if $PCOUNT eq 0} hide{/if}">
	<div class="pageNumbers alignTop {if $LISTVIEW_LINKS['LISTVIEWSETTING']|@count gt 0}{else}{/if}">
		<span>
			<span class="pageNumbersText" style="padding-right:5px">{if $LISTVIEW_ENTRIES_COUNT}{$PAGING_MODEL->getRecordStartRange()} {vtranslate('LBL_to', $MODULE)} {$PAGING_MODEL->getRecordEndRange()}{else}<span>&nbsp;</span>{/if}</span>
			<!--<span class="icon-refresh pull-right totalNumberOfRecords cursorPointer{if $PCOUNT eq 0} hide{/if}"></span>-->
		</span>
	</div>
	<div class="btn-group alignTop margin0px">
		<span class="pull-right">
			<span class="btn-group">
				<button class="btn"  id="userclaimprevpagebutton"  {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="fa fa-chevron-left"></span></button>
				<!--<button class="btn dropdown-toggle" type="button" id="listViewPageJump" data-toggle="dropdown" {if $PAGE_COUNT eq 1} disabled {/if}>
					<i class="vtGlyph vticon-pageJump" title="{vtranslate('LBL_LISTVIEW_PAGE_JUMP',$moduleName)}"></i>
					</button>
					<ul class="listViewBasicAction dropdown-menu" id="listViewPageJumpDropDown">
						<li>
							<span class="row-fluid">
								<span class="span3 pushUpandDown2per">
									<span class="pull-right">{vtranslate('LBL_PAGE',$moduleName)}</span>
								</span>
								<span class="span4">
									<input type="text" id="pageToJump" class="listViewPagingInput" value="{$PAGE_NUMBER}"/>
								</span>
								<span class="span2 textAlignCenter pushUpandDown2per">
									{vtranslate('LBL_OF',$moduleName)}&nbsp;
								</span>
								<span class="span2 pushUpandDown2per" id="totalPageCount">{$PAGE_COUNT}</span>
							</span>
						</li>
					</ul>-->
				<button class="btn" id="userclaimnextpagebutton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="fa fa-chevron-right"></span></button>					
			</span>
		</span>	
	</div>	
</div>
			</span>
</div>
				<!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->
	<table class="table table-bordered listViewEntriesTable">
		<thead>
			<tr>
				<th nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_CLAIM_NO', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_CLAIM_TYPE', $MODULE)}</th>
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
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['fullname']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claimno']}</label></td>
					<td class="listTableRow small" valign=top><label style="background-color:{$USER_CLAIM['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label><label class="instlabel">{$USER_CLAIM['category']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['transactiondate']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['totalamount']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_CLAIM['claim_status']}</label></td>

					<td class="listTableRow small" valign=top>
						<div class="pull-left actions">
							<span class="actionImages">
							<a onclick="javascript:window.open('?module=Claim&relatedModule=Documents&view=Detail&record={$USER_CLAIM['claimid']}&mode=showRelatedList&tab_label=Documents&popup=Claim','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="fa fa-file alignMiddle" 
								title="Documents"></i>  </a>&nbsp;&nbsp;	
								<a class="editLeave cursorPointer" onclick="Users_Claim_Js.Popup_ClaimApprove('{$CREATE_CLAIM_URL}&record={$USER_CLAIM['claimid']}&userId={$USER_CLAIM['applicantid']}&claimstatus={$USER_CLAIM['claim_status']}&manager=true');"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="fa fa-pencil alignBottom"></i></a>&nbsp;&nbsp;
								{if $USER_CLAIM['claim_status'] eq 'Apply' OR $USER_CLAIM['claim_status'] eq 'New'}
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
<!--end team leaves-->
{/if}

{/if}
{/strip}

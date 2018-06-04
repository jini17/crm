{strip}
{if $SECTION eq 'M'}
	<table class="table table-bordered listViewEntriesTable">
		<thead>
			<tr>
				<th nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_START_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_END_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>	
			</tr>
		</thead>
		<tbody>
			{if count($MYLEAVES) gt 0}
			{foreach item=USER_LEAVE from=$MYLEAVES}
				<tr data-section="M">
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leave_reason']}</label></td>
					<td class="listTableRow small" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['color_code']};width:30px;height:20px;"></label><label style="float:left;" class="instlabel">{$USER_LEAVE['leave_type']}</label></td>		<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['from_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['to_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leavestatus']}</label></td>
					<td class="listTableRow small" valign=top>
						<div class="pull-right actions">
							<span class="actionImages">
<a onclick="javascript:window.open('?module=Leave&relatedModule=Documents&view=Detail&record={$USER_LEAVE['id']}&mode=showRelatedList&tab_label=Documents&popup=Leave','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );">
<i class="icon-file alignMiddle" title="Documents"></i>  </a>	
					{if $USER_LEAVE['leavestatus'] eq 'New'} 
						<a class="editLeave cursorPointer" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;
{/if}
{if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
<a class="deleteLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLeave&record={$USER_LEAVE['id']}"><i class="icon-trash alignMiddle" title="Delete"></i></a>
{/if}
{if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}
dsdsssdsd<a class="cancelLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=CancelLeave&record={$USER_LEAVE['id']}&leavestatus={$USER_LEAVE['leavestatus']}&leave_type={$USER_LEAVE['leavetypeid']}"><i class="icon-trash alignMiddle" title="Cancel"></i></a>
{/if}

							</span>
						</div>
					</td>
				</tr>
			{/foreach}
			{else}
				<tr><td colspan="6"><center>{vtranslate('LBL_NO_LEAVE_FOUND', $MODULE)}</center></td></tr>
			{/if}
		</tbody>			
	</table>
{elseif $SECTION eq 'T'}
<div class="listViewActionsDiv row-fluid">
			<span class="span4 btn-toolbar" style="float:right;margin-left:0.12766%;margin-top:0;margin-bottom:9px;">

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
	<div class="pageNumbers alignTop">
						<span>
							<span class="pageNumbersText" style="padding-right:5px">{if $PCOUNT>0}{$PAGING_MODEL->getRecordStartRange()} {vtranslate('LBL_to', $MODULE)} {$PAGING_MODEL->getRecordEndRange()}{else}<span>&nbsp;</span>{/if}</span>
							<!--<span class="icon-refresh pull-right totalNumberOfRecords cursorPointer{if !$LISTVIEW_ENTRIES_COUNT} hide{/if}"></span>-->
						</span>
	</div>
	<div class="btn-group alignTop margin0px">
				<span class="pull-right">
					<span class="btn-group">
						<button class="btn "  id="previouspage" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="icon-chevron-left"></span></button>
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
						<button class="btn" id="listViewNPageButton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="icon-chevron-right"></span></button>				
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
				<th nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_START_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_END_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>

				<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>

			</tr>
		</thead>
		<tbody>
			{if count($MYTEAMLEAVES) gt 0}
			{foreach item=USER_LEAVE from=$MYTEAMLEAVES}
				<tr data-section="T">
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['fullname']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leave_reason']}</label></td>
					<td class="listTableRow small" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label><label class="instlabel">{$USER_LEAVE['leave_type']}</label></td>		<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['from_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['to_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leavestatus']}</label></td>

					<td class="listTableRow small" valign=top>
						<div class="pull-right actions">
							<span class="actionImages">
<a onclick="javascript:window.open('?module=Leave&relatedModule=Documents&view=Detail&record={$USER_LEAVE['id']}&mode=showRelatedList&tab_label=Documents&popup=Leave','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="icon-file alignMiddle" title="Documents"></i>  </a>				
								<a class="editLeave cursorPointer" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true"><i title="{vtranslate('LBL_LEAVE_APPROVAL', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;
								{if $USER_LEAVE['leavestatus'] neq 'New' && $USER_LEAVE['leavestatus'] neq 'Cancel'}
								<a class="cancelLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}">Cancel</a>				
								{/if}
							</span>
						</div>

					</td>
				</tr>
			{/foreach}
			{else}
				<tr><td colspan="7"><center>{vtranslate('LBL_NO_LEAVE_FOUND', $MODULE)}</center></td></tr>
			{/if}
		</tbody>			
	</table>
{else}
<!-- Added hidden field by jitu for paging --->
<script src="layouts/vlayout/modules/Vtiger/resources/List.js?v=6.1.0" type="text/javascript"></script>
<script src="layouts/vlayout/modules/Users/resources/Leave.js?v=6.1.0" type="text/javascript"></script>
<!--- End for pagination --->
<!--start my leaves-->
<div id="MyLeaveContainer">
<button type="button" class="addMyLeave btn addButton" data-allow="{$ISCREATE}" data-url="{$CREATE_LEAVE_URL}&userId={$USERID}"><i class="icon-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_CREATE_LEAVE', $MODULE)}</strong></button>
	<div style="float:left;"><strong>{vtranslate('LBL_MY_LEAVE', $MODULE)}</strong></div>
	<div style="float:left;margin-left:5px;">
		<select name="my_selyear" id="my_selyear" data-section="M" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}" class="my_selyear">
			<!--//Added By Jitu Date Combobox-->
			{for $year=$STARTYEAR to $CURYEAR}
				<option value="{$year}" {if $year eq $CURYEAR} selected {/if}>{$year}</option>
			{/for}
		</select>	
	</div><br /><br />
	<div style="clear:both;"></div>
	
	<div id="myleavelist">
	<table class="table table-bordered listViewEntriesTable">
		<thead>
			<tr>
				<th nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_START_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_END_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>	
			</tr>
		</thead>
		<tbody>

			{if count($MYLEAVES) gt 0}<!--<pre>{$PAGING_MODEL|@print_r}</pre>-->
			{foreach item=USER_LEAVE from=$MYLEAVES}
				<tr data-section="M">
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leave_reason']}</label></td>
					<td class="listTableRow small" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['color_code']};width:30px;height:20px;"></label><label style="float:left;" class="instlabel">{$USER_LEAVE['leave_type']}</label></td>		<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['from_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['to_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leavestatus']}</label></td>
					<td class="listTableRow small" valign=top>
						<div class="pull-right actions">
							<span class="actionImages">
								<a class="docsLeave cursorPointer" onclick="javascript:window.open('?module=Leave&relatedModule=Documents&view=Detail&record={$USER_LEAVE['id']}&mode=showRelatedList&tab_label=Documents&popup=Leave','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="icon-file alignMiddle" title="Documents"></i>  </a>	
					{if $USER_LEAVE['leavestatus'] eq 'New'} 
						<a class="editLeave cursorPointer" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;
{/if} <input type="hidden" name="manager" id="manager" value="false" />
{if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
<a class="deleteLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLeave&record={$USER_LEAVE['id']}"><i class="icon-trash alignMiddle" title="Delete"></i></a>
{/if}
{if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}
<a class="cancelLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&leavestatus={$USER_LEAVE['leavestatus']}"><i class="icon-trash alignMiddle" title="Cancel"></i></a>

	
{/if}

							</span>
						</div>
					</td>
				</tr>
			{/foreach}
			{else}
				<tr><td colspan="6"><center>{vtranslate('LBL_NO_LEAVE_FOUND', $MODULE)}</center></td></tr>
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
<div id="MyTeamLeaveContainer">
	<div style="float:left;margin-bottom:21px;"><strong>{vtranslate('LBL_MYTEAM_LEAVE', $MODULE)}</strong></div>
	<div class="listViewTopMenuDiv noprint" style="float:left;margin-left:5px;">
		<select name="team_selyear" class="team_selyear" id="team_selyear" data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}" >
		{for $year=$STARTYEAR to $CURYEAR}
			<option value="{$year}" {if $year eq $CURYEAR} selected {/if}>{$year}</option>
		{/for}
		</select>&nbsp;
		<select name="sel_teammember" class="sel_teammember" id="sel_teammember" data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}" >
			<option value="All">{vtranslate('SEL_LBL_USER', $MODULE)}</option>
		{foreach item=MEMBERS from=$MYTEAM}
			<option value="{$MEMBERS['id']}">{$MEMBERS['fullname']}</option>
		{/foreach}
		</select>&nbsp;
		<select name="sel_leavetype" class="sel_leavetype" id="sel_leavetype"  data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}" >
			<option value="All">{vtranslate('SEL_LBL_LEAVETYPE', $MODULE)}</option>
		{foreach item=LEAVETYPE from=$LEAVETYPELIST}
			<option value="{$LEAVETYPE['leavetypeid']}">{$LEAVETYPE['leavetype']}</option>
		{/foreach}
		</select>
	</div>
	<div id="myteamleavelist">
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
				<button class="btn"  id="userleaveprevpagebutton"  {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="icon-chevron-left"></span></button>
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
				<button class="btn" id="userleavenextpagebutton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="icon-chevron-right"></span></button>				
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
				<th nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_START_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_END_DATE', $MODULE)}</th>
				<th nowrap>{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>

				<th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>

			</tr>
		</thead>
		<tbody>
			{if count($MYTEAMLEAVES) gt 0}
			{foreach item=USER_LEAVE from=$MYTEAMLEAVES}
				<tr data-section="T">
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['fullname']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leave_reason']}</label></td>
					<td class="listTableRow small" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label><label class="instlabel">{$USER_LEAVE['leave_type']}</label></td>		<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['from_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['to_date']}</label></td>
					<td class="listTableRow small" valign=top><label class="instlabel">{$USER_LEAVE['leavestatus']}</label></td>

					<td class="listTableRow small" valign=top>
						<div class="pull-right actions">
							<span class="actionImages">
<a onclick="javascript:window.open('?module=Leave&relatedModule=Documents&view=Detail&record={$USER_LEAVE['id']}&mode=showRelatedList&tab_label=Documents&popup=Leave','name','scrollbars=1,resizable=0,width=770,height=500,left=0,top=0' );"><i class="icon-file alignMiddle" title="Documents"></i>  </a>	
								<a class="editLeave cursorPointer" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;
								{if $USER_LEAVE['leavestatus'] neq 'New' && $USER_LEAVE['leavestatus'] neq 'Cancel'}
								<a class="cancelLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}">Cancel</a>				
								{/if}
							</span>
						</div>

					</td>
				</tr>
			{/foreach}
			{else}
				<tr><td colspan="7"><center>{vtranslate('LBL_NO_LEAVE_FOUND', $MODULE)}</center></td></tr>
			{/if}
		</tbody>			
	</table>
	</div>
</div>
<!--end team leaves-->
{/if}{/if}
{/strip}

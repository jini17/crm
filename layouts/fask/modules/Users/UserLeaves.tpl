{strip}
{if $SECTION eq 'M'}

<table class="table detailview-table listViewEntriesTable">
    <thead>
        <tr>
            <th width="30%" nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
            <th nowrap width="18%">{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
            <th nowrap width="13%">{vtranslate('LBL_START_DATE', $MODULE)}</th>
            <th nowrap width="13%">{vtranslate('LBL_END_DATE', $MODULE)}</th>
            <th nowrap width="13%">{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
            <th nowrap width="13%">{vtranslate('LBL_ACTION', $MODULE)}</th> 
        </tr>
    </thead>
    <tbody>
        {if count($MYLEAVES) gt 0}
        {foreach item=USER_LEAVE from=$MYLEAVES}
        <tr data-section="M">
            <td class="medium" valign=top>{$USER_LEAVE['leave_reason']}</td>
            <td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['colorcode']};width:30px;height:20px;"></label><span style="float:left;" >{$USER_LEAVE['leave_type']}</span></td>		

            <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>

            <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
            <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
            <td class="medium" valign=top>
                <div class="pull-left actions">
                    <span class="actionImages">
                        {if $USER_LEAVE['fileid'] neq ''}     

                        <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                        {/if}

                        {if $USER_LEAVE['leavestatus'] eq 'New'} 

                        <a class="editLeave cursorPointer editAction ti-pencil" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false" title="{vtranslate('LBL_EDIT', $MODULE)}"></a>
                        {/if}
                        {if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
                        <a class="deleteLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLeave&record={$USER_LEAVE['id']}"><i class="fa fa-trash" title="Delete"></i></a>
                        {/if}
                        {if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}<a class="cancelLeave cursorPointer" onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','M');"><i class="fa fa-trash" title="Cancel"></i></a>
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

            <button type="button" id="LeavePreviousPageButton" class="btn btn-secondary" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if}><i class="material-icons">chevron_left</i></button>
          <!--  <button type="button" id="PageJump" data-toggle="dropdown" class="btn btn-secondary" aria-expanded="false">
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
            <button type="button" id="LeaveNextPageButton" class="btn btn-secondary" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if}><i class="material-icons">chevron_right</i></button>
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
        <th width="14%" nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
        <th width="18%" nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
        <th nowrap width="20%">{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
        <th nowrap width="12%">{vtranslate('LBL_START_DATE', $MODULE)}</th>
        <th nowrap width="12%">{vtranslate('LBL_END_DATE', $MODULE)}</th>
        <th nowrap width="12%">{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
        <th nowrap width="12%">{vtranslate('LBL_ACTION', $MODULE)}</th> 

    </tr>
</thead>
<tbody>
    {if count($MYTEAMLEAVES) gt 0}
    {foreach item=USER_LEAVE from=$MYTEAMLEAVES}
    <tr data-section="T">
        <td class="medium" valign=top>{$USER_LEAVE['fullname']}</td>
        <td class="medium" valign=top title="{$USER_LEAVE['leave_reason']}">{$USER_LEAVE['leave_reason']|truncate:20}</td>
        <td class="medium" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label>{$USER_LEAVE['leave_type']}</td>		

        <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>
        <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
        <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>

        <td class="listTableRow small" valign=top>
            <div class="pull-left actions">
                <span class="actionImages">


                  {if $USER_LEAVE['fileid'] neq ''}     

                    <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                    {/if}	



                   {if $USER_LEAVE['leavestatus'] eq 'Apply'}
                   <a class="editLeave cursorPointer editAction ti-pencil" data-url='{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true'
                   title="{vtranslate('LBL_LEAVE_APPROVAL', $MODULE)}" onclick="Users_Leave_Js.Popup_LeaveApprove('{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true');"></a>&nbsp;&nbsp;

                   {/if}  
                   {if $USER_LEAVE['leavestatus'] eq 'Approved'}

                   <a class="cancelLeave cursorPointer" data-section ='T' data-url='?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}'
                   onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','T');"><i title="Cancel" class="fa fa-times-circle alignBottom"></i></a>				
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

<input type="hidden" id="leaveallow" value="{$ISCREATE}" />

<!--start my leaves-->
<div id="MyLeaveContainer">
    <div class="btn-group pull-right allprofilebtn" style="float:right;margin-right:15px;margin-bottom:10px;">
     <button style="margin-left:15px;" type="button" class="btn btn-primary pull-right" onclick="Users_Leave_Js.addLeave('{$CREATE_LEAVE_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_CREATE_LEAVE', $MODULE)}</strong></button>
     <select class="selectProfileCont" name="my_selyear" id="my_selyear" data-section="M"  class="select2"  data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}" onchange="Users_Leave_Js.registerChangeYear('?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}','M');">

            <!--//Added By Jitu Date Combobox-->
            {for $year=$STARTYEAR to $ENDYEAR}
            <option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
            {/for}
        </select>   
</div>
<div class="clearfix"></div>



<div class="block listViewContentDiv" id="listViewContents" style="margin-top: 15px;">
    <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
        <div>
            <h5>{vtranslate('My Leave', $MODULE)}</h5>
        </div>
        <hr>
        <div style="clear:both;"></div>

        <div id="myleavelist">
            <table class="table detailview-table listViewEntriesTable" style="background-color: #fff;margin: 14px;width: 98%;">
                <thead>
                    <tr>
                        <th width="30%" nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
                        <th nowrap width="18%">{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
                        <th nowrap width="13%">{vtranslate('LBL_START_DATE', $MODULE)}</th>
                        <th nowrap width="13%">{vtranslate('LBL_END_DATE', $MODULE)}</th>
                        <th nowrap width="13%">{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
                        <th nowrap width="13%">{vtranslate('LBL_ACTION', $MODULE)}</th> 
                    </tr>
                </thead>
                <tbody>

                    {if count($MYLEAVES) gt 0}<!--<pre>{$PAGING_MODEL|@print_r}</pre>-->
                        {foreach item=USER_LEAVE from=$MYLEAVES}
                            <tr data-section="M">
                                <td class="medium " valign=top>{$USER_LEAVE['leave_reason']}</td>
                                <td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['colorcode']};width:30px;height:20px;"></label><span style="float:left;" >{$USER_LEAVE['leave_type']}</span></td>      <td class="medium" valign=top>{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($USER_LEAVE['from_date'])}</td>
                                <td class="medium" valign=top>{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($USER_LEAVE['to_date'])}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
                                <td class="medium" valign=top>
                                    <div class="pull-left actions">
                                        <span class="actionImages">

                                            {if $USER_LEAVE['fileid'] neq ''}     

                                            <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                                            {/if}

                                            {if $USER_LEAVE['leavestatus'] eq 'New'}
                                                <a class="editLeave cursorPointer editAction ti-pencil" data-url='index.php{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false'
                                                title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Leave_Js.editLeave('index.php{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false');"></a>
                                            {/if} 
                                            <input type="hidden" name="manager" id="manager" value="false" />

                                            {if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
                                                <a class="deleteLeave cursorPointer" onclick="Users_Leave_Js.deleteLeave('index.php?module=Leave&action=Delete&record={$USER_LEAVE['id']}');"><i class="fa fa-trash" title="Delete"></i></a>
                                            {/if}
                                            {if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}
                                                <a class="cancelLeave cursorPointer" data-section='M' data-url='?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}' 

                                            onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','M');">
                                                <i class="icon-trash alignMiddle" title="Cancel">   </i>
                                                </a>
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
</div>
</div>
<!--end my leaves-->

<!--START MY TEAM LEAVE-->
{if $MANAGER eq 'true'}
<br />
<div class="listViewTopMenuDiv noprint pull-right" style="margin-right:15px;">
    <select  class="selectProfileCont" name="team_selyear" class="team_selyear" id="team_selyear" data-section="T" data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}" onchange="Users_Leave_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}','T');" >
        {for $year=$STARTYEAR to $ENDYEAR}
        <option value="{$year}" {if $year eq $CURYEAR} selected {/if}>{$year}</option>
        {/for}
    </select>&nbsp;
    <select class="selectProfileCont" name="sel_teammember" class="sel_teammember" id="sel_teammember" data-url='?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}' data-section="T" onchange="Users_Leave_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}','T');"  >
        <option value="All">{vtranslate('SEL_LBL_USER', $MODULE)}</option>
        {foreach item=MEMBERS from=$MYTEAM}
        <option value="{$MEMBERS['id']}">{$MEMBERS['fullname']}</option>
        {/foreach}
    </select>&nbsp;
    <select class="selectProfileCont" name="sel_leavetype" class="sel_leavetype" id="sel_leavetype" data-url='?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}' data-section="T" onchange="Users_Leave_Js.sel_teammember('?module=Users&view=ListViewAjax&mode=getUserLeave&section=T&record={$USERID}','T');" >
        <option value="All">{vtranslate('SEL_LBL_LEAVETYPE', $MODULE)}</option>
        {foreach item=LEAVETYPE from=$LEAVETYPELIST}
        <option value="{$LEAVETYPE['leavetypeid']}">{$LEAVETYPE['leavetype']}</option>
        {/foreach}
    </select>
</div>
<br /><br />
<!--start team leaves-->
<div id="MyTeamLeaveContainer">
    <div class="block listViewContentDiv" id="listViewContents" style="marign-top: 15px;">
        <div class="listViewEntriesDiv contents-bottomscroll " style="padding-top: 5px;">
            <div><h5>{vtranslate('LBL_MYTEAM_LEAVE', $MODULE)}</h5></div>
            <hr>


            <div id="myteamleavelist">
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

                            <button type="button" id="LeavePreviousPageButton" class="btn btn-secondary" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if}><i class="material-icons">chevron_left</i></button>
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
                            <button type="button" id="LeaveNextPageButton" class="btn btn-secondary" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if}><i class="material-icons">chevron_right</i></button>
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
                               <th width="14%" nowrap>{vtranslate('LBL_FULLNAME', $MODULE)}</th>
                                <th width="18%" nowrap>{vtranslate('LBL_LEAVE_DESC', $MODULE)}</th>
                                <th nowrap width="20%">{vtranslate('LBL_LEAVE_TYPE', $MODULE)}</th>
                                <th nowrap width="12%">{vtranslate('LBL_START_DATE', $MODULE)}</th>
                                <th nowrap width="12%">{vtranslate('LBL_END_DATE', $MODULE)}</th>
                                <th nowrap width="12%">{vtranslate('LBL_LEAVE_STATUS', $MODULE)}</th>
                                <th nowrap width="12%">{vtranslate('LBL_ACTION', $MODULE)}</th> 

                                <th nowrap>{vtranslate('LBL_ACTION', $MODULE)}</th>

                            </tr>
                        </thead>
                        <tbody>
                            {if count($MYTEAMLEAVES) gt 0}
                            {foreach item=USER_LEAVE from=$MYTEAMLEAVES}
                            <tr data-section="T">
                                <td class="medium" valign=top>{$USER_LEAVE['fullname']}</td>
                                <td class="medium" valign=top title="{$USER_LEAVE['leave_reason']}">{$USER_LEAVE['leave_reason']|truncate:30}</td>
                                <td class="medium" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label>{$USER_LEAVE['leave_type']}</td>     
                                <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
                                <td class="medium" valign=top>
                                    <div class="pull-left actions">
                                        <span class="actionImages">

                                              {if $USER_LEAVE['fileid'] neq ''}     

                                                <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                                                {/if}

                                            {if $USER_LEAVE['leavestatus'] eq 'Apply'}
                                            <a class="editLeave cursorPointer editAction ti-pencil" data-url='{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true'
                                            title="{vtranslate('LBL_EDIT', $MODULE)}"  onclick="Users_Leave_Js.Popup_LeaveApprove('{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true');"></a>
                                            {/if}
                                            {if $USER_LEAVE['leavestatus'] eq 'Apply' || ($USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime)}
                                            <a class="cancelLeave cursorPointer" onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','T');"><i title="Cancel" class="fa fa-times-circle alignBottom"></i></a>              
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
        </div>
    </div>
    <!--end team leaves-->
    {/if}{/if}
    {/strip}
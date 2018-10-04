{strip}
{if $SECTION eq 'M'}

<table class="table detailview-table listViewEntriesTable">
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
            <td class="medium" valign=top>{$USER_LEAVE['leave_reason']}</td>
            <td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['colorcode']};width:30px;height:20px;"></label><span style="float:left;" >{$USER_LEAVE['leave_type']}</span></td>		

            <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>

            <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
            <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
            <td class="medium" valign=top>
                <div class="pull-right actions">
                    <span class="actionImages">
                        {if $USER_LEAVE['fileid'] neq ''}     

                        <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                        {/if}

                        {if $USER_LEAVE['leavestatus'] eq 'New'} 

                        <a class="editLeave cursorPointer editAction ti-pencil" data-url="{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false" title="{vtranslate('LBL_EDIT', $MODULE)}"></a>&nbsp;&nbsp;
                        {/if}
                        {if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
                        <a class="deleteLeave cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteLeave&record={$USER_LEAVE['id']}"><i class="fa fa-trash-o" title="Delete"></i></a>
                        {/if}
                        {if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}<a class="cancelLeave cursorPointer" onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','M');"><i class="fa fa-trash-o" title="Cancel"></i></a>
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
                        <button class="btn "  id="previouspage" {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="icon-chevron-left"></span></button>

                        <button class="btn" id="listViewNPageButton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="fa fa-chevron-right"></span></button>                
                    </span>
                </span> 
            </div>  
        </div>
    </span>
</div>
<!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->

<table class="table detailview-table listViewEntriesTable">
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
        <td class="medium" valign=top>{$USER_LEAVE['fullname']}</td>
        <td class="medium" valign=top>{$USER_LEAVE['leave_reason']}</td>

        <td class="medium" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label>{$USER_LEAVE['leave_type']}</td>		

        <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>
        <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
        <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>

        <td class="listTableRow small" valign=top>
            <div class="pull-right actions">
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
<!-- Added hidden field by jitu for paging 
<script src="layouts/fask/modules/Vtiger/resources/List.js" type="text/javascript"></script>
<script src="layouts/fask/modules/Users/resources/Leave.js?v=6.1.0" type="text/javascript"></script>
-->
<input type="hidden" id="leaveallow" value="{$ISCREATE}" />
<!--start my leaves-->
<div id="MyLeaveContainer">


    <div class="btn-group pull-right allprofilebtn">
     <button style="margin-right:15px;" type="button" class="btn btn-primary pull-right" onclick="Users_Leave_Js.addLeave('{$CREATE_LEAVE_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_CREATE_LEAVE', $MODULE)}</strong></button>
     <select class="selectProfileCont" name="my_selyear" id="my_selyear" data-section="M"  class="select2"  data-url="?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}" onchange="Users_Leave_Js.registerChangeYear('?module=Users&view=ListViewAjax&mode=getUserLeave&section=M&record={$USERID}','M');">

            <!--//Added By Jitu Date Combobox-->
            {for $year=$STARTYEAR to $ENDYEAR}
            <option value="{$year}" {if $year eq $CURRENTYEAR} selected {/if}>{$year}</option>
            {/for}
        </select>   
</div>
<div class="clearfix"></div>



<div class="block listViewContentDiv" id="listViewContents" style="marign-top: 15px;">
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
                        <td class="medium" valign=top>{$USER_LEAVE['leave_reason']}</td>
                        <td class="medium" valign=top><label style="float:left;margin-right:5px;background-color:{$USER_LEAVE['colorcode']};width:30px;height:20px;"></label><span style="float:left;" >{$USER_LEAVE['leave_type']}</span></td>      <td class="medium" valign=top>{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($USER_LEAVE['from_date'])}</td>
                        <td class="medium" valign=top>{Vtiger_Util_Helper::convertDateIntoUsersDisplayFormat($USER_LEAVE['to_date'])}</td>
                        <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
                        <td class="medium" valign=top>
                            <div class="pull-right actions">
                                <span class="actionImages">

                                    {if $USER_LEAVE['fileid'] neq ''}     

                                    <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                                    {/if}


                                    {if $USER_LEAVE['leavestatus'] eq 'New'}



                                    <a class="editLeave cursorPointer editAction ti-pencil" data-url='index.php{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false'
                                    title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Leave_Js.editLeave('index.php{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USERID}&leavestatus={$USER_LEAVE['leavestatus']}&manager=false');"></a>&nbsp;&nbsp;
                                    {/if} <input type="hidden" name="manager" id="manager" value="false" />
                                    {if $USER_LEAVE['leavestatus'] eq 'New' OR $USER_LEAVE['leavestatus'] eq 'Apply'}
                                    <a class="deleteLeave cursorPointer" onclick="Users_Leave_Js.deleteLeave('index.php?module=Leave&action=Delete&record={$USER_LEAVE['id']}');"><i class="fa fa-trash-o" title="Delete"></i></a>
                                    {/if}
                                    {if $USER_LEAVE['leavestatus'] eq 'Approved' && $USER_LEAVE['from_date']|strtotime gt $CurrentDate|strtotime}
                                    <a class="cancelLeave cursorPointer" data-section='M' data-url='?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}' 

                                    onclick="Users_Leave_Js.cancelLeave('?module=Users&action=DeleteSubModuleAjax&mode=cancelLeave&record={$USER_LEAVE['id']}&leave_type={$USER_LEAVE['leavetypeid']}&user_id={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}','M');"><i class="icon-trash alignMiddle" title="Cancel"></i></a>


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

                            <div class="pageNumbers alignTop {if $LISTVIEW_LINKS['LISTVIEWSETTING']|@count gt 0}{else}{/if}" style="display: inline-block;    padding: 7px 12px;">
                                <span>
                                    <span class="pageNumbersText" style="padding-right:5px">{if $LISTVIEW_ENTRIES_COUNT}{$PAGING_MODEL->getRecordStartRange()} {vtranslate('LBL_to', $MODULE)} {$PAGING_MODEL->getRecordEndRange()}{else}<span>&nbsp;</span>{/if}</span>
                                    <!--<span class="icon-refresh pull-right totalNumberOfRecords cursorPointer{if $PCOUNT eq 0} hide{/if}"></span>-->
                                </span>
                            </div>

                            <div class="btn-group alignTop margin0px" style="display: inline-block;">
                                <span class="pull-right">
                                    <span class="btn-group">
                                        <button class="btn"  id="userleaveprevpagebutton"  {if !$PAGING_MODEL->isPrevPageExists()} disabled {/if} type="button"><span class="fa fa-chevron-left"></span></button>
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
                                            <button class="btn" id="userleavenextpagebutton" {if (!$PAGING_MODEL->isNextPageExists()) or ($PAGE_COUNT eq 1)} disabled {/if} type="button"><span class="fa fa-chevron-right"></span></button>                
                                        </span>
                                    </span> 
                                </div>  
                            </div>
                        </span>
                    </div>
                    <!--@@@@@@@@@@@@END PAGINATION TOOLS@@@@@@@@@@@@@@@-->
                    <table class="table detailview-table listViewEntriesTable">
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
                                <td class="medium" valign=top>{$USER_LEAVE['fullname']}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['leave_reason']}</td>
                                <td class="medium" valign=top><label style="background-color:{$USER_LEAVE['color_code']};float:left;margin-right:5px;width:30px;height:20px;"></label>{$USER_LEAVE['leave_type']}</td>     <td class="medium" valign=top>{$USER_LEAVE['from_date']}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['to_date']}</td>
                                <td class="medium" valign=top>{$USER_LEAVE['leavestatus']}</td>
                                <td class="medium" valign=top>
                                    <div class="pull-right actions">
                                        <span class="actionImages">

                                              {if $USER_LEAVE['fileid'] neq ''}     

                                                <a href="index.php?module=Leave&action=DownloadAttachment&record={$USER_LEAVE['id']}&attachmentid={$USER_LEAVE['fileid']}"><i class="fa fa-file-o" title="Documents"></i></a>    
                                                {/if}

                                            {if $USER_LEAVE['leavestatus'] eq 'Apply'}
                                            <a class="editLeave cursorPointer editAction ti-pencil" data-url='{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true'
                                            title="{vtranslate('LBL_EDIT', $MODULE)}"  onclick="Users_Leave_Js.Popup_LeaveApprove('{$CREATE_LEAVE_URL}&record={$USER_LEAVE['id']}&userId={$USER_LEAVE['applicantid']}&leavestatus={$USER_LEAVE['leavestatus']}&manager=true');"></a>&nbsp;&nbsp;
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

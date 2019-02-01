{*+**********************************************************************************
        * The contents of this file are subject to the vtiger CRM Public License Version 1.1
        * ("License"); You may not use this file except in compliance with the License
        * The Original Code is: vtiger CRM Open Source
        * The Initial Developer of the Original Code is vtiger.
        * Portions created by vtiger are Copyright (C) vtiger.
        * All Rights Reserved.
        * Created By Mabruk For Meeting On 07/06/2018
        ************************************************************************************}
        {strip}
        <style>
        #Participants {
                border-right: 1px solid green;
        }
</style>
<input type="hidden" value={$MEETINGDATA.status} id="meetingStatus">
<input type="hidden" value={$MEETINGDATA.subject} id="subject">
<table id="MOMTable" style="background:white;" width="100%">
        <tr><br>
                {if $MEETINGDATA.status neq 'Held'}
                <input type="button" value="Send Agenda To Selected Participants" style="float:right" class="sendMail btn btn-success">
                {else}
                <input type="button" value="Send MOM To Selected Participants" style="float:right" class="sendMail btn btn-success">
                {/if}	
        </tr>	
        <tr>
                <td style="background: #FFFFFF;
                border: 1px solid #F3F3F3;
                padding: 15px;" valign="top" width="15%" id="Participants">
                <div style="border-bottom: 1px solid #ddd;">
                        <h4 class="textOverflowEllipsis" style="height: 20px;">Participants</h4>
                </div>

                <h5>
                        <i class="fa fa-book" aria-hidden="true" style="font-size: 14px">&nbsp;&nbsp;</i>Contacts
                </h5>
                {foreach from=$CONTACTS item=DATA}
                &emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;&nbsp;{$DATA.name}<br>
                {/foreach}	
                <hr>


                {if $ACCOUNTS}
                <h5>
                        <i class="fa fa-crosshairs" aria-hidden="true" style="font-size: 14px">&nbsp;&nbsp;</i>Accounts
                </h5>
                {foreach from=$ACCOUNTS item=DATA}
                &emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;&nbsp;{$DATA.name}<br>
                {/foreach}
                <hr>
                {/if}


                {if $LEADS}
                <h5>
                        <i class="fa fa-magnet" aria-hidden="true" style="font-size: 14px">&nbsp;&nbsp;</i>Leads
                </h5>
                {foreach from=$LEADS item=DATA}
                &emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;&nbsp;{$DATA.name}<br>
                {/foreach}
                <hr>
                {/if}	


                <h5>
                        <i class="fa fa-user" aria-hidden="true" style="font-size: 14px">&nbsp;&nbsp;</i>Users
                </h5>
                {foreach from=$USERS item=DATA}
                &emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;&nbsp;{$DATA.name}<br>
                {/foreach}
                <hr>


                <h5>
                        <i class="fa fa-envelope-o" aria-hidden="true" style="font-size: 14px">&nbsp;&nbsp;</i>External Emails
                </h5>
                {foreach from=$EXTEMAILS item=DATA}
                &emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;&nbsp;{$DATA.name|regex_replace:'/\..*/':''}<br>
                {/foreach}	
                <hr>

        </td>
        <td width=5%></td>
        <td>
                <div class="block">
                        <table class="MOMDetails" >
                                {if $MEETINGDATA.status neq 'Held'}
                                <tr>
                                        <td class="MOMDetailslabel"><label>Agenda Subject</label></td>
                                        <td class="MOMDetailsdata"style="padding: 10px 10px;">{$MEETINGDATA.subject}</td></tr>
                                {else}
                                <tr>
                                        <td class="MOMDetailslabel"><label>MOM Subject</label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.subject}</td></tr>	
                                {/if}	
                                <tr>
                                        <td class="MOMDetailslabel"><label>Attendees</label></td>
                                        <td class="MOMDetailsdata">{$ATTENDEES}</td></tr>
                                <tr>
                                        <td class="MOMDetailslabel"><label>Date</label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.date}</td></tr>
                                <tr>
                                        <td class="MOMDetailslabel"><label>Start Time </label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.startTime}</td></tr>
                                <tr>
                                        <td class="MOMDetailslabel"><label>End Time </label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.endTime}</td></tr>
                                <tr>
                                        <td class="MOMDetailslabel"><label>Duration</label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.timeDiff} min</td></tr>
                                <tr>
                                        <td class="MOMDetailslabel"><label>Meeting Status</label></td>
                                        <td class="MOMDetailsdata">{$MEETINGDATA.status}</td></tr>
                        </table>
                </div>
                <br>
                {if $MEETINGDATA.status neq 'Held'}
                <div class="block" style="width:95%">
                        <div>
                                <h4 class="maxWidth50">&nbsp;Agenda Content</h4>
                        </div>
                        <hr>
                        <div class="blockData" style="padding-left:5px;">
                                <div id="meetingContent">
                                        {decode_html($MEETINGDATA.content)}
                                </div>
                        </div>
                </div>
                {else}
                <div class="block" style="width:100%">

                        <div>
                                <!-- Modify by jitu@Hide permission to edit agenda based on role-->
                                <h4>&nbsp;Minutes of Meeting(MOM) Content
                                        {if $EDITAGENDA}
                                        <span id="clickmeeting">&nbsp;&nbsp;<i class="fa fa-pencil" style="font-size:15px;margin-bottom: -2px" data-toggle="tooltip" title="Edit">&nbsp;</i></span>
                                        {/if}
                                </h4>	
                                <!-- End here -->
                        </div>

                        <hr style="border: 2px solid #555;">
                        <div class="blockData" style="padding-left:5px;">
                                <div id="meetingContent">
                                        {decode_html($MEETINGDATA.content)}
                                </div>
                                <div style="display:none;" id="meetingContainer">
                                        <form id="MOM">
                                                <textarea name="min_meeting" id="min_meeting">{decode_html($MEETINGDATA.content)}</textarea><br>
                                                <div align="center">
                                                        <button id="saveMOM" class="btn btn-success" name="saveMOM"><strong>Save</strong></button>&ensp;
                                                        <a href="#" class="cancelMOM" type="reset" data-dismiss="modal" style="color:red">Cancel</a>
                                                </div>
                                        </form>	
                                </div>
                        </div>					
                </div>
                {/if}	
        </td>	
</tr>		
</table>	
{literal} 

                <script type="text/javacript">
    jQuery(document).ready(function(){
        alert("c");
             jQuery("textarea").each(function(){
                   jQuery(this).closest('.row').find('div').css("width","100% !important")               
                });
    });
</script>    
{/literal} 

{/strip}

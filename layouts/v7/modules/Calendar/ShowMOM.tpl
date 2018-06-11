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
		<td style="padding-right:20px;" valign="top" width="15%" id="Participants">
			<h3>Participants</h3>
			<h4>Contacts</h4>
						
				{foreach from=$CONTACTS item=DATA}
					&emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;{$DATA.name}<br>
				{/foreach}	
		    
			<h4>Users</h4>
			
				{foreach from=$USERS item=DATA}
					&emsp;<input type="checkbox" value={$DATA.email} class="chkbox">&nbsp;{$DATA.name}<br>
				{/foreach}
		</td>
		<td width=5%></td>
		<td>
			<table class="MOMDetails">
				{if $MEETINGDATA.status neq 'Held'}
					<tr><td><label>Agenda Subject</label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.subject}</td></tr>
				{else}
					<tr><td><label>MOM Subject</label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.subject}</td></tr>	
				{/if}	
					<tr><td><label>Attendees</label></td><td>&emsp;:&emsp;</td><td>{$ATTENDEES}</td></tr>
					<tr><td><label>Date</label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.date}</td></tr>
					<tr><td><label>Start Time </label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.startTime}</td></tr>
					<tr><td><label>End Time </label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.endTime}</td></tr>
					<tr><td><label>Duration</label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.timeDiff} min</td></tr>
					<tr><td><label>Meeting Status</label></td><td>&emsp;:&emsp;</td><td>{$MEETINGDATA.status}</td></tr>
			</table>
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
				<div class="block" style="width:95%">
					<div>
						<h4 class="maxWidth50">&nbsp;Minutes of Meeting(MOM) Content<span id="clickmeeting">&nbsp;&nbsp;<i class="fa fa-pencil" style="font-size:15px;margin-bottom: -2px" data-toggle="tooltip" title="Edit">&nbsp;</i></span></h4>	
					</div>
					<hr>
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
{/strip}

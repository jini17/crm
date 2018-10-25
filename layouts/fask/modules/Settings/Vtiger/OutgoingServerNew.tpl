{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
-->*}
{strip}
<div class="container-fluid">
	<div class="contents row-fluid">
		{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
		<form action="index.php?module=Vtiger&parent=Settings&action=SaveFromEmail" method="post" name="index" enctype="multipart/form-data" class="form-horizontal" >
			<input type="hidden" name="return_module" value="Settings">
			<input type="hidden" name="parenttab" value="Settings">
			
			
    	<input type="hidden" name="return_action" value="EmailConfig">
			
			<div class="widget_header row-fluid">
				<div class="span8"><h3>{vtranslate('LBL_OUTGOING_SERVER', $QUALIFIED_MODULE)}</h3>&nbsp;{vtranslate('LBL_OUTGOING_SERVER_DESC', $QUALIFIED_MODULE)}</div>
				<div class="span4 btn-toolbar"><div class="pull-right">
					<button class="btn btn-success" type="submit" title="{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
					<!--<button type="button" title="{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}"  onclick="window.history.back()"><strong>{vtranslate('LBL_CANCEL_BUTTON_LABEL', $QUALIFIED_MODULE)}</strong></button>-->
					<a class="cancelLink" type="reset" onclick="javascript:window.location.replace('index.php?parent=Settings&module=Vtiger&view=OutgoingServerDetail');">Cancel</a>
					
				</div></div>
			</div>
			<hr>

			<input type="hidden" name="id" value="{$ID}">

			<div class="row-fluid hide errorMessage">
				<div class="alert alert-error">
				  {vtranslate('LBL_TESTMAILSTATUS', $QUALIFIED_MODULE)}<strong>{vtranslate('LBL_MAILSENDERROR', $QUALIFIED_MODULE)}</strong>  
				</div>
			</div>
			{foreach name=emaildetail1 item=emaildetail from=$EDIT}
			{$EMAIL = $emaildetail.email}
			{$NAME = $emaildetail.name}
			{$ID = $emaildetail.id}
			{/foreach}
			<input type="hidden" name="id" value="{$ID}">
			<table class="table table-bordered table-condensed themeTableColor">
				<thead>
					<tr class="blockHeader"><th colspan="2" class="{$WIDTHTYPE}">{vtranslate('LBL_MAIL_SERVER_SMTP', $QUALIFIED_MODULE)}</th></tr>
				</thead>
				<tbody>
					<tr>
                            <td width="20%" class="labelmiddle">
                            	<label class="muted pull-right marginRight10px"><font color="red">*</font>{vtranslate('LBL_EMAIL_EMAIL', $QUALIFIED_MODULE)}</label>
                            	
                            </td>
                            <td width="80%" class="small cellText">
				<input style="width:50%;" type="text" name="email" class="detailedViewTextBox" value="{$EMAIL}">
			    </td>
                          </tr>
                          <tr>
                            <td width="20%" class="labelmiddle"><label class="muted pull-right marginRight10px">{vtranslate('LBL_EMAIL_NAME', $QUALIFIED_MODULE)}</label></td>
                            <td width="80%" class="small cellText">
				<input style="width:50%;" type="text" name="name" class="detailedViewTextBox" value="{$NAME}">
			    </strong></td>
                          </tr>
                          
					
				</tbody>
			</table>
		
			<br>	
			
		</form>
	</div>
</div>
	
{/strip}
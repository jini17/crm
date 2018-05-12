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

<script>
function ifselected()
{ldelim}


      var sel =document.massdelete.selected_id.length;
      var returnval=false;

     for(i=0; i < sel; i++)
     {ldelim}

      if(document.massdelete.selected_id[i].checked == true)
        {ldelim}
            returnval=true;
            break;
        {rdelim}

      {rdelim}


          if(returnval==true)
           {ldelim}
               document.getElementById("newEmail").style.display="none";
           {rdelim}
          else
           {ldelim}
              document.getElementById("newEmail").style.display="block";
          {rdelim}

{rdelim}
</script>
<div class="container-fluid" id="OutgoingServerDetails">
	<div id="detailHeader">
		<div class="widget_header row-fluid">
			<div class="span8"><h3>{vtranslate('LBL_OUTGOING_SERVER', $QUALIFIED_MODULE)}</h3></div>

			<div class="span4"><div class="pull-right"><button class="btn editButton" data-url='{$MODEL->getEditViewUrl()}' type="button" title="{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}</strong></button></div></div>
		</div>
	<hr>
	</div>
	<div class="contents row-fluid" id="contents">
		<table class="table table-bordered table-condensed themeTableColor">
			<thead>
				<tr class="blockHeader">
					<th colspan="2" class="{$WIDTHTYPE}">
						<span class="alignMiddle">{vtranslate('LBL_MAIL_SERVER_SMTP', $QUALIFIED_MODULE)}</span>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr><td width="25%" class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate('LBL_SERVER_NAME', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE}" style="border-left: none;"><span>{$MODEL->get('server')}</span></td></tr>
				<tr><td class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate('LBL_USER_NAME', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE}" style="border-left: none;"><span>{$MODEL->get('server_username')}</span></td></tr>
				<tr><td class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate('LBL_PASSWORD', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE}" style="border-left: none;"><span class="password">{if $MODEL->get('server_password') neq ''}
													******
													{/if}&nbsp;</span></td></tr>
				<tr><td class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate('LBL_FROM_EMAIL', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE}" style="border-left: none;"><span>{$MODEL->get('from_email_field')}</span></td></tr>
				<tr><td class="{$WIDTHTYPE}"><label class="muted pull-right marginRight10px">{vtranslate('LBL_REQUIRES_AUTHENTICATION', $QUALIFIED_MODULE)}</label></td>
					<td class="{$WIDTHTYPE}" style="border-left: none;"><span>{if $MODEL->isSmtpAuthEnabled()}{vtranslate('LBL_YES', $QUALIFIED_MODULE)} {else}{vtranslate('LBL_NO', $QUALIFIED_MODULE)}{/if}</span></td></tr>
			</tbody>
		</table>
	</div>
        <!-- multiple from address :afiq -->
        <br/>
        <div class="widget_header row-fluid">
		<div class="span4"><div class="pull-left">
				<span class="btn-group">
				<input style="width:65px" class="btn btn-danger span10 marginLeftZero" type="button" value="{vtranslate('LBL_DELETE', $QUALIFIED_MODULE)}" id="deleteItem" > <!-- removed onclick event & change type submit to button-->
				</span>
			</div>

		<div class="span4"><div class="pull-right" id="newEmail"><button class="btn newButton" data-url='{$MODEL->getNewViewUrl()}' type="button" name="profile" title="{vtranslate('LBL_LIST_NEW', $QUALIFIED_MODULE)}" id="newmailbtn"><strong>{vtranslate('LBL_LIST_NEW', $QUALIFIED_MODULE)}</strong></button></div></div>
	</div>
	<hr>
	<div class="contents row-fluid" id="bottom">
	<form name="massdelete" method="POST" onsubmit="VtigerJS_DialogBox.block();">
			<input name="idlist" type="hidden" id="idlist">	<!--id attr added by jitu@tar -->
			<!--<input name="module" type="hidden" value="Settings">
    		<input name="action" type="hidden" value="DeleteEmailDetails">-->
		<table class="table table-condensed themeTableColor">
			<thead>
				<tr class="blockHeader">
					<th>#</th>
                                        <th><label>{vtranslate('LBL_LIST_SELECT', $QUALIFIED_MODULE)}</label></th>
                                        <th class="{$WIDTHTYPE}"><label>{vtranslate('LBL_EMAIL_NAME', $QUALIFIED_MODULE)}</label></th>
                                        <th class="{$WIDTHTYPE}"><label>{vtranslate('LBL_EMAIL_EMAIL', $QUALIFIED_MODULE)}</label></th>
				</tr>
			</thead>
			<tbody >


					{foreach name=emaildetail1 item=emaildetail from=$DETAILS}
					<tr>
						<td>{$emaildetail.no}</td>
						<td><input type="checkbox" name="selected_id" value="{$emaildetail.id}" onclick="ifselected(); " class=small></td>
						<td class="listTableRow small" valign=top>
							<a class="coloredlink" href="index.php?module=Vtiger&parent=Settings&view=OutgoingServerNewEdit&block=4&fieldid=15&id={$emaildetail.id}" >{$emaildetail.name}</a>
						</td>
						<td class="listTableRow small" valign=top>
							{$emaildetail.email}
						</td>

					</tr>

					{/foreach}

			</tbody>
		</table>
		</form>
	</div>
        <!-- end of code-->
</div>
{/strip}
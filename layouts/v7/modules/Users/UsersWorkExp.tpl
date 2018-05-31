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
<div id="UserWorkExpContainer">
	<div class="contents row-fluid">
		{assign var=CREATE_WORKEXP_URL value=$WORKEXP_RECORD_MODEL->getCreateUserWorkExpUrl()}
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	
		<div class="marginBottom10px">
			<button type="button" class="btn" onclick="Users_WorkExp_Js.addWorkExp('{$CREATE_WORKEXP_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_WORKEXP', $MODULE)}</strong></button>
		</div>
		<div class="listViewContentDiv" id="listViewContents">
			<div class="contents-topscroll noprint">
				<div class="topscroll-div" style="width:756px">
					&nbsp;
				 </div>
			</div>
			<div class="listViewEntriesDiv contents-bottomscroll">
				<div class="bottomscroll-div">
					<table class="table table-bordered table-condensed listViewEntriesTable">
						<thead>
							<tr class="listViewHeaders">
								<th nowrap width="20%"><strong>{vtranslate('LBL_COMPANY_NAME', $MODULE)}</strong></td>
								<th nowrap width="15%"><strong>{vtranslate('LBL_DESIGNATION', $MODULE)}</strong></td>
								<th nowrap width="15%"><strong>{vtranslate('LBL_LOCATION', $MODULE)}</strong></td>
								<th nowrap width="15%"><strong>{vtranslate('LBL_TIMEPERIOD', $MODULE)}</strong></td>
								<th nowrap><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></td>
								<th nowrap width="10%" colspan="2" class="medium"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></td>
							</tr>
						</thead>
						<tbody>
							{foreach item=USER_WORKEXP from=$USER_WORKEXP_LIST}
								<tr>
									<td class="listTableRow small" valign=top><label class="instlabel">{$USER_WORKEXP['company_title']}</label></td>
									<td class="listTableRow small" valign=top><span class="durationlabel">{$USER_WORKEXP['designation']}</span></td>
									<td class="listTableRow small" valign=top><span class="Workexplabel">{$USER_WORKEXP['location']}</span></td>
									<td class="listTableRow small" valign=top><span class="startdatelable">{$USER_WORKEXP['start_date']} {vtranslate('LBL_TO', $MODULE)} {if $USER_WORKEXP['end_date'] eq ''}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_WORKEXP['end_date']}{/if}</span></td>
									<td class="listTableRow small" valign=top><span class="descriptionlable">{$USER_WORKEXP['description']}</span></td>
									<td class="listTableRow small" valign=top><span class="isviewlabel">{('0'==$USER_WORKEXP['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span></td>
									<td class="listTableRow small" valign=top>
										<div class="pull-right actions">
											<span class="actionImages">
												<a class="editWorkExp" data-url="{$CREATE_WORKEXP_URL}&record={$USER_WORKEXP['uw_id']}&userId={$USERID}"><i title="{vtranslate('LBL_EDIT', $MODULE)}" class="icon-pencil alignBottom"></i></a>&nbsp;&nbsp;<a class="deleteWorkExp cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteWorkExp&record={$USER_WORKEXP['uw_id']}"><i class="icon-trash alignMiddle" title="Delete"></i></a>
											</span>
										</div>
									</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
{/strip}

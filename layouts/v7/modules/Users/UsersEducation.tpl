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

<script src="layouts/v7/modules/Users/resources/Education.js"></script>
<div id="UserEducationContainer">
	<div class="contents row-fluid">
		{assign var=CREATE_EDUCATION_URL value=$EDUCATION_RECORD_MODEL->getCreateEducationUrl()}
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	
		<div class="marginBottom10px">
			<a id="menubar_quickCreate_Education" class="quickCreateModule" data-name="Education" data-url="index.php?module=Education&view=QuickCreateAjax" href="javascript:void(0)">Add Education</a>
			<!--<button type="button" class="addEducation btn addButton" data-url="{$CREATE_EDUCATION_URL}&userId={$USERID}" id="clickme"><i class="icon-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_EDUCATION', $MODULE)}</strong></button>-->
		</div>
		<div class="listViewContentDiv" id="listViewContents">
			<div class="contents-topscroll noprint">
				<div class="topscroll-div" style="width:756px">
					&nbsp;
				 </div>
			</div>
			<div class="listViewEntriesDiv contents-bottomscroll">
				<div class="bottomscroll-div">
					<table class="table table-bordered listViewEntriesTable">
						<thead>
							<tr>
								<th nowrap><strong>{vtranslate('LBL_INSTITUTION_NAME', $MODULE)}</strong></td>
								<th nowrap><strong>{vtranslate('LBL_DURATION', $MODULE)}</strong></td>
								<th nowrap><strong>{vtranslate('LBL_EDUCATION_LEVEL', $MODULE)}</strong></td>
								<th nowrap><strong>{vtranslate('LBL_AREA_OF_STUDY', $MODULE)}</strong></td>
								<th nowrap><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></td>
								<th nowrap colspan="2" class="medium"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></td>
							</tr>
						</thead>
						<tbody>
							{foreach item=USER_EDUCATION from=$USER_EDUCATION_LIST}
								<tr>
									<td class="listTableRow small" valign=top>{$USER_EDUCATION['institution']}</td>
									<td class="listTableRow small" valign=top>{$USER_EDUCATION['start_date']} {vtranslate('LBL_TO', $MODULE)} {if $USER_EDUCATION['is_studying'] eq '1'}{vtranslate('LBL_TILL_NOW', $MODULE)}{else}{$USER_EDUCATION['end_date']}{/if}</td>
									<td class="listTableRow small" valign=top>{$USER_EDUCATION['education_level']}</td>
									<td class="listTableRow small" valign=top>{$USER_EDUCATION['major']}</td>
									<td class="listTableRow small" valign=top>{$USER_EDUCATION['description']}</td>
									<td class="listTableRow small" valign=top>
										{('0'==$USER_EDUCATION['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}
									</td>
									<td width="5%" class="listTableRow small" valign=top>
										<div class="pull-right actions">
											<span class="actionImages">
												<a class="editEducation" data-url="{$CREATE_EDUCATION_URL}&record={$USER_EDUCATION['edu_id']}&userId={$USERID}"><i class="icon-pencil alignBottom" title="{vtranslate('LBL_EDIT', $MODULE)}"></i></a>&nbsp;&nbsp;<a class="deleteEducation cursorPointer" data-url="?module=Users&action=DeleteSubModuleAjax&mode=deleteEducation&record={$USER_EDUCATION['edu_id']}"><i class="icon-trash alignMiddle" title="Delete"></i></a>
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

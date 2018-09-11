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
<div id="UserProjectContainer">
	<div class="contents row-fluid">
		{assign var=CREATE_PROJECT_URL value=$PROJECT_RECORD_MODEL->getCreateProjectUrl()}
		{assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}	

		<div class="myProfileBtn">
			<button type="button" class="btn btn-primary" onclick="Users_Project_Js.addProject('{$CREATE_PROJECT_URL}&userId={$USERID}');"><i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_NEW_PROJECT', $MODULE)}</strong></button>
		</div>

		<div class="listViewContentDiv" id="listViewContents">
			
			<div class="listViewEntriesDiv contents-bottomscroll">
				<div class="bottomscroll-div">
					<table class="table table-bordered table-condensed listViewEntriesTable" style="background-color: #fff;margin: 14px;width: 98%;">
						<thead>
							<tr class="listViewHeaders">
								<th nowrap width="15%"><strong>{vtranslate('LBL_PROJECT_TITLE', $MODULE)}</strong></th>
								<th nowrap><strong>{vtranslate('LBL_DESCRIPTION', $MODULE)}</strong></th>
								<th nowrap><strong>{vtranslate('LBL_OCCUPATION', $MODULE)}</strong></th>
								<th nowrap width="10%"><strong>{vtranslate('LBL_DATE', $MODULE)}</strong></th>
								<th nowrap><strong>{vtranslate('LBL_PROJECT_URL', $MODULE)}</strong></th>
								<th nowrap width="10%" colspan="2" class="medium"><strong>{vtranslate('LBL_EDUCATION_ISVIEW', $MODULE)}</strong></th>
							</tr>
						<thead>
						<tbody>
							{foreach item=USER_PROJECT from=$USER_PROJECT_LIST}
								<tr>
									<td class="listTableRow small" valign=top>{$USER_PROJECT['title']}</td>
									<td class="listTableRow small" valign=top>{$USER_PROJECT['description']}</td>
									<td class="listTableRow small" valign=top>{if $USER_PROJECT['relation_type'] eq 'E'}Student at {/if}{$USER_PROJECT['designation']}</td>
									<td class="listTableRow small" valign=top>{$USER_PROJECT['project_start_date']}</td>
									<td class="listTableRow small" valign=top>{$USER_PROJECT['project_url']}</td>
									<td class="listTableRow small" valign=top>{('0'==$USER_PROJECT['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</td>
									<td class="listTableRow small" valign=top>
										<div class="pull-right actions">
											<span class="actionImages">
												

												<a class="editProject editAction ti-pencil" title="{vtranslate('LBL_EDIT', $MODULE)}" onclick="Users_Project_Js.editProject('index.php{$CREATE_PROJECT_URL}&record={$USER_PROJECT['employeeprojectsid']}&userId={$USERID}');"></a>
												&nbsp;&nbsp;
												<a class="cursorPointer" onclick="Users_Project_Js.deleteProject('index.php?module=EmployeeProjects&action=Delete&record={$USER_PROJECT['employeeprojectsid']}');">
												<i title="{vtranslate('LBL_DELETE', $MODULE)}" class="fa fa-trash-o"></i></a>
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

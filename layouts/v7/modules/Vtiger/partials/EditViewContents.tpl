{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
********************************************************************************/
-->*}
{strip}
	{if !empty($PICKIST_DEPENDENCY_DATASOURCE)}
		<input type="hidden" name="picklistDependency" value='{Vtiger_Util_Helper::toSafeHTML($PICKIST_DEPENDENCY_DATASOURCE)}' />
	{/if}

	<div name='editContent'>
		{if $DUPLICATE_RECORDS}
			<div class="fieldBlockContainer duplicationMessageContainer">
				<div class="duplicationMessageHeader"><b>{vtranslate('LBL_DUPLICATES_DETECTED', $MODULE)}</b></div>
				<div>{getDuplicatesPreventionMessage($MODULE, $DUPLICATE_RECORDS)}</div>
			</div>
		{/if}
		{foreach key=BLOCK_LABEL item=BLOCK_FIELDS from=$RECORD_STRUCTURE name=blockIterator} 
			{if $BLOCK_FIELDS|@count gt 0}
				<div class='fieldBlockContainer' data-block="{$BLOCK_LABEL}">
					<h4 class='fieldBlockHeader'>{vtranslate($BLOCK_LABEL, $MODULE)}</h4>
					<hr>
					<table class="table table-borderless">
						<!--Added By Mabruk-->
						{if $BLOCK_LABEL eq 'Meeting Agenda' && $MODULE eq 'Events'}
							<tr>
								<td class="fieldLabel alignMiddle">Select an Agenda Template</td>
								<td class="fieldValue" style="width:1015px">
									<select id="agendaTemplate" class="select2 inputElement" name="agendaTemplate">
										<option value="" slected>Select a template</option>
										{foreach item=ITEM from=$DATA}											
											<option value="{$ITEM.body}">{$ITEM.name}</option>
										{/foreach}
									</select>
								</td>								
							</tr>
						{/if}
						{if $BLOCK_LABEL eq 'LBL_MOM_BLOCK' && $MODULE eq 'Events'}
							<tr>
								<td class="fieldLabel alignMiddle">Select a MOM Template</td>
								<td class="fieldValue" style="width:1015px">
									<select id="MOMTemplate" class="select2 inputElement" name="MOMTemplate">
										<option value="" slected>Select a template</option>
										{foreach item=ITEM from=$DATA}											
											<option value="{$ITEM.body}">{$ITEM.name}</option>
										{/foreach}
									</select>
								</td>								
							</tr>
						{/if}
						<!--End-->
						<tr>
							{assign var=COUNTER value=0}
							{foreach key=FIELD_NAME item=FIELD_MODEL from=$BLOCK_FIELDS name=blockfields}
								{assign var="isReferenceField" value=$FIELD_MODEL->getFieldDataType()}
								{assign var="refrenceList" value=$FIELD_MODEL->getReferenceList()}
								{assign var="refrenceListCount" value=count($refrenceList)}
								{if $FIELD_MODEL->isEditable() eq true}
									{if $FIELD_MODEL->get('uitype') eq "19"}
										{if $COUNTER eq '1'}
											<td></td><td></td></tr><tr>
											{assign var=COUNTER value=0}
										{/if}
									{/if}
									{if $COUNTER eq 2}
									</tr><tr>
										{assign var=COUNTER value=1}
									{else}
										{assign var=COUNTER value=$COUNTER+1}
									{/if}
									<td class="fieldLabel alignMiddle">
										
										{if $isReferenceField eq "reference"}
											{if $refrenceListCount > 1}
												{assign var="DISPLAYID" value=$FIELD_MODEL->get('fieldvalue')}
												{assign var="REFERENCED_MODULE_STRUCTURE" value=$FIELD_MODEL->getUITypeModel()->getReferenceModule($DISPLAYID)}
												{if !empty($REFERENCED_MODULE_STRUCTURE)}
													{assign var="REFERENCED_MODULE_NAME" value=$REFERENCED_MODULE_STRUCTURE->get('name')}
												{/if}
												<select style="width: 140px;" class="select2 referenceModulesList">
													{foreach key=index item=value from=$refrenceList}
														<option value="{$value}" {if $value eq $REFERENCED_MODULE_NAME} selected {/if}>{vtranslate($value, $value)}</option>
													{/foreach}
												</select>
											{else}
												{if $FIELD_MODEL->get('uitype') eq "66" && $DISABLEDRELATED eq 1}
												{else}
													{vtranslate($FIELD_MODEL->get('label'), $MODULE)}
												{/if}
												
											{/if}
										{else if $FIELD_MODEL->get('uitype') eq "83"}
											{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE) COUNTER=$COUNTER MODULE=$MODULE}
											{if $TAXCLASS_DETAILS}
												{assign 'taxCount' count($TAXCLASS_DETAILS)%2}
												{if $taxCount eq 0}
													{if $COUNTER eq 2}
														{assign var=COUNTER value=1}
													{else}
														{assign var=COUNTER value=2}
													{/if}
												{/if}
											{/if}
										{else}
											{if $MODULE eq 'Documents' && $FIELD_MODEL->get('label') eq 'File Name'}
												{assign var=FILE_LOCATION_TYPE_FIELD value=$RECORD_STRUCTURE['LBL_FILE_INFORMATION']['filelocationtype']}
												{if $FILE_LOCATION_TYPE_FIELD}
													{if $FILE_LOCATION_TYPE_FIELD->get('fieldvalue') eq 'E'}
														{vtranslate("LBL_FILE_URL", $MODULE)}&nbsp;<span class="redColor">*</span>
													{else}
														{vtranslate($FIELD_MODEL->get('label'), $MODULE)}
													{/if}
												{else}
													{vtranslate($FIELD_MODEL->get('label'), $MODULE)}
												{/if}
											{else}
												<!--added by jitu@hide HR document checkbox-->
												{if $MODULE eq 'Documents' AND  $HRDOC eq '1' AND $FIELD_MODEL->get('label') eq 'Is HR Document?'}
													
												{else}
												{vtranslate($FIELD_MODEL->get('label'), $MODULE)}
												{/if}
												<!-- End here -->
											{/if}
										{/if}
										&nbsp;{if $FIELD_MODEL->isMandatory() eq true} <span class="redColor">*</span> {/if}
									</td>
									{if $FIELD_MODEL->get('uitype') neq '83'}
										{if $MODULE eq 'Documents' AND  $HRDOC eq '1' AND $FIELD_MODEL->get('label') eq 'Is HR Document?'}
											
										
										{else}
											<!--added by jitu@hide related to if account/leads disabled -->
											{if $FIELD_MODEL->get('uitype') eq "66" && $DISABLEDRELATED eq 1}
											
											{else}
												<td class="fieldValue" {if $FIELD_MODEL->getFieldDataType() eq 'boolean'} style="width:25%" {/if} {if $FIELD_MODEL->get('uitype') eq '19'} colspan="3" {assign var=COUNTER value=$COUNTER+1} {/if}>
												{include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE)}
												</td>
											{/if}
											<!--End here -->
										{/if}
									{/if}
								{/if}
							{/foreach}
							{*If their are odd number of fields in edit then border top is missing so adding the check*}
							{if $COUNTER is odd}
								<td></td>
								<td></td>
							{/if}
						</tr>
						<!-- Added By Jitu Mabruk for Meeting-->
						{if $BLOCK_LABEL eq 'Participants' && $MODULE eq 'Events'}
							<tr>
								<td class="fieldLabel alignMiddle">{vtranslate('LBL_INVITE_USERS', $MODULE)}</td>
								<td class="fieldValue">
									<select id="selectedUsers" class="select2 inputElement" multiple name="selectedusers[]">
										{foreach key=USER_ID item=USER_NAME from=$ACCESSIBLE_USERS}
											{if $USER_ID eq $CURRENT_USER->getId()}
												{continue}
											{/if}
											<option value="{$USER_ID}" {if in_array($USER_ID,$INVITIES_SELECTED)}selected{/if}>
												{$USER_NAME}
											</option>
										{/foreach}
									</select>
								</td>
								<td></td><td></td>
							</tr>
							<tr>
								<td class="fieldLabel alignMiddle">{vtranslate('LBL_INVITE_EXTERNAL_EMAILS', $MODULE)}</td>
								<td class="fieldValue">
									
									<select id="externalusers" class="select2 inputElement {if $EXTERNAL_EMAILS|count eq 0} hide{/if}" multiple name="externalusers[]" placeholder="Click on add icon">
										{foreach item=EMAIL from=$EXTERNAL_EMAILS}
											<option value="{$EMAIL['emailaddress']}" selected>
												{$EMAIL['emailaddress']}
											</option>
										{/foreach}
									</select>
									&nbsp;&nbsp;
									<span class="addemail" style="cursor:pointer;"><button class="btn" name="addemail"><i class="fa fa-plus"></i>&nbsp;Add Email</button></span>
									<span class="fieldvalue inputspan hide"><input type="email" class="inputElement" name="extemail" id="extemail" /></span>
									
									<div class="btn-group inline-save hide">
        								<button class="button btn-success btn-small add" type="button" name="save"><i class="fa fa-check"></i></button>
        								<button class="button btn-danger btn-small cancelbtn" type="button" name="Cancel"><i class="fa fa-close"></i></button>
    								</div>
								</td>
								<td></td><td></td>
							</tr>		
						{/if}
					</table>
				</div>

			{/if}
		{/foreach}
	</div>
{/strip}

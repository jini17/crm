<script src="layouts/vlayout/modules/Users/resources/Emergency.js?v=6.1.0" type="text/javascript"></script>
{strip}
{assign var=EDIT_EMERGENCY_URL value=$EMERGENCY_RECORD_MODEL->getEditEmergencyUrl()}
<div id="UserEmergencyContainer">
	<div class="pull-right">
		<button type="button" class="editEmergency btn" data-url="{$EDIT_EMERGENCY_URL}&userId={$USERID}"><strong>{vtranslate('LBL_EDIT_CONTACT', $MODULE)}</strong></button>	
	</div><br /><br />
	<table class="table table-bordered equalSplit detailview-table">
		<thead>
			<tr>
				<th class="blockHeader" colspan="4">
					Emergency Contact
				</th>	
			</tr>
		</thead>	
		<tbody>
			<tr>
				<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_CONTACT_NAME', $MODULE)}</label>
				</td>
				<td class="fieldValue medium">
					<span class="value"> {$USER_EMERGENCY_CONTACTS['contact_name']} </span>
				</td>
				<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_HOME_PH', $MODULE)}</label>
				</td>
				<td class="fieldValue medium">
					<span class="value"> {$USER_EMERGENCY_CONTACTS['home_phone']} </span>
				</td>
			</tr>
			<tr>
				<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_OFFICE_PH', $MODULE)}</label>		</td>
				<td class="fieldValue medium">
					<span class="value" data-field-type="boolean"> {$USER_EMERGENCY_CONTACTS['office_phone']} </span>
				</td>
				<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_MOBILE', $MODULE)}</label>
				</td>
				<td class="fieldValue medium">
					<span class="value" data-field-type="userRole"> {$USER_EMERGENCY_CONTACTS['mobile']} </span>
				</td>
			</tr>
			<tr>
				<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_RELATIONSHIP', $MODULE)}</label>
				</td>
				<td class="fieldValue medium">
					<span class="value" data-field-type="picklist"> {$USER_EMERGENCY_CONTACTS['relationship']} </span>
				</td>
				<!--<td class="fieldLabel medium">
					<label class="muted pull-right marginRight10px">{vtranslate('LBL_PUBLIC', $MODULE)}</label>
				</td>
				<td class="fieldValue medium">
					<span class="value">{('0'==$USER_EMERGENCY_CONTACTS['isview'])?{vtranslate('LBL_NO', $MODULE)}:{vtranslate('LBL_YES', $MODULE)}}</span>
				</td>-->
			</tr>
		</tbody>
	</table>
</div>
{/strip}

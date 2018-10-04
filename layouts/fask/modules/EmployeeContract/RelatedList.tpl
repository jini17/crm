{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{strip}
	{assign var=RELATED_MODULE_NAME value=$RELATED_MODULE->get('name')}
	{include file="PicklistColorMap.tpl"|vtemplate_path:$MODULE LISTVIEW_HEADERS=$RELATED_HEADERS}

	<div class="relatedContainer">
			<div class="relatedContents col-lg-10 col-md-10 col-sm-10 table-container">
			<div class="bottomscroll-div">
				<table id="listview-table" class="table listview-table">
					<thead>
						<tr class="listViewHeaders ">
								<th class="nowrap ">
									{vtranslate('LBL_BENEFIT_NAME', $MODULE)}
								</th>
								<th class="nowrap ">
									{vtranslate('LBL_BENEFIT_DESCRIPTION', $MODULE)}
								</th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		<script type="text/javascript">
			var related_uimeta = (function () {
				var fieldInfo = {$RELATED_FIELDS_INFO};
				return {
					field: {
						get: function (name, property) {
							if (name && property === undefined) {
								return fieldInfo[name];
							}
							if (name && property) {
								return fieldInfo[name][property]
							}
						},
						isMandatory: function (name) {
							if (fieldInfo[name]) {
								return fieldInfo[name].mandatory;
							}
							return false;
						},
						getType: function (name) {
							if (fieldInfo[name]) {
								return fieldInfo[name].type
							}
							return false;
						}
					}
				};
			})();
		</script>
	</div>
{/strip}
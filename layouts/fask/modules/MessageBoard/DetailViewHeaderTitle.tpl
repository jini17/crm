{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="record-header clearfix">
			{if !$MODULE}
				{assign var=MODULE value=$MODULE_NAME}
			{/if}
			<div class="recordImage bg_{$MODULE} hidden-sm hidden-xs ">
				<div class="name">
						<img src="{$IMAGEPATH}">
						<span><strong><i class="{if $MODULE eq 'EmailTemplates'}ti-email templates{else}ti-{strtolower($MODULE)}{/if}"></i></strong></span>
				</div>  
			</div>

			<div class="recordBasicInfo">
				<div class="info-row">
					<h4>
						<span class="recordLabel pushDown" title="{$RECORD->getName()}">
							{foreach item=NAME_FIELD from=$MODULE_MODEL->getNameFields()}
								{assign var=FIELD_MODEL value=$MODULE_MODEL->getField($NAME_FIELD)}
								{if $FIELD_MODEL->getPermissions()}
									<span class="{$NAME_FIELD}">{$RECORD->get($NAME_FIELD)}</span>&nbsp;
								{/if}
							{/foreach}
						</span>
					</h4>
				</div>
				{include file="DetailViewHeaderFieldsView.tpl"|vtemplate_path:$MODULE}
			</div>
		</div>
	</div>
                        <script type="text/javascript">
                            jQuery(document).ready(function(){
                                    var messageheight = jQuery("#MessageBoard_detailView_fieldValue_message").height();
                                    jQuery("#MessageBoard_detailView_fieldLabel_message").css("height",messageheight+"px")
                                   
                                })
                       </script>     
                       <style>
                           #MessageBoard_detailView_fieldLabel_department,
                            #MessageBoard_detailView_fieldValue_department{
                                width: 100%;                            
                            }
                       </style>
{/strip}
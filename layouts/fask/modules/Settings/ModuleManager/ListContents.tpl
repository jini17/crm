{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/ModuleManager/views/List.php *}

{strip}
	<div class="listViewPageDiv detailViewContainer" id="moduleManagerContents">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div id="listview-actions" class="listview-actions-container">
				<div class="clearfix">
					<h4 class="pull-left">{vtranslate('LBL_MODULE_MANAGER', $QUALIFIED_MODULE)} 
					 </h4>




<div class="pull-right">
						<div class="btn-group">
							<button class="btn btn-secondary" type="button" onclick='window.location.href="{$IMPORT_USER_MODULE_FROM_FILE_URL}"'>
								{vtranslate('LBL_IMPORT_MODULE_FROM_ZIP', $QUALIFIED_MODULE)}
							</button>
						
							<button class="btn btn-secondary" type="button" onclick='window.location.href = "{$IMPORT_MODULE_URL}"'>
								{vtranslate('LBL_EXTENSION_STORE', 'Settings:ExtensionStore')}
							</button>
                                                        
						</div>
					</div>
				</div>
				<br>
				<div class="contents">
					{assign var=COUNTER value=0}
					<table class="table table-bordered modulesTable">
						<tr>
							{foreach item=MODULE_MODEL key=MODULE_ID from=$ALL_MODULES}
								{assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
								{assign var=MODULE_ACTIVE value=$MODULE_MODEL->isActive()}
								{assign var=MODULE_LABEL value=vtranslate($MODULE_MODEL->get('label'), $MODULE_MODEL->get('name'))}
								{if $COUNTER eq 2}
								</tr><tr>
									{assign var=COUNTER value=0}
								{/if}
								<td class="ModulemanagerSettings">
									<div class="moduleManagerBlock">
										<span class="col-lg-1" style="line-height: 2.5;">
											<input type="checkbox" value="" name="moduleStatus" data-module="{$MODULE_NAME}" data-module-translation="{$MODULE_LABEL}" {if $MODULE_MODEL->isActive()}checked{/if} />
										</span>
										<span class="col-lg-1 moduleImage {if !$MODULE_ACTIVE}dull {/if}">
											{if !$MODULE}
											{assign var=MODULE value=$MODULE_NAME}
											{/if}
												
												

											{if vimage_path($MODULE_NAME|cat:'.png') != false}
												
												<i class="ti-{strtolower($MODULE_LABEL)} alignMiddle" alt="{$MODULE_LABEL}" title="{$MODULE_LABEL}" ></i>
											{else}
												<i class="ti-folder alignMiddle" alt="{$MODULE_LABEL}" title="{$MODULE_LABEL}"></i>
											{/if}	

										</span>
										<span class="col-lg-7 moduleName {if !$MODULE_ACTIVE} dull {/if}"><h5>{$MODULE_LABEL}</h5></span>
											{assign var=SETTINGS_LINKS value=$MODULE_MODEL->getSettingLinks()}
											{if !in_array($MODULE_NAME, $RESTRICTED_MODULES_LIST) && (count($SETTINGS_LINKS) > 0)}
											<span class="col-lg-3 moduleblock">
												<span class="btn-group pull-right actions {if !$MODULE_ACTIVE}hide{/if}">
													<button class="btn btn-success btn dropdown-toggle unpin hiden " data-toggle="dropdown">
														{vtranslate('LBL_SETTINGS', $QUALIFIED_MODULE)}&nbsp;<i class="caret"></i>
													</button>
													<ul class="dropdown-menu pull-right dropdownfields animated flipInY">
														{foreach item=SETTINGS_LINK from=$SETTINGS_LINKS}
															<li>
																<a {if stripos($SETTINGS_LINK['linkurl'], 'javascript:')===0} onclick='{$SETTINGS_LINK['linkurl']|substr:strlen("javascript:")};'{else} onclick='window.location.href = "{$SETTINGS_LINK['linkurl']}"'{/if}>{vtranslate($SETTINGS_LINK['linklabel'], $MODULE_NAME, vtranslate("SINGLE_$MODULE_NAME", $MODULE_NAME))}</a>
															</li>
														{/foreach}
													</ul>
												</span>
											</span>
										{/if}
									</div>
									{assign var=COUNTER value=$COUNTER+1}
								</td>
							{/foreach}
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
{/strip}
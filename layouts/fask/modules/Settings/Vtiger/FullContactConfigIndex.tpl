{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Mabruk
************************************************************************************}
{* modules/Settings/Vtiger/views/FullContactConfigIndex.php *}

{strip}	
<div id="body">
<div class=" col-lg-12 col-md-12 col-sm-12">
{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
<div id="Head" style="position: relative;">
         <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98%; " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
    <div class="clearfix"></div>
	<div class="widget_header row-fluid">
		<div class="span8"><h3>Full Contact Configuration</h3></div>						
	</div>
	<hr>
	<br>
</div>

<div class="contents tabbable clearfix">
	<ul class="nav nav-tabs layoutTabs massEditTabs" id="tabs">
		<li class="tab-item taxesTab active"><a data-toggle="tab" href="#FullContactConfig"><strong>{vtranslate('LBL_FULLCONTACT_CONFIG', $QUALIFIED_MODULE)}</strong></a></li>
		</ul>
	<div class="tab-content layoutContent padding20 overflowVisible">
		<div class="tab-pane active" id="FullContactConfig">
			<div  id="contents">
				<div class="container-fluid" id="FullContactConfigDetails">
				
					<div class="pull-right">
						<button class="btn editButton" id="editButton" data-url='{$MODEL->getEditViewUrl()}' type="button" title="{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}</strong></button>
					</div>
					
					<div class="contents">
						<table class="table table-bordered table-condensed themeTableColor">
								<thead>
									<tr class="blockHeader">
										<th class="{$WIDTHTYPE}">
											<span class="alignMiddle">Full Contact Configuration</span>
										</th>
										<th >
											
										</th>
									</tr>
								</thead>
								<tbody>
									{assign var=FIELD_DATA value=$MODEL->getViewableData()}
									{foreach key=FIELD_NAME item=FIELD_DETAILS from=$MODEL->getEditableFields()} 
										{if $FIELD_DATA[$FIELD_NAME] eq "Inactive"}
											<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted marginRight10px pull-right">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
												<td style="border-left: none;" class="{$WIDTHTYPE}">
													<span>{$FIELD_DATA[$FIELD_NAME]}</span>
												</td>
											</tr>
										{break}										
										{else}
											<tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted marginRight10px pull-right">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
												<td style="border-left: none;" class="{$WIDTHTYPE}">
													<span>{$FIELD_DATA[$FIELD_NAME]}</span>
												</td>
											</tr>
										{/if}
									{/foreach}
								</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</div>
</div>
{/strip}
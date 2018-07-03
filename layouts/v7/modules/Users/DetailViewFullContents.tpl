{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{* modules/Vtiger/views/Detail.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
{strip}
	{assign var=NAME_FIELDS value=array('first_name', 'last_name')}
	{if $MODULE_MODEL}
		{assign var=NAME_FIELDS value=$MODULE_MODEL->getNameFields()}
	{/if}
	<!--start added by fadzil 28/8/14-->
	<div class="contents tabbable ui-sortable" id="tab">
	<!--added by jitu@secondcrm.com for Leave approval widget link-->
	<ul class="nav nav-tabs layoutTabs massEditTabs"> 
		<li class="{if $DEFAULT_TAB neq ''}relatedListTab{else}active{/if}">
			<a data-toggle="tab" href="#preference"><strong>{vtranslate('LBL_MY_PREFERENCES', $MODULE_NAME)}</strong></a>
		</li>
		<li class="relatedListTab">
			<a data-toggle="tab" href="#education"><strong>{vtranslate('LBL_EDUCATION', $MODULE_NAME)}</strong></a>
		</li>
		<li class="relatedListTab">
			<a data-toggle="tab" href="#workexp"><strong>{vtranslate('LBL_WORKEXP', $MODULE_NAME)}</strong></a>
		</li>
		<li class="relatedListTab">
			<a data-toggle="tab" href="#project"><strong>{vtranslate('LBL_USER_PROJECTS', $MODULE_NAME)}</strong></a>
		</li>
		<li class="relatedListTab">
			<a data-toggle="tab" href="#skills"><strong>{vtranslate('LBL_SKILL_LANG', $MODULE_NAME)}</strong></a>
		</li>
		<li class="relatedListTab">
			<a data-toggle="tab" href="#emergency"><strong>{vtranslate('LBL_USER_EMERGENCY', $MODULE_NAME)}</strong></a>
		</li>
		<!--Added by jitu@secondcrm.com on 24-12-2014 
		added by jitu@secondcrm.com for Leave approval widget link-->
		{if $ISACTIVE eq 0 && $VIEW eq 'PreferenceDetail'}
		<li class="{if $DEFAULT_TAB neq ''}active{else}relatedListTab{/if}">
			<a data-toggle="tab" href="#leave"><strong>{vtranslate('LBL_LEAVE', $MODULE_NAME)}</strong></a>
		</li>
		<li class="{if $DEFAULT_TAB neq ''}active{else}relatedListTab{/if}">
			<a data-toggle="tab" href="#claim"><strong>{vtranslate('LBL_CLAIM', $MODULE_NAME)}</strong></a>
		</li>		
		{/if}
		<!-- End Leave Tab-->
	</ul>
	</div>
	<div class="tab-pane" id="prefernces">
    	<form id="detailView" data-name-fields='{ZEND_JSON::encode($NAME_FIELDS)}' method="POST">
        	{include file='DetailViewBlockView.tpl'|@vtemplate_path:$MODULE_NAME RECORD_STRUCTURE=$RECORD_STRUCTURE MODULE_NAME=$MODULE_NAME}
    	</form>
	</div>
    <div class="tab-pane" id="education"></div>
	<div class="tab-pane" id="workexp"></div>
	<div class="tab-pane" id="skills"></div>
	<div class="tab-pane" id="project"></div>
	<div class="tab-pane" id="emergency"></div>
	<div class="tab-pane" id="leave"></div>
	<div class="tab-pane" id="claim"></div>		<!--Added by jitu@secondcrm.com on 24-12-2014-->
{/strip}

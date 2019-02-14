{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
	<div class='related-tabs row visible-lg'>
		<ul class="nav nav-tabs">
			{foreach item=RELATED_LINK from=$DETAILVIEW_LINKS['DETAILVIEWTAB']}
				{$engagementEnabledModules = ['Accounts','Contacts','Leads']}

					{assign var=RELATEDLINK_URL value=$RELATED_LINK->getUrl()}
					{assign var=RELATEDLINK_LABEL value=$RELATED_LINK->getLabel()}
					{assign var=RELATED_TAB_LABEL value={vtranslate('SINGLE_'|cat:$MODULE_NAME, $MODULE_NAME)}|cat:" "|cat:$RELATEDLINK_LABEL}
				<li class="tab-item {if $RELATED_TAB_LABEL==$SELECTED_TAB_LABEL}active{/if}" data-url="{$RELATEDLINK_URL}&tab_label={$RELATED_TAB_LABEL}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATEDLINK_LABEL}" data-link-key="{$RELATED_LINK->get('linkKey')}" >
					<a href="{$RELATEDLINK_URL}&tab_label={$RELATEDLINK_LABEL}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis">
						<span class="tab-label">{vtranslate($RELATEDLINK_LABEL,{$MODULE_NAME})}</span>
					</a>
				</li>
			{/foreach}

			{assign var=RELATEDTABS value=$DETAILVIEW_LINKS['DETAILVIEWRELATED']}
			{assign var=COUNT value=$RELATEDTABS|@count}

			{assign var=LIMIT value = 18}
			{if $COUNT gt 10}
				{assign var=COUNT1 value = $LIMIT}
			{else}
				{assign var=COUNT1 value=$COUNT}
			{/if}

			{for $i = 0 to $COUNT1-1}
				{if isset($RELATEDTABS[$i]) && $RELATEDTABS[$i] neq NULL}
					{assign var=RELATED_LINK value=$RELATEDTABS[$i]}
					{assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
					{assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
					{assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}
					<li class="tab-item {if (trim($RELATED_LINK->getLabel())== trim($SELECTED_TAB_LABEL)) && ($RELATED_LINK->getId() == $SELECTED_RELATION_ID)}active{/if}"  data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
						data-module="{$RELATEDMODULENAME}" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDMODULENAME eq "ModComments"} title {else} title="{$DETAILVIEWRELATEDLINKLBL}"{/if} {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if} >
						<a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis waves-effect waves-dark" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" title="{$DETAILVIEWRELATEDLINKLBL}" {if $RELATEDMODULENAME neq "ModComments"}tippytitle{/if}>
							{if $RELATEDMODULENAME eq "ModComments"}
								<span class="tab-label">{$DETAILVIEWRELATEDLINKLBL}</span>&nbsp;
									{else}
								<span class="tab-icon">
									{assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'fas fa-search-dollar',
    'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
    'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
    'foundation'=>'fas fa-info-circle','admin'=>'fas fa-hand-holding-heart',
    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
    'quotes'=>'description','invoice'=>'fas fa-file-invoice','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
    'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-headset','tools'=>'business_center',
    'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call',
    'performance'=>'fas fa-chart-line', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-hand-holding-usd','myprofile'=>'face'  ]}

    							  {if $iconsarray[{strtolower($RELATEDMODULENAME)}]|strstr:"fas"}
			                        <i class="{$iconsarray[{strtolower($RELATEDMODULENAME)}]}" style="height:15px;width:15px;" ></i> 
			                      {else}
			                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($RELATEDMODULENAME)}]}</i> 
			                      {/if}
								</span>
							{/if}
							<!--<span class="numberCircle disabled" >0</span>-->
						</a>
					</li>
					{if ($RELATED_LINK->getId() == {$smarty.request.relationId})}
						{assign var=MORE_TAB_ACTIVE value='true'}
					{/if}
				{/if}
			{/for}
			{if $MORE_TAB_ACTIVE neq 'true'}
				{for $i = 0 to $COUNT-1}
					{assign var=RELATED_LINK value=$RELATEDTABS[$i]}
					{if ($RELATED_LINK->getId() == {$smarty.request.relationId})}
						{assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
						{assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
						{assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}
						<li class="more-tab moreTabElement active"  data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
							data-module="{$RELATEDMODULENAME}" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDMODULENAME eq "ModComments"} title {else} title="{$DETAILVIEWRELATEDLINKLBL}"{/if} {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
							<a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis waves-effect waves-dark" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" >
								{if $RELATEDMODULENAME eq "ModComments"}
									<span class="tab-label" >{$DETAILVIEWRELATEDLINKLBL}</span>&nbsp;
								{else}  
									<span class="tab-icon">
										{assign var=RELATED_MODULE_MODEL value=Vtiger_Module_Model::getInstance($RELATEDMODULENAME)}  
										{assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'fas fa-search-dollar',
    'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
    'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
    'foundation'=>'fas fa-info-circle','admin'=>'fas fa-hand-holding-heart',
    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
    'quotes'=>'description','invoice'=>'fas fa-file-invoice','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
    'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-headset','tools'=>'business_center',
    'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call',
    'performance'=>'fas fa-chart-line', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-hand-holding-usd','myprofile'=>'face'  ]}
									
    							  {if $iconsarray[{strtolower($RELATEDMODULENAME)}]|strstr:"fas"}
			                        <i class="{$iconsarray[{strtolower($RELATEDMODULENAME)}]}" style="height:15px;width:15px;" ></i> 
			                      {else}
			                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($RELATEDMODULENAME)}]}</i> 
			                      {/if}
										
									</span>
								{/if}
								<!--<span class="numberCircle hide">0</span>-->
							</a>
						</li>
						{break}
					{/if}
				{/for}
			{/if}
			{if $COUNT gt $LIMIT}
				<li class="dropdown related-tab-more-element">
					<a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle">
						<span class="tab-label"> 
							{vtranslate("LBL_MORE",$MODULE_NAME)} &nbsp; <b class="fa fa-caret-down"></b>
						</span>
					</a>
					<ul class="dropdown-menu pull-right animated flipInY " style="min-width: 200px;" id="relatedmenuList">
						{for $j = $COUNT1 to $COUNT-1}
							{assign var=RELATED_LINK value=$RELATEDTABS[$j]}
							{assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
							{assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
							{assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}
							<li class="more-tab {if (trim($RELATED_LINK->getLabel())== trim($SELECTED_TAB_LABEL)) && ($RELATED_LINK->getId() == $SELECTED_RELATION_ID)}active{/if}" data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
								data-module="{$RELATEDMODULENAME}" title="" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
								<a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" class="waves-effect waves-dark">
									{if $RELATEDMODULENAME eq "ModComments"}
										<span class="tab-label textOverflowEllipsis"> {$DETAILVIEWRELATEDLINKLBL}</span>&nbsp;
									{else}  
										{assign var=RELATED_MODULE_MODEL value=Vtiger_Module_Model::getInstance($RELATEDMODULENAME)}  
										<span class="tab-icon textOverflowEllipsis">
{assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'fas fa-search-dollar',
    'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
    'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
    'foundation'=>'fas fa-info-circle','admin'=>'fas fa-hand-holding-heart',
    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
    'quotes'=>'description','invoice'=>'fas fa-file-invoice','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
    'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-headset','tools'=>'business_center',
    'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call',
    'performance'=>'fas fa-chart-line', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-hand-holding-usd','myprofile'=>'face'  ]}
									<i class="material-icons module-icon" >{$iconsarray[{strtolower($RELATEDMODULENAME)}]}</i>
											<span class="content"> &nbsp;{$DETAILVIEWRELATEDLINKLBL}</span>
										</span>
									{/if}
									<!-- Condition Added By Mabruk -->
									{if $RELATEDMODULENAME neq 'ClaimType'}							
										<!--<span class="numberCircle">0</span>-->
									{/if}	
									</a>
							</li>
						{/for}
					</ul>
				</li>
			{/if}
		</ul>
	</div>
{strip}
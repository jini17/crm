{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

{strip}
{include file="layouts/fask/modules/Vtiger/Header.tpl"}
{assign var="APP_IMAGE_MAP" value=[	'MARKETING' => 'ti-thumb-up',
'SALES' => 'ti-money',
'SUPPORT' => 'ti-headphone-alt',
'INVENTORY' => 'ti-archive',
'PROJECT' => 'ti-bag' ]}






<style>

.dropdown-submenu {
        position: relative;
}

.dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -1px;
}

</style>
<script type="text/javascript">
jQuery(document).ready(function(){

jQuery('.menu-open').on('hover',function(){

 jQuery('.app-navigator-container').find('.dropdown-menu.fask').css('display','block');

});

  jQuery('.addtionalDashboardTab').on('hover',function(){
       
          jQuery('.dropdown-menu.fask').css('display','none');

});

$( '.app-navigator-container' ).on('mouseleave','.dropdown-menu.fask', function(){
$(this).hide();
});


});


</script>

<nav class="navbar navbar-default navbar-fixed-top app-fixed-navbar">


<div class="container-fluid global-nav">
        <div class="row">
                <div class="col-lg-2 col-md-5 col-sm-4 col-xs-8 paddingRight0 app-navigator-container">
                        <div class="row">
                                <div id="appnavigator" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 cursorPointer app-switcher-container hidden-lg hidden-md " data-app-class="{if $MODULE eq 'Home' || !$MODULE}ti-dashboard{else}{$APP_IMAGE_MAP[$SELECTED_MENU_CATEGORY]}{/if}">
                                        <div class="row app-navigator">
                                                <span class="app-icon fa fa-bars"></span>
                                        </div>
                                </div>



                                <!-- nuovo menu-->	
                                <div class="dropdown col-lg-3 hidden-sm hidden-xs ">
                                        <button class="btn btn-fask btn-lg" type="button" id="dropdownMenuButtonDesk" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="material-icons" style="color: #fff!important"></i>
                                        </button>
                                        <div class="dropdown-menu fask" id="moredropdown"  aria-labelledby="dropdownMenuButtonDesk">
                                                <div class="bluredBackground"></div>
                                                <ul class="faskfirst">
                                                        <li class="nav-small-cap hide">APPS</li>


                                                        {assign var=USER_PRIVILEGES_MODEL value=Users_Privileges_Model::getCurrentUserPrivilegesModel()}
                                                        {assign var=HOME_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Home')}
                                                        {assign var=DASHBOARD_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Dashboard')}

                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($DASHBOARD_MODULE_MODEL->getId())}
                                                        <li class="{if $MODULE eq "Home"}active{/if}"> <a class=" waves-effect waves-dark" href="{$HOME_MODULE_MODEL->getDefaultUrl()}" ><i class="material-icons">dashboard</i><span class="hide-menu" style="text-transform: uppercase">{vtranslate('LBL_DASHBOARD',$MODULE)} </span></a>
                                                        </li>
                                                        {/if}

                                                        {assign var=MAILMANAGER_MODULE_MODEL value=Vtiger_Module_Model::getInstance('MailManager')}
                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($MAILMANAGER_MODULE_MODEL->getId())}

                                                    {*    <li class="{if $MODULE eq "MailManager"}active{/if}"> <a class=" waves-effect waves-dark" href="index.php?module=MailManager&view=List" ><i class="app-icon-list material-icons">email</i><span class="hide-menu"> {vtranslate('MailManager')}</span></a>
                                                        </li>*}
                                                        {/if}
                                                        {assign var=DOCUMENTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Documents')}
                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($DOCUMENTS_MODULE_MODEL->getId())}

                                                        <li class="{if $MODULE eq "Documents"}active{/if}"> <a class=" waves-effect waves-dark" href="index.php?module=Documents&view=List" ><i class="app-icon-list material-icons">insert_drive_file</i><span class="hide-menu"> {vtranslate('Documents')}</span></a>
                                                        </li>
                                                        {/if}
                                                        <hr/>
                                                        {if $USER_MODEL->isAdminUser()}


                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="index.php?module=Vtiger&parent=Settings&view=Index" ><span class="module-icon"><i class="material-icons">settings</i></span><span class="hide-menu">  {vtranslate('LBL_CRM_SETTINGS','Vtiger')}</span></a></li>

                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="index.php?module=Users&parent=Settings&view=List" ><span class="module-icon"><i class="material-icons">contacts</i></span><span class="hide-menu">   {vtranslate('LBL_MANAGE_USERS','Vtiger')}</span></a></li>


                                                        {else}

                                                        <li class="{if $MODULE eq "Users"}active{/if}"> <a class=" waves-effect waves-dark" href="index.php?module=Users&view=Settings" ><i class="material-icons">settings</i><span class="hide-menu" style="text-transform: uppercase"> {vtranslate('LBL_SETTINGS', 'Settings:Vtiger')}</span></a>
                                                        </li>

                                                        {/if}

                                                </ul>
                                                <ul class="fasksecond">
                                                        {assign var=APP_GROUPED_MENU value=Settings_MenuEditor_Module_Model::getAllVisibleModules()}
                                                        {assign var=APP_LIST value=Vtiger_MenuStructure_Model::getAppMenuList()}

                                                        {if $MODULE eq "Home"}
                                                        {assign var=SELECTED_MENU_CATEGORY value='Dashboard'}
                                                        {/if}

                                                        {foreach item=APP_NAME from=$APP_LIST}
                                                        {if $APP_NAME eq 'ANALYTICS'} {continue}{/if}
                                                        {if count($APP_GROUPED_MENU.$APP_NAME) gt 0}

                                                        {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
                                                        {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
                                                        {if $APP_MENU_MODEL}
                                                        {break}
                                                        {/if}
                                                        {/foreach}

                                                        {assign var=iconsarray value=['potentials'=>'attach_money','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
                                                        'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
                                                        'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
                                                        'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
                                                        'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
                                                        'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
                                                        'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
                                                        'mycthemeswitcher'=>'folder', 'chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call','performance'=>'timeline', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app','claim'=>'attach_money','myprofile'=>'face'  ]}


                                                        <li class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}"> 
                                                                <a class="has-arrow waves-effect waves-dark " >
                                                                        <i class="app-icon-list material-icons" >{$iconsarray[{strtolower($APP_NAME)}]}</i><span class="hide-menu">{vtranslate("LBL_$APP_NAME")}</span></a>

                                                                        <ul style="padding-left:6px;padding-top:15px;">
                                                                                {foreach item=moduleModel key=moduleName from=$APP_GROUPED_MENU[$APP_NAME]}
                                                                                {assign var='translatedModuleLabel' value=vtranslate($moduleModel->get('label'),$moduleName )}
                                    {if $moduleName eq 'MyProfile'}                                            
										{assign var='moduleURL' value="index.php?module=Users&view=Detail&record={$USER_MODEL->getId()}&app=$APP_NAME&parent=Settings"}
									{else}
										{assign var='moduleURL' value="{$moduleModel->getDefaultUrl()}&app=$APP_NAME}"}
									{/if}	
                                                                                <li {$APP_NAME}><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="{$moduleURL}" >
                                                                                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($moduleName)}]}</i> <span class="hide-menu"> {$translatedModuleLabel}</span></a></li>
                                                                                        {/foreach}
                                                                                </ul>

                                                                        </li>


                                                                        {/if}
                                                                        {/foreach}



                                                                        <li class="nav-small-cap hide">TOOLS & SETTINGS</li>


                                                                        {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
                                                                        {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
                                                                        {if $APP_MENU_MODEL}
                                                                        {break}
                                                                        {/if}
                                                                        {/foreach}

                                                                        <li class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}"> <a class="has-arrow waves-effect waves-dark "><i class="app-icon-list material-icons">more</i><span class="hide-menu"> {vtranslate("LBL_MORE")}</span></a>

                                                                                <ul style="padding-left:6px;padding-top:10px;" >




                                                                                        {assign var=RECYCLEBIN_MODULE_MODEL value=Vtiger_Module_Model::getInstance('RecycleBin')}
                                                                                        {if $RECYCLEBIN_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RECYCLEBIN_MODULE_MODEL->getId())}

                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="{$RECYCLEBIN_MODULE_MODEL->getDefaultUrl()}" ><span class="module-icon"><i class="material-icons">delete_forever</i></span><span class="hide-menu"> {vtranslate('Recycle Bin')}</span></a></li>

                                                                                        {/if}
                                                                                        {assign var=RSS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Rss')}
                                                                                        {if $RSS_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RSS_MODULE_MODEL->getId())}

                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="index.php?module=Rss&view=List" ><span class="module-icon"><i class="material-icons">rss_feed</i></span><span class="hide-menu"> {vtranslate($RSS_MODULE_MODEL->getName(), $RSS_MODULE_MODEL->getName())}</span></a></li>

                                                                                        {/if}
                                                                                        {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Portal')}
                                                                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Portal&view=List"><i class="material-icons module-icon">web</i> <span class="hide-menu"> {vtranslate('Portal')}</span></a></li>

                                                                                        {/if}
                                                                                              {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Bills')}
                                                                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Bills&view=List"><i class="material-icons module-icon">receipt</i> <span class="hide-menu"> {vtranslate('Bills')}</span></a></li>

                                                                                        {/if}
                                                                                                                                                          
                                                                                        {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('WorkingHours')}
                                                                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=WorkingHours&view=List"><i class="material-icons module-icon">access_time</i> <span class="hide-menu"> {vtranslate('WorkingHours')}</span></a></li>

                                                                                        {/if}
                                                                                        
                                                                                        {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Payments')}
                                                                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Payments&view=List"><i class="material-icons module-icon">payment</i> <span class="hide-menu"> {vtranslate('Payments')}</span></a></li>

                                                                                        {/if}
                                                                                                {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('LeaveType')}
                                                                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                                                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=LeaveType&view=List"><i class="material-icons module-icon">keyboard_tab</i> <span class="hide-menu"> {vtranslate('LeaveType')}</span></a></li>

                                                                                        {/if}
                                                                                </ul>
                                                                        </li>



                                                                </div>
                                                        </div>
                                                        <!--fine menu-->

                                                        <div class="logo-container col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                                                <div class="row">
                                                                        <a href="index.php" class="company-logo">
                                                                                <img src="{$COMPANY_LOGO->get('imagepath')}" alt="{$COMPANY_LOGO->get('alt')}"/>
                                                                        </a>
                                                                </div>
                                                        </div>

                                                </div>
                                        </div>
                        <!--<div class="search-links-container col-md-3 col-lg-3 hidden-sm">



                                <div class="search-link hidden-xs">
                                        <span class="ti-search" aria-hidden="true"></span>
                                        <input class="keyword-input" type="text" placeholder="{vtranslate('LBL_TYPE_SEARCH')}" value="{$GLOBAL_SEARCH_VALUE}">
                                        <span id="adv-search" class="adv-search ti-arrow-circle-down pull-right cursorPointer" aria-hidden="true"></span>
                                </div>
                        </div>-->

                        <!--top nav with lock-->
                        <div class="col-lg-5 col-md-5 col-sm-4 col-xs-8 "><div class="row">
                                <ul class="nav navbar-nav newtabs">
                                        <li>
                                                <div class="dropdownFinance">
                                                        <div class="addtionalDashboardTab">
                                                                <span aria-hidden="true">HRM</span>
                                                        </div>

                                                        <div class="dropdown-content-Finance">

                                                                <ul class="dropdownlist">
                                                                        <li>
                                                                                <a class="dropdown-icon-dashboard"  title="Employee" href="index.php?module=EmployeeContract&view=List&block=15&fieldid=53">
                                                                                	<i class="material-icons module-icon">person</i>&nbsp;Employee
                                                                                     
                                                                                </a>
                                                                        </li>
                                                                          {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->isAdminUser()}  
                                                                        <li>
                                                                               <a class="dropdown-icon-dashboard"  title="Leave" href="index.php?module=Leave&view=List">
                                                                                	<i class="material-icons module-icon">exit_to_app</i>&nbsp;Leave
                                                                                      
                                                                                </a>
                                                                        </li>
                                                                        {else}
                                                                                     <li>
                                                                                <a class="dropdown-icon-dashboard"  title="Leave" href="index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USER_MODEL->getId()}">

                                                                                	<i class="material-icons module-icon">exit_to_app</i>&nbsp;Leave
                                                                                      
                                                                                </a>
                                                                        </li>
                                                                        {/if}
                                                                           {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->isAdminUser()}  
                                                                        <li>
                                                                                <a class="dropdown-icon-dashboard" title="Claim" href="index.php?module=Claim&view=List">
                                                                                	<i class="material-icons module-icon">attach_money</i>&nbsp;Claim
                                                                                       
                                                                                </a>
                                                                        </li>
                                                                            {else}
                                                                                  <li>
                                                                                <a class="dropdown-icon-dashboard" title="Claim" href="index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USER_MODEL->getId()}">
                                                                                	<i class="material-icons module-icon">attach_money</i>&nbsp;Claim
                                                                                       
                                                                                </a>
                                                                        </li>
                                                                        {/if}
                                                                        <li>
                                                                                <a class="dropdown-icon-dashboard"  title="Payslip" href="index.php?module=Payslip&amp;view=List&amp;app=ADMIN">
                                                                                	<i class="material-icons module-icon">insert_drive_file</i>&nbsp;Payslip
                                                                                       
                                                                                </a>
                                                                        </li>
                                                                        <li>
                                                                                <a class="dropdown-icon-dashboard"  title="Performance" href="index.php?module=Performance&view=List&amp;block=15&amp;fieldid=56">
                                                                                	<i class="material-icons module-icon">timeline</i>&nbsp;Performance
                                                                                       
                                                                                </a>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                </div>

                                        </li>
                                        <li>
                                                <div class="dropdownSales">
                                                         <div class="addtionalDashboardTab">
                                                                <span aria-hidden="true">Sales</span> <i class="fa fa-lock" style="color: #2f5597;vertical-align: middle;font-size: 15px;"></i>
                                                        </div>
                                                       

                                                        <div class="dropdown-content-Sales">
                                                                <div class="row">
                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img" >
                                                                                                <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img2.jpg" alt="monitor activities and updates" style="width: 85%;">
                                                                                        </div>

                                                                                        <div class="popup-col-4text">
                                                                                                Manage Sales Team and activities.
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img">
                                                                                                <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img3.jpg" alt="sync from google calendar" style="width:85%;">
                                                                                        </div>
                                                                                        <div class="popup-col-4text">
                                                                                                Google contacts, calendar and docs synchronization
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img">
                                                                                                <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img1.jpg" alt="second crm dashboard" style="width: 85%;">
                                                                                        </div>
                                                                                        <div class="popup-col-4text">
                                                                                                Acquire more leads
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12 row" style="padding: 10px;">
                                                                        <a href="#" class="buttonpopup">Read More</a>
                                                                </div>
                                                        </div>
                                                </div>

                                        </li>

                                        <li>
                                                <div class="dropdownTools">
                                                        <div class="addtionalDashboardTab">
                                                                <span aria-hidden="true">Communications</span>
                                                        </div>
                                                        <div class="dropdown-content-Tools">

                                                                <ul class="dropdownlist">

                                                                    <li>
                                                                        <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                <i class="fa fa-bell-o"></i>&nbsp;Notification Templates
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-icon-dashboard" title="Rss" href="index.php?module=Rss&amp;view=List&amp;app=TOOLS">
                                                                                <i class="fa fa-rss"></i>&nbsp;Rss
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-icon-dashboard" title="Recycle Bin" href="index.php?module=RecycleBin&amp;view=List&amp;app=TOOLS">
                                                                                <i class="fa fa-trash-o"></i>&nbsp;Recycle Bin
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-icon-dashboard" title="Our Sites" href="index.php?module=Portal&amp;view=List&amp;app=TOOLS">
                                                                                <i class="fa fa-desktop"></i>&nbsp;Our Sites
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-icon-dashboard" title="PBX Manager" href="index.php?module=PBXManager&amp;view=List&amp;app=TOOLS">
                                                                                <i class="fa fa-phone"></i>&nbsp;PBX Manager
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                        </div>
                                                </div>
                                        </li>
                                        <li>
                                                <div class="dropdownSupport">
                                                        <div class="addtionalDashboardTab">
                                                                <span aria-hidden="true" >Support</span> <i class="fa fa-lock" style="color: #2f5597;    vertical-align: middle;font-size: 15px;"></i>
                                                        </div>

                                                         <div class="dropdown-content-Support">
                                                                <div class="row">
                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img" >
                                                                                                <img src="http://www.secondcrm.com/sites/default/files/quote-invoice-generator-billing-automation.jpg" alt="monitor activities and updates" style="width: 85%;">
                                                                                        </div>

                                                                                        <div class="popup-col-4text">
                                                                                                Sales Order, Invoice and Quotation Generator
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img">
                                                                                                <img src="http://www.secondcrm.com/sites/default/files/send-email-template-easier.jpg" alt="sync from google calendar" style="width:85%;">
                                                                                        </div>
                                                                                        <div class="popup-col-4text">
                                                                                                Email and SMS Marketing Service
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                                <div class="popup-col-4">
                                                                                        <div class="popup-col-4img">
                                                                                                <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/support-img1.jpg" style="width: 85%;">
                                                                                        </div>
                                                                                        <div class="popup-col-4text">
                                                                                                Auto capture requests from multiple support channels
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                </div>
                                                                <div class="col-md-12 row" style="padding: 10px;">
                                                                        <a href="#" class="buttonpopup">Read More</a>
                                                                </div>
                                                        </div>


                                                        
                                                </div>

                                        </li>



                                        <li>
                                                <div>
                                                        <a class="menu-open">
                                                                <span aria-hidden="true" style="font-size: 15px;
color: #000;
display: inline-block;
height: 100%;
width: 100%;
/* color: #fff; */
/* font-size: 15px; */
padding: 10px 20px;
text-decoration: none;">All</span>
                                                        </a>
                                                </div>
                                        </li>

                <!-- 			<li>
                                                <div class="dropdownMore">
                                                        <div class="addtionalDashboardTab">
                                                                <span aria-hidden="true">More</span>
                                                        </div>


dashboard
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Dashboard" href="index.php?module=Home&amp;view=DashBoard">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Dashboard
                                                                                </a>
                                                                            </li>   
                                                                             <li>
                                                                                <a class="dropdown-icon-dashboard" title="Mail" href="index.php?module=MailManager&amp;view=List">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Mail
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Documents" href="index.php?module=Documents&amp;view=List">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Documents
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="CRM Settings" href="index.php?module=Vtiger&amp;parent=Settings&amp;view=Index">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;CRM Settings
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Manage User" href="index.php?module=Users&amp;parent=Settings&amp;view=List">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Manage User
                                                                                </a>
                                                                            </li>  

                                                        <div class="dropdown-content-More row" style="width: 100%;">
                                                                <div class="col-md-2" >
                                                                        <ul class="dropdownlist">
                                                                                <div style="border-bottom: 2px solid #cecece">
                                                                                <span>General</span>
                                                                            </div>  
                                                                                <li>
                                                                                <a class="dropdown-icon-dashboard" title="Contacts" href="index.php?module=Contacts&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Contacts
                                                                                </a>
                                                                            </li>   
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Calendar" href="index.php?module=Calendar&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Calendar
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Organizations" href="index.php?module=Accounts&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Organizations
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Leads" href="index.php?module=Leads&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Leads
                                                                                </a>
                                                                            </li>  
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Calendar" href="index.php?module=SMSNotifier&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;SMS Notifier
                                                                                </a>
                                                                            </li>  

                                                                                <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Template" href="index.php?module=EmailTemplates&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Notification Template
                                                                                </a>
                                                                            </li>  


                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Report" href="index.php?module=Reports&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;Report
                                                                                </a>
                                                                            </li>  

                                                                                <li>
                                                                                <a class="dropdown-icon-dashboard" title="My Profile" href="index.php?module=MyProfile&amp;view=List&amp;app=FOUNDATION">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;My Profile
                                                                                </a>
                                                                            </li>  


                                                                        </ul>
                                                                </div>
                                                                <div class="col-md-2" >
                                                                        <ul class="dropdownlist">
                                                                           <li>
                                                                                        <a class="dropdown-icon-dashboard"  title="Employee" href="index.php?module=Users&parent=Settings&view=List">
                                                                                                <i class="fa fa-user"></i>&nbsp;Employee
                                                                                        </a>
                                                                                </li>

                                                                                <li>
                                                                                        <a class="dropdown-icon-dashboard"  title="Leave" href="index.php?module=Leave&amp;view=List&amp;app=ADMIN">
                                                                                                <i class="fa fa-sign-out"></i>&nbsp;Leave
                                                                                        </a>
                                                                                </li>
                                                                                <li>
                                                                                        <a class="dropdown-icon-dashboard" title="Claim" href="index.php?module=Claim&amp;view=List&amp;app=ADMIN">
                                                                                                <i class="fa fa-usd"></i>&nbsp;Claim
                                                                                        </a>
                                                                                </li>
                                                                                <li>
                                                                                        <a class="dropdown-icon-dashboard"  title="Payslip" href="index.php?module=Payslip&amp;view=List&amp;app=ADMIN">
                                                                                                <i class="fa fa-file-text-o"></i>&nbsp;Payslip
                                                                                        </a>
                                                                                </li>
                                                                                <li>
                                                                                        <a class="dropdown-icon-dashboard"  title="Performance" href="index.php?module=Performance&amp;parent=Settings&amp;view=List&amp;block=15&amp;fieldid=56">
                                                                                                <i class="fa fa-bolt"></i>&nbsp;Performance
                                                                                        </a>
                                                                                </li>

                                                                        </ul>
                                                                </div>
                                                                <div class="col-md-2" >
                                                                        <ul class="dropdownlist">
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;3
                                                                                </a>
                                                                            </li>   
                                                                             <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;3
                                                                                </a>
                                                                            </li>  
                                                                        </ul>
                                                                </div>
                                                                <div class="col-md-2" >
                                                                        <ul class="dropdownlist">
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;4
                                                                                </a>
                                                                            </li>   
                                                                             <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;4
                                                                                </a>
                                                                            </li>  
                                                                        </ul>
                                                                </div>
                                                                <div class="col-md-2" >
                                                                        <ul class="dropdownlist">
                                                                            <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;5
                                                                                </a>
                                                                            </li>   
                                                                             <li>
                                                                                <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                                                                                        <i class="fa fa-bell-o"></i>&nbsp;5
                                                                                </a>
                                                                            </li>  
                                                                        </ul>
                                                                </div>


                                                        </div>
                                                </div>
                                        </li>
                                -->
                                </ul>

                        </div>
                </div>

                <div id="navbar" class="col-sm-2 col-md-3 col-lg-3 collapse navbar-collapse navbar-right global-actions">
                        <ul class="nav navbar-nav">




                                <li style="width: 250px;">
                                        <div class="search-links-container hidden-sm">
                                                <div class="search-link hidden-xs" style="    border: 1px solid #000;color: #000!important;">
                                                        <span class="ti-search" aria-hidden="true" style="color: #000 !important;"></span>
                                                        <input class="keyword-input" id="search-top-bar" type="text" placeholder="{vtranslate('LBL_TYPE_SEARCH')}" value="{$GLOBAL_SEARCH_VALUE}">
                                                        <span id="adv-search" title="Advanced Search" class="adv-search ti-arrow-circle-down pull-right cursorPointer" aria-hidden="true" ></span>
                                                </div>
                                        </div>
                                </li>
                                <li>
                                        <div class="dropdown">
                                                <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                                        <a  aria-hidden="true" href="#" id="menubar_quickCreate" class="qc-button rightside-icon-dashboard" title="{vtranslate('LBL_QUICK_CREATE',$MODULE)}" aria-hidden="true">
                                                                        <i class="fa fa-plus"></i>
                                                        </a>
                                                        </div>
                                                        <ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dropdownMenu1" style="width:650px;">
                                                                <li class="title" style="padding: 5px 0 0 15px;">
                                                                        <h4><strong>{vtranslate('LBL_QUICK_CREATE',$MODULE)}</strong></h4>
                                                                </li>
                                                                <hr/>
                                                                <li id="quickCreateModules" style="padding: 0 5px;">
                                                                        <div class="col-lg-12" style="padding-bottom:15px;">
                                                                                {foreach key=moduleName item=moduleModel from=$QUICK_CREATE_MODULES}
                                                                                {if $moduleModel->isPermitted('CreateView') || $moduleModel->isPermitted('EditView')}
                                                                                {assign var='quickCreateModule' value=$moduleModel->isQuickCreateSupported()}
                                                                                {assign var='singularLabel' value=$moduleModel->getSingularLabelKey()}
                                                                                {assign var=hideDiv value={!$moduleModel->isPermitted('CreateView') && $moduleModel->isPermitted('EditView')}}
                                                                                {assign var=iconsarray value=['potentials'=>'attach_money','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
                                                                                'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
                                                                                'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
                                                                                'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
                                                                                'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
                                                                                'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
                                                                                'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
                                                                                'mycthemeswitcher'=>'folder', 'chat'=>'chat', 'mobilecall'=>'call', 'call'=>'call', 'meeting'=>'people','claim'=>'attach_money' ,'workinghours'=>'access_time']}
                                                                                {if $quickCreateModule == '1'}
                                                                                {if $count % 3 == 0}
                                                                                <div class="row">
                                                                                        {/if}
                                                                                        {* Adding two links,Event and Task if module is Calendar *}
                                                                                        {if $singularLabel == 'SINGLE_Calendar'}
                                                                                        {assign var='singularLabel' value='LBL_TASK'}
                                                                                        <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if}">
                                                                                                <a id="menubar_quickCreate_Events" class="quickCreateModule" data-name="Events"
                                                                                                data-url="index.php?module=Events&view=QuickCreateAjax" href="javascript:void(0)"><i class="material-icons pull-left">event</i><span class="quick-create-module">{vtranslate('LBL_EVENT',$moduleName)}</span></a>
                                                                                        </div>
                                                                                        {if $count % 3 == 2}
                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                        {/if}
                                                                                        <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if}">
                                                                                                <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModule" data-name="{$moduleModel->getName()}"
                                                                                                        data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)"><i class="material-icons pull-left">card_travel</i><span class="quick-create-module">{vtranslate($singularLabel,$moduleName)}</span></a>
                                                                                                </div>
                                                                                                {if !$hideDiv}
                                                                                                {assign var='count' value=$count+1}
                                                                                                {/if}
                                                                                                {else if $singularLabel == 'SINGLE_Documents'}
                                                                                                <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if} dropdown">
                                                                                                        <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModuleSubmenu dropdown-toggle" data-name="{$moduleModel->getName()}" data-toggle="dropdown" 
                                                                                                                data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)">
                                                                                                                <i class="material-icons pull-left">{$iconsarray[{strtolower($moduleName)}]}</i>
                                                                                                                <span class="quick-create-module">
                                                                                                                        {vtranslate($singularLabel,$moduleName)}
                                                                                                                        <i class="fa fa-caret-down quickcreateMoreDropdownAction"></i>
                                                                                                                </span>
                                                                                                        </a>
                                                                                                        <ul class="dropdown-menu quickcreateMoreDropdown" aria-labelledby="menubar_quickCreate_{$moduleModel->getName()}">
                                                                                                                <li class="dropdown-header"><i class="material-icons">file_upload</i> {vtranslate('LBL_FILE_UPLOAD', $moduleName)}</li>
                                                                                                                <li id="VtigerAction">
                                                                                                                        <a href="javascript:Documents_Index_Js.uploadTo('Vtiger')">
                                                                                                                                <img style="  margin-top: -3px;margin-right: 4%;" title="Vtiger" alt="Vtiger" src="layouts/v7/skins//images/Vtiger.png">
                                                                                                                                {vtranslate('LBL_TO_SERVICE', $moduleName, {vtranslate('LBL_VTIGER', $moduleName)})}
                                                                                                                        </a>
                                                                                                                </li>
                                                                                                                <li class="dropdown-header"><i class="ti-link"></i> {vtranslate('LBL_LINK_EXTERNAL_DOCUMENT', $moduleName)}</li>
                                                                                                                <li id="shareDocument"><a href="javascript:Documents_Index_Js.createDocument('E')">&nbsp;<i class="material-icons">link</i>&nbsp;&nbsp; {vtranslate('LBL_FROM_SERVICE', $moduleName, {vtranslate('LBL_FILE_URL', $moduleName)})}</a></li>
                                                                                                                <li role="separator" class="divider"></li>
                                                                                                                <li id="createDocument"><a href="javascript:Documents_Index_Js.createDocument('W')"><i class="ti-file"></i> {vtranslate('LBL_CREATE_NEW', $moduleName, {vtranslate('SINGLE_Documents', $moduleName)})}</a></li>
                                                                                                        </ul>
                                                                                                </div>
                                                                                                {else}
                                                                                                <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if}">
                                                                                                        <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModule" data-name="{$moduleModel->getName()}"
                                                                                                                data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)">
                                                                                                                <i class="material-icons pull-left">{$iconsarray[{strtolower($moduleName)}]}</i>
                                                                                                                <span class="quick-create-module">{vtranslate($singularLabel,$moduleName)}</span>
                                                                                                        </a>
                                                                                                </div>
                                                                                                {/if}
                                                                                                {if $count % 3 == 2}
                                                                                        </div>
                                                                                        <br>
                                                                                        {/if}
                                                                                        {if !$hideDiv}
                                                                                        {assign var='count' value=$count+1}
                                                                                        {/if}
                                                                                        {/if}
                                                                                        {/if}
                                                                                        {/foreach}
                                                                                </div>
                                                                        </li>
                                                                </ul>
                                                        </div>
                                                </li>

                                                <li>
                                                        <div>
                                                                <a class="rightside-icon-dashboard" href="index.php?module=SMSNotifier&view=List&app=FOUNDATION" title="Notifications" aria-hidden="true">
                                                                        <i class="fa fa-bell-o"></i>
                                                                </a>
                                                        </div>
                                                </li>

                                                <li>
                                                        <div>
                                                                <a class="rightside-icon-dashboard" href="index.php?module=MailManager&view=List" title="Email" aria-hidden="true">
                                                                        <i class="fa fa-envelope-o"></i>
                                                                </a>
                                                        </div>
                                                </li>

                                                <li>
                                                        <div>
                                                                <a class="rightside-icon-dashboard" href="index.php?module=Documents&view=List" title="Files" aria-hidden="true">
                                                                        <i class="fa fa-file-o"></i>
                                                                </a>
                                                        </div>
                                                </li>

                                                {assign var=USER_PRIVILEGES_MODEL value=Users_Privileges_Model::getCurrentUserPrivilegesModel()}
                                                {assign var=CALENDAR_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Calendar')}
                                                {if $USER_PRIVILEGES_MODEL->hasModulePermission($CALENDAR_MODULE_MODEL->getId())}
                                                <li>

                                                        <div>
                                                                <a class="rightside-icon-dashboard" href="index.php?module=Calendar&view={$CALENDAR_MODULE_MODEL->getDefaultViewName()}" title="{vtranslate('Calendar','Calendar')}" aria-hidden="true">
                                                                        <i class="fa fa-calendar-o"></i>
                                                                </a>
                                                        </div>
                                                </li>
                                                {/if}

                                                {assign var=REPORTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Reports')}
                                                {if $USER_PRIVILEGES_MODEL->hasModulePermission($REPORTS_MODULE_MODEL->getId())}
                                                <li>
                                                        <div>
                                                                <a class="rightside-icon-dashboard"  href="index.php?module=Reports&view=List" title="{vtranslate('Reports','Reports')}" aria-hidden="true">
                                                                        <i class="fa fa-line-chart"></i>
                                                                </a>
                                                        </div>
                                                </li>
                                                {/if}

                                                <li>
                                                        <div>
                                                                <a class="rightside-icon-dashboard"  href="index.php?module=Vtiger&amp;parent=Settings&amp;view=Index" title="Setting" aria-hidden="true">
                                                                        <i class="fa fa-gear"></i>
                                                                </a>
                                                        </div>
                                                </li>



                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($CALENDAR_MODULE_MODEL->getId())}
                                                <!--<li><div><a href="#" class="taskManagement" title="{vtranslate('Tasks','Vtiger')}" aria-hidden="true">
                                                        <i class="material-icons">card_travel</i></a></div></li>-->
                                                        {/if}
                                                        <li class="dropdown">
                                                                <div>

                                                                        {assign var=IMAGE_DETAILS value=$USER_MODEL->getImageDetails()}
                                                                        {if $IMAGE_DETAILS neq '' && $IMAGE_DETAILS[0] neq '' && $IMAGE_DETAILS[0].path eq ''}
                                                                        <a href="#" class="userName dropdown-toggle " data-toggle="dropdown" role="button" title="{$USER_MODEL->get('first_name')} {$USER_MODEL->get('last_name')}
                                                                                ({$USER_MODEL->get('user_name')})"><i class="material-icons">perm_identity</i>

                                                                                <span class="link-text-xs-only hidden-lg hidden-md hidden-sm">{$USER_MODEL->getName()}</span>
                                                                        </a>
                                                                        {else}
                                                                        {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
                                                                        {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                                                                        <a href="#" class="userName dropdown-toggle" data-toggle="dropdown" role="button" title="{$USER_MODEL->get('first_name')} {$USER_MODEL->get('last_name')}
                                                                                ({$USER_MODEL->get('user_name')})"><img style="width: 30px;border-radius: 50%;
                                                                                padding: 7px 0px;" src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                                                        </a>
                                                                        {/if}
                                                                        {/foreach}
                                                                        {/if}



                                                                        <div class="dropdown-menu logout-content animated flipInY" role="menu">
                                                                                <div class="row">

                                                                                        <div class="col-lg-12 col-sm-12" style="padding:10px;">
                                                                                                <div class="profile-container col-lg-5 col-sm-5">
                                                                                                        {assign var=IMAGE_DETAILS value=$USER_MODEL->getImageDetails()}
                                                                                                        {if $IMAGE_DETAILS neq '' && $IMAGE_DETAILS[0] neq '' && $IMAGE_DETAILS[0].path eq ''}
                                                                                                        <i class='material-icons'>perm_identity</i>
                                                                                                        {else}
                                                                                                        {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
                                                                                                        {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                                                                                                        <img src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                                                                                        {/if}
                                                                                                        {/foreach}
                                                                                                        {/if}
                                                                                                </div>
                                                                                                <div class="col-lg-7 col-sm-7">
                                                                                                        <h5>{$USER_MODEL->get('first_name')} {$USER_MODEL->get('last_name')}</h5>
                                                                                                        <h6 class="textOverflowEllipsis" title='{$USER_MODEL->get('user_name')}'>{$USER_MODEL->get('user_name')} | {$USER_MODEL->getUserRoleName()}</h6>
                                                                                                        {assign var=useremail value=$USER_MODEL->get('email1')}
                                                                                                        <h6 class="textOverflowEllipsis" title='{$USER_MODEL->get('email')}'>{$useremail}</h6>
                                                                                                </div>
                                                                                                <hr style="margin: 10px 0 !important">
                                                                                                <div class="col-lg-12 col-sm-12">
                                                                                                        <ul class="dropdown-user">
                                                                                                                <li role="separator" class="divider"></li>
                                                                                                                <li>

                                                                                                                        <a id="menubar_item_right_LBL_MY_PREFERENCES" href="{$USER_MODEL->getPreferenceDetailViewUrl()}">
                                                                                                                                <i class="material-icons">settings</i> {vtranslate('LBL_MY_PREFERENCES')}</a>
                                                                                                                        </li>
                                                                                                                        <li>

                                                                                                                                <a id="menubar_item_right_LBL_SIGN_OUT" href="index.php?module=Users&action=Logout">
                                                                                                                                        <i class="material-icons">power_settings_new</i> {vtranslate('LBL_SIGN_OUT')}</a>
                                                                                                                                </li>
                                                                                                                        </ul>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>

                                                                                        </div>
                                                                                </div>
                                                                        </li>
                                                                </ul>


                                                        </div>
                                                        <div class="col-xs-4 visible-xs padding0px">
                                                                <div class="dropdown btn-group pull-right">

                                                                        <button class="btn dropdown-toggle" style="background-color: #398bf7;padding: 12px;color: #fff;margin-top: -1px;margin-bottom:0px;border: none;" data-toggle="dropdown" aria-expanded="true">
                                                                                <a href="#" id="menubar_quickCreate_mobile" class="qc-button" title="{vtranslate('LBL_QUICK_CREATE',$MODULE)}" aria-hidden="true">
                                                                                        <i class="material-icons">add</i>&nbsp;<span class="caret"></span></a>
                                                                                </button>
                                                                                <ul class="dropdown-menu">
                                                                                        <li class="title" style="padding: 5px 0 0 15px;">
                                                                                                <h4><strong>{vtranslate('LBL_QUICK_CREATE',$MODULE)}</strong></h4>
                                                                                        </li>
                                                                                        <hr/>
                                                                                        <li id="quickCreateModules_mobile" style="padding: 0 8px;">
                                                                                                <div class="col-xs-12 padding0px" style="padding-bottom:15px;">
                                                                                                        {foreach key=moduleName item=moduleModel from=$QUICK_CREATE_MODULES}
                                                                                                        {if $moduleModel->isPermitted('CreateView') || $moduleModel->isPermitted('EditView')}
                                                                                                        {assign var='quickCreateModule' value=$moduleModel->isQuickCreateSupported()}
                                                                                                        {assign var='singularLabel' value=$moduleModel->getSingularLabelKey()}
                                                                                                        {assign var=hideDiv value={!$moduleModel->isPermitted('CreateView') && $moduleModel->isPermitted('EditView')}}
                                                                                                        {if $quickCreateModule == '1'}
                                                                                                        {if $count % 3 == 0}
                                                                                                        <div class="row">
                                                                                                                {/if}
                                                                                                                {* Adding two links,Event and Task if module is Calendar *}
                                                                                                                {if $singularLabel == 'SINGLE_Calendar'}
                                                                                                                {assign var='singularLabel' value='LBL_TASK'}
                                                                                                                <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-xs-12{/if}">
                                                                                                                        <a id="menubar_quickCreate_Events" class="quickCreateModule" data-name="Events"
                                                                                                                        data-url="index.php?module=Events&view=QuickCreateAjax" href="javascript:void(0)"><i class="material-icons pull-left">event</i><span class="quick-create-module">{vtranslate('LBL_EVENT',$moduleName)}</span></a>
                                                                                                                </div>
                                                                                                                {if $count % 3 == 2}
                                                                                                        </div>
                                                                                                        <div class="row">
                                                                                                                {/if}
                                                                                                                <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-xs-12{/if}">
                                                                                                                        <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModule" data-name="{$moduleModel->getName()}"
                                                                                                                                data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)"><i class="material-icons pull-left">card_travel</i><span class="quick-create-module">{vtranslate($singularLabel,$moduleName)}</span></a>
                                                                                                                        </div>
                                                                                                                        {if !$hideDiv}
                                                                                                                        {assign var='count' value=$count+1}
                                                                                                                        {/if}
                                                                                                                        {else if $singularLabel == 'SINGLE_Documents'}
                                                                                                                        <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-xs-12{/if} dropdown">
                                                                                                                                <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModuleSubmenu dropdown-toggle" data-name="{$moduleModel->getName()}" data-toggle="dropdown" 
                                                                                                                                        data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)">
                                                                                                                                        <i class="material-icons pull-left">{$iconsarray[{strtolower($moduleName)}]}</i>
                                                                                                                                        <span class="quick-create-module">
                                                                                                                                                {vtranslate($singularLabel,$moduleName)}
                                                                                                                                                <i class="fa fa-caret-down quickcreateMoreDropdownAction"></i>
                                                                                                                                        </span>
                                                                                                                                </a>
                                                                                                                                <ul class="dropdown-menu quickcreateMoreDropdown" aria-labelledby="menubar_quickCreate_{$moduleModel->getName()}">
                                                                                                                                        <li class="dropdown-header"><i class="ti-upload"></i> {vtranslate('LBL_FILE_UPLOAD', $moduleName)}</li>
                                                                                                                                        <li id="VtigerAction">
                                                                                                                                                <a href="javascript:Documents_Index_Js.uploadTo('Vtiger')">
                                                                                                                                                        <img style="  margin-top: -3px;margin-right: 4%;" title="Vtiger" alt="Vtiger" src="layouts/v7/skins//images/Vtiger.png">
                                                                                                                                                        {vtranslate('LBL_TO_SERVICE', $moduleName, {vtranslate('LBL_VTIGER', $moduleName)})}
                                                                                                                                                </a>
                                                                                                                                        </li>
                                                                                                                                        <li class="dropdown-header"><i class="ti-link"></i> {vtranslate('LBL_LINK_EXTERNAL_DOCUMENT', $moduleName)}</li>
                                                                                                                                        <li id="shareDocument"><a href="javascript:Documents_Index_Js.createDocument('E')">&nbsp;<i class="ti-link"></i>&nbsp;&nbsp; {vtranslate('LBL_FROM_SERVICE', $moduleName, {vtranslate('LBL_FILE_URL', $moduleName)})}</a></li>
                                                                                                                                        <li role="separator" class="divider"></li>
                                                                                                                                        <li id="createDocument"><a href="javascript:Documents_Index_Js.createDocument('W')"><i class="ti-file"></i> {vtranslate('LBL_CREATE_NEW', $moduleName, {vtranslate('SINGLE_Documents', $moduleName)})}</a></li>
                                                                                                                                </ul>
                                                                                                                        </div>
                                                                                                                        {else}
                                                                                                                        <div class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-xs-12{/if}">
                                                                                                                                <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModule" data-name="{$moduleModel->getName()}"
                                                                                                                                        data-url="{$moduleModel->getQuickCreateUrl()}" href="javascript:void(0)">
                                                                                                                                        <i class="material-icons pull-left">{$iconsarray[{strtolower($moduleName)}]}</i>
                                                                                                                                        <span class="quick-create-module">{vtranslate($singularLabel,$moduleName)}</span>
                                                                                                                                </a>
                                                                                                                        </div>
                                                                                                                        {/if}
                                                                                                                        {if $count % 3 == 2}
                                                                                                                </div>
                                                                                                                {/if}
                                                                                                                {if !$hideDiv}
                                                                                                                {assign var='count' value=$count+1}
                                                                                                                {/if}
                                                                                                                {/if}
                                                                                                                {/if}
                                                                                                                {/foreach}
                                                                                                        </div>
                                                                                                </li>
                                                                                        </ul>

                                                                                </div>

                                                                                <div class="dropdown btn-group pull-right">
                                                                                        <button style="background-color: #398bf7;padding: 12px;color: #fff;margin-top: -1px;margin-bottom:0px;border: none;border-right: 1px solid #fff; " class="btn dropdown-toggle" type="button" data-toggle="dropdown"><i class="material-icons">settings</i>
                                                                                                &nbsp;<span class="caret"></span></button>
                                                                                                <ul class="dropdown-menu">



                                                                                                        <div class="clearfix"></div>


                                                                                                        {assign var=USER_PRIVILEGES_MODEL value=Users_Privileges_Model::getCurrentUserPrivilegesModel()}
                                                                                                        {assign var=CALENDAR_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Calendar')}
                                                                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($CALENDAR_MODULE_MODEL->getId())}
                                                                                                        <li><a href="index.php?module=Calendar&view={$CALENDAR_MODULE_MODEL->getDefaultViewName()}" title="{vtranslate('Calendar','Calendar')}" aria-hidden="true"><i class="material-icons">event</i>&nbsp;{vtranslate('Calendar','Calendar')}</a></li>
                                                                                                        {/if}
                                                                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($CALENDAR_MODULE_MODEL->getId())}
                                                                                                        <li><a class="taskManagement" href="#" title="{vtranslate('Task','Task')}" aria-hidden="true"><i class="material-icons">card_travel</i>&nbsp;{vtranslate('Task','Task')}</a></li>
                                                                                                        {/if}
                                                                                                        {assign var=REPORTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Reports')}
                                                                                                        {if $USER_PRIVILEGES_MODEL->hasModulePermission($REPORTS_MODULE_MODEL->getId())}
                                                                                                        <li><a href="index.php?module=Reports&view=List" title="{vtranslate('Reports','Reports')}" aria-hidden="true"><i class="material-icons">pie_chart</i>&nbsp;{vtranslate('Reports','Reports')}</a></li>
                                                                                                        {/if}

                                                                                                        <li class="divider"></li>
                                                                                                        <li class="dropdown-header"> 
                                                                                                                {$USER_MODEL->get('first_name')} {$USER_MODEL->get('last_name')}
                                                                                                                <br/>
                                                                                                                {$USER_MODEL->get('user_name')} | {$USER_MODEL->getUserRoleName()}
                                                                                                        </li>
                                                                                                        <li class="divider"></li>
                                                                                                        <li>
                                                                                                                <a id="menubar_item_right_LBL_MY_PREFERENCES" href="{$USER_MODEL->getPreferenceDetailViewUrl()}"><i class="material-icons">settings</i>&nbsp;{vtranslate('LBL_MY_PREFERENCES')}</a>
                                                                                                        </li>
                                                                                                        <li>
                                                                                                                <a id="menubar_item_right_LBL_SIGN_OUT" href="index.php?module=Users&action=Logout"><i class="material-icons">power_settings_new</i>&nbsp;{vtranslate('LBL_SIGN_OUT')}</a>
                                                                                                        </li>

                                                                                                </ul>
                                                                                        </div>
                                                                                </div>


                                                                        </div>
                                                                </div>

                                                                {/strip}

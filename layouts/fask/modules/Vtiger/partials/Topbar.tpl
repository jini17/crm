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
    {assign var="APP_IMAGE_MAP" value=[ 'MARKETING' => 'ti-thumb-up',
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
    {assign var="announcement" value=$ANNOUNCEMENT->get('announcement')}   
 <div class="headertext" id="headertextflow"> {if !empty($announcement)}{$announcement}{else}{vtranslate('LBL_NO_ANNOUNCEMENTS',$MODULE)}{/if}</div>

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
                            <li class="{if $MODULE eq "Home"}active{/if}"> 
                                <a class=" waves-effect waves-dark" href="{$HOME_MODULE_MODEL->getDefaultUrl()}" >
                                    <i class="material-icons">dashboard</i>
                                    <span class="hide-menu" style="text-transform: uppercase">{vtranslate('LBL_DASHBOARD',$MODULE)} </span>
                                </a>
                            </li>
                            {/if}

                            {assign var=MAILMANAGER_MODULE_MODEL value=Vtiger_Module_Model::getInstance('MailManager')}
                            {if $USER_PRIVILEGES_MODEL->hasModulePermission($MAILMANAGER_MODULE_MODEL->getId())}

                            {*    <li class="{if $MODULE eq "MailManager"}active{/if}"> <a class=" waves-effect waves-dark" href="index.php?module=MailManager&view=List" ><i class="app-icon-list material-icons">email</i><span class="hide-menu"> {vtranslate('MailManager')}</span></a>
                            </li>*}
                            {/if}
                            {assign var=DOCUMENTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Documents')}
                            {if $USER_PRIVILEGES_MODEL->hasModulePermission($DOCUMENTS_MODULE_MODEL->getId())}

                            <li class="{if $MODULE eq "Documents"}active{/if}"> 
                                <a class=" waves-effect waves-dark" href="index.php?module=Documents&view=List" >
                                    <i class="app-icon-list material-icons">insert_drive_file</i><span class="hide-menu"> 
                                    {vtranslate('Documents')}</span>
                                </a>
                            </li>
                            {/if}
                            <hr/>
                            {if $USER_MODEL->isAdminUser()}


                            <li>
                                <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
                                href="index.php?module=Vtiger&parent=Settings&view=Index" >
                                <span class="module-icon">
                                    <i class="material-icons">settings</i></span>
                                    <span class="hide-menu">  
                                        {vtranslate('LBL_CRM_SETTINGS','Vtiger')}
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
                                href="index.php?module=Users&parent=Settings&view=List" >
                                <span class="module-icon"><i class="material-icons">contacts</i></span>
                                <span class="hide-menu">   {vtranslate('LBL_MANAGE_USERS','Vtiger')}</span>
                            </a>
                        </li>
                        <li tools="">
                            <a class="waves-effect waves-dark " href=" index.php?module=RecycleBin&amp;view=List&amp;app=TOOLS ">
                                <i class="material-icons module-icon">delete_forever</i> <span class="hide-menu"> Recycle Bin</span>
                            </a>
                        </li>

                        <li foundation="">
                            <a class="waves-effect waves-dark " href=" index.php?module=SMSNotifier&amp;view=List&amp;app=FOUNDATION ">
                                <i class="material-icons module-icon">sms</i> <span class="hide-menu"> {vtranslate('LBL_SMS_MESSAGES', 'Vtiger')}</span>
                            </a>
                        </li>
                        {else}


                        <li class="{if $MODULE eq "Users"}active{/if}"> 
                            <a class=" waves-effect waves-dark" href="index.php?module=Users&view=Settings" >
                                <i class="material-icons">settings</i>
                                <span class="hide-menu" style="text-transform: uppercase"> {vtranslate('LBL_SETTINGS', 'Settings:Vtiger')}</span>
                            </a>
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
                        'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call','performance'=>'timeline', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app','claim'=>'attach_money','myprofile'=>'face'  ]}

                        {if $APP_NAME neq 'SALES'}


                        <li {$APP_NAME} class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}"> 
                            <a class="has-arrow waves-effect waves-dark " >
                                <i class="app-icon-list material-icons" >{$iconsarray[{strtolower($APP_NAME)}]}</i><span class="hide-menu">{vtranslate("LBL_$APP_NAME")}</span></a>

                                <ul style="padding-left:6px;padding-top:15px;">
                                    {foreach item=moduleModel key=moduleName from=$APP_GROUPED_MENU[$APP_NAME]}
                                    {assign var='translatedModuleLabel' value=vtranslate($moduleModel->get('label'),$moduleName )}
                                    {if $moduleName eq 'MyProfile'}                                            
                                    {assign var='moduleURL' value="index.php?module=Users&view=Detail&record={$USER_MODEL->getId()}&app=$APP_NAME&parent=Settings"}
                                    {else}
                                    {assign var='moduleURL' value="{$moduleModel->getDefaultUrl()}&app=$APP_NAME"}
                                    {/if}   
                                         {if $moduleName eq 'Calendar'}
                                    <li {$APP_NAME} moudel='{$moduleName}'>

                                        <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
                                        href="index.php?module=Calendar&view=List" >
                                        <i class="ti ti-notepad" ></i> 
                                        <span class="hide-menu"> {vtranslate("LBL_MEETING",'Vtiger')}</span>
                                        </a>

                                    </li>
                                    <li {$APP_NAME} moudel='{$moduleName}'>

                                        <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
                                        href="{if $translatedModuleLabel eq 'Employee'} index.php?module=Users&parent=Settings&view=List   {/if}
                                        {if $translatedModuleLabel neq 'Employee'} {$moduleURL} {/if}" >
                                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($moduleName)}]}</i> 
                                        <span class="hide-menu"> {$translatedModuleLabel}</span>
                                        </a>

                                    </li>
                                      {else}   
                                          <li {$APP_NAME} moudel='{$moduleName}'>

                                        <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
                                        href="{if $translatedModuleLabel eq 'Employee'} index.php?module=Users&parent=Settings&view=List   {/if}
                                        {if $translatedModuleLabel neq 'Employee'} {$moduleURL} {/if}" >
                                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($moduleName)}]}</i> 
                                        <span class="hide-menu"> {$translatedModuleLabel}</span>
                                        </a>

                                    </li>
                                            {/if}
                                    {/foreach}
                                </ul>

                            </li>
                            {/if}
                            {/if}
                            {/foreach}



                            <li class="nav-small-cap hide">TOOLS & SETTINGS</li>


                            {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
                            {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
                            {if $APP_MENU_MODEL}
                            {break}
                            {/if}
                            {/foreach}

                            <li class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}"> 
                                <a class="has-arrow waves-effect waves-dark ">
                                    <i class="app-icon-list material-icons">more</i>
                                    <span class="hide-menu"> {vtranslate("LBL_MORE")}</span></a>

                                <ul style="padding-left:6px;padding-top:10px;" >




                                    {assign var=RSS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Rss')}
                                    {if $RSS_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RSS_MODULE_MODEL->getId())}

                                    <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="index.php?module=Rss&view=List" ><span class="module-icon"><i class="material-icons">rss_feed</i></span><span class="hide-menu"> {vtranslate($RSS_MODULE_MODEL->getName(), $RSS_MODULE_MODEL->getName())}</span></a></li>

                                    {/if}
                                    {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Portal')}
                                    {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                    <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Portal&view=List"><i class="material-icons module-icon">web</i> <span class="hide-menu"> {vtranslate('Portal')}</span></a></li>

                                    {/if}
                                    {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Bills')}
                                {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->column_fields['roleid'] eq 'H13' || $USER_MODEL->column_fields['roleid'] eq 'H15' ||  $USER_MODEL->isAdminUser()}  
                                    {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}



                                    <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Bills&view=List"><i class="material-icons module-icon">receipt</i> <span class="hide-menu"> {vtranslate('Office Bills','Vtiger')}</span></a></li>

                                    {/if}

                                    {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('WorkingHours')}
                                    {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
                                                <!-- <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=WorkingHours&view=List"><i class="material-icons module-icon">access_time</i> <span class="hide-menu"> {vtranslate('WorkingHours')}</span></a></li>
                                                -->        
                                                {/if}

                                        {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Payments')}
                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
                                        <li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Payments&view=List"><i class="material-icons module-icon">payment</i> <span class="hide-menu"> {vtranslate('Payments')}</span></a></li>

                                        {/if}
      {*                                  {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('LeaveType')}
                                        {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
                                         <!--<li><a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=LeaveType&view=List"><i class="material-icons module-icon">keyboard_tab</i> <span class="hide-menu"> {vtranslate('LeaveType')}</span></a></li>
                                         -->
                                         {/if}*}
                                     </ul>
                                 </li>

                                        {/if}

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
                                                                                        <a class="dropdown-icon-dashboard"  title="Employee" href="index.php?module=Users&view=List&block=15&fieldid=53&parent=Settings">
                                                                                            <i class="material-icons module-icon">person</i>&nbsp;Employee

                                                                                        </a>
                                                                                    </li>
                                                                                    {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->isAdminUser()}  
                                                                                        <li>
                                                                                           <a class="dropdown-icon-dashboard"   title="Leave" href="index.php?module=Leave&view=List">
                                                                                                <i class="material-icons module-icon">exit_to_app</i>&nbsp;Leave
                                                                                            </a>
                                                                                         </li>                                                                         
                                                                                        {else}
                                                                                        <li>
                                                                                            <a class="dropdown-icon-dashboard"  
                                                                                               title="Leave" 
                                                                                               href="index.php?module=Users&view=PreferenceDetail&parent=Settings&record={$USER_MODEL->getId()}">
                                                                                                <i class="material-icons module-icon">exit_to_app</i>&nbsp;Leave
                                                                                            </a>
                                                                                        </li>
                                                                                        {/if}
                                                                                        <li admin="" moudel="Timesheet">
                                                                                            <a  class="dropdown-icon-dashboard"   href="index.php?module=Timesheet&amp;view=List&amp;app=ADMIN ">
                                                                                                <i class="material-icons module-icon">timer</i>
                                                                                                <span class="hide-menu"> {vtranslate('Timesheet','Home')}</span>
                                                                                            </a>
                                                                                        </li>
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
                                                                                                        <a class="dropdown-icon-dashboard"  title="Performance" href="index.php?module=Performance&view=List&amp;block=15&amp;fieldid=56">
                                                                                                            <i class="material-icons module-icon">timeline</i>&nbsp;Performance
                                                                                                </li>
                                                                                                <li admin="" moudel="Training">

                                                                                                    <a class="dropdown-icon-dashboard" href=" index.php?module=Training&amp;view=List&amp;app=ADMIN ">
                                                                                                        <i class="material-icons module-icon">book</i> Training
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li admin="" moudel="Attendance">
                                                                                                    <a  class="dropdown-icon-dashboard"   href=" index.php?module=Attendance&amp;view=List&amp;app=ADMIN ">
                                                                                                        <i class="material-icons module-icon">assignment</i> Attendance
                                                                                                    </a>
                                                                                                </li>

                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>

                                                                                </li>
                                                                                <li>
                                                                                    <div class="dropdownSales">
                                                                                     <div class="addtionalDashboardTab">
                                                                                        <span aria-hidden="true">Sales</span> <i class="fa fa-lock" style="color: #2f5597;vertical-align: middle;font-size: 13px;"></i>
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
                                                                                            <a href="http://dev7.secondcrm.com/agiliux/addons.php" class="buttonpopup">Read More</a>
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
                                                                                                    <i class="fa fa-bell-o"></i>&nbsp;Templates
                                                                                                </a>
                                                                                            </li>
                                                             <!--   <li>
                                                                    <a class="dropdown-icon-dashboard" title="Rss" href="index.php?module=Rss&amp;view=List&amp;app=TOOLS">
                                                                            <i class="fa fa-rss"></i>&nbsp;Rss
                                                                    </a>
                                                                </li>-->
                                                                {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->isAdminUser()}  
                                                                {* Khaled - Removed as Per Requirement<li>
                                                                    <a class="dropdown-icon-dashboard" title="Recycle Bin" href="index.php?module=RecycleBin&amp;view=List&amp;app=TOOLS">
                                                                        <i class="fa fa-trash-o"></i>&nbsp;Recycle Bin
                                                                    </a>
                                                                </li>*}
                                                                {/if}
                                                                <li>


                                                                 <a class="dropdown-icon-dashboard"  title="{vtranslate('LBL_MAIL_MANAGER')}" href="index.php?module=MailManager&view=List">
                                                                    <i class="material-icons module-icon">email</i>&nbsp;{vtranslate('LBL_MAIL_MANAGER')}

                                                                </a>

                                                            </li>
                                                       {*     Khaled - Removed as Per Requirement<li admin="">
                                                                <a class="waves-effect waves-dark dropdown-icon-dashboard " href=" index.php?module=WorkingHours&amp;view=List&amp;app=ADMIN ">
                                                                    <i class="material-icons module-icon">access_time</i> <span class="hide-menu"> Working Hours</span>
                                                                </a>
                                                            </li>

                                                            <li admin="">
                                                                <a class="waves-effect waves-dark dropdown-icon-dashboard" href=" index.php?module=Documents&amp;view=List&amp;app=ADMIN ">
                                                                    <i class="material-icons module-icon">file_download</i> <span class="hide-menu"> Documents</span>
                                                                </a>
                                                            </li>
                                                            <li admin="">
                                                                <a class="waves-effect waves-dark dropdown-icon-dashboard" href=" index.php?module=MessageBoard&amp;view=List&amp;app=ADMIN ">
                                                                    <i class="material-icons module-icon">assignment</i> <span class="hide-menu"> Message Board</span>
                                                                </a>
                                                            </li>*}
                                                        </ul>
                                                    </div>
                                                </div>

                                            </li>
                                            <li>
                                                <div class="dropdownSupport">
                                                    <div class="addtionalDashboardTab">
                                                        <span aria-hidden="true" >Support</span> <i class="fa fa-lock" style="color: #2f5597;    vertical-align: middle;font-size: 13px;"></i>

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
                                                            <a href="http://dev7.secondcrm.com/agiliux/addons.php" class="buttonpopup">Read More</a>
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
                                        <!--START-textheader-->
                                        <li>
                                            <div>
                                                <a onclick="onofftextheader()" aria-hidden="true" class="qc-button rightside-icon-dashboard" title="Announcement" aria-hidden="true">
                                                    <i  class="fa fa-bullhorn"></i>
                                                </a>
                                            </div>
                                        </li>
                                        <!--END-textheader-->
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
                                                            'sales'=>'attach_money','messageboard'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
                                                            'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
                                                            'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
                                                            'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
                                                            'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
                                                            'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
                                                            'mycthemeswitcher'=>'folder', 'timesheet'=>'timer','training'=>'book','attendance'=>'assignment','chat'=>'chat', 'mobilecall'=>'call', 'call'=>'call', 'meeting'=>'people','claim'=>'attach_money' ,'workinghours'=>'access_time']}
                                                            {if $quickCreateModule == '1'}
                                                            {if $count % 3 == 0}
                                                            <div class="row">
                                                                {/if}
                                                                {* Adding two links,Event and Task if module is Calendar *}
                                                                {if $singularLabel == 'SINGLE_Calendar'}
                                                                {assign var='singularLabel' value='LBL_TASK'}
                                                                <div {$moduleName} class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if}">
                                                                    <a id="menubar_quickCreate_Events" class="quickCreateModule" data-name="Events"
                                                                        data-url="index.php?module=Events&view=QuickCreateAjax" href="javascript:void(0)">
                                                                        <i class="material-icons pull-left">event</i>
                                                                        <span class="quick-create-module">{vtranslate('LBL_EVENT',$moduleName)}</span>
                                                                    </a>
                                                                </div>
                                                                {if $count % 3 == 2}
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                {/if}
                                                                <div {$moduleName} class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if}">
                                                                    <a id="menubar_quickCreate_{$moduleModel->getName()}" class="quickCreateModule" 
                                                                       data-name="{$moduleModel->getName()}"
                                                                        data-url="{$moduleModel->getQuickCreateUrl()}" 
                                                                        href="javascript:void(0)"><i class="material-icons pull-left">card_travel</i><span class="quick-create-module">{vtranslate($singularLabel,$moduleName)}</span></a>
                                                                    </div>
                                                                    {if !$hideDiv}
                                                                    {assign var='count' value=$count+1}
                                                                    {/if}
                                                                    {else if $singularLabel == 'SINGLE_Documents'}
                                                                    <div {$moduleName} class="{if $hideDiv}create_restricted_{$moduleModel->getName()} hide{else}col-lg-4{/if} dropdown">
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
                                                                <div class="clearfix"></div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="col-lg-4">
                                                                        <a id="menubar_quickCreate_Users" class="quickCreateModule" data-name="Users"
                                                                            data-url="" onclick='window.location.href="index.php?module=Users&parent=Settings&view=Edit"'>
                                                                            <i class="material-icons pull-left">person</i>
                                                                            <span class="quick-create-module">{vtranslate('Users','Users')}</span>
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <a id="menubar_quickCreate_Users" class="quickCreateModule" data-name="Users"
                                                                            data-url="" onclick='window.location.href = "index.php?module=Leave&view=Edit&app=ADMIN"'>
                                                                            <i class="material-icons pull-left">exit_to_app</i>
                                                                            <span class="quick-create-module">{vtranslate('Leave','Leave')}</span>
                                                                        </a>
                                                                    </div>
                                                                        <div class="col-lg-4">
                                                                        <a id="menubar_quickCreate_Users" class="quickCreateModule" data-name="Users"
                                                                            data-url="" onclick='window.location.href = "index.php?module=Bills&view=Edit&app=ADMIN"'>
                                                                            <i class="material-icons pull-left">receipt</i>
                                                                            <span class="quick-create-module">{vtranslate('Bills','Bills')}</span>
                                                                        </a>
                                                                    </div>
                                                                        </div>
                                                                </div>
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

                                            {* <li>
                                                <div>
                                                    <a class="rightside-icon-dashboard"  href="index.php?module=Vtiger&amp;parent=Settings&amp;view=Index" title="Setting" aria-hidden="true">
                                                        <i class="fa fa-gear"></i>
                                                    </a>
                                                </div>
                                            </li>*}




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
                                                        <!--START-textheaderscript-->
    <script>
        function onofftextheader() {
            var x = document.getElementById("headertextflow");
            if (x.style.display === "none") 
            {
                x.style.display = "block";

            } else {
                x.style.display = "none";

            }
        }
    </script>
                                                        <!--END-textheaderscript-->

{/strip}



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
   .searchoption{
   position:relative
   }
   .searchoption .fa.fa-angle-down{
   position: absolute !important;
   left: 85%;
   top: 10px;
   color: #fff;
   z-index: 1;
   }
   .searchoption a{
      padding: 0 !important;
      height: 33px !important;
      margin-top: 4px !important;
      background-color: #fff;
      color: #000 ;
      border-radius: 3px !important;
      border: 0 !important;
      box-shadow:none !important;
      text-shadow: none !important;
   }
   .searchoption .select2-container .select2-choice .select2-arrow {
      color: #fff !important;
   }
   .searchoption .select2-highlighted{
      background-color: #2f5597 !important;
   }
   .searchoption  .select2-container .select2-choice .select2-arrow b{ display: none; }
   .searchoption   .select2-container .select2-choice .select2-arrow {
      width: 40px;
      color: #fff;
      font-size: 1.3em;
      padding: 4px 12px;
   }
   .searchoption .select2-container .select2-choice {
      height: 41px; /* Jobsy form controls have 37px total height */
      border: 2px solid #bdc3c7;
      border-radius: 6px;
      outline: none;
      color: #34495e;
   }

   .notifications{
   position:relative;
   }
   .notification-list{
      position: absolute;
      z-index: 10000;
      width: 280px;
      height: 200px;
      background-color: #fff !important;
      color: #000 !important;
      left: -229px;
   }

   .notifications-heading{
      padding:5px;
      font-size:10px !important;
      font-weight: bold;
      background-color: #2f5597 !important;
      color:#fff !important;
      padding:10px;
      margin:0;
      border-radius: 5px;
   }
   .notifications-heading i{
      margin-right:10px !important;
      color:#fff !important;
   }
   .notification-list::before {
      position: absolute;
      top: -7px;
      right: 26px;
      display: inline-block;
      border-right: 7px solid transparent;
      border-bottom: 7px solid #ccc;
      border-left: 7px solid transparent;
      border-bottom-color: rgba(47, 85, 151,1);
      content: '';
   }
   .notification-container .img-holder{
      width:40px;
      height:40px;
      float:left;
   }
   .notification-container{
      padding:10px;
      border:1px solid  #f2f2f2;
   }
   .notification-container .notification-title{
      width:200px;
      float:right;
   }
   .notification-container .notification-time{
   }   
   .notification-container.unread{
       background-color: #f2f2f2;
   
   }
   
   .notification-list h6
    {
         background-color: #2f5597 ;
         margin: 0;
         padding: 10px;
         color: #ffffff !important;
    }
    .notification-list h6 i{
     color: #ffffff !important;
     }
     .all-notification{
         color: #2f5597
     }
</style>
<nav class="navbar navbar-default navbar-fixed-top app-fixed-navbar">
{assign var="announcement" value=$ANNOUNCEMENT->get('announcement')}   
<div class="headertext {if $ANNOUNCEMENT->get('isview') eq 0} hide {/if} " id="headertextflow"> {if !empty($announcement)}{$announcement}{else}{vtranslate('LBL_NO_ANNOUNCEMENTS',$MODULE)}{/if}</div>
<div class="container-fluid global-nav">
<div class="row app-navigator-container">
<div class='col-md-6 col-sm-12 col-xs-12'>
   <div id="appnavigator" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 cursorPointer app-switcher-container hidden-lg hidden-md " data-app-class="{if $MODULE eq 'Home' || !$MODULE}ti-dashboard{else}{$APP_IMAGE_MAP[$SELECTED_MENU_CATEGORY]}{/if}">
      <div class="row app-navigator">
         <span class="app-icon fa fa-bars"></span>
      </div>
   </div>
   <!-- nuovo menu-->  
   <div class="dropdown hidden-sm hidden-xs hide">
      <button class="btn btn-fask btn-lg" type="button" id="dropdownMenuButtonDesk" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="material-icons" style="color: #fff!important"></i>
      </button>
      <div class="dropdown-menu fask" id="moredropdown" style="width:100%" aria-labelledby="dropdownMenuButtonDesk">
         <div class="bluredBackground"></div>
         {include file="modules/Vtiger/partials/TopbarMenu.tpl"}
      </div>
      <div class='col-md-6 col-sm-12 col-xs-12'>
         <div id="navbar" class="col-sm-2 col-md-3 col-lg-3 collapse navbar-collapse navbar-right global-actions">
            <ul class="nav navbar-nav">
               <!--Global Search -->
               <li class='searchoption'>
                  <i class="fa fa-angle-down"></i>
                  <select class="select2 col-lg-12" id="searchModuleList" data-placeholder="{vtranslate('LBL_SELECT_MODULE')}">
                     <option></option>
                     {foreach key=MODULE_NAME item=fieldObject from=$SEARCHABLE_MODULES}
                     <option value="{$MODULE_NAME}" {if $MODULE_NAME eq $SOURCE_MODULE}selected="selected"{/if}>{vtranslate($MODULE_NAME,$MODULE_NAME)}</option>
                     {/foreach}
                  </select>
                  &nbsp;&nbsp;&nbsp;
               </li>
               <li style="width: 200px;">
                  <div class="search-links-container hidden-sm">
                     <div class="search-link hidden-xs" style="    border: 1px solid #000;color: #000!important;">
                        <span class="ti-search" aria-hidden="true" style="color: #000 !important;"></span>
                        <input class="keyword-input" id="search-top-bar" type="text" placeholder="{vtranslate('LBL_TYPE_SEARCH')}" value="{$GLOBAL_SEARCH_VALUE}">
                        <span id="adv-search" title="Advanced Search" class="adv-search ti-arrow-circle-down pull-right cursorPointer" aria-hidden="true" ></span>
                     </div>
                  </div>
               </li>
               <!--End here-->
               <!--START-Announcement-->
               <li>
                  <div>
                     <a aria-hidden="true" onclick="Vtiger_Index_Js.toggleAnnouncement();" id="announcementicon" class="qc-button rightside-icon-dashboard" title="Announcement" aria-hidden="true">
                     <i  class=" {if $ANNOUNCEMENT->get('isview') eq 0}fas fa-bullhorn {else} fas fa-bullhorn {/if}"></i>
                     </a>
                  </div>
               </li>
               <!--END-Announcement-->
               <!-- Made dynamic code of QuickCreate by MABRUK & modified by jitu@if no module set quickcreate-->
               {include file="modules/Vtiger/partials/TopbarQuickCreateMenu.tpl"}
               <!--End here -->  

               <!--Notification Code by Jitu -->
               <li>
                  <div>


                     <a class="notifications rightside-icon-dashboard"  onclick="Vtiger_Header_Js.showNotification();" data-toggle="dropdown" title="Notifications" aria-hidden="true">
                     {if $NOTIFICATIONS['new'] gt 0}<span class="count" style="position: absolute;top:0;right:0; background-color: red;color:#fff;padding-right:5px;padding-top:1px;padding-left:5px; font-size:11px;z-index:100; ">{$NOTIFICATIONS['new']}</span>{/if}
                     <i class="far fa-bell"></i>

                    </a>
                  </div>
                  <div class="notification-list hide" style="top:30px;" onmouseleave="Vtiger_Header_Js.hideNotification();">
                     <h6>{vtranslate('Notification')}<i class="fa fa-gear pull-right"></i></h6>

                     {if $NOTIFICATIONS['details']|count eq 0}
                        <span style="font-size: 11px; text-align: center;"><strong>{vtranslate('No Notification found')}</strong></span>
                     {else}
                     <ul class="list-unstyled">
                       {foreach item=NOTIFICATION from=$NOTIFICATIONS['details']}

                        <li>
                           <div class="notification-container {if $NOTIFICATION['unread'] eq 0}unread{/if}">
                              <div class="notification-avatar left-node">
                                 <div class="img-holder">
                                    <img src="{$NOTIFICATION['profilepic']}" class="img-circle" height="40" width="40">
                                 </div>
                              </div>
                              <div class="right-node">
                                 <div class="notification-title">
                                    {if $NOTIFICATION['unread'] eq 1}<strong>{$NOTIFICATION['message']}</strong>{else}{$NOTIFICATION['message']}{/if}
                                    <div class="clearfix"></div>
                                    <span class="notification-time">{$NOTIFICATION['timestamp']}</span> 
                                 </div>
                              </div>
                              <div class="clearfix"> </div>
                           </div>
                           <div class="clearfix"> </div>
                        </li>
                        {/foreach}
                     </ul>
                      <div class="clearfix"> </div>
                        {if $NEXTPAGE}
                           <a href="#" class="btn btn-block all-notification text-center"> See all recent activity </a>
                        {/if}   
                     {/if}     
                    </div>
               </li>
               <!--End here -->

               <!-- Top Menu on right side corner -->
               <li>
                  <div>
                     <a class="rightside-icon-dashboard" href="index.php?module=MailManager&view=List" title="Email" aria-hidden="true">
                     <i class="far fa-envelope-open"></i>
                     </a>
                  </div>
               </li>
               <li>
                  <div>
                     <a class="rightside-icon-dashboard" href="index.php?module=Documents&view=List" title="Files" aria-hidden="true">
                     <i class="far fa-file"></i>
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
               <!--Right Corener Profile Image & slider come from right to left for changing theme and other options with logout-->
               {include file="modules/Vtiger/partials/TopbarRight.tpl"}
               <!--End here -->
               </ul>
            </div>
         {include file="modules/Vtiger/partials/TopbarMobile.tpl"}
      </div>
   </div>
</div>
<script type="text/javascript">
   jQuery(document).ready(function(){
   
      $('.searchoption #s2id_searchModuleList').find('.select2-choice').find('.select2-arrow').find('b').remove();
   
      $('.select2-arrow').append('<i class="fa fa-angle-down"style="color:#ffff !important;"></i>');
           jQuery('.menu-open').on('hover',function(){
           jQuery('.dropdown-menu.fask').css('display','block');
      });
   
      jQuery('.addtionalDashboardTab').on('hover',function(){
         jQuery('.dropdown-menu.fask').css('display','none');
      });
   
      $( '.app-navigator-container' ).on('mouseleave','.dropdown-menu.fask', function(){
         $(this).hide();
      });
   
   
   });
</script>
{/strip}
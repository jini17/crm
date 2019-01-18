

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

<nav class="navbar navbar-default navbar-fixed-top app-fixed-navbar">
{assign var="announcement" value=$ANNOUNCEMENT->get('announcement')}   
<div class="headertext" id="headertextflow"> {if !empty($announcement)}{$announcement}{else}{vtranslate('LBL_NO_ANNOUNCEMENTS',$MODULE)}{/if}</div>
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
      <div class="dropdown-menu fask" id="moredropdown"  aria-labelledby="dropdownMenuButtonDesk">
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
                     <a onclick="onofftextheader()" aria-hidden="true" class="qc-button rightside-icon-dashboard" title="Announcement" aria-hidden="true">
                     <i  class="fa fa-bullhorn"></i>
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
                     <a class="notifications rightside-icon-dashboard"  onclick="Vtiger_Header_Js.showNotification();" title="Notifications" aria-hidden="true">
                     <i class="fa fa-bell-o"></i>
                     </a>
                  </div>
                  <div class="notification-list hide">
                     <h6>{vtranslate('Notification')}<i class="fa fa-gear pull-right"></i></h6>
                     <ul class="list-unstyled" ">
                        <li>
                           <div class="notification-container unread">
                              <div class="notification-avatar left-node">
                                 <div class="img-holder">
                                    <img src="storage/2018/October/week3/2560_admin.jpg" class="img-circle" height="40" width="40">
                                 </div>
                              </div>
                              <div class="right-node">
                                 <div class="notification-title">
                                    <a style="display:block; width: 100%; padding:0;">
                                    <strong>Khaled approved leave</strong>
                                    </a>  
                                    <div class="clearfix"></div>
                                    <span class="notification-time">2 hr</span> 
                                 </div>
                              </div>
                              <div class="clearfix"> </div>
                           </div>
                           <div class="clearfix"> </div>
                        </li>
                     </ul>
                     <div class="clearfix"> </div>
                     <a href="#" class="btn btn-block all-notification text-center"> See all recent activity </a>
                  </div>
               </li>
               <!--End here -->
               <!-- Top Menu on right side corner -->
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
{/strip}
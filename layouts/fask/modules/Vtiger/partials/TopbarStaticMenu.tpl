
<ul class="nav navbar-nav newtabs pull-right">
   <li>
      <div class="dropdownFinance">
         <div class="addtionalDashboardTab" style="padding: 10px 10px;">
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
            </ul>
         </div>
      </div>
   </li>
   {if $PLAN eq 1}
   <li>
      <div class="dropdownSales">
         <div class="addtionalDashboardTab"  style="padding: 10px 10px;">
            <span aria-hidden="true">Sales</span>
            <i class="fa fa-lock" style="color: #2f5597;vertical-align: middle;font-size: 13px;"></i>
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
   {elseif $PLAN eq 2 || $PLAN eq 4}
   {assign var=iconsarray value=['potentials'=>'attach_money','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'assignment','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call','performance'=>'timeline', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app','claim'=>'attach_money','myprofile'=>'face'  ]}
   <li>
      <div class="dropdownFinance">
         <div class="addtionalDashboardTab" style="padding: 10px 10px;"><span aria-hidden="true">{vtranslate('Sales')}</span></div>
            <div class="dropdown-content-Finance">
               <ul class="dropdownlist">
                  {foreach item=MENU_MODEL key=MODULE from=$SALES_MENU_MODEL}
                   <li>
                     <a class="dropdown-icon-dashboard" title="{$MODULE}" href=" index.php?module={$MODULE}&amp;view=List&amp;app=SALES ">
                     <i class="app-icon-list material-icons" >{$iconsarray[{strtolower($MODULE)}]}</i>&nbsp;{$MODULE}</a>
                  </li>
                 {/foreach}
               </ul>
             </div>
         </div> 

   </li>
   {/if}
   <li>
      <div class="dropdownTools">
         <div class="addtionalDashboardTab"  style="padding: 10px 10px;">
            <span aria-hidden="true">Communications</span>
         </div>
         <div class="dropdown-content-Tools">
            <ul class="dropdownlist">
               <li>
                  <a class="dropdown-icon-dashboard" title="Notification Templates" href="index.php?module=EmailTemplates&amp;view=List&amp;app=TOOLS">
                  <i class="fa fa-bell-o"></i>&nbsp;Templates
                  </a>
               </li>
               <li>
                  <a class="dropdown-icon-dashboard"  title="{vtranslate('LBL_MAIL_MANAGER')}" href="index.php?module=MailManager&view=List">
                  <i class="material-icons module-icon">email</i>&nbsp;{vtranslate('LBL_MAIL_MANAGER')}
                  </a>
               </li>
               <li>
                  <a class="dropdown-icon-dashboard"  title="{vtranslate('Message Board')}" href="index.php?module=MessageBoard&view=List">
                  <i class="material-icons module-icon">sms</i>&nbsp;{vtranslate('Message Board')}
                  </a>
               </li>
            </ul>
         </div>
      </div>
   </li>
   {if $PLAN eq 1}
   <li>
      <div class="dropdownSupport">
         <div class="addtionalDashboardTab">
            <span aria-hidden="true" >Support</span>
            <i class="fa fa-lock" style="color: #2f5597;    vertical-align: middle;font-size: 13px;"></i>
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
   {else if $PLAN eq 3 || $PLAN eq 4}
    {assign var=iconsarray value=['potentials'=>'attach_money','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'assignment','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call','performance'=>'timeline', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app','claim'=>'attach_money','myprofile'=>'face'  ]}
   <li>
      <div class="dropdownFinance">
         <div class="addtionalDashboardTab" style="padding: 10px 10px;"><span aria-hidden="true">{vtranslate('Support')}</span></div>
            <div class="dropdown-content-Finance">
               <ul class="dropdownlist">
                  {foreach item=MENU_MODEL key=MODULE from=$SUPPORT_MENU_MODEL}
                   <li>
                     <a class="dropdown-icon-dashboard" title="{$MODULE}" href=" index.php?module={$MODULE}&amp;view=List&amp;app=SUPPORT ">
                     <i class="app-icon-list material-icons" >{$iconsarray[{strtolower($MODULE)}]}</i>&nbsp;{$MODULE}</a>
                  </li>
                 {/foreach}
               </ul>
             </div>
         </div> 

   </li>
   {/if}
   <li>
      <div>
         <a class="menu-open">
         <span aria-hidden="true" style="font-size: 15px;
            color: #000;
            display: inline-block;
            height: 100%;
            width: 100%;
            padding: 12px 0;
            text-decoration: none;">All</span>
         </a>
      </div>
   </li>
</ul>
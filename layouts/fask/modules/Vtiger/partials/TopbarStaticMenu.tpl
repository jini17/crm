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
   
   {if $PLAN eq 1 || $PLAN eq 3}


<li>
   <div class="">
      <div class="addtionalDashboardTab"  style="padding: 10px 10px;">
         <span aria-hidden="true"  data-toggle="modal" data-target="#sales">Sales</span>&nbsp;<i class="fa fa-lock" style="color: #2f5597;vertical-align: middle;font-size: 13px;"></i>
      </div>
      <div id="sales" class="modal fade" role="dialog">
         <div class="modal-dialog" style="width: 800px;">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header" style="border: none !important;  ">
                  <button type="button" class="close" data-dismiss="modal" style="border-radius: 50%; border: 1px solid #000;     padding-left: 5px;    padding-right: 5px; ">&times;</button>
                  <br />
                  <br />
               </div>
               <div class="modal-body">
                  <div class="">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img" style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img2.jpg" alt="monitor activities and updates" style="width: 85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Manage Sales Team and activities.
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img" style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img3.jpg" alt="sync from google calendar" style="width:85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Google contacts, calendar and docs synchronization
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img" style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/sales-img1.jpg" alt="second crm dashboard" style="width: 85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Acquire more leads
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 row" style="padding: 10px;">
                         <a target="_blank" href="http://dev7.secondcrm.com/agiliux/addons.php" class="buttonpopup">Read More</a>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</li>

{elseif $PLAN eq 2 || $PLAN eq 4}
   
  {assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'fas fa-list-alt','pricebooks'=>'library_books','salesorder'=>'fas fa-file-invoice-dollar',
    'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
    'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
    'foundation'=>'fas fa-info-circle','admin'=>'fas fa-hand-holding-heart',
    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
    'quotes'=>'description','invoice'=>'fas fa-envelope-open','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
    'recyclebin'=>'delete_forever','products'=>'fas fa-box','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-headset','tools'=>'business_center',
    'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call',
    'performance'=>'fas fa-chart-line', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-hand-holding-usd','myprofile'=>'face','salestarget'=>'fas fa-dot-circle' ]}
   <li>
      <div class="dropdownFinance">
         <div class="addtionalDashboardTab" style="padding: 10px 10px;"><span aria-hidden="true">{vtranslate('Sales')}</span></div>
            <div class="dropdown-content-Finance">
               <ul class="dropdownlist">
                  {foreach item=MENU_MODEL key=MODULE from=$SALES_MENU_MODEL}
                   <li>
                     <a class="dropdown-icon-dashboard" title="{$MODULE}" href=" index.php?module={$MODULE}&amp;view=List&amp;app=SALES ">
                     {if $iconsarray[{strtolower($MODULE)}]|strstr:"fas"}
                        <i class="{$iconsarray[{strtolower($MODULE)}]}" ></i> 
                     {else}
                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($MODULE)}]}</i> 
                      {/if}
                      {if $MODULE eq 'Potentials'}
                        <span class="hide-menu">&nbsp;Appointment</span>
                        {else}
                            <span class="hide-menu">&nbsp;{$MODULE}</span>
                     {/if}</a>   
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
                  <i class="fa fa-bell"></i>&nbsp;Templates
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

{if $PLAN eq 1 || $PLAN eq 2}


<li>
   <div class="">
      <div class="addtionalDashboardTab">
         <span aria-hidden="true"   data-toggle="modal" data-target="#support">Support</span>&nbsp;<i class="fa fa-lock" style="color: #2f5597;vertical-align: middle;font-size: 13px;"></i>
      </div>
      <div id="support" class="modal fade" role="dialog">
         <div class="modal-dialog" style="width: 800px;">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header" style="border: none !important;  ">
                  <button type="button" class="close" data-dismiss="modal" style="border-radius: 50%; border: 1px solid #000;     padding-left: 5px;    padding-right: 5px; ">&times;</button>
                  <br />
                  <br />
               </div>
               <div class="modal-body">
                  <div class="">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img"  style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/default/files/quote-invoice-generator-billing-automation.jpg" alt="monitor activities and updates" style="width: 85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Sales Order, Invoice and Quotation Generator
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img" style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/default/files/send-email-template-easier.jpg" alt="sync from google calendar" style="width:85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Email and SMS Marketing Service
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="popup-col-4">
                              <div class="popup-col-4img" style="height: 265px;">
                                 <img src="http://www.secondcrm.com/sites/all/themes/mobileplus/images/support-img1.jpg" style="width: 85%;">
                              </div>
                              <div class="popup-col-4text">
                                 Auto capture requests from multiple support channels
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-12 row" style="padding: 10px;">
                         <a target="_blank" href="http://dev7.secondcrm.com/agiliux/addons.php" class="buttonpopup">Read More</a>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</li>
   {else if $PLAN eq 3 || $PLAN eq 4}
    {assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'fas fa-list-alt','pricebooks'=>'library_books','salesorder'=>'fas fa-file-invoice-dollar',
    'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
    'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
    'foundation'=>'fas fa-info-circle','admin'=>'fas fa-hand-holding-heart',
    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
    'quotes'=>'description','invoice'=>'fas fa-envelope-open','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
    'recyclebin'=>'delete_forever','products'=>'fas fa-box','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-headset','tools'=>'business_center',
    'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'face', 'mobilecall'=>'call', 'call'=>'call',
    'performance'=>'fas fa-chart-line', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'assignment','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-hand-holding-usd','myprofile'=>'face', 'salestarget'=>'fas fa-dot-circle']}
   <li>
      <div class="dropdownFinance">
         <div class="addtionalDashboardTab" style="padding: 10px 10px;"><span aria-hidden="true">{vtranslate('Support')}</span></div>
            <div class="dropdown-content-Finance">
               <ul class="dropdownlist">
                  {foreach item=MENU_MODEL key=MODULE from=$SUPPORT_MENU_MODEL}
                   <li>
                     <a class="dropdown-icon-dashboard" title="{$MODULE}" href=" index.php?module={$MODULE}&amp;view=List&amp;app=SUPPORT ">
                     {if $iconsarray[{strtolower($MODULE)}]|strstr:"fas"}
                        <i class="{$iconsarray[{strtolower($MODULE)}]}" ></i> 
                     {else}
                        <i class="material-icons module-icon" >{$iconsarray[{strtolower($MODULE)}]}</i> 
                      {/if}

                    {if $MODULE eq 'Potentials'}
                        <span class="hide-menu">&nbsp; Appointment</span>
                        {else}
                            <span class="hide-menu">&nbsp;{$MODULE}</span>
                     {/if}
                  </a>   

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
         <span aria-hidden="true" style="font-size: 16px;
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
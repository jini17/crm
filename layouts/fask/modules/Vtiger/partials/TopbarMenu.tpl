<!--Onmouse hover on ALL show Left Most sub-menu -->
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
      <a class="waves-effect waves-dark " href="index.php?module=SMSNotifier&amp;view=List&amp;app=FOUNDATION ">
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
<!--End here of Left Submenu of All onmouse hover -->

<!--Onmouse hover on ALL show Middle sub-menu -->
<ul class="fasksecond">
{assign var=APP_GROUPED_MENU value=Settings_MenuEditor_Module_Model::getAllVisibleModules()}
{assign var=APP_LIST value=Vtiger_MenuStructure_Model::getAppMenuList()}
{if $MODULE eq "Home"}
{assign var=SELECTED_MENU_CATEGORY value='Dashboard'}
{/if}
{foreach item=APP_NAME from=$APP_LIST}


{if $APP_NAME eq 'ANALYTICS'} {continue}{/if}
{if $APP_NAME eq 'SALES'}
{assign var=SALES_MENU_MODEL value=$APP_GROUPED_MENU[$APP_NAME]}
{/if}

{if $APP_NAME eq 'SUPPORT'}
{assign var=SUPPORT_MENU_MODEL value=$APP_GROUPED_MENU[$APP_NAME]}
{/if}

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
'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web',
'inventory'=>'assignment',
'support'=>'headset','tools'=>'business_center',
'mycthemeswitcher'=>'folder', 'training'=>'book',
 'attendance'=>'fingerprint',
'exitinterview'=>'assignment',
'exitdetails'=>'assignment',
'timesheet'=>'timer',
'chat'=>'chat',
'user'=>'face', 
'mobilecall'=>'call', 
'call'=>'call',
'performance'=>'timeline',
 'users'=>'person',
'meeting'=>'people' ,
'bills'=>'receipt',
'workinghours'=>'access_time' ,
'payments'=>'payment' ,'payslip'=>'insert_drive_file',
'messageboard'=>'assignment',
'leavetype'=>'keyboard_tab' ,
'leave'=>'exit_to_app',
'claim'=>'attach_money','myprofile'=>'face'  ]}
{if $APP_NAME neq 'SALES'}

<li {$APP_NAME} class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}"
                {if vtranslate("LBL_$APP_NAME") eq "Communications"} style="width:15%" {else} style="width:15%"{/if}> 

<a class="has-arrow waves-effect waves-dark " >
    <i class="app-icon-list material-icons" >{$iconsarray[{strtolower($APP_NAME)}]}</i>
    <span class="hide-menu">{$APP_NAME} {vtranslate("LBL_$APP_NAME")}</span>
</a>
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
   <span class="hide-menu"> {vtranslate("LBL_MORE")}</span>
   </a>
   <ul style="padding-left:6px;padding-top:10px;" >
      {assign var=RSS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Rss')}
      {if $RSS_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($RSS_MODULE_MODEL->getId())}
      <li>
         <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href="index.php?module=Rss&view=List" >
         <span class="module-icon">
         <i class="material-icons">rss_feed</i></span>
         <span class="hide-menu"> {vtranslate($RSS_MODULE_MODEL->getName(), $RSS_MODULE_MODEL->getName())}</span>
         </a>
      </li>
      {/if}
      {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Portal')}
      {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
      <li>
         <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Portal&view=List">
         <i class="material-icons module-icon">web</i> <span class="hide-menu"> {vtranslate('Portal')}</span>
         </a>
      </li>
      {/if}
      {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Bills')}
      {if $USER_MODEL->column_fields['roleid'] eq 'H12' || $USER_MODEL->column_fields['roleid'] eq 'H13' || $USER_MODEL->column_fields['roleid'] eq 'H15' ||  $USER_MODEL->isAdminUser()}  
      {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
      <li>
         <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Bills&view=List">
         <i class="material-icons module-icon">receipt</i> <span class="hide-menu"> {vtranslate('Office Bills','Vtiger')}</span>
         </a>
      </li>
      {/if}
      {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('WorkingHours')}                                  
      {assign var=PORTAL_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Payments')}
      {if $PORTAL_MODULE_MODEL && $USER_PRIVILEGES_MODEL->hasModulePermission($PORTAL_MODULE_MODEL->getId())}
      <li>
         <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if} " href="index.php?module=Payments&view=List">
         <i class="material-icons module-icon">payment</i> <span class="hide-menu"> {vtranslate('Payments')}</span>
         </a>
      </li>
      {/if}
   </ul>
</li>
{/if}
</div>
</div>
 <!--Company Logo -->
  <div class="logo-container pull-left">
      <a href="index.php" class="">
      <!--<img src="{$COMPANY_LOGO->get('imagepath')}" alt="{$COMPANY_LOGO->get('alt')}"/>-->
      <img src="test/loginlogo/second-crm-logo.png" alt="Second CRM" height=""/>
      </a>
  </div>
<!--End here logo -->

<!--Static Menu / submenu HRM, SALES, COMMUNICATION, SUPPORT / ALL -->
{include file="modules/Vtiger/partials/TopbarStaticMenu.tpl"}
<!--End here for above Static SubMenu-->
<!--fine menu-->
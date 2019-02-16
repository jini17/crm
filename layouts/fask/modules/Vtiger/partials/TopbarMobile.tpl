</div>
<div class="dropdown-menu fask" id="moredropdown"  aria-labelledby="dropdownMenuButtonDesk">
  <div class="bluredBackground">
  </div>
  <ul class="faskfirst">
    <li class="nav-small-cap hide">APPS
    </li>
    {assign var=USER_PRIVILEGES_MODEL value=Users_Privileges_Model::getCurrentUserPrivilegesModel()}
    {assign var=HOME_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Home')}
    {assign var=DASHBOARD_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Dashboard')}
    {if $USER_PRIVILEGES_MODEL->hasModulePermission($DASHBOARD_MODULE_MODEL->getId())}
    <li class="{if $MODULE eq "Home"}active{/if}"> 
      <a class=" waves-effect waves-dark" href="{$HOME_MODULE_MODEL->getDefaultUrl()}" >
        <i class="material-icons">dashboard
        </i>
        <span class="hide-menu" style="text-transform: uppercase">{vtranslate('LBL_DASHBOARD')} 
        </span>
      </a>
    </li>
    {/if}
    {assign var=MAILMANAGER_MODULE_MODEL value=Vtiger_Module_Model::getInstance('MailManager')}                           
    {assign var=DOCUMENTS_MODULE_MODEL value=Vtiger_Module_Model::getInstance('Documents')}
    {if $USER_PRIVILEGES_MODEL->hasModulePermission($DOCUMENTS_MODULE_MODEL->getId())}
    <li class="{if $MODULE eq "Documents"}active{/if}"> 
      <a class=" waves-effect waves-dark" href="index.php?module=Documents&view=List" >
        <i class="app-icon-list material-icons">insert_drive_file</i>
        <span class="hide-menu"> 
          {vtranslate('Documents')}
        </span>
      </a>
    </li>
    {/if}
    <hr/>
    {if $USER_MODEL->isAdminUser()}
    <li>
      <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
         href="index.php?module=Vtiger&parent=Settings&view=Index" >
        <span class="module-icon">
          <i class="material-icons">settings</i>
        </span>
        <span class="hide-menu">  
          {vtranslate('LBL_CRM_SETTINGS','Vtiger')}
        </span>
      </a>
    </li>
    <li>
      <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
         href="index.php?module=Users&parent=Settings&view=List" >
        <span class="module-icon">
          <i class="fas fa-user-circle"></i>
        </span>
        <span class="hide-menu">{vtranslate('LBL_MANAGE_USERS','Vtiger')}
        </span>
      </a>
    </li>
    <li tools="">
      <a class="waves-effect waves-dark " href=" index.php?module=RecycleBin&amp;view=List&amp;app=TOOLS ">
        <i class="material-icons module-icon" style="font-size: 18px !important">delete_forever</i> 
        <span class="hide-menu">{vtranslate('Recycle Bin', 'Vtiger')}
        </span>
      </a>
    </li>
    <li foundation="">
      <a class="waves-effect waves-dark " href="index.php?module=SMSNotifier&amp;view=List&amp;app=FOUNDATION ">
        <i class="material-icons module-icon">sms
        </i> 
        <span class="hide-menu">{vtranslate('LBL_SMS_MESSAGES', 'Vtiger')}
        </span>
      </a>
    </li>
    {else}
    <li class="{if $MODULE eq "Users"}active{/if}"> 
      <a class=" waves-effect waves-dark" href="index.php?module=Users&view=Settings" >
        <i class="material-icons">settings</i>
        <span class="hide-menu" style="text-transform: uppercase"> {vtranslate('LBL_SETTINGS', 'Settings:Vtiger')}
        </span>
      </a>
    </li>
    {/if}
  </ul>
  <style>
      .fas.fa-envelope.menu{
          background: none !important;
          padding: 0 !important;
          color: #000;
          margin-right: 5px;
      }
  </style>
  <ul class="fasksecond">
    {assign var=APP_GROUPED_MENU value=Settings_MenuEditor_Module_Model::getAllVisibleModules()}
    {assign var=APP_LIST value=Vtiger_MenuStructure_Model::getAppMenuList()}
    {if $MODULE eq "Home"}
    {assign var=SELECTED_MENU_CATEGORY value='Dashboard'}
    {/if}
    {if $PLAN eq 1}
    {assign var=counttab value=5}
    {else if $PLAN eq 2 || $PLAN eq 3}
    {assign var=counttab value=6}
    {else}   
    {assign var=counttab value=7}
    {/if}
    {math equation="(100/$counttab)" assign="widthtab"}
    {math equation="(100/$counttab)" assign="widthcomtab"}
    {foreach item=APP_NAME from=$APP_LIST}
    {if vtranslate("LBL_$APP_NAME") eq 'General' OR vtranslate("LBL_$APP_NAME") eq 'HRM'}
    {math equation="$widthtab" assign="colwidth"}
    {else if vtranslate("LBL_$APP_NAME") eq 'Communications'}
    {math equation="$widthcomtab+2" assign="colwidth"}
    {else}
    {math equation="$widthcomtab+1" assign="colwidth"}   
    {/if}
    {if $APP_NAME eq 'ANALYTICS'} {continue}{/if}
    {if count($APP_GROUPED_MENU.$APP_NAME) gt 0}
    {foreach item=APP_MENU_MODEL from=$APP_GROUPED_MENU.$APP_NAME}
    {assign var=FIRST_MENU_MODEL value=$APP_MENU_MODEL}
    {if $APP_MENU_MODEL}
    {break}
    {/if}
    {/foreach}
    {assign var=iconsarray value=['potentials'=>'fas fa-comments-dollar','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
   'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'fas fa-list-alt','pricebooks'=>'library_books','salesorder'=>'fas fa-file-invoice-dollar',
   'purchaseorder'=>'fas fa-shopping-cart','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'fas fa-book',
   'projecttask'=>'check_box','projectmilestone'=>'fas fa-info-circle','mailmanager'=>'fas fa-envelope menu','documents'=>'file_download', 'calendar'=>'event',
'foundation'=>'fas fa-info-circle','admin'=>'fas  fa-users',
   'emails'=>'email','reports'=>'fas fa-chart-bar','servicecontracts'=>'content_paste','contacts'=>'fas fa-address-book','campaigns'=>'notifications',
   'quotes'=>'description','invoice'=>'fas fa-file-invoice','emailtemplates'=>'fas fa-file','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
   'recyclebin'=>'delete_forever','products'=>'fas fa-box','portal'=>'web','inventory'=>'assignment','support'=>'fas fa-ticket-alt','tools'=>'business_center',
   'mycthemeswitcher'=>'folder', 'training'=>'book', 'attendance'=>'fingerprint','exitinterview'=>'assignment','exitdetails'=>'assignment','timesheet'=>'timer','chat'=>'chat','user'=>'fas fa-id-card', 'mobilecall'=>'call', 'call'=>'call',
'performance'=>'fas fa-chart-bar', 'users'=>'person','meeting'=>'people' ,'bills'=>'receipt','workinghours'=>'access_time' ,'payments'=>'payment' ,'payslip'=>'insert_drive_file','messageboard'=>'fas fa-newspaper','leavetype'=>'keyboard_tab' ,'leave'=>'exit_to_app',
    'claim'=>'fas fa-dollar-sign','myprofile'=>'fas fa-id-card'  ]}
    <li {$APP_NAME} class="with-childs {if $SELECTED_MENU_CATEGORY eq $APP_NAME}active{/if}" style="width:{$colwidth}%;"> 
      <a class="has-arrow waves-effect waves-dark " >
        {if $iconsarray[{strtolower($APP_NAME)}]|strstr:"fas"}
        <i class="{$iconsarray[{strtolower($APP_NAME)}]}" >
        </i> 
        {else}
        <i class="material-icons module-icon" >{$iconsarray[{strtolower($APP_NAME)}]}
        </i> 
        {/if}   
        <span class="hide-menu" {$moduleName}>{vtranslate("LBL_$APP_NAME")}
        </span>
      </a>
      <ul style="padding-left:6px;padding-top:15px;">
        {foreach item=moduleModel key=moduleName from=$APP_GROUPED_MENU[$APP_NAME]}
        {assign var='translatedModuleLabel' value=vtranslate($moduleModel->get('label'),$moduleName )}
        {if $moduleName eq 'MyProfile'}                                            
        {assign var='moduleURL' value="index.php?module=Users&view=PreferenceDetail&record={$USER_MODEL->getId()}&app=$APP_NAME&parent=Settings"}
        {else}
        {assign var='moduleURL' value="{$moduleModel->getDefaultUrl()}&app=$APP_NAME"}
        {/if}  
        {if $moduleName eq 'Calendar'}
        <li {$APP_NAME} moudel='{$moduleName}'>
          <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" href='index.php?module=Calendar&view=List&search_params=[[["activitytype"%2C"e"%2C"Meeting"]]]' >
            <i class="ti ti-notepad" >
            </i> 
            <span class="hide-menu"> {vtranslate("LBL_MEETING",'Vtiger')}
            </span>
          </a>
        </li>
        <li {$APP_NAME} moudel='{$moduleName}'>
          <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
             href="{if $translatedModuleLabel eq 'Employee'} index.php?module=Users&parent=Settings&view=List   {/if}
                   {if $translatedModuleLabel neq 'Employee'} {$moduleURL} {/if}" >
            {if $iconsarray[{strtolower($moduleName)}]|strstr:"fa"}
            <i class="{$iconsarray[{strtolower($moduleName)}]}" >
            </i> 
            {else}
            <i class="material-icons module-icon" >{$iconsarray[{strtolower($moduleName)}]}
            </i> 
            {/if}   
            <span class="hide-menu"> {$translatedModuleLabel}
            </span>
          </a>
        </li>
        {else}   
        <li {$APP_NAME} moudel='{$moduleName}'>
          <a class="waves-effect waves-dark {if $MODULE eq $moduleName}active{/if}" 
             href="{if $translatedModuleLabel eq 'Employee'}index.php?module=Users&parent=Settings&view=List{/if}
                   {if $translatedModuleLabel neq 'Employee'} {$moduleURL} {/if}" >
            {if $iconsarray[{strtolower($moduleName)}]|strstr:"fas"}
            <i class="{$iconsarray[{strtolower($moduleName)}]}" >
            </i> 
            {else}
            <i class="material-icons module-icon" >{$iconsarray[{strtolower($moduleName)}]}
            </i> 
            {/if}   
            <span class="hide-menu"> {$translatedModuleLabel}
            </span>
          </a>
        </li>
        {/if}
        {/foreach}
      </ul>
    </li>
    {/if}
    {/foreach}
    </div>
</div>
<div class="row hide">
  <div id="navbar" class=" hide col-sm-2 col-md-3 col-lg-3 collapse navbar-collapse navbar-right global-actions">
    <ul class="nav navbar-nav">
      <!--START-textheader-->
      <li>
        <div>
          <a onclick="onofftextheader()" aria-hidden="true" class="qc-button rightside-icon-dashboard" title="Announcement" aria-hidden="true">
            <i  class="fas fa-megaphone">
            </i>
          </a>
        </div>
      </li>
      <!--END-textheader-->
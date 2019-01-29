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
         ({$USER_MODEL->get('user_name')})">
      <img height="40" width="30"  src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
      </a>
      {/if}
      {/foreach}
      {/if}
      <div class="dropdown-menu logout-content animated fadeInRight profile-tool-box" role="menu">
         <div class="row">
            <div class="col-lg-12 col-sm-12" style="padding:10px;">
               <div class="profile-container col-lg-12 col-sm-13">
                  {assign var=IMAGE_DETAILS value=$USER_MODEL->getImageDetails()}
                  <input type="hidden" name="user_id" id="current_user_id" value="{$USER_MODEL->get('id')}" />
                  {if $IMAGE_DETAILS neq '' && $IMAGE_DETAILS[0] neq '' && $IMAGE_DETAILS[0].path eq ''}
                  <i class='material-icons'>perm_identity</i>
                  {else}
                  {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
                  {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                  <img class="user-profile-pic img-circle" src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                  {/if}
                  {/foreach}
                  {/if}
               </div>
               <div class="col-lg-12 col-sm-12">
                  <h5 class=" text-center user-first-n-last-name text-bold">{$USER_MODEL->get('first_name')} {$USER_MODEL->get('last_name')}</h5>
                  <h6 class="textOverflowEllipsis text-center" title='{$USER_MODEL->get('user_name')}'>{$USER_MODEL->get('user_name')} | {$USER_MODEL->getUserRoleName()}</h6>
                  {assign var=useremail value=$USER_MODEL->get('email1')}
                  <h6 class="textOverflowEllipsis text-center" title='{$USER_MODEL->get('email')}'>{$useremail}</h6>
               </div>
               <hr style="margin: 10px 0 !important">
               <div class="col-lg-12 col-sm-12 text-center">
                  <ul class="dropdown-user list-inline ">
                     <li role="separator" class="divider"></li>
                     <li>
                        <a id="menubar_item_right_LBL_MY_PREFERENCES" class="btn btn-primary" href="{$USER_MODEL->getPreferenceDetailViewUrl()}">
                        <i class="material-icons">settings</i> {vtranslate('LBL_MY_PREFERENCES')}</a>
                     </li>
                     <li role="separator" class="divider"></li>
                     <li>
                        <a id="menubar_item_right_LBL_SIGN_OUT" class="btn btn-danger" href="index.php?module=Users&action=Logout">
                        <i class="material-icons">power_settings_new</i> {vtranslate('LBL_SIGN_OUT')}</a>
                     </li>
                  </ul>
               </div>
               <div class="clearfix"></div>
               <hr>
               <div class="clearfix"></div>
               <div class="col-md-12 col-lg-12 col-xs-12">
                  <h5 class="text-bold">Themes</h5>
               </div>
               <div class="clearfix"></div>
               <hr />
               <div class="clearfix"></div>
               <div class="col-md-3">Colors</div>
               <div class="col-md-9">
                  <ul class="color-list list-inline pull-right">
                     <li><a class="btn color-box color-blue themeElement" data-skinName="blue"><i class="fa {if $USER_MODEL->get('theme') eq 'blue'}  fa-check {/if}"  ></i></a></li>
                     <li><a class="btn color-box color-purple themeElement" data-skinName="purple"><i class="fa {if $USER_MODEL->get('theme') eq 'purple'} fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-yellow themeElement" data-skinName="yellow"><i class="fa  {if $USER_MODEL->get('theme') eq 'yellow'} fa-check {/if}"></i></a></li>
                     <li><a class="btn color-box color-green themeElement" data-skinName="green"><i class="fa {if $USER_MODEL->get('theme') eq 'green'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-shipcove themeElement" data-skinName="shipcove"><i class="fa {if $USER_MODEL->get('theme') eq 'shipcove'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-lilacbush themeElement" data-skinName="lilacbush"><i class="fa {if $USER_MODEL->get('theme') eq 'lilacbush'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-energyyellow themeElement" data-skinName="energyyellow"><i class="fa {if $USER_MODEL->get('theme') eq 'energyyellow'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-downy themeElement" data-skinName="downy"><i class="fa {if $USER_MODEL->get('theme') eq 'downy'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-lily themeElement" data-skinName="lily"><i class="fa {if $USER_MODEL->get('theme') eq 'lily'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-danube themeElement" data-skinName="danube"><i class="fa {if $USER_MODEL->get('theme') eq 'danube'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-selectiveyellow themeElement" data-skinName="selectiveyellow"><i class="fa {if $USER_MODEL->get('theme') eq 'selectiveyellow'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-sandybrown themeElement" data-skinName="sandybrown"><i class="fa {if $USER_MODEL->get('theme') eq 'sandybrown'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-mandy themeElement" data-skinName="mandy"><i class="fa {if $USER_MODEL->get('theme') eq 'mandy'}  fa-check  {/if}"></i></a></li>
                     <li><a class="btn color-box color-aquaisland themeElement" data-skinName="aquaisland"><i class="fa {if $USER_MODEL->get('theme') eq 'aquaisland'}  fa-check  {/if}"></i></a></li>
                  </ul>
                  <div class="clarfix"></div>
               </div>
               <div class="clearfix"></div>
               <hr />
               <div class="clearfix"></div>
               <div class="col-md-12">
                  <ul class="profile-list list-unstyled">
                     <li> <a class="" href="index.php?module=Users&parent=Settings&view=Calendar&record={$USER_MODEL->get('id') }"><i class='fa fa-gear'></i>  Preferences </a></li>
                     <li> <a class="" href="index.php?module=Home&view=DashBoard&tabid=1298"><i class='fa fa-rocket'></i> Getting Started</a></li>
                     <li> <a class="" href="http://dev7.secondcrm.com/agiliux/help.php"><i class='fa fa-life-ring'></i> Help</a></li>
                     <li> <a class=""><i class='fa fa-at'></i> Contact Support</a></li>
                     <!--<li> <a class=""><i class='fa fa-paper-plane'></i> What's new?</a></li>-->
                  </ul>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</li>
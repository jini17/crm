<li>
   <div class="dropdown ">
      <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><a aria-hidden="true" href="#" id="menubar_quickCreate" class="qc-button rightside-icon-dashboard" title="Quick Create"><i class="fa fa-plus"></i></a></div>
      <ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dropdownMenu1" style="width:650px;">
         <li class="title" style="padding: 5px 0 0 15px;">
            <h4><strong>Quick Create</strong></h4>
         </li>
         <hr>
         <li id="quickCreateModules" style="padding: 0 5px;">
            <div class="col-lg-12" style="padding-bottom:15px;">
               <!-- Added By Mabruk -->
               {if $QUICK_CREATE_MOD_ICONS|count gt 0}      
               {foreach from = $QUICK_CREATE_MOD_ICONS key = i item = MODULE}
               {if $i == 0}
               <div class="row">
                  {else if $i % 3 == 0}                                
               </div>
               <br>
               <div class="row">
                  {/if}
                  {if $MODULE['moduleName'] == 'Users'}
                  {assign var=URL value="index.php?module=Users&parent=Settings&view=Edit"}
                  {else}    
                  {assign var=URL value="index.php?module={$MODULE['moduleName']}&amp;view=QuickCreateAjax"}
                  {/if}
                  {if $MODULE['moduleName'] == 'Documents'}
                  <div documents="" class="col-lg-4 dropdown">
                     <a id="menubar_quickCreate_Documents" class="quickCreateModuleSubmenu dropdown-toggle" data-name="Documents" data-toggle="dropdown" data-url="index.php?module=Documents&amp;view=QuickCreateAjax" href="javascript:void(0)">
                     <i class="material-icons pull-left">file_download
                     </i>
                     <span class="quick-create-module">Documents
                     <i class="fa fa-caret-down quickcreateMoreDropdownAction">
                     </i>
                     </span>
                     </a>
                     <ul class="dropdown-menu quickcreateMoreDropdown" aria-labelledby="menubar_quickCreate_Documents" style="width:100%">
                        <li class="dropdown-header">
                           <i class="material-icons">file_upload
                           </i> File Upload
                        </li>
                        <li id="VtigerAction">
                           <a href="javascript:Documents_Index_Js.uploadTo('Vtiger')">
                           <img width="15" hieght="15" style="  margin-top: -3px;margin-right: 4%;" title="Agiliux" alt="Agiliux" src="layouts/v7/skins/images/favicon.ico">
                           To Agiliux
                           </a>
                        </li>
                        <li class="dropdown-header">
                           <i class="ti-link">
                           </i> Link External Document
                        </li>
                        <li id="shareDocument">
                           <a href="javascript:Documents_Index_Js.createDocument('E')">&nbsp;
                           <i class="material-icons">link
                           </i>&nbsp;&nbsp; From File Url
                           </a>
                        </li>
                        <li role="separator" class="divider">
                        </li>
                        <li id="createDocument">
                           <a href="javascript:Documents_Index_Js.createDocument('W')">
                           <i class="ti-file">
                           </i> Create New Document
                           </a>
                        </li>
                     </ul>
                  </div>
                  {else}
                  <div class="col-lg-4">
                     <a id="menubar_quickCreate_{$MODULE['moduleName']}" class="quickCreateModule" data-name="{$MODULE['moduleName']}" {if $MODULE['moduleName'] eq 'Users'}href={$URL}{else}data-url={$URL} href="javascript:void(0)"{/if}>
                     {if $MODULE['moduleIcon']|strstr:"fas"}
                        <i class="{$MODULE['moduleIcon']}"></i>
                     {else}
                        <i class="material-icons pull-left">{$MODULE['moduleIcon']}</i>
                     {/if}   
                     <span class="quick-create-module">{vtranslate($MODULE['moduleName'])}</span>
                     </a>
                  </div>
                  {/if}    
                  {/foreach}
                  {/if}   
               </div>
               <!-- END -->
            </div>
         </li>
      </ul>
   </div>
</li>
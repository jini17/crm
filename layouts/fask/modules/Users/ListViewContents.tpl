{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Users/views/List.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
{strip}

<style>
   .alphabetSearch a{
   color: #307fe8;
   font-weight: bold;
   }
   .box-content{
   padding:5px 10px;
   border: 1px solid #ddd;
   background: #fff;
   min-height: 300px;
   margin-top: 20px;
   marign-bottom: 20px;
   }
   .user-social{
   margin-top: 15px;
   }
   .username{
   margin-bottom: 5px;
   }
   .user-social a{
   color: #fff;
   }
   .facebook {
   background:  #3B5998;
   padding-left:4px;
   padding-right:4px;
   padding-top: 3px;
   padding-bottom: 3px;
   }
   .twitter {
   background: #0084b4;
   padding-left:3px;
   padding-right:3px;
   padding-top: 3px;
   padding-bottom: 3px;
   }
   .linkedin {
   background: #0077B5;
   padding-left:3px;
   padding-right:3px;
   padding-top: 3px;
   padding-bottom: 3px;
   }
   .birthdaybox{
   margin-top: 30px;
   }
   .highlight-birthday{
   background: #b3ffff;   
   }
   .img-circle{
   background-color: #fff;
   }
   .email-icon i{
   color: #333;
   }
   .view{
   
     }
   .activeview{
       
   }
</style>

<input type="text" id="listViewEntriesCount" value="{$LISTVIEW_ENTRIES_COUNT}" />
<input type="hidden" id="pageStartRange" value="{$PAGING_MODEL->getRecordStartRange()}" />
<input type="hidden" id="pageEndRange" value="{$PAGING_MODEL->getRecordEndRange()}" />
<input type="hidden" id="previousPageExist" value="{$PAGING_MODEL->isPrevPageExists()}" />
<input type="hidden" id="nextPageExist" value="{$PAGING_MODEL->isNextPageExists()}" />
<input type="hidden" id="pageNumberValue" value= "{$PAGE_NUMBER}"/>
<input type="hidden" id="pageLimitValue" value= "{$PAGING_MODEL->getPageLimit()}" />
<input type="hidden" id="numberOfEntries" value= "{$LISTVIEW_ENTRIES_COUNT}" />
<input type="hidden" id="alphabetSearchKey" value= "{$MODULE_MODEL->getAlphabetSearchField()}" />
<input type="hidden" id="Operator" value="{$OPERATOR}" />
<input type="hidden" id="alphabetValue" value="{$ALPHABET_VALUE}" />
<input type="text" id="pagecount" value="{$PAGE_COUNT}" />
<input type="text" id="totalCount" value="{$LISTVIEW_COUNT}" />
<input type="hidden" name="orderBy" value="{$ORDER_BY}" id="orderBy">
<input type="hidden" name="sortOrder" value="{$SORT_ORDER}" id="sortOrder">
<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
<input type='text' value="{$PAGING_MODEL->getPageLimit()}" id='pageLimit'>
<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">
<input type="hidden" value="{$NO_SEARCH_PARAMS_CACHE}" id="noFilterCache" >

{assign var = ALPHABETS_LABEL value = vtranslate('LBL_ALPHABETS', 'Vtiger')}
{assign var = ALPHABETS value = ','|explode:$ALPHABETS_LABEL}
   <div class="clearfix" style="height: 20px;"></div>
  <div class="row">
            <div class="col-lg-9">
       
               {include file="ListViewAlphabet.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
            </div>
            <!--  Filter -->
            <div class="col-lg-3 ">
                  <select class="select2 grid-filter pull-right">
                      <option value=""> {vtranslate('Filter by',$MODULE)}</option>
                      <option value="N"> {vtranslate('New Joinees',$MODULE)}</option>
                      <option value="B"> {vtranslate('Bithdays',$MODULE)} </option>
                      <option value="G"> {vtranslate('Gender',$MODULE)} </option>
                  </select>
              </div>
      </div>
                  <div class="clearfix"></div>
<div class="row">


    <div class="clearfix" style="height: 30px;"></div>

    <div id="table-content" class="table-container">
        <form name='list' id='listedit' action='' onsubmit="return false;">
                <table id="listview-table" class="table table-striped table-hover {if $LISTVIEW_ENTRIES_COUNT eq '0'}listview-table-norecords {/if} listview-table">
                        <thead>
                                <tr class="listViewContentHeader">
                                        <th>
                                            {vtranslate('LBL_ACTIONS', $QUALIFIED_MODULE)} <i class="fa fa-search pull-right" onclick="jQuery('.searchRow').toggle('slow')"></i>
                                        </th>
                                        {foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS}
                                                {if $LISTVIEW_HEADER->getName() neq 'last_name' and $LISTVIEW_HEADER->getName() neq 'email1' and $LISTVIEW_HEADER->getName() neq 'status'}
                                                        {if $LISTVIEW_HEADER->getName() eq 'first_name'}
                                                                {assign var=HEADER_LABEL value='LBL_NAME_EMAIL'}
                                                        {else}
                                                                {assign var=HEADER_LABEL value=$LISTVIEW_HEADER->get('label')}
                                                        {/if}
                                                         {if $LISTVIEW_HEADER->getName() neq 'facebook'}
                                                        <th {if $COLUMN_NAME eq $LISTVIEW_HEADER->get('name')} nowrap="nowrap" {/if} >
                                                                <a href="#" class="listViewContentHeaderValues" data-nextsortorderval="{if $COLUMN_NAME eq $LISTVIEW_HEADER->get('name')}{$NEXT_SORT_ORDER}{else}ASC{/if}" data-columnname="{$LISTVIEW_HEADER->get('name')}">
                                                                        {if $COLUMN_NAME eq $LISTVIEW_HEADER->get('name')}
                                                                                <i class="fa fa-sort {$FASORT_IMAGE}"></i>
                                                                        {else}
                                                                                <i class="fa fa-sort customsort"></i>
                                                                        {/if}
                                                                        &nbsp;{vtranslate($HEADER_LABEL, $MODULE)}&nbsp;
                                                                </a>
                                                                {if $COLUMN_NAME eq $LISTVIEW_HEADER->get('name')}
                                                                        <a href="#" class="removeSorting"><i class="ti-close"></i></a>
                                                                {/if}
                                                        </th>
                                                        {else}
                                                          <th {if $COLUMN_NAME eq $LISTVIEW_HEADER->get('name')} nowrap="nowrap" {/if} ><a href="#" class="listViewContentHeaderValues">{vtranslate('LBL_GET_IN_TOUCH', $MODULE)}</a>&nbsp;</th>
                                                        {/if}
                                                {/if}
                                        {/foreach}
                                </tr>
                        </thead>
                        <tbody class="overflow-y">
                                {if $MODULE_MODEL->isQuickSearchEnabled() && !$SEARCH_MODE_RESULTS}
                                        <tr class="searchRow">
                                                <th class="inline-search-btn">
                                                        <div class="table-actions">
                                                                <button class="btn btn-success btn-sm" data-trigger="listSearch">{vtranslate("LBL_SEARCH",$MODULE)}</button>
                                                        </div>
                                                </th>
                                                {foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS}
                                                        {if $LISTVIEW_HEADER->getName() eq 'last_name' or $LISTVIEW_HEADER->getName() eq 'email1' or $LISTVIEW_HEADER->getName() eq 'status'}
                                                                {continue}
                                                        {/if}
                                                        {if $LISTVIEW_HEADER->getName() neq 'facebook'}
                                                        <th>
                                                                {assign var=FIELD_UI_TYPE_MODEL value=$LISTVIEW_HEADER->getUITypeModel()}
                                                                {include file=vtemplate_path($FIELD_UI_TYPE_MODEL->getListSearchTemplateName(),$MODULE) FIELD_MODEL= $LISTVIEW_HEADER SEARCH_INFO=$SEARCH_DETAILS[$LISTVIEW_HEADER->getName()] USER_MODEL=$CURRENT_USER_MODEL}
                                                                <input type="hidden" class="operatorValue" value="{$SEARCH_DETAILS[$LISTVIEW_HEADER->getName()]['comparator']}">
                                                        </th>
                                                        {else}
                                                            <th><input type="text" disabled class="listSearchContributor inputElement"/></th>
                                                       {/if} 
                                                {/foreach}
                                        </tr>
                                {/if}
                                {foreach item=LISTVIEW_ENTRY from=$LISTVIEW_ENTRIES name=listview}
                                        <tr class="listViewEntries" data-id='{$LISTVIEW_ENTRY->getId()}' data-recordUrl='{$LISTVIEW_ENTRY->getDetailViewUrl()}&parentblock=LBL_USER_MANAGEMENT' id="{$MODULE}_listView_row_{$smarty.foreach.listview.index+1}">
                                                <td class="listViewRecordActions">
                                                        {include file="ListViewRecordActions.tpl"|vtemplate_path:$MODULE}
                                                </td>
                                                {foreach item=LISTVIEW_HEADER from=$LISTVIEW_HEADERS}
                                                        {assign var=LISTVIEW_HEADERNAME value=$LISTVIEW_HEADER->get('name')}
                                                        {assign var=LISTVIEW_ENTRY_RAWVALUE value=$LISTVIEW_ENTRY->getRaw($LISTVIEW_HEADER->get('column'))}
                                                        {assign var=LISTVIEW_ENTRY_VALUE value=$LISTVIEW_ENTRY->get($LISTVIEW_HEADERNAME)}
                                                        {if $LISTVIEW_HEADER->getName() eq 'first_name'}
                                                                <td data-name="{$LISTVIEW_HEADER->get('name')}" data-rawvalue="{$LISTVIEW_ENTRY_RAWVALUE}" 
                                                                    data-type="{$LISTVIEW_HEADER->getFieldDataType()}">
                                                                        <span class="fieldValue">
                                                                                <span class="value textOverflowEllipsis">
                                                                                        <div style="margin-left: -13px;">
                                                                                                {assign var=IMAGE_DETAILS value=$LISTVIEW_ENTRY->getImageDetails()}
                                                                                                {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
                                                                                                        {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                                                                                                                <div class='col-lg-2'>
                                                                                                                        <img src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                                                                                                </div>
                                                                                                        {/if}
                                                                                                {/foreach}
                                                                                                {if $IMAGE_DETAILS[0]['id'] eq null}
                                                                                                        <div class='col-lg-2'>
                                                                                                                <i class="ti-user userDefaultIcon"></i>
                                                                                                        </div>
                                                                                                {/if}
                                                                                                <div class="usersinfo col-lg-9 textOverflowEllipsis" title="{$LISTVIEW_ENTRY->get('last_name')}">
                                                                                                        <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">{$LISTVIEW_ENTRY->get($LISTVIEW_HEADERNAME)} {$LISTVIEW_ENTRY->get('last_name')}</a>
                                                                                                </div>
                                                                                                <div class="usersinfo col-lg-9 textOverflowEllipsis">
                                                                                                        {$LISTVIEW_ENTRY->get('email1')}
                                                                                                </div>
                                                                                        </div>
                                                                                </span>
                                                                        </span>
                                                                </td>
                                                        {elseif $LISTVIEW_HEADER->getName() neq 'last_name' and $LISTVIEW_HEADER->getName() neq 'email1' and $LISTVIEW_HEADER->getName() neq 'status' and $LISTVIEW_HEADER->getName() neq 'facebook'}
                                                                <td class="{$WIDTHTYPE}" nowrap>
                                                                        <span class="fieldValue">
                                                                                <span class="value textOverflowEllipsis">
                                                                                        {$LISTVIEW_ENTRY->get($LISTVIEW_HEADERNAME)}
                                                                                </span>
                                                                        </span>
                                                                </td>
                                                        {elseif $LISTVIEW_HEADER->getName() eq 'facebook' }            
                                                            <td class="{$WIDTHTYPE}" nowrap>
                                                                 {if $LISTVIEW_ENTRY->getSocialMediaLinks('facebook',$LISTVIEW_ENTRY->getId()) neq ''}  
                                                                <a class="facebook" target="_blamk" href="{$LISTVIEW_ENTRY->getSocialMediaLinks('facebook',$LISTVIEW_ENTRY->getId())}" style="margin-left:5px;"><i class="fa fa-facebook"></i></a>
                                                                {/if}
                                                                {if $LISTVIEW_ENTRY->getSocialMediaLinks('twitter',$LISTVIEW_ENTRY->getId()) neq ''}  
                                                                <a class='twitter' target="_blamk" href="{$LISTVIEW_ENTRY->getSocialMediaLinks('twitter',$LISTVIEW_ENTRY->getId())}" style="margin-left:5px;"><i class='fa fa-twitter'></i></a>
                                                                {/if}
                                                                 {if $LISTVIEW_ENTRY->getSocialMediaLinks('linkedin',$LISTVIEW_ENTRY->getId()) neq ''}  
                                                                <a  class='linkedin' target="_blamk" href="{$LISTVIEW_ENTRY->getSocialMediaLinks('linkedin',$LISTVIEW_ENTRY->getId())}" style="margin-left:5px;"><i class='fa fa-linkedin'></i></a>
                                                                {/if}
                                                                <a  class='email-icon' href="#"  style="margin-left:5px;" onclick="javascript:Settings_Users_List_Js.birthdayEmail({$LISTVIEW_ENTRY->getId()})"><i class='fa fa-envelope'></i></a>
                                                             </td>
                                                        {/if}
                                                {/foreach}
                                        </tr>
                                {/foreach}
                                {if $LISTVIEW_ENTRIES_COUNT eq '0'}
                                        <tr class="emptyRecordsDiv">
                                                {assign var=COLSPAN_WIDTH value={count($LISTVIEW_HEADERS)}}
                                                <td colspan="{$COLSPAN_WIDTH}">
                                                        <div class="emptyRecordsContent">
                                                                <center>
                                                                        {if $SEARCH_VALUE eq 'Active'}
                                                                                {assign var=SINGLE_MODULE value="SINGLE_$MODULE"}
                                                                                {vtranslate('LBL_NO')} {vtranslate($MODULE, $MODULE)} {vtranslate('LBL_FOUND')},{if $IS_MODULE_EDITABLE} <a style="color:blue" href="{$MODULE_MODEL->getCreateRecordUrl()}"> {vtranslate('LBL_CREATE_USER',$MODULE)}</a>{/if}
                                                                        {else}
                                                                                {vtranslate('LBL_NO')} {vtranslate($MODULE, $MODULE)} {vtranslate('LBL_FOUND')}
                                                                        {/if}
                                                                </center>
                                                        </div>
                                                </td>
                                        </tr>
                                {/if}
                        </tbody>
                </table>
        </form>
    </div>
    <div id="scroller_wrapper" class="bottom-fixed-scroll">
        <div id="scroller" class="scroller-div"></div>
    </div>
    <div>Pagenation code start
     <nav aria-label="Page navigation example">
         {if $PAGE_COUNT > 1}
            <ul class="pagination">
              <li class="page-item {if $PAGE_NUMBER le 1}disabled{/if}">
                   <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                  <span class="sr-only {if $PAGE_NUMBER le 1}disabled{/if}">Previous</span>
                </a>
              </li>
             
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                  <span class="sr-only">Next</span>
                </a>
              </li>
            </ul>
   
    </nav>
    
    </div>
{/strip}
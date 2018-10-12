{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
    <style>
        #tablist li.active{
          border-bottom: 2px solid #2f5597 ;
          color: #2f5597 ;
        }
    </style>
    <input type="hidden" id="listViewEntriesCount" value="{$LISTVIEW_ENTRIES_COUNT}" />
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
<input type="hidden" id="totalCount" value="{$LISTVIEW_COUNT}" />
<input type="hidden" name="orderBy" value="{$ORDER_BY}" id="orderBy">
<input type="hidden" name="sortOrder" value="{$SORT_ORDER}" id="sortOrder">
<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
<input type='hidden' value="{$PAGING_MODEL->getPageLimit()}" id='pageLimit'>
<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">
<input type="hidden" value="{$NO_SEARCH_PARAMS_CACHE}" id="noFilterCache" >
<input type="hidden" value="{$TAB_TYPE}" id="tabtype" />
        <div class="listViewPageDiv" id="listViewContent" style="padding-left: 0px; width: 100%">
            <!--id="listViewContent"-->
            <div class="col-sm-12 col-xs-12 full-height">
                 
                   <div class="" id="tablist">
                        <ul class="nav nav-tabs tabs sortable container-fluid visible-lg">

                            <li class="{if $TAB_TYPE eq 'ED'}active {/if} employeeTab" data-tabname="Employee Directory">
                                <a  href="index.php?module=Users&parent=Settings&view=List&block=1&fieldid=1&tabtype=ED">
                                        <div><span class="name textOverflowEllipsis" value="Employee Directory" style="width:10%">
                                            <strong>{vtranslate('Employee Directory',$MODULE)}</strong></span><span class="editTabName hide">
                                            <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                        </div>
                                </a>
                            </li>
                            <li class="{if $TAB_TYPE eq 'MD'}active {/if} employeeTab" data-tabname="My Department">
                                <a href="index.php?module=Users&parent=Settings&view=List&block=1&fieldid=1&tabtype=MD" class="">
                                        <div><span class="name textOverflowEllipsis" value="Tasks" style="width:10%">
                                            <strong>{vtranslate('My Department',$MODULE)}</strong></span><span class="editTabName hide">
                                            <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                        </div>
                                </a>
                            </li>
                            <li class="{if $TAB_TYPE eq 'WAI'}active {/if} employeeTab" data-tabname="Where am i">
                                <a href="index.php?module=Users&parent=Settings&view=List&block=1&fieldid=1&tabtype=WAI">
                                    <div>
                                        <span class="name textOverflowEllipsis" value="Employees" style="width:10%">
                                            <strong>{vtranslate('Where am i',$MODULE)}</strong>
                                        </span>
                                        <span class="editTabName hide"><input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                    </div>
                                </a>
                           </li>
                   </div>
            <div class="clearfix" style="height:20px;"></div>
            <div class="row">
                <div class="col-lg-6" style="float: left;">
                    <strong>
                        {vtranslate('YOU_ARE_CURRENLY_VIEWING',$MODULE)} "Soft Solvers Solutions"
                    </strong>
                </div>                 
                <div class="col-lg-6">
                    <div class="btn-group list-switcher" role="group" aria-label="Basic example">
                        <button type="button" class="empview btn {if $EMP_VIEW eq 'List'} btn-primary activeview {else}btn-white view{/if}" data-tabtype="{$TAB_TYPE}" data-listtype='list' title="List View"><i class='fa fa-list'></i> {vtranslate('List View', $MODULE)}</button>
                        <button type="button"  class="empview btn {if $EMP_VIEW eq 'grid'} btn-primary activeview {else}btn-white view{/if}"  data-tabtype="{$TAB_TYPE}" data-listtype='grid' title="Grid View"> <i class="fa fa-th-large"></i> {vtranslate('Grid View', $MODULE)}</button>
                    </div>
       
             <form class='form-inline pull-right'>
                 <div class='form-group'>
                     <input type="text" id="keywordsearch" placeholder="{vtranslate('Enter Keyword',$MODULE)}" class="form-control">
                 </div>
                 <div class="form-group">
                     <button type="button" class='btn btn-primary keyword-search'> Search   </button>
                 </div>
             </form>
         </div>
            </div>
                 <div class="clearfix"></div>
        
<div class="clearfix"></div>
           <div class="list-content">
               
{/strip}

{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}

    
    <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 81% !important; " title="Left Panel Show/Hide">
        <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
    </button>
    
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
<input type="hidden" value="{$DEPT}" id="curdepartment" />
    <div class="listViewPageDiv" id="listViewContent" style="padding:10px; width: 100%">
        <!--id="listViewContent"-->
        <div class="col-sm-12 col-xs-12 col-md-12 full-height">

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
                        <li class="{if $TAB_TYPE eq 'MD'} active {/if} employeeTab" data-tabname="My Department">
                            <a href='index.php?module=Users&view=List&block=15&fieldid=53&tabtype=MD&parent=Settings&search_params=[[["department","e","{$DEPT}"]]]' class="">
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
                                        <strong>{vtranslate('Where am I',$MODULE)}</strong>
                                    </span>
                                    <span class="editTabName hide"><input name="tabName" type="text"></span></i>
                                </div>
                            </a>
                       </li>
               </div>
        <div class="clearfix" style="height:20px;"></div>
        {if $TAB_TYPE neq 'WAI'}
        <div class="row">
                           
            <div class="col-lg-9">
                
                    <div class='form-group  col-lg-7' style="padding:0">
                        <input type="text" id="keywordsearch" placeholder="{vtranslate('Search for Name, Designation, Email, Department',$MODULE)} " class="form-control" style="width:100%;">
                    </div>
                    <div class="form-group  col-lg-1" style="padding:0;">
                        <button type="button" class='btn btn-primary keyword-search' style="padding: 5px 12px; margin-left: 5px;"> Search </button>
                    </div>
                
                              
            </div>
            <div class="col-lg-3">
                  <div class="btn-group list-switcher pull-right" role="group" aria-label="Basic example">
                    <button type="button" class="empview btn {if $EMP_VIEW eq 'List'} btn-primary activeview {else}btn-white view{/if}" data-tabtype="{$TAB_TYPE}" data-listtype='list' title="List View"><i class='fa fa-list'></i> </button>
                    <button type="button"  class="empview btn {if $EMP_VIEW eq 'grid'} btn-primary activeview {else}btn-white view{/if}"  data-tabtype="{$TAB_TYPE}" data-listtype='grid' title="Grid View"> <i class="fa fa-th-large"></i> </button>
                </div>
          {*      <select class="select2 grid-filter pull-left" style="width: 60%;">
                    <option value=""> {vtranslate('Filter by',$MODULE)}</option>
                    <option value="all">All</option>
                    <option value="N"> {vtranslate('New Joinees',$MODULE)}</option>
                    <option value="B"> {vtranslate('Bithdays',$MODULE)} </option>
                    <option value="MALE"> {vtranslate('Male Employee',$MODULE)} </option>
                    <option value="FEMALE"> {vtranslate('Female Employee',$MODULE)} </option>
                </select>
              *}
            </div>
                <div class="clearfix"></div>
        </div>
         {/if}    

             <div class="clearfix"></div>

<div class="clearfix"></div>
       <div class="list-content">

{/strip}

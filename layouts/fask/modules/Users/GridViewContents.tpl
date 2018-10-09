
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
<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
<input type='hidden' value="{$PAGING_MODEL->getPageLimit()}" id='pageLimit'>
<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">


{if $EMP_VIEW eq 'grid'}
    {assign var =LIST value = 'btn-white'}
    {assign var =GRID value = 'btn-primary'}

{else}
        {assign var =LIST value = 'btn-primary'}
    {assign var =GRID value = 'btn-white'}
{/if}
<div class="clearfix" style="height:20px;"></div>
<div class="row">
  <div class="col-lg-6" style="float: left;">
     <strong>
     {vtranslate('YOU_ARE_CURRENLY_VIEWING',$MODULE)} "Soft Solvers Solutions"
     </strong>
  </div>
 
</div>
    <div class="col-lg-6 pull-right">

      <div class="btn-group list-switcher" role="group" aria-label="Basic example">
          <button type="button" onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('List','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn {if $EMP_VIEW eq 'List'} btn-primary activeview {else}btn-white view{/if}" data-listType='List' title="List View"><i class='fa fa-list'></i> {vtranslate('List View', $MODULE)}</button>
          <button type="button"  onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('grid','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn {if $EMP_VIEW eq 'grid'} btn-primary activeview {else}btn-white view{/if}" data-listType='Grid' title="Grid View"> <i class="fa fa-th-large"></i> {vtranslate('Grid View', $MODULE)}</button>
      </div>
   
      <form class='form-inline pull-right'>
          <div class='form-group'>
              <input type="text" placeholder="{vtranslate('Enter Keyword',$MODULE)}" class="form-control">
          </div>
          <div class="form-group">
              <button type="button" class='btn btn-primary'> Search   </button>
          </div>
      </form>
    </div>
    <div class="clearfix" style="height: 50px;"></div>
  
    
<!-- Alphabets -->
<div class="col-lg-10">
   {include file="ListViewAlphabet.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
</div>
<!--  Filter -->
<div class="col-lg-2 pull-right">
      <select class="select2 grid-filter form-control" style="width:240x !important;">
          <option value=""> {vtranslate('Filter by',$MODULE)}</option>
          <option value="N"> {vtranslate('New Joinees',$MODULE)}</option>
          <option value="B"> {vtranslate('Bithdays',$MODULE)} </option>
          <option value="G"> {vtranslate('Gender',$MODULE)} </option>
      </select>
  </div>

<div style="min-height:450px;">
   {if $EMP_VIEW eq 'grid'}
   {include file="GridBoxContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {else}
   {include file="ListViewContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {/if}   

</div>

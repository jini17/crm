
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

    
<!-- Alphabets -->
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
                  <div class="col-lg-3">
                      <select class="select2 gender">
                          
                      </select>
                  </div>
      </div>
<div style="min-height:450px;">
 {if $EMP_VIEW eq 'grid'}
   {include file="GridBoxContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {else}
   {include file="ListViewContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {/if}   

</div>

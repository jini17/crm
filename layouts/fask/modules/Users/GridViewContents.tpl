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
<input type='hidden' value="{$PAGE_NUMBER}" id='pageNumber'>
<input type='hidden' value="{$PAGING_MODEL->getPageLimit()}" id='pageLimit'>
<input type="hidden" value="{$LISTVIEW_ENTRIES_COUNT}" id="noOfEntries">
{assign var = ALPHABETS_LABEL value = vtranslate('LBL_ALPHABETS', 'Vtiger')}
{assign var = ALPHABETS value = ','|explode:$ALPHABETS_LABEL}
{*
<pre />
{$LISTVIEW_ENTRIES|print_r}*}
<div class="clearfix" style="height:20px;"></div>
<div class="row">
  <div class="col-lg-6" style="float: left;">
     <strong>
     {vtranslate('YOU_ARE_CURRENLY_VIEWING',$MODULE)} "Soft Solvers Solutions"
     </strong>
  </div>
  <div class="col-lg-6" style="float: right;">
     <div class="btn-group list-switcher" role="group" aria-label="Basic example" style="display: inline-block; margin-left: 20%;">
        <button type="button" onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('List','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn btn-primary" data-listType='List' title="List View"><i class='fa fa-list'></i> List View</button>
        <button type="button"  onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('grid','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn btn-danger" data-listType='Grid' title="Grid View"> <i class="fa fa-th-large"></i> Grid View</button>
     </div>
     <div style="display: inline-block;float: right;">
       <form class="form-inline" >
        <div class="form-group">
            <input type="text" placeholder="Enter Keyword" class="form-control">
        </div>
        <div class="form-group">
            <button type="button" class='btn btn-primary'> Search   </button>
        </div>
      </form>
     </div>
     
      
      
  </div>
</div>
<div class="clearfix" style="height: 50px;"></div>
<!-- Alphabets -->
<div class="col-lg-9">
   {include file="ListViewAlphabet.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
</div>
<!--  Filter -->
<div class="col-lg-3">
   <select class="select2 grid-filter form-control pull-right">
      <option value=""> Filter by</option>
      <option value="N"> New Joinees </option>
      <option value="B"> Bithdays </option>
      <option value="G"> Gender </option>
   </select>
</div>
<div style="min-height:450px;">
   {if $EMP_VIEW eq 'grid'}
   {include file="GridBoxContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {else}
   {include file="ListViewContents.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
   {/if}   
</div>
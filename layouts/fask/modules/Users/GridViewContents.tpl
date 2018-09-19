
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
{*<pre />
{$LISTVIEW_ENTRIES|print_r}*}
<div class="clearfix" style="height:20px;"></div>
<div class="col-lg-6">
      <strong>
        {vtranslate('YOU_ARE_CURRENLY_VIEWING',$MODULE)} "Soft Solvers Solutions"
    </strong>
</div>
    <div class="col-lg-6">
      <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-primary" title="List View"><i class='fa fa-list'></i> List View</button>
          <button type="button" class="btn btn-danger" title="Grid View"> <i class="fa fa-th-large"></i> Grid View</button>
      </div>
   
        <form class='form-inline pull-right'>
            <div class='form-group'>
                <input type="text" placeholder="Enter Keyword" class="form-control">
            </div>
            <div class="form-group">
                <button type="button" class='btn btn-primary'> Search </button>
            </div>
     </form>
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
    <div class="row">
        <div class="col-lg-12">
            {foreach  item=LISTVIEW_ENTRY from=$LISTVIEW_ENTRIES }
                    {assign var=birthday value=$LISTVIEW_ENTRY->getBirthdayWish($LISTVIEW_ENTRY->get('birthday'),$LISTVIEW_ENTRY->getId())}
                    
                <div class="col-lg-4"   data-id='{$LISTVIEW_ENTRY->getId()}' data-recordUrl='{$LISTVIEW_ENTRY->getDetailViewUrl()}' id="{$MODULE}_listView_row_{$smarty.foreach.listview.index+1}">

                           <div class="box-content {if $birthday } highlight-birthday{/if}">
                        <div class="img-holder">
                           {assign var=IMAGE_DETAILS value=$LISTVIEW_ENTRY->getImageDetails()}
                                {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
	                 {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                             <img width="120" height='120' class="img-circle"  style="display:block; margin:0 auto;"  src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                        {/if}

                                {/foreach}
                                {if $IMAGE_DETAILS[0]['id'] eq null}

                                    <img width="120" height='120' class="img-circle"  style="display:block; margin:0 auto;" src="{vimage_path('DefaultUserIcon.png')}">

                                {/if}
                        </div>
                        <div class="user-meta text-center">
                            <h4 class="username text-center">								
                                <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
                                            {$LISTVIEW_ENTRY->get('last_name')}
                                </a>
                            </h4>
                                <div class="designation_label designation">
                                     {$LISTVIEW_ENTRY->get('title')}
                                </div>   
                                <div class="email-address">  {$LISTVIEW_ENTRY->get('email1')}</div>
                                   
                        </div>
                        <div class='user-social text-center'>
                            <a class='facebook' href="#"><i class='fa fa-facebook'></i></a>
                            <a class='twitter' href="#"><i class='fa fa-twitter'></i></a>
                            <a  class='linkedin' href="#"><i class='fa fa-linkedin'></i></a>
                        </div>
                        <div class='clearfix'></div>
                        {assign var = BIRTHDAY value =$LISTVIEW_ENTRY->get('birthday')}
                           {php}
                                
                            {/php}
                        <div class='birthdaybox text-center'>{$birthday}</div>
                    </div>
                             <div class="clearfix"></div>
                            </div>
               
            
                
                {/foreach}
        </div>
        
    </div>
    

</div>


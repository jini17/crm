
<style>
    .alphabetSearch a{
        color: #307fe8;
        font-weight: bold;
    }
    .box-content{
      padding:20px 10px;
      border: 1px solid #ddd;
      background: #fff;
        min-height: 391px;
        margin-top: 20px;
        margin-bottom: 9px;
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


.fa-facebook {
  background: #3B5998;
  color: white;
  padding: 10px;
}.fa-twitter {
  background: #55ACEE;
  color: white;
  padding: 10px;
}
.fa-envelope {
  background: #ff6600;
  color: white;
  padding: 10px;
}

 .img-holder{

    width: 122px;
    height: 122px;
    margin: 0 auto !important;

  
 }
.img-circle{
      background: #fff;
    -moz-border-radius: 50%;
    -webkit-border-radius: 50%;
    margin: 3px 4px !important;
}

.fa-linkedin {
  background: #007bb5;
  color: white;
  padding: 10px;
}
    .birthdaybox{
        margin-top: 30px;
    }
    .highlight-birthday{
       background: #d1e3fa;   
      }
      .img-circle{
          padding:3px;
          border:1px solid #ccc;  
          background-color: #fff;
          margin:0 auto !important;
          display:block;
      }
      .email-icon i{
          color: #333;
      }
</style>

{*<pre />
{$LISTVIEW_ENTRIES|print_r}*}

<div style="min-height:450px;">

   <div class="row">
       <div class="col-lg-12" style="padding:0;">
            {foreach  item=LISTVIEW_ENTRY from=$LISTVIEW_ENTRIES }
                    {assign var=birthday value=$LISTVIEW_ENTRY->getBirthdayWish($LISTVIEW_ENTRY->get('birthday'),$LISTVIEW_ENTRY->getId(),'grid')}
                     {assign var=joinee value=$LISTVIEW_ENTRY->getNewJoinee($LISTVIEW_ENTRY->get('date_joined'),$LISTVIEW_ENTRY->getId(),'grid')}
                <div class="col-lg-3"   data-id='{$LISTVIEW_ENTRY->getId()}' data-recordUrl='{$LISTVIEW_ENTRY->getDetailViewUrl()}' id="{$MODULE}_listView_row_{$smarty.foreach.listview.index+1}">

                           <div class="box-content {if $birthday } highlight-birthday{/if}">
                        <div class="img-holder">
                           {assign var=IMAGE_DETAILS value=$LISTVIEW_ENTRY->getImageDetails()}
                                {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
	                 {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                             <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
                                 <img width="110" height='110' class="img-circle"  style="display:block; margin:0 auto;"  src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                 </a>   
                                       {/if}

                                {/foreach}
                                        {if $IMAGE_DETAILS[0]['id'] eq null}
                                            <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
                                            <img width="110" height='110' class="img-circle"  style="display:block; margin:0 auto;" src="{vimage_path('DefaultUserIcon.png')}">
                                            </a>
                                        {/if}
                        </div>
                        <div class="user-meta text-center">
                            <h4 class="username text-center">								
                                <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
                                    <strong>    {$LISTVIEW_ENTRY->get('first_name')}</strong>
                                </a>
                            </h4>
                                <div class="designation_label designation">
                                    {assign var=designation value=$LISTVIEW_ENTRY->getDepartmetByemployeeID($LISTVIEW_ENTRY->get('id'))}
                                      {if $designation neq '0'} {$designation} {/if}
                                </div>
                            <div class="designation_label designation">
                                {assign var=department value=$LISTVIEW_ENTRY->getDesignationByEmployeeID($LISTVIEW_ENTRY->get('id'))}
                                {if $department neq '0'} {$department} {/if}
                            </div>
                            <div class="email-address">  {$LISTVIEW_ENTRY->get('email1')}</div>
                                   
                        </div>
                                
                        <div class='user-social text-center'>
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="{$LISTVIEW_ENTRY->get('twitter')}" class="fa fa-twitter"></a>
                            <a href="{$LISTVIEW_ENTRY->get('linkedin')}" class="fa fa-linkedin"></a>
                            <a href="#" onclick="javascript:Settings_Users_List_Js.birthdayEmail({$LISTVIEW_ENTRY->getId()})" class="fa fa-envelope"></a>
                        </div>
                        <div class='clearfix'></div>
                        <div class='birthdaybox text-center'>{$birthday}</div>
                        <div class="clearfix"></div>
                        <small >{$joinee}</small>
                    </div>
                             <div class="clearfix"></div>
                            </div>
               
            
                
                {/foreach}
     {if $LISTVIEW_ENTRIES_COUNT eq '0'}
            <table>
                <tr class="emptyRecordsDiv">
                        {assign var=COLSPAN_WIDTH value={count($LISTVIEW_HEADERS)}}
                        <td colspan="{$COLSPAN_WIDTH}">
                                <div class="emptyRecordsContent">
                                        <center>
                                                {if $SEARCH_VALUE eq 'Active'}
                                                        {assign var=SINGLE_MODULE value="SINGLE_$MODULE"}
                                                        {vtranslate('LBL_NO')} {vtranslate($MODULE, $MODULE)}
                                                        {vtranslate('LBL_FOUND')},{if $IS_MODULE_EDITABLE} 
                                                            <a style="color:blue" href="{$MODULE_MODEL->getCreateRecordUrl()}">
                                                                {vtranslate('LBL_CREATE_USER',$MODULE)}
                                                            </a>
                                                        {/if}
                                                {else}
                                                        {vtranslate('LBL_NO')} {vtranslate($MODULE, $MODULE)} {vtranslate('LBL_FOUND')}
                                                {/if}
                                        </center>
                                </div>
                        </td>
                </tr>
            </table>
      {/if}
        </div>
               
                <div class="clearfix"></div>
    </div>
                <!-- Employee Pagination -->
                <div class="col-md-12  text-center">
                    {$PAGINATION}
                </div>
  </div>


<style>
    .alphabetSearch a{
        color: #307fe8;
        font-weight: bold;
    }
    .box-content{
      padding:20px 10px;
      border: 1px solid #ddd;
      background: #fff;
      min-height: 360px;
      margin-top: 20px;
      margin-bottom: 20px;
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
       border-radius: 50%;
       border:3px solid #ccc;    
       width: 122px;
       height: 122px;
       margin: 0 auto;
       box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    background: #fff;
 
    margin: 0 auto;

       overflow: hidden;
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
      background-color: #fff;
      }
      .email-icon i{
          color: #333;
      }
</style>

{*<pre />
{$LISTVIEW_ENTRIES|print_r}*}

<div style="min-height:450px;">
 
   <div class="row">
        <div class="col-lg-12">
            {foreach  item=LISTVIEW_ENTRY from=$LISTVIEW_ENTRIES }
                    {assign var=birthday value=$LISTVIEW_ENTRY->getBirthdayWish($LISTVIEW_ENTRY->get('birthday'),$LISTVIEW_ENTRY->getId())}
                    
                <div class="col-lg-3"   data-id='{$LISTVIEW_ENTRY->getId()}' data-recordUrl='{$LISTVIEW_ENTRY->getDetailViewUrl()}' id="{$MODULE}_listView_row_{$smarty.foreach.listview.index+1}">

                           <div class="box-content {if $birthday } highlight-birthday{/if}">
                        <div class="img-holder">
                           {assign var=IMAGE_DETAILS value=$LISTVIEW_ENTRY->getImageDetails()}
                                {foreach item=IMAGE_INFO from=$IMAGE_DETAILS}
	                 {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                             <img width="110" height='110' class="img-circle"  style="display:block; margin:0 auto;"  src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}">
                                        {/if}

                                {/foreach}
                                {if $IMAGE_DETAILS[0]['id'] eq null}

                                    <img width="110" height='110' class="img-circle"  style="display:block; margin:0 auto;" src="{vimage_path('DefaultUserIcon.png')}">

                                {/if}
                        </div>
                        <div class="user-meta text-center">
                            <h4 class="username text-center">								
                                <a href="{$LISTVIEW_ENTRY->getDetailViewUrl()}">
                                    <strong>    {$LISTVIEW_ENTRY->get('first_name')}</strong>
                                </a>
                            </h4>
                                <div class="designation_label designation">
                                      {$LISTVIEW_ENTRY->get('title')}
                                </div>   
                                <div class="email-address">  {$LISTVIEW_ENTRY->get('email1')}</div>
                                   
                        </div>
                        <div class='user-social text-center'>
                            <a href="#" class="fa fa-facebook"></a>
                            <a href="#" class="fa fa-twitter"></a>
                            <a href="#" class="fa fa-linkedin"></a>
                            <a href="#" onclick="javascript:Settings_Users_List_Js.birthdayEmail({$LISTVIEW_ENTRY->getId()})" class="fa fa-envelope"></a>
                            
                        </div>
                        <div class='clearfix'></div>
                        <div class='birthdaybox text-center'>{$birthday}</div>
                    </div>
                             <div class="clearfix"></div>
                            </div>
               
            
                
                {/foreach}
     
        </div>
        
    </div>
    
</div>


<style>
    .fa-facebook {
        background: #3B5998;
        color: #fff;
        padding: 8px;
    }

    .fa-twitter {
        background: #55ACEE;
        color: #fff;
        padding: 10px;
    }

.tree{
    width: 818px;
    margin: 0 auto;
}
    .fa-linkedin {
        background: #007bb5;
        color: #fff;
        padding: 8px;
    }
  .tree li .box{
        height: auto;
    }
    .new-line li:first-child:nth-last-child(1) {
        /* -or- li:only-child { */
        width: 100%;
    }

    /* two items */
   .new-line li:first-child:nth-last-child(2),
   .new-line li:first-child:nth-last-child(2) ~ li {
        width: 50%;
    }

    /* three items */
    .new-line li:first-child:nth-last-child(3),
    .new-line li:first-child:nth-last-child(3) ~ li {
        width: 33.3333%;
    }
    .new-line{
        margin-top: 150px;
    }
    .new-line::before{
        height: 192px !important;
        top: -170px !important;
    }
    .social-links a i{
        font-size: 10px;
        padding: 5px;
    }
    .fa-envelope{
background: #ff6600;
    border: 1px solid #fff;
    color: #fff;
    font-size: 10px !important;
    padding: 5px 5px !important;
    padding-top: 55px;
    line-height: 1;


    }
</style>
{assign var=width value=COUNT($DEPARTMENT_EMPLOYEES)}

<div class="tree" {if $width lt 5} style="width:{300*$width}px;  height: 700px; overflow-y: scroll" {else}style="width:100%; height: 700px; overflow: scroll;"{/if}>

    <ul>
     
        <li>
           
            {if $REPORTING_MANAGER neq '0'}
            <div href="#" class="box">
                <div class="orgbox">
                    <div class="img-holder">
                        <img width="70" height="70" class="img-circle"  src="{$REPORTING_MANAGER['image'][0]['path']}_{$REPORTING_MANAGER['image'][0]['name']}"/>
                      
                    </div>
                    <div class="orgbox-details text-left">
                        <h5 style="margin-top: 2px;font-size: 14px;margin-bottom: 2px;font-weight: bold;">
                            <a href="index.php?module=Users&parent=Settings&view=Detail&record={$REPORTING_MANAGER['id']}">
                                {$REPORTING_MANAGER['full_name']} 
                            </a>
                        </h5>
                        <div class='clearfix'></div>
                        <small style='font-size:14px;'>  {$REPORTING_MANAGER['department'] } </small>
                        <div class="clearfix"></div>
                         <small style='font-size:14px;'>  {$REPORTING_MANAGER['designation'] } </small>
                        <div class="clearfix"></div>
                        <small style='font-size:14px; word-wrap: break-word;'> {$REPORTING_MANAGER['email'] } </small>          
                         <div class="clearfix"></div>
                            <div class="social-links text-right">
                                <a href="{$REPORTING_MANAGER['facebook']}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{$REPORTING_MANAGER['twitter']}"><i class="fab fa-twitter"></i></a>
                                <a href="{$REPORTING_MANAGER['linkedin']}"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"
                                   onclick="javascript:Vtiger_Helper_Js.getInternalMailer({$REPORTING_MANAGER['emp_id']},'email','Users');"
                                   class=""><i class="far fa-envelope"></i></a>
                            </div>
                    </div>
                   
                    <div class="clearfix"></div>
                    <div class="org-datejoined">
                        {if $REPORTING_MANAGER['joindate'] gt 0 AND $REPORTING_MANAGER['joindate'] lte 30}
                            <strong><i class="far fa-clock"></i> {vtranslate('LBL_JOINED','Users')}  {$REPORTING_MANAGER['joindate']} {vtranslate('LBL_DAYS_AGO','Users')}</strong>
                        {/if}
                    </div>
                    <div class="clearfix"></div>
                        <div class="orgbirthdaybox">
                            {$REPORTING_MANAGER['birthday']}
                        </div>
                            <div class="clearfix"></div>
                </div>
            </div>
            {/if}
            <!-- MY DETAILS -->
            <ul>
                <li>
                    <div href="#" class="box">
                        <div class="orgbox">
                            <div class="img-holder">
                                <img width="70" height="70"
                                     class="img-circle"
                                     src="{$MY_DETAILS['image'][0]['path']}_{$MY_DETAILS['image'][0]['name']}"/>
                            </div>
                            <div class="orgbox-details text-left">
                                <h5 style="margin-top: 2px;font-size: 14px;margin-bottom: 2px;font-weight: bold;"><a href="index.php?module=Users&parent=Settings&view=Detail&record={$MY_DETAILS['id']}">{$MY_DETAILS['fullname']}</a></h5>
                                <div class='clearfix'></div>
                                 <small style='font-size:14px; word-wrap: break-word;'> {$MY_DETAILS['department'] } </small>
                                <div class="clearfix"></div>
                                <small style='font-size:14px; word-wrap: break-word;'> {$MY_DETAILS['designation'] } </small>
                                <div class="clearfix"></div>
                                <small style='font-size:14px; word-wrap: break-word;'> {$MY_DETAILS['email'] } </small>
                                <div class="clearfix"></div>
                            <div class="social-links text-right">
                                <a href="{$MY_DETAILS['facebook']}"><i class="fab fa-facebook-f"></i></a>
                                <a href="{$MY_DETAILS['twitter']}"><i class="fab fa-twitter"></i></a>
                                <a href="{$MY_DETAILS['linkedin']}"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"
                                   onclick="javascript:Vtiger_Helper_Js.getInternalMailer({$MY_DETAILS['emp_id']},'email','Users');"><i
                                            class="far fa-envelope"></i></a>
                            </div>
                            </div>
                            
                            <div class="clearfix"></div>
                                <div class="orgbirthdaybox">
                                    {$MY_DETAILS['birthday']}
                                </div>
                                  <div class="clearfix"></div>
                                <div class="org-datejoined">
                                    {if $emp['joindate'] gt 0 AND $emp['joindate'] lte 30}
                                        <strong> <i class="far fa-clock"></i> {vtranslate('LBL_JOINED','Users')}  {$emp['joindate']} {vtranslate('LBL_DAYS_AGO','Users')}</strong>
                                    {/if}
                                </div>
                                  <div class="clearfix"></div>
                        </div>
                    </div>
                    {assign var=counter value=0}
                    <ul {counter}>
                    {foreach item=emp key=i from=$DEPARTMENT_EMPLOYEES}
                        {assign var=counter value=$counter+1}


                    {if $counter % 4 eq  1 AND $counter neq 1}
                        </ul>

                        <div class="clearfix" style="height: 20px"></div>

                        <ul class="new-line"{$counter}>

                        {/if}
                <li>
                    <div href="#" class="box">
                        <div class="orgbox">
                            <div class="img-holder">
                                <img width="70" height="70"
                                     class="img-circle" src="{$emp['image'][0]['path']}_{$emp['image'][0]['name']}"/>
                            
                            </div>

                            <div class="orgbox-details text-left">
                                <h5 style="margin-top: 2px;font-size: 14px;margin-bottom: 2px;font-weight: bold;"><a href="index.php?module=Users&parent=Settings&view=Detail&record={$emp['id']}">{$emp['full_name']}</a></h5>
                                <div class='clearfix'></div>
                                 <small style='font-size:14px; word-wrap: break-word;'>  {$emp['department'] } </small>
                                <div class="clearfix"></div>
                                <small style='font-size:14px; word-wrap: break-word;'>  {$emp['designation'] } </small>
                                <div class="clearfix"></div>
                                 <small style='font-size:14px; word-wrap: break-word;'> {$emp['email'] } </small>
                                
                                 <div class="clearfix"></div>
                            <div class="social-links text-right">
                                <a href="{$emp['facebook']}"> <i class="fab fa-facebook-f"></i> </a>
                                <a href="{$emp['twitter']}"> <i class="fab fa-twitter"></i> </a>
                                <a href="{$emp['linkedin']}"> <i class="fab fa-linkedin-in"></i> </a>
                                <a href="#"
                                   onclick="javascript:Vtiger_Helper_Js.getInternalMailer({$emp['id']},'email','Users');">
                                    <i   class="far fa-envelope"></i>
                                </a>
                            </div>
                            </div>
                                    <div class="clearfix"></div>
                                    <div class="orgbirthdaybox">
                                    {$emp['birthday']}
                                </div>
                                <div class="clearfix"></div>
                                <div class="org-datejoined">
                                    {if $emp['joindate'] gt 0 AND $emp['joindate'] lte 30}
                                        <strong> {vtranslate('LBL_JOINED','Users')}  {$emp['joindate']} {vtranslate('LBL_DAYS_AGO','Users')}</strong>
                                    {/if}
                                </div>
                                          <div class="clearfix"></div>
                        </div>
                    </div>
                </li>

            {/foreach}

            </ul>
        </li>
    </ul>
    </li>
    </ul>
</div>
            <div class="clearfix" style="height: 50"></div>
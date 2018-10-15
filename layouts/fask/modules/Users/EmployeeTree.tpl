
    
<div class="tree" >
   
    <ul>
                <li>
                    <div href="#" class="box">
                        <div class="orgbox">
                            <div class="img-holder">
                                <img width="90" height="90"  class="img-circle" src="{$REPORTING_MANAGER['image'][0]['path']}_{$REPORTING_MANAGER['image'][0]['name']}" />
                            </div>     
                            <div class="orgbox-details">
                                <h5>{$REPORTING_MANAGER['full_name']}</h5>
                                <div class='clearfix'></div>
                                <small> {$REPORTING_MANAGER['department'] } </small>
                                <div class="clearfix"></div>
                                 <small> {$REPORTING_MANAGER['email'] } </small>
                                <div class="orgbirthdaybox">
                                    {$REPORTING_MANAGER['birthday'] }
                                </div>
                             </div>
                             <div class="clearfix"></div>
                            <div class="social-links text-right">
                                <a href="{$REPORTING_MANAGER['facebook']}"> <i class="fa fa-facebook"></i> </a>
                                <a href="{$REPORTING_MANAGER['twitter']}"> <i class="fa fa-twitter"></i> </a>
                                <a href="{$REPORTING_MANAGER['linkedin']}"> <i class="fa fa-linkedin"></i> </a>
                            </div>
                           
                        </div>
                    </div>
                            <!-- MY DETAILS -->
                        <ul>
                                <li>
                                        <div href="#" class="box">
                                            <div class="orgbox">
                                                <div class="img-holder">
                                                    <img width="90" height="90" 
                                                         class="img-circle" src="{$MY_DETAILS['image'][0]['path']}_{$MY_DETAILS['image'][0]['name']}" />
                                                </div>     
                                                <div class="orgbox-details">
                                                    <h5>{$MY_DETAILS['fullname']}</h5>
                                                    <div class='clearfix'></div>
                                                    <small> {$MY_DETAILS['department'] } </small>
                                                    <div class="clearfix"></div>
                                                     <small> {$MY_DETAILS['email'] } </small>
                                                    <div class="orgbirthdaybox">
                                                        {$MY_DETAILS['birthday'] }
                                                    </div>
                                                 </div>
                                                <div class="clearfix"></div>
                                                <div class="social-links text-right">
                                                    <a href="{$MY_DETAILS['facebook']}"> <i class="fa fa-facebook"></i> </a>
                                                    <a href="{$MY_DETAILS['twitter']}"> <i class="fa fa-twitter"></i> </a>
                                                    <a href="{$MY_DETAILS['linkedin']}"> <i class="fa fa-linkedin"></i> </a>
                                                </div>

                                            </div>
                                    </div>
                        <ul>
                        
                              {foreach item=emp key=i from=$DEPARTMENT_EMPLOYEES}
                                    <li>
                                            <div href="#" class="box">
                                                    <div class="orgbox">
                                                        <div class="img-holder">
                                                            <img width="90" height="90" 
                                                                 class="img-circle" src="{$emp['image'][0]['path']}_{$emp['image'][0]['name']}" />
                                                        </div>     
                                                        
                                                        <div class="orgbox-details">
                                                            <h5>{$emp['full_name']}</h5>
                                                            <div class='clearfix'></div>
                                                            <small> {$emp['department'] } </small>
                                                            <div class="clearfix"></div>
                                                             <small> {$emp['email'] } </small>
                                                            <div class="orgbirthdaybox">
                                                                {$emp['birthday'] }
                                                            </div>
                                                         </div>
                                                            <div class="clearfix"></div>
                                                        <div class="social-links text-right">
                                                            <a href="{$emp['facebook']}"> <i class="fa fa-facebook"></i> </a>
                                                            <a href="{$emp['twitter']}"> <i class="fa fa-twitter"></i> </a>
                                                            <a href="{$emp['linkedin']}"> <i class="fa fa-linkedin"></i> </a>
                                                        </div>
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
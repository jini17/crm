
<div class='col-xs-12 
     {if $smarty.get.module eq 'Users'}
         {if $smarty.get.view eq 'List'}
             
          {else}
              hide
           {/if}   
      {else}
          hide
      {/if}'>
        <h4> Filter </h4>
        <!-- Latest compiled and minified Bootstrap CSS -->
        <div class="panel-group panel-filter" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseOne">
                            Gender <i class="fa fa-minus pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <ul class='gender list-unstyled'>
                            <li><input type="checkbox" name="gender" value="Male"/>&nbsp;Male</li>
                            <li><input type="checkbox" name="gender" value="Female"/> Female</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwo">
                            Birthday <i class="fa fa-plus pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class='gender list-unstyled'>
                            <li><input type="checkbox" name="birthday" value="thisweek">&nbsp;This Week</li>
                            <li><input type="checkbox" name="birthday" value="thismonth"/> This Month</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseThree">
                            Department<i class="fa fa-plus pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class='department list-unstyled'>
                       
                            {foreach item=DEPT from=$DEPT_LIST}
                                <li><input type="checkbox" name="department" value="{$DEPT}"/> {$DEPT}</li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFour">
                            New Joinee <i class="fa fa-plus pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class='gender list-unstyled'>
                            <li><input type="checkbox" name="date_joined" value="thisweek">&nbsp;This Week</li>
                            <li><input type="checkbox" name="date_joined" value="thismonth"/> &nbsp;This Month
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
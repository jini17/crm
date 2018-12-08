 
<div class="contents" style="margin:10px;padding:10px !important;">
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <h4>{vtranslate('Employee Leave Status', $MODULE)}</h4>
    <div class="pull-right">
      <!--<span>{vtranslate('Above no of leaves would not be carry farward, Still do you want to continue? ',$MODULE)}</span>-->
      <input class=" btn btn-primary" type="button" name="continue" onclick="Settings_Vtiger_Allocation_Js.registerExecuteYND();" value="Year End Process">
    </div>
    <div class="clearfix"></div>
    
    <table class="table table-bordered table-striped">
      <tr>
        <td>{vtranslate('Grade',$MODULE)}</td>
        <td>Employee Name</td>
        <td>Leave Type</td>
        <td class="btn-primary text-white text-center" colspan="3">Leave Allocation</td>
        <td colspan="2">Status</td>
        <td rowspan="2">
          <button class="btn-primary" style="padding: 7px; margin-top: 16px;">Search</button>
        </td>  
      </tr>  
      <tr>
        <td>
          <select class="select2 full-width">
            {foreach from=$Grades item=grade key=gradeid}
              <option value="{$gradeid}">{$grade}</option>  
            {/foreach}
          </select>
        </td>
        <td>
          <select class="select2 full-width">
             {foreach from=$UsersList item=employee key=userid}
             <option value="{$userid}">{$employee->first_name}&nbsp;{$employee->last_name}</option>  
            {/foreach}
          </select>
        </td>
        <td>
          <select class="select2 full-width">
           {foreach from=$LEAVETYPES item=leavetype}
            <option value="{$leavetype['leavetypeid']}">{$leavetype['title']}</option>  
            {/foreach}
          </select>
        </td>
        <td> Allocated </td>  
        <td> Used </td>  
        <td> Balanced </td>  
        <td><input type="checkbox" name="forfit" /> Forfeit</td>
      </tr>  
      {if $USERS_LEAVESTATUS neq 0}
        {foreach from=$USERS_LEAVESTATUS item=UserLeave}
        <tr>
            <td>{$UserLeave['Grade']}</td>
            <td>{$UserLeave['Username']}</td>
            <td>{$UserLeave['LeaveType']}</td>
            <td>{$UserLeave['Allocation']}</td>
            <td>{$UserLeave['Used']}</td>
            <td>{$UserLeave['Balance']}</td>
            <td colspan="3">{$UserLeave['Status']}</td>
        </tr>
       {/foreach}
      {else}
          <tr><td colspan="9">{vtranslate('No Allocation done', $MODULE)}</td></tr>
      {/if} 

    </table>  
  </div>
  </div>
</div>
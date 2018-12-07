<div>
  <div></div>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th class="btn-primary">
     &nbsp;
      </th>  
        <th colspan="3" class="btn-primary text-white text-center">{vtranslate('Annual Leave', $MODULE)}</th>    
    </tr>
    
       <tr>
      <th>
       {vtranslate('Employee Name', $MODULE)}
      </th>
       <th>{vtranslate('Allocated',$MODULE)}</th>
       <th>{vtranslate('Used',$MODULE)}</th>
       <th>{vtranslate('Carry Forward',$MODULE)}</th>
    </tr>  
    </thead>

  <tbody>
   {foreach from=$USERS_LEAVESTATUS item=UserLeave key=EMPNAME}
    <tr>
     <td>{$EMPNAME}</td>
     <td>{$UserLeave['Allocation']}</td>
     <td>{$UserLeave['Used']}</td>
     <td>{$UserLeave['Carry Forward']}</td>
   </tr>
   {/foreach}
  </tbody>  
</table>  

  <div>
      <span>{vtranslate('Above no of leaves would not be carry farward, Still do you want to continue? ',$MODULE)}</span>
      <input class=" btn btn-primary pull-right" type="button" name="continue" onclick="Settings_Vtiger_Allocation_Js.registerExecuteYND();" value="Continue">
  </div>
  <div class="clearfix"></div>
</div>
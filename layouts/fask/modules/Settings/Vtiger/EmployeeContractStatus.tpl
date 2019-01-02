<div>
<table class="table table-bordered table-striped">
  <thead>
    <tr>
        <th colspan="4" class="btn-primary text-white text-center">{vtranslate('Below list either don\'t have contract or expired!!', $MODULE)}</th>    
    </tr>
    
       <tr>
      <th colspan="4">
       {vtranslate('Employee List', $MODULE)}
      </th>
    </tr>  
    </thead>
  <tbody>
    <tr>
   {foreach from=$ContractStatus item=Employee key=k}
   {if $k%3 eq 0}
    </tr>
    <tr>
   {/if}
     <td>{$Employee['empname']} ({$Employee['department']})</td>
   {/foreach}
  </tbody>  
</table>  

  <div>
      <span>{vtranslate('No leave will assign to above employee, Still do you want to continue? ',$MODULE)}</span>
      <input class=" btn btn-primary pull-right" type="button" name="continue" onclick="Settings_Vtiger_Allocation_Js.registerExecuteYND();" value="Continue">
  </div>
  <div class="clearfix"></div>
</div>
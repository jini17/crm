<!--<div class="contents" style="    overflow: scroll;">
  <table class="table table-bordered table-condensed marginBottom50px" style="width: 100%;">
    <thead>
      <tr class="blockHeader">
        <th>{vtranslate('Employee Name', $MODULE)}</th>
        {foreach from=$LEAVETYPES item=LEAVETYPE}
             <th >{$LEAVETYPE['title']}</th>
        {/foreach}
        <th nowrap="nowrap">Advanced Sharing Rules</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>      
-->
<table class="table table-bordered ">
  <thead>
    <tr>
      <th rowspan="2">
        <td>Employee Name</td>
      </th>  
      <th  colspan="3">Medical Leave</th>    
      <th colspan="3"> Annual</th>  
      <th colspan="3"> Study Leave </th>  
    </tr>
   
  </thead>
  <head>
     <tr>
      <td></td>
      <td>&Allocation;</td>
      <td>Allocation</td>
      <td>Used</td>
      <td>Carry Forward?</td>
    </tr>  
  </head>
  <tbody>
  <tbody>  
  
</table>  
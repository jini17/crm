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
  <tr><td colspan="9" class="text-center">{vtranslate('No Allocation Found!!', $MODULE)}</td></tr>
{/if} 
{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 03/04/2018
 ************************************************************************************}
{* modules/Settings/UserPlan/views/Index.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}

{strip}
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" media="screen" />

<div class="listViewPageDiv" id="plansettingcontainer">
    <div class="table-responsive col-md-8">
        <table class="table table-condensed sharingAccessDetails marginBottom50px" name="userTable" id="plan">
            <thead>
            <tr class="blockHeader">    
            <th>User Name</th>
            <th>Current Plan</th>
            <th>Role</th>
            <th>Action</th>
            </tr>
            </thead>
            <tbody>
                {foreach from=$USERS key=KEY item=USER}
                    <tr>
                    <td>{$USER.name}</td>
                    <td id="{$USER.id}" data-planid="{$USER.planid}">{$USER.plantitle}</td>
                    <td>{$USER.role}</td>
                    <td width="17%" align='center'><a class="editPlan cursorPointer" data-id="{$USER.id}" data-username="{$USER.name}" data-plantitle="{$USER.plantitle}" data-url="index.php?module=UserPlan&parent=Settings&view=UserPlanAjax"><i class="fa fa-edit" title="{vtranslate('LBL_EDIT', $MODULE)}" ></i></a></td>
                    </tr>
                    
                {/foreach}
            </tbody>
        </table>
    </div>
    <div class="table-responsive col-md-4" style="margin-top:36px;padding: 15px !important;">
        <table class="table table-condensed sharingAccessDetails marginBottom50px" name="planTable" id="userplantablesmall">
            <thead>
                <tr class="blockHeader" >    
                    <th colspan="4" style="padding: 11px 18px">
                    Plans    
                    </th>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Assign</td>
                    <td>Balance</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                {foreach from=$PLANS key=KEY item=PLAN}
                <tr>
                    {if $PLAN.plantitle != "Sales+Support"}
                    <td>
                             {if $PLAN.plantitle eq 'Foundation'}
                                {$PLAN.plantitle}<br />
                                <a href="index.php?module=Users&parent=Settings&view=Edit" style="color: #333 !important; border: 1px solid #979797;background: linear-gradient(to bottom, white 0%, #dcdcdc 100%);">Create User</a>
                             {else}
                                {$PLAN.plantitle}
                             {/if}   

                    </td>
                    <td id="users_{$PLAN.planid}">{$PLAN.users}</td>
                    <td>{$PLAN.nousers-$PLAN.users}</td>
                    <td>{$PLAN.nousers}</td>
                        {/if}
                </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
<script>
jQuery(document).ready( function () {
    jQuery('#plan').DataTable();    
});
</script>
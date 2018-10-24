
{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk Rashid Khan on 28/05/2018
 ************************************************************************************}

{strip}
<table class="table table-bordered table-condensed themeTableColor">
    <thead>
        <th>
            <span class="alignMiddle">{vtranslate('LBL_FROM_ADDRESS_SETTING', $QUALIFIED_MODULE)}</span>
        </th>
    </thead>
    <tbody>
        <tr>
            <td>
                Select
            </td>
            <td>
                Name
            </td>
            <td>
                Email Address
            </td>                        
        </tr>
        {foreach item=VALUE from=$DATA}
        <tr>
            <td>
                <input type="checkbox" name="selected_id" value="{$VALUE.id}" class="smallchkd">
            </td>
            <td>
                {$VALUE.name}
            </td>
            <td>
                {$VALUE.email}
            </td>                        
        </tr>
        {/foreach}
    </tbody>
</table>
{/strip}
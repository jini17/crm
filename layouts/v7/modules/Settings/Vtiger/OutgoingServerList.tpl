{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Nirbhay and Mabruk
************************************************************************************}
{strip}

    <div class="col-sm-12 col-xs-12 ">
    <div id="Head">
        <div class="widget_header row-fluid">
            <div class="span8"><h3>{vtranslate('LBL_OUTOGING SERVER', $QUALIFIED_MODULE)}</h3></div>
        </div>
        <hr>
        <br>
    </div>

    <div class="contents tabbable clearfix">
        <button class="btn btn-danger span10 marginLeftZero"  id="deleteItem">{vtranslate('LBL_DELETE_VALUE',$QUALIFIED_MODULE)}</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <button class="btn span10 marginLeftZero newButton" id="addItem">{vtranslate('LBL_ADD_VALUE',$QUALIFIED_MODULE)}</button> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <br><br>

        <div class="contents">
            <table class="table table-bordered table-condensed themeTableColor">
                <thead>
                <th class="{$WIDTHTYPE}">
                    <span class="alignMiddle">{vtranslate('LBL_OUTGOING_SERVER_SETTINGS', $QUALIFIED_MODULE)}</span>
                </th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Select
                        </td>
                        <td>
                            Show From Addresses
                        </td>
                        <td>
                            Host
                        </td>
                        <td>
                            Username
                        </td>
                        <td>
                            From Email
                        </td>
                        <td>
                            Is active
                        </td>
                        <td>
                            Is Default
                        </td>
                    </tr>
                    {foreach item=VALUE from=$DATA}
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_id" value="{$VALUE.id}" class="smallchkd">
                        </td>
                        <td>
                            <button class="showFromAddress btn span3 marginLeftZero newButton" id="showFromAddress" value="{$VALUE.id}">Show</button><br><br>
                        </td>
                        <td>
                            {$VALUE.server}
                        </td>
                        <td>
                            {$VALUE.server_username}
                        </td>
                        <td>
                            {$VALUE.from_email_field}
                        </td>
                        <td>
                            {$VALUE.isactive}
                        </td>
                        <td>
                            {$VALUE.isdefault}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    </div>
{/strip}
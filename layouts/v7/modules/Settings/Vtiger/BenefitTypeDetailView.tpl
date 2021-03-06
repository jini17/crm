{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Nirbhay
************************************************************************************}

{strip}
    <div id="body">
        <div class=" col-lg-12 col-md-12 col-sm-12">
            <div id="Head">
                <div class="widget_header row-fluid">
                    <div class="span8"><h3>Benefit Type</h3></div>
                </div>
                <hr>
                <br>
            </div>

            <div class="contents tabbable clearfix">
                <button class="btn btn-danger span10 marginLeftZero"  id="deleteItem">Delete</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn span10 marginLeftZero newButton" id="addItem">Add</button><br><br>
                <button class="btn span10 marginLeftZero newButton" id="editItem">Edit</button><br><br>
                <div class="contents">
                    <table class="table table-bordered table-condensed themeTableColor">
                        <thead>
                        <th class="{$WIDTHTYPE}">
                            <span class="alignMiddle">Benefit Types List</span>
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Select
                            </td>
                            <td>
                                Benefit Title
                            </td>
                            <td>
                                Benefit Code
                            </td>
                            <td>
                                Is Active
                            </td>
                        </tr>
                        {foreach item=SPLITVALUE from=$VALUES}
                            <tr>
                                {foreach key=key item=VALUE from=$SPLITVALUE}

                                    {if $key eq 'checkbox'}
                                        <td>
                                            <input type="checkbox" name="selected_id" value="{$VALUE}" class="smallchkd">
                                        </td>
                                    {else}
                                        <td>
                                            {$VALUE}
                                        </td>
                                    {/if}

                                {/foreach}
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
{/strip}
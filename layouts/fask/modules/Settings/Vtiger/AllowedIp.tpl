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
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 22px;
        }


        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 12px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #00AA88;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #00AA88;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 25px;
        }

        .slider.round:before {
            border-radius: 20%;
        }
    </style>
    <div id="body">
        <div class=" col-lg-12 col-md-12 col-sm-12">
            <div id="Head">
                <div class="widget_header row-fluid">
                    <div class="span8"><h3>IP Restriction</h3></div>
                </div>
                <hr>
                <br>
            </div>

            <div class="contents tabbable clearfix">
                <button class="btn btn-danger span10 marginLeftZero"  id="deleteItem">Delete</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn span10 marginLeftZero newButton" id="addItem">Add</button><br><br>
                <button class="btn span10 marginLeftZero newButton" id="editItem">Edit</button><br><br>
                <label class="switch">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="defaultvalue" {$DEFAULTVALUE} />
                    <span class="slider round"></span>
                </label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label id="Allowed">The IP's not mentioned in the List will be Allowed</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label id="NotAllowed">The IP's not mentioned in the List will be Not Allowed</label>

                <br><br>

                <div class="contents">
                    <table class="table table-bordered table-condensed themeTableColor">
                        <thead>
                            <th class="{$WIDTHTYPE}">
                                <span class="alignMiddle">IP Restriction Settings</span>
                            </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Select
                                </td>
                                <td>
                                    IP
                                </td>
                                <td>
                                    IP Restriction Type
                                </td>
                                <td>
                                    Type Of Restriction
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
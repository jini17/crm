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
            <div id="Head" style="position:relative;">
                  <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
                <div class="widget_header row-fluid">
                    <div class="span8"><h3>{vtranslate('Allocation', $MODULE)}</h3></div>
                </div>
                <hr>
                <br>
            </div>

            <div class="contents tabbable clearfix">
              
                    <div class="pull-right"><a class="btn btn-success" href="index.php?module=Vtiger&parent=Settings&view=BalanceLeave&mode=ShowBalanceLeave">{vtranslate('Employee Leave Status', $MODULE)}</a></div>
              
                <button class="btn btn-danger span10 marginLeftZero"  id="deleteItem">{vtranslate('Delete', $MODULE)}</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn span10 marginLeftZero newButton" id="addItem">{vtranslate('Add', $MODULE)}</button><br><br>
                <button class="btn span10 marginLeftZero newButton" id="editItem">{vtranslate('Edit', $MODULE)}</button><br><br>
                <div class="contents">
                    <table class="table table-bordered table-condensed themeTableColor">
                        <thead>
                        <th class="{$WIDTHTYPE}">
                            <span class="alignMiddle">{vtranslate('Leave Type List', $MODULE)}</span>
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {vtranslate('Select', $MODULE)}
                            </td>
                            <td>
                               {vtranslate('Allocation Title', $MODULE)} 
                            </td>
                            <td>
                               {vtranslate('Leave Type', $MODULE)} 
                            </td>
                            <td>
                                {vtranslate('Grade', $MODULE)}
                            </td>
                            <td>
                               {vtranslate('Status', $MODULE)} 
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
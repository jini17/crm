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
                    <div class="span8"><h3>{vtranslate('Leave Policy', $MODULE)}</h3></div>
                </div>
                <hr>
                <br>
            </div>

            <div class="contents tabbable clearfix">
              
                    <div class="pull-right"><a class="btn btn-success" href="index.php?module=Vtiger&parent=Settings&view=BalanceLeave&mode=ShowBalanceLeave">{vtranslate('Employee Leave Status', $MODULE)}</a></div>
              
                    <button class="btn btn-primary span10 marginLeftZero newButton" style="margin-right: 5px;" id="addItem">{vtranslate('Add', $MODULE)}</button>
             <button class="btn btn-primary span10 marginLeftZero newButton"style="margin-right: 5px;" id="editItem">{vtranslate('Edit', $MODULE)}</button>
             <button class="btn btn-danger span10 marginLeftZero"  id="deleteItem">{vtranslate('Delete', $MODULE)}</button>
             <div class='clearfix' style='height: 10px;'></div>
             <div class='clearfix'></div>
             <div class="contents container-fluid" style='background-color: #fff;'>                 
                 <div class="row th miniListContent">
                     <div class="col-md-12">
                         <h5 class="alignMiddle"><strong>{vtranslate('Leave Type List', $MODULE)}</strong></h5>
                     </div>
                 </div>
                     <div class='clearfix'></div>
                <div class='row th' style='padding-top: 5px; padding-bottom: 5px;'>
                    <div class='col-md-1'>   <strong>{vtranslate('Select', $MODULE)}</strong></div>
                    <div class='col-md-3'>  <strong> {vtranslate('Leave Policy Title', $MODULE)} </strong></div>
                    <div class='col-md-3'><strong>{vtranslate('Leave Type', $MODULE)}</strong> </div>
                    <div class='col-md-3'>   <strong>   {vtranslate('Grade', $MODULE)}</strong></div>
                    <div class='col-md-1'>   <strong> {vtranslate('Status', $MODULE)} </strong></div>                   
                </div>
                   <div class='clearfix'></div>
                   
                   {foreach item=SPLITVALUE from=$VALUES}
                      
                      
                                   <div class='row miniListContent'  style='padding-top: 5px; padding-bottom: 5px;'>                
                                       <div class='col-md-1'>  
                                                    <input type="checkbox" name="selected_id" value="{$SPLITVALUE['checkbox']}" class="smallchkd">
                                                </div>
                                       <div class='col-md-3'>  
                                                  {$SPLITVALUE['allocationtitle']}
                                       </div>
                                   <div class='col-md-3'>{$SPLITVALUE['allocationtitle']}</div>
                                   <div class='col-md-3'>  {$SPLITVALUE['leavetype']}</div>
                                   <div class='col-md-1'>      {$SPLITVALUE['status']}</div>      
                                   </div>
                                   
                    
                  
                   {/foreach}
             </div>

           {*     
                <div class="contents">
                    <table class="table table-bordered table-condensed themeTableColor">
                        <thead>
                        <th class="{$WIDTHTYPE}">
                          
                        </th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                {vtranslate('Select', $MODULE)}
                            </td>
                            <td>
                               {vtranslate('Leave Policy Title', $MODULE)} 
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
                </div>*}
            </div>
        </div>
    </div>
{/strip}
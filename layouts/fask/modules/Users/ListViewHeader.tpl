{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
        <div class="listViewPageDiv" id="listViewContent" style="padding-left: 0px; width: 100%">
            <!--id="listViewContent"-->
            <div class="col-sm-12 col-xs-12 full-height">
                 {if $EMP_VIEW eq 'grid'}
<<<<<<< HEAD
                 

=======
                   <div class="tabContainer"><ul class="nav nav-tabs tabs sortable container-fluid visible-lg">

                        <li class="active employeeTab" data-tabname="Employee Directory">
                            <a data-toggle="tab" href="#tab_2">
                                    <div><span class="name textOverflowEllipsis" value="Employee Directory" style="width:10%">
                                        <strong>Employee Directory</strong></span><span class="editTabName hide">
                                        <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                    </div>
                            </a>
                        </li>
                        <li class=" employeeTab" data-tabname="My Department">
                                <a data-toggle="tab" href="#tab_1">
                                    <div><span class="name textOverflowEllipsis" value="Tasks" style="width:10%">
                                        <strong>My Department</strong></span><span class="editTabName hide">
                                        <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                    </div></a>
                        </li>
                        <li class=" employeeTab" data-tabid="210" data-tabname="Where am i">
                            <a data-toggle="tab" href="#tab_210"><div><span class="name textOverflowEllipsis" value="Employees" style="width:10%">
                                <strong>{vtranslate('Where am i',$MODULE)}</strong>
                            </span><span class="editTabName hide"><input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                        </div></a></li>
                   </div>
>>>>>>> c10b058... New Layout Employee
                {else}
                    <div id="listview-actions" class="listview-actions-container">
                        <div class = "row">
                            <div class="btn-group col-md-3"></div>
                            <div class='col-lg-6 col-md-6 col-xs-12' style="padding-top: 5px">
                                <div class="btn-group userFilter" style="margin-left: 25%">
                                    <button class="btn btn-info" id="activeUsers" data-searchvalue="Active">
                                            {vtranslate('LBL_ACTIVE_USERS', $MODULE)}
                                    </button>
                                    <button class="btn btn-danger" id="inactiveUsers" data-searchvalue="Inactive">
                                            {vtranslate('LBL_INACTIVE_USERS', $MODULE)}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
                <div class="list-content">
{/strip}

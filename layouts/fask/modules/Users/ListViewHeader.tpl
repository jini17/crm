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
                 
                   <div class="tabContainer" id="tab">
                        <ul class="nav nav-tabs tabs sortable container-fluid visible-lg">

                            <li class="active employeeTab" data-tabname="Employee Directory">
                                <a data-toggle="tab" href="#employeedirectory">
                                        <div><span class="name textOverflowEllipsis" value="Employee Directory" style="width:10%">
                                            <strong>{vtranslate('Employee Directory',$MODULE)}</strong></span><span class="editTabName hide">
                                            <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                        </div>
                                </a>
                            </li>
                            <li class=" employeeTab" data-tabname="My Department">
                                    <a data-toggle="tab" href="#mydepartment">
                                        <div><span class="name textOverflowEllipsis" value="Tasks" style="width:10%">
                                            <strong>{vtranslate('My Department',$MODULE)}</strong></span><span class="editTabName hide">
                                            <input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                        </div></a>
                            </li>
                            <li class=" employeeTab" data-tabid="210" data-tabname="Where am i">
                                <a data-toggle="tab" href="#whereami">
                                    <div>
                                        <span class="name textOverflowEllipsis" value="Employees" style="width:10%">
                                            <strong>{vtranslate('Where am i',$MODULE)}</strong>
                                        </span>
                                        <span class="editTabName hide"><input name="tabName" type="text"></span><i class="fa fa-bars moveTab hide"></i>
                                    </div>
                                </a>
                           </li>
                   </div>
            <!--<div class="clearfix" style="height:20px;"></div>
            <div class="row">
                <div class="col-lg-6" style="float: left;">
                    <strong>
                        {vtranslate('YOU_ARE_CURRENLY_VIEWING',$MODULE)} "Soft Solvers Solutions"
                    </strong>
                </div>
            </div>        


            <div class="col-lg-6 pull-right">
                <div class="btn-group list-switcher" role="group" aria-label="Basic example">
                    <button type="button" onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('List','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn {$LIST} btn-white view" data-listType='List' title="List View"><i class='fa fa-list'></i> {vtranslate('List View', $MODULE)}</button>
                    
                    <button type="button"  onclick="javascript:Settings_Users_List_Js.UserListViewSwitcher('grid','{$TEXT_FILTER}','{$PAGE_URL}');" class="btn {$GRID} activeview" data-listType='Grid' title="Grid View"> <i class="fa fa-th-large"></i> {vtranslate('Grid View', $MODULE)}</button>
                </div>
   
                <form class='form-inline pull-right'>
                    <div class='form-group'>
                        <input type="text" placeholder="{vtranslate('Enter Keyword',$MODULE)}" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="button" class='btn btn-primary'> Search   </button>
                    </div>
                </form>
            </div>-->
         

            <!-- Alphabets -->
            <div class="col-lg-9">
               {include file="ListViewAlphabet.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
            </div>
               <div class="clearfix" style="height: 50px;"></div>
            <!--  Filter -->
          <!--  <div class="col-lg-3">

                <select class="select2 grid-filter form-control pull-right">
                    <option value=""> {vtranslate('Filter by',$MODULE)}</option>
                    <option value="N"> {vtranslate('New Joinees',$MODULE)}</option>
                    <option value="B"> {vtranslate('Bithdays',$MODULE)} </option>
                    <option value="G"> {vtranslate('Gender',$MODULE)} </option>
                </select>

            </div>-->
     
           <div class="list-content">
{/strip}

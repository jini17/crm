{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 02/04/2018
 ************************************************************************************}
{* modules/Settings/UserPlan/views/UserPlanAjax.php *}

{strip}

    <div class="taxModalContainer modal-dialog modal-xs" id="EditLeaveTypeContainer">
        <div class="modal-content">
            <form id="AddRule" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Leave Type Title :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="Adoption Leave" id="LeaveTypeTitle" name="LeaveTypeTitle" value="{$VALUES['leave_type_title']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Leave Type Code :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="L01" id="LeaveTypeCode" name="LeaveTypeCode" value="{$VALUES['leave_type_leavecode']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Status :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="status" name="status" >
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Description :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="textarea" id="LeaveType_Desc" name="LeaveType_Desc" value="{$VALUES['leave_type_descriptions']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Mid Year Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="LeaveType_MidYearAllocation" name="LeaveType_MidYearAllcoation">
                                    <option value="">Select One</option>
                                    <option value="Absolute">Full Allocation</option>
                                    <option value="Range">Prorate Allocation</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Halfday Allowed :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="LeaveType_HalfdayAllowed" name="LeaveType_HalfdayAllowed">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Carry Forward :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="LeaveType_CarryForward" name="LeaveType_CarryForward">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Leave Frequency :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="LeaveType_LeaveFrequency" name="LeaveType_LeaveFrequency">
                                    <option value="">Select One</option>
                                    <option value="Absolute">One Time</option>
                                    <option value="Range">Per Year</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <input type="hidden" id="LeaveTypeId" name="LeaveTypeId" value="{$VALUES['leave_type_id']}">
                </div>
                <div class="modal-footer ">
                    <center>
                        <button class="btn btn-success" type="button" id="saveButtonRule" name="saveButtonRule"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                        <a href="#" class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>

                    </center>
                </div>
            </form>
        </div>
    </div>
{/strip}




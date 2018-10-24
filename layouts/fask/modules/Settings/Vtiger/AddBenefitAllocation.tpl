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
    
    <div class="allocationModalContainer modal-dialog modal-lg" id="AddBenefitContainer">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:-5px;left:97%"><i class="fa fa-times" aria-hidden="true"></i><span class="close"></span><div></div></button>
                Add Benefit Allocation
        </div>
        <div class="modal-content">            
            <form id="AddBenefitAllocation" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Benefit Allocation Title :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="New Joiners" id="AllocationTitle" name="AllocationTitle">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Benefit Allocation Code :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="A01" id="AllocationCode" name="AllocationCode">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>IsActive :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="status" name="status">
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Description :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <textarea class="inputElement col-sm-9" style="width: 359px; height: 111px;" type="textarea" id="Allocation_Desc" name="Allocation_Desc"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Grade Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:359px;" id="Allocation_grade" name="Allocation_grade[]" multiple>
                                    <option value="">Select One</option>
                                    {foreach item=SPLITVALUE key=k from=$GRADE}
                                        <option value={$GRADE[$k]['id']}>{$GRADE[$k]['grade']}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div id="BenefitTypeAllocation">
                        <div class="container float-left">

                            <div class="contents row form-group">

                                <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn" type="button" id="AddBenefittype" name="AddBenefittype"><strong>{vtranslate('LBL_ADDBENEFITTYPE', $MODULE)}</strong></button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="dropdownValue" value='{$BENEFITTYPE}'>

                </div>
                <div class="modal-footer ">
                    <center>
                        <button class="btn btn-success" type="button" id="saveButtonBenefit" name="saveButtonBenefit"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                        <a href="#" class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>

                    </center>
                </div>
            </form>
        </div>
    </div>
    
{/strip}

